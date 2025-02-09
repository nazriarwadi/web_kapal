<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Regu extends Model
{
    use HasFactory;

    protected $table = 'regu';

    protected $fillable = ['nama_regu'];

    public function anggota()
    {
        return $this->hasMany(Anggota::class, 'regu_id');
    }

    // Relasi many-to-many dengan Informasi
    public function informasis()
    {
        return $this->belongsToMany(Informasi::class, 'informasi_regu', 'regu_id', 'informasi_id');
    }
}