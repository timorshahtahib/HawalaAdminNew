<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Models\Customer;
use App\Models\FinanceAccount;
use App\Models\Transaction;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Throwable;

class TransactionController extends Controller
{

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
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $limit = $request->has('limit') ? $request->limit : 10;

            $transaction = Transaction::where('status', '=', '1')
            ->with(['financeAccount','customer','tr_currency','bank_account','referencedTransaction'])->orderBy('id','desc')
            ->paginate($limit);

            if ($transaction->isEmpty()) {
                return response()->json(['error' => 'Transaction not found'], 404);
            }
            $total_pages= $transaction->lastPage();
            return response()->json(['transactions' =>$transaction,'total_pages'=>$transaction]);
        }
        catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
      
    }

    // select all transaction that have the ref_id = customer id in the profile page
        public function getCustomerInfo(Request $request){
           
                try {
                    $id = $request->id;
                    $limit = $request->has('limit') ? $request->limit : 10;

                    $transaction_rasid_bord = Transaction::where('status', '=', '1')->where('ref_id',$id)
                    ->with(['financeAccount','tr_currency','bank_account','referencedTransaction'])->paginate($limit);
                    $customer = Customer::where('id',$id)->paginate($limit);
                    $transaction_order = Transaction::where('status', '=', '1')
                    ->where('ref_id',$id)->where('transaction_type','order')->with(['financeAccount','tr_currency','bank_account','referencedTransaction','referencedTransaction'])->paginate($limit);
                
                    $rasid=Transaction::where('status', '=', '1')->where('ref_id',$id)->sum('amount');
                    $bord=Transaction::where('status', '=', '1')->where('ref_id',$id)->sum('amount_equal');
                    $totalAmount = $rasid - $bord;

                    if($transaction_rasid_bord->isEmpty()){
                        return response()->json([]);
                    }
                    $total_pages= $transaction_rasid_bord->lastPage();
                    return response()->json(['customer'=>$customer,'transactions'=>$transaction_rasid_bord,'orders'=>$transaction_order,'rasid'=> $rasid,'bord'=>$bord,'total_amount'=>$totalAmount,'total_pages'=>$total_pages]);
                      
                } catch (Throwable $e) {
                  return response()->json(['message'=>$e->getMessage()]);
                }
        }

     


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $check_number = $this->new_check_number();
        $validator =Validator::make($request->all(),[
            'rasid_bord'=>'required|in:rasid,bord',
            'amount'=>'required',
            'currency'=>'required',
            'amount_equal'=>'required',
            'currency_equal'=>'required',
            'currency_rate'=>'required',
            'ref_id'=>"required|max:20|exists:customer,id",
            'bank_acount_id'=>'required',
            'desc'=>'nullable'
           

        ]);
        
        if(!$validator->passes()){
            return response()->json([
                'error'=>$validator->errors()->toArray(),
            ]);
        }else{
        
            DB::beginTransaction();
            try{
                ////transaction chek number generate
                $check_number = TransactionController::new_check_number();
                // dd($check_number);

                $transaction_values = [
                    'rasid_bord'=> $request->rasid_bord,
                    'transaction_type'=>'rasid_bord',
                    'amount'=>$request->amount,
                    'currency'=>$request->currency,
                    'finance_acount_id'=>24,
                    // 'finance_acount_id'=>$request->finance_acount_id,
                    'bank_acount_id'=>$request->bank_acount_id,
                    'amount_equal'=>$request->amount_equal,
                    'currency_equal'=>$request->currency_equal,
                    'currency_rate'=>$request->currency_rate,
                    'ref_id'=>$request->ref_id,
                    // 'user_id'=>Auth::user()->id,
                    'user_id'=>1,
                    'desc'=>$request->desc,
                    'date'=>$request->date,
                    'check_number'=>$check_number,
                    
                ];

                $transaction_id = Transaction::insertGetId($transaction_values);

                if($transaction_id){
                    $update_values = ['transaction_id'=>$transaction_id,];
                 
                    $output_data = Transaction::where('id',$transaction_id)->with(['financeAccount','customer','tr_currency','bank_account'])->first();

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
    public function show($id)
    {
        try {
            $transaction = Transaction::where('id','=',$id)->where('status', '=', '1')->with(['financeAccount','customer','tr_currency','bank_account'])->get();

            if ($transaction->isEmpty()) {
                return response()->json([]);
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
    public function update(Request $request,Transaction $transaction)
    {
        $validator =Validator::make($request->all(),[
            'id'=>'required|20',
            'rasid_bord'=>'in:rasid,bord',
            'transaction_type'=>'required',
            'amount'=>'required',
            'currency'=>'required',
            'amount_equal'=>'nullable',
            'currency_equal'=>'nullable',
            'currency_rate'=>'required',
            'ref_id'=>'required',
            'finance_acount_id'=>'required',
            'bank_acount_id'=>'nullable',
            'user_id'=>'required',
            'desc'=>'nullable',
            'status'=>'',

        ]);
        if(!$validator->passes()){
            return response()->json([
                'status'=>false,
                'error'=>$validator->errors()->toArray(),
            ]);
        }
        else{
            DB::beginTransaction();
            $transaction_values = [
                'rasid_bord'=> $request->rasid_bord,
                'amount'=>$request->amount,
                'currency'=>$request->currency,
                'bank_acount_id'=>$request->bank_id,
                'amount_equal'=>$request->amount_equal,
                'currency_equal'=>$request->currency_equal,
                'currency_rate'=>$request->currency_rate,
                'ref_id'=>$request->ref_id,
                // 'user_id'=>Auth::user()->id,
                'user_id'=>1,
                'desc'=>$request->desc,
                'date'=>$request->date,
            
            ];
            $transaction_update = Transaction::where('id',$request->id)->update($transaction_values);
            if($transaction_update){
              
                $output_data = Transaction::where('id',$request->id)->with(['financeAccount','customer','tr_currency','bank_account','referencedTransaction'])->first();

                DB::commit();
                return  response()->json([
                    'status'=>true,
                    'new_data'=>$output_data,
                    'message'=>'اطلاعات موفقانه ویرایش شد.',
                ]);

            }else{
                DB::rollback();
                return  response()->json([
                    'status'=>false,
                    'message'=>'عملیات انجام نشد',
                ]);
            }
            // $transaction->update($request->all());
            
        }

    }

    public function updateTransaction(Request $request){
        $validator = Validator::make($request->all(), [
            "id"=>"required|max:20|exists:transaction,id",
            'rasid_bord'=>'in:rasid,bord',
            'amount'=>'required',
            'currency'=>'required',
            'amount_equal'=>'nullable',
            'currency_equal'=>'nullable',
            'currency_rate'=>'required',
            'ref_id'=>'required',
            'bank_acount_id'=>'nullable',
            'desc'=>'nullable',
            'status'=>'',
        ],
        [
            'id.required'=>'اطلاعات  معتبر نیست',
            'id.exists'=>'اطلاعات  معتبر نیست.',
            'rasid_bord.required'=>'نوع معامله را انتخاب کنید',
            'ref_id.required'=>'نام مشتری را انتخاب کنید.',
            'bank_id.required'=>'دخل را انتخاب کنید.',
            'currency.required'=>'واحد را انتخاب کنید.',
            'currency_rate.required'=>'نرخ واحد را انتخاب کنید.',
            'currency_equal.required'=>'واحد رسید را انتخاب کنید.',
            'amount_equal.required'=>'مقدار رسید را انتخاب کنید.',
            'bank_id.exists'=>'دخل معتبر نیست',
            'amount.required'=>'مبلغ را وارد کنید.',
            'amount.max'=>'تعداد ارقام باید کمتر از 10 باشد',
            'date.required'=>'تاریخ را وارد کنید',
            'date.max'=>'تاریخ معتبر نیست',
            'desc.required'=>'توضیحات را وارد کنید',
            'desc.max'=>'توضیحات نباید بیشتر از 300 حرف باشد',
        ]
    );

    if(!$validator->passes()){
        return response()->json([
            'status'=>false,
            'error'=>$validator->errors()->toArray(),
        ]);
    }else{
        DB::beginTransaction();


        // dd($request);
        try{
            ////transaction chek number generate
            // $check_number = TransactionController::new_check_number();
        
                $transaction_values = [
                'rasid_bord'=> $request->rasid_bord,
                'amount'=>$request->amount,
                'currency'=>$request->currency,
                'bank_acount_id'=>$request->bank_id,
                'amount_equal'=>$request->amount_equal,
                'currency_equal'=>$request->currency_equal,
                'currency_rate'=>$request->currency_rate,
                'ref_id'=>$request->ref_id,
                // 'user_id'=>Auth::user()->id,
                'user_id'=>1,
                'desc'=>$request->desc,
                'date'=>$request->date,
            
            ];

            $transaction_update = Transaction::where('id',$request->id)->update($transaction_values);



            if($transaction_update){
              
                $output_data = Transaction::where('id',$request->id)->with(['financeAccount','customer','tr_currency','bank_account'])->first();

                DB::commit();
                return  response()->json([
                    'status'=>true,
                    'new_data'=>$output_data,
                    'message'=>'اطلاعات موفقانه ویرایش شد.',
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
    

   

    public function getSearchTransactions(Request $request) {
        
        try {
            $searchTerm = $request->input('query');
    
            $transaction = Transaction::query()->where('status', '=', '1')->where
            (function ($query) {
                $query->where('rasid_bord', 'rasid')->orWhere('rasid_bord', 'bord');
            });
    
            if ($searchTerm) {
                $transaction->where(function ($query) use ($searchTerm) {
                    $query->whereHas('customer', function ($query) use ($searchTerm) {
                        $query->where('name', 'like', '%' . $searchTerm . '%');
                    })
                    ->orWhereHas('financeAccount', function ($query) use ($searchTerm) {
                        $query->where('account_name', 'like', '%' . $searchTerm . '%');
                    })
                    ->orWhereHas('tr_currency', function ($query) use ($searchTerm) {
                        $query->where('name', 'like', '%' . $searchTerm . '%');
                    })
                    ->orWhere('id', 'like', '%' . $searchTerm . '%')
                    ->orWhere('rasid_bord', 'like', '%' . $searchTerm . '%')
                    ->orWhere('check_number', 'like', '%' . $searchTerm . '%')
                    ->orWhere('amount', 'like', '%' . $searchTerm . '%')
                    ->orWhere('amount_equal', 'like', '%' . $searchTerm . '%')
                    ->orWhere('currency_equal', 'like', '%' . $searchTerm . '%')
                    ->orWhere('currency_rate', 'like', '%' . $searchTerm . '%')
                    ->orWhere('currency', 'like', '%' . $searchTerm . '%')
                    ->orWhere('bank_acount_id', 'like', '%' . $searchTerm . '%')
                    ->orWhere('desc', 'like', '%' . $searchTerm . '%');
                });
            }
    
            $transactions = $transaction->with(['financeAccount', 'customer', 'tr_currency', 'bank_account'])
                ->orderBy('id', 'desc')
                ->get();
    
            if ($transactions->isEmpty()) {
                return response()->json([]);
            }
    
            return response()->json($transactions);
        } catch (Throwable $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }
    

    public function getCustomerInfoSearch(Request $request,$id){
        $query=$request->input('query');

        $searchTerm = $request->input('query');

        $transaction = Transaction::query()->where('status', '=', '1')
            ->whereHas('customer', function ($query) use ($searchTerm) {
                $query->where('name', 'like', '%' . $searchTerm . '%');
            })
            ->orWhereHas('financeAccount', function ($query) use ($searchTerm) {
                $query->where('account_name', 'like', '%' . $searchTerm . '%');
            })
            ->orWhereHas('tr_currency', function ($query) use ($searchTerm) {
                $query->where('name', 'like', '%' . $searchTerm . '%');
            })
            ->where('ref_id','=',$id)
            ->orWhere('amount',  'like', '%' . $searchTerm . '%')
            ->orWhere('amount_equal',  'like', '%' . $searchTerm . '%')
            ->orWhere('currency_equal',  'like', '%' . $searchTerm . '%')
            ->orWhere('currency_rate',  'like', '%' . $searchTerm . '%')
            
            ->with(['financeAccount','customer','tr_currency','bank_account'])->orderBy('id','desc')
            ->get();
       
       
       
        return response()->json($transaction);
    }
    


}
