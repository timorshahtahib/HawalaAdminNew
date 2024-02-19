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


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
                'name' => 'required',
                'cu_number'=>'',
                'phone' => 'required|unique:users,phone',
                'email' => 'required|unique:users,email',
                'password'=>'required',
                // 'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:50',
                'image' => 'nullable',
                'address'=>'',
                'token' => '',
                'type'=>'',
                'acount_currency'=>'',
                'desc'=>'',
                'status'=>'1',
        ],
        [
            'name.required' =>'نام ضروری است',
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
         
                return response()->json([ 'status'=>true,'message' => 'User created successfully!'], 201);
            
          
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
            $out_put = User::where('status','=',1)->where('id', $request->id)->update([
                'name' => $request->name,
                'email' => $request->email,
                'role' => $request->role
            ]);
    
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

     

        public function deleteOneUser(Request $request)
        {
            $id = $request->id;
            $user = User::find($id);
    
            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'User not found'
                ]);
            }
    
            $user->status = 0;
            // $user->update(['status' => '0']); 
            $user->save();
    
            return response()->json([
                'status' => true,
                'message' => 'User deleted successfully'
            ],204);
        }

        public function searchUsers0(Request $request){
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
        

        public function searchUsers(Request $request)
        {
            $query=$request->input('query');
            $searchTerm = $request->input('query');
              $user =User::query()
              ->where('status', '=', '1')->Where('id',  'like', '%' . $searchTerm . '%')
              ->orWhere('name',  'like', '%' . $searchTerm . '%')
              ->orWhere('email',  'like', '%' . $searchTerm . '%')
              ->orWhere('role',  'like', '%' . $searchTerm . '%')
              ->get();
            return response()->json($user);
        }


}
