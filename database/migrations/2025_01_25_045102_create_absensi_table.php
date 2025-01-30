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
        Schema::create('absensi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('anggota_id')->constrained('anggota')->onDelete('cascade'); // Foreign key ke tabel anggota
            $table->foreignId('profesi_id')->constrained('profesi')->onDelete('cascade'); // Foreign key ke tabel profesi
            $table->foreignId('regu_id')->constrained('regu')->onDelete('cascade'); // Foreign key ke tabel regu
            $table->bigInteger('hadir')->default(0); // Mengganti boolean dengan bigInteger
            $table->bigInteger('izin')->default(0); // Mengganti boolean dengan bigInteger
            $table->bigInteger('lembur')->default(0); // Mengganti boolean dengan bigInteger
            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absensi');
    }
};