<x-theme::layout
    title="Instagram Reels Audio Downloader – Download MP3 from Reels"
    description="Extract and save audio from any public Instagram Reel as MP3 or M4A. No login, no app, no limit. Works on iPhone, Android, and every desktop browser.">

{{-- ═══════════════════════════════════════════
     HERO
════════════════════════════════════════════ --}}
<section class="ra-hero" aria-label="Reels Audio Downloader" x-data="SplashApp()">
    <div class="container ra-hero__inner">

        <div class="ra-hero__badge">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="2.18"/><line x1="7" y1="2" x2="7" y2="22"/><line x1="17" y1="2" x2="17" y2="22"/><line x1="2" y1="12" x2="22" y2="12"/></svg>
            Instagram Reels Audio Downloader
        </div>

        <h1 class="ra-hero__title">
            Download Audio from
            <span class="ra-hero__gradient">Instagram Reels</span>
        </h1>

        <p class="ra-hero__desc">
            Extract and save the audio from any public Instagram Reel as MP3 or M4A.
            No login, no app, no limit. Works on iPhone, Android, and every desktop browser.
        </p>

        {{-- ── Search form ── --}}
        <div x-show="!instaResult">
            <form @submit.prevent="submitInsta()" x-ref="instaForm" method="POST" action="/insta-fetch">
                @csrf
                <div class="ra-search" x-data="{ fmtOpen: false }">
                    <svg class="ra-search__icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10 13a5 5 0 007.54.54l3-3a5 5 0 00-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 00-7.54-.54l-3 3a5 5 0 007.07 7.07l1.71-1.71"/></svg>
                    <input x-model="instaUrl" name="url" type="url"
                           placeholder="Paste Instagram Reel, Post, or Story link here..."
                           aria-label="Instagram Reel URL" class="ra-search__input" required>

                    {{-- Format dropdown --}}
                    <div class="ra-fmt" @click.outside="fmtOpen = false">
                        <button type="button" class="ra-fmt__trigger" @click="fmtOpen = !fmtOpen">
                            <span class="ra-fmt__label" x-text="instaFormat.toUpperCase()">MP3</span>
                            <span class="ra-fmt__sub">Best con</span>
                            <svg :class="{ 'ra-fmt__arrow--open': fmtOpen }" class="ra-fmt__arrow" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                        </button>
                        <ul class="ra-fmt__menu" x-show="fmtOpen" x-cloak role="listbox">
                            <li class="ra-fmt__opt" :class="{'ra-fmt__opt--active': instaFormat==='mp3'}" @click="instaFormat='mp3'; fmtOpen=false">
                                <span class="ra-fmt__opt-name">MP3</span>
                                <span class="ra-fmt__opt-desc">Best quality</span>
                            </li>
                            <li class="ra-fmt__opt" :class="{'ra-fmt__opt--active': instaFormat==='m4a'}" @click="instaFormat='m4a'; fmtOpen=false">
                                <span class="ra-fmt__opt-name">M4A</span>
                                <span class="ra-fmt__opt-desc">Original audio</span>
                            </li>
                        </ul>
                    </div>
                    <input type="hidden" name="format" :value="instaFormat">

                    <button :disabled="instaProcessing" type="submit" class="ra-search__btn">
                        <span x-show="!instaProcessing">Download</span>
                        <x-theme::icon.loading x-show="instaProcessing" class="icon" x-cloak="true"/>
                    </button>
                </div>
            </form>

            <div class="ra-hero__badges">
                <span>✓ Trending Sounds</span>
                <span>✓ Music Tracks</span>
                <span>✓ Voiceovers</span>
                <span>✓ MP3 &amp; M4A</span>
                <span>✓ Free Forever</span>
            </div>
        </div>

        {{-- Result card --}}
        <template x-if="instaResult">
            <div class="insta-result-card">
                <div class="insta-thumb-wrap">
                    <img class="insta-thumb-img" :src="instaResult.thumbnail" :alt="instaResult.title"
                         x-show="instaResult.thumbnail" @@error="$el.style.display='none'">
                    <div class="insta-thumb-overlay">
                        <div class="insta-thumb-badge">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                            Instagram
                        </div>
                    </div>
                </div>
                <div class="insta-result-meta">
                    <div class="insta-result-uploader">
                        <svg width="14" height="14" fill="none" viewBox="0 0 24 24"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        <span x-text="instaResult.uploader"></span>
                    </div>
                    <h2 class="insta-result-title" x-text="instaResult.title"></h2>
                    <div class="insta-result-duration" x-show="instaResult.duration_string">
                        <svg width="13" height="13" fill="none" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/><path d="M12 6v6l4 2" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                        <span x-text="instaResult.duration_string"></span>
                    </div>
                </div>
                <div class="insta-player-wrap">
                    <div class="insta-player-label">
                        <svg width="15" height="15" fill="none" viewBox="0 0 24 24"><path d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        Preview Audio
                    </div>
                    <audio class="insta-audio-player" controls preload="metadata" :src="previewSrc" x-ref="audioEl">
                        Your browser does not support the audio element.
                    </audio>
                    <p class="insta-player-note">⚡ Preview loads from server — may take a moment</p>
                </div>
                <div class="insta-download-btns">
                    <a class="insta-dl-btn insta-dl-btn--mp3" :href="instaDownloadUrl('mp3')" @click.prevent="startInstaDownload('mp3')" target="_blank">
                        <svg width="16" height="16" fill="none" viewBox="0 0 24 24"><path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        Download MP3
                    </a>
                    <a class="insta-dl-btn insta-dl-btn--m4a" :href="instaDownloadUrl('m4a')" @click.prevent="startInstaDownload('m4a')" target="_blank">
                        <svg width="16" height="16" fill="none" viewBox="0 0 24 24"><path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        Download M4A
                    </a>
                </div>
                <div x-show="instaDownloading" class="insta-dl-notice">
                    <svg class="spin" width="15" height="15" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3" stroke-dasharray="60" stroke-dashoffset="20" stroke-linecap="round"/></svg>
                    Extracting audio — this may take 15–30 seconds…
                </div>
                <button class="insta-reset-btn" @click="resetInsta()">
                    <svg width="13" height="13" fill="none" viewBox="0 0 24 24"><path d="M10 19l-7-7m0 0l7-7m-7 7h18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    Try another Instagram link
                </button>
            </div>
        </template>

        {{-- Error --}}
        <div x-show="instaError" x-cloak class="insta-error-banner">
            <svg width="18" height="18" fill="none" viewBox="0 0 24 24"><path d="M12 9v4m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            <span x-text="instaError"></span>
            <button @click="instaError = null" aria-label="Dismiss">✕</button>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════
     WHAT AUDIO CAN YOU DOWNLOAD
