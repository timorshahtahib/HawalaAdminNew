<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Laravel\Passport\Passport;
use Throwable;

class APIController extends Controller
{

//     public function __construct()
// {
//     $this->middleware('auth:api', ['except' => ['login']]);
// }
  
public function guard()
{
    return Auth::guard();
}

public static function new_check_number()
    {
        $last = User::orderBy('id','desc')->pluck('cu_number')->first();
        
        $new_check_number='';
        if($last){
            $number = explode("-",$last);
            $new_number  = $number[1]+1;
            $new_check_number = 'AD-'.$new_number;
        }else{
            $new_check_number = 'AD-1';
        }

        return $new_check_number;
    }
public function register(Request $request)
{
    try {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|min:8|max:255',
            'role' => 'required', // Fixed typo here
        ], [
            'name.required' => 'نام ضروری میباشد',
            'email.required' => 'ایمیل ضروری میباشد',
            'email.unique' => 'ایمیل از قبل موجود میباشد',
            'password.required' => 'رمز عبور ضروری میباشد',
            'password.min' => 'رمز عبور باید بیشتر از 8 کاراکتر باشد',
            'role.required' => 'تعین سطح دسترسی ضروری میباشد', // Fixed typo here
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false,'message' => 'Error', 'error' => $validator->errors()->toArray()],402);
        }

        // dd($request->all());
        $check_number = $this->new_check_number();

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'type' => $request->role,
            'cu_number'=> $check_number,

        ]);

        return response()->json(['status' => true, 'message' => 'کاربر با موفقیت ثبت شد!', 'new_user' => $user], 200);

    } catch (Throwable $e) {
        return response()->json(['status' => false, "message"=>$e->getMessage()]);
    }
}


 
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
    
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $username = Auth::user()->name;
            // $token = $user->createToken("myToken")->accessToken;
            $token = $user->createToken("myToken")->accessToken;
    
            if ($token) {
                return response()->json([
                    "status" => true,
                    "message" => "ورود با موفقیت انجام شد",
                    "access_token" => $token,
                    'username'=>$username
                ]);
            } else {
                return response()->json([
                    "status" => false,
                    "error" => "خطا در ایجاد توکن"
                ]);
            }
        } 

    
        
        else {
            return response()->json([
                "status" => false,
                "error" => "ایمیل یا رمز عبور اشتباه است"
            ]);
        }
    }


    // public function loginCustomer(Request $request)
    // {

    //     $credentials = $request->only('username', 'password');

    // if (Auth::guard('customers')->attempt($credentials)) {
    //     $user = Auth::guard('customers')->user();
    //     $token = $user->createToken('Customer Access Token')->accessToken;
        
    //     return response()->json(['token' => $token], 200);
    // }

    // return response()->json(['message' => 'Unauthorized'], 401);
    
    //     // $validator = Validator::make($request->all(), [
    //     //     'username' => 'required',
    //     //     'password' => 'required',
    //     // ]);

    //     // if ($validator->fails()) {
    //     //     return response()->json(['error' => $validator->errors()], 422);
    //     // }

    //     // $credentials = request(['username ', 'password']);

    //     // if (Auth::guard('customer')->attempt($credentials)) {
    //     //     $customer = Auth::guard('customer');
    //     //     $accessToken = $customer->createToken('myToken')->accessToken;

    //     //     return response()->json(['access_token' => $accessToken], 200);
    //     // } else {
    //     //     return response()->json(['error' => 'Unauthenticated'], 401);
    //     // }
    // }
    public function logout(Request $request) {
        if (Auth::guard('api')->check()) {
            $accessToken = Auth::guard('api')->user()->token();
            DB::table('oauth_refresh_tokens')->where('access_token_id', $accessToken)->update(['revoked' => true]);
            $accessToken->revoke();
            return response()->json([
                'status' => false,
                'data' => 'Unauthorized',
                'message' => 'User logout successfully',
                'accessToken' => $accessToken
            ], 200);
        }
        
        return response()->json([
            'status' => false,
            'data' => 'Unauthorized'
        ],401);
    }

  
    // password forget
    public function forget_pass(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email', 'max:255'],
        ],['email.required'=>'ایمیل ضروری میباشد']);

        if ($validator->fails()) {
            return $this->sendResponse(400, $validator->errors()->first());
        }

        $token_str = str::random(64);

        try {
            //code...
            $url = env('APP_URL');
            $token = $url."reset-password/".$token_str;
            Mail::send('email.forgetPassword', ['token' => $token], function ($message) use ($request) {
                $message->to($request->email);
                $message->subject('Reset Password');
            });

            DB::table('password_resets')->insert([
                'email' => $request->email,
                'token' => $token_str,
                'created_at' => Carbon::now()
            ]);

            return $this->sendResponse(null, "success");
        } catch (\Throwable $th) {
            return $this->sendResponse(400, "لطفا با بخش پشتیبانی ما به تماس شوید");
        }
    }

    // reset password
    public function reset_pass(Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email', 'max:255'],
            'token' => ['required', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],

        ], [
            'email.required'=>'ایمیل ضروری میباشد',
            'token.required'=>'توکن ضروری میباشد',
            'passwod.required'=>'رمز عبور ضروری میباشد',
        ]);

        if ($validator->fails()) {
            return $this->sendResponse(400, $validator->errors()->first());
        }

        try {
            $updatePassword = DB::table('password_resets')->where(['email' => $request->email, 'token' => $request->token])->first();

            if(!$updatePassword){
                return $this->sendResponse(400, 'Invalid token.');
            }

            // update users password
            User::where('email', $request->email)->update(['password' => Hash::make($request->password)]);

            // delete old data from database
            DB::table('password_resets')->where(['email'=> $request->email])->delete();

            return $this->sendResponse(null, "success");
        } catch (Throwable $e) {
            return $this->sendResponse(400, "لطفا با بخش پشتیبانی ما به تماس شوید");
        }
    }


    
    
}
