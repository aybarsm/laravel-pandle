<?php

declare(strict_types=1);

namespace Aybarsm\Laravel\Pandle;

use Aybarsm\Laravel\Pandle\Contracts\ClientContract;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Fluent;

class Company implements Contracts\CompanyContract
{
    public function __construct(
        protected int $companyId
    )
    {
    }

    protected function getClientInstance(): ClientContract
    {
        return App::get(ClientContract::class);
    }

    public function getBankAccounts(array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('GET', "companies/{$this->companyId}/bank_accounts", [], [], $options);
    }
    public function createBankAccount(array $data, array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('POST', "companies/{$this->companyId}/bank_accounts", [], $data, $options);
    }
    public function getBankAccount(int $id, array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('GET', "companies/{$this->companyId}/bank_accounts/{$id}", [], [], $options);
    }
    public function updateBankAccount(int $id, array $data, array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('PATCH', "companies/{$this->companyId}/bank_accounts/{$id}", [], $data, $options);
    }
    public function deleteBankAccount(int $id, array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('DELETE', "companies/{$this->companyId}/bank_accounts/{$id}", [], [], $options);
    }
    public function getBankAccountAccount(int $bankAccountId, array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('GET', "companies/{$this->companyId}/bank_accounts/{$bankAccountId}/account", [], [], $options);
    }
    public function getBankRules(array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('GET', "companies/{$this->companyId}/bank_rules", [], [], $options);
    }
    public function createBankRule(array $data, array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('POST', "companies/{$this->companyId}/bank_rules", [], $data, $options);
    }
    public function getBankRule(int $id, array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('GET', "companies/{$this->companyId}/bank_rules/{$id}", [], [], $options);
    }
    public function updateBankRule(int $id, array $data, array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('PATCH', "companies/{$this->companyId}/bank_rules/{$id}", [], $data, $options);
    }
    public function deleteBankRule(int $id, array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('DELETE', "companies/{$this->companyId}/bank_rules/{$id}", [], [], $options);
    }
    public function getBankRuleConditionOptions(array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('GET', "companies/{$this->companyId}/bank_rules/condition_options", [], [], $options);
    }
    public function getBankRuleCategories(array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('GET', "companies/{$this->companyId}/bank_rule_categories", [], [], $options);
    }
    public function getBankAccountBankTransactions(int $bankAccountId, array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('GET', "companies/{$this->companyId}/bank_accounts/{$bankAccountId}/bank_transactions", [], [], $options);
    }
    public function createBankAccountBankTransaction(int $bankAccountId, array $data, array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('POST', "companies/{$this->companyId}/bank_accounts/{$bankAccountId}/bank_transactions", [], $data, $options);
    }
    public function getBankAccountBankTransaction(int $bankAccountId, int $id, array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('GET', "companies/{$this->companyId}/bank_accounts/{$bankAccountId}/bank_transactions/{$id}", [], [], $options);
    }
    public function updateBankAccountBankTransaction(int $bankAccountId, int $id, array $data, array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('PATCH', "companies/{$this->companyId}/bank_accounts/{$bankAccountId}/bank_transactions/{$id}", [], $data, $options);
    }
    public function deleteBankAccountBankTransaction(int $bankAccountId, int $id, array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('DELETE', "companies/{$this->companyId}/bank_accounts/{$bankAccountId}/bank_transactions/{$id}", [], [], $options);
    }
    public function createBankAccountBankTransactionAttachment(int $bankAccountId, int $bankTransactionId, array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('POST', "companies/{$this->companyId}/bank_accounts/{$bankAccountId}/bank_transactions/{$bankTransactionId}/attachments", [], [], $options);
    }
    public function deleteBankAccountBankTransactionAttachmentBatchDetach(int $bankAccountId, int $bankTransactionId, array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('DELETE', "companies/{$this->companyId}/bank_accounts/{$bankAccountId}/bank_transactions/{$bankTransactionId}/attachments/batch_detach", [], [], $options);
    }
    public function getBankAccountBankTransactionUploads(int $bankAccountId, int $bankTransactionId, array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('GET', "companies/{$this->companyId}/bank_accounts/{$bankAccountId}/bank_transactions/{$bankTransactionId}/uploads", [], [], $options);
    }
    public function createBankAccountBankTransactionUpload(int $bankAccountId, int $bankTransactionId, array $data, array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('POST', "companies/{$this->companyId}/bank_accounts/{$bankAccountId}/bank_transactions/{$bankTransactionId}/uploads", [], $data, $options);
    }
    public function deleteBankAccountBankTransactionUpload(int $bankAccountId, int $bankTransactionId, int $id, array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('DELETE', "companies/{$this->companyId}/bank_accounts/{$bankAccountId}/bank_transactions/{$bankTransactionId}/uploads/{$id}", [], [], $options);
    }
    public function getBankTransactionCategories(array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('GET', "companies/{$this->companyId}/bank_transaction_categories", [], [], $options);
    }
    public function getBankAccountBankTransactionCategories(int $bankAccountId, array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('GET', "companies/{$this->companyId}/bank_accounts/{$bankAccountId}/bank_transaction_categories", [], [], $options);
    }
    public function getBankTransactionTaxcode(array $query, array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('GET', "companies/{$this->companyId}/bank_transaction_taxcodes", $query, [], $options);
    }
    public function createBankAccountBankFeedImport(int $bankAccountId, array $data, array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('POST', "companies/{$this->companyId}/bank_accounts/{$bankAccountId}/bank_feed_imports", [], $data, $options);
    }
    public function getBankAccountBankFeedImport(int $bankAccountId, int $id, array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('GET', "companies/{$this->companyId}/bank_accounts/{$bankAccountId}/bank_feed_imports/{$id}", [], [], $options);
    }
    public function createBatchUploadDeletion(array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('POST', "companies/{$this->companyId}/batch_upload_deletions", [], [], $options);
    }
    public function createBankAccountImportedBankTransactionConfirmation(int $bankAccountId, int $importedBankTransactionId, array $data, array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('POST', "companies/{$this->companyId}/bank_accounts/{$bankAccountId}/imported_bank_transactions/{$importedBankTransactionId}/confirmation", [], $data, $options);
    }
    public function getBankAccountConfirmedImportedBankTransactions(int $bankAccountId, array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('GET', "companies/{$this->companyId}/bank_accounts/{$bankAccountId}/confirmed_imported_bank_transactions", [], [], $options);
    }
    public function getFinancialCurrencyConversionRates(int $currencyId, array $query, array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('GET', "companies/{$this->companyId}/financial/currencies/{$currencyId}/conversion_rates", $query, [], $options);
    }
    public function getCustomers(array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('GET', "companies/{$this->companyId}/customers", [], [], $options);
    }
    public function createCustomer(array $data, array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('POST', "companies/{$this->companyId}/customers", [], $data, $options);
    }
    public function getCustomer(int $id, array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('GET', "companies/{$this->companyId}/customers/{$id}", [], [], $options);
    }
    public function updateCustomer(int $id, array $data, array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('PATCH', "companies/{$this->companyId}/customers/{$id}", [], $data, $options);
    }
    public function deleteCustomer(int $id, array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('DELETE', "companies/{$this->companyId}/customers/{$id}", [], [], $options);
    }
    public function getCustomerGroups(array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('GET', "companies/{$this->companyId}/customer_groups", [], [], $options);
    }
    public function getCustomerAccount(int $customerId, array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('GET', "companies/{$this->companyId}/customers/{$customerId}/account", [], [], $options);
    }
    public function getDashboardBankAccountChart(array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('GET', "companies/{$this->companyId}/dashboard/bank_account_chart", [], [], $options);
    }
    public function getDashboardCashFlowChart(array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('GET', "companies/{$this->companyId}/dashboard/cash_flow_chart", [], [], $options);
    }
    public function getDashboardExpenseChart(array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('GET', "companies/{$this->companyId}/dashboard/expense_chart", [], [], $options);
    }
    public function getDashboardProfitAndLossChart(array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('GET', "companies/{$this->companyId}/dashboard/profit_and_loss_chart", [], [], $options);
    }
    public function getDashboardSalesChart(array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('GET', "companies/{$this->companyId}/dashboard/sales_chart", [], [], $options);
    }
    public function getDashboardTaxAndDividend(array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('GET', "companies/{$this->companyId}/dashboard/tax_and_dividend", [], [], $options);
    }
    public function getDocumentSettings(array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('GET', "companies/{$this->companyId}/document_settings", [], [], $options);
    }
    public function getEcSalesLists(array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('GET', "companies/{$this->companyId}/ec_sales_lists", [], [], $options);
    }
    public function getEcSalesList(int $id, array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('GET', "companies/{$this->companyId}/ec_sales_lists/{$id}", [], [], $options);
    }
    public function getEcSalesListHmrcSubmissions(array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('GET', "companies/{$this->companyId}/ec_sales_list_hmrc_submissions", [], [], $options);
    }
    public function getEcSalesListHmrcSubmission(int $id, array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('GET', "companies/{$this->companyId}/ec_sales_list_hmrc_submissions/{$id}", [], [], $options);
    }
    public function getEcSalesListHmrcSubmissionLines(int $ecSalesListHmrcSubmissionId, array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('GET', "companies/{$this->companyId}/ec_sales_list_hmrc_submissions/{$ecSalesListHmrcSubmissionId}/lines", [], [], $options);
    }
    public function getEcSalesListHmrcSubmissionLine(int $ecSalesListHmrcSubmissionId, int $id, array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('GET', "companies/{$this->companyId}/ec_sales_list_hmrc_submissions/{$ecSalesListHmrcSubmissionId}/lines/{$id}", [], [], $options);
    }
    public function getEcSalesListLines(int $ecSalesListId, array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('GET', "companies/{$this->companyId}/ec_sales_lists/{$ecSalesListId}/lines", [], [], $options);
    }
    public function getEcSalesListLine(int $ecSalesListId, int $id, array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('GET', "companies/{$this->companyId}/ec_sales_lists/{$ecSalesListId}/lines/{$id}", [], [], $options);
    }
    public function getFinancialYear(array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('GET', "companies/{$this->companyId}/financial_year", [], [], $options);
    }
    public function updateFinancialYear(int $id, array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('PATCH', "companies/{$this->companyId}/financial_year/{$id}", [], [], $options);
    }
    public function getBankAccountImportedBankTransactions(int $bankAccountId, array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('GET', "companies/{$this->companyId}/bank_accounts/{$bankAccountId}/imported_bank_transactions", [], [], $options);
    }
    public function getBankAccountImportedBankTransaction(int $bankAccountId, int $id, array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('GET', "companies/{$this->companyId}/bank_accounts/{$bankAccountId}/imported_bank_transactions/{$id}", [], [], $options);
    }
    public function updateBankAccountImportedBankTransaction(int $bankAccountId, int $id, array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('PATCH', "companies/{$this->companyId}/bank_accounts/{$bankAccountId}/imported_bank_transactions/{$id}", [], [], $options);
    }
    public function getBankAccountIgnoredImportedBankTransactions(int $bankAccountId, array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('GET', "companies/{$this->companyId}/bank_accounts/{$bankAccountId}/ignored_imported_bank_transactions", [], [], $options);
    }
    public function getInvoices(array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('GET', "companies/{$this->companyId}/invoices", [], [], $options);
    }
    public function createInvoice(array $data, array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('POST', "companies/{$this->companyId}/invoices", [], $data, $options);
    }
    public function getInvoice(int $id, array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('GET', "companies/{$this->companyId}/invoices/{$id}", [], [], $options);
    }
    public function updateInvoice(int $id, array $data, array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('PATCH', "companies/{$this->companyId}/invoices/{$id}", [], $data, $options);
    }
    public function getCustomerInvoices(int $customerId, array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('GET', "companies/{$this->companyId}/customers/{$customerId}/invoices", [], [], $options);
    }
    public function getSupplierInvoices(int $supplierId, array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('GET', "companies/{$this->companyId}/suppliers/{$supplierId}/invoices", [], [], $options);
    }
    public function getCustomerOutstandingInvoices(int $customerId, array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('GET', "companies/{$this->companyId}/customers/{$customerId}/outstanding_invoices", [], [], $options);
    }
    public function getSupplierOutstandingInvoices(int $supplierId, array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('GET', "companies/{$this->companyId}/suppliers/{$supplierId}/outstanding_invoices", [], [], $options);
    }
    public function createInvoiceEmail(int $invoiceId, array $data, array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('POST', "companies/{$this->companyId}/invoices/{$invoiceId}/emails", [], $data, $options);
    }
    public function createInvoiceAttachment(int $invoiceId, array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('POST', "companies/{$this->companyId}/invoices/{$invoiceId}/attachments", [], [], $options);
    }
    public function deleteInvoiceAttachmentBatchDetach(int $invoiceId, array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('DELETE', "companies/{$this->companyId}/invoices/{$invoiceId}/attachments/batch_detach", [], [], $options);
    }
    public function getInvoiceUploads(int $invoiceId, array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('GET', "companies/{$this->companyId}/invoices/{$invoiceId}/uploads", [], [], $options);
    }
    public function createInvoiceUpload(int $invoiceId, array $data, array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('POST', "companies/{$this->companyId}/invoices/{$invoiceId}/uploads", [], $data, $options);
    }
    public function deleteInvoiceUpload(int $invoiceId, int $id, array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('DELETE', "companies/{$this->companyId}/invoices/{$invoiceId}/uploads/{$id}", [], [], $options);
    }
    public function getInvoiceAuditTrails(int $invoiceId, array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('GET', "companies/{$this->companyId}/invoices/{$invoiceId}/audit_trails", [], [], $options);
    }
    public function getInvoicePdf(int $invoiceId, array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('GET', "companies/{$this->companyId}/invoices/{$invoiceId}/pdf", [], [], $options);
    }
    public function getMileageJourneys(array $query, array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('GET', "companies/{$this->companyId}/mileage/journeys", $query, [], $options);
    }
    public function createMileageJourney(array $data, array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('POST', "companies/{$this->companyId}/mileage/journeys", [], $data, $options);
    }
    public function updateMileageJourney(int $id, array $data, array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('PATCH', "companies/{$this->companyId}/mileage/journeys/{$id}", [], $data, $options);
    }
    public function deleteMileageJourney(int $id, array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('DELETE', "companies/{$this->companyId}/mileage/journeys/{$id}", [], [], $options);
    }
    public function getMileageLocations(array $query, array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('GET', "companies/{$this->companyId}/mileage/locations", $query, [], $options);
    }
    public function createMileageLocation(array $data, array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('POST', "companies/{$this->companyId}/mileage/locations", [], $data, $options);
    }
    public function getMileagePaymentAccounts(array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('GET', "companies/{$this->companyId}/mileage/payment_accounts", [], [], $options);
    }
    public function getMileageTrips(array $query, array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('GET', "companies/{$this->companyId}/mileage/trips", $query, [], $options);
    }
    public function createMileageTrip(array $data, array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('POST', "companies/{$this->companyId}/mileage/trips", [], $data, $options);
    }
    public function getMileageTrip(int $id, array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('GET', "companies/{$this->companyId}/mileage/trips/{$id}", [], [], $options);
    }
    public function updateMileageTrip(int $id, array $data, array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('PATCH', "companies/{$this->companyId}/mileage/trips/{$id}", [], $data, $options);
    }
    public function deleteMileageTrip(int $id, array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('DELETE', "companies/{$this->companyId}/mileage/trips/{$id}", [], [], $options);
    }
    public function createMileageTripAttachment(int $tripId, array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('POST', "companies/{$this->companyId}/mileage/trips/{$tripId}/attachments", [], [], $options);
    }
    public function deleteMileageTripAttachmentBatchDetach(int $tripId, array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('DELETE', "companies/{$this->companyId}/mileage/trips/{$tripId}/attachments/batch_detach", [], [], $options);
    }
    public function getMileageTripUploads(int $tripId, array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('GET', "companies/{$this->companyId}/mileage/trips/{$tripId}/uploads", [], [], $options);
    }
    public function createMileageTripUpload(int $tripId, array $data, array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('POST', "companies/{$this->companyId}/mileage/trips/{$tripId}/uploads", [], $data, $options);
    }
    public function deleteMileageTripUpload(int $tripId, int $id, array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('DELETE', "companies/{$this->companyId}/mileage/trips/{$tripId}/uploads/{$id}", [], [], $options);
    }
    public function getMileageVehicles(array $query, array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('GET', "companies/{$this->companyId}/mileage/vehicles", $query, [], $options);
    }
    public function createMileageVehicle(array $data, array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('POST', "companies/{$this->companyId}/mileage/vehicles", [], $data, $options);
    }
    public function updateMileageVehicle(int $id, array $data, array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('PATCH', "companies/{$this->companyId}/mileage/vehicles/{$id}", [], $data, $options);
    }
    public function deleteMileageVehicle(int $id, array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('DELETE', "companies/{$this->companyId}/mileage/vehicles/{$id}", [], [], $options);
    }
    public function getMileageVehicleTypes(array $query, array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('GET', "companies/{$this->companyId}/mileage/vehicle_types", $query, [], $options);
    }
    public function createMileageVehicleType(array $data, array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('POST', "companies/{$this->companyId}/mileage/vehicle_types", [], $data, $options);
    }
    public function updateMileageVehicleType(int $id, array $data, array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('PATCH', "companies/{$this->companyId}/mileage/vehicle_types/{$id}", [], $data, $options);
    }
    public function deleteMileageVehicleType(int $id, array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('DELETE', "companies/{$this->companyId}/mileage/vehicle_types/{$id}", [], [], $options);
    }
    public function getNominalAccounts(array $query, array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('GET', "companies/{$this->companyId}/nominal_accounts", $query, [], $options);
    }
    public function createBankAccountPaypalFeedImport(int $bankAccountId, array $data, array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('POST', "companies/{$this->companyId}/bank_accounts/{$bankAccountId}/paypal_feed_imports", [], $data, $options);
    }
    public function getBankAccountPaypalFeedImport(int $bankAccountId, int $id, array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('GET', "companies/{$this->companyId}/bank_accounts/{$bankAccountId}/paypal_feed_imports/{$id}", [], [], $options);
    }
    public function getProjects(array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('GET', "companies/{$this->companyId}/projects", [], [], $options);
    }
    public function createProject(array $data, array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('POST', "companies/{$this->companyId}/projects", [], $data, $options);
    }
    public function getProject(int $id, array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('GET', "companies/{$this->companyId}/projects/{$id}", [], [], $options);
    }
    public function updateProject(int $id, array $data, array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('PATCH', "companies/{$this->companyId}/projects/{$id}", [], $data, $options);
    }
    public function deleteProject(int $id, array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('DELETE', "companies/{$this->companyId}/projects/{$id}", [], [], $options);
    }
    public function getProjectExpenseTransactions(int $id, array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('GET', "companies/{$this->companyId}/projects/{$id}/expense_transactions", [], [], $options);
    }
    public function getProjectIncomeTransactions(int $id, array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('GET', "companies/{$this->companyId}/projects/{$id}/income_transactions", [], [], $options);
    }
    public function createProjectAttachment(int $projectId, array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('POST', "companies/{$this->companyId}/projects/{$projectId}/attachments", [], [], $options);
    }
    public function deleteProjectAttachmentBatchDetach(int $projectId, array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('DELETE', "companies/{$this->companyId}/projects/{$projectId}/attachments/batch_detach", [], [], $options);
    }
    public function getProjectUploads(int $projectId, array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('GET', "companies/{$this->companyId}/projects/{$projectId}/uploads", [], [], $options);
    }
    public function createProjectUpload(int $projectId, array $data, array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('POST', "companies/{$this->companyId}/projects/{$projectId}/uploads", [], $data, $options);
    }
    public function deleteProjectUpload(int $projectId, int $id, array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('DELETE', "companies/{$this->companyId}/projects/{$projectId}/uploads/{$id}", [], [], $options);
    }
    public function getQuotes(array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('GET', "companies/{$this->companyId}/quotes", [], [], $options);
    }
    public function createQuote(array $data, array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('POST', "companies/{$this->companyId}/quotes", [], $data, $options);
    }
    public function getQuote(int $id, array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('GET', "companies/{$this->companyId}/quotes/{$id}", [], [], $options);
    }
    public function updateQuote(int $id, array $data, array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('PATCH', "companies/{$this->companyId}/quotes/{$id}", [], $data, $options);
    }
    public function getCustomerQuotes(int $customerId, array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('GET', "companies/{$this->companyId}/customers/{$customerId}/quotes", [], [], $options);
    }
    public function createQuoteEmail(int $quoteId, array $data, array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('POST', "companies/{$this->companyId}/quotes/{$quoteId}/emails", [], $data, $options);
    }
    public function getReportAgedCreditors(array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('GET', "companies/{$this->companyId}/reports/aged_creditors", [], [], $options);
    }
    public function getReportAgedDebtors(array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('GET', "companies/{$this->companyId}/reports/aged_debtors", [], [], $options);
    }
    public function getReportBalanceSheet(array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('GET', "companies/{$this->companyId}/reports/balance_sheet", [], [], $options);
    }
    public function getReportCashFlow(array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('GET', "companies/{$this->companyId}/reports/cash_flow", [], [], $options);
    }
    public function getReportProfitAndLoss(array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('GET', "companies/{$this->companyId}/reports/profit_and_loss", [], [], $options);
    }
    public function getReportTrialBalance(array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('GET', "companies/{$this->companyId}/reports/trial_balance", [], [], $options);
    }
    public function createQuoteAttachment(int $quoteId, array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('POST', "companies/{$this->companyId}/quotes/{$quoteId}/attachments", [], [], $options);
    }
    public function deleteQuoteAttachmentBatchDetach(int $quoteId, array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('DELETE', "companies/{$this->companyId}/quotes/{$quoteId}/attachments/batch_detach", [], [], $options);
    }
    public function getQuoteUploads(int $quoteId, array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('GET', "companies/{$this->companyId}/quotes/{$quoteId}/uploads", [], [], $options);
    }
    public function createQuoteUpload(int $quoteId, array $data, array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('POST', "companies/{$this->companyId}/quotes/{$quoteId}/uploads", [], $data, $options);
    }
    public function deleteQuoteUpload(int $quoteId, int $id, array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('DELETE', "companies/{$this->companyId}/quotes/{$quoteId}/uploads/{$id}", [], [], $options);
    }
    public function getQuoteAuditTrails(int $quoteId, array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('GET', "companies/{$this->companyId}/quotes/{$quoteId}/audit_trails", [], [], $options);
    }
    public function updateQuoteConvertToInvoice(int $quoteId, array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('PATCH', "companies/{$this->companyId}/quotes/{$quoteId}/convert_to_invoice", [], [], $options);
    }
    public function getSuppliers(array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('GET', "companies/{$this->companyId}/suppliers", [], [], $options);
    }
    public function createSupplier(array $data, array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('POST', "companies/{$this->companyId}/suppliers", [], $data, $options);
    }
    public function getSupplier(int $id, array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('GET', "companies/{$this->companyId}/suppliers/{$id}", [], [], $options);
    }
    public function updateSupplier(int $id, array $data, array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('PATCH', "companies/{$this->companyId}/suppliers/{$id}", [], $data, $options);
    }
    public function deleteSupplier(int $id, array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('DELETE', "companies/{$this->companyId}/suppliers/{$id}", [], [], $options);
    }
    public function getSupplierAccount(int $supplierId, array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('GET', "companies/{$this->companyId}/suppliers/{$supplierId}/account", [], [], $options);
    }
    public function getSubscriptions(array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('GET', "companies/{$this->companyId}/subscriptions", [], [], $options);
    }
    public function createSubscription(array $data, array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('POST', "companies/{$this->companyId}/subscriptions", [], $data, $options);
    }
    public function getSubscriptionBillingPlans(array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('GET', "companies/{$this->companyId}/subscriptions/billing_plans", [], [], $options);
    }
    public function getSubscriptionStripeInvoices(array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('GET', "companies/{$this->companyId}/subscriptions/stripe_invoices", [], [], $options);
    }
    public function updateSubscriptionEndSubscription(array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('PATCH', "companies/{$this->companyId}/subscriptions/end_subscription", [], [], $options);
    }
    public function getTaxCodes(array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('GET', "companies/{$this->companyId}/tax_codes", [], [], $options);
    }
    public function getUploads(array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('GET', "companies/{$this->companyId}/uploads", [], [], $options);
    }
    public function createUpload(array $data, array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('POST', "companies/{$this->companyId}/uploads", [], $data, $options);
    }
    public function deleteUpload(int $id, array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('DELETE', "companies/{$this->companyId}/uploads/{$id}", [], [], $options);
    }
    public function getVatReturns(array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('GET', "companies/{$this->companyId}/vat_returns", [], [], $options);
    }
    public function getVatReturn(int $id, array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('GET', "companies/{$this->companyId}/vat_returns/{$id}", [], [], $options);
    }
    public function getVatReturnHmrcSubmissions(array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('GET', "companies/{$this->companyId}/vat_return_hmrc_submissions", [], [], $options);
    }
    public function getVatReturnHmrcSubmission(int $id, array $options = []): Fluent
    {
        return $this->getClientInstance()->handler()->httpRequest('GET', "companies/{$this->companyId}/vat_return_hmrc_submissions/{$id}", [], [], $options);
    }
}
