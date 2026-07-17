<x-admin.layout title="My Account">
    <div class="content-card card">
        <div class="heading">
            <h2>My Account</h2>
            <p>Update your account credentials.</p>
        </div>

        <form
            action="{{route('admin.me')}}"
            method="POST"
            id="meForm"
        >
            @csrf
            <div @class(['form-element', 'is-required', 'is-error'=> $errors->has('name')])>
                <label for="name">Name</label>
                <input id="name" name="name" value="{{old('name', auth()->user()->name)}}" required>
                @error('name')
                <div class="error">{{$message}}</div>
                @enderror
            </div>
            <div @class(['form-element', 'is-required', 'is-error'=> $errors->has('name')])>
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="{{old('email', auth()->user()->email)}}" required>
                @error('email')
                <div class="error">{{$message}}</div>
                @enderror
            </div>
            <div @class(['form-element', 'is-error'=> $errors->has('password')])>
                <label for="password">New Password</label>
                <input type="password" id="password" name="password" autocomplete="new-password">
                @error('password')
                <div class="error">{{$message}}</div>
                @enderror
            </div>
            @push('header')
                <button class="button is-primary" type="submit" form="meForm">Save</button>
            @endpush
        </form>
    </div>
</x-admin.layout>



