<nav class="card nav">
    <small>Menu</small>
    <x-admin.nav-link
        href="{{route('admin.settings')}}"
        icon="admin.icon.mini.cog"
        text="Site Settings"
    />
    <x-admin.nav-link
        href="{{route('admin.proxy')}}"
        icon="admin.icon.mini.bolt"
        text="Configure Proxies"
    />
    <x-admin.nav-link
        href="{{route('admin.appearance')}}"
        icon="admin.icon.mini.paint-brush"
        text="Appearance"
    />
    <x-admin.nav-link
        href="{{route('admin.me')}}"
        icon="admin.icon.mini.user"
        text="My Account"
    />

    <x-admin.user-dropdown />
</nav>
