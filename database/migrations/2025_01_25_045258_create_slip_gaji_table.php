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
        Schema::create('slip_gaji', function (Blueprint $table) {
            $table->id();
            $table->foreignId('anggota_id')->constrained('anggota')->onDelete('cascade'); // Foreign key ke tabel anggota
            $table->foreignId('profesi_id')->constrained('profesi')->onDelete('cascade'); // Foreign key ke tabel profesi
            $table->foreignId('regu_id')->constrained('regu')->onDelete('cascade'); // Foreign key ke tabel regu
            $table->integer('hadir');
            $table->integer('izin');
            $table->integer('lembur');
            $table->decimal('gaji', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('slip_gaji');
    }
};