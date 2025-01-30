<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SlipGaji extends Model
{
    use HasFactory;

    // Tentukan nama tabel secara manual
    protected $table = 'slip_gaji';

    // Kolom yang bisa diisi secara massal
    protected $fillable = ['anggota_id', 'profesi_id', 'regu_id', 'hadir', 'izin', 'lembur', 'gaji'];

    // Relasi ke model Anggota
    public function anggota()
    {
        return $this->belongsTo(Anggota::class, 'anggota_id');
    }

    // Relasi ke model Profesi
    public function profesi()
    {
        return $this->belongsTo(Profesi::class, 'profesi_id');
    }

    // Relasi ke model Regu
    public function regu()
    {
        return $this->belongsTo(Regu::class, 'regu_id');
    }
}