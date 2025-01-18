<?php

declare(strict_types=1);

namespace Aybarsm\Laravel\Pandle;

use Aybarsm\Laravel\Pandle\Contracts\ClientContract;
use GuzzleHttp\Promise\PromiseInterface as HttpPromiseInterface;
use Illuminate\Container\Attributes\Config;
use Illuminate\Contracts\Cache\Repository as CacheRepositoryContract;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response as HttpResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Fluent;
use Illuminate\Support\Str;
use Psr\Http\Message\ResponseInterface;

final class Handler implements Contracts\HandlerContract
{
    protected PendingRequest $request;
    protected array $noAuthUris = [
        'POST' => ['auth', 'auth/sign_in'],
    ];

    public static array $tokenAttributes = ['access-token', 'client', 'expiry', 'uid'];

    public function __construct(
        #[Config('pandle.email')] private ?string $email,
        #[Config('pandle.password')] private ?string $password,
        #[Config('pandle.baseUrl', 'https://my.pandle.com/api/v1')] protected string $baseUrl,
        #[Config('pandle.cache.enabled', false)] protected bool $cacheEnabled,
        #[Config('pandle.cache.store', 'database')] protected string $cacheStore,
        #[Config('pandle.cache.key', 'pandle')] protected string $cacheKey,
    ){
        throw_if(
            blank($this->email) || blank($this->password),
            Exceptions\PandleException::class,
            'E-mail or password cannot be empty.'
        );

        $this->baseUrl = Str::rtrim($this->baseUrl, '/');
        $this->request = (new PendingRequest())->acceptJson()->baseUrl($this->baseUrl);
    }
    protected function getClient(): ClientContract
    {
        return App::get(ClientContract::class);
    }

    public function getRequest(): PendingRequest
    {
        return $this->request;
    }

    protected function getCacheStore(): CacheRepositoryContract
    {
        return Cache::store($this->cacheStore);
    }

    public function getCache(): Fluent
    {
        if ($this->getCacheStore()->has($this->cacheKey)){
            $cache = Crypt::decrypt($this->getCacheStore()->get($this->cacheKey));
        }else {
            $cache = [];
        }
        return fluent($cache);
    }

    protected function putCache(Fluent|array $cache): bool
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

    public function signIn(): array
    {
        $response = $this->httpRequest(
            method: 'POST',
            url: 'auth/sign_in',
            data: [
                'email' => $this->email,
                'password' => $this->password,
            ],
            returnResponse: true
        );

        $token = Arr::only($response->getHeaders(), self::$tokenAttributes);

        if ($this->cacheEnabled) {
            $this->putCache($token);
        }

        return $token;
    }

    public function signOut(): bool
    {
        $response = $this->httpRequest(
            method: 'POST',
            url: 'auth/sign_out',
            returnResponse: true
        );

        if ($response->getStatusCode() !== 200) {
            return false;
        }

        if ($this->cacheEnabled) {
            $this->forgetCache();
        }

        return true;
    }

    protected function getToken(): array
    {
        if ($this->cacheEnabled && $this->getCache()->has(self::$tokenAttributes)) {
            $cache = $this->getCache();
            if ($cache->has('expiry') && Carbon::parse($cache->get('expiry'))->isPast()) {

            }
            return $this->getCache()->toArray();
        }
    }

    protected function prepareHttpRequest(string $method, string $uri, array $query = [], array $data = [], array $options = []): PendingRequest
    {
        $request = $this->getRequest();

        $request->withQueryParameters($query)
            ->withOptions($options)
            ->withOptions(['json' => $data]);

        if (in_array($uri, ($this->noAuthUris[$method] ?? []), true)) {
            return $request;
        }

        return $request;
    }

    public function httpRequest(string $method, string $url, array $query = [], array $data = [], array $options = [], bool $returnResponse = false): Fluent|HttpPromiseInterface|HttpResponse
    {
        $url = Str::of($url)->trim('/ ')->trim()->lower()->value();
        $method = Str::upper($method);

        $request = $this->prepareHttpRequest($method, $url, $query, $data, $options);
        $response = $request
            ->throw(function (HttpResponse $response){
                $message = "[{$response->getReasonPhrase()}]";
                $errors = $response->json('errors', []);

                if (!blank($errors)) {
                    $message .= ' Errors: ';
                    $message .= Arr::join(Arr::map($errors, fn ($msg, $key) => ($key + 1) . ") {$msg}"), ' && ');
                }

                return throw new Exceptions\PandleException(
                    message: $message,
                    code: $response->getStatusCode()
                );
            })
            ->send($method, $url);

        return $returnResponse ? $response : $this->renderHttpResponse($response);
    }

    protected function renderHttpResponse(HttpPromiseInterface|HttpResponse $response): Fluent
    {
        return fluent($response->json());
    }
}
