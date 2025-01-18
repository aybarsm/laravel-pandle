<?php

declare(strict_types=1);

namespace Aybarsm\Laravel\Pandle;

use Aybarsm\Laravel\Pandle\Contracts\AccessTokenContract;
use Aybarsm\Laravel\Pandle\Contracts\ClientContract;
use Aybarsm\Laravel\Pandle\Contracts\CompanyContract;
use Aybarsm\Laravel\Pandle\Contracts\HandlerContract;
use Illuminate\Support\ServiceProvider;

final class PandleServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/pandle.php',
            'pandle'
        );

        $this->app->bindIf(AccessTokenContract::class, AccessToken::class);
        $this->app->singletonIf(HandlerContract::class, Handler::class);
        $this->app->bindIf(CompanyContract::class, Company::class);
        $this->app->singletonIf(ClientContract::class, Client::class);
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/pandle.php' => config_path('pandle.php'),
            ]);
        }
    }
}
