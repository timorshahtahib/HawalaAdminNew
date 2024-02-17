<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Throwable;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
 
    public function index(Request $request)
    {
        try {
            $limit = $request->has('limit') ? $request->limit : 10;
    
            $user = User::where('status','=',1)->orderBy('id', 'desc')->paginate($limit);
    
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

    }

 
    public function updateUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|string|email|max:255|',
            // 'role' => 'required', // Fixed typo here
        ], [
            'name.required' => 'نام ضروری میباشد',
            'email.required' => 'ایمیل ضروری میباشد',
            
        ]);
       
        if ($validator->fails()) {
            return response()->json(['status' => false, 'error' => $validator->errors()->toArray()]);
        }

        try {
            $out_put = User::where('status','=',1)->where('id', $request->id)->update($request->all());
    
            if ($out_put) {
                $output_data = User::where('status',1)->where('id', $request->id)->get(); 
                // Change to user model
                return response()->json([
                    'status' => true,
                    'new_data' => $out_put,
                    'message' => 'اطلاعات موفقانه آپدیت شد.',
                ]);
    
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'عملیات انجام نشد',
                ]);
            }
    
        } catch (Throwable $e) {
            return response()->json($e->getMessage());
        }
      
    }
  

 

    /**
     * Remove the specified resource from storage.
     */
  


    public function deleteOneUser0(Request $request)
{
        try {
            $user = User::findOrFail($request->id);
            $user->update(['status' => 0]);
            return response()->json(['status' => true, 'message' => 'عملیات با موفقیت انجام شد']);
        } catch (Throwable $e) {
            return response()->json(['status' => false, 'message' =>$e->getMessage()]);
        }
}

        public function deleteOneUser(Request $request)
        {
            $id = $request->id;
            $user = User::where('status', '1')->where('id', $id)->first();
            
            if ($user) {
                $user->update(['status' => '0']); // Update status to 0
                $user_output = User::where('status', 1)->where('id', $id)->get();
                
                return response()->json([
                    'status' => true,
                    'user' => $user_output,
                    'message' => 'عملیات انجام شد',
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'کاربر مورد نظر یافت نشد',
                ], 404);
            }
        }



        public function searchUsers(Request $request){
            try {
                $limit = $request->has('limit') ? $request->limit : 10;

                $searchTerm = $request->input('query');
                $query = User::query()->where('status', '1')->orderBy('id', 'desc');
        
                if($searchTerm){
                    $query->where(function ($query) use ($searchTerm) {
                        $query->where('name', 'like', '%' . $searchTerm . '%')
                            ->orWhere('id', 'like', '%' . $searchTerm . '%')
                            ->orWhere('email', 'like', '%' . $searchTerm . '%')
                            ->orWhere('role', 'like', '%' . $searchTerm . '%');
                    });
                }
            
                $users = $query->paginate($limit);
                $totalPages = $users->lastPage();
    
                return response()->json(['users' => $users, 'total_pages' => $totalPages]);
             
            } catch (Throwable $e) {
                return response()->json(['message' => $e->getMessage()]);
            }
        }
        


}
