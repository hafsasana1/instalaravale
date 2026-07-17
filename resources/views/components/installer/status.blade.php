@if($passed ?? true)
    <x-installer.passed/>
@else
    <x-installer.failed/>
@endif
