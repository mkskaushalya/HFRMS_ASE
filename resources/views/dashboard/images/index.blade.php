@php
    use Illuminate\Support\Facades\Auth;
    $usertype = Auth::user()->usertype;

@endphp
<x-app-layout>
    <x-dashboard>
        <x-slot:header>{{ __('Dashboard') }} </x-slot:header>
        <x-slot:contentTitle> {{ __('Booking Management') }}</x-slot:contentTitle>
        <x-slot:contentDescription> {{ __('Welcome to booking management dashboard.') }}</x-slot:contentDescription>
        @if($usertype == 'admin' || $usertype == 'user')
            <div class="header">
                <div class="add-btn">
                    <a href="{{ $usertype == 'admin' ? route('dashboard.images.create') : route('halls') }}"
                       class="button">Add Images</a>
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
                        <th>Hall</th>
                        <th>User</th>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if($hallImages->isEmpty())
                        <tr>
                            <td colspan="9">No images found</td>
                        </tr>

                    @else
                        @foreach($hallImages as $hallImage)

                            <tr>
                                <td style="cursor: pointer"
                                    onclick="location.href ='{{ route('dashboard.images.show', $hallImage) }}';">{{ $hallImage->id }}</td>
                                <td style="cursor: pointer"
                                    onclick="location.href ='{{ route('dashboard.images.show', $hallImage) }}';">{{ $hallImage->hall->name }}</td>
                                <td style="cursor: pointer"
                                    onclick="location.href ='{{ route('dashboard.images.show', $hallImage) }}';">{{ $hallImage->user->firstname }} {{ $hallImage->user->lastname }}</td>
                                <td style="cursor: pointer"
                                    onclick="location.href ='{{ route('dashboard.images.show', $hallImage) }}';"><img
                                        src="{{ url($hallImage->url) }}" alt=""></td>
                                <td style="cursor: pointer"
                                    onclick="location.href ='{{ route('dashboard.images.show', $hallImage) }}';">{{ $hallImage->title }}</td>
                                <td class="tbl_action">
                                    @if($usertype == 'admin')
                                        <button
                                            onclick="location.href ='{{ route('dashboard.images.edit', $hallImage) }}';"
                                            class="button edit">
                                            Edit
                                        </button>
                                        <button class="button delete"
                                                onclick="return confirm('Are you sure you want to delete this image?')"
                                                form="delete_image_{{$hallImage->id }}">Delete
                                        </button>

                                        <form id="delete_image_{{$hallImage->id}}"
                                              action="{{ route('dashboard.images.destroy', $hallImage) }}"
                                              method="POST"
                                              style="display: none">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    @endif
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
