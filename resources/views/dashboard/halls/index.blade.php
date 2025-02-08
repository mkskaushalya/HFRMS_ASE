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
        <x-slot:contentTitle> {{ __('Hall Management') }}</x-slot:contentTitle>
        <x-slot:contentDescription> {{ __('Welcome to hall management dashboard.') }}</x-slot:contentDescription>
        @if($usertype == 'admin')
            <div class="header">
                <div class="add-btn">
                    <a href="{{ route('dashboard.halls.create') }}" class="button">Add Hall</a>
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
                        <th>Name</th>
                        <th>Location</th>
                        <th>Capacity</th>
                        <th>Price</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if($halls->isEmpty())
                        <tr>
                            <td colspan="6">No halls found</td>
                        </tr>

                    @else
                        @foreach($halls as $hall)

                            <tr>
                                <td style="cursor: pointer"
                                    onclick="location.href ='{{ route('dashboard.halls.show', $hall) }}';">{{ $hall->id }}</td>
                                <td style="cursor: pointer"
                                    onclick="location.href ='{{ route('dashboard.halls.show', $hall) }}';">{{ $hall->name }}</td>
                                <td style="cursor: pointer"
                                    onclick="location.href ='{{ route('dashboard.halls.show', $hall) }}';">{{ $hall->hallLocation->location }}</td>
                                <td style="cursor: pointer"
                                    onclick="location.href ='{{ route('dashboard.halls.show', $hall) }}';">{{ $hall->capacity }}</td>
                                <td style="cursor: pointer"
                                    onclick="location.href ='{{ route('dashboard.halls.show', $hall) }}';">{{ $hall->price }}</td>
                                <td class="tbl_action">
                                    <button onclick="location.href ='{{ route('dashboard.halls.edit', $hall) }}';"
                                            class="button edit">
                                        Edit
                                    </button>
                                    <button class="button delete"
                                            onclick="return confirm('Are you sure you want to delete this hall?')"
                                            form="delete_hall_{{$hall->id }}">Delete
                                    </button>
                                    <form id="delete_hall_{{$hall->id}}"
                                          action="{{ route('dashboard.halls.destroy', $hall) }}" method="POST"
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
