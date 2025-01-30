<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profesi extends Model
{
    use HasFactory;

    // Tentukan nama tabel secara manual
    protected $table = 'profesi';

    protected $fillable = ['nama_profesi'];

    public function anggota()
    {
        return $this->hasMany(Anggota::class);
    }
}