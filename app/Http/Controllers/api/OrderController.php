<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\OrderModel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $limit = $request->has('limit') ? $request->limit : 10;
    
            $order = OrderModel::where('status', '=', '1')
                ->orderBy('id', 'desc')
                ->paginate($limit);
    
            if ($order->isEmpty()) {
                return response()->json([]);
            }
    
            $totalPages = $order->lastPage();
    
            return response()->json(['orders' => $order, 'total_pages' => $totalPages]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function getAcceptedOrder(Request $request){
        try {
            $limit = $request->has('limit') ? $request->limit : 10;
    
            $order = OrderModel::where('status', '=', '1')->where('state','done')
                ->orderBy('id', 'desc')
                ->paginate($limit);
    
            if ($order->isEmpty()) {
                return response()->json([]);
            }
    
            $totalPages = $order->lastPage();
    
            return response()->json(['orders' => $order, 'total_pages' => $totalPages]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function getPendingOrder(Request $request){
        try {
            $limit = $request->has('limit') ? $request->limit : 10;
    
            $order = OrderModel::where('status', '=', '1')->where('state','pending')
                ->orderBy('id', 'desc')
                ->paginate($limit);
    
            if ($order->isEmpty()) {
                return response()->json([]);
            }
    
            $totalPages = $order->lastPage();
    
            return response()->json(['orders' => $order, 'total_pages' => $totalPages]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getrejectedOrder(Request $request){
        try {
            $limit = $request->has('limit') ? $request->limit : 10;
    
            $order = OrderModel::where('status', '=', '1')->where('state','rejected')
                ->orderBy('id', 'desc')
                ->paginate($limit);
    
            if ($order->isEmpty()) {
                return response()->json([]);
            }
    
            $totalPages = $order->lastPage();
    
            return response()->json(['orders' => $order, 'total_pages' => $totalPages]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
     
            $input = validator::make($request->all(), [
                'customer_id' => 'required',
                'transaction_id' => 'required',
                'order_date' => 'required',
                'state' => 'required',
                'order_number' => 'required',
                'ip_address' => 'required',
                'system' => 'required',
                'phone_number' => 'required',
                'network_id' => 'required',
                'sub_category_id' => 'nullable',
                'qtt' => 'required',
                'amount' => 'required',
                'final_amount' => 'required',
                'profit_percentage' => 'required',
                'profit_amount' => 'required',
                'currency' => 'required',
                'buy_currency_id' => 'required',
                'currency_rate' => 'required',
                'buy_price' => 'required',
                'user_id' => 'required',
                'product_id' => 'required',
                'supplier_id' => 'required',
                'reject_disc' => 'required',
            ],
            [
                'customer_id.required' =>'آیدی مشتری ضروری میباشد',
                'transaction_id.required' =>'آیدی ترانزکشن ضروری میباشد',
                'order_date.required' =>'تاریخ سفارش ضروری میباشد',
                'state.required' =>'تاریخ سفارش ضروری میباشد',
                'order_number.required' =>'شماره سفارش ضروری میباشد',
                'network_id.required' =>'نتورک آیدی سفارش ضروری میباشد',
                'ip_address.required' =>'آیپی آدرس ضروری میباشد',
                'system.required' =>'نوعیت سیستم ضروری میباشد',
                'phone_number.required' =>'شماره تماس ضروری میباشد',
                'qtt.required' =>'کیو تی تی ضروری میباشد',
                'amount.required' =>'مقدار ضروری میباشد',
                'final_amount.required' =>'مقدار نهائی ضروری میباشد',
                'profit_percentage.required' =>'درصد مفاد ضروری میباشد',
                'profit_amount.required' =>'مقدار مفاد ضروری میباشد',
                'currency.required' =>'واحد پولی ضروری میباشد',
                'buy_currency_id.required' =>'آیدی واحد خریداری شده ضروری میباشد',
                'currency_rate.required' =>'نرخ ارز ضروری میباشد',
                'buy_price.required' =>'مقدار خرید ضروری میباشد',
                'user_id.required' =>'آیدی مشتری ضروری میباشد',
                'product_id.required' =>'آیدی محصول ضروری میباشد',
                'supplier_id.required' =>'آیدی تامین کننده ضروری میباشد',
                'reject_disc.required' =>'توضیحات رد شده ضروری میباشد',
            ]
        
        );
    
            if($input->fails()) {
                return response()->json([
                    'error'=>$input->errors()->toArray(),
                ]);
            }
    
            $order = OrderModel::create($request->all());
            return response()->json(['orders' => $order], 201);
        
    }


   







    /**
     * Display the specified resource.
     */
    public function show(OrderModel $order)
    {
        return response()->json($order,200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,OrderModel $order)
    {
        $input = validator::make($request->all(), [
            'customer_id' => 'required',
            'transaction_id' => 'required',
            'order_date' => 'required',
            'state' => 'required',
            'order_number' => 'required',
            'ip_address' => 'required',
            'system' => 'required',
            'phone_number' => 'required',
            'network_id' => 'required',
            'sub_category_id' => 'nullable',
            'qtt' => 'required',
            'amount' => 'required',
            'final_amount' => 'required',
            'profit_percentage' => 'required',
            'profit_amount' => 'required',
            'currency' => 'required',
            'buy_currency_id' => 'required',
            'currency_rate' => 'required',
            'buy_price' => 'required',
            'user_id' => 'required',
            'product_id' => 'required',
            'supplier_id' => 'required',
            'reject_disc' => 'required',
        ],
        [
            'customer_id.required' =>'آیدی مشتری ضروری میباشد',
            'transaction_id.required' =>'آیدی ترانزکشن ضروری میباشد',
            'order_date.required' =>'تاریخ سفارش ضروری میباشد',
            'state.required' =>'تاریخ سفارش ضروری میباشد',
            'order_number.required' =>'شماره سفارش ضروری میباشد',
            'network_id.required' =>'نتورک آیدی سفارش ضروری میباشد',
            'ip_address.required' =>'آیپی آدرس ضروری میباشد',
            'system.required' =>'نوعیت سیستم ضروری میباشد',
            'phone_number.required' =>'شماره تماس ضروری میباشد',
            'qtt.required' =>'کیو تی تی ضروری میباشد',
            'amount.required' =>'مقدار ضروری میباشد',
            'final_amount.required' =>'مقدار نهائی ضروری میباشد',
            'profit_percentage.required' =>'درصد مفاد ضروری میباشد',
            'profit_amount.required' =>'مقدار مفاد ضروری میباشد',
            'currency.required' =>'واحد پولی ضروری میباشد',
            'buy_currency_id.required' =>'آیدی واحد خریداری شده ضروری میباشد',
            'currency_rate.required' =>'نرخ ارز ضروری میباشد',
            'buy_price.required' =>'مقدار خرید ضروری میباشد',
            'user_id.required' =>'آیدی مشتری ضروری میباشد',
            'product_id.required' =>'آیدی محصول ضروری میباشد',
            'supplier_id.required' =>'آیدی تامین کننده ضروری میباشد',
            'reject_disc.required' =>'توضیحات رد شده ضروری میباشد',
        ]
    
    );

        if($input->fails()) {
            return response()->json(['errors' => $input->errors()], 400);
        }

        $order->update($request->all());
        return response()->json($order,201);
    }

    /**
     * Remove the specified resource from storage.
     */
  
    public function destroy(Request $request,$id)
    {
        $order = OrderModel::findOrFail($id);
        $order->status = $request->input('status');

        $order->update(['status'=>0]);
        return response()->json(['message' => 'Order deleted successfully', 'data' => $order], 204);
    }


    public function searchOrder(Request $request){
        $query=$request->input('query');
        $searchTerm = $request->input('query');
          $order =OrderModel::query()
          ->Where('customer_id',  'like', '%' . $searchTerm . '%')
          ->orWhere('transaction_id',  'like', '%' . $searchTerm . '%')
          ->orWhere('order_date',  'like', '%' . $searchTerm . '%')
          ->orWhere('action_date',  'like', '%' . $searchTerm . '%')
          ->orWhere('state',  'like', '%' . $searchTerm . '%')
          ->orWhere('order_number',  'like', '%' . $searchTerm . '%')
          ->orWhere('system',  'like', '%' . $searchTerm . '%')
          ->orWhere('phone_number',  'like', '%' . $searchTerm . '%')
          ->orWhere('network_id',  'like', '%' . $searchTerm . '%')
          ->orWhere('amount',  'like', '%' . $searchTerm . '%')
          ->orWhere('currency',  'like', '%' . $searchTerm . '%')
          ->orWhere('buy_currency_id',  'like', '%' . $searchTerm . '%')
          ->orWhere('buy_price',  'like', '%' . $searchTerm . '%')
          ->orWhere('user_id',  'like', '%' . $searchTerm . '%')
          ->orWhere('product_id',  'like', '%' . $searchTerm . '%')
          ->orWhere('supplier_id',  'like', '%' . $searchTerm . '%')
          ->orWhere('reject_disc',  'like', '%' . $searchTerm . '%')
          ->get();
          
          return response()->json($order);
}
}
