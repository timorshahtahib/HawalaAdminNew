<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Models\Customer;
use App\Models\Transaction;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Throwable;

class CustomerController extends Controller
{
   
    public function index(Request $request)
    {
        try {
            $limit = $request->has('limit') ? $request->limit : 10;
    
            $customers = Customer::where('status', '=', '1')
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
        $validator = Validator::make($request->all(),[
                'name' => 'required',
                'last_name' => 'required',
                'cu_number'=>'',
                'phone' => 'required|unique:customer,phone',
                'username' => 'required|unique:customer,username',
                'password'=>'required',
                // 'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:50',
                'image' => 'nullable',
                'address'=>'',
                'token' => '',
                'type'=>'',
                'acount_currency'=>'',
                'desc'=>'',
                'status'=>'',
        ],
        [
            'name.required' =>'نام ضروری است',
            'last_name.required'=>'نام خانوادگی ضروری است.',
            'phone.required'=>'شماره تماس ضروری است',
            'phone.unique'=>'شماره تماس از قبل موجود است',
            'username.required'=>'نام کاربری ضروری است',
            'username.unique'=>'نام کاربری از قبل موجود است',
            'password.required'=>'رمز عبور را وارد کنید.',
        ]);
            if(!$validator->passes()){
                return response()->json([
                    'status'=>false,
                    'error'=>$validator->errors()->toArray(),
                ]);
            }
            $input = $request->all();
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $name = time().'.'.$image->getClientOriginalExtension();
                $destinationPath = public_path('/images');
                $image->move($destinationPath, $name);
                $input['image'] = $name;
            }
                $out_put = Customer::create($input);
                return response()->json([ 'status'=>true,'message' => 'User created successfully!', 'new_data' => $out_put], 201);
            
      
        
          
    }


    public function show(Customer $customer)
    {
        return response()->json($customer,200);
    }

    public function update(Request $request,Customer $customer)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'last_name' => 'required',
            'cu_number'=>'',
            'phone' => 'required',
            // 'username' => 'required',
            // 'password'=>'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:50',
            'address'=>'',
            'token' => '',
            'type'=>'',
            'acount_currency'=>'',
            'desc'=>'',
            'status'=>'',
    ],
    [
        'name.required' =>'نام ضروری است',
        'last_name.required'=>'نام خانوادگی ضروری است.',
        'phone.required'=>'شماره تماس ضروری است',
        // 'username.required'=>'نام کاربری ضروری است',
        // 'password.required'=>'رمز عبور را وارد کنید.',
    ]);
        // if(!$validator->passes()){
        //     return response()->json([
        //         'status'=>false,
        //         'error'=>$validator->errors()->toArray(),
        //     ]);
        // }else{
            $out_put = $customer->update($request->all());
            return response()->json([ 'status'=>true,'message' => 'User update successfully!', 'new_data' => $out_put], 200);
        // }
        
     
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
                ->orWhere('last_name',  'like', '%' . $searchTerm . '%')
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

  

    public function getCustomerBalance2($customerId) {
        $customer = Customer::find($customerId);
        
       
        // Fetch all transactions for the customer
        $transactions=Transaction::where('status', '=', '1')->where('ref_id',$customer->id)->get();
        
        // Calculate the balance for each currency
        $balances = [];
        foreach ($transactions as $transaction) {
            $currencyid = $transaction->currency_equal;

            // Calculate the balance based on transaction type (credit or debit)
            $amount = ($transaction->rasid_bord  == 'rasid') ? $transaction->amount_equal : -$transaction->amount_equal;
    
            if (!isset($balances[$currencyid])) {
                $balances[$currencyid] = 0;
            }
    
            $balances[$currencyid] += $amount;
        }
    
        // Return the balances as JSON
        return response()->json(['balances' => $balances]);
        
    }

    public function getCustomerBalance($customerId) {
        $customer = Customer::find($customerId);
    
        // Check if the customer exists
        if (!$customer) {
            return response()->json(['error' => 'Customer not found'], 404);
        }
    
        // Use the transactions relationship
        $transactions=Transaction::where('status', '=', '1')->where('ref_id',$customer->id)->get();
    
        // Fetch currency codes
        $currencyCodes = Currency::pluck('id', 'id');
    
        // Calculate the balance for each currency
        $balances = [];
        foreach ($transactions as $transaction) {
            $currencyId = $transaction->currency_equal;
    
            // Fetch the currency code from the $currencyCodes array
            $currencyCode = $currencyCodes[$currencyId] ?? 'Unknown';
    
            // Calculate the balance based on transaction type (credit or debit)
            $amount = ($transaction->rasid_bord  == 'rasid') ? $transaction->amount_equal : -$transaction->amount_equal;
    
            if (!isset($balances[$currencyCode])) {
                $balances[$currencyCode] = 0;
            }
    
            $balances[$currencyCode] += $amount;
        }
    
        // Return the balances as JSON
        return response()->json(['balances' => $balances]);
    }
}
