@php
    use Illuminate\Support\Facades\Auth;
    $usertype = Auth::user()->usertype;

@endphp
<x-app-layout>
    <x-dashboard>
        <x-slot:header>{{ __('Dashboard') }} </x-slot:header>
        <x-slot:contentTitle> {{ __('Booking Management') }}</x-slot:contentTitle>
        <x-slot:contentDescription> {{ __('Welcome to booking management dashboard.') }}</x-slot:contentDescription>
        @if($usertype == 'admin' || $usertype == 'user')
            <div class="header">
                <div class="add-btn">
                    <a href="{{ $usertype == 'admin' ? route('dashboard.bookings.create') : route('halls') }}"
                       class="button">Add Booking</a>
                </div>
                <div class="search-bar">
                    <div class="search-box">
                        <input type="search">
                    </div>
                    <div class="search-btn button">Search</div>
                </div>
            </div>
            <div class="dashcont">
                <table>
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Hall</th>
                        <th>User</th>
                        <th>Booking Date</th>
                        <th>Booking Time</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if($bookings->isEmpty())
                        <tr>
                            <td colspan="9">No booking found</td>
                        </tr>

                    @else
                        @foreach($bookings as $booking)

                            <tr>
                                <td style="cursor: pointer"
                                    onclick="location.href ='{{ route('dashboard.bookings.show', $booking) }}';">{{ $booking->id }}</td>
                                <td style="cursor: pointer"
                                    onclick="location.href ='{{ route('dashboard.bookings.show', $booking) }}';">{{ $booking->hall->name }}</td>
                                <td style="cursor: pointer"
                                    onclick="location.href ='{{ route('dashboard.bookings.show', $booking) }}';">{{ $booking->user->firstname }} {{ $booking->user->lastname }}</td>
                                <td style="cursor: pointer"
                                    onclick="location.href ='{{ route('dashboard.bookings.show', $booking) }}';">{{ $booking->booking_date }}</td>
                                <td style="cursor: pointer"
                                    onclick="location.href ='{{ route('dashboard.bookings.show', $booking) }}';">{{ $booking->start_time }}
                                    - {{ $booking->end_time }}</td>
                                <td style="cursor: pointer"
                                    onclick="location.href ='{{ route('dashboard.bookings.show', $booking) }}';"
                                    class="status"><span class="{{$booking->status}}">{{ $booking->status }}</span></td>
                                <td class="tbl_action">
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
                                </td>
                            </tr>

                        @endforeach
                    @endif

                    </tbody>
                </table>

            </div>

        @else
            {{ abort(403) }}
        @endif
    </x-dashboard>
</x-app-layout>
