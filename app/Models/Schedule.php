<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $table = 'jadwal';

    protected $fillable = [
        'tanggal',
        'jam_mulai',
        'jam_selesai',
        'harga',
        'status',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'id_jadwal');
    }
}
