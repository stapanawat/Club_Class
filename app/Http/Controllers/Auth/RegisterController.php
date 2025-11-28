<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Mail\VerifyEmailMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    // POST /register
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'role' => 'user',
            'membership_status' => 'visitor',
            'selected_plan' => 'free',
        ]);

        event(new \Illuminate\Auth\Events\Registered($user));

        Auth::login($user);

        return response()->json([
            'message' => 'สมัครสำเร็จ กรุณาตรวจสอบอีเมลเพื่อยืนยันตัวตน',
        ], 201);
    }

    // GET /verify-email/{token}
    // GET /verify-email/{token}


}
