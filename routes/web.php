<?php

use App\Http\Controllers\APIController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HallBookingController;
use App\Http\Controllers\HallBookingTempController;
use App\Http\Controllers\HallController;
use App\Http\Controllers\HallImageController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use App\Models\Hall;
use App\Models\HallLocation;
use App\Models\Review;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;


//Artisan Commands
Route::get('/clear-routes', function () {
    Artisan::call('route:clear');
    return 'Routes cleared';
});

Route::get('/optimize-app', function () {
    Artisan::call('optimize');
    return 'Application optimized';
});

Route::get('/clear-cache', function () {
    Artisan::call('cache:clear');
    return 'Cache cleared';
});

Route::get('/migrate-fresh', function () {
    Artisan::call('migrate:fresh');
    return 'Database migrated and seeded';
});

//seed database
Route::get('/seed', function () {
    Artisan::call('db:seed');
    return 'Database seeded';
});

//Static Pages
Route::view('home', 'index');
Route::view('tinyfilemanager', 'tinyfilemanager');
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::view('about', 'about')->name('about');
Route::view('contact', 'contact')->name('contact');


//Hall Routes
Route::controller(HallController::class)->group(function () {
    Route::get('halls', 'index')->name('halls');
    Route::get('halls/{hall}', 'show')->name('halls.show');
});

Route::controller(HallBookingTempController::class)->group(function () {
    Route::post('halls/{hall}/booking', 'hallBookingTemp')->name('halls.booking.temp');
});

//Review Routes
Route::controller(ReviewController::class)->group(function () {
    Route::get('halls/{hall}/reviews', 'reviews')->middleware(['auth', 'verified'])->name('halls.reviews');
    Route::post('halls/{hall}/reviews', 'storeReview')->middleware(['auth', 'verified'])->name('halls.reviews.store');
    Route::patch('halls/{hall}/reviews/{review}', 'updateReview')->middleware(['auth', 'verified'])->name('halls.reviews.update');
    Route::delete('halls/{hall}/reviews/{review}', 'destroyReview')->middleware(['auth', 'verified'])->name('halls.reviews.destroy');
});
//Review Routes
Route::controller(HallBookingController::class)->group(function () {
    Route::get('bookings/{bookingToken}', 'index')->middleware(['auth', 'verified'])->name('bookings');
    Route::get('bookings/success/{booking}', 'success')->middleware(['auth', 'verified'])->name('bookings.success');
    Route::post('bookings/{bookingToken}', 'storeBooking')->middleware(['auth', 'verified'])->name('bookings.store');
    Route::patch('bookings/{booking}', 'updateBooking')->middleware(['auth', 'verified'])->name('bookings.update');
    Route::delete('bookings/{booking}', 'destroyBooking')->middleware(['auth', 'verified'])->name('bookings.destroy');
});


//Dashboard Routes
Route::controller(DashboardController::class)->group(function () {
    Route::get('dashboard', 'index')->middleware(['auth', 'verified'])->name('dashboard');

    //Halls management
    Route::get('dashboard/halls', 'halls')->middleware(['auth', 'verified'])->name('dashboard.halls');
    Route::get('dashboard/halls/create', 'createHall')->middleware(['auth', 'verified'])->name('dashboard.halls.create');
    Route::post('dashboard/halls', 'storeHall')->middleware(['auth', 'verified'])->name('dashboard.halls.store');
    Route::get('dashboard/halls/{hall}', 'showHall')->middleware(['auth', 'verified'])->name('dashboard.halls.show');
    Route::get('dashboard/halls/{hall}/edit', 'editHall')->middleware(['auth', 'verified'])->name('dashboard.halls.edit');
    Route::patch('dashboard/halls/{hall}', 'updateHall')->middleware(['auth', 'verified'])->name('dashboard.halls.update');
    Route::delete('dashboard/halls/{hall}', 'destroyHall')->middleware(['auth', 'verified'])->name('dashboard.halls.destroy');

    //Users management
    Route::get('dashboard/users', 'users')->middleware(['auth', 'verified'])->name('dashboard.users');
    Route::get('dashboard/users/create', 'createUser')->middleware(['auth', 'verified'])->name('dashboard.users.create');
    Route::post('dashboard/users', 'storeUser')->middleware(['auth', 'verified'])->name('dashboard.users.store');
    Route::get('dashboard/users/{user}', 'showUser')->middleware(['auth', 'verified'])->name('dashboard.users.show');
    Route::get('dashboard/users/{user}/edit', 'editUser')->middleware(['auth', 'verified'])->name('dashboard.users.edit');
    Route::patch('dashboard/users/{user}', 'updateUser')->middleware(['auth', 'verified'])->name('dashboard.users.update');
    Route::delete('dashboard/users/{user}', 'destroyUser')->middleware(['auth', 'verified'])->name('dashboard.users.destroy');

    //Booking management
    Route::get('dashboard/bookings', 'bookings')->middleware(['auth', 'verified'])->name('dashboard.bookings');
    Route::get('dashboard/bookings/create', 'createBooking')->middleware(['auth', 'verified'])->name('dashboard.bookings.create');
    Route::post('dashboard/bookings', 'storeBooking')->middleware(['auth', 'verified'])->name('dashboard.bookings.store');
    Route::get('dashboard/bookings/{booking}', 'showBooking')->middleware(['auth', 'verified'])->name('dashboard.bookings.show');
    Route::get('dashboard/bookings/{booking}/edit', 'editBooking')->middleware(['auth', 'verified'])->name('dashboard.bookings.edit');
    Route::patch('dashboard/bookings/{booking}', 'updateBooking')->middleware(['auth', 'verified'])->name('dashboard.bookings.update');
    Route::patch('dashboard/bookings/{booking}/approve', 'approveBooking')->middleware(['auth', 'verified'])->name('dashboard.bookings.approve');
    Route::patch('dashboard/bookings/{booking}/reject', 'rejectBooking')->middleware(['auth', 'verified'])->name('dashboard.bookings.reject');
    Route::delete('dashboard/bookings/{booking}', 'destroyBooking')->middleware(['auth', 'verified'])->name('dashboard.bookings.destroy');
});

