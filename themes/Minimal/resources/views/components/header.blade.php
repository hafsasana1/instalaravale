<header x-data="HeaderComponent()" class="header" aria-label="Main Header">
    <div class="logo">
        <a href="{{route('home')}}" aria-label="{{config('app.name')}}">
            <img src="{{$theme->asset('images/logo.svg')}}" alt="{{config("app.name")}}" aria-hidden="true" height="40" width="150"/>
        </a>
    </div>
    <nav aria-label="Main Navigation" :class="{'is-open': showNav}">
        <ul>
            <x-minimal::nav-link href="{{route('popular-videos')}}" text="Popular videos"  />
            <x-minimal::nav-link href="{{route('how-to-save')}}" text="How to save?"  />
        </ul>
    </nav>
    <div>
        <x-theme::change-locale/>
        <button @click="toggleNav()" class="menu-toggle mi-start" aria-label="Toggle Navigation">
            <x-theme::icon.mini.bars-3 x-show="!showNav" aria-hidden="true" />
            <x-theme::icon.mini.x-mark x-show="showNav" x-cloak="true" aria-hidden="true" />
        </button>
    </div>
</header>

@pushonce('scripts')
    <script>
        function HeaderComponent() {
            return {
                showNav: false,
                toggleNav() {
                    this.showNav = !this.showNav;
                }
            };
        }
    </script>
@endpushonce
