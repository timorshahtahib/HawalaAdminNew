<?php

namespace App\Http\Controllers\api;

use App\Enums\TypeEnum;
use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Models\FinanceAccount;
use App\Models\IncomeExp;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Enum;
use Throwable;

class FinanceAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */


     public function index(Request $request)
     {
        try {
            $limit = $request->has('limit') ? $request->limit : 10;
    
            $financeAccount = FinanceAccount::where('status', '=', '1')->with(['finance_currency'])
                ->orderBy('id', 'desc')
                ->paginate($limit);
    
            if ($financeAccount->isEmpty()) {
                return response()->json([]);
            }
    
            $currency = Currency::where('status',1)->get();

            $totalPages = $financeAccount->lastPage();
    
            return response()->json(['financeAccounts' => $financeAccount,'currencies' => $currency, 'total_pages' => $totalPages]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

     }
     
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'account_name' => 'required|max:50',
            'type' => 'in:asset,equity,liablity',
            'currency'=>'nullable|max:20',
            'description' => '',
           
            'status'=>'',
            'account'=>''
    ]);
  
    if(!$validator->passes()){
        return response()->json([
            'error'=>$validator->errors()->toArray(),
        ]);
    }else{

        DB::beginTransaction();
        try{
    
            $finance_values = [
                'account_name' => $request->account_name,
                'type' =>  $request->type,
                'currency'=> $request->currency,
                'description' =>$request->description,
                'user_id'=>Auth::user()->id,
                'account'=>$request->account
            ];

            $transaction_id = FinanceAccount::insertGetId($finance_values);

            if($transaction_id){
             
             
                $output_data = FinanceAccount::where('id',$transaction_id)->with(['finance_currency'])->first();

                DB::commit();
                return  response()->json([
                    'status'=>true,
                    'new_data'=>$output_data,
                    'message'=>'عملیات انجام شد',
                ]);

            }else{
                DB::rollback();
                return  response()->json([
                    'status'=>false,
                    'message'=>'عملیات انجام نشد',
                ]);
            }

        }catch(Throwable $e){
            DB::rollback();
            return  response()->json([
                'status'=>false,
                'message'=>$e->getMessage(),
            ]);
        }

    }

    

    }

    /**
     * Display the specified resource.
     */
    public function show(FinanceAccount $financeAccount)
    {
        return response()->json($financeAccount,200);
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,FinanceAccount $financeAccount)
    {
    $validator = Validator::make($request->all(), [
        'account_name' => 'required|max:50',
        'type' => 'in:asset,equity,liablity',
        'currency'=>'nullable|max:20',
        'description' => '',
        // 'user_id' => ,
        'account'=>''
]);

        if(!$validator->passes()){
                return response()->json([
                'error'=>$validator->errors()->toArray(),
            ]);
        }else{

            $finance_values = [
                'account_name' => $request->account_name,
                'type' =>  $request->type,
                'currency'=> $request->currency,
                'description' =>$request->description,
                'account'=>$request->account
            ];

    $finance_id = FinanceAccount::insertGetId($finance_values);
    // $financeAccount->update($request->all());

    if($finance_id){
        $update_values = ['id'=>$finance_id,];
     
        $output_data = FinanceAccount::where('id',$finance_id)->first();

        DB::commit();
        return  response()->json([
            'status'=>true,
            'new_data'=>$output_data,
            'message'=>'عملیات انجام شد',
        ]);

    }else{
        DB::rollback();
        return  response()->json([
            'status'=>false,
            'message'=>'عملیات انجام نشد',
        ]);
    }
    // return response()->json($financeAccount,201);

}
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $financeAccount=FinanceAccount::findOrFail($id);
        $financeAccount->update(['status'=>0]);
        $financeAccount->save();
        return response()->json(['message' => 'financeAccount was deleted successfully'], 204);
    
    }

  
///////////exppense//////////////////////////////////////
    public function expenses(Request $request)
    {
        try {
            $limit = $request->has('limit') ? $request->limit : 10;
            $offset = $request->has('offset') ? $request->offset : 0;

            $expenses_acounts = FinanceAccount::where('status', '=', '1')->where('account','expense')->orderBy('id', 'desc')->get();

            if ($expenses_acounts->isEmpty()) {
                return response()->json(['error' => 'FinanceAccount not found!'], 404);
            }

            $total_count = FinanceAccount::where('status', '=', '1')->count();
            $total_pages = ceil($total_count / $limit);

            return response()->json(['financeAccounts' => $expenses_acounts, 'total_pages' =>  $total_pages]);
        } 
        catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function getBanksByCurrency($id){

        $currency = Currency::where('id',$id)->first();
        $financeAccount = FinanceAccount::where('id',$id)->first();
        $bank_accounts = FinanceAccount::where('currency',$currency->id)->where('account','bank')->get();

        if ($bank_accounts->isEmpty() && $currency->isEmpty()) {
            return response()->json([]);
        }
            return response()->json(['financeAccCurrencies'=>$currency,'banks'=>$bank_accounts]);
    }


    public function searchFinanceAccount(Request $request){

        try {
        $searchTerm = $request->input('query');
          $query=FinanceAccount::query()->where('status', '=', '1')->orderBy('id', 'desc')
          ->with(['finance_currency']);
            
          if($searchTerm){
            $query->where(function ($query) use ($searchTerm) {
                $query->where('account_name', $searchTerm)
                    ->orWhere('type', 'like', '%' . $searchTerm . '%')
                    ->orWhere('currency', 'like', '%' . $searchTerm . '%')
                    ->orWhere('description', 'like', '%' . $searchTerm . '%')
                    ->orWhere('user_id', 'like', '%' . $searchTerm . '%')
                    ->orWhere('account', 'like', '%' . $searchTerm . '%')
                   ->with(['finance_currency'])->get();
            });

          }
          $expense = $query
          ->with(['finance_currency'])->get();
          if ($expense->isEmpty()) {
            return response()->json([]);
        }
          
          return response()->json($expense);
        } catch (Throwable $e) {
            return response()->json(['message'=>$e->getMessage()]);
        }
}


    
public function filterFinanceAccount(Request $request) {
   
            try {
                $limit = $request->has('limit') ? $request->limit : 10;
                $finance_type = $request->type;
                $bank_type = $request->account;
            
                $financeAcc = FinanceAccount::where('status', 1)->with(['finance_currency']);
            
                if ($finance_type != 'all') {
                    $financeAcc->where('type', '=', $finance_type);
                }
                
                if ($bank_type != 'all') {
                    $financeAcc->where('account', '=', $bank_type);
                }
            
                $totalPages = $financeAcc->paginate($limit)->lastPage();
                $result = $financeAcc->orderBy('id', 'desc')->paginate($limit);
                return response()->json(['financeAccounts' => $result, 'total_pages' => $totalPages]);

            } catch (Throwable $e) {
               return response()->json(['status'=>false,"message"=>$e->getMessage()]);
            }
}



    
}
