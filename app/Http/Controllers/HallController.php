<?php

namespace App\Http\Controllers;

use App\Models\Hall;
use App\Models\HallLocation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class HallController extends Controller
{
    public function index(Request $request): Response
    {
        $request->validate([
            'location' => 'nullable|exists:hall_locations,id',
            'booking_date' => 'nullable|date',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i',
        ]);

        $location = $request->location;
        $date = $request->booking_date;
        $start_time = $request->start_time;
        $end_time = $request->end_time;
        $data = true;




        if ($location == null || $date == null || $start_time == null || $end_time == null) {
            $halls = Hall::all();

        } else {
            $halls = Hall::getAvailableHalls($location, $date, $start_time, $end_time);
            $data = false;
        }

        $locations = HallLocation::all();

        return response()->view('halls.index', ['halls' => $halls, 'locations' => $locations, 'request' => $request, 'data' => $data]);
    }


    public function show(Hall $hall, Request $request): Response
    {
        if (isset($request->booking_date) && isset($request->start_time) && isset($request->end_time)) {
            $bookDate = Carbon::parse($request->booking_date);
            $startTime = Carbon::parse($request->start_time)->format('H:i:s');
            $endTime = Carbon::parse($request->end_time)->format('H:i:s');

            $hallAvailability = Hall::checkHallAvailability($hall, $bookDate, $startTime, $endTime);
        } else {
            $hallAvailability = null;
        }
        return response()->view('halls.show', ['hall' => $hall, 'request' => $request, 'hallAvailability' => $hallAvailability]);
    }
}
