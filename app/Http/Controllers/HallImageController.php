<?php

namespace App\Http\Controllers;

use App\Models\Hall;
use App\Models\HallImage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class HallImageController extends Controller
{
    //Images management

    public function createImage(): Response
    {
        return response()->view('dashboard.images.create', ['halls' => Hall::all()]);
    }

    public function storeImage(): RedirectResponse
    {
        request()->validate([
            'hall' => 'required|exists:halls,id',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'title' => 'nullable|string|max:255',
        ]);

        $hall = Hall::findOrFail(request('hall'));

        foreach (request('images') as $key => $image) {
            $extension = $image->getClientOriginalExtension();
            $filename = request('hall') . '_' . $key . "_" . time() . '.' . $extension;
            $path = "img/halls/";

            $image->move($path, $filename);

            HallImage::create([
                'hall_id' => request('hall'),
                'user_id' => auth()->id(),
                'title' => request('title'),
                'url' => $path . $filename,
            ]);

        }

        return response()->redirectToRoute('dashboard.images.create')->with('success', 'Image uploaded successfully');
    }

    public function images(): Response
    {
        $hallImages = HallImage::all()->reverse();
        return response()->view('dashboard.images.index', compact('hallImages'));
    }

    public function destroyImage(HallImage $hallImage): RedirectResponse
    {
        if (Auth::user()->usertype == 'admin' || Auth::id() == $hallImage->user_id) {
            $oldImage = $hallImage->url;
            if (file_exists($oldImage)) {
                unlink($oldImage);
            }
            $hallImage->delete();
            return response()->redirectToRoute('dashboard.images')->with('success', 'Image deleted successfully');
        } else {
            return response()->redirectToRoute('dashboard.images')->with('error', 'You are not authorized to delete this image');
        }
    }

    public function showImage(HallImage $hallImage): Response
    {
        return response()->view('dashboard.images.show', compact('hallImage'));
    }

    public function editImage(HallImage $hallImage): Response
    {
        return response()->view('dashboard.images.edit', ['hallImage' => $hallImage, 'halls' => Hall::all()]);
    }

    public function updateImage(HallImage $hallImage): RedirectResponse
    {
        request()->validate([
            'hall' => 'required|exists:halls,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'title' => 'nullable|string|max:255',
        ]);

        $image = request('image');
        if ($image != null) {
            $oldImage = $hallImage->url;
            if (file_exists($oldImage)) {
                unlink($oldImage);
            }

            $extension = $image->getClientOriginalExtension();
            $filename = request('hall') . '_' . 1 . "_" . time() . '.' . $extension;
            $path = "img/halls/";

            $image->move($path, $filename);

            $hallImage->update([
                'hall_id' => request('hall'),
                'user_id' => auth()->id(),
                'title' => request('title'),
                'url' => $path . $filename,
            ]);

        } else {
            $hallImage->update([
                'hall_id' => request('hall'),
                'user_id' => auth()->id(),
                'title' => request('title'),
            ]);
        }

        return response()->redirectToRoute('dashboard.images.show', $hallImage)->with('success', 'Image updated successfully');
    }

    //End Images management
}
