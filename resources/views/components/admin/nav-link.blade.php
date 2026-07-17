<a {{$attributes->class([
    'nav-link',
    'is-active' => $active,
])}} href="{{$href}}">
    <x-dynamic-component :component="$icon" />
    <span>{{$text}}</span>
</a>
