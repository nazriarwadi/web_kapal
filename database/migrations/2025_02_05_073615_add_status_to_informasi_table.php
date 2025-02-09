<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('informasi', function (Blueprint $table) {
            $table->enum('status', ['Selesai dikerjakan', 'Sedang dikerjakan', 'Belum dikerjakan'])
                  ->default('Belum dikerjakan')
                  ->after('jam_sampai');
        });
    }

    public function down()
    {
        Schema::table('informasi', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};