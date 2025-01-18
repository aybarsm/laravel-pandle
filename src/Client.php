<?php

declare(strict_types=1);

namespace Aybarsm\Laravel\Pandle;

use Aybarsm\Laravel\Pandle\Contracts\CompanyContract;
use Aybarsm\Laravel\Pandle\Contracts\HandlerContract;
use Illuminate\Container\Attributes\Config;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Fluent;

final class Client implements Contracts\ClientContract
{
    protected array $companies;

    public function __construct(
        #[Config('pandle.companyId')] protected ?int $companyId,
    ) {}

    public function handler(): HandlerContract
    {
        return App::get(HandlerContract::class);
    }

    public function me(): Fluent
    {
        return $this->handler()->httpRequest('GET', 'me');
    }

    public function company(?int $companyId = null): CompanyContract
    {
        $companyId = blank($companyId) ? $this->companyId : null;

        throw_if(
            blank($companyId),
            Exceptions\PandleException::class,
            'Company id or default company id is required.'
        );

        $companyKey = (string) $companyId;

        if (! isset($this->companies[$companyKey])) {
            $this->companies[$companyKey] = App::make(CompanyContract::class, ['companyId' => $companyId]);
        }

        return $this->companies[$companyKey];
    }

    public function createAuth(array $options = []): Fluent
    {
        return $this->handler()->httpRequest('POST', 'auth', [], [], $options);
    }

    public function getAuthConfirmation(array $options = []): Fluent
    {
        return $this->handler()->httpRequest('GET', 'auth/confirmation', [], [], $options);
    }

    public function createAuthConfirmation(array $data, array $options = []): Fluent
    {
        return $this->handler()->httpRequest('POST', 'auth/confirmation', [], $data, $options);
    }

    public function getAuthValidateToken(array $options = []): Fluent
    {
        return $this->handler()->httpRequest('GET', 'auth/validate_token', [], [], $options);
    }

    public function getCompanies(array $options = []): Fluent
    {
        return $this->handler()->httpRequest('GET', 'companies', [], [], $options);
    }

    public function getCompany(int $id, array $options = []): Fluent
    {
        return $this->handler()->httpRequest('GET', "companies/{$id}", [], [], $options);
    }

    public function getCompanyNew(array $options = []): Fluent
    {
        return $this->handler()->httpRequest('GET', 'companies/new', [], [], $options);
    }

    public function updateCompanySetupBasicDetail(array $query, array $data, array $options = []): Fluent
    {
        return $this->handler()->httpRequest('PATCH', 'companies/setup/basic_details', $query, $data, $options);
    }

    public function updateCompanySetupCompanyInfo(array $query, array $data, array $options = []): Fluent
    {
        return $this->handler()->httpRequest('PATCH', 'companies/setup/company_info', $query, $data, $options);
    }

    public function updateCompanySetupCompanyAddress(array $query, array $data, array $options = []): Fluent
    {
        return $this->handler()->httpRequest('PATCH', 'companies/setup/company_address', $query, $data, $options);
    }

    public function updateCompanySetupFinancialInfo(array $query, array $data, array $options = []): Fluent
    {
        return $this->handler()->httpRequest('PATCH', 'companies/setup/financial_info', $query, $data, $options);
    }

    public function updateCompanySetupBankAccount(array $query, array $data, array $options = []): Fluent
    {
        return $this->handler()->httpRequest('PATCH', 'companies/setup/bank_accounts', $query, $data, $options);
    }

    public function getCompaniesHouseCompany(array $query, array $options = []): Fluent
    {
        return $this->handler()->httpRequest('GET', 'companies_house/company', $query, [], $options);
    }

    public function getCompaniesHouseSearchCompanies(array $query, array $options = []): Fluent
    {
        return $this->handler()->httpRequest('GET', 'companies_house/search/companies', $query, [], $options);
    }

    public function getCounties(array $options = []): Fluent
    {
        return $this->handler()->httpRequest('GET', 'counties', [], [], $options);
    }

    public function getCountries(array $query, array $options = []): Fluent
    {
        return $this->handler()->httpRequest('GET', 'countries', $query, [], $options);
    }

    public function getFinancialCurrencies(array $options = []): Fluent
    {
        return $this->handler()->httpRequest('GET', 'financial/currencies', [], [], $options);
    }

    public function getLocationIqAutocomplete(array $data, array $options = []): Fluent
    {
        return $this->handler()->httpRequest('GET', 'location_iq/autocomplete', [], $data, $options);
    }

    public function getLocationIqReverse(array $data, array $options = []): Fluent
    {
        return $this->handler()->httpRequest('GET', 'location_iq/reverse', [], $data, $options);
    }

    public function getLocationIqRouting(array $data, array $options = []): Fluent
    {
        return $this->handler()->httpRequest('GET', 'location_iq/routing', [], $data, $options);
    }

    public function getLocationIqSearch(array $data, array $options = []): Fluent
    {
        return $this->handler()->httpRequest('GET', 'location_iq/search', [], $data, $options);
    }

    public function getMe(array $options = []): Fluent
    {
        return $this->handler()->httpRequest('GET', 'me', [], [], $options);
    }
}
