<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('anggota', function (Blueprint $table) {
            $table->boolean('is_banned')->default(false)->after('password');
            $table->dateTime('banned_until')->nullable()->after('is_banned');
        });
    }

    public function down()
    {
        Schema::table('anggota', function (Blueprint $table) {
            $table->dropColumn(['is_banned', 'banned_until']);
        });
    }
};
