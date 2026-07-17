<section class="faq-section" aria-label="Frequently Asked Questions">
    <div class="container">
        <div class="section-header">
            <h2>Frequently Asked Questions</h2>
            <p>Everything you need to know about downloading Instagram audio.</p>
        </div>

        <div class="faq-list" x-data="{ open: null }">
            @php
            $faqs = [
                [
                    'q' => 'What types of Instagram content can I download audio from?',
                    'a' => 'You can extract audio from any public Instagram Reel, Post (with video), IGTV, and Story. Private accounts are not supported — the content must be publicly accessible.'
                ],
                [
                    'q' => 'Is it free to use?',
                    'a' => 'Yes, completely free with no hidden charges, subscriptions, or download limits. There are no watermarks added to the audio files.'
                ],
                [
                    'q' => 'What\'s the difference between MP3 and M4A?',
                    'a' => 'MP3 is the most widely compatible audio format and works on virtually every device and media player. M4A (AAC) generally offers better audio quality at the same file size but requires a slightly more modern player — most smartphones and computers support it natively.'
                ],
                [
                    'q' => 'Do I need to create an account?',
                    'a' => 'No account or login is required. Simply paste the Instagram link and click Download. No personal information is collected.'
                ],
                [
                    'q' => 'How do I get the link from Instagram?',
                    'a' => 'Open the Instagram app, find the Reel or Post you want, tap the three-dot menu (···) in the top right corner of the post, then tap "Copy Link". Paste that link into the field on this page.'
                ],
                [
                    'q' => 'Why is my link not working?',
                    'a' => 'Make sure the account is public and the content is a video/reel (not a photo). If the link is from a private account, we cannot access it. Also ensure you are copying the full URL that starts with https://www.instagram.com/.'
                ],
                [
                    'q' => 'Where is the audio saved after downloading?',
                    'a' => 'The audio file is saved to your browser\'s default download folder. You can change this location in your browser settings.'
                ],
            ];
            @endphp

            @foreach($faqs as $i => $faq)
            <div class="faq-item" x-data="{ isOpen: false }">
                <button class="faq-question" @click="isOpen = !isOpen" :aria-expanded="isOpen">
                    <span>{{ $faq['q'] }}</span>
                    <svg class="faq-chevron" :class="{ 'rotate': isOpen }" width="18" height="18" fill="none" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </button>
                <div class="faq-answer" x-show="isOpen" x-collapse>
                    <p>{{ $faq['a'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
