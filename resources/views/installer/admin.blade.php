<x-installer.layout title="Create Admin">
    <div class="heading">
        <h2>Create Admin</h2>
        <p>Please create your admin account.</p>
    </div>

    <form action="{{route('installer.admin.create')}}" method="POST" id="adminForm">
        @csrf
        @method('POST')

        <div @class(['form-element', 'is-required', 'is-error'=> $errors->has('name')])>
            <label for="name">Name</label>
            <input type="text" id="name" name="name" value="{{old('name')}}" required>
            @error('name')
            <span class="error">{{$message}}</span>
            @enderror
            <span class="tip">The name of the admin.</span>
        </div>

        <div @class(['form-element', 'is-required', 'is-error'=> $errors->has('email')])>
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="{{old('email')}}" required>
            @error('email')
            <span class="error">{{$message}}</span>
            @enderror
            <span class="tip">The email of the admin.</span>
        </div>

        <div @class(['form-element', 'is-required', 'is-error'=> $errors->has('password')])>
            <label for="password">Password</label>
            <input type="password" id="password" name="password" value="{{old('password')}}" required>
            @error('password')
            <span class="error">{{$message}}</span>
            @enderror
            <span class="tip">The password of the admin.</span>
        </div>
    </form>

    <x-slot:footer>
        <button type="submit" class="button is-primary" form="adminForm">Create Admin</button>
    </x-slot:footer>
</x-installer.layout>
