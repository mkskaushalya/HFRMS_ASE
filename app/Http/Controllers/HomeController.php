<?php

namespace App\Http\Controllers;

use App\Models\Hall;
use App\Models\HallLocation;
use App\Models\Review;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $locations = HallLocation::all();
        $halls = Hall::all();
        $reviews = Review::latest()->take(10)->get();
        $review_count = Review::all()->count();

        return view('index', compact('locations', 'halls', 'reviews', 'review_count'));
    }
}
