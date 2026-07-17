<x-installer.layout title="Finish Installation">
    <form class="finish-form" action="{{route('installer.finish.clean-up')}}" method="POST">
        @csrf
        @method('POST')

        <div class="status-icon">
            <x-installer.icon.broom/>
        </div>

        <div class="heading">
            <h2>Finish the Installation</h2>
            <p>The script has been successfully configured. Click the below button to finish the installation
                process.</p>
        </div>

        <button type="submit" class="button is-primary">Clean Up and Finish Installation</button>
    </form>
</x-installer.layout>
