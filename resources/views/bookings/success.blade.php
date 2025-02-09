@php
    use Carbon\Carbon;use Illuminate\Support\Facades\Auth;

    $user = Auth::user();
    $hall = $booking->hall;

@endphp
<x-default-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Hall Booking Page') }}
        </h2>
    </x-slot>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css"/>

    <section id="bookingSuccess">
        <div class="cont">
            <div class="alert-success">
                <h2 class="alert-heading">Booking Successful!</h2>
                <p>Your booking has been successfully submitted. You will receive an email confirmation shortly.</p>
                <hr>
                <p class="mb-0">Thank you for choosing us.</p>
            </div>
        </div>
    </section>
    <section id="hallBookingPage">
        <div class="cont">
            @if(Auth::check())
                <div class="left">
                    <div class="heading">
                        <h2>Your Information</h2>
                    </div>
                    <form class="myform">
                        @csrf
                        <div class="input-box">
                            <label for="firstname">First Name</label>
                            <input type="text" readonly value="{{ $user->firstname }}"
                                   id="firstname">
                        </div>

                        <div class="input-box">
                            <label for="lastname">Last Name</label>
                            <input type="text" readonly value="{{ $user->lastname }}" id="lastname">
                        </div>

                        <div class="input-box">
                            <label for="phone">Phone</label>
                            <input type="tel" readonly value="{{ $user->phone }}" id="phone">
                        </div>

                        <div class="input-box">
                            <label for="address">Address</label>
                            <input type="text" readonly value="{{ $user->address }}" id="address">
                        </div>

                        <div class="input-box">
                            <label for="email">Email</label>
                            <input type="email" readonly value="{{ $user->email }}" id="email">
                        </div>

                        <div class="input-box">
                            <label for="hall">Hall *</label>
                            <input type="text" value="{{ $booking->hall->name }}" readonly>
                        </div>

                        <div class="input-box">
                            <label for="booking_date">Date *</label>
                            <input type="text"
                                   value="{{ $booking->booking_date }}" readonly
                                   name="booking_date" id="booking_date"
                                   required>
                        </div>

                        <div class="input-box">
                            <label for="start_time">Start Time *</label>
                            <input type="text"
                                   value="{{ $booking->start_time }}"
                                   id="start_time" readonly required>
                        </div>

                        <div class="input-box">
                            <label for="end_time">End Time *</label>
                            <input type="text"
                                   readonly
                                   value="{{ $booking->end_time }}"
                                   id="end_time" required>
                        </div>

                        <div class="input-box">
                            <label for="purpose">Purpose *</label>
                            <input type="text" value="{{ $booking->purpose }}" id="purpose" readonly>
                            @error('purpose')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="input-box">
                            <label for="description">Description *</label>
                            <input type="text" value="{{ $booking->description }}" readonly>
                        </div>

                        <div class="input-box">
                            <label for="status">Status *</label>
                            <input type="text" value="{{ Str::apa($booking->status) }}" class="{{$booking->status}}"
                                   readonly>
                        </div>

                        <div class="input-box action-btn-form" style="justify-content: flex-end">
                            <button onclick="location.href ='{{ route('dashboard.bookings') }}';" type="button"
                                    class="button primary">
                                Booking Dashboard
                            </button>
                        </div>

                    </form>

                </div>
                @php

                    $start_time = Carbon::parse($booking->booking_date . ' ' . $booking->start_time);
                    $end_time = Carbon::parse($booking->booking_date . ' ' . $booking->end_time);
                    $diff = $start_time->diffInHours($end_time);

                @endphp
                <div class="right">
                    <div class="heading">
                        <h2>Review Your Booking</h2>
                    </div>
                    <div class="review-box" id="review-box">
                        <a class="hall-card" href="{{ route('halls.show', $hall) }}">
                            <div class="hall-image">
                                <img src="{{ url($hall->image) }}" alt="{{ $hall->name }}">
                            </div>
                            <div class="hall-title">
                                <h3>{{ $hall->name }}</h3>
                                <p>{{ $hall->description }}</p>
                            </div>
                            <div class="ratings">
                                @php($ratingAvg = number_format($hall->reviews->avg('rating'), 1, '.', '') )

                                <span class="rate">{{ $ratingAvg }}</span><span class="rate-text">@if($ratingAvg == 5)
                                        Excellent
                                    @elseif($ratingAvg >= 4)
                                        Very Good
                                    @elseif($ratingAvg >= 3)
                                        Average
                                    @elseif($ratingAvg >= 2)
                                        Poor
                                    @elseif($ratingAvg >= 1)
                                        Terrible
                                    @else
                                        No Rating
                                    @endif</span>
                                <span class="num-rate">{{ $hall->reviews->count() }} Reviews</span>
                            </div>
                            <div class="hall-features">
                                <p>Price : <span>LKR {{ $hall->price }}</span> / Hour</p>
                            </div>
                        </a>
                        <hr class="review-hr">
                        <div class="booking-details">
                            <div class="booking-date">
                                <h4>Booking Date</h4>
                                <p>{{ $booking->booking_date }}</p>
                            </div>
                            <div class="booking-time">
                                <h4>Booking Time</h4>
                                <p>{{ $booking->start_time }} - {{ $booking->end_time }}</p>
                            </div>
                        </div>
                        <hr class="review-hr">
                        <div class="price-details">
                            <div class="hall-date">
                                <h4>Price per Hour</h4>
                                <p>LKR {{ $hall->price }} / h</p>
                            </div>
                            <div class="booking-time">
                                <h4>Selected hours</h4>
                                <p>{{ $diff }} h</p>
                            </div>
                        </div>
                        <hr class="review-hr">
                        <div class="total-price-details">
                            <div class="hall-date">
                                <h4>Total Price</h4>
                                <p>LKR {{ $hall->price * $diff }}</p>
                            </div>
                        </div>

                    </div>
                </div>

            @else
                <div class="alert alert-danger" role="alert">
                    You need to login to book a hall.
                </div>
            @endif


        </div>
    </section>


</x-default-layout>
