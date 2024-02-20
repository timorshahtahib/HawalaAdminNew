<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Throwable;

class deleteTransaction extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
  
    public function deleteTransaction(Request $request)
    {
       
        try {
            $id = $request->id;
            $transaction = Transaction::findOrFail($id);
            $transaction->update(['status'=>0]);
            return response()->json(['message' => 'Transaction deleted successfully', 'data' => $transaction], 204);
        } catch (Throwable $e) {
            return response()->json(['message'=>$e->getMessage()]);
        }
    }
}
