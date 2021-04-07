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
use App\Http\Controllers\Api\Purchases\Purchase\PurchasesController;
use App\Http\Controllers\Api\Settings\Currency\CurrenciesController;
use App\Http\Controllers\Api\Settings\PaymentMethod\PaymentMethodsController;
use App\Http\Controllers\Api\InventoryManagement\Supplier\SuppliersController;
use App\Http\Controllers\Api\InventoryManagement\Warehouse\WarehousesController;
use App\Http\Controllers\Api\Settings\IncomeCategory\IncomeCategoriesController;
use App\Http\Controllers\Api\InventoryManagement\Stock\StockAdjustmentsController;
use App\Http\Controllers\Api\Settings\ExpenseCategory\ExpenseCategoriesController;
use App\Http\Controllers\Api\Banking\BankAccountTransfer\BankAccountTransfersController;
use App\Http\Controllers\Api\Banking\BankAccountReconciliation\BankAccountReconciliationsController;

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
     * Item
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

    /**
     * Tax
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
 * * Purchases
 *  - Bills
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
     * Purchase
     */
    Route::prefix('purchases')->group(function () 
    {
        Route::get('/', [PurchasesController::class, 'index']);
        Route::get('/{id}', [PurchasesController::class, 'show']);
        Route::post('/', [PurchasesController::class, 'store']);
        Route::put('/', [PurchasesController::class, 'update']);
        Route::delete('/', [PurchasesController::class, 'destroy']);
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
 *  - Invoices
 *  - Customers
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
     * Invoices
     */
    Route::prefix('invoices')->group(function () 
    {
        Route::get('/', [InvoicesController::class, 'index']);
        Route::get('/{id}', [InvoicesController::class, 'show']);
        Route::post('/', [InvoicesController::class, 'store']);
        Route::post('/{invoice}/customers/{customer}/mail', [InvoicesController::class, 'email']);
        Route::post('/{id}/mark-as-paid', [InvoicesController::class, 'markAsPaid']);
        Route::post('/payment', [InvoicesController::class, 'payment']);
        Route::put('/', [InvoicesController::class, 'update']);
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
 *  - Account
 *  - Payment methods
 *  - Income categories
 *  - Expense categories
 *  - Payment methods
 */
Route::prefix('settings')->group(function () 
{
    /**
     * Account
     */
    Route::prefix('account')->group(function () 
    {
        Route::post('/verify', [AccountController::class, 'verify']);
        Route::put('/', [AccountController::class, 'update']);
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
     * Income Categories
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
     * Warehouse
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




