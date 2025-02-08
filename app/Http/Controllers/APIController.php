<?php

namespace App\Http\Controllers;

use App\Models\Hall;
use Carbon\Carbon;
use GuzzleHttp\Psr7\Request;

class APIController extends Controller
{
    public function index()
    {
        return response()->json([
            'message' => 'Welcome to the API',
        ]);
    }

    public function halls()
    {
        $halls = Hall::all();
        return response()->json($halls);

    }

    public function findHall($id)
    {
        $hall = Hall::find($id);
        return response()->json($hall);
    }

    public function getAvailableHalls($location, $date, $start_time, $end_time)
    {
        $bookDate = Carbon::parse($date);
        $startTime = Carbon::parse($start_time);
        $endTime = Carbon::parse($end_time);

        $halls = Hall::getAvailableHalls($location, $bookDate, $startTime, $endTime);
        return response()->json($halls);
    }

    public function checkHall($id, $date, $start_time, $end_time)
    {
        $bookDate = Carbon::parse($date);
        $startTime = Carbon::parse($start_time)->format('H:i:s');
        $endTime = Carbon::parse($end_time)->format('H:i:s');

        $hall = Hall::find($id);
        $isAvailable = $hall->checkHallAvailability($hall, $bookDate, $startTime, $endTime);
        return response()->json([
            'isAvailable' => $isAvailable,
        ]);
    }

    public function bookHall(Request $request, $id)
    {
        $hall = Hall::find($id);
        $bookDate = Carbon::parse($request->date);
        $startTime = Carbon::parse($request->start_time);
        $endTime = Carbon::parse($request->end_time);
        $user = auth()->user();

        if (!$hall->isAvailable($bookDate, $startTime, $endTime)) {
            return response()->json([
                'message' => 'Hall is not available',
            ], 400);
        } else {
            $booking = $hall->book($user, $bookDate, $startTime, $endTime);
            return response()->json($booking);
        }

    }

    public function showBooking($id)
    {
        $booking = auth()->user()->bookings()->find($id);
        return response()->json($booking);
    }

    public function bookings()
    {
        $bookings = auth()->user()->bookings;
        return response()->json($bookings);
    }

    public function approveBooking($id)
    {
        $booking = auth()->user()->bookings()->find($id);
        $booking->update([
            'status' => 'approved',
        ]);
        return response()->json($booking);
    }

    public function rejectBooking($id)
    {
        $booking = auth()->user()->bookings()->find($id);
        $booking->update([
            'status' => 'rejected',
        ]);
        return response()->json($booking);
    }
}
