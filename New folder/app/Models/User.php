<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    public $timestamps = false;
    protected $table = 'users';

    protected $fillable = [
        'email',
        'no_hp',
        'alamat',
        'username',
        'password',
        'role',
        'image', // Tambahan kolom image
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // ============================
    // RELATIONS
    // ============================

    // Relasi ke orders (dulu namanya Pesanan)
    public function pesanan()
    {
        return $this->hasMany(Order::class, 'user_id');
    }

    // Relasi ke favorit
    public function favorits()
    {
        return $this->hasMany(Favorit::class, 'user_id');
    }

    // Relasi ke alamats
    public function alamats()
    {
        return $this->hasMany(Alamat::class, 'user_id');
    }

    // ============================
    // ACCESSORS / HELPERS
    // ============================

    /**
     * Ambil URL image user atau default jika kosong
     */
    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/' . $this->image) : asset('assets/images/profile.jpg');
    }
}
