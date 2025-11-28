<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Throwable;

class SocialLoginController extends Controller
{
    // STEP 1: redirect ไป Google
    public function redirectToGoogle(Request $request)
    {
        if ($request->has('redirect')) {
            session(['social_redirect' => $request->query('redirect')]);
        }

        return Socialite::driver('google')->redirect();
    }

    // STEP 2: callback จาก Google
    public function handleGoogleCallback(Request $request)
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();
        } catch (Throwable $e) {
            return redirect('/login')->with('error', 'ไม่สามารถเข้าสู่ระบบด้วย Google ได้');
        }

        $email = $googleUser->getEmail() ?: 'google_' . $googleUser->getId() . '@example.local';

        $user = User::firstOrCreate(
            ['email' => $email],
            [
                'name'              => $googleUser->getName() ?? 'Google User',
                'password'          => Hash::make(uniqid('google_', true)),
                'role'              => 'user',
                'membership_status' => 'visitor',
                'provider'          => 'google',
                'provider_id'       => $googleUser->getId(),
                'email_verified_at' => now(),
            ]
        );

        Auth::login($user, true);

        $user->tokens()->delete();
        $apiToken = $user->createToken('auth_token')->plainTextToken;

        $redirectPath = session('social_redirect', '/dashboard');
        session()->forget('social_redirect');

        $frontend = env('FRONTEND_URL', 'http://localhost:8000');

        $callbackUrl = $frontend
            . '/oauth/callback?token=' . urlencode($apiToken)
            . '&redirect=' . urlencode($redirectPath);

        return redirect()->away($callbackUrl);
    }
}