════════════════════════════════════════════ --}}
<section class="ra-section">
    <div class="container">
        <div class="ra-section__head">
            <h2>What Audio Can You Download from a Reel?</h2>
            <p>Instagram Reels can carry three types of audio: a licensed music track from Instagram's library, an original sound recorded or uploaded by the creator, or a remixed version of another creator's audio. Our tool extracts whichever audio stream is in the Reel — you get exactly what you hear.</p>
        </div>
        <div class="ra-cards">
            <div class="ra-card">
                <div class="ra-card__icon" style="background:#fff0f5;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#E1306C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 7 13.5 15.5 8.5 10.5 2 17"/><polyline points="16 7 22 7 22 13"/></svg>
                </div>
                <h3>Trending Sounds</h3>
                <p>Grab a trending track the moment it goes viral and use it in your own content on any platform before the trend cycle moves on.</p>
            </div>
            <div class="ra-card">
                <div class="ra-card__icon" style="background:#fff0f5;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#E1306C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 18V5l12-2v13"/><circle cx="6" cy="18" r="3"/><circle cx="18" cy="16" r="3"/></svg>
                </div>
                <h3>Music Reference</h3>
                <p>Save a track you can't Shazam — drop it into your DAW to analyse the BPM, key, or arrangement before finding a licensed replacement.</p>
            </div>
            <div class="ra-card">
                <div class="ra-card__icon" style="background:#fff0f5;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#E1306C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 1a3 3 0 0 0-3 3v8a3 3 0 0 0 6 0V4a3 3 0 0 0-3-3z"/><path d="M19 10v2a7 7 0 0 1-14 0v-2"/><line x1="12" y1="19" x2="12" y2="23"/><line x1="8" y1="23" x2="16" y2="23"/></svg>
                </div>
                <h3>Voiceover Clips</h3>
                <p>Extract spoken content from interview Reels, tutorials, or creator commentary for use as a reference clip or podcast interstitial.</p>
            </div>
            <div class="ra-card">
                <div class="ra-card__icon" style="background:#fff0f5;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#E1306C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="2.18"/><line x1="7" y1="2" x2="7" y2="22"/><line x1="17" y1="2" x2="17" y2="22"/><line x1="2" y1="12" x2="22" y2="12"/></svg>
                </div>
                <h3>Video Editing</h3>
                <p>Use a Reel's audio as a temp track while editing your own video to lock the timing and mood before final music clearance.</p>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════
     HOW TO DOWNLOAD
