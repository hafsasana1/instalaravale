<x-installer.layout title="Configure Database">
    <div class="heading">
        <h2>Configure Database</h2>
        <p>Please configure your database connection.</p>
    </div>

    <form action="{{route('installer.database.configure')}}" method="POST" id="databaseForm">
        @csrf
        @method('POST')

        <div @class(['form-element', 'is-required', 'is-error'=> $errors->has('database_host')])>
            <label for="database_host">Database Host</label>
            <input type="text" id="database_host" name="database_host" value="{{old('database_host')}}" required>
            @error('database_host')
            <span class="error">{{$message}}</span>
            @enderror
            <span class="tip">The host of the database. e.g. localhost/127.0.0.1.</span>
        </div>

        <div @class(['form-element', 'is-required', 'is-error'=> $errors->has('database_port')])>
            <label for="database_port">Database Port</label>
            <input type="text" id="database_port" name="database_port" value="{{old('database_port')}}" required>
            @error('database_port')
            <span class="error">{{$message}}</span>
            @enderror
            <span class="tip">The port of the database. e.g. 3306.</span>
        </div>

        <div @class(['form-element', 'is-required', 'is-error'=> $errors->has('database_name')])>
            <label for="database_name">Database Name</label>
            <input type="text" id="database_name" name="database_name" value="{{old('database_name')}}" required>
            @error('database_name')
            <span class="error">{{$message}}</span>
            @enderror
            <span class="tip">The name of the database. e.g. tiktokdown/tiktok.</span>
        </div>

        <div @class(['form-element', 'is-required', 'is-error'=> $errors->has('database_username')])>
            <label for="database_username">Database Username</label>
            <input type="text" id="database_username" name="database_username" value="{{old('database_username')}}"
                   required>
            @error('database_username')
            <span class="error">{{$message}}</span>
            @enderror
            <span class="tip">The username of the database. e.g. root/admin/tiktok_user.</span>
        </div>

        <div @class(['form-element', 'is-error'=> $errors->has('database_password')])>
            <label for="database_password">Database Password</label>
            <input type="password" id="database_password" name="database_password" value="{{old('database_password')}}">
            @error('database_password')
            <span class="error">{{$message}}</span>
            @enderror
            <span class="tip">The password of the database. Please set password for your database in production environment.</span>
        </div>
    </form>

    <x-slot:footer>
        <button type="submit" class="button is-primary" form="databaseForm">Migrate</button>
    </x-slot:footer>
</x-installer.layout>
