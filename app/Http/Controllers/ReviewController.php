<?php

namespace App\Http\Controllers;

use App\Models\Hall;
use App\Models\Review;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function storeReview(Request $request, Hall $hall): RedirectResponse
    {
        $request->validate([
            'rating' => 'required|integer|between:1,5',
            'hall_id' => 'required|integer|exists:halls,id',
            'title' => 'required|string',
            'message' => 'required|string',
        ]);

        $review = Review::create([
            'rating' => $request->rating,
            'hall_id' => $request->hall_id,
            'user_id' => auth()->id(),
            'title' => $request->title,
            'message' => $request->message,
        ]);


        return redirect(url()->previous() . "#review-{$review->id}");
    }

//    public function reviews(Request $request, Hall $hall): Response
//    {
//        $reviews = $hall->reviews()->latest()->get();
//        return response()->view('halls.reviews', ['hall' => $hall, 'reviews' => $reviews]);
//    }

    public function updateReview(Request $request, Hall $hall, Review $review): RedirectResponse
    {
        $request->validate([
            'rating' => 'required|integer|between:1,5',
            'title' => 'required|string',
            'message' => 'required|string',
        ]);

        $review->update([
            'rating' => $request->rating,
            'title' => $request->title,
            'message' => $request->message,
        ]);

        return redirect(url()->previous() . "#review-{$review->id}");
    }

    public function destroyReview(Hall $hall, Review $review): RedirectResponse
    {
        $review->delete();
        return redirect(url()->previous() . "#reviews");
    }
}
