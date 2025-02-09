<?php

namespace App\Http\Controllers;

use App\Models\Hall;
use App\Models\HallBooking;
use App\Models\HallImage;
use App\Models\HallLocation;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class DashboardController extends Controller
{
    private $user, $users, $bookings, $halls, $hallImages;

    public function __construct()
    {
        if (!Auth::check()) {
            return response()->redirectToRoute('login');
        } elseif (Auth::user()->usertype == 'admin') {
            $this->users = User::all();
            $this->bookings = HallBooking::all()->reverse();
            $this->hallImages = HallImage::all()->reverse();
            $this->halls = Hall::all();
            $this->user = Auth::user();
        } else if (Auth::user()->usertype == 'user') {
            $this->users = User::where('id', Auth::user()->id)->get();
            $this->bookings = HallBooking::where('user_id', Auth::user()->id)->get();
            $this->halls = Hall::where('user_id', Auth::user()->id)->get();
            $this->user = Auth::user();
        }
    }

    public function index(): Response
    {

        return response()->view('dashboard.index', [
            'user' => $this->user,
            'users' => $this->users,
            'bookings' => $this->bookings,
            'halls' => $this->halls,
            'hallImages' => $this->hallImages,
        ]);
    }

    //Dashboard


    //Halls management

    public function halls(): Response
    {
        return response()->view('dashboard.halls.index');
    }

    public function showHall(Hall $hall): Response
    {
        return response()->view('dashboard.halls.show', ['hall' => $hall]);
    }

    public function createHall(): Response
    {
        $locations = HallLocation::all();

        return response()->view('dashboard.halls.create', ['locations' => $locations]);
    }

    public function storeHall(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required',
            'hall_number' => 'required',
            'description' => 'required',
            'capacity' => 'required',
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg,webp', 'max:2048'],
            'price' => 'required',
            'location' => 'required',
        ]);

        $image = $request->file('image');
        $extension = $image->getClientOriginalExtension();
        $filename = request('hall_number') . "_" . time() . '.' . $extension;
        $path = "img/halls/";
        $image->move($path, $filename);


        Hall::create([
            'name' => $request['name'],
            'hall_number' => $request['hall_number'],
            'description' => $request['description'],
            'capacity' => $request['capacity'],
            'price' => $request['price'],
            'image' => $path . $filename,
            'hall_location_id' => $request['location'],
            'user_id' => $this->user->id,
        ]);

        return response()->redirectToRoute('dashboard.halls');
    }

    public function editHall(Hall $hall): Response
    {
        $locations = HallLocation::all();

        return response()->view('dashboard.halls.edit', ['hall' => $hall, 'locations' => $locations]);
    }

    public function updateHall(Hall $hall): RedirectResponse
    {
        $data = request()->validate([
            'name' => 'required',
            'hall_number' => 'required',
            'description' => 'required',
            'capacity' => 'required',
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg,webp', 'max:2048'],
            'price' => 'required',
            'location' => 'required',
        ]);

        if (request('image')) {
            //Delete the old image
            $old_image = $hall->image;
            $old_image = str_replace('img/halls/', '', $old_image);
            unlink('img/halls/' . $old_image);

            $image = request()->file('image');
            $extension = $image->getClientOriginalExtension();
            $filename = request('hall_number') . "_" . time() . '.' . $extension;
            $path = "img/halls/";
            $image->move($path, $filename);
        }

        $hall->update([
            'name' => $data['name'],
            'hall_number' => $data['hall_number'],
            'description' => $data['description'],
            'capacity' => $data['capacity'],
            'image' => $path . $filename,
            'price' => $data['price'],
            'hall_location_id' => $data['location'],
        ]);

        return response()->redirectTo(route('dashboard.halls.show', $hall));
    }

    public function destroyHall(Hall $hall): RedirectResponse
    {
        $hall->delete();

        return response()->redirectToRoute('dashboard.halls');
    }

    //End Halls management


    //Users management
    public function users(): Response
    {
        return response()->view('dashboard.users.index');
    }

    public function showUser(User $user): Response  //This is the show method
    {
        return response()->view('dashboard.users.show', ['user' => $user]);

    }

    public function createUser(): Response
    {
        return response()->view('dashboard.users.create');
    }

    public function storeUser(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'usertype' => ['required'],
        ]);

        User::create([
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'phone' => $data['phone'],
            'address' => $data['address'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'usertype' => $data['usertype'],
        ]);

        return response()->redirectToRoute('dashboard.users');
    }

    public function editUser(User $user): Response
    {
        return response()->view('dashboard.users.edit', ['user' => $user]);
    }

    public function updateUser(User $user): RedirectResponse
    {
        if (request('password') and request('password_confirmation') and request('password') !== '' and request('password_confirmation') !== '' and request('password') === request('password_confirmation')) {
            $data = request()->validate([
                'firstname' => ['required', 'string', 'max:255'],
                'lastname' => ['required', 'string', 'max:255'],
                'phone' => ['required', 'string', 'max:255'],
                'address' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class . ',email,' . $user->id],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
                'usertype' => ['required'],
            ]);

            $user->update([
                'firstname' => $data['firstname'],
                'lastname' => $data['lastname'],
                'phone' => $data['phone'],
                'address' => $data['address'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'usertype' => $data['usertype'],
            ]);

        } else {
            $data = request()->validate([
                'firstname' => ['required', 'string', 'max:255'],
                'lastname' => ['required', 'string', 'max:255'],
                'phone' => ['required', 'string', 'max:255'],
                'address' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class . ',email,' . $user->id],
                'usertype' => ['required'],
            ]);

            $user->update([
                'firstname' => $data['firstname'],
                'lastname' => $data['lastname'],
                'phone' => $data['phone'],
                'address' => $data['address'],
                'email' => $data['email'],
                'usertype' => $data['usertype'],
            ]);
        }

        return response()->redirectTo(route('dashboard.users.show', $user));
    }

    public function destroyUser(User $user): RedirectResponse
    {
        $user->delete();

        return response()->redirectToRoute('dashboard.users');
    }

    //End Users management

    //Booking management
    public function bookings(): Response
    {
        return response()->view('dashboard.bookings.index', ['bookings' => $this->bookings]);
    }

    public function showBooking(HallBooking $booking): Response
    {
        return response()->view('dashboard.bookings.show', ['booking' => $booking, 'halls' => $this->halls, 'users' => $this->users]);
    }

    public function createBooking(): Response
    {
        return response()->view('dashboard.bookings.create', ['halls' => $this->halls, 'users' => $this->users]);
    }

    public function storeBooking(): RedirectResponse
    {
        if (Auth::user()->usertype == 'admin') {
            $data = request()->validate([
                'hall' => 'required',
                'user' => 'required',
                'booking_date' => 'required',
                'start_time' => 'required',
                'end_time' => 'required',
                'status' => 'required',
                'purpose' => 'required',
                'description' => 'required',
                'payment' => 'required',

            ]);

            HallBooking::create([
                'hall_id' => $data['hall'],
                'user_id' => $data['user'],
                'booking_date' => $data['booking_date'],
                'start_time' => $data['start_time'],
                'end_time' => $data['end_time'],
                'purpose' => $data['purpose'],
                'description' => $data['description'],
                'payment' => $data['payment'],
                'status' => $data['status'],
            ]);
        } else {
            abort(403);
        }
        return response()->redirectToRoute('dashboard.bookings');
    }

    public function editBooking(HallBooking $booking): Response
    {
        return response()->view('dashboard.bookings.edit', ['booking' => $booking, 'halls' => $this->halls, 'users' => $this->users]);
    }

    public function updateBooking(HallBooking $booking): RedirectResponse
    {
        if (Auth::user()->id == $booking->user_id || Auth::user()->usertype == 'admin') {
            if (Auth::user()->usertype == 'admin') {
                $data = request()->validate([
                    'hall' => 'required',
                    'user' => 'required',
                    'booking_date' => 'required',
                    'start_time' => 'required',
                    'end_time' => 'required',
                    'status' => 'required',
                    'purpose' => 'required',
                    'description' => 'required',
                    'payment' => 'required',
                ]);

                $booking->update([
                    'hall_id' => $data['hall'],
                    'user_id' => $data['user'],
                    'booking_date' => $data['booking_date'],
                    'start_time' => $data['start_time'],
                    'end_time' => $data['end_time'],
                    'purpose' => $data['purpose'],
                    'description' => $data['description'],
                    'payment' => $data['payment'],
                    'status' => $data['status'],
                ]);
            } elseif (Auth::user()->usertype == 'user') {
                $data = request()->validate([
                    'booking_date' => 'required',
                    'start_time' => 'required',
                    'end_time' => 'required',
                    'purpose' => 'required',
                    'description' => 'required',
                ]);

                $booking->update([
                    'booking_date' => $data['booking_date'],
                    'start_time' => $data['start_time'],
                    'end_time' => $data['end_time'],
                    'purpose' => $data['purpose'],
                    'description' => $data['description'],
                ]);
            }
        } else {
            abort(403);
        }

        return response()->redirectTo(route('dashboard.bookings.show', $booking));
    }

    public function destroyBooking(HallBooking $booking): RedirectResponse
    {
        if (Auth::user()->id == $booking->user_id || Auth::user()->usertype == 'admin') {
            $booking->delete();
        } else {
            abort(403);
        }
        return response()->redirectToRoute('dashboard.bookings');
    }

    public function approveBooking(HallBooking $booking)
    {
        if (Auth::user()->usertype == 'user') {
            return response()->redirectToRoute('dashboard.bookings');
        } else if (Auth::user()->usertype == 'admin') {
            $booking->update([
                'status' => 'approved',
            ]);
        }


        return back();

    }

    public function rejectBooking(HallBooking $booking)
    {
        if (Auth::user()->usertype == 'user') {
            return response()->redirectToRoute('dashboard.bookings');
        } else if (Auth::user()->usertype == 'admin') {

            $booking->update([
                'status' => 'rejected',
            ]);
        }
        return back();

    }

    //End Booking management


}
