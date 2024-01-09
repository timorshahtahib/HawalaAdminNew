<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $user = User::all();
    
            if ($user->isEmpty()) {
                return response()->json(['error' => 'user not found'], 404);
            }
            return response()->json($user);
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
        $validated =$request->validate([
                'id'=>'required',
                'name'=>'required',
                'email'=>'required',
                'email_verified_at'=>'nullable',
                'password'=>'required',
                'remember_token'=>'nullable'
                      
        ]);
        $user = User::create($request->all());
        return response()->json($user);
      
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return response()->json($user->id,200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,User $user)
    {
    
        $validated =$request->validate([
            'id'=>'required',
            'name'=>'required',
            'email'=>'required',
            'email_verified_at'=>'nullable',
            'password'=>'required',
            'remember_token'=>'nullable'
                  
    ]);
        $user->update($request->all());
        return response()->json($user,201);
        // $user['password']= bcrypt(array_get($validated, 'password'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request,$id)
    {
        $user = User::findOrFail($id);
        $user->field_name = $request->input('status');
    
        $user->update(['status'=>0]);
        return response()->json(['message' => 'Order deleted successfully', 'data' => $user], 204);
    }
}
