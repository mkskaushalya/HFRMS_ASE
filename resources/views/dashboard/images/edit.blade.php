@php
    use Illuminate\Support\Facades\Auth;
    $usertype = Auth::user()->usertype;

@endphp
<x-app-layout>
    <x-dashboard>
        <x-slot:header>{{ __('Dashboard') }} </x-slot:header>
        <x-slot:contentTitle> {{ __('Edit Booking') }}</x-slot:contentTitle>
        <x-slot:contentDescription> {{ __('Welcome to booking management dashboard.') }}</x-slot:contentDescription>
        @if($usertype == 'admin' || ($usertype == 'user' && $hallImage->user_id == Auth::id()))
            <div class="cont">
                <form method="POST" autocomplete="off" action="{{ route('dashboard.images.update', $hallImage)}}"
                      enctype="multipart/form-data">
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
                                            @if(old('hall') ==  $hall->id || $hallImage->hall->id == $hall->id) selected @endif>{{ $hall->name }}</option>
                                @endforeach
                            </select>
                        @elseif($usertype == 'user')
                            <input type="text" value="{{ $hallImage->hall->name }}" name="hall" id="hall" readonly>
                        @endif

                        @error('hall')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>


                    <div class="input-box">
                        <label for="title">Title</label>
                        <input type="text" value="{{ old('title') != null ? old('title') : $hallImage->title }}"
                               name="title" id="title"
                               placeholder="Enter Title" required>
                        @error('title')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="input-box">

                        <label for="image">Images * <img src="{{ url($hallImage->url) }}" alt=""
                                                         style="max-width: 200px;"></label>
                        <input type="file"
                               name="image" id="image">
                        @error('image')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="input-box">
                        <button type="submit" class="button">Edit Images</button>
                    </div>
                </form>
            </div>

        @else
            {{ abort(403) }}
        @endif
    </x-dashboard>
</x-app-layout>
