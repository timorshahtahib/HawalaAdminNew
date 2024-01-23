<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\BankBalance;
use App\Models\Currency;
use App\Models\FinanceAccount;
use App\Models\IncomeExp;
use App\Models\Transaction;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class ReportFinanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

      
    }

        public function getBankBalance(Request $request){
             
         try {
            $limit = $request->has('limit') ? $request->limit : 10;

            $bankBalance = BankBalance::paginate($limit);
            $currency_count= Currency::where('status',1)->count();
            $financeAcc_count= FinanceAccount::where('status',1)->count();

            if($bankBalance->isEmpty()){
                return response()->json([]);
            }
            $totalPages = $bankBalance->lastPage();
            return response()->json(['bank_balance'=>$bankBalance,'currency_counts'
            =>$currency_count,'financeAcc_count'=>$financeAcc_count,'total_pages'=>$totalPages]);
        
         } catch (Throwable $e) {
            return response()->json(['message'=>$e->getMessage()],500);
         }
        }




        public function getBanksTransaction(Request $request){
            $id = $request->id;
            $bankTransaction = Transaction::where('bank_acount_id',$id)->where('status',1)->with(['financeAccount','customer','tr_currency','bank_account'])->orderBy('id','desc')->get();
            
            return response()->json(['banksTransaction'=>$bankTransaction]);
        }



        public function filterBankTransactions(Request $request) {
            $tr_type = $request->tr_type;
            $start_date = $request->start_date;
            $end_date = $request->end_date;
            $bank_acount_id = $request->bank_acount_id;
        
            // Building the query
            $searchBank = Transaction::where('bank_acount_id', $bank_acount_id);
        
            if ($tr_type!='all') {
                $searchBank->where('rasid_bord', $tr_type);
            }
        
            if ($start_date) {
                $searchBank->whereDate('date', '>=', $start_date);
            }
        
            if ($end_date) {
                $searchBank->whereDate('date', '<=', $end_date);
            }
        
            $result = $searchBank->with(['financeAccount','customer','tr_currency','bank_account'])->orderBy('id','desc')->get();
        
            return response()->json(['searchBank' => $result]);
        }
        
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function getUserAllPaindAndLoan(){

    }

    public function filterAllTransaction(Request $request) {
        $transaction_type = $request->transaction_type;
        $rasid_bord = $request->rasid_bord;
        $customer_id = $request->customer_id;
        $currency = $request->currency;
        $dakhl = $request->dakhl;
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        
    
        $getTransaction = Transaction::where('status',1);
        

    
        if ($transaction_type!='all') {
            if ($rasid_bord!='all') {
              
                $getTransaction->where('rasid_bord', $rasid_bord)->where('transaction_type',$transaction_type);
            }
        }else{
           
            if ($rasid_bord!='all') {
              
                $getTransaction->where('rasid_bord', $rasid_bord);
            }
                }
    
    
      
    
        if ($customer_id) {
            $getTransaction->where('ref_id', $customer_id);
        }
        if ($currency) {
            $getTransaction->where('currency', $currency);
        }
        if ($dakhl) {
            $getTransaction->where('bank_acount_id', $dakhl);
        }

        if ($start_date) {
            $getTransaction->whereDate('date', '>=', $start_date);
        }
        if ($end_date) {
            $getTransaction->whereDate('date', '<=', $end_date);
        }
    
        $result = $getTransaction->with(['financeAccount','customer','tr_currency','bank_account'])->orderBy('id','desc')->get();
    
        return response()->json(['transactions' => $result]);
    }

    public function getCurrencyCounts(){
        $currency_count= Currency::where('status',1)->count();
        return response()->json($currency_count);
    }
}
