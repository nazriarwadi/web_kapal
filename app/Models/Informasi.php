<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Informasi extends Model
{
    use HasFactory;

    protected $table = 'informasi';

    protected $fillable = ['gambar', 'bawaan', 'kebarangkatan', 'jam_sampai', 'status'];

    // Relasi many-to-many dengan Regu
    public function regus()
    {
        return $this->belongsToMany(Regu::class, 'informasi_regu', 'informasi_id', 'regu_id');
    }

    // Opsi status yang tersedia
    public static function getStatusOptions()
    {
        return [
            'Selesai dikerjakan' => 'Selesai dikerjakan',
            'Sedang dikerjakan' => 'Sedang dikerjakan',
            'Belum dikerjakan' => 'Belum dikerjakan',
        ];
    }

    // Accessor untuk menampilkan status dalam format yang lebih rapi
    public function getStatusLabelAttribute()
    {
        $labels = [
            'Selesai dikerjakan' => '<span class="badge badge-success">Selesai</span>',
            'Sedang dikerjakan' => '<span class="badge badge-warning">Sedang dikerjakan</span>',
            'Belum dikerjakan' => '<span class="badge badge-danger">Belum dikerjakan</span>',
        ];

        return $labels[$this->status] ?? '<span class="badge badge-secondary">Tidak Diketahui</span>';
    }
}