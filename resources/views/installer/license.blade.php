<x-installer.layout title="Verify Purchase Code">
    <div class="heading">
        <h2>Verify Purchase Code</h2>
        <p>Please verify your purchase code.</p>
    </div>

    <form action="{{route('installer.license.verify')}}" method="POST" id="licenseForm">
        @csrf
        @method('POST')
        <div @class(['form-element', 'is-required', 'is-error'=> $errors->has('domain')])>
            <label for="domain">Domain</label>
            <input type="text" id="domain" name="domain" value="{{old('domain')}}" required>
            @error('domain')
            <span class="error">{{$message}}</span>
            @enderror
            <span class="tip">Domain name must start with http:// or https://</span>
        </div>
        <div @class(['form-element', 'is-required', 'is-error'=> $errors->has('license_key')])>
            <label for="license_key">Purchase Code</label>
            <input type="text" id="license_key" name="license_key" value="{{old('license_key')}}" required>
            @error('license_key')
            <span class="error">{{$message}}</span>
            @enderror
            <span class="tip">Please include your purchase code.</span>
        </div>
    </form>

    <x-slot:footer>
        <a href="{{route('installer.requirements')}}" class="button">Back</a>
        <button type="submit" class="button is-primary" form="licenseForm">Verify</button>
    </x-slot:footer>

</x-installer.layout>
