<x-admin.layout title="Add Proxy">
    <x-slot:banner>
        <x-admin.proxy-notice/>
    </x-slot:banner>

    <div class="content-card card">
        <div class="heading">
            <h2>Add New Proxy</h2>
            <p>Please add proxies if the script is facing Captcha issues.</p>
        </div>

        @push('header')
            <button type="submit" form="proxyForm" class="button is-primary">Add Proxy</button>
        @endpush

        <form
            action="{{route('admin.proxy.create')}}"
            method="POST"
            id="proxyForm"
            x-data="ProxyComponent()"
        >
            @csrf
            <div @class(['form-element', 'is-required', 'protocol'=> $errors->has('protocol')])>
                <label for="protocol">Protocol</label>
                <select id="protocol" name="protocol" required>
                    @foreach(['http', 'https'] as $protocol)
                        <option value="{{$protocol}}" {{old('protocol', 'http') === $protocol ? 'selected' : ''}}>
                            {{str($protocol)->value()}}
                        </option>
                    @endforeach
                </select>
                <div class="error">{{$errors->first('protocol')}}</div>
            </div>
            <div @class(['form-element', 'is-required', 'is-error'=> $errors->has('hostname')])>
                <label for="hostname">Hostname</label>
                <input type="text" id="hostname" name="hostname" value="{{old('hostname')}}" required>
                <div class="error">{{$errors->first('hostname')}}</div>
            </div>
            <div @class(['form-element', 'is-required', 'is-error'=> $errors->has('port')])>
                <label for="port">Port</label>
                <input type="number" id="port" name="port" min="0" value="{{old('port')}}" required>
                <div class="error">{{$errors->first('port')}}</div>
            </div>
            <div @class(['form-element', 'protocol'=> $errors->has('auth')])>
                <div class="checkbox">
                    <input type="checkbox" id="auth" name="auth" @if(old('auth')) checked
                           @endif @change="onAuthChange($event)" x-ref="authInput">
                    <label for="auth">Has Authentication</label>
                </div>

                <div class="error">{{$errors->first('auth')}}</div>
            </div>
            <div @class(['form-element', 'is-required', 'is-error'=> $errors->has('username')]) x-show="auth" x-cloak>
                <label for="username">Username</label>
                <input type="text" id="username" name="username" value="{{old('username')}}">
                <div class="error">{{$errors->first('username')}}</div>
            </div>
            <div @class(['form-element', 'is-required', 'is-error'=> $errors->has('password')]) x-show="auth" x-cloak>
                <label for="password">Password</label>
                <input type="text" id="password" name="password" value="{{old('password')}}">
                <div class="error">{{$errors->first('password')}}</div>
            </div>
        </form>
    </div>

    @pushonce('scripts')
        <script>
            function ProxyComponent() {

                return {
                    auth: false,
                    onAuthChange(e) {
                        this.auth = e.target.checked
                    },
                    init() {
                        this.auth = this.$refs.authInput.checked
                    }
                }
            }
        </script>
    @endpushonce
</x-admin.layout>



