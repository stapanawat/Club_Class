<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasColumn('contents', 'excerpt')) {
            Schema::table('contents', function (Blueprint $table) {
                $table->text('excerpt')->nullable()->after('teaser');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('contents', 'excerpt')) {
            Schema::table('contents', function (Blueprint $table) {
                $table->dropColumn('excerpt');
            });
        }
    }
};
