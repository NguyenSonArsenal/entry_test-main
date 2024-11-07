<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Booking extends Authenticatable
{
    use SoftDeletes;

    protected $table = 'bookings';

    protected $fillable = [
        'booking_id',
        'hotel_id',
        'customer_name',
        'customer_contact',
        'checkin_time',
        'checkout_time',
    ];

    public function hotel()
    {
        return $this->belongsTo(Hotel::class,'hotel_id', 'hotel_id');
    }
}
