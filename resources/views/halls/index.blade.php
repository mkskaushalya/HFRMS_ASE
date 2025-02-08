@php use Carbon\Carbon; @endphp
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

    <section id="hall-search">
        <div class="cont">
            <div class="heading"><h2>Search Hall</h2></div>
            <div class="search-form">
                <form action="" method="GET">
                    <div class="input-box">
                        <label for="location">Location</label>
                        <select name="location" id="location">
                            @foreach($locations as $location )
                                <option
                                    value="{{ $location->id }}"
                                    @if($request->location == $location->id) selected @endif>{{ $location->location }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="input-box">
                        <label for="booking_date">Date</label>
                        <input type="date"
                               value="{{ isset($request->booking_date) || $request->booking_date != null ||  $request->booking_date != "" ? $request->booking_date : today()->format("Y-m-d")  }}"
                               min="{{ today()->format("Y-m-d") }}"
                               name="booking_date" id="booking_date" placeholder="Select Date">
                    </div>
                    <div class="input-box">
                        <label for="start_time">Start Time</label>
                        <input type="time"
                               value="{{ isset($request->start_time) || $request->start_time != null ||  $request->start_time != "" ? $request->start_time : "09:00"  }}"
                               name="start_time" id="start_time" placeholder="Select Time">
                    </div>
                    <div class="input-box">
                        <label for="end_time">End Time</label>
                        <input type="time"
                               value="{{ isset($request->end_time) || $request->end_time != null ||  $request->end_time != "" ? $request->end_time : "17:00"  }}"
                               name="end_time" id="end_time" placeholder="Select Time">
                    </div>

                    <div class="input-box">
                        <button type="submit">Search</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <section id="hall-results">
        <div class="left">
            <div class="cont">
                <div class="heading"><h2>Filter</h2></div>
                <div class="filter-form">

                </div>
            </div>
        </div>
        <div class="right">
            <div class="cont">
                <div class="heading"><h2>Available Halls</h2></div>
                <div class="hall-list">

                    <hr class="review-hr" style="background-color: var(--bg-color-2)">
                    {{-- Display all halls --}}
                    @foreach($halls as $hall)
                        @php
                            $data = isset($request->booking_date) && isset($request->start_time) && isset($request->end_time);
                            $start_time = Carbon::parse($request->booking_date . ' ' . $request->start_time);
                            $end_time = Carbon::parse($request->booking_date . ' ' . $request->end_time);
                            $diff = $start_time->diffInHours($end_time);

                            $bookings = $hall->bookings()->where('booking_date', $request->booking_date)->get();

                        @endphp
                        <div class="hall">
                            <div class="hall-img">
                                <img src="{{ $hall->image }}" alt="Hall Image">
                            </div>
                            <div class="hall-info">
                                <a href="{{ route('halls.show', $hall) }}" class="hall-title">
                                    <h3>{{ $hall->name }}</h3>
                                    <p>{{ $hall->description }}</p>
                                </a>
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
                                    <p>Location: <span>{{ $hall->hallLocation->location }}</span></p>
                                    <p>Capacity: <span>{{ $hall->capacity  }}</span></p>
                                    <p>Price : <span>LKR {{ $hall->price }} / Hour</span></p>
                                    @if($data)
                                        <p>Selected hours : <span>{{ ceil($diff)}}</span></p>
                                        <p>Selected Price:
                                            <span class="highlight warning">LKR {{ $hall->price * ceil($diff) }}</span>
                                        </p>
                                    @endif

                                </div>

                                <a class="button"
                                   href="{{ route('halls.show', $hall)  }}{{ $data ? '?booking_date='.$request->booking_date .'&start_time='. $request->start_time.'&end_time='.$request->end_time.'#hall-availability' : ""}}">Book
                                    Now</a>
                            </div>
                        </div>
                        <hr class="review-hr" style="background-color: var(--bg-color-2)">
                    @endforeach

                </div>
            </div>
        </div>

    </section>

</x-default-layout>