//Hall Image Routes
Route::controller(HallImageController::class)->group(function () {
    Route::get('dashboard/images', 'images')->middleware(['auth', 'verified'])->name('dashboard.images');
    Route::get('dashboard/images/create', 'createImage')->middleware(['auth', 'verified'])->name('dashboard.images.create');
    Route::post('dashboard/images', 'storeImage')->middleware(['auth', 'verified'])->name('dashboard.images.store');
    Route::get('dashboard/images/{hallImage}', 'showImage')->middleware(['auth', 'verified'])->name('dashboard.images.show');
    Route::get('dashboard/images/{hallImage}/edit', 'editImage')->middleware(['auth', 'verified'])->name('dashboard.images.edit');
    Route::patch('dashboard/images/{hallImage}', 'updateImage')->middleware(['auth', 'verified'])->name('dashboard.images.update');
    Route::delete('dashboard/images/{hallImage}', 'destroyImage')->middleware(['auth', 'verified'])->name('dashboard.images.destroy');
});


//API Routes
Route::controller(APIController::class)->group(function () {
    Route::get('api', 'index')->name('api');
    Route::get('api/halls', 'halls')->name('api.halls');
    Route::get('api/halls/{hall}', 'findHall')->name('api.halls.show');
    Route::get('api/halls/{hall}/{date}/{start_time}/{end_time}', 'checkHall')->name('api.halls.check');
    Route::get('api/halls/{location}/{date}/{start_time}/{end_time}', 'getAvailableHalls')->name('api.halls.available');
    Route::post('api/halls/{hall}/book', 'bookHall')->name('api.halls.book');
    Route::get('api/bookings', 'bookings')->name('api.bookings');
    Route::get('api/bookings/{booking}', 'showBooking')->name('api.bookings.show');
    Route::post('api/bookings/{booking}/approve', 'approveBooking')->name('api.bookings.approve');
    Route::post('api/bookings/{booking}/reject', 'rejectBooking')->name('api.bookings.reject');
});

//Route::get('dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');
//Route::get('dashboard/halls', [DashboardController::class, 'halls'])->middleware(['auth', 'verified'])->name('dashboard.halls');
//Route::get('dashboard/halls/create', [DashboardController::class, 'create'])->middleware(['auth', 'verified'])->name('dashboard.halls.create');
//Route::post('dashboard/halls', [DashboardController::class, 'store'])->middleware(['auth', 'verified'])->name('dashboard.halls.store');
//Route::get('dashboard/halls/{hall}/edit', [DashboardController::class, 'edit'])->middleware(['auth', 'verified'])->name('dashboard.halls.edit');
//Route::patch('dashboard/halls/{hall}', [DashboardController::class, 'update'])->middleware(['auth', 'verified'])->name('dashboard.halls.update');
//Route::delete('dashboard/halls/{hall}', [DashboardController::class, 'destroy'])->middleware(['auth', 'verified'])->name('dashboard.halls.destroy');

//Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__ . '/auth.php';
