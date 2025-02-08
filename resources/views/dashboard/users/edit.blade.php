@php
    use Illuminate\Support\Facades\Auth;
    $usertype = Auth::user()->usertype;

@endphp
<x-app-layout>
    <x-dashboard>
        <x-slot:header>{{ __('Dashboard') }} </x-slot:header>
        <x-slot:contentTitle> {{ __('Edit User') }}</x-slot:contentTitle>
        <x-slot:contentDescription> {{ __('Welcome to users management dashboard.') }}</x-slot:contentDescription>
        @if($usertype == 'admin')
            <div class="cont">
                <form method="POST" autocomplete="off" action="{{ route('dashboard.users.show', $user)}}">
                    @csrf
                    @method('PATCH')


                    @if($errors->any())
                        <div class="input-box">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li style="color: red">{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="input-box">
                        <label for="firstname">First Name *</label>
                        <input type="text" value="{{ $user->firstname }}" name="firstname" id="firstname"
                               placeholder="Sahan" required>
                    </div>

                    <div class="input-box">
                        <label for="lastname">Last Name *</label>
                        <input type="text" value="{{ $user->lastname }}" name="lastname" id="lastname"
                               placeholder="Enter Hall Name" required>
                    </div>

                    <div class="input-box">
                        <label for="phone">Phone *</label>
                        <input type="tel" name="phone" value="{{ $user->phone }}" id="phone" placeholder="+94712345678"
                               required>
                    </div>

                    <div class="input-box">
                        <label for="address">Address *</label>
                        <input type="text" name="address" value="{{ $user->address }}" id="address"
                               placeholder="Enter Address" required>
                    </div>

                    <div class="input-box">
                        <label for="email">Email *</label>
                        <input type="email" name="email" value="{{ $user->email }}" id="email"
                               placeholder="user@email.com" required>
                    </div>

                    <div class="input-box">
                        <label for="password">Password * (If you do not want to change the password, leave that box
                            blank.) </label>
                        <input type="password" name="password" value="" id="password" placeholder="Password"
                               required>
                    </div>

                    <div class="input-box">
                        <label for="status">Confirm Password *</label>
                        <input type="password" name="password_confirmation" id="password" placeholder="Confirm Password"
                               required>
                    </div>

                    <div class="input-box">
                        <label for="usertype">User Type *</label>
                        <select name="usertype" id="usertype" required>
                            <option value="admin" @if($user->usertype == "admin") selected @endif>Admin</option>
                            <option value="user" @if($user->usertype == "user") selected @endif>User</option>
                        </select>
                    </div>

                    <div class="input-box">
                        <button type="submit" class="button">Update User</button>
                    </div>

                </form>
            </div>

        @else
            {{ abort(403) }}
        @endif
    </x-dashboard>
</x-app-layout>
