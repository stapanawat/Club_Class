<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class LineAuthController extends Controller
{
    // STEP 1: redirect ไปหน้า LINE
    public function redirectToLine(Request $request)
    {
        if ($request->has('redirect')) {
            session(['social_redirect' => $request->query('redirect')]);
        }

        $state = Str::random(40);
        session(['line_state' => $state]);

        $query = http_build_query([
            'response_type' => 'code',
            'client_id' => config('services.line.client_id'),
            'redirect_uri' => config('services.line.redirect') ?? route('login.line.callback'),
            'state' => $state,
            'scope' => 'profile openid email',
        ]);

        return redirect()->away('https://access.line.me/oauth2/v2.1/authorize?' . $query);
    }

    // STEP 2: callback กลับมาจาก LINE
    public function handleLineCallback(Request $request)
    {
        $state = $request->query('state');
        if (!$state || $state !== session('line_state')) {
            return redirect('/login')->with('error', 'Invalid LINE login state');
        }
        session()->forget('line_state');

        $code = $request->query('code');
        if (!$code) {
            return redirect('/login')->with('error', 'ไม่พบ code จาก LINE');
        }

        $tokenResponse = Http::asForm()->post('https://api.line.me/oauth2/v2.1/token', [
            'grant_type' => 'authorization_code',
            'code' => $code,
            'redirect_uri' => config('services.line.redirect') ?? route('login.line.callback'),
            'client_id' => config('services.line.client_id'),
            'client_secret' => config('services.line.client_secret'),
        ]);

        if (!$tokenResponse->ok()) {
            return redirect('/login')->with('error', 'ขอ token จาก LINE ไม่สำเร็จ');
        }

        $tokenData = $tokenResponse->json();
        $accessToken = $tokenData['access_token'] ?? null;

        if (!$accessToken) {
            return redirect('/login')->with('error', 'ไม่พบ access token จาก LINE');
        }

        $profileResponse = Http::withToken($accessToken)
            ->get('https://api.line.me/v2/profile');

        if (!$profileResponse->ok()) {
            return redirect('/login')->with('error', 'ดึงข้อมูลผู้ใช้จาก LINE ไม่สำเร็จ');
        }

        $profile = $profileResponse->json();

        $lineId = $profile['userId'] ?? null;
        $name = $profile['displayName'] ?? 'LINE User';

        $email = 'line_' . $lineId . '@example.local';

        $user = User::firstOrCreate(
            ['email' => $email],
            [
                'name' => $name,
                'password' => Hash::make(uniqid('line_', true)),
                'role' => 'user',
                'membership_status' => 'visitor',
                'provider' => 'line',
                'provider_id' => $lineId,
                'email_verified_at' => now(),
            ]
        );

        // login session เผื่อใช้ฝั่ง server
        Auth::login($user, true);

        // ออก Sanctum token ให้ member ใช้กับ /me
        $user->tokens()->delete();
        $apiToken = $user->createToken('auth_token')->plainTextToken;

        $redirectPath = session('social_redirect', '/dashboard');
        session()->forget('social_redirect');

        $frontend = env('FRONTEND_URL', url('/'));

        $callbackUrl = $frontend
            . '/oauth/callback?token=' . urlencode($apiToken)
            . '&redirect=' . urlencode($redirectPath);

        return redirect()->away($callbackUrl);
    }
}
