<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegisterMail;
use App\Mail\ResetPasswordMail;
use App\Mail\PasswordResetSuccessMail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            Notification::createNotification(
                'user',
                'New User Registration',
                'New user "' . $user->name . '" has registered',
                route('admin.user.index'),
                ['user_id' => $user->id, 'email' => $user->email],
                'fas fa-user-plus',
                'success'
            );

            try {
                $verificationUrl = URL::temporarySignedRoute(
                    'verification.verify',
                    now()->addMinutes(60),
                    ['id' => $user->id, 'hash' => sha1($user->email)]
                );

                Mail::to($user->email)->queue(new RegisterMail($user, $verificationUrl));
            } catch (\Exception $mailError) {
                // Log mail error but don't fail registration
                \Log::error('Mail queueing failed: ' . $mailError->getMessage());
            }

            return response()->json([
                'success' => true,
                'message' => 'Registration successful! Please check your email to verify your account.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'errors' => ['general' => [$e->getMessage()]]
            ], 422);
        }
    }

    public function verify(Request $request)
    {
        $user = User::find($request->route('id'));

        if (!$user) {
            return redirect('/')->with('error', 'Invalid verification link.');
        }

        if (!hash_equals((string) $request->route('hash'), sha1($user->getEmailForVerification()))) {
            return redirect('/')->with('error', 'Invalid verification link.');
        }

        if ($user->hasVerifiedEmail()) {
            return redirect('/')->with('success', 'Email already verified.');
        }

        if ($user->markEmailAsVerified()) {
            event(new \Illuminate\Auth\Events\Verified($user));
        }

        return redirect('/')->with('success', 'Email verified successfully! You can now sign in.');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'errors' => ['general' => ['Invalid email or password']]
            ], 422);
        }

        if (!$user->hasVerifiedEmail()) {
            try {
                $verificationUrl = URL::temporarySignedRoute(
                    'verification.verify',
                    now()->addMinutes(60),
                    ['id' => $user->id, 'hash' => sha1($user->email)]
                );
                Mail::to($user->email)->queue(new RegisterMail($user, $verificationUrl));
            } catch (\Exception $e) {
                \Log::error('Verification email queueing failed: ' . $e->getMessage());
            }

            return response()->json([
                'success' => false,
                'errors' => ['general' => ['Please verify your email first. We have sent you a new verification link.']]
            ], 422);
        }

        Auth::login($user, $request->remember);

        return response()->json([
            'success' => true,
            'message' => 'Login successful!'
        ]);
    }

    public function frontendlogout()
    {
        Auth::logout();
        return response()->json([
            'success' => true,
            'message' => 'Logged out successfully!',
            'redirect' => route('frontend.home')
        ]);
    }

    public function showForgotPasswordForm()
    {
        return view('frontend.auth.forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'We can\'t find a user with that email address.']);
        }

        try {
            $token = Hash::make($user->email . now());
            $resetUrl = route('password.reset', ['email' => $user->email, 'token' => $token]);

            try {
                Mail::to($user->email)->queue(new ResetPasswordMail($user, $resetUrl));
            } catch (\Exception $mailError) {
                \Log::error('Reset password mail queueing failed: ' . $mailError->getMessage());
            }

            return back()->with('status', 'We have sent your password reset link to your email!');
        } catch (\Exception $e) {
            \Log::error('Reset password failed: ' . $e->getMessage());
            return back()->withErrors(['email' => 'Failed to send reset link. Please try again.']);
        }
    }

    public function showResetPasswordForm(Request $request)
    {
        $email = $request->route('email');
        $token = $request->route('token');

        return view('frontend.auth.reset-password', compact('email', 'token'));
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
            'token' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'We can\'t find a user with that email address.']);
        }

        // Update password
        $user->update([
            'password' => Hash::make($request->password)
        ]);

        // Queue success email
        try {
            Mail::to($user->email)->queue(new PasswordResetSuccessMail($user));
        } catch (\Exception $mailError) {
            \Log::error('Password reset success mail queueing failed: ' . $mailError->getMessage());
        }

        return redirect('/')->with('success', 'Your password has been reset successfully! You can now sign in.');
    }
}