════════════════════════════════════════════ --}}
<section class="ra-section ra-section--alt">
    <div class="container">
        <div class="ra-section__head">
            <h2>How to Download Audio from Instagram Reels</h2>
            <p>From copying a link to having the audio file on your device — the whole process takes under 30 seconds and requires nothing but a browser.</p>
        </div>
        <div class="ra-steps">
            <div class="ra-step">
                <div class="ra-step__num">01</div>
                <div class="ra-step__body">
                    <h3>Open the Instagram Reel</h3>
                    <p>Find the Reel you want on Instagram — in the app or in a browser. The post must be public; private accounts cannot be downloaded.</p>
                </div>
            </div>
            <div class="ra-step">
                <div class="ra-step__num">02</div>
                <div class="ra-step__body">
                    <h3>Copy the Link</h3>
                    <p>Tap the three-dot menu (⋯) on the Reel and select <strong>Copy Link</strong>. The URL is instantly saved to your clipboard — ready to paste.</p>
                </div>
            </div>
            <div class="ra-step">
                <div class="ra-step__num">03</div>
                <div class="ra-step__body">
                    <h3>Paste &amp; Download</h3>
                    <p>Paste the link into the box above, choose MP3 or M4A, and click <strong>Download</strong>. Your audio file will be ready within seconds.</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════
     FORMATS
════════════════════════════════════════════ --}}
<section class="ra-section">
    <div class="container">
        <div class="ra-section__head">
            <h2>Supported Output Formats</h2>
            <p>Choose the format that fits your workflow — both options are lossless extractions of the original Instagram audio stream.</p>
        </div>
        <div class="ra-fmt-grid">
            <div class="ra-fmt-card">
                <div class="ra-fmt-card__icon">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#E1306C" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M9 18V5l12-2v13"/><circle cx="6" cy="18" r="3"/><circle cx="18" cy="16" r="3"/></svg>
                </div>
                <h3>MP3</h3>
                <p>The universal audio format. Compatible with every device, music player, and editing app. Best choice for most users.</p>
                <ul class="ra-fmt-card__list">
                    <li>✓ Plays everywhere</li>
                    <li>✓ Small file size</li>
                    <li>✓ High audio quality</li>
                </ul>
            </div>
            <div class="ra-fmt-card">
                <div class="ra-fmt-card__icon">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#E1306C" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M3 18v-6a9 9 0 0 1 18 0v6"/><path d="M21 19a2 2 0 0 1-2 2h-1a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h3zM3 19a2 2 0 0 0 2 2h1a2 2 0 0 0 2-2v-3a2 2 0 0 0-2-2H3z"/></svg>
                </div>
                <h3>M4A</h3>
                <p>Apple's preferred audio container. Closest to the original stream Instagram uses — ideal for professional editing workflows.</p>
                <ul class="ra-fmt-card__list">
                    <li>✓ Original quality</li>
                    <li>✓ AAC codec</li>
                    <li>✓ Great for Apple devices</li>
                </ul>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════
     FAQ
