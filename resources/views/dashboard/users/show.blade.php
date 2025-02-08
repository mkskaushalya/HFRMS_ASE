@php
    use Illuminate\Support\Facades\Auth;
    $usertype = Auth::user()->usertype;

    $users = App\Models\User::all();
    $bookings = App\Models\HallBooking::all();
@endphp
<x-app-layout>
    <x-dashboard>
        <x-slot:header>{{ __('Dashboard') }} </x-slot:header>
        <x-slot:contentTitle> {{ __('User details') }}</x-slot:contentTitle>
        <x-slot:contentDescription> {{ __('This page shown a user information\'s.') }}</x-slot:contentDescription>
        @if($usertype == 'admin')
            <div class="cont">
                <div class="user">
                    <div class="user-info">
                        <p>Firstname : {{ $user->firstname }}</p>
                        <p>Lastname : {{ $user->lastname }}</p>
                        <p>Phone : {{ $user->phone }}</p>
                        <p>Email : {{ $user->email }}</p>
                        <p>Address : {{ $user->address }}</p>
                        <p>Usertype : {{ $user->usertype }}</p>
                        <p>Status : {{ $user->status }}</p>
                        <p>Created at : {{ $user->created_at }}</p>
                        <p>Updated at : {{ $user->updated_at }}</p>
                    </div>
                    <div class="actions">
                        <button onclick="location.href ='{{ route('dashboard.users.edit', $user) }}';"
                                class="button edit">
                            Edit
                        </button>
                        <button class="button delete"
                                onclick="return confirm('Are you sure you want to delete this user?')"
                                form="delete_user_{{$user->id }}">Delete
                        </button>
                        <form id="delete_user_{{$user->id}}"
                              action="{{ route('dashboard.users.destroy', $user) }}" method="POST"
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
