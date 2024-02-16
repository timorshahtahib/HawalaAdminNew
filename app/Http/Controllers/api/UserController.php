<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
 
    public function index(Request $request)
    {
        try {
            $limit = $request->has('limit') ? $request->limit : 10;
    
            $user = User::where('status',1)->orderBy('id', 'desc')->paginate($limit);
    
            if ($user->isEmpty()) {
                return response()->json(['کاربری برای نمایش وجود ندارد']);
            }
    
            $totalPages = $user->lastPage();
    
            return response()->json(['users' => $user, 'total_pages' => $totalPages]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
   
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);

        // return response()->json("Hello");
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateUser(Request $request,User $user)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|string|email|max:255|unique:users',
            'role' => 'required', // Fixed typo here
        ], [
            'name.required' => 'نام ضروری میباشد',
            'email.required' => 'ایمیل ضروری میباشد',
            'email.unique' => 'ایمیل از قبل موجود میباشد',
            'role.required' => 'تعین سطح دسترسی ضروری میباشد', // Fixed typo here
        ]);
       
        if ($validator->fails()) {
            return response()->json(['status' => false, 'error' => $validator->errors()->toArray()]);
        }

        $user->update($request->all());
        return response()->json($user,201);
      
    }
  



    /**
     * Remove the specified resource from storage.
     */
    public function deleteUser(Request$request)
    {
        $user = User::findOrFail($request->id);
        $user->status = $request->input('status');
        $user->update(['status'=>0]);
        return response()->json(['message' => 'User deleted successfully', 'data' => $user], 204);
    }
}
