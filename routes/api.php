<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Item\Tax\TaxController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Item\Item\ItemsController;
use App\Http\Controllers\Api\Auth\ResetPasswordController;
use App\Http\Controllers\Api\Auth\ForgotPasswordController;
use App\Http\Controllers\Api\Purchases\Bill\BillsController;
use App\Http\Controllers\Api\Sales\Invoice\InvoicesController;
use App\Http\Controllers\Api\Sales\Revenue\RevenuesController;
use App\Http\Controllers\Api\Item\Discount\DiscountsController;
use App\Http\Controllers\Api\AccessRight\AccessRightsController;
use App\Http\Controllers\Api\Banking\Account\AccountsController;
use App\Http\Controllers\Api\Item\Category\CategoriesController;
use App\Http\Controllers\Api\Purchases\Vendor\VendorsController;
use App\Http\Controllers\Api\Sales\Customer\CustomersController;
use App\Http\Controllers\Api\Settings\Account\AccountController;
use App\Http\Controllers\Api\Purchases\Payment\PaymentsController;
use App\Http\Controllers\Api\Settings\Company\CompaniesController;
use App\Http\Controllers\Api\Settings\Currency\CurrenciesController;
use App\Http\Controllers\Api\Sales\Invoice\EstimateInvoicesController;
use App\Http\Controllers\Api\Banking\Transaction\TransactionsController;
use App\Http\Controllers\Api\HumanResource\Employee\EmployeesController;
use App\Http\Controllers\Api\Settings\Contribution\ContributionsController;
use App\Http\Controllers\Api\Settings\PaymentMethod\PaymentMethodsController;
use App\Http\Controllers\Api\HumanResource\Payroll\Payroll\PayrollsController;
use App\Http\Controllers\Api\InventoryManagement\Supplier\SuppliersController;
use App\Http\Controllers\Api\DoubleEntry\JournalEntry\JournalEntriesController;
use App\Http\Controllers\Api\InventoryManagement\Warehouse\WarehousesController;
use App\Http\Controllers\Api\Settings\IncomeCategory\IncomeCategoriesController;
use App\Http\Controllers\Api\DoubleEntry\ChartOfAccount\ChartOfAccountsController;
use App\Http\Controllers\Api\InventoryManagement\Stock\StockAdjustmentsController;
use App\Http\Controllers\Api\Settings\ExpenseCategory\ExpenseCategoriesController;
use App\Http\Controllers\Api\HumanResource\Payroll\PayCalendar\PayCalendarsController;
use App\Http\Controllers\Api\Banking\BankAccountTransfer\BankAccountTransfersController;
use App\Http\Controllers\Api\HumanResource\Payroll\SalaryBenefit\SalaryBenefitsController;
use App\Http\Controllers\Api\Banking\BankAccountReconciliation\BankAccountReconciliationsController;
use App\Http\Controllers\Api\Exports\Items\ItemExportsController;
use App\Http\Controllers\Api\Exports\Purchases\BillExportsController;
use App\Http\Controllers\Api\Exports\Purchases\PaymentExportsController;
use App\Http\Controllers\Api\Exports\Sales\CustomerExportsController;
use App\Http\Controllers\Api\Exports\Sales\InvoiceExportsController;
use App\Http\Controllers\Api\Exports\Sales\RevenueExportsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


/**
 * Auth Module
 */
Route::middleware(['api'])->group(function () 
{
    Route::prefix('auth')->group(function () 
    {
        Route::post('/login', [LoginController::class, 'login']);
        Route::post('/register', [RegisterController::class, 'register']);
    });

    Route::prefix('forgot-password')->group(function () 
    {
        Route::post('/email', [ForgotPasswordController::class, 'sendResetLinkEmail']);
        Route::post('/reset', [ResetPasswordController::class, 'reset']);
    });

    Route::middleware(['auth:api'])->group(function () 
    {
        Route::post('/logout', [LoginController::class, 'logout']);
        Route::get('/auth', [AuthController::class, 'show']);
    });
});



/**
 * Access rights module
 */
Route::prefix('access-rights')->group(function () 
{
    Route::get('/', [AccessRightsController::class, 'index']);
    Route::get('/{id}', [AccessRightsController::class, 'show']);
    Route::post('/', [AccessRightsController::class, 'store']);
    Route::put('/', [AccessRightsController::class, 'update']);
    Route::delete('/', [AccessRightsController::class, 'destroy']);
});




