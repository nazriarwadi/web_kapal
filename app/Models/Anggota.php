<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Carbon\Carbon;

class Anggota extends Model
{
    use HasFactory, HasApiTokens;

    protected $table = 'anggota';

    protected $fillable = [
        'nama',
        'no_telp',
        'email',
        'password',
        'regu_id',
        'profesi_id',
        'is_banned',
        'banned_until'
    ];

    protected $casts = [
        'is_banned' => 'boolean', // Konversi tinyint(1) ke boolean
        'banned_until' => 'datetime', // Konversi datetime ke objek Carbon
    ];

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
        return $this->hasMany(Absensi::class, 'anggota_id');
    }

    public function slipGaji()
    {
        return $this->hasMany(SlipGaji::class);
    }

    /**
     * Cek apakah anggota sedang dibanned.
     *
     * @return bool
     */
    public function isCurrentlyBanned(): bool
    {
        return $this->is_banned && $this->banned_until && Carbon::now()->lt($this->banned_until);
    }

    /**
     * Set anggota sebagai banned untuk durasi tertentu.
     *
     * @param int $days Jumlah hari untuk banned
     * @return void
     */
    public function setBanned(int $days): void
    {
        $this->update([
            'is_banned' => true,
            'banned_until' => Carbon::now()->addDays($days),
        ]);
    }

    /**
     * Unban anggota.
     *
     * @return void
     */
    public function unban(): void
    {
        $this->update([
            'is_banned' => false,
            'banned_until' => null,
        ]);
    }
}
