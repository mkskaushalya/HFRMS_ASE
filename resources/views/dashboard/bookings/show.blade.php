@php
    use Illuminate\Support\Facades\Auth;
    $usertype = Auth::user()->usertype;

@endphp
<x-app-layout>
    <x-dashboard>
        <x-slot:header>{{ __('Dashboard') }} </x-slot:header>
        <x-slot:contentTitle> {{ __('User details') }}</x-slot:contentTitle>
        <x-slot:contentDescription> {{ __('This page shown a user information\'s.') }}</x-slot:contentDescription>
        @if($usertype == 'admin' || ($usertype == 'user' && $booking->user_id == Auth::id()))
            <div class="cont">
                <div class="booking">
                    <div class="booking-info">
                        <p>Id : {{ $booking->id }}</p>
                        <p>Hall : {{ $booking->hall->name }}</p>
                        <p>User : {{ $booking->user->firstname }} {{ $booking->user->lastname }}</p>
                        <p>Booking Date : {{ $booking->booking_date }}</p>
                        <p>Booking Time : {{ $booking->start_time }} - {{ $booking->end_time }}</p>
                        <p>Status : <span class="{{$booking->status}}">{{ $booking->status }}</span></p>
                        <p>Purpose : {{ $booking->purpose }}</p>
                        <p>Description : {{ $booking->description }}</p>
                        <p>Payment : {{ $booking->payment }}</p>
                    </div>
                    <div class="actions">
                        @if($usertype == 'admin')
                            <button form="approve_booking_{{$booking->id }}"
                                    class="button success">Approve
                            </button>
                            <form id="approve_booking_{{$booking->id}}"
                                  action="{{ route('dashboard.bookings.approve', $booking) }}"
                                  method="POST"
                                  style="display: none">
                                @csrf
                                @method('PATCH')
                            </form>
                            <button form="reject_booking_{{$booking->id }}"
                                    class="button delete">Reject
                            </button>
                            <form id="reject_booking_{{$booking->id}}"
                                  action="{{ route('dashboard.bookings.reject', $booking) }}"
                                  method="POST"
                                  style="display: none">
                                @csrf
                                @method('PATCH')
                            </form>
                        @endif
                        @if ($booking->status == 'pending' && $usertype == 'user')
                        <button onclick="location.href ='{{ route('dashboard.bookings.edit', $booking) }}';"
                                class="button edit">
                            Edit
                        </button>
                        <button class="button delete"
                                onclick="return confirm('Are you sure you want to delete this booking?')"
                                form="delete_booking_{{$booking->id }}">Delete
                        </button>
                       
                        <form id="delete_booking_{{$booking->id}}"
                              action="{{ route('dashboard.bookings.destroy', $booking) }}"
                              method="POST"
                              style="display: none">
                            @csrf
                            @method('DELETE')
                        </form>
                        @endif
                    </div>
                </div>
            </div>

        @else
            {{ abort(403) }}
        @endif
    </x-dashboard>
</x-app-layout>
