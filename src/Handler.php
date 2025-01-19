<?php

declare(strict_types=1);

namespace Aybarsm\Laravel\Pandle;

use Aybarsm\Laravel\Pandle\Contracts\AccessTokenContract;
use Aybarsm\Laravel\Pandle\Contracts\ClientContract;
use Aybarsm\Laravel\Pandle\Enums\RequestReturn;
use GuzzleHttp\Promise\PromiseInterface as HttpPromiseInterface;
use Illuminate\Container\Attributes\Config;
use Illuminate\Contracts\Cache\Repository as CacheRepositoryContract;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response as HttpResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Fluent;
use Illuminate\Support\Str;

final class Handler implements Contracts\HandlerContract
{
    protected PendingRequest $request;

    protected ?AccessTokenContract $accessToken = null;

    protected array $publicPaths = [
        'POST' => ['auth', 'auth/sign_in'],
    ];

    protected static string $resourcePattern = '/([a-z_]+)(?:\/(\d+))?/';

    public function __construct(
        #[Config('pandle.email')] private ?string $email,
        #[Config('pandle.password')] private ?string $password,
        #[Config('pandle.baseUrl', 'https://my.pandle.com/api/v1')] protected string $baseUrl,
        #[Config('pandle.cache.enabled', false)] protected bool $cacheEnabled,
        #[Config('pandle.cache.store', 'database')] protected string $cacheStore,
        #[Config('pandle.cache.key', 'pandle')] protected string $cacheKey,
    ) {
        throw_if(
            blank($this->email) || blank($this->password),
            Exceptions\PandleException::class,
            'E-mail or password cannot be empty.'
        );

        $this->baseUrl = Str::rtrim($this->baseUrl, '/');
        $this->request = (new PendingRequest)->asJson()->acceptJson()->baseUrl($this->baseUrl);
    }

    public function setBaseUrl(string $baseUrl): self
    {
        $this->baseUrl = $baseUrl;
        $this->request->baseUrl($baseUrl);

        return $this;
    }

    protected function getClient(): ClientContract
    {
        return App::get(ClientContract::class);
    }

    public function getRequest(): PendingRequest
    {
        return $this->request;
    }

    public function getAccessToken(): ?AccessTokenContract
    {
        return $this->accessToken;
    }

    public static function makeAccessToken(array $headers): AccessTokenContract
    {
        return App::make(AccessTokenContract::class, ['headers' => $headers]);
    }

    protected function getCacheStore(): CacheRepositoryContract
    {
        return Cache::store($this->cacheStore);
    }

    public function getCache(): Fluent
    {
        if ($this->getCacheStore()->has($this->cacheKey)) {
            $cache = Crypt::decrypt($this->getCacheStore()->get($this->cacheKey));
        } else {
            $cache = [];
        }

        return fluent($cache);
    }

    public function putCache(Fluent|array $cache): bool
    {
        if (! $this->cacheEnabled) {
            return false;
        }

        $cache = $cache instanceof Fluent ? $cache->toArray() : $cache;

        return $this->getCacheStore()->forever(
            $this->cacheKey,
            Crypt::encrypt($cache)
        );
    }

    public function forgetCache(): bool
    {
        return $this->getCacheStore()->forget($this->cacheKey);
    }

    public function hasCache(): bool
    {
        return $this->cacheEnabled && $this->getCacheStore()->has($this->cacheKey);
    }

    public function signIn($force = false): void
    {
        if (! $force) {
            if (! blank($this->accessToken)) {
                return;
            }

            if ($this->hasCache()) {
                $this->accessToken = self::makeAccessToken($this->getCache()->toArray());

                return;
            }
        }

        $response = $this->httpRequest(
            method: 'POST',
            path: 'auth/sign_in',
            data: [
                'email' => $this->email,
                'password' => $this->password,
            ],
            returnType: RequestReturn::ResponseInstance
        );

        $this->accessToken = self::makeAccessToken($response->getHeaders());

        if ($this->cacheEnabled) {
            $this->putCache($this->accessToken->toArray());
        }
    }

    public function signOut(): void
    {
        $response = $this->httpRequest(
            method: 'POST',
            path: 'auth/sign_out',
            returnType: RequestReturn::ResponseInstance
        );

        $this->accessToken = null;

        if ($this->cacheEnabled) {
            $this->forgetCache();
        }
    }

    protected function prepareHttpRequest(string $method, string $path, array $query = [], array $data = [], array $options = []): PendingRequest
    {
        $request = $this->getRequest();

        $request
            ->when(! blank($query), fn ($req) => $req->withQueryParameters($query))
            ->when(! blank($options), fn ($req) => $req->withOptions($options))
            ->when(! blank($data), fn ($req) => $req->withOptions([$req->getBodyFormat() => $data]));

        if (in_array($path, ($this->publicPaths[$method] ?? []), true)) {
            return $request;
        }

        if (blank($this->accessToken)) {
            $this->signIn();
        }

        if ($this->accessToken->hasExpired()) {
            $this->signIn(force: true);
        }

        return $request->replaceHeaders($this->accessToken->asRequestHeaders());
    }

    public function httpRequest(
        string $method,
        string $path,
        array $query = [],
        array $data = [],
        array $options = [],
        RequestReturn $returnType = RequestReturn::RenderedResponse
    ): Fluent|HttpPromiseInterface|HttpResponse|PendingRequest {
        $path = Str::of($path)->trim('/ ')->trim()->lower()->value();
        $method = Str::upper($method);

        $request = $this->prepareHttpRequest($method, $path, $query, $data, $options)
            ->throw(function (HttpResponse $response) {
                $message = "[{$response->getReasonPhrase()}]";
                $errors = $response->json('errors', []);

                if (! blank($errors)) {
                    $message .= ' Errors: ';
                    $message .= Arr::join(Arr::map($errors, fn ($msg, $key) => ($key + 1).") {$msg}"), ' && ');
                }

                return throw new Exceptions\PandleException(
                    message: $message,
                    code: $response->getStatusCode()
                );
            });

        if ($returnType === RequestReturn::PendingRequest) {
            return $request;
        }

        $configuredOptions = $request->getOptions();
        $response = $request->send($method, $path, $configuredOptions);

        return $returnType === RequestReturn::ResponseInstance ? $response : $this->renderHttpResponse($path, $query, $response);
    }

    public static function resolveResource(string $path, array $query): array
    {
        preg_match_all(self::$resourcePattern, $path, $matches, PREG_SET_ORDER);
        $resource = [
            'raw' => $path,
            'path' => [],
        ];

        foreach ($matches as $match) {
            $resourceName = $match[1];
            $resource['path'][] = $resourceName;

            if (isset($match[2])) {
                $resourceId = (int) $match[2];
                $resource['id'][Str::singular($resourceName)] = $resourceId;
                $resource['id'][$resourceName] = $resourceId;
            }
        }

        $resource['path'] = implode('.', $resource['path']);

        if (! blank($query)) {
            $resource['raw'] .= '?'.http_build_query($query);
            foreach ($query as $key => $value) {
                $resource['filter'][$key] = $value;
            }
        }

        return $resource;
    }

    protected function renderHttpResponse(string $path, array $query, HttpPromiseInterface|HttpResponse $response): Fluent
    {
        $resource = self::resolveResource($path, $query);
        $data = $response->json('data');

        if (! blank($data)) {
            if (Arr::isList($data)) {
                $data = collect($data)->map(fn ($item) => fluent($item));
            }
        }

        return fluent(['resource' => $resource, 'data' => $data]);
    }
}
