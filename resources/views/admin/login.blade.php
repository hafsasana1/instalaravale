<x-admin.auth-layout title="Login">
    <div class="card login-card">
        <div class="heading">
            <h2>Welcome back!</h2>
        </div>
        <form action="{{route('login')}}" method="POST">
            @csrf
            <div @class(['form-element', 'is-required', 'is-error'=> $errors->has('email')])>
                <label for="email">Email</label>
                <input type="email" required name="email" id="email"/>
                @error('email')
                <span class="error">{{$message}}</span>
                @enderror
            </div>
            <div @class(['form-element', 'is-required', 'is-error'=> $errors->has('password')])>
                <label for="password">Password</label>
                <input type="password" required name="password" id="password"/>
                @error('password')
                <span class="error">{{$message}}</span>
                @enderror
            </div>
            <button class="button is-primary" type="submit">Login</button>
        </form>
    </div>
</x-admin.auth-layout>
