<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HallBookingTemp extends Model
{
    use HasFactory;

    protected $fillable = [
        'hall_id',
        'user_id',
        'booking_date',
        'start_time',
        'end_time',
        'status',
        'token',
    ];

    public function hall()
    {
        return $this->belongsTo(Hall::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


}
