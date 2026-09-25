<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $table = 'booking';

    protected $fillable = [
        'id_pelanggan',
        'id_jadwal',
        'nama_tim',
        'status',
    ];

    public function pelanggan()
    {
        return $this->belongsTo(Customer::class, 'id_pelanggan');
    }

    public function jadwal()
    {
        return $this->belongsTo(Schedule::class, 'id_jadwal');
    }
}
