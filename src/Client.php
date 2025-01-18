<?php

declare(strict_types=1);

namespace Aybarsm\Laravel\Pandle;
use Aybarsm\Laravel\Pandle\Contracts\HandlerContract;
use Illuminate\Container\Attributes\Config;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\App;

final class Client implements Contracts\ClientContract
{
    public function handler(): HandlerContract
    {
        return App::get(HandlerContract::class);
    }
}
