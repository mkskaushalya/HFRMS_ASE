<?php

namespace App\Http\Controllers;

use App\Models\HallBooking;
use App\Models\HallBookingTemp;

class HallBookingController extends Controller
{
    public function index($bookingToken)
    {
        $tempBooking = HallBookingTemp::where('token', $bookingToken)->first();
        if ($tempBooking == null) {
            $tempBooking = HallBooking::find($bookingToken);
            if ($tempBooking == null) {
                abort(404);
            }
        }
        return view('bookings.index', ['tempBooking' => $tempBooking]);
    }

    public function storeBooking($bookingToken)
    {
        $data = request()->validate([
            'hall' => 'required',
            'booking_date' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'purpose' => 'required',
            'description' => 'required',
        ]);


        $tempBooking = HallBookingTemp::where('token', $bookingToken)->first();

        if ($tempBooking->user_id != auth()->id() || $tempBooking->status != 'pending' || $tempBooking->hall->id != $data['hall']) {
            abort(403);
        } else {
            $booking = HallBooking::create([
                'hall_id' => $tempBooking->hall_id,
                'user_id' => auth()->id(),
                'booking_date' => $tempBooking->booking_date,
                'start_time' => $tempBooking->start_time,
                'end_time' => $tempBooking->end_time,
                'purpose' => $data['purpose'],
                'description' => $data['description'],
                'status' => 'pending',
            ]);

            $tempBooking->delete();

            return redirect()->route('bookings.success', $booking->id);
        }

    }

    public function success($booking)
    {
        $booking = HallBooking::find($booking);
        return view('bookings.success', ['booking' => $booking]);
    }


}
