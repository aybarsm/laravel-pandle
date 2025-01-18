<?php

declare(strict_types=1);

namespace Aybarsm\Laravel\Pandle;

use Carbon\CarbonInterface;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Traits\Macroable;

final class AccessToken implements Contracts\AccessTokenContract
{
    use Macroable;
    protected string $accessToken;
    protected string $client;
    protected string $uid;
    protected float|int|string $expiry;
    protected static array $tokenHeaderAttributes = ['access-token', 'client', 'expiry', 'uid'];
    protected CarbonInterface $expires;

    public function __construct(array $headers)
    {
        throw_if(
            !Arr::has($headers, self::getTokenHeaderAttributes()),
            Exceptions\PandleException::class,
            '`' . Arr::join(self::getTokenHeaderAttributes(), '`, `', '`, and `') . '` headers should present to create access token instance.'
        );

        $headers = Arr::only($headers, self::getTokenHeaderAttributes());
        $headers = Arr::map($headers, fn ($item) => is_array($item) && Arr::isList($item) ? Arr::first($item) : $item);

        $this->accessToken = $headers['access-token'];
        $this->client = $headers['client'];
        $this->uid = $headers['uid'];
        $this->expiry = $headers['expiry'];
        $this->expires = Carbon::createFromTimestampUTC($this->expiry);
    }

    public function getAccessToken(): string
    {
        return $this->accessToken;
    }

    public function getClient(): string
    {
        return $this->client;
    }

    public function getUid(): string
    {
        return $this->uid;
    }

    public function getExpiry(): null|int|string
    {
        return $this->expiry;
    }

    public function getExpires(): CarbonInterface
    {
        return $this->expires;
    }

    public function asRequestHeaders(): array
    {
        return [
            'access-token' => $this->accessToken,
            'client' => $this->client,
            'uid' => $this->uid,
        ];
    }

    public function toArray(): array
    {
        return [
            'access-token' => $this->accessToken,
            'client' => $this->client,
            'uid' => $this->uid,
            'expiry' => $this->expiry,
        ];
    }

    public static function getTokenHeaderAttributes(): array
    {
        return self::$tokenHeaderAttributes;
    }

    public function hasExpired(): bool
    {
        return $this->getExpires()->isPast();
    }
}
