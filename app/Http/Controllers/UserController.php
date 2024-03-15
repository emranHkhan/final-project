<?php

namespace App\Http\Controllers;

use App\Mail\JobPortalMail;
use App\Models\Company;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    function UserRegistration(Request $request)
    {
        try {
            DB::beginTransaction();

            $request->validate([
                'firstName' => 'required|string|max:50',
                'lastName' => 'required|string|max:50',
                'email' => 'required|string|email|max:50|unique:users,email',
                'mobile' => 'required|string|max:50',
                'password' => 'required|string|min:3',
                'role' => 'required|string',
                'company_name' => $request->input('role') == 'company' ? 'required|string|max:50' : '',
                'company_location' => $request->input('role') == 'company' ? 'required|string|max:50' : '',
                'company_description' => $request->input('role') == 'company' ? 'required|string|max:50' : ''

            ]);

            $user = User::create([
                'firstName' => $request->input('firstName'),
                'lastName' => $request->input('lastName'),
                'email' => $request->input('email'),
                'mobile' => $request->input('mobile'),
                'password' => Hash::make($request->input('password')),
                'role' => $request->input('role')
            ]);

            if ($user->role == 'company') {
                $company = new Company([
                    'name' => $request->input('company_name'),
                    'location' => $request->input('company_location'),
                    'description' => $request->input('company_description'),
                ]);

                $user->company()->save($company);
            }


            DB::commit();

            return response()->json(['status' => 'success', 'message' => 'User Registration Successfully']);
        } catch (Exception $e) {
            DB::rollBack();

            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }
    function UserLogin(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|string|email|max:50',
                'password' => 'required|string|min:3'
            ]);

            $user = User::where('email', $request->input('email'))->first();



            if (!$user || !Hash::check($request->input('password'), $user->password)) {
                return response()->json(['status' => 'failed', 'message' => 'Invalid User']);
            }

            $token = $user->createToken('authToken')->plainTextToken;
            return response()->json(['status' => 'success', 'message' => 'Login Successful', 'token' => $token, 'user' => $user]);
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

    function UserProfile(Request $request)
    {
        return Auth::user();
    }

    function UserLogout(Request $request)
    {
        $request->session()->forget('user');
        $request->user()->tokens()->delete();
        return redirect('/userLogin');
    }

    function UpdateProfile(Request $request)
    {

        try {
            $request->validate([
                'firstName' => 'required|string|max:50',
                'lastName' => 'required|string|max:50',
                'mobile' => 'required|string|max:50',
            ]);

            User::where('id', '=', Auth::id())->update([
                'firstName' => $request->input('firstName'),
                'lastName' => $request->input('lastName'),
                'mobile' => $request->input('mobile'),
            ]);

            return response()->json(['status' => 'success', 'message' => 'Request Successful']);
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

    function SendOTPCode(Request $request)
    {

        try {

            $request->validate([
                'email' => 'required|string|email|max:50'
            ]);

            $email = $request->input('email');
            $otp = rand(1000, 9999);
            $count = User::where('email', '=', $email)->count();

            if ($count == 1) {
                Mail::to($email)->send(new JobPortalMail($otp));
                User::where('email', '=', $email)->update(['otp' => $otp]);
                return response()->json(['status' => 'success', 'message' => '4 Digit OTP Code has been send to your email !']);
            } else {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'Invalid Email Address'
                ]);
            }
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

    function VerifyOTP(Request $request)
    {

        try {
            $request->validate([
                'email' => 'required|string|email|max:50',
                'otp' => 'required|string|min:4'
            ]);

            $email = $request->input('email');
            $otp = $request->input('otp');

            $user = User::where('email', '=', $email)->where('otp', '=', $otp)->first();

            if (!$user) {
                return response()->json(['status' => 'fail', 'message' => 'Invalid OTP']);
            }


            User::where('email', '=', $email)->update(['otp' => '0']);

            $token = $user->createToken('authToken')->plainTextToken;
            return response()->json(['status' => 'success', 'message' => 'OTP Verification Successful', 'token' => $token]);
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

    function ResetPassword(Request $request)
    {

        try {
            $request->validate([
                'password' => 'required|string|min:3'
            ]);
            $id = Auth::id();
            $password = $request->input('password');
            User::where('id', '=', $id)->update(['password' => Hash::make($password)]);
            return response()->json(['status' => 'success', 'message' => 'Request Successful']);
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage(),]);
        }
    }

    function AdminLogin(Request $request)
    {
    }
}
