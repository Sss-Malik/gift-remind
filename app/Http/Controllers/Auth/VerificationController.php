<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Demo-only verification controller.
 *
 * Accepts any 6-digit code and advances the user through
 * email → phone verification steps. No real OTP or SMS
 * integration — designed to be swapped out later.
 */
class VerificationController extends Controller
{
    /**
     * Show the email verification screen.
     */
    public function showEmailVerification()
    {
        // Skip if user already passed email verification step in this session
        if (session('email_verified_demo')) {
            return redirect()->route('verify.phone');
        }

        return view('auth.verify-email-code');
    }

    /**
     * Handle email verification code submission.
     * Demo: accepts any 6-digit code.
     */
    public function verifyEmail(Request $request)
    {
        $request->validate([
            'code' => ['required', 'digits:6'],
        ]);

        // Demo logic: any 6-digit code is accepted
        session(['email_verified_demo' => true]);

        return redirect()->route('verify.phone')->with('success', 'Email verified successfully!');
    }

    /**
     * Show the phone verification screen.
     */
    public function showPhoneVerification()
    {
        // Require email step first
        if (!session('email_verified_demo')) {
            return redirect()->route('verify.email');
        }

        // Skip if phone already verified in this session
        if (session('phone_verified_demo')) {
            return redirect()->route('dashboard');
        }

        return view('auth.verify-phone-code');
    }

    /**
     * Handle phone verification code submission.
     * Demo: accepts any 6-digit code.
     */
    public function verifyPhone(Request $request)
    {
        $request->validate([
            'code' => ['required', 'digits:6'],
        ]);

        // Demo logic: any 6-digit code is accepted
        session(['phone_verified_demo' => true]);

        // Mark the user's email and phone as verified in the database
        $user = Auth::user();
        if (!$user->email_verified_at) {
            $user->email_verified_at = now();
        }
        if (!$user->phone_verified_at) {
            $user->phone_verified_at = now();
        }
        $user->save();

        return redirect()->route('dashboard')->with('success', 'Account fully verified! Welcome to GiftSync.');
    }

    /**
     * Demo-only: simulate resending verification code.
     */
    public function resendCode(Request $request)
    {
        $type = $request->input('type', 'email');

        // Demo: just flash a success message — no real email/SMS sent
        return back()->with('success', "A new verification code has been sent to your {$type}.");
    }
}
