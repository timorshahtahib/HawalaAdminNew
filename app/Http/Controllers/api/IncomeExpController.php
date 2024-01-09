<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\api\TransactionController;
use App\Models\Currency;
use App\Models\FinanceAccount;
use App\Models\IncomeExp;
use App\Models\Transaction;
use Exception;
use Response;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Throwable;

class IncomeExpController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        try {
            $limit = $request->has('limit') ? $request->limit : 10;
            $offset = $request->has('offset') ? $request->offset : 0;

            $IncomeExp = IncomeExp::where('status', '=', '1')->limit($limit)->with(['expense_bank','customer','expense_currency'])->orderBy('id','desc')->offset($offset)->get();
            if ($IncomeExp->isEmpty()) {
                return response()->json(['error' => 'IncomeExp not found!'], 404);
            }

            $total_count = IncomeExp::where('status', '=', '1')->count();
            $total_pages = ceil($total_count / $limit);

            return response()->json(['IncomeExpenses' => $IncomeExp, 'total_pages' => $total_pages]);
        }
        catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function showExpenses(Request $request)
    {
        try {
            $limit = $request->has('limit') ? $request->limit : 10;
            $offset = $request->has('offset') ? $request->offset : 0;

            $IncomeExp = IncomeExp::where('status', '=', '1')->where('type','expense')->with(['expense_currency','inserted_by_user','expense_acount','expense_bank'])->orderBy('id','desc')->limit($limit)->offset($offset)->get();

            if ($IncomeExp->isEmpty()) {
                return response()->json(['error' => 'Expenses not found!'], 404);
            }

            $total_count = IncomeExp::where('status', '=', '1')->where('type','expense')->count();
            $total_pages = ceil($total_count / $limit);

            return response()->json(['expenses' => $IncomeExp, 'total_pages' => $total_pages]);
        }
        catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            // 'id' => 'required|max:20',
            'type' => 'required|in:expense,income',
            'amount' => 'required',
            'currency'=>'required|max:20',
            'amount_equal' => 'nullable',
            'currency_equal' => 'nullable|max:20',
            'date'=>'required|max:20',
            'transaction_id' => 'nullable|max:20',
            'finance_acount_id'=>'required|max:20',
            'user_id' => 'required|max:200',
            'ref_type'=>'required|max:20',
            'state'=>'reqiured|in:pending,payed,unpaid',
        ],
        [
            'type.required' =>'نوعیت حساب ضروری میباشد',
            'amount.required' =>'لطفا مقداری را وارد نمائید',
            'currency.required' =>'انتخاب واحد پولی ضروری میباشد',
            'date.required' =>'لطفا تاریخ را انتخاب نمائید',
            'finance_acount_id.required' =>'فایننس اکانت آیدی ضروری میباشد',
            'user_id.required' =>'آیدی کاربر ضروری میباشد',
            'ref_type.required' =>'آیدی ریفرنس ضروری میباشد',
        ]);
       
            if(!$validator->passes()){
                return response()->json(['status'=>false,'error'=>$validator->errors()->toArray()]);
            }
                $incomeExp = IncomeExp::create($request->all());
                dd($request->all());
                return response()->json(['message' => 'incomeExp created successfully!', 'IncomeExpenses' => $incomeExp], 201);
            
      
    }

    /**
     * Display the specified resource.
     */
    public function showExpens($id)
    {
        // $expense = IncomeExp::find($id);
        $expense = IncomeExp::where('id',$id)->where('status', '=', '1')->where('type','expense')
        ->with(['expense_currency','expense_acount','expense_bank'])->first();


        // dd($expense);
        if (!$expense) {
            return response()->json(['message' => 'Expense not found'], 404);
        }

        return response()->json($expense, 200);
    }

    public function show(IncomeExp $incomeExp)
    {
        return response()->json($incomeExp,200);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,IncomeExp $incomeExp)
    {
        // $validated =$request->validate([
        //     'id' => 'required|max:20',
        //     'type' => 'reqiured|in:expense,income',
        //     'amount' => 'required',
        //     'currency'=>'required|max:20',
        //     'amount_equal' => 'nullable',
        //     'currency_equal' => 'nullable|max:20',
        //     'date'=>'required|max:20',
        //     'transaction_id' => 'nullable|max:20',
        //     'finance_acount_id'=>'required|max:20',
        //     'user_id' => 'required|max:200',
        //     'ref_type'=>'required|max:20',
        //     'state'=>'reqiured|in:pending,payed,unpaid',
        // ]);

        $incomeExp->update($request->all());
        // dd($request->all());
        return response()->json($incomeExp,201);


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request,$id)
    {
        $incomeExp = IncomeExp::findOrFail($id);
        $incomeExp->update(['status'=>0]);
        $incomeExp->save();
        return response()->json(['message' => 'Income Expense deleted successfully'], 204);
    }


    public function getFinanceAccWithCur($id)
    {
        $financeAccount = FinanceAccount::where('id',$id)->first();
        $currency = Currency::where('id',$financeAccount->currency)->first();
        // dd($financeAccount);
        $bank_acounts = FinanceAccount::where('currency',$currency->id)->where('account','bank')->get();

            return response()->json(['financeAccCurrencies'=>$currency,'banks'=>$bank_acounts]);


    }


    //////insert expense page

    public function storeExpense(Request $request){

        $validator = Validator::make($request->all(), [
                "finance_acount_id"=>"required|max:2|exists:finance_account,id",
                "amount"=>"required|max:10",
                "date"=>"required|string|max:15",
                "bank_id"=>"required|max:2|exists:finance_account,id",
                "desc"=>"required|string|max:300"
            ],
            [
                'finance_acount_id.required'=>'حساب را انتخاب کنید.',
                'finance_acount_id.exists'=>'حساب معتبر نیست',
                'bank_id.required'=>'دخل را انتخاب کنید.',
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
            try{
                ////transaction chek number generate
                $check_number = TransactionController::new_check_number();
                // dd($check_number);

                $expense_acount = FinanceAccount::where('id',$request->finance_acount_id)->first();

                $incomeExp_values = [
                    'type'=>'expense',
                    'amount'=>$request->amount,
                    'currency'=>$expense_acount->currency,
                    'date'=>$request->date,
                    'finance_acount_id'=>$expense_acount->id,
                    'bank_id'=>$request->bank_id,
                    // 'user_id'=>Auth::user()->id,
                    'user_id'=>1,
                    'state'=>'payed',
                    'ref_type'=>'expense',
                    'desc'=>$request->desc,
                ];

                $expense_id = IncomeExp::insertGetId($incomeExp_values);


                $transaction_values = [
                    'rasid_bord'=>'bord',
                    'transaction_type'=>'expense',
                    'amount'=>$request->amount,
                    'currency'=>$expense_acount->currency,
                    'ref_id'=>$expense_id,
                    'finance_acount_id'=>$expense_acount->id,
                    'bank_acount_id'=>$request->bank_id,
                    // 'user_id'=>Auth::user()->id,
                    'user_id'=>1,
                    'desc'=>$request->desc,
                    'date'=>$request->date,
                    'check_number'=>$check_number,




                ];

                $transaction_id = Transaction::insertGetId($transaction_values);



                if($transaction_id&&$expense_id){
                    $update_values = [
                        'transaction_id'=>$transaction_id,
                    ];
                    $expense_update = IncomeExp::where('id',$expense_id)->update($update_values);
                    $output_data = IncomeExp::where('id',$expense_id)->with(['expense_currency','inserted_by_user','expense_acount','expense_bank'])->first();

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

 //        dd($validator->all());
        //    $incomeExp = IncomeExp::create($request->all()); 
        //    return response()->json($incomeExp,201);
        }


       
    }


    public function updateExpense(Request $request){

        $validator = Validator::make($request->all(), [
                "id"=>"required|max:20|exists:income_expense,id",
                "finance_acount_id"=>"required|max:2|exists:finance_account,id",
                "amount"=>"required|max:10",
                "date"=>"required|string|max:15",
                "bank_id"=>"required|max:2|exists:finance_account,id",
                "desc"=>"required|string|max:300"
            ],
            [
                'id.required'=>'اطلاعات  معتبر نیست',
                'id.exists'=>'اطلاعات  معتبر نیست.',
                'finance_acount_id.required'=>'حساب را انتخاب کنید.',
                'finance_acount_id.exists'=>'حساب معتبر نیست',
                'bank_id.required'=>'دخل را انتخاب کنید.',
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
                
                $expense_acount = FinanceAccount::where('id',$request->finance_acount_id)->first();
                $expense_befor_edit = IncomeExp::where('id',$request->id)->first();
                // dd($expense_befor_edit);

                $incomeExp_values = [
                    
                    'amount'=>$request->amount,
                    'currency'=>$expense_acount->currency,
                    'date'=>$request->date,
                    'finance_acount_id'=>$expense_acount->id,
                    'bank_id'=>$request->bank_id,
                    // 'user_id'=>Auth::user()->id,
                    'user_id'=>1,
                    'state'=>'payed',
                    'ref_type'=>'expense',
                    'desc'=>$request->desc,
                ];

                $expense_update= IncomeExp::where('id',$expense_befor_edit->id)->update($incomeExp_values);


                $transaction_values = [
                    
                    'amount'=>$request->amount,
                    'currency'=>$expense_acount->currency,
                    'finance_acount_id'=>$expense_acount->id,
                    'bank_acount_id'=>$request->bank_id,
                    // 'user_id'=>Auth::user()->id,
                    'user_id'=>1,
                    'desc'=>$request->desc,
                    'date'=>$request->date,
                ];

                $transaction_update = Transaction::where('id',$expense_befor_edit->transaction_id)->update($transaction_values);



                if($transaction_update&&$expense_update){
                  
                    $output_data = IncomeExp::where('id',$expense_befor_edit->id)->with(['expense_currency','inserted_by_user','expense_acount','expense_bank'])->first();

                    DB::commit();
                    return  response()->json([
                        'status'=>true,
                        'new_data'=>$output_data,
                        'message'=>'اطلاعات موفقانه آپدیت شد.',
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
        public function showExpense(){

        }
        public function searchIncomeExpensesFunc(Request $request)
        {
            $query=$request->input('query');
            $searchTerm = $request->input('query');
              $expense =IncomeExp::query()
              ->where('status', '=', '1')->Where('type',  'like', '%' . $searchTerm . '%')
              ->orWhere('amount',  'like', '%' . $searchTerm . '%')
              ->orWhere('currency',  'like', '%' . $searchTerm . '%')
              ->orWhere('amount_equal',  'like', '%' . $searchTerm . '%')
              ->orWhere('currency_equal',  'like', '%' . $searchTerm . '%')
              ->orWhere('date',  'like', '%' . $searchTerm . '%')
              ->orWhere('transaction_id',  'like', '%' . $searchTerm . '%')
              ->orWhere('finance_acount_id',  'like', '%' . $searchTerm . '%')
              ->orWhere('bank_id',  'like', '%' . $searchTerm . '%')
              ->orWhere('user_id',  'like', '%' . $searchTerm . '%')
              ->orWhere('ref_type',  'like', '%' . $searchTerm . '%')
              ->orWhere('state',  'like', '%' . $searchTerm . '%')
              ->get();
            return response()->json($expense);
        }


// for searching all expenses
        public function searchExpensesFunc(Request $request)
        {

           
            $query=$request->input('query');
            $searchTerm = $request->input('query');
              $expense =IncomeExp::query()
              ->where('status', '=', '1')->where('type','expense')->Where('type',  'like', '%' . $searchTerm . '%')
              ->orWhere('amount',  'like', '%' . $searchTerm . '%')
              ->orWhere('currency',  'like', '%' . $searchTerm . '%')
              ->orWhere('amount_equal',  'like', '%' . $searchTerm . '%')
              ->orWhere('currency_equal',  'like', '%' . $searchTerm . '%')
              ->orWhere('date',  'like', '%' . $searchTerm . '%')
              ->orWhere('transaction_id',  'like', '%' . $searchTerm . '%')
              ->orWhere('finance_acount_id',  'like', '%' . $searchTerm . '%')
              ->orWhere('bank_id',  'like', '%' . $searchTerm . '%')
              ->orWhere('user_id',  'like', '%' . $searchTerm . '%')
              ->orWhere('ref_type',  'like', '%' . $searchTerm . '%')
              ->orWhere('state',  'like', '%' . $searchTerm . '%')->with(['expense_bank','customer','expense_currency'])
              ->get();
            return response()->json($expense);


        }

        public function deleteExpense(Request $request){
           
            $incomeExp = IncomeExp::findOrFail($request->id);
             $transaction= Transaction::findOrFail($incomeExp->transaction_id);
            $incomeExp->update(['status'=>0]);
            $transaction->update(['status'=>0]);
            $incomeExp->save();
            $transaction->save();
            return response()->json(['message' => 'Income Expense deleted successfully'], 204);
        }
        
}
