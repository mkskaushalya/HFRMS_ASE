<x-app-layout>
    <x-dashboard>
        <x-slot:header>{{ __('Dashboard') }}</x-slot:header>
        <x-slot:contentTitle> {{ __('Dashboard') }}</x-slot:contentTitle>
        <x-slot:contentDescription> {{ __('Welcome to your dashboard!') }}</x-slot:contentDescription>
        <div class="cont">

            @if($user->usertype == 'admin')
                <a href="{{ route('dashboard.halls') }}" class="card">
                    <div class="card-title">
                        <h3>Manage Halls</h3>
                    </div>
                    <div class="card-content">
                        <p>You have {{ $halls->count() }} halls</p>
                    </div>
                </a>

                <a href="{{ route('dashboard.users') }}" class="card">
                    <div class="card-title">
                        <h3>Manage Users</h3>
                    </div>
                    <div class="card-content">
                        <p>You have {{ $users->count() }} users</p>
                    </div>
                </a>

                <a href="{{ route('dashboard.bookings') }}" class="card">
                    <div class="card-title">
                        <h3>Manage Bookings</h3>
                    </div>
                    <div class="card-content">
                        <p>You have {{ $bookings->count() }} bookings</p>
                    </div>
                </a>
                <a href="{{ route('dashboard.images') }}" class="card">
                    <div class="card-title">
                        <h3>Manage Images</h3>
                    </div>
                    <div class="card-content">
                        <p>You have {{ $hallImages->count() }} images</p>
                    </div>
                </a>
            @elseif($user->usertype == 'user')
                <a href="{{ route('dashboard.bookings') }}" class="card">
                    <div class="card-title">
                        <h3>Manage Bookings</h3>
                    </div>
                    <div class="card-content">
                        <p>You have {{ $bookings->count() }} bookings</p>
                    </div>
                </a>
            @endif


        </div>
        <div class="max-w-7xl py-6 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </x-dashboard>
</x-app-layout>
