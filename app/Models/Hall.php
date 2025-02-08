<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Hall extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'hall_number',
        'description',
        'hall_location_id',
        'capacity',
        'price',
        'status',
        'image',
        'user_id',
    ];


    public static function getAvailableHalls($location, $date, $start_time, $end_time): array
    {
        $date = Carbon::parse($date); // Parse the given date
        $start_time = Carbon::parse($start_time)->format('H:i:s'); // Format the start time
        $end_time = Carbon::parse($end_time)->format('H:i:s'); // Format the end time

        $hallLocation = HallLocation::find($location); // Find the hall location
        $halls = $hallLocation->halls; // Get the halls in the location

        // Get the available halls
        return self::getHall($halls, $date, $start_time, $end_time);
    }

    public static function getHall($halls, $date, $start_time, $end_time): array
    {
        $availableHalls = []; // Initialize an empty array to store available halls

        // Loop through the halls

        foreach ($halls as $hall) {
            $bookings = $hall->bookings; // Get the bookings for the hall
            $isAvailable = self::checkBooking($bookings, $date, $start_time, $end_time); // Check if the hall is available

            // If the hall is available, add it to the available halls array
            if ($isAvailable) {
                $availableHalls[$hall->id] = $hall;
            }

        }
        return $availableHalls;
    }

    public static function checkBooking($bookings, $date, $start_time, $end_time): bool
    {
        $isAvailable = true; // Initialize a variable to check if the hall is available

        // Loop through the bookings

        foreach ($bookings as $booking) {
            $bookingDate = Carbon::parse($booking->booking_date); // Parse the booking date
            $bookingStartTime = Carbon::parse($booking->start_time)->format('H:i:s'); // Format the booking start time
            $bookingEndTime = Carbon::parse($booking->end_time)->format('H:i:s'); // Format the booking end time

            // Check if the given date is the same as the booking date

            if ($date == $bookingDate) {
                // Check if the given start time is between the booking start and end time

                if ($start_time >= $bookingStartTime && $start_time <= $bookingEndTime) {
                    $isAvailable = false; // Set the hall as not available
                    break; // Break the loop
                }

                // Check if the given end time is between the booking start and end time

                if ($end_time >= $bookingStartTime && $end_time <= $bookingEndTime) {
                    $isAvailable = false; // Set the hall as not available
                    break; // Break the loop
                }

                // Check if the given start and end time are outside the booking start and end time

                if ($start_time <= $bookingStartTime && $end_time >= $bookingEndTime) {
                    $isAvailable = false; // Set the hall as not available
                    break; // Break the loop
                }
            }
        }
        return $isAvailable;
    }

    public static function checkHallAvailability($hall, $date, $start_time, $end_time): bool
    {
        $bookings = $hall->bookings; // Get the bookings for the hall

        // Check if the hall is available
        return self::checkBooking($bookings, $date, $start_time, $end_time);

    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function hallImages()
    {
        return $this->hasMany(HallImage::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function hallLocation()
    {
        return $this->belongsTo(HallLocation::class);
    }

    public function hallBookingTemps()
    {
        return $this->hasMany(HallBookingTemp::class);
    }

    public function bookings()
    {
        return $this->hasMany(HallBooking::class);
    }


}
