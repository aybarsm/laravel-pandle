<?php

declare(strict_types=1);

use Aybarsm\Laravel\Pandle\Contracts\HandlerContract;
use Aybarsm\Laravel\Pandle\Exceptions\PandleException;
use Aybarsm\Laravel\Pandle\Handler;
use Illuminate\Config\Repository;

it('pandle configuration requires email and password', function () {
    $app = app();

    $app->singleton(HandlerContract::class, Handler::class);

    // Test with empty email
    $app->bind('config', fn () => new Repository([
        'pandle' => [
            'email' => '',
            'password' => 'test-password',
        ],
    ]));

    expect(fn () => $app->get(HandlerContract::class))
        ->toThrow(PandleException::class, 'E-mail or password cannot be empty.');

    // Test with empty password
    $app->bind('config', fn () => new Repository([
        'pandle' => [
            'email' => 'test@example.com',
            'password' => '',
        ],
    ]));

    expect(fn () => $app->get(HandlerContract::class))
        ->toThrow(PandleException::class, 'E-mail or password cannot be empty.');

    // Test with both empty
    $app->bind('config', fn () => new Repository([
        'pandle' => [
            'email' => '',
            'password' => '',
        ],
    ]));

    expect(fn () => $app->get(HandlerContract::class))
        ->toThrow(PandleException::class, 'E-mail or password cannot be empty.');

    // Test with valid credentials
    $app->bind('config', fn () => new Repository([
        'pandle' => [
            'email' => 'test@example.com',
            'password' => 'test-password',
        ],
    ]));

    expect(fn () => $app->get(HandlerContract::class))->not->toThrow(PandleException::class);
});
