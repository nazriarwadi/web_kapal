<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('informasi', function (Blueprint $table) {
            $table->dropForeign(['regu_id']); // Hapus foreign key
            $table->dropColumn('regu_id'); // Hapus kolom regu_id
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('informasi', function (Blueprint $table) {
            $table->foreignId('regu_id')->constrained('regu')->onDelete('cascade');
        });
    }
};