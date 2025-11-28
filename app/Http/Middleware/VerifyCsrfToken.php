<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    protected $except = [
        'admin/*',   // 👈 กัน error 419 สำหรับ admin login/logout ทั้งหมด
    ];
}
