<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\OrderModel;
use App\Models\Transaction;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Morilog\Jalali\Jalalian;

class myHomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function showIndexPage(Request $request)
    {
        $date = Jalalian::now();
        $today_date = $date->getYear() ."/" .$date->getMonth() ."/" .$date->getDay();
        $account_name = Auth::user()->id;
        
        try {
            $customers = Customer::where('status',1)->count();
            $deleted_customers = Customer::where('status',0)->count();
        
            $users = User::where('status', 1)->count();
             // get today transactions 
            $allTransaction = Transaction::where('status', 1)->count();
            $lastTenTransactions = Transaction::orderBy('created_at', 'desc')->with(['financeAccount', 'customer', 'tr_currency','eq_currency', 'bank_account'])->take(10)->get();
            $deletdTransaction = Transaction::where('status', 0)->count();
            $todayTransaction = Transaction::where('status', 1)->whereDate('date',$today_date)->count();

            $allOrders = OrderModel::where('status', 1)->count();
             // get accepted orders
            $acceptedOrders = OrderModel::where('status', 1)->where('state','done')->count();
             // get pending orders
            $pendingOrders = OrderModel::where('status', 1)->where('state','pending')->count();
            $rejectedOrders = OrderModel::where('status', 1)->where('state','rejected')->count();

             return response()->json(['customers'=>$customers,'deleted_customers'=>$deleted_customers,'users'=>$users,
             'all_transactions'=>$allTransaction,'deleted_transactions'=>$deletdTransaction,
             'today_transactions' =>$todayTransaction,'all_orders'=>$allOrders,
             'accept_orders'=>$acceptedOrders ,'rejected_orders'=>$rejectedOrders,'pending_orders'=> $pendingOrders,'transactions'=>$lastTenTransactions,'user_name'=>$account_name]);
          
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
      }
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
