@php
    use Illuminate\Support\Facades\Auth;
    $usertype = Auth::user()->usertype;


@endphp
<x-app-layout>
    <x-dashboard>
        <x-slot:header>{{ __('Dashboard') }} </x-slot:header>
        <x-slot:contentTitle> {{ __('Add New images') }}</x-slot:contentTitle>
        <x-slot:contentDescription> {{ __('Welcome to images management dashboard.') }}</x-slot:contentDescription>
        @if($usertype == 'admin')
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <div class="cont">
                <form method="POST" action="{{ route('dashboard.images.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="input-box">
                        <ul>
                            @if($errors->any())
                                @foreach($errors->all() as $error)
                                    <li class="error">{{ $error }}</li>
                                @endforeach
                            @endif
                        </ul>
                    </div>

                    <div class="input-box">
                        <label for="hall">Hall *</label>
                        <select name="hall" id="hall" required>
                            @foreach($halls as $hall)
                                <option value="{{ $hall->id }}"
                                        @if(old('hall') ==  $hall->id ) selected @endif>{{ $hall->name }}</option>
                            @endforeach
                        </select>
                        @error('hall')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>


                    <div class="input-box">
                        <label for="title">Title</label>
                        <input type="text" value="{{ old('title') }}" name="title" id="title"
                               placeholder="Enter Title">
                        @error('title')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="input-box">
                        <label for="images">Images *</label>
                        <input type="file"
                               name="images[]" id="images" multiple required>
                        @error('images')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="input-box">
                        <button type="submit" class="button">Add Images</button>
                    </div>
                </form>
            </div>

        @else
            {{ abort(403) }}
        @endif
    </x-dashboard>
</x-app-layout>
