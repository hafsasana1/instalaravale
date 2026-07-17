<div class="user-dropdown">
    <x-admin.icon.avatar class="avatar"/>
    <span>{{auth()->user()->name}}</span>

    <button class="icon-button" type="submit" form="logoutForm">
        <x-admin.icon.mini.logout/>
    </button>
</div>

<form action="{{route('logout')}}" method="POST" id="logoutForm">
    @csrf
</form>
