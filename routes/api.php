<?php


use App\Http\Controllers\APIController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\CurrencyController;
use App\Http\Controllers\api\CustomerController;
use App\Http\Controllers\api\deleteTransaction;
use App\Http\Controllers\api\ExchangeController;
use App\Http\Controllers\api\FinanceAccountController;
use App\Http\Controllers\api\IncomeExpController;
use App\Http\Controllers\api\OrderController;
use App\Http\Controllers\api\ReportFinanceController;
use App\Http\Controllers\api\TestController;
use App\Http\Controllers\api\TransactionController;
use App\Http\Controllers\api\UserController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });



Route::post('/login', [APIController::class, 'login']);
Route::post('/loginCustomer', [APIController::class, 'loginCustomer']);

Route::post('/forget-password', [APIController::class, 'forget_pass']);
Route::post('/reset-password', [APIController::class, 'reset_pass']);




Route::middleware('auth:api')->group(function(){

    Route::post('/register', [APIController::class, 'register']);
    
    Route::post('/logout', [APIController::class, 'logout']);
    Route::apiResource('user', UserController::class);
    Route::post('/updateuser', [UserController::class,'updateUser']);
    Route::post('/deleteuser', [UserController::class,'deleteOneUser']);
    Route::post('/searchuser', [UserController::class,'searchUsers']);
    
    Route::apiResource('customer',CustomerController::class);
    Route::post('/updatecustomer', [CustomerController::class, 'updateCustomer']);
    Route::post('/searchCustomer', [CustomerController::class, 'searchCustomer']);
    Route::post('/changeusername/{id}', [CustomerController::class, 'ChangeUsernameFunc']);
    Route::post('/changepassword/{id}', [CustomerController::class, 'ChangePasswordFunc']);
    // for exporting the  customer transaction table to pdf
    Route::post('/exportcustomertopdf', [CustomerController::class, 'filterCustomerExport']);
    
    Route::apiResource('currencies',CurrencyController::class);
    Route::post('/updatecurrency', [CurrencyController::class, 'updateCurrency']);
    Route::post('/searchcurrency', [CurrencyController::class, 'searchCurrency']);
    
    Route::apiResource('finance_account',FinanceAccountController::class);
    
    Route::post('/searchfinanceaccount', [FinanceAccountController::class, 'searchFinanceAccount']);
    // filter finance Account by type
    Route::post('/financetypefilter', [FinanceAccountController::class, 'filterfinanceAccount']);
    
    
    Route::apiResource('orders',OrderController::class);
    Route::get('/acceptedorder', [OrderController::class, 'getAcceptedOrder']);
    Route::get('/pendingorder', [OrderController::class, 'getPendingOrder']);
    Route::get('/rejectedorder', [OrderController::class, 'getrejectedOrder']);
    Route::post('/searchorder', [OrderController::class, 'searchOrder']);
    
    Route::apiResource('users',UserController::class);
    
    Route::get('/financeAccWithCurrency/{id}',[IncomeExpController::class, 'getFinanceAccountByCurrencyId']);
    Route::post('/searchbanksbytype',[FinanceAccountController::class, 'searchBanksByType']);
    Route::post('/deleteExpense',[IncomeExpController::class, 'deleteExpense']);
    Route::post('/searchincomexpenses', [IncomeExpController::class, 'searchIncomeExpensesFunc']);
    
    
    Route::apiResource('transaction',TransactionController::class);
    Route::get('/transaction/{id}',[TransactionController::class]);
    Route::post('/searchtransactions',[TransactionController::class,'getSearchTransactions']);
    Route::post('/searchtransaction',[TransactionController::class,'getCustomerInfoSearch']);
    // edit transaction
    Route::post('/updateTransaction',[TransactionController::class,'updateTransaction']);
    
    // select transaction that the ref_id equal to customer id
    Route::post('/customerinfo',[TransactionController::class,'getCustomerInfo']);
    
    // Route::get('/transactionbyorderid/{id}',[TransactionController::class,'transactionByOrderId']);
    
    
    
    ////expenses///////
    Route::get('/expenses',[FinanceAccountController::class,'expenses']);
    Route::post('/storeExpense',[IncomeExpController::class, 'storeExpense']);
    Route::get('/showExpenses', [IncomeExpController::class, 'showExpenses']);
    Route::get('/showExpense/{id}', [IncomeExpController::class, 'showExpens']);
    Route::post('/updateExpense', [IncomeExpController::class, 'updateExpense']);
    // for searching just expense page
    Route::post('/searchexpense',[IncomeExpController::class,'searchExpensesFunc']);
    Route::apiResource('income_expense',IncomeExpController::class);
    
    // get banks by currency id
    Route::get('/getbankbyid/{id}', [FinanceAccountController::class, 'getBanksByCurrency']);
    
    
    
    // Route::apiResource('reportfinanceAccounts',ReportFinanceController::class);
    Route::get('/bankbalance',[ReportFinanceController::class, 'getBankBalance']);
    // Route::get('/bankdetails/{id}',[ReportFinanceController::class, 'getBanksTransaction']);
    Route::get('/bankdetails/{id}',[ReportFinanceController::class, 'getBanksTransaction']);
    Route::post('/filterBankTransactions',[ReportFinanceController::class, 'filterBankTransactions']);
    
    // get all balances
    Route::get('/getallbalances',[ReportFinanceController::class, 'getAllBalances']);
    // for getting the customer balance
    // Route::get('/getcustomerbalance/{id}',[CustomerController::class, 'getCustomerBalance']);
    Route::get('/customerblance/{customerId}', [CustomerController::class, 'getCustomerBalance']);
    // for gettting all transaction
    Route::post('/filteralltransaction',[ReportFinanceController::class, 'filterAllTransaction']);
    // for getting all currency counts
    Route::get('/getcurrencycount', [ReportFinanceController::class, 'getCurrencyCounts']);
    // Exchange Buy Controller
    Route::apiResource('/exchange',ExchangeController::class);
    Route::post('/buystoretransaction',[ExchangeController::class,'buyStoreExchange']);
    Route::post('/getexchangeforedit',[ExchangeController::class,'getExchangeforEdit']);
    Route::post('/updatebuyexchange',[ExchangeController::class,'updateBuyExchangeTransaction']);
    // for get buy transactions
    Route::get('/getbuytransaction',[ExchangeController::class,'getBuyTransaction']);
    // for get sale transactions
    Route::get('/getsaletransaction',[ExchangeController::class,'getSaleTransaction']);
    
    Route::post('/deleteexchange',[ExchangeController::class,'deleteBuyExchange']);
    Route::post('/searchexchange',[ExchangeController::class,'getBuySearchTransaction']);
    Route::post('/searchsaleexchange',[ExchangeController::class,'getSaleSearchTransaction']);
    
    
    Route::post('/salestore',[ExchangeController::class,'saleStoreExchange']);
    Route::post('/getexchangesaleforedit',[ExchangeController::class,'getExchangeSaleforEdit']);
    Route::post('/updatesaleexchange',[ExchangeController::class,'updateSaleExchange']);
    Route::post('/deleteexchangesale',[ExchangeController::class,'deleteSaleExchange']);
    
    
    // transfer
    Route::get('/gettransfers',[ExchangeController::class, 'getTransfer']);
    
    Route::post('/storetransfer',[ExchangeController::class,'storeTranferTransactions']);
    Route::post('/gettransferforedit',[ExchangeController::class,'getTransferforEdit']);
    Route::post('/updateTransferTransaction',[ExchangeController::class,'updateTransferTransaction']);
    Route::post('/deletetransfer',[ExchangeController::class,'deleteTransfer']);
    Route::post('/searchtransfer',[ExchangeController::class,'searchTransfers']);
    // for delete transaction
    Route::post('/deleteonetransaction',[deleteTransaction::class, 'deleteTransaction']);
    
    // for exporting the customer transaction table
    Route::get('/transactions/pdf', [TransactionController::class, 'exportTransactionsToPDF'])->name('transactions.pdf');
    // rooznacha 
    Route::post('/getrooznamchah',[ReportFinanceController::class, 'getRooznamcha']);
    Route::post('/filterrooznamchah',[ReportFinanceController::class, 'filterRooznachah']);
});


