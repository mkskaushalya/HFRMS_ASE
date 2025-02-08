@php
    use Illuminate\Support\Facades\Auth;
    $usertype = Auth::user()->usertype;

@endphp
<x-app-layout>
    <x-dashboard>
        <x-slot:header>{{ __('Dashboard') }} </x-slot:header>
        <x-slot:contentTitle> {{ __('Edit Booking') }}</x-slot:contentTitle>
        <x-slot:contentDescription> {{ __('Welcome to booking management dashboard.') }}</x-slot:contentDescription>
        @if($usertype == 'admin' || ($usertype == 'user' && $booking->user_id == Auth::id() && $booking->status == 'pending'))
            <div class="cont">
                <form method="POST" autocomplete="off" action="{{ route('dashboard.bookings.show', $booking)}}">
                    @csrf
                    @method('PATCH')

                    <div class="input-box">
                        @if($errors->any())
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li class="error">{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif
                    </div>

                    <div class="input-box">
                        <label for="hall">Hall *</label>
                        @if($usertype == 'admin')
                            <select name="hall" id="hall" required>
                                @foreach($halls as $hall)
                                    <option value="{{ $hall->id }}"
                                            @if(old('hall') ==  $hall->id || $booking->hall->id == $hall->id) selected @endif>{{ $hall->name }}</option>
                                @endforeach
                            </select>
                        @elseif($usertype == 'user')
                            <input type="text" value="{{ $booking->hall->name }}" name="hall" id="hall" readonly>
                        @endif

                        @error('hall')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    @if($usertype == 'admin')
                        <div class="input-box">
                            <label for="user">User *</label>

                            <select name="user" id="user" required>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}"
                                            @if(old('user') ==  $user->id || $booking->user->id == $user->id ) selected @endif>{{ $user->firstname }} {{ $user->lastname }}</option>
                                @endforeach
                            </select>
                            @error('user')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                    @endif


                    <div class="input-box">
                        <label for="booking_date">Date *</label>
                        <input type="date"
                               value="@if(old('booking_date') != null){{old('booking_date')}}@else{{$booking->booking_date}}@endif"
                               name="booking_date" id="booking_date"
                               required>
                        @error('booking_date')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="input-box">
                        <label for="start_time">Start Time *</label>
                        <input type="time"
                               value="@if(old('start_time') != null){{ old('start_time')}}@else{{$booking->start_time}}@endif"
                               name="start_time" id="start_time" required>
                        @error('start_time')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="input-box">
                        <label for="end_time">End Time *</label>
                        <input type="time"
                               value="@if(old('end_time') != null){{ old('end_time') }}@else{{$booking->end_time}}@endif"
                               name="end_time" id="end_time" required>
                        @error('end_time')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                    @if($usertype == 'admin')
                        <div class="input-box">
                            <label for="status">Status *</label>
                            <select name="status" id="status" required>
                                <option value="pending"
                                        @if($booking->status == 'pending') selected @endif>
                                    Pending
                                </option>
                                <option value="approved"
                                        @if($booking->status == 'approved') selected @endif>
                                    Approved
                                </option>
                                <option value="rejected"
                                        @if($booking->status == 'rejected') selected @endif>
                                    Rejected
                                </option>
                            </select>
                            @error('status')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>

                    @endif


                    <div class="input-box">
                        <label for="purpose">Purpose</label>
                        <input type="text" value="{{ old('purpose') != null ? old('purpose') : $booking->purpose }}"
                               name="purpose" id="purpose"
                               placeholder="Enter Purpose" required>
                        @error('purpose')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="input-box">
                        <label for="description">Description</label>
                        <textarea name="description"
                                  id="description">{{ old('description') != null ? old('description') : $booking->description }}</textarea>
                        @error('description')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    @if($usertype == 'admin')
                        <div class="input-box">
                            <label for="payment">Payment *</label>
                            <input type="number"
                                   value="@if(old('payment') != null){{old('payment')}}@else{{ $booking->payment }}@endif"
                                   name="payment" id="payment" placeholder="Enter Payment" required>
                            @error('payment')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                    @endif


                    <div class="input-box">
                        <button type="submit" class="button">Edit Booking</button>
                    </div>
                </form>
            </div>

        @else
            {{ abort(403) }}
        @endif
    </x-dashboard>
</x-app-layout>