/**
 * * Banking
 * 
 *  - Accounts
 *  - Bank account transfers
 *  - Bank account reconciliations
 *  - Transactions
 */
Route::prefix('banking')->group(function () 
{
    /**
     * Accounts
     */
    Route::prefix('accounts')->group(function () 
    {
        Route::get('/', [AccountsController::class, 'index']);
        Route::get('/{id}', [AccountsController::class, 'show']);
        Route::post('/', [AccountsController::class, 'store']);
        Route::put('/', [AccountsController::class, 'update']);
        Route::delete('/', [AccountsController::class, 'destroy']);
    });

    /**
     * Bank account transfers
     */
    Route::prefix('transfers')->group(function () 
    {
        Route::get('/', [BankAccountTransfersController::class, 'index']);
        Route::get('/{id}', [BankAccountTransfersController::class, 'show']);
        Route::post('/', [BankAccountTransfersController::class, 'store']);
        Route::put('/', [BankAccountTransfersController::class, 'update']);
        Route::delete('/', [BankAccountTransfersController::class, 'destroy']);
    });

    /**
     * Bank account reconciliations
     */
    Route::prefix('reconciliations')->group(function () 
    {
        Route::get('/', [BankAccountReconciliationsController::class, 'index']);
        Route::get('/{id}', [BankAccountReconciliationsController::class, 'show']);
        Route::post('/', [BankAccountReconciliationsController::class, 'store']);
        Route::put('/', [BankAccountReconciliationsController::class, 'update']);
        Route::delete('/', [BankAccountReconciliationsController::class, 'destroy']);
    });

    /**
    * Transactions
    */
    Route::prefix('transactions')->group(function () 
    {
        Route::get('/', [TransactionsController::class, 'index']);
        Route::get('/{id}', [TransactionsController::class, 'show']);
        Route::get('/account/{id}', [TransactionsController::class, 'showByAccount']);
    });
});



/**
 * * Double entry
 *  - Chart of accoutns
 *  - Journal Entry
 */
Route::prefix('double-entry')->group(function () 
{
    /**
      * Chart of accounts
      */
    Route::prefix('chart-of-accounts')->group(function () 
    {
        Route::get('/', [ChartOfAccountsController::class, 'index']);
        Route::get('/{id}', [ChartOfAccountsController::class, 'show']);
        Route::post('/', [ChartOfAccountsController::class, 'store']);
        Route::put('/', [ChartOfAccountsController::class, 'update']);
        Route::delete('/', [ChartOfAccountsController::class, 'destroy']);
    });

    /**
      * Journal Entries
      */
    Route::prefix('journal-entries')->group(function () 
    {
        Route::get('/', [JournalEntriesController::class, 'index']);
        Route::get('/{id}', [JournalEntriesController::class, 'show']);
        Route::post('/', [JournalEntriesController::class, 'store']);
        Route::put('/', [JournalEntriesController::class, 'update']);
        Route::delete('/', [JournalEntriesController::class, 'destroy']);
    });
});


/**
 * * Exports (EXCEL, CSV, PDF)
 */
Route::prefix('exports')->group(function () 
{
    Route::prefix('excel')->group(function () 
    {
        Route::get('/items', [ItemExportsController::class, 'excel']);
        Route::get('/invoices', [InvoiceExportsController::class, 'excel']);
        Route::get('/revenues', [RevenueExportsController::class, 'excel']);
        Route::get('/customers', [CustomerExportsController::class, 'excel']);
        Route::get('/bills', [BillExportsController::class, 'excel']);
        Route::get('/payments', [PaymentExportsController::class, 'excel']);
    });

    Route::prefix('csv')->group(function () 
    {
        Route::get('/items', [ItemExportsController::class, 'csv']);
        Route::get('/invoices', [InvoiceExportsController::class, 'csv']);
        Route::get('/revenues', [RevenueExportsController::class, 'csv']);
        Route::get('/customers', [CustomerExportsController::class, 'csv']);
        Route::get('/bills', [BillExportsController::class, 'csv']);
        Route::get('/payments', [PaymentExportsController::class, 'csv']);
    });
});


