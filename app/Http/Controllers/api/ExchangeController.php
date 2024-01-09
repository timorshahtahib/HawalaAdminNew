<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Throwable;

class ExchangeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $transaction = Transaction::where('status', '=', '1')->where('transaction_type','exchange')->with(['financeAccount','customer','tr_currency','bank_account'])->orderBy('id','desc')->get();

            if ($transaction->isEmpty()) {
                return response()->json(['error' => 'Transaction not found'], 404);
            }
            return response()->json($transaction);
        }
        catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    // for generating hawal id 
    public static function new_check_number()
    {
        $last = Transaction::orderBy('id','desc')->pluck('check_number')->first();
        
        $new_check_number='';
        if($last){
            $number = explode("-",$last);
            $new_number  = $number[1]+1;
            $new_check_number = 'Hawala-'.$new_number;
        }else{
            $new_check_number = 'Hawala-1';
        }

        return $new_check_number;
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    { 
        $check_number = $this->new_check_number();
        $validator =Validator::make($request->all(),[
            'transaction_type'=>'exchange',
            'rasid_amount'=>'required',
            'currency'=>'required',
            'amount_equal'=>'nullable',
            'currency_equal'=>'nullable',
            'currency_rate'=>'required',
            // 'ref_id'=>"required|max:20",
            'order_id'=>'nullable',
            'rasid_bank_acount_id'=>'required',
            'bord_bank_acount_id'=>'required',
            'desc'=>'nullable',
            'status'=>'',

        ]);
        
        if(!$validator->passes()){
            return response()->json([
                'status'=>false,
                'error'=>$validator->errors()->toArray(),
            ]);
        }else{
        
            DB::beginTransaction();
            try{
                ////transaction chek number generate
                $check_number = TransactionController::new_check_number();

                $transaction_values = [
                    'rasid_bord'=> 'rasid',
                    'transaction_type'=>'exchange',
                    'amount'=>$request->rasid_amount,
                    'currency'=>$request->currency,
                    'finance_acount_id'=>25,
                    'bank_acount_id'=>$request->rasid_bank_acount_id,
                    'amount_equal'=>$request->amount,
                    'currency_equal'=>$request->currency,
                    'currency_rate'=>$request->currency_rate,
                    'desc'=>$request->desc,
                    'date'=>$request->date,
                    'check_number'=>$check_number,
                    
                ];
             
                $transaction_id = Transaction::insertGetId($transaction_values);
                $check_number2 = TransactionController::new_check_number();
                $transaction_values2 = [
                    'rasid_bord'=> 'bord',
                    'transaction_type'=>'exchange',
                    'amount'=>$request->amount_equal,
                    'currency'=>$request->currency_equal,
                    'finance_acount_id'=>25,
                    'bank_acount_id'=>$request->bord_bank_acount_id,
                    'amount_equal'=>$request->amount_equal,
                    'currency_equal'=>$request->currency_equal,
                    'currency_rate'=>$request->currency_rate,
                    'desc'=>$request->desc,
                    'date'=>$request->date,
                    'check_number'=>$check_number2,
                    
                ];
                $transaction_id2 = Transaction::insertGetId($transaction_values2);

                if($transaction_id && $transaction_id2 ){

                    $update_values1 = [
                        'order_id'=>$transaction_id2,
                    ];
                    $update_values2 = [
                        'order_id'=>$transaction_id,
                    ];
                    Transaction::where('id',$transaction_id)->update($update_values1);
                    Transaction::where('id',$transaction_id2)->update($update_values2);

                    $update_values = ['transaction_id'=>$transaction_id,];
                    $update_values2 = ['transaction_id2'=>$transaction_id2,];
                 
                    $output_data = Transaction::where('id',$transaction_id)->with(['financeAccount','customer_exchange','tr_currency','bank_account'])->first();
                    $output_data2 = Transaction::where('id',$transaction_id2)->with(['financeAccount','customer_exchange','tr_currency','bank_account'])->first();

                    DB::commit();
                    return  response()->json([
                        'status'=>true,
                        'new_data1'=>$output_data,
                        'new_data2'=>$output_data2,
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
    public function show($id)
    {
        try {
            $transaction = Transaction::where('status', '=', '1')->where('id','=',$id)->where('rasid_bord','rasid')->with(['financeAccount','customer','tr_currency','bank_account'])->get();;

            if ($transaction->isEmpty()) {
                return response()->json(['error' => 'Transaction not found'], 404);
            }
            return response()->json($transaction);
        }
        catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function getExchangeforEdit(Request $request)
    {
        $tr_type=$request->rasid_bord;
        $id=$request->id;
            try {
                if($tr_type ==='rasid'){
                    $rasid_transaction = Transaction::where('status', '=', '1')->where('id',$id)->where('transaction_type','exchange')
                    ->where('rasid_bord','rasid')
                    ->with(['financeAccount','customer','tr_currency','bank_account'])->first();
           
                    $bord_transaction = Transaction::where('status', '=', '1')->where('id',$rasid_transaction->order_id)->where('transaction_type','exchange')
                    ->where('rasid_bord','bord')
                    ->with(['financeAccount','customer','tr_currency','bank_account'])->first();
           

                    return response()->json(['bord'=>$bord_transaction,'rasid'=>$rasid_transaction]);
               }
               else if($tr_type ==='bord'){
                   $bord_transaction = Transaction::where('status', '=', '1')->where('id',$id)->where('transaction_type','exchange')
                   ->where('rasid_bord','bord')
                   ->with(['financeAccount','customer','tr_currency','bank_account'])->first();
                   $rasid_transaction = Transaction::where('status', '=', '1')->where('id',$bord_transaction->order_id)->where('transaction_type','exchange')
                   ->where('rasid_bord','rasid')
                   ->with(['financeAccount','customer','tr_currency','bank_account'])->first();
                   return response()->json(['bord'=>$bord_transaction,'rasid'=>$rasid_transaction]);
               }
            } catch (Throwable $e) {
                return response()->json(['message'=>$e->getMessage()]);
            }
         
    }
    

    public function updateBuyExchangeTransaction(Request $request)
    { 
        $validator =Validator::make($request->all(),[
            'rasid_id'=>'required',
            'rasid_amount'=>'required',
            'rasid_currency'=>'required',
            'rasid_bank_acount_id'=>'required',

            'bord_id'=>'required',
            'bord_amount'=>'required',
            'bord_currency'=>'required',
            'bord_bank_acount_id'=>'required',
           
            'desc'=>'nullable',
            'date'=>'required',
            'currency_rate'=>'required',
        ]);
        
        if(!$validator->passes()){
            return response()->json([
                'status'=>false,
                'error'=>$validator->errors()->toArray(),
            ]);
        }else {
            $tr_rasidv = [
            
                'amount'=>$request->rasid_amount,
                'currency'=>$request->rasid_currency,
                'bank_acount_id'=>$request->rasid_bank_acount_id,
                'desc'=>$request->desc,
                'date'=>$request->date,
                'currency_rate'=>$request->currency_rate,
            ];
            $tr_bordv = [
                'amount'=>$request->bord_amount,
                'currency'=>$request->bord_currency,
                'bank_acount_id'=>$request->bord_bank_acount_id,
                'desc'=>$request->desc,
                'date'=>$request->date,
                'currency_rate'=>$request->currency_rate,
            ];

            DB::beginTransaction();
            try{
                
               $tr_rasid= Transaction::where('id',$request->rasid_id)->update($tr_rasidv);
               $tr_bord= Transaction::where('id',$request->bord_id)->update($tr_bordv);


               if($tr_rasid && $tr_bord){

                $output_data = Transaction::where('id',$request->rasid_id)->with(['financeAccount','customer_exchange','tr_currency','bank_account'])->first();
                $output_data2 = Transaction::where('id',$request->bord_id)->with(['financeAccount','customer_exchange','tr_currency','bank_account'])->first();
                DB::commit();
                return  response()->json([
                    'status'=>true,
                    'rasid'=>$output_data,
                    'bord'=>$output_data2,
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
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request,$id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->status = $request->input('status');

        $transaction->update(['status'=>0]);
        return response()->json(['message' => 'Transaction deleted successfully', 'data' => $transaction], 204);
    }
}
