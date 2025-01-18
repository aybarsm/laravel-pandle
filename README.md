# Laravel Pandle

A highly customizable Laravel service provider package for the Pandle (pandle.com) bookkeeping platform API.

## Installation

You can install the package via composer:

```bash
composer require aybarsm/laravel-pandle
```

## Configuration

Publish the configuration file:

```bash
php artisan vendor:publish --provider="Aybarsm\Laravel\Pandle\PandleServiceProvider"
```

Add the following environment variables to your `.env` file:

```env
# Pandle E-Mail
PANDLE_EMAIL=your-pandle-email
# Pandle Password
PANDLE_PASSWORD=your-pandle-password
# Pandle Base URL (optional, defaults to https://my.pandle.com/api/v1)
PANDLE_BASE_URL=https://my.pandle.com/api/v1
# Pandle Default Company ID (optional, defaults to null)
# If set, the package will use this company ID for company-specific operations.
# However, $client->company(123456) will create a new company instance for the given ID (123456).
PANDLE_COMPANY_ID=your-company-id
# Cache is being used to store access tokens.
# Cache is always encrypted.
# Cache Enabled
PANDLE_CACHE_ENABLED=false
# Cache Store
PANDLE_CACHE_STORE=database
# Cache Key
PANDLE_CACHE_KEY=pandle
```

## Usage

### Basic Usage

```php
use Aybarsm\Laravel\Pandle\Contracts\ClientContract as PandleClient;

class YourController extends Controller
{
    public function __construct(protected PandleClient $pandle) {}
    
    public function index()
    {
        // Get authenticated user info
        $me = $this->pandle->me();
        
        // Get company instance
        $company = $this->pandle->company(123456);
        
        // Get bank accounts
        $bankAccounts = $company->getBankAccounts();
        
        // Get customers
        $customers = $company->getCustomers();
    }
}
```

## Architecture & Design

### Dependency Injection

This package implements a clean dependency injection pattern with no circular dependencies. All concrete implementations are referenced through their corresponding interfaces (abstracts):

```php
use Aybarsm\Laravel\Pandle\Contracts\ClientContract;
use Aybarsm\Laravel\Pandle\Contracts\HandlerContract;
use Aybarsm\Laravel\Pandle\Contracts\CompanyContract;
use Aybarsm\Laravel\Pandle\Contracts\AccessTokenContract;

// Example of clean DI in action
class Company implements CompanyContract
{
    public function __construct(
        protected ClientContract $client
    ) {}
}
```

This architectural decision provides several key benefits:

1. **Performance**: No circular dependencies means faster instantiation and reduced memory usage
2. **Testability**: Easy to mock dependencies for unit testing
3. **Maintainability**: Clear separation of concerns and dependencies
4. **Flexibility**: Simple to replace any component without affecting others
5. **Reliability**: Prevents complex dependency chains that can lead to runtime issues

## Customisation

The concretes in this package are not extensible. However, the package is designed to be highly customisable. All core components can be replaced with your own implementations by binding them before the PandleServiceProvider registers its defaults.


```php
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
```

### Available Contracts for Customisation
1. **AccessTokenContract**
   - Default Abstract: `Aybarsm\Laravel\Pandle\Contracts\AccessTokenContract::class`
   - Default Concrete: `Aybarsm\Laravel\Pandle\AccessToken::class`
   - Handles access token management

2. **HandlerContract**
   - Default Abstract: `Aybarsm\Laravel\Pandle\Contracts\HandlerContract::class`
   - Default Concrete: `Aybarsm\Laravel\Pandle\Handler::class`
   - Manages HTTP requests and response handling
   - Singleton by default for consistent request handling

3. **CompanyContract**
   - Default Abstract: `Aybarsm\Laravel\Pandle\Contracts\CompanyContract::class`
   - Default Concrete: `Aybarsm\Laravel\Pandle\Company::class`
   - Handles company-specific operations

4. **ClientContract**
   - Default Abstract: `Aybarsm\Laravel\Pandle\Contracts\ClientContract::class`
   - Default Concrete: `Aybarsm\Laravel\Pandle\Client::class`
   - Main client interface for API interactions
   - Singleton by default for connection pooling

### Example: Custom Handler Concrete Implementation

Here's an example of implementing a custom handler with logging capabilities:
You can customize the implementations in your `AppServiceProvider`'s register method:

```php
<?php

namespace App\Providers;

use Aybarsm\Laravel\Pandle\Contracts\HandlerContract;
use Your\Custom\PandleHandler;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(HandlerContract::class, function ($app){
            return new PandleHandler();
        });
    }
}
```

### Error Handling

The package throws `PandleException` for API-related errors. You can catch these exceptions to handle errors gracefully:

```php
use Aybarsm\Laravel\Pandle\Exceptions\PandleException;

try {
    $company->createCustomer($data);
} catch (PandleException $e) {
    // Handle the error
    $statusCode = $e->getCode();
    $message = $e->getMessage();
}
```

## Security

If you discover any security related issues, please email hello@aybarsm.com instead of using the issue tracker.

## Credits

- [Murat Aybars](https://github.com/aybarsm)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

