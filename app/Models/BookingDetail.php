<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class BookingDetail extends Model
{
    use HasFactory;
    protected $table = 'booking_detail';
    protected $fillable = [
        'id_booking',
        'id_jadwal',
    ];
    public function booking()
    {
        return $this->belongsTo(Booking::class, 'id_booking');
    }
    public function jadwal()
    {
        return $this->belongsTo(Schedule::class, 'id_jadwal');
    }
}
