@php
    use Illuminate\Support\Facades\Auth;
    $usertype = Auth::user()->usertype;

@endphp
<x-app-layout>
    <x-dashboard>
        <x-slot:header>{{ __('Dashboard') }} </x-slot:header>
        <x-slot:contentTitle> {{ __('User details') }}</x-slot:contentTitle>
        <x-slot:contentDescription> {{ __('This page shown a user information\'s.') }}</x-slot:contentDescription>
        @if($usertype == 'admin' || ($usertype == 'user' && $hallImage->user_id == Auth::id()))
            <div class="cont">
                <div class="booking">
                    <div class="booking-info">
                        <p>Id : {{ $hallImage->id }}</p>
                        <p>Hall : {{ $hallImage->hall->name }}</p>
                        <p>User : {{ $hallImage->user->firstname }} {{ $hallImage->user->lastname }}</p>
                        <p>Booking Date : {{ $hallImage->title }}</p>
                        <img src="{{ url($hallImage->url) }}" alt="" style="max-width: 400px">
                    </div>
                    <div class="actions">

                        <button onclick="location.href ='{{ route('dashboard.images.edit', $hallImage) }}';"
                                class="button edit">
                            Edit
                        </button>
                        <button class="button delete"
                                onclick="return confirm('Are you sure you want to delete this booking?')"
                                form="delete_booking_{{$hallImage->id }}">Delete
                        </button>

                        <form id="delete_booking_{{$hallImage->id}}"
                              action="{{ route('dashboard.images.destroy', $hallImage) }}"
                              method="POST"
                              style="display: none">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                </div>
            </div>

        @else
            {{ abort(403) }}
        @endif
    </x-dashboard>
</x-app-layout>
