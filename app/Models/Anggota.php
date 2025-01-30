<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Anggota extends Model
{
    use HasFactory, HasApiTokens;

    // Tentukan nama tabel secara manual
    protected $table = 'anggota';

    protected $fillable = ['nama', 'no_telp', 'email', 'password', 'regu_id', 'profesi_id'];

    public function regu()
    {
        return $this->belongsTo(Regu::class);
    }

    public function profesi()
    {
        return $this->belongsTo(Profesi::class);
    }

    public function absensi()
    {
        return $this->hasMany(Absensi::class);
    }

    public function slipGaji()
    {
        return $this->hasMany(SlipGaji::class);
    }
}