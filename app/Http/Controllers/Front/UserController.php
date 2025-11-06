<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;



class UserController extends Controller
{
    public function index()
    {        
        return view('front.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $request->session()->regenerate();

            // Add flash message for success
            // return redirect()->intended('/')->with('success', 'Login successful!');
            return redirect()->route('my.account')->with('success', 'Login successful!');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email')->with('error', 'Login failed! Please check your credentials.');
    }

    public function myAccount()
    {        
        return view('front.my-account');
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'   => 'required|string|max:255',
            'mobile' => ['required', 'regex:/^[0-9]{10,15}$/'],
            'email'  => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'photo'  => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
        ]);

        $user->name   = $request->name;
        $user->mobile = $request->mobile;
        $user->email  = $request->email;

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/users'), $filename);
            $user->photo = $filename;
        }

        $user->save();
        return redirect()->back()->with('success', 'Profile updated successfully!');

        // return back()->with('success', 'Profile updated successfully!');
    }

    // Handle Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    public function forgotPassword()
    {
        return view('front.forgot-password');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'We can\'t find a user with that email address.'])->onlyInput('email');
        }

        // Generate OTP and expiry
        $otp = rand(1000, 9999);
        $expiresAt = now()->addMinutes(10);

        // Save to users table
        $user->otp = $otp;
        $user->otp_expires_at = $expiresAt;
        $user->save();

        // Send email
        Mail::send('emails.otp-email', ['otp' => $otp, 'email' => $request->email], function($message) use ($user) {
            $message->to($user->email);
            $message->subject('Your Password Reset OTP');
        });

        return redirect()->route('otp')->with([
            'email' => $request->email,
            'status' => 'We have emailed your password reset OTP!'
        ]);
    }

    public function otp(Request $request)
    {
        if (!$request->session()->has('email')) {
            return redirect()->route('forgot.password')->with('error', 'Please request OTP first.');
        }

        return view('front.password-otp');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|digits:4',
        ]);

        $user = User::where('email', $request->email)
                    ->where('otp', $request->otp)
                    ->where('otp_expires_at', '>', now())
                    ->first();

        if (!$user) {
            return back()->withErrors(['otp' => 'The provided OTP is invalid or has expired.'])->onlyInput('otp');
        }

        // OTP is valid, redirect to reset password page
        return redirect()->route('reset')->with([
            'email' => $request->email,
            'otp_verified' => true
        ]);
    }

    public function reset(Request $request)
    {
        if (!$request->session()->has('email') || $request->session()->get('otp_verified') !== true) {
            return redirect()->route('login')->with('error', 'Please verify OTP before resetting password.');
        }

        return view('front.reset-password');
    }
    
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp_verified' => 'required|in:true,false',
            'password' => 'required|min:8|confirmed',
        ]);

        if (!$request->otp_verified) {
            return back()->withErrors(['otp' => 'OTP not verified. Please go through the OTP verification process.']);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'We can\'t find a user with that email address.']);
        }

        $user->password = Hash::make($request->password);
        $user->otp = null;
        $user->otp_expires_at = null;
        $user->save();

        return redirect()->route('login')->with('success', 'Your password has been reset successfully!');
    }
}