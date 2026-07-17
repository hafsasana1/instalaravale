@php
    /** @var array $locales */
    $locales = $theme->locales();
    $currentLocale = app()->getLocale();
@endphp

<div class="change-locale mi-start" x-data="ChangeLocaleComponent()" :class="{'is-open': showMenu}">
    <button class="change-locale-toggle" aria-label="Change locale" @click="toggleMenu()">
        <x-theme::icon.globe class="icon mi-end" aria-hidden="true"/>
        <span aria-label="Current locale">{{$locales[$currentLocale]}}</span>
        <x-theme::icon.chevron-down class="arrow mi-start" aria-hidden="true"/>
    </button>
    <div x-show="showMenu" x-cloak x-transition @click.outside="closeMenu()" class="change-locale-menu inset-i-end" dir="ltr">
        @foreach($locales as $locale => $label)
            <a href="{{route(request()->route()->getName(), compact('locale'))}}">{{$label}}</a>
        @endforeach
    </div>
</div>

@pushonce('scripts')
    <script>
        function ChangeLocaleComponent() {
            return {
                showMenu: false,
                closeMenu() {
                    this.showMenu = false;
                },
                toggleMenu() {
                    this.showMenu = !this.showMenu;
                }
            };
        }
    </script>
@endpushonce
