<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class APIController extends Controller
{
    public function sendError($error, $errorMessages = [], $code = 404)
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];

        if (!empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }
        return response()->json($response, $code);
    }

    public function sendResponse($result, $message)
    {
        $response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ];
        return response()->json($response, 200);
    }

    // custom login
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:250',
            'password' => 'required|max:250',
        ],
        ['email.required'=>'نام کاربری ضروری میباشد',
        'password.required'=>'رمز عبور ضروری میباشد'
        ]
    );

        if ($validator->fails()) {
            return $this->sendResponse(400, $validator->errors()->first());
        }
// After successful login in your login method
     
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $user = User::where('email', $request->email)->first();
            $refreshToken = Str::random(60); // Generate a random refresh token
            $user->remember_token = Hash::make($refreshToken);
            $user->refresh_token_expiry = now()->addMinutes(1); // Set the expiration date for the refresh token
            $user->save();
            return $this->sendResponse($user, "success");
        }
        return $this->sendResponse(400, "نام کاربری و رمز عبور مطابقت ندارد!");
    }

    // custom register
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ],
        [
            'name.required'=>'نام ضروری میباشد',
            'email.required'=>'ایمیل ضروری میباشد',
            'passwod.required'=>'رمز عبور ضروری میباشد',
        ]
    
    
    );

        if ($validator->fails()) {
            return $this->sendResponse(400, $validator->errors()->first());
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        if ($user) {
            return $this->sendResponse($user, "success");
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

        $token_str = Str::random(64);

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

    public function refreshAccessToken(Request $request)
{
    $request->validate([
        'refresh_token' => 'required',
    ]);

    $user = User::where('refresh_token', $request->refresh_token)
                ->where('refresh_token_expiry', '>', now())
                ->first();

    if (!$user) {
        return response()->json(['error' => 'Invalid refresh token'], 401);
    }

    // Generate a new access token
    $accessToken = $user->createToken('AccessToken')->plainTextToken;

    return response()->json(['access_token' => $accessToken]);
}
    
}
