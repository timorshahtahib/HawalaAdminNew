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

class ReportFinanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
   // $bankBalances = BankBalance::all();

      
    }

        public function getBankBalance(){
            $bankBalance = BankBalance::get();
          
            return response()->json(['bank_balance'=>$bankBalance]);
        }


        public function getBanksTransaction(Request $request){
            $id= $request->id;
        try {
            $limit = $request->has('limit') ? $request->limit : 10;
            $id= $request->id;
            $bankTransaction = Transaction::where('status', '=', '1')->where('bank_acount_id',$id)
            ->with(['financeAccount','customer','tr_currency','bank_account'])->orderBy('id','desc')
            ->paginate($limit);

            if ($bankTransaction->isEmpty()) {
                return response()->json(['error' => 'Transaction not found'], 404);
            }
            $total_pages= $bankTransaction->lastPage();
            return response()->json(['banksTransaction' =>$bankTransaction,'total_pages'=>$total_pages]);
        }
        catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
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
}
