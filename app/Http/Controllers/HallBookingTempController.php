<?php

namespace App\Http\Controllers;

use App\Models\Hall;
use App\Models\HallBookingTemp;
use Illuminate\Support\Str;

class HallBookingTempController extends Controller
{
    public function hallBookingTemp(Hall $hall)
    {
        $data = request()->validate([
            'booking_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
        ]);

        $hallBookingTemp = HallBookingTemp::create([
            'hall_id' => $hall->id,
            'user_id' => auth()->id(),
            'booking_date' => $data['booking_date'],
            'start_time' => $data['start_time'],
            'end_time' => $data['end_time'],
            'token' => Str::uuid(),
            'status' => 'pending',
        ]);


        return redirect()->route('bookings', $hallBookingTemp->token);
    }
}