════════════════════════════════════════════ --}}
<section class="ra-section ra-section--alt">
    <div class="container">
        <div class="ra-section__head">
            <h2>Frequently Asked Questions</h2>
            <p>Everything you need to know about downloading audio from Instagram Reels.</p>
        </div>
        <div class="ra-faq" x-data="{ open: null }">

            <div class="ra-faq__item" :class="{ 'ra-faq__item--open': open === 0 }">
                <button class="ra-faq__q" @click="open = open === 0 ? null : 0">
                    Is it free to download audio from Instagram Reels?
                    <svg class="ra-faq__arrow" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                </button>
                <div class="ra-faq__a" x-show="open === 0" x-collapse>
                    <p>Yes, completely free. There are no download limits, no subscription fees, and no hidden charges. You can download as many Reel audio files as you need.</p>
                </div>
            </div>

            <div class="ra-faq__item" :class="{ 'ra-faq__item--open': open === 1 }">
                <button class="ra-faq__q" @click="open = open === 1 ? null : 1">
                    Do I need to create an account or log in?
                    <svg class="ra-faq__arrow" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                </button>
                <div class="ra-faq__a" x-show="open === 1" x-collapse>
                    <p>No account needed. Just paste the Reel link and download. We don't ask for your Instagram credentials or any personal information.</p>
                </div>
            </div>

            <div class="ra-faq__item" :class="{ 'ra-faq__item--open': open === 2 }">
                <button class="ra-faq__q" @click="open = open === 2 ? null : 2">
                    Can I download audio from private Instagram accounts?
                    <svg class="ra-faq__arrow" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                </button>
                <div class="ra-faq__a" x-show="open === 2" x-collapse>
                    <p>No. Only publicly accessible Reels can be processed. If an account is set to private, the post cannot be reached by our servers, so the download will not work.</p>
                </div>
            </div>

            <div class="ra-faq__item" :class="{ 'ra-faq__item--open': open === 3 }">
                <button class="ra-faq__q" @click="open = open === 3 ? null : 3">
                    What is the difference between MP3 and M4A?
                    <svg class="ra-faq__arrow" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                </button>
                <div class="ra-faq__a" x-show="open === 3" x-collapse>
                    <p>MP3 is the most widely compatible format and works on virtually every device. M4A uses the AAC codec and is the native format Instagram streams use — it may sound slightly better and is preferred by Apple users and professional editors.</p>
                </div>
            </div>

            <div class="ra-faq__item" :class="{ 'ra-faq__item--open': open === 4 }">
                <button class="ra-faq__q" @click="open = open === 4 ? null : 4">
                    Does the audio have a watermark?
                    <svg class="ra-faq__arrow" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                </button>
                <div class="ra-faq__a" x-show="open === 4" x-collapse>
                    <p>No. Audio files have no watermarks — it is the clean original audio stream extracted directly from the Reel. There is no branding or audible tag added.</p>
                </div>
            </div>

            <div class="ra-faq__item" :class="{ 'ra-faq__item--open': open === 5 }">
                <button class="ra-faq__q" @click="open = open === 5 ? null : 5">
                    Does this work on iPhone and Android?
                    <svg class="ra-faq__arrow" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                </button>
                <div class="ra-faq__a" x-show="open === 5" x-collapse>
                    <p>Yes. The tool is fully browser-based. No app installation required — open this page in Safari, Chrome, Firefox, or any browser on any device and the download works the same way.</p>
                </div>
            </div>

        </div>
    </div>
</section>

<script>
function SplashApp() {
    return {
        instaResult: null,
        instaUrl: "",
        instaFormat: "mp3",
        instaProcessing: false,
        instaDownloading: false,
        instaError: null,
        previewSrc: "",

        submitInsta() {
            if (!this.instaUrl.trim()) return;
            if (!validateInstagramURL(this.instaUrl)) {
                this.instaError = 'Please paste a valid Instagram link (instagram.com/reel/, /p/, /tv/, or /stories/).';
                return;
            }
            this.instaProcessing = true;
            this.instaError = null;
            this.instaResult = null;
            this.previewSrc = "";
            const self = this;
            const fd = new FormData(this.$refs.instaForm);
            fetch('/insta-fetch', { method: 'POST', body: fd, headers: { "accept": "application/json" } })
                .then(r => r.json().then(d => { if (!r.ok) throw d; return d; }))
                .then(d => { self.instaResult = d; self.previewSrc = d.audio_url || ''; })
                .catch(err => {
                    self.instaError = (err && err.message) ? err.message : 'Could not process that link. Make sure the post is public.';
                })
                .finally(() => { self.instaProcessing = false; });
        },
        instaDownloadUrl(fmt) {
            if (!this.instaResult) return '#';
            const u = new URL('/download', window.location.origin);
            u.searchParams.set('url', btoa(this.instaResult.url));
            u.searchParams.set('format', fmt);
            u.searchParams.set('extension', fmt);
            return u.toString();
        },
        startInstaDownload(fmt) {
            this.instaDownloading = true;
            const a = document.createElement('a');
            a.href = this.instaDownloadUrl(fmt);
            a.target = '_blank';
            document.body.appendChild(a); a.click(); document.body.removeChild(a);
            setTimeout(() => { this.instaDownloading = false; }, 35000);
        },
        resetInsta() {
            this.instaUrl = '';
            this.instaResult = null;
            this.instaError = null;
            this.instaDownloading = false;
            this.previewSrc = '';
            if (this.$refs.audioEl) this.$refs.audioEl.pause();
        },
    };
}
function validateInstagramURL(url) {
    return /https?:\/\/(www\.)?instagram\.com\/(p|reel|reels|tv|stories)\/[a-zA-Z0-9_\-]+/i.test(url);
}
</script>

</x-theme::layout>
