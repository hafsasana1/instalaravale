<x-admin.layout title="Configure Proxies">
    <x-slot:banner>
        <x-admin.proxy-notice/>
    </x-slot:banner>
    <div class="content-card card">
        <div class="heading">
            <h2>Proxies</h2>
            <p>Please add proxies if the script is facing Captcha issues.</p>
        </div>

        @push('header')
            <a href="{{route('admin.proxy.create')}}" class="button is-primary">Add New Proxy</a>
        @endpush

        @foreach($proxies as $proxy)
            <div @class(['proxy', 'is-disabled'=> !$proxy->enabled])>
                <span class="proxy-text">{{$proxy->maskedUrl()}}</span>
                <span class="proxy-status">{{$proxy->enabled ? 'Active' : 'Disabled'}}</span>

                <div class="proxy-action" x-data="DeleteProxyComponent()">
                    <a href="{{route('admin.proxy.edit', $proxy)}}" class="icon-button edit-button">
                        <x-admin.icon.mini.edit/>
                    </a>

                    <a href="#" class="icon-button" @click.prevent="deleteProxy(@js($proxy->id))">
                        <x-admin.icon.mini.trash/>
                    </a>
                </div>
            </div>
        @endforeach
    </div>

    <form name="deleteProxyForm" method="POST">
        @csrf
        @method('DELETE')
    </form>

    @pushonce('scripts')
        <script>
            function DeleteProxyComponent() {
                return {
                    deleteProxy(id) {

                        const url = '{{route('admin.proxy.delete', ':id')}}'.replace(':id', id);

                        const form = window.deleteProxyForm;
                        if(! form)
                            return;

                        form.action = url;

                        if (confirm('Are you sure you want to delete this proxy?')) {
                           form.submit();
                        }
                    }
                }
            }
        </script>
    @endpushonce
</x-admin.layout>



