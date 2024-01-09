<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CurrencyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $limit = $request->has('limit') ? $request->limit : 10;
            $offset = $request->has('offset') ? $request->offset : 0;
    
            $currency = Currency::where('status', '=', '1')->orderBy('id', 'desc')->limit($limit)->offset($offset)->get();
    
            if ($currency->isEmpty()) {
                return response()->json(['error' => 'currency not found!'], 404);
            }
    
            $total_count = Currency::where('status', '=', '1')->count();
            $total_pages = ceil($total_count / $limit);
    
            return response()->json(['currencies' => $currency, 'total_pages' => $total_pages]);
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
             try{
                $validator = Validator::make($request->all(), [
                    'name' => 'required|max:20|unique:currency,name,id ',
                    'sign' => 'required|max:10|unique:currency,sign,id',

                ],
                [
                    'name.required' =>'نام ضروری است',
                    'name.unique'=>'نام واحد پولی از قبل موجود است',
                    'sign.required'=>'نشان واحد ضروری است',
                    'sign.unique'=>'نشان واحد از قبل موجود است',

                ]
            
            );
        
                if(!$validator->passes()){
                    return response()->json([
                        'status'=>false,
                        'error'=>$validator->errors()->toArray(),
                    ]);
                }
        
                $currency = new Currency();
                $currency->name = $request->input('name');
                $currency->sign = $request->input('sign');
                $currency->save();
        
                return response()->json([
                    'message' => 'Successfully created currency!',
                    'currency' => $currency
                ], 201);
            }
            catch (Exception $e) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
    }

    /**
     * Display the specified resource.
     */
    public function show(Currency $currency)
    {
        return response()->json($currency,200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,Currency $currency)
    {
        // $validated =$request->validate([
        //     'name' => 'required|max:20',
        //     'sign' => 'nullable | 1',
        // ]);
        $currency->update($request->all());
        return response()->json($currency,201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request,$id)
    {
        $currency = Currency::findOrFail($id);
        $currency->status = $request->input('status');
    
        $currency->update(['status'=>0]);
        return response()->json(['message' => 'Currency deleted successfully', 'data' => $currency], 204);
    }


    public function searchCurrency(Request $request){
        $query=$request->input('query');
        $searchTerm = $request->input('query');
          $currency =Currency::query()
          ->Where('name',  'like', '%' . $searchTerm . '%')
          ->orWhere('sign',  'like', '%' . $searchTerm . '%')->get();
          
          return response()->json($currency);
}
   
}
