<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Check if admin already exists to avoid duplicates
        if (!User::where('email', 'admin@exclusive.com')->exists()) {
            User::create([
                'name' => 'Admin',
                'email' => 'admin@exclusive.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'membership_status' => 'active',
                'selected_plan' => 'premium',
                'email_verified_at' => now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        User::where('email', 'admin@exclusive.com')->delete();
    }
};
