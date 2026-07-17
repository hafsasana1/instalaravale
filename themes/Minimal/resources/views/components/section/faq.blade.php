<section class="faq-section" aria-label="Frequently Asked Questions">
    <div class="container">

        <div class="faq-header">
            <h2>@lang("Frequently Asked Questions")</h2>
            <p>@lang("Everything you need to know about downloading Instagram audio — formats, quality, safety, and supported content.")</p>
        </div>

        <div class="faq-card" x-data="{ open: null }">
            @php
            $faqs = [
                [
                    'q' => 'Is :appName free to use?',
                    'a' => 'Yes, completely free with no hidden charges, subscriptions, or download limits. No account or login is required and no watermarks are added to the audio files.',
                ],
                [
                    'q' => 'How do I download audio from an Instagram Reel?',
                    'a' => 'Open the Instagram app, find the Reel you want, tap the three-dot menu (···) and select "Copy Link". Paste that link into the field on this page, choose MP3 or M4A, and tap "Extract Audio".',
                ],
                [
                    'q' => 'Which Instagram content types does it support?',
                    'a' => 'You can extract audio from public Instagram Reels, Posts (with video), IGTV, Stories, Highlights, and Carousel posts. Private accounts are not supported — content must be publicly accessible.',
                ],
                [
                    'q' => 'What audio formats can I download?',
                    'a' => 'You can download in MP3 (universally compatible, works on every device) or M4A (AAC, slightly better quality at the same file size). Both formats are supported on all modern smartphones and computers.',
                ],
                [
                    'q' => 'Will the audio quality be reduced?',
                    'a' => 'No. :appName extracts the original audio track directly from the video without re-encoding or quality loss. You get the same audio that Instagram hosts.',
                ],
                [
                    'q' => 'Do I need to install an app or browser extension?',
                    'a' => 'No installation needed. Everything runs in your browser — just paste the link and download. Works on Windows, Mac, iOS, Android, and Linux.',
                ],
                [
                    'q' => 'Can I download audio from private Instagram accounts?',
                    'a' => 'No. Only publicly accessible content can be processed. If the account is set to private, the tool will not be able to fetch the content.',
                ],
                [
                    'q' => 'Is it safe to use :appName?',
                    'a' => 'Yes. No personal data or login credentials are ever required. Links you paste are used only to fetch the audio and are not stored permanently.',
                ],
                [
                    'q' => 'How long does audio extraction take?',
                    'a' => 'Typically 10–30 seconds depending on the video length and server load. A progress indicator will show while your audio is being prepared.',
                ],
                [
                    'q' => 'Can I use the downloaded audio in my own content?',
                    'a' => 'Downloaded audio is for personal use only. Music and audio on Instagram may be protected by copyright. Always check the rights of the original content before using it publicly or commercially.',
                ],
            ];
            @endphp

            @foreach($faqs as $i => $faq)
            <div class="faq-item" :class="{ 'faq-item--open': open === {{ $i }} }">
                <button class="faq-question" @click="open = open === {{ $i }} ? null : {{ $i }}" :aria-expanded="open === {{ $i }}">
                    <span class="faq-num">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span>
                    <span class="faq-q-text">@lang($faq['q'], ['appName' => config('app.name')])</span>
                    <svg class="faq-chevron" width="18" height="18" fill="none" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </button>
                <div class="faq-answer" x-show="open === {{ $i }}" x-collapse>
                    <p>@lang($faq['a'], ['appName' => config('app.name')])</p>
                </div>
            </div>
            @endforeach

            <div class="faq-footer">
                <div class="faq-footer-left">
                    <span class="faq-footer-icon">
                        <svg width="18" height="18" fill="none" viewBox="0 0 24 24"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </span>
                    <span>@lang("Still have questions? View our complete FAQ.")</span>
                </div>
                <a href="/how-to-save" class="faq-footer-btn">@lang("View All FAQs")</a>
            </div>
        </div>

    </div>
</section>