/**
 * * Human Resources
 * 
 *  - Employees
 *  - Payroll 
 *      -- Pay calendars
 *      -- Salary benefits
 */
Route::prefix('human-resources')->group(function () 
{
    /**
    * Employees
    */
    Route::prefix('employees')->group(function () 
    {
        Route::get('/', [EmployeesController::class, 'index']);
        Route::get('/{id}', [EmployeesController::class, 'show']);
        Route::post('/', [EmployeesController::class, 'store']);
        Route::put('/', [EmployeesController::class, 'update']);
        Route::delete('/', [EmployeesController::class, 'destroy']);
    });

    Route::prefix('payrolls')->group(function () 
    {
        /**
          * Pay calendars
          */
        Route::prefix('pay-calendars')->group(function () 
        {
            Route::get('/', [PayCalendarsController::class, 'index']);
            Route::get('/{id}', [PayCalendarsController::class, 'show']);
            Route::post('/', [PayCalendarsController::class, 'store']);
            Route::put('/', [PayCalendarsController::class, 'update']);
            Route::delete('/', [PayCalendarsController::class, 'destroy']);
        });

        /**
          * Payroll
          */
        Route::prefix('run-payrolls')->group(function () 
        {
            Route::get('/', [PayrollsController::class, 'index']);
            Route::get('/{id}', [PayrollsController::class, 'show']);
            Route::post('/', [PayrollsController::class, 'store']);
            Route::put('/', [PayrollsController::class, 'update']);
            Route::put('/{id}/approve', [PayrollsController::class, 'approve']);
            Route::delete('/', [PayrollsController::class, 'destroy']);
        });

        /**
          * Salary Benefits
          */
        Route::prefix('salary-benefits')->group(function () 
        {
            Route::get('/', [SalaryBenefitsController::class, 'index']);
            Route::get('/{id}', [SalaryBenefitsController::class, 'show']);
            Route::post('/', [SalaryBenefitsController::class, 'store']);
            Route::put('/', [SalaryBenefitsController::class, 'update']);
            Route::delete('/', [SalaryBenefitsController::class, 'destroy']);
        });

    });
});



/**
 * * Item
 * 
 *  - Items
 *  - Categories
 *  - Discounts
 */
Route::prefix('item')->group(function () 
{
    /**
     * Categories
     */
    Route::prefix('categories')->group(function () 
    {
        Route::get('/', [CategoriesController::class, 'index']);
        Route::get('/{id}', [CategoriesController::class, 'show']);
        Route::post('/', [CategoriesController::class, 'store']);
        Route::put('/', [CategoriesController::class, 'update']);
        Route::delete('/', [CategoriesController::class, 'destroy']);
    });

    /**
     * Discounts
     */
    Route::prefix('discounts')->group(function () 
    {
        Route::get('/', [DiscountsController::class, 'index']);
        Route::get('/{id}', [DiscountsController::class, 'show']);
        Route::post('/', [DiscountsController::class, 'store']);
        Route::put('/', [DiscountsController::class, 'update']);
        Route::delete('/', [DiscountsController::class, 'destroy']);
    });

    /**
     * Items
     */
    Route::prefix('items')->group(function () 
    {
        Route::get('/', [ItemsController::class, 'index']);
        Route::get('/{id}', [ItemsController::class, 'show']);
        Route::post('/', [ItemsController::class, 'store']);
        Route::post('/upload', [ItemsController::class, 'upload']);
        Route::put('/', [ItemsController::class, 'update']);
        Route::delete('/', [ItemsController::class, 'destroy']);
    });

});



/**
 * * Purchases
 * 
 *  - Bills
 *  - Payments
 *  - Vendor
 */
