@php
    use Illuminate\Support\Facades\Auth;
    $usertype = Auth::user()->usertype;

    $users = App\Models\User::all();
@endphp
<x-app-layout>
    <x-dashboard>
        <x-slot:header>{{ __('Dashboard') }} </x-slot:header>
        <x-slot:contentTitle> {{ __('User Management') }}</x-slot:contentTitle>
        <x-slot:contentDescription> {{ __('Welcome to user management dashboard.') }}</x-slot:contentDescription>
        @if($usertype == 'admin')
            <div class="header">
                <div class="add-btn">
                    <a href="{{ route('dashboard.users.create') }}" class="button">Add User</a>
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
                        <th>Firstname</th>
                        <th>Lastname</th>
                        <th>Email</th>
                        <th>User Type</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if($users->isEmpty())
                        <tr>
                            <td colspan="6">No halls found</td>
                        </tr>

                    @else
                        @foreach($users as $user)

                            <tr>
                                <td style="cursor: pointer"
                                    onclick="location.href ='{{ route('dashboard.users.show', $user) }}';">{{ $user->id }}</td>
                                <td style="cursor: pointer"
                                    onclick="location.href ='{{ route('dashboard.users.show', $user) }}';">{{ $user->firstname }}</td>
                                <td style="cursor: pointer"
                                    onclick="location.href ='{{ route('dashboard.users.show', $user) }}';">{{ $user->lastname }}</td>
                                <td style="cursor: pointer"
                                    onclick="location.href ='{{ route('dashboard.users.show', $user) }}';">{{ $user->email }}</td>
                                <td style="cursor: pointer"
                                    onclick="location.href ='{{ route('dashboard.users.show', $user) }}';">{{ $user->usertype }}</td>
                                <td class="tbl_action">
                                    <button onclick="location.href ='{{ route('dashboard.users.edit', $user) }}';"
                                            class="button edit">
                                        Edit
                                    </button>
                                    <button class="button delete"
                                            onclick="return confirm('Are you sure you want to delete this user?')"
                                            form="delete_hall_{{$user->id }}">Delete
                                    </button>
                                    <form id="delete_hall_{{$user->id}}"
                                          action="{{ route('dashboard.users.destroy', $user) }}" method="POST"
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
