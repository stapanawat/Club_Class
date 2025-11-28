<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('payments', function (Blueprint $table) {
        $table->string('channel')->nullable()->after('status');
        $table->string('reference')->nullable()->after('channel');
        $table->text('notes')->nullable()->after('reference');
    });
}

public function down()
{
    Schema::table('payments', function (Blueprint $table) {
        $table->dropColumn(['channel', 'reference', 'notes']);
    });
}

};
