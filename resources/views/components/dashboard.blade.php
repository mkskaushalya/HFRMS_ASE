@php
    use Carbon\Traits\Date;use Illuminate\Support\Facades\Auth;
    $user = Auth::user();

@endphp
<section id="dashboard">
    <div class="side-menu">
        <div class="title">
            <h2>{{ $header }}</h2>
        </div>
        <div class="profile-info">
            <div class="user-img">
                <img src="{{ url($user->profile_picture) }}" alt="user">
            </div>
            <div class="user-type {{ $user->usertype }}">
                @if($user->usertype == 'admin')
                    <h3>Admin</h3>
                @elseif($user->usertype == 'user')
                    <h3>User</h3>
                @endif
            </div>
            <div class="user-name">
                <h3>{{ $user->firstname }} {{ $user->lastname }}</h3>
            </div>
            <div class="since-date">
                <p>Member since {{ $user->created_at->format('Y') }}</p>
            </div>
        </div>
        <hr class="divider">
        <div class="menu">
            <ul>
                <li class="{{ Request::routeIs('dashboard') ? 'active' : ''}}">
                    <a href="{{route('dashboard')}}">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                @if($user->usertype == 'admin')
                    <li class="{{ Request::routeIs('dashboard.halls') || Request::routeIs('dashboard.halls.*') ? 'active' : ''}}">
                        <a href="{{ route('dashboard.halls') }}">
                            <i class="fas fa-users"></i>
                            <span>Halls</span>
                        </a>
                    </li>
                    <li class="{{ Request::routeIs('dashboard.images') || Request::routeIs('dashboard.images.*') ? 'active' : ''}}">
                        <a href="{{ route('dashboard.images') }}">
                            <i class="fas fa-users"></i>
                            <span>Images</span>
                        </a>
                    </li>
                    <li class="{{ Request::routeIs('dashboard.users') || Request::routeIs('dashboard.users.*') ? 'active' : ''}}">
                        <a href="{{route('dashboard.users')}}">
                            <i class="fas fa-users"></i>
                            <span>Users</span>
                        </a>
                    </li>
                @endif
                <li class="{{ Request::routeIs('dashboard.bookings') || Request::routeIs('dashboard.bookings.*') ? 'active' : ''}}">
                    <a href="{{route('dashboard.bookings')}}">
                        <i class="fas fa-cogs"></i>
                        <span>Bookings</span>
                    </a>
                </li>
                <li class="{{ Request::routeIs('profile.edit') ? 'active' : ''}}">
                    <a href="{{ route('profile.edit') }}">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Profile</span>
                    </a>
                </li>
                <li class="{{ Request::routeIs('logout') ? 'active' : ''}}">
                    <a style="cursor: pointer" onclick="document.getElementById('logoutForm').submit();">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                        <form method="POST" id="logoutForm" action="{{ route('logout') }}">
                            @csrf
                        </form>
                    </a>
                </li>

            </ul>
        </div>

    </div>
    <div class="content">
        <div class="title">
            <h2><span>{{ $contentTitle }}</span>
                <button class="button" onclick="location.href = '{{ url()->previous() }}'"
                        style="background-color: var(--secondary); color: var(--white)">Back
                </button>
            </h2>
            <p>{{ $contentDescription }}</p>
        </div>
        {{ $slot }}
    </div>
</section>
