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



class APIController extends Controller
{
  
    public function register(Request $request)
    {
       $validator = Validator::make($request->all(), [
        'name' => 'required|string',
        'email' => 'required|string|email|max:255|unique:users',
        'password' =>'required|min:8|max:255',
       ],
       [
        'name.required' => 'نام ضروری میباشد',
        'email.required' => 'ایمیل ضروری میباشد',
        'password.required' => 'رمز عبور ضروری میباشد',
    ]
    );

    if ($validator->fails()) {
        return response()->json(['status'=>false,$validator->errors()->toArray()], 403);
    }
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
    ]);

    return response()->json(['status'=>true,'message'=>'کاربر با موفقیت ثبت شد!']);

    // if ($user) {
    //     return response()->json($user, "success");
    // }
    }

    public function login(Request $request){

        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:250',
            'password' => 'required|max:250',
        ],
        ['email.required'=>'نام کاربری ضروری میباشد',
        'password.required'=>'رمز عبور ضروری میباشد'
        ]
        );

        if ($validator->fails()) {
            return response()->json(
                [
                'status'=>false,
                'error'=>$validator->errors()->toArray()]
            );
        }

        // Auth Facade
        if(Auth::attempt([
            "email" => $request->email,
            "password" => $request->password
        ])){

            $user = Auth::user();
            $token = $user->createToken("myToken")->accessToken;

            return response()->json([
                "status" => true,
                "message" => "ورود با موفقیت انجام شد",
                "access_token" => $token
            ]);
        }

        return response()->json([
            "status" => false,
            "message" => "رمز عبور و ایمیل مطابقت ندارد"
        ]);
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
        } catch (\Throwable $th) {
            return $this->sendResponse(400, "لطفا با بخش پشتیبانی ما به تماس شوید");
        }
    }


    
    
}
