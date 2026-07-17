<x-admin.layout title="Edit Proxy">
    <div class="content-card card">
        <div class="heading">
            <h2>Edit Proxy</h2>
        </div>

        @push('header')
            <button type="submit" form="disableProxyComponent" class="button">{{$proxy->enabled ? 'Disable': 'Enable'}}
                Proxy
            </button>
            <button type="submit" form="proxyForm" class="button is-primary">Update Proxy</button>
        @endpush

        <form
            action="{{route('admin.proxy.toggle', $proxy)}}"
            method="POST"
            id="disableProxyComponent"
        >
            @csrf
        </form>

        <form
            action="{{route('admin.proxy.edit', $proxy)}}"
            method="POST"
            id="proxyForm"
            x-data="ProxyComponent()"
        >
            @csrf
            <div @class(['form-element', 'is-required', 'protocol'=> $errors->has('protocol')])>
                <label for="protocol">Protocol</label>
                <select id="protocol" name="protocol" required>
                    @foreach(['http', 'https'] as $protocol)
                        <option
                            value="{{$protocol}}" {{old('protocol',$proxy->protocol) === $protocol ? 'selected' : ''}}>
                            {{str($protocol)->value()}}
                        </option>
                    @endforeach
                </select>
                <div class="error">{{$errors->first('protocol')}}</div>
            </div>
            <div @class(['form-element', 'is-required', 'is-error'=> $errors->has('hostname')])>
                <label for="hostname">Hostname</label>
                <input type="text" id="hostname" name="hostname" value="{{old('hostname', $proxy->hostname)}}" required>
                <div class="error">{{$errors->first('hostname')}}</div>
            </div>
            <div @class(['form-element', 'is-required', 'is-error'=> $errors->has('port')])>
                <label for="port">Port</label>
                <input type="number" id="port" name="port" min="0" value="{{old('port', $proxy->port)}}" required>
                <div class="error">{{$errors->first('port')}}</div>
            </div>
            <div @class(['form-element', 'protocol'=> $errors->has('auth')])>
                <div class="checkbox">
                    <input type="checkbox" id="auth" name="auth" @if(old('auth', $proxy->auth)) checked
                           @endif @change="onAuthChange($event)" x-ref="authInput">
                    <label for="auth">Has Authentication</label>
                </div>

                <div class="error">{{$errors->first('auth')}}</div>
            </div>
            <div @class(['form-element', 'is-required', 'is-error'=> $errors->has('username')]) x-show="auth" x-cloak>
                <label for="username">Username</label>
                <input type="text" id="username" name="username" value="{{old('username', $proxy->username)}}">
                <div class="error">{{$errors->first('username')}}</div>
            </div>
            <div @class(['form-element', 'is-required', 'is-error'=> $errors->has('password')]) x-show="auth" x-cloak>
                <label for="password">Password</label>
                <input type="text" id="password" name="password" value="{{old('password', $proxy->password)}}">
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



