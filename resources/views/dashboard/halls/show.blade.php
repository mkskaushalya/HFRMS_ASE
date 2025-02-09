@php
    use Illuminate\Support\Facades\Auth;
    $usertype = Auth::user()->usertype;

    $users = App\Models\User::all();
    $bookings = App\Models\HallBooking::all();
    $halls = App\Models\Hall::all();
@endphp
<x-app-layout>
    <x-dashboard>
        <x-slot:header>{{ __('Dashboard') }} </x-slot:header>
        <x-slot:contentTitle> {{ __($hall->name) }}</x-slot:contentTitle>
        <x-slot:contentDescription> {{ __($hall->description) }}</x-slot:contentDescription>
        @if ($usertype == 'admin')
            <div class="cont">
                <div class="hall">
                    <div class="hall-img">
                        <img src="{{ url($hall->image) }}" alt=""
                            style="width: 100%; max-height: 250px; object-fit: cover;">
                    </div>
                    <div class="hall-info" style="padding: 40px 0 20px 0;">
                        <p>Location : {{ $hall->hallLocation->location }}</p>
                        <p>Hall Number : {{ $hall->hall_number }}</p>
                        <p>Capacity : {{ $hall->capacity }}</p>
                        <p>Price : {{ $hall->price }}</p>

                    </div>
                    <div id="hall-gallery">
                        <div class="cont">
                            <div class="gallery">
                                <!-- Swiper -->

                                <div style="--swiper-navigation-color: #fff; --swiper-pagination-color: #fff"
                                    class="swiper mySwiper2">
                                    <div class="swiper-wrapper">
                                        @foreach ($hall->hallImages as $image)
                                            <div class="swiper-slide">
                                                <img src="{{ url($image->url) }}" />
                                            </div>
                                        @endforeach

                                    </div>
                                    <div class="swiper-button-next"></div>
                                    <div class="swiper-button-prev"></div>
                                </div>
                                <div thumbsSlider="" class="swiper mySwiper">
                                    <div class="swiper-wrapper">
                                        @foreach ($hall->hallImages as $image)
                                            <div class="swiper-slide">
                                                <img src="{{ url($image->url) }}" />
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                    <div class="actions">
                        <button onclick="location.href ='{{ route('dashboard.halls.edit', $hall) }}';"
                            class="button edit">
                            Edit
                        </button>
                        <button class="button delete"
                            onclick="return confirm('Are you sure you want to delete this hall?')"
                            form="delete_hall_{{ $hall->id }}">Delete
                        </button>
                        <form id="delete_hall_{{ $hall->id }}"
                            action="{{ route('dashboard.halls.destroy', $hall) }}" method="POST"
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
