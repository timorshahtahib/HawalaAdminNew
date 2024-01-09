<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\IncomeExp;
use Exception;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
      
            try {
                $limit = $request->has('limit') ? $request->limit : 10;
                $offset = $request->has('offset') ? $request->offset : 0;
        
                $expense = IncomeExp::where('status', '=', '1')->orderBy('id', 'desc')->limit($limit)->offset($offset)->get();
        
                if ($expense->isEmpty()) {
                    return response()->json(['error' => 'Customer not found!'], 404);
                }
        
                $total_count = IncomeExp::where('status', '=', '1')->count();
                $total_pages = ceil($total_count / $limit);
        
                return response()->json(['customers' => $expense, 'total_pages' => $total_pages]);
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
