<footer class="footer">
    <nav class="footer-nav" aria-label="Footer Navigation">
        <a href="{{route('tos')}}">@lang("Terms of Service")</a>
        <a href="{{route('privacy')}}">@lang("Privacy Policy")</a>
        <a href="{{route('faq')}}">@lang("FAQ")</a>
    </nav>
    <noindex>
        <b>@lang("This product is in no way affiliated with, authorized, maintained, sponsored or endorsed by TikTok, Instagram or any of its affiliates or subsidiaries.")</b>
    </noindex>
    <p>@lang("Copyright © :year", ['year'=> now()->translatedFormat('Y')])</p>
</footer>