Route::prefix('purchases')->group(function () 
{
    /**
     * Bills
     */
    Route::prefix('bills')->group(function () 
    {
        Route::get('/', [BillsController::class, 'index']);
        Route::get('/{id}', [BillsController::class, 'show']);
        Route::post('/', [BillsController::class, 'store']);
        Route::post('/{bill}/vendors/{vendor}/mail', [BillsController::class, 'email']);
        Route::post('/{id}/mark-as-paid', [BillsController::class, 'markAsPaid']);
        Route::post('/payment', [BillsController::class, 'payment']);
        Route::put('/', [BillsController::class, 'update']);
        Route::put('/{bill}', [BillsController::class, 'cancel']);
        Route::delete('/', [BillsController::class, 'destroy']);
    });

    /**
     * Payments
     */
    Route::prefix('payments')->group(function () 
    {
        Route::get('/', [PaymentsController::class, 'index']);
        Route::get('/{id}', [PaymentsController::class, 'show']);
        Route::post('/', [PaymentsController::class, 'store']);
        Route::put('/', [PaymentsController::class, 'update']);
        Route::delete('/', [PaymentsController::class, 'destroy']);
    });

    /**
     * Vendors
     */
    Route::prefix('vendors')->group(function () 
    {
        Route::get('/', [VendorsController::class, 'index']);
        Route::get('/{id}', [VendorsController::class, 'show']);
        Route::post('/', [VendorsController::class, 'store']);
        Route::put('/', [VendorsController::class, 'update']);
        Route::delete('/', [VendorsController::class, 'destroy']);
    });

});

/**
 * * Sales 
 * 
 *  - Customers
 *  - Invoices
 *  - Estimate invoices
 *  - Revenues
 */
Route::prefix('sales')->group(function () 
{
    /**
     * Customers
     */
    Route::prefix('customers')->group(function () 
    {
        Route::get('/', [CustomersController::class, 'index']);
        Route::get('/{id}', [CustomersController::class, 'show']);
        Route::post('/', [CustomersController::class, 'store']);
        Route::put('/', [CustomersController::class, 'update']);
        Route::delete('/', [CustomersController::class, 'destroy']);
    });

    /**
      * Estimate Invoices
      */
    Route::prefix('estimate-invoices')->group(function () 
    {
        Route::get('/', [EstimateInvoicesController::class, 'index']);
        Route::get('/{id}', [EstimateInvoicesController::class, 'show']);
        Route::post('/', [EstimateInvoicesController::class, 'store']);
        Route::post('/{estimateInvoice}/customers/{customer}/mail', [EstimateInvoicesController::class, 'mail']);
        Route::put('/{estimateInvoice}/mark-as-approved', [EstimateInvoicesController::class, 'markAsApproved']);
        Route::put('/{estimateInvoice}/mark-as-refused', [EstimateInvoicesController::class, 'markAsRefused']);
        Route::put('/', [EstimateInvoicesController::class, 'update']);
        Route::delete('/', [EstimateInvoicesController::class, 'destroy']);
    });

    /**
     * Invoices
     */
    Route::prefix('invoices')->group(function () 
    {
        Route::get('/', [InvoicesController::class, 'index']);
        Route::get('/{id}', [InvoicesController::class, 'show']);
        Route::post('/', [InvoicesController::class, 'store']);
        Route::post('/{invoice}/customers/{customer}/mail', [InvoicesController::class, 'mail']);
        Route::post('/payment', [InvoicesController::class, 'payment']);
        Route::put('/', [InvoicesController::class, 'update']);
        Route::put('/{invoice}/mark-as-paid', [InvoicesController::class, 'markAsPaid']);
        Route::put('/{invoice}', [InvoicesController::class, 'cancel']);
        Route::delete('/', [InvoicesController::class, 'destroy']);
    });

    /**
     * Revenues
     */
    Route::prefix('revenues')->group(function () 
    {
        Route::get('/', [RevenuesController::class, 'index']);
        Route::get('/{id}', [RevenuesController::class, 'show']);
        Route::post('/', [RevenuesController::class, 'store']);
        Route::put('/', [RevenuesController::class, 'update']);
        Route::delete('/', [RevenuesController::class, 'destroy']);
    });
});



/**
 * * Settings
 * 
 *  - Accounts
 *  - Company
 *  - Contributions
 *  - Currencies
 *  - Payment methods
 *  - Income categories
 *  - Expense categories
 *  - Payment methods
 *  - Taxes
 */
