<?php

namespace App\Http\Controllers;

use App\Helper\JWTToken;
use App\Mail\OTPMail;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    // User Create A New Account / Registration Method
    public function userRegistration(Request $request)
    {
        try {
            // dd($request);
            User::create([
                'firstName' => $request->input('firstName'),
                'lastName' => $request->input('lastName'),
                'email' => $request->input('email'),
                'mobile' => $request->input('mobile'),
                'password' => $request->input('password'),
            ]);
            return response()->json([
                'status' => 'success',
                'message' => 'User Registration Successfully',
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => 'User Registration Failed',
            ], 200);
        }
    }

    // User Login Method
    public function userLogin(Request $request)
    {

        // dd($request);
        $userFind = User::where('email', '=', $request->input('email'))
            ->where('password', '=', $request->input('password'))
            ->count();
        if ($userFind === 1) {
            $token = JWTToken::createTokenForUserLogin($request->input('email'));
            return response()->json([
                'status' => 'success',
                'message' => 'User Login Successful',
                // 'token' => $token,
            ], 200)->cookie('token', $token, 60*24*30);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'unauthorized',
            ], 401);
        }
    }

    // Send OTP Code Of User Email Method
    public function sendOTPCode(Request $request)
    {
        $email = $request->input('email');
        $otp = rand(100000, 999999); // random 6 digit number will be generate

        $userFind = User::where('email', '=', $email)
            ->count();

        if ($userFind === 1) {
            // Send OTP
            Mail::to($email)->send(new OTPMail($otp));
            // Add OTP Code DB Table Update
            User::where('email', '=', $email)->update(['otp' => $otp]);
            return response()->json([
                'status' => 'success',
                'message' => '6 Digit OTP Send Your Email',
            ], 200);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'unauthorized',
            ], 401);
        }
    }

    // Verify OTP Method
    public function verifyOTP(Request $request)
    {
        $email = $request->input('email');
        $otp = $request->input('otp');
        $userFind = User::where('email', '=', $email)->where('otp', '=', $otp)->count();
        if ($userFind === 1) {
            // Add OTP Code DB Table Update
            User::where('email', '=', $email)->update(['otp' => '0']);
            // Pass reset Token Issue
            $token = JWTToken::createTokenForForgetPassword($request->input('email'));
            return response()->json([
                'status' => 'success',
                'message' => 'OTP Verification Successful',
                'token' => $token
            ], 200);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'unauthorized'
            ], 401);
        }
    }

    // Reset / Forgot Password Method
    public function resetUserPassword(Request $request)
    {
        try {
            $email = $request->header('email');
            $newPassword = $request->input('password');
            User::where('email', '=', $email)->update([
                'password' => $newPassword,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => "Password Reset Successful"
            ], 200);
        } catch (Exception $e) {
            //throw $th;
            return response()->json([
                'status' => 'failed',
                'message' => "Something Went Wrong!!!"
            ], 200);
        }
    }

    // Show Login Page
    public function loginPage()
    {
        return view('pages.auth.login-page');
    }
    public function registrationPage()
    {
        return view('pages.auth.registration-page');
    }
    public function sendOTPPage()
    {
        return view('pages.auth.send-otp-page');
    }
    public function verifyOTPPage()
    {
        return view('pages.auth.verify-otp-page');
    }
    public function resetPasswordPage()
    {
        return view('pages.auth.reset-pass-page');
    }
    public function dashboardPage()
    {
        return view('pages.dashboard.dashboard-page');
        // return 'hi';
    }
}
