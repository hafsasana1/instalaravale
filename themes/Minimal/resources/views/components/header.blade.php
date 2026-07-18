<header x-data="HeaderComponent()" class="header" aria-label="Main Header">
    <div class="logo">
        <a href="{{route('home')}}" aria-label="{{config('app.name')}}">
            <img src="{{$theme->asset('images/logo.svg')}}" alt="{{config("app.name")}}" aria-hidden="true" height="40" width="150"/>
        </a>
    </div>
    <nav aria-label="Main Navigation" :class="{'is-open': showNav}">
        <ul>
            <li>
                <a href="/instagram-reels-audio-download" class="nav-item-link">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#E1306C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="2.18" ry="2.18"/><line x1="7" y1="2" x2="7" y2="22"/><line x1="17" y1="2" x2="17" y2="22"/><line x1="2" y1="12" x2="22" y2="12"/><line x1="2" y1="7" x2="7" y2="7"/><line x1="2" y1="17" x2="7" y2="17"/><line x1="17" y1="7" x2="22" y2="7"/><line x1="17" y1="17" x2="22" y2="17"/></svg>
                    Reels Audio
                </a>
            </li>
            <li>
                <a href="/instagram-stories-audio-download" class="nav-item-link">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#6366f1" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                    Stories Audio
                </a>
            </li>
            <li>
                <a href="/instagram-highlights-download" class="nav-item-link">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#f97316" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                    Highlights
                </a>
            </li>
            <li>
                <a href="/guide" class="nav-item-link">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#3b82f6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                    Guide
                </a>
            </li>
            <li>
                <a href="/faq" class="nav-item-link">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                    FAQ
                </a>
            </li>
            <li>
                <a href="/blog" class="nav-item-link">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#8b5cf6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                    Blog
                </a>
            </li>
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
