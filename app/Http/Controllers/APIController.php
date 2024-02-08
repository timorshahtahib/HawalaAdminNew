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
use Throwable;

class APIController extends Controller
{
  
    public function register(Request $request)
    {
            try {
                $validator = Validator::make($request->all(), [
                    'name' => 'required|string',
                    'email' => 'required|string|email|max:255|unique:users',
                    'password' =>'required|min:8|max:255',
                   ],
                   [
                    'name.required' => 'نام ضروری میباشد',
                    'email.required' => 'ایمیل ضروری میباشد',
                    'email.unique' => 'ایمیل از قبل موجود میباشد',
                    'password.required' => 'رمز عبور ضروری میباشد',
                    'password.min' => 'رمز عبور باید بیشتر از8 کاراکتر باشد',
                ]
                );
            
                if (!$validator->passes()) {
                    return response()->json(['status'=>false,'error'=>$validator->errors()->toArray()]);
                }
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                ]);
            
                return response()->json(['status'=>true,'message'=>'کاربر با موفقیت ثبت شد!'],200);
            
            } catch (Throwable $e) {
                return response()->json(['status'=>false,$e->getMessage()]);
            }

    }


    public function login0(Request $request){

        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:250',
            'password' => 'required|max:250',
        ],
        [
            'email.required'=>'ایمیل ضروری میباشد',
            'password.required'=>'رمز عبور ضروری میباشد',
        ]);
    
        if (!$validator->passes()) {
            return response()->json(['status'=>false,'error'=>$validator->errors()->toArray()]);
        }
    
        // Attempt to authenticate the user
        if(Auth::attempt([
            "email" => $request->email,
            "password" => $request->password
        ])){
    
            $user = Auth::user();
            $token = $user->createToken("myToken")->accessToken;
    
            return response()->json([
                "status" => true,
                'user_name'=>$user->name,
                "message" => "ورود با موفقیت انجام شد",
                "access_token" => $token
            ]);
        } else {
            // Authentication failed, return error message
            return response()->json([
                "status" => false,
                "error" => "ایمیل یا رمز عبور اشتباه است"
            ]);
        }
    }


    public function login(Request $request){
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken("myToken")->accessToken;

            return response()->json([
                "status" => true,
                "user_name" => $user->name,
                "message" => "ورود با موفقیت انجام شد",
                "access_token" => $token
            ]);
        } else {
            return response()->json([
                "status" => false,
                "error" => "ایمیل یا رمز عبور اشتباه است"
            ]);
        }
    }
    public function login2(Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:250',
            'password' => 'required|max:250',
        ], [
            'email.required' => 'ایمیل ضروری می‌باشد',
            'password.required' => 'رمز عبور ضروری می‌باشد',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['status' => false, 'error' => $validator->$request->toArray()], 422);
        }
    
        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();
            $token = $user->createToken('myToken')->accessToken;
    
            return response()->json([
                'status' => true,
                'user_name' => $user->name,
                'message' => 'ورود با موفقیت انجام شد',
                'access_token' => $token,
            ]);
        } else {
            return response()->json([
                'status' => false,
                'error' => 'ایمیل یا رمز عبور اشتباه است',
            ], 401);
        }
    }
    
    public function login1(Request $request) {

        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:250',
            'password' => 'required|max:250',
        ],
        [
            'email.required'=>'ایمیل ضروری میباشد',
            'password.required'=>'رمز عبور ضروری میباشد',
        ]);
    
        if (!$validator->passes()) {
            return response()->json(['status'=>false,'error'=>$validator->errors()->toArray()]);
        }
    
        // Attempt to authenticate the user
        if(Auth::attempt([
            "email" => $request->email,
            "password" => $request->password
        ])){
    
            $user = Auth::user();
            // Revoke existing tokens to ensure only one token is active per user
            $user->tokens->each(function ($token, $key) {
                $token->delete();
            });
            // $this->logout($request);
            // Create new token for the authenticated user
            $token = $user->createToken("myToken")->accessToken;
    
            return response()->json([
                "status" => true,
                'user_name'=>$user->name,
                "message" => "ورود با موفقیت انجام شد",
                "access_token" => $token
            ]);
        } else {
            // Authentication failed, return error message
            return response()->json([
                "status" => false,
                "error" => "ایمیل یا رمز عبور اشتباه است"
            ]);
        }
    }
public function logout(Request $request)
{
    // Check if the user is authenticated
    if (Auth::check()) {
        // Revoke the user's token
        $request->user()->token()->revoke();
    
        return response()->json(['status'=>true,'message' => '!خروج با موفقیت انجام شد'], 200);
    } else {
        // User is not authenticated, return error response
        $response = ['error' => 'شما هنوز وارد نشده‌اید!'];
        return response()->json($response, 401);
    }
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
