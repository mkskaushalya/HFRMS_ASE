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
        <x-slot:contentTitle> {{ __('Edit Hall') }}</x-slot:contentTitle>
        <x-slot:contentDescription> {{ __('Welcome to hall management dashboard.') }}</x-slot:contentDescription>
        @if ($usertype == 'admin')
            <div class="cont">
                <form method="POST" action="{{ route('dashboard.halls.show', $hall) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')

                    @if ($errors->any())
                        <div class="input-box">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li style="color: red">{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="input-box">
                        <label for="hall_number">Hall Number *</label>
                        <input type="text" value="{{ $hall->hall_number }}" name="hall_number" id="hall_number"
                            placeholder="Enter Hall Number" required>
                    </div>

                    <div class="input-box">
                        <label for="name">Hall Name *</label>
                        <input type="text" name="name" id="name" placeholder="Enter Hall Name"
                            value="{{ $hall->name }}" required>
                    </div>

                    <div class="input-box">
                        <label for="description">Description</label>
                        <textarea name="description" id="description" placeholder="Enter Hall Description">{{ $hall->description }}</textarea>
                    </div>

                    <div class="input-box">
                        <label for="location">Location *</label>
                        <select name="location" id="location" required>
                            @foreach ($locations as $location)
                                <option value="{{ $location->id }}" @if ($location->id == $hall->hall_location_id) selected @endif>
                                    {{ $location->location }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="input-box">
                        <label for="capacity">Capacity *</label>
                        <input type="number" value="{{ $hall->capacity }}" name="capacity" id="capacity"
                            placeholder="Enter Hall Capacity" required>
                    </div>

                    <div class="input-box">
                        <label for="price">Price *</label>
                        <input type="number" value="{{ $hall->price }}" name="price" id="price"
                            placeholder="Enter Hall Price" required>
                    </div>

                    <div class="input-box">
                        <label for="image">Image</label>
                        <input type="file" name="image" id="image">
                    </div>

                    <div class="input-box">
                        <button type="submit" class="button">Update Hall</button>
                    </div>

                </form>
            </div>
        @else
            {{ abort(403) }}
        @endif
    </x-dashboard>
</x-app-layout>
