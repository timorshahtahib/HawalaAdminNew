<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Models\Customer;
use App\Models\Transaction;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Throwable;

class CustomerController extends Controller
{
   
    public static function new_check_number()
    {
        $last = User::orderBy('id','desc')->pluck('cu_number')->first();
        
        $new_check_number='';
        if($last){
            $number = explode("-",$last);
            $new_number  = $number[1]+1;
            $new_check_number = 'Cu-'.$new_number;
        }else{
            $new_check_number = 'Cu-1';
        }

        return $new_check_number;
    }
    public function index(Request $request)
    {
        try {
            $limit = $request->has('limit') ? $request->limit : 10;
    
            $customers = Customer::where('status', 1)->where('role','customer')
                ->orderBy('id', 'desc')
                ->paginate($limit);
    
            if ($customers->isEmpty()) {
                return response()->json([]);
            }
    
            $totalPages = $customers->lastPage();
    
            return response()->json(['customers' => $customers, 'total_pages' => $totalPages]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function DeletedCustomers(Request $request)
    {
        try {
            $limit = $request->has('limit') ? $request->limit : 10;
    
            $customers = Customer::where('status',0)->where('role','customer')
                ->orderBy('id', 'desc')
                ->paginate($limit);
    
            if ($customers->isEmpty()) {
                return response()->json([]);
            }
    
            $totalPages = $customers->lastPage();
    
            return response()->json(['customers' => $customers, 'total_pages' => $totalPages]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    
 
    public function store(Request $request)
    {

        $check_number = $this->new_check_number();

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'phone' => 'required|unique:users,phone',
            'email' => 'required|unique:users,email',
            'password'=>'required',
            'image' => 'nullable',
            'address'=>'',
            'type'=>'',
            'desc'=>'',
        ], [
            'name.required' =>'نام ضروری است',
            'phone.required'=>'شماره تماس ضروری است',
            'phone.unique'=>'شماره تماس از قبل موجود است',
            'email.required'=>'نام کاربری ضروری است',
            'email.unique'=>'نام کاربری از قبل موجود است',
            'password.required'=>'رمز عبور را وارد کنید.',
        ]);
       
        if ($validator->fails()) {
            return response()->json([
                'status'=>false,
                'error'=>$validator->errors()->toArray(),
            ]);
        }
        
        // If validation passes, proceed to store the new customer
        
        // Check for unique constraints in a try-catch block
       
      
        try {
            $transaction_values = [
                'name'=> $request->name,
                'phone'=>$request->phone,
                'email'=>$request->email,
                'password'=>Hash::make($request->password),
                'image'=>"",
                'address'=>$request->address,
                'type'=>'customer',
                'user_id'=>Auth::user()->id,
                'role' =>'customer',
             'cu_number'=> $check_number,
                'desc'=>$request->desc,
            ];

            // dd();
        
            $customer = User::create($transaction_values);
        
            return response()->json([
                'status'=>true,
                'new_data'=>$customer,
                'message'=>'عملیات انجام شد',
            ]);
        } catch (Exception $e) {
           
            return response()->json([
                'status' => false,
                'message' => 'خطا در انجام عملیات: ' . $e->getMessage(),
            ]);
        }
        
    }
    
    public function show(Customer $customer)
    {
        return response()->json($customer,200);
    }
    

    public function updateCustomer(Request $request,Customer $customer)
    {
      try {
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            // 'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:50',
            'phone' => 'required',
            'address'=>'',
            'desc'=>'',
    ],
    [
        'name' =>'نام ضروری است',
        'phone.required'=>'شماره تماس ضروری است',
    ]);
        if(!$validator->passes()){
            return response()->json([
                'status'=>false,
                'error'=>$validator->errors()->toArray(),
            ]);
        }
  
    $customer = Customer::findOrFail($request->id);
        $customer->update([
            'name' => $request->name,
            // 'image' => $request->image,
            'phone' => $request->phone,
            'address'=>$request->address,
            'desc'=>$request->desc,
        ]);
        return response()->json([ 'status'=>true,'message' => 'User update successfully!', 'Customer' => $customer], 200);
      } catch (Throwable $e) {
        return response()->json([ 'status'=>false,'message' => $e->getMessage()], 500);

      }
    }
    public function ChangeUsernameFunc(Request $request, $id){
    $customer =  Customer::where('id', $id)->where('status', 1)->first();
    if (!$customer) {
                return response()->json([]);
            }
            $validator = Validator::make($request->all(),[
                'username' => "required|unique:customer,username|max:255"
             
            ],
          [
            'username.required'=>'نام کاربری ضروری است',
            'username.unique'=>'نام کاربری ازقبل موجود است'
            
        ]);
        if(!$validator->passes()){
            return response()->json([
                'status'=>false,
                'error'=>$validator->errors()->toArray(),
            ]);
        }
    $customer->update(['username'=>$request->username]);
    $customer->save();
    return response()->json(['message' => 'Username was updated successfully'], 204);
    }

   
    public function ChangePasswordFunc(Request $request, $id){
        $customer =  Customer::where('id', $id)->where('status', 1)->first();
        if (!$customer) {
                    return response()->json([]);
                }
                $validator = Validator::make($request->all(),[
                    'password' => "required|max:255"
                 
                ],
              [
                'username.required'=>'رمز عبور ضروری است',
                
            ]);
            if(!$validator->passes()){
                return response()->json([
                    'status'=>false,
                    'error'=>$validator->errors()->toArray(),
                ]);
            }
        $customer->update(['password'=>$request->password]);
        $customer->save();
        return response()->json(['message' => 'Password was updated successfully'], 204);
        }
    public function destroy($id)
    {

    $customer = Customer::findOrFail($id);
    $customer->update(['status'=>0]);
    $customer->save();
    return response()->json(['message' => 'Customer was deleted successfully'], 204);


    }

    public function searchCustomer(Request $request){

    try {
        $searchTerm = $request->input('query');
          $query=Customer::query()->where('status', '=', '1')->orderBy('id', 'desc');
            
          if($searchTerm){
            $query->where(function ($query) use ($searchTerm) {
                $query->where('name',  'like', '%' . $searchTerm . '%')
                ->orWhere('id',  'like', '%' . $searchTerm . '%')
                    ->orWhere('cu_number',  'like', '%' . $searchTerm . '%')
                    ->orWhere('phone',  'like', '%' . $searchTerm . '%')
                    ->orWhere('address',  'like', '%' . $searchTerm . '%')
                    ->orWhere('type',  'like', '%' . $searchTerm . '%')
                    ->orWhere('desc',  'like', '%' . $searchTerm . '%')
                   ->get();
            });

          }
          $customer = $query->get();
          if ($customer->isEmpty()) {
            return response()->json([]);
        }
          
          return response()->json($customer);
        } catch (Throwable $e) {
            return response()->json(['message'=>$e->getMessage()]);
        }
        
    }

    // for getting the customer balance
    public function searchDeletedCustomer(Request $request){

        try {
            $searchTerm = $request->input('query');
              $query=Customer::query()->where('status',0)->orderBy('id', 'desc');
                
              if($searchTerm){
                $query->where(function ($query) use ($searchTerm) {
                    $query->where('name',  'like', '%' . $searchTerm . '%')
                    ->orWhere('id',  'like', '%' . $searchTerm . '%')
                        ->orWhere('cu_number',  'like', '%' . $searchTerm . '%')
                        ->orWhere('phone',  'like', '%' . $searchTerm . '%')
                        ->orWhere('address',  'like', '%' . $searchTerm . '%')
                        ->orWhere('type',  'like', '%' . $searchTerm . '%')
                        ->orWhere('desc',  'like', '%' . $searchTerm . '%')
                       ->get();
                });
    
              }
              $customer = $query->get();
              if ($customer->isEmpty()) {
                return response()->json([]);
            }
              
              return response()->json($customer);
            } catch (Throwable $e) {
                return response()->json(['message'=>$e->getMessage()]);
            }
            
        }
  




    public function getCustomerBalance($customerId) {
        $transactions = Transaction::with('eq_currency')
            ->where('ref_id', $customerId)
            ->get();
    
           
        $balances = [];
    
        foreach ($transactions as $transaction) {
            $currencyName = $transaction->eq_currency->name; // Assuming 'name' is the field in the 'currency' table
            // $amount = $transaction->amount;
            $amount = $transaction->amount_equal;
            $type = $transaction->rasid_bord; // 'credit' or 'debit'
    
            if (!isset($balances[$currencyName])) {
                $balances[$currencyName] = [
                    'rasid' => 0,
                    'bord' => 0,
                    'balance' => 0,
                ];
            }
           
            if ($type === 'rasid') {
                $balances[$currencyName]['rasid'] += $amount;
            } elseif ($type === 'bord') {
                $balances[$currencyName]['bord'] += $amount;
            }
    
            // Calculate balance
            $balances[$currencyName]['balance'] = $balances[$currencyName]['rasid'] - $balances[$currencyName]['bord'];
        }
    
        ///return response()->json($balances);
        return $balances;
    }

  
    
    public function filterCustomerExport(Request $request) {
      
                try {
                    $limit = $request->has('limit') ? $request->limit : 10;
                    $id = $request->id;
                    $typeOfExchange = $request->transaction_type;
                    $rasid_bord = $request->rasid_bord;
                    $currency = $request->currency;
               
                    $customerExportFilter = Transaction::where('status', '1')->where('ref_id',$id)->orderBy('id', 'desc');
                
                    if ($typeOfExchange!='all') {
                        
                        $customerExportFilter->where('transaction_type', $typeOfExchange);
                    }
                    if ($rasid_bord!='all') {
                        
                        $customerExportFilter->where('rasid_bord', $rasid_bord);
                    }
                
              
                    if ($currency) {
                        $customerExportFilter->where('currency',  $currency);
                    }
                  
                
            
                    $result = $customerExportFilter->with(['financeAccount','customer','tr_currency','bank_account'])->paginate($limit);

                    $totalPages = $result->lastPage();
                    return response()->json(['customerExportFilter' => $result,'total_pages' => $totalPages]);

                } catch (Throwable $e) {
                    return response()->json(['error' => $e->getMessage()], 500);
                }
    }

}
