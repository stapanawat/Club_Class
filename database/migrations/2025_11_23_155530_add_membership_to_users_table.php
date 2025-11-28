<?php

// database/migrations/xxxx_xx_xx_xxxxxx_add_membership_to_users.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('user'); // user, admin
            $table->string('membership_status')->default('visitor'); // visitor, pending, active

            $table->string('provider')->nullable(); // google, line
            $table->string('provider_id')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'membership_status', 'provider', 'provider_id']);
        });
    }
};
