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
        ]);

        if ($validator->fails()) {
            return $this->sendResponse(400, $validator->errors()->first());
        }

        $credentials = $request->only('email', 'password');
        // if (Auth::attempt($credentials)) {
            $user = User::where('email', $request->email)->first();
            return $this->sendResponse($user, "success");
        // }
        return $this->sendResponse(400, "Credentials not match with our records");
    }

    // custom register
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

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
        ]);

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
            return $this->sendResponse(400, "Something went wrong, please contact support.");
        }
    }

    // reset password
    public function reset_pass(Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email', 'max:255'],
            'token' => ['required', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
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
            return $this->sendResponse(400, "Something went wrong, please contact support.");
        }
    }
}