Route::prefix('settings')->group(function () 
{
    /**
     * Accounts
     */
    Route::prefix('account')->group(function () 
    {
        Route::post('/verify', [AccountController::class, 'verify']);
        Route::put('/', [AccountController::class, 'update']);
    });

    /**
      * Company
      */
    Route::prefix('company')->group(function () 
    {
        Route::get('/{id}', [CompaniesController::class, 'show']);
        Route::post('/', [CompaniesController::class, 'store']);
        Route::put('/', [CompaniesController::class, 'update']);
    });

    /**
      * Contributions
      */
    Route::prefix('contributions')->group(function () 
    {
        Route::get('/', [ContributionsController::class, 'index']);
        Route::get('/{id}', [ContributionsController::class, 'show']);
        Route::post('/', [ContributionsController::class, 'store']);
        Route::put('/', [ContributionsController::class, 'update']);
        Route::delete('/', [ContributionsController::class, 'destroy']);
    });

    /**
      * Currencies
      */
    Route::prefix('currencies')->group(function () 
    {
        Route::get('/', [CurrenciesController::class, 'index']);
        Route::get('/{id}', [CurrenciesController::class, 'show']);
        Route::post('/', [CurrenciesController::class, 'store']);
        Route::put('/', [CurrenciesController::class, 'update']);
        Route::delete('/', [CurrenciesController::class, 'destroy']);
    });

    /**
      * Income Categories
      */
    Route::prefix('income-categories')->group(function () 
    {
        Route::get('/', [IncomeCategoriesController::class, 'index']);
        Route::get('/{id}', [IncomeCategoriesController::class, 'show']);
        Route::post('/', [IncomeCategoriesController::class, 'store']);
        Route::put('/', [IncomeCategoriesController::class, 'update']);
        Route::delete('/', [IncomeCategoriesController::class, 'destroy']);
    });
    
    /**
      * Expense Categories
      */
    Route::prefix('expense-categories')->group(function () 
    {
        Route::get('/', [ExpenseCategoriesController::class, 'index']);
        Route::get('/{id}', [ExpenseCategoriesController::class, 'show']);
        Route::post('/', [ExpenseCategoriesController::class, 'store']);
        Route::put('/', [ExpenseCategoriesController::class, 'update']);
        Route::delete('/', [ExpenseCategoriesController::class, 'destroy']);
    });

    /**
      * Payment methods
      */
    Route::prefix('payment-methods')->group(function () 
    {
        Route::get('/', [PaymentMethodsController::class, 'index']);
        Route::get('/{id}', [PaymentMethodsController::class, 'show']);
        Route::post('/', [PaymentMethodsController::class, 'store']);
        Route::put('/', [PaymentMethodsController::class, 'update']);
        Route::delete('/', [PaymentMethodsController::class, 'destroy']);
    });

    /**
     * Taxes
     */
    Route::prefix('taxes')->group(function () 
    {
        Route::get('/', [TaxController::class, 'index']);
        Route::get('/{id}', [TaxController::class, 'show']);
        Route::post('/', [TaxController::class, 'store']);
        Route::put('/', [TaxController::class, 'update']);
        Route::delete('/', [TaxController::class, 'destroy']);
    });
});



/**
 * * Inventory Management
 * 
 *  - Suppliers
 *  - Stock adjustments
 *  - Warehouses
 */
Route::prefix('inventory-management')->group(function () 
{
    /**
     * Suppliers
     */
    Route::prefix('suppliers')->group(function () 
    {
        Route::get('/', [SuppliersController::class, 'index']);
        Route::get('/{id}', [SuppliersController::class, 'show']);
        Route::post('/', [SuppliersController::class, 'store']);
        Route::put('/', [SuppliersController::class, 'update']);
        Route::delete('/', [SuppliersController::class, 'destroy']);
    });

    /**
     * Stock adjustments
     */
    Route::prefix('stock-adjustments')->group(function () 
    {
        Route::get('/', [StockAdjustmentsController::class, 'index']);
        Route::get('/{id}', [StockAdjustmentsController::class, 'show']);
        Route::post('/', [StockAdjustmentsController::class, 'store']);
        Route::put('/', [StockAdjustmentsController::class, 'update']);
        Route::delete('/', [StockAdjustmentsController::class, 'destroy']);
    });

    /**
     * Warehouses
     */
    Route::prefix('warehouses')->group(function () 
    {
        Route::get('/', [WarehousesController::class, 'index']);
        Route::get('/{id}', [WarehousesController::class, 'show']);
        Route::post('/', [WarehousesController::class, 'store']);
        Route::put('/', [WarehousesController::class, 'update']);
        Route::delete('/', [WarehousesController::class, 'destroy']);
    });
});




