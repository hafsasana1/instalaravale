<x-theme::layout
    title="Instagram Stories Audio Downloader – Save Audio from Stories"
    description="Extract and save audio from any public Instagram Story as MP3 or M4A. No login, no app, no limit. Works on all devices.">

<script>
function SplashApp() {
    return {
        instaResult: null, instaUrl: "", instaFormat: "mp3",
        instaProcessing: false, instaDownloading: false, instaError: null, previewSrc: "",
        submitInsta() {
            if (!this.instaUrl.trim()) return;
            if (!validateInstagramURL(this.instaUrl)) { this.instaError = 'Please paste a valid Instagram link.'; return; }
            this.instaProcessing = true; this.instaError = null; this.instaResult = null; this.previewSrc = "";
            const self = this; const fd = new FormData(this.$refs.instaForm);
            fetch('/insta-fetch', { method: 'POST', body: fd, headers: { "accept": "application/json" } })
                .then(r => r.json().then(d => { if (!r.ok) throw d; return d; }))
                .then(d => { self.instaResult = d; self.previewSrc = d.audio_url || ''; })
                .catch(err => { self.instaError = (err && err.message) ? err.message : 'Could not process that link. Make sure the post is public.'; })
                .finally(() => { self.instaProcessing = false; });
        },
        instaDownloadUrl(fmt) {
            if (!this.instaResult) return '#';
            const u = new URL('/download', window.location.origin);
            u.searchParams.set('url', btoa(this.instaResult.url)); u.searchParams.set('format', fmt); u.searchParams.set('extension', fmt);
            return u.toString();
        },
        startInstaDownload(fmt) {
            this.instaDownloading = true;
            const a = document.createElement('a'); a.href = this.instaDownloadUrl(fmt); a.target = '_blank';
            document.body.appendChild(a); a.click(); document.body.removeChild(a);
            setTimeout(() => { this.instaDownloading = false; }, 35000);
        },
        resetInsta() {
            this.instaUrl = ''; this.instaResult = null; this.instaError = null; this.instaDownloading = false; this.previewSrc = '';
            if (this.$refs.audioEl) this.$refs.audioEl.pause();
        },
    };
}
function validateInstagramURL(url) {
    return /https?:\/\/(www\.)?instagram\.com\/(p|reel|reels|tv|stories)\/[a-zA-Z0-9_\-]+/i.test(url);
}
</script>

{{-- HERO --}}
<section class="ra-hero" aria-label="Stories Audio Downloader" x-data="SplashApp()">
    <div class="container ra-hero__inner">
        <div class="ra-hero__badge" style="background:rgba(99,102,241,0.08);color:#6366f1;border-color:rgba(99,102,241,0.2);">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
            Instagram Stories Audio Downloader
        </div>
        <h1 class="ra-hero__title">
            Download Audio from
            <span style="background:linear-gradient(90deg,#6366f1,#E1306C);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">Instagram Stories</span>
        </h1>
        <p class="ra-hero__desc">Extract and save audio from any public Instagram Story as MP3 or M4A. No login, no app, no limit. Works on iPhone, Android, and every desktop browser.</p>

        <div x-show="!instaResult">
            <form @submit.prevent="submitInsta()" x-ref="instaForm" method="POST" action="/insta-fetch">
                @csrf
                <div class="ra-search" x-data="{ fmtOpen: false }">
                    <svg class="ra-search__icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10 13a5 5 0 007.54.54l3-3a5 5 0 00-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 00-7.54-.54l-3 3a5 5 0 007.07 7.07l1.71-1.71"/></svg>
                    <input x-model="instaUrl" name="url" type="url" placeholder="Paste Instagram Story link here..." aria-label="Instagram Story URL" class="ra-search__input" required>
                    <div class="ra-fmt" @click.outside="fmtOpen = false">
                        <button type="button" class="ra-fmt__trigger" @click="fmtOpen = !fmtOpen">
                            <span class="ra-fmt__label" x-text="instaFormat.toUpperCase()">MP3</span>
                            <span class="ra-fmt__sub">Best con</span>
                            <svg :class="{ 'ra-fmt__arrow--open': fmtOpen }" class="ra-fmt__arrow" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                        </button>
                        <ul class="ra-fmt__menu" x-show="fmtOpen" x-cloak role="listbox">
                            <li class="ra-fmt__opt" :class="{'ra-fmt__opt--active': instaFormat==='mp3'}" @click="instaFormat='mp3'; fmtOpen=false"><span class="ra-fmt__opt-name">MP3</span><span class="ra-fmt__opt-desc">Best quality</span></li>
                            <li class="ra-fmt__opt" :class="{'ra-fmt__opt--active': instaFormat==='m4a'}" @click="instaFormat='m4a'; fmtOpen=false"><span class="ra-fmt__opt-name">M4A</span><span class="ra-fmt__opt-desc">Original audio</span></li>
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
                <span>✓ Stories Audio</span><span>✓ 24h Stories</span><span>✓ MP3 &amp; M4A</span><span>✓ No Login</span><span>✓ Free Forever</span>
            </div>
        </div>

        <template x-if="instaResult">
            <div class="insta-result-card">
                <div class="insta-thumb-wrap"><img class="insta-thumb-img" :src="instaResult.thumbnail" :alt="instaResult.title" x-show="instaResult.thumbnail" @@error="$el.style.display='none'"><div class="insta-thumb-overlay"><div class="insta-thumb-badge"><svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>Instagram</div></div></div>
                <div class="insta-result-meta"><div class="insta-result-uploader"><svg width="14" height="14" fill="none" viewBox="0 0 24 24"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg><span x-text="instaResult.uploader"></span></div><h2 class="insta-result-title" x-text="instaResult.title"></h2><div class="insta-result-duration" x-show="instaResult.duration_string"><svg width="13" height="13" fill="none" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/><path d="M12 6v6l4 2" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg><span x-text="instaResult.duration_string"></span></div></div>
                <div class="insta-player-wrap"><div class="insta-player-label"><svg width="15" height="15" fill="none" viewBox="0 0 24 24"><path d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>Preview Audio</div><audio class="insta-audio-player" controls preload="metadata" :src="previewSrc" x-ref="audioEl">Your browser does not support the audio element.</audio><p class="insta-player-note">⚡ Preview loads from server — may take a moment</p></div>
                <div class="insta-download-btns"><a class="insta-dl-btn insta-dl-btn--mp3" :href="instaDownloadUrl('mp3')" @click.prevent="startInstaDownload('mp3')" target="_blank"><svg width="16" height="16" fill="none" viewBox="0 0 24 24"><path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/></svg>Download MP3</a><a class="insta-dl-btn insta-dl-btn--m4a" :href="instaDownloadUrl('m4a')" @click.prevent="startInstaDownload('m4a')" target="_blank"><svg width="16" height="16" fill="none" viewBox="0 0 24 24"><path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/></svg>Download M4A</a></div>
                <div x-show="instaDownloading" class="insta-dl-notice"><svg class="spin" width="15" height="15" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3" stroke-dasharray="60" stroke-dashoffset="20" stroke-linecap="round"/></svg>Extracting audio — this may take 15–30 seconds…</div>
                <button class="insta-reset-btn" @click="resetInsta()"><svg width="13" height="13" fill="none" viewBox="0 0 24 24"><path d="M10 19l-7-7m0 0l7-7m-7 7h18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>Try another link</button>
            </div>
        </template>
        <div x-show="instaError" x-cloak class="insta-error-banner"><svg width="18" height="18" fill="none" viewBox="0 0 24 24"><path d="M12 9v4m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg><span x-text="instaError"></span><button @click="instaError = null" aria-label="Dismiss">✕</button></div>
    </div>
</section>

{{-- WHAT CAN YOU SAVE --}}
<section class="ra-section">
    <div class="container">
        <div class="ra-section__head">
            <h2>What Audio Can You Save from Instagram Stories?</h2>
            <p>Instagram Stories can contain music stickers, voiceovers, and ambient sound recorded during filming. Our tool extracts whichever audio is embedded — you get the exact sound you hear in the Story.</p>
        </div>
        <div class="ra-cards">
            <div class="ra-card"><div class="ra-card__icon" style="background:#f0f0ff;"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#6366f1" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 18V5l12-2v13"/><circle cx="6" cy="18" r="3"/><circle cx="18" cy="16" r="3"/></svg></div><h3>Music Stickers</h3><p>Save any song added via Instagram's music sticker — get the original track in MP3 or M4A directly from the Story.</p></div>
            <div class="ra-card"><div class="ra-card__icon" style="background:#f0f0ff;"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#6366f1" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 1a3 3 0 0 0-3 3v8a3 3 0 0 0 6 0V4a3 3 0 0 0-3-3z"/><path d="M19 10v2a7 7 0 0 1-14 0v-2"/><line x1="12" y1="19" x2="12" y2="23"/><line x1="8" y1="23" x2="16" y2="23"/></svg></div><h3>Voiceovers</h3><p>Extract spoken narration from tutorial or commentary Stories — perfect for podcast clips and reference recordings.</p></div>
            <div class="ra-card"><div class="ra-card__icon" style="background:#f0f0ff;"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#6366f1" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 7 13.5 15.5 8.5 10.5 2 17"/><polyline points="16 7 22 7 22 13"/></svg></div><h3>Trending Sounds</h3><p>Capture viral audio from Stories the moment it goes trending — before it's no longer accessible after 24 hours.</p></div>
            <div class="ra-card"><div class="ra-card__icon" style="background:#f0f0ff;"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#6366f1" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/></svg></div><h3>Background Audio</h3><p>Save ambient sound or background music recorded in a Story — useful for content creators and video editors.</p></div>
        </div>
    </div>
</section>

{{-- HOW TO --}}
<section class="ra-section ra-section--alt">
    <div class="container">
        <div class="ra-section__head">
            <h2>How to Download Audio from Instagram Stories</h2>
            <p>Three quick steps — no app or account required. Works directly in your browser.</p>
        </div>
        <div class="ra-steps">
            <div class="ra-step"><div class="ra-step__num">01</div><div class="ra-step__body"><h3>Open the Instagram Story</h3><p>Find the Story you want to save audio from. The account must be public — private Stories cannot be accessed.</p></div></div>
            <div class="ra-step"><div class="ra-step__num">02</div><div class="ra-step__body"><h3>Copy the Story Link</h3><p>Tap the three-dot menu (⋯) on the Story and select <strong>Copy Link</strong>. The URL is copied to your clipboard instantly.</p></div></div>
            <div class="ra-step"><div class="ra-step__num">03</div><div class="ra-step__body"><h3>Paste &amp; Download</h3><p>Paste the link into the box above, pick MP3 or M4A, and click <strong>Download</strong>. Your audio file is ready in seconds.</p></div></div>
        </div>
    </div>
</section>

{{-- FAQ --}}
<section class="ra-section">
    <div class="container">
        <div class="ra-section__head"><h2>Frequently Asked Questions</h2><p>Common questions about downloading audio from Instagram Stories.</p></div>
        <div class="ra-faq" x-data="{ open: null }">
            <div class="ra-faq__item" :class="{ 'ra-faq__item--open': open === 0 }"><button class="ra-faq__q" @click="open = open === 0 ? null : 0">Can I save audio from Stories that expired?<svg class="ra-faq__arrow" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg></button><div class="ra-faq__a" x-show="open === 0" x-collapse><p>No. Once a Story has expired (after 24 hours), it is no longer accessible on Instagram's servers. Our tool can only process Stories that are currently live and publicly visible.</p></div></div>
            <div class="ra-faq__item" :class="{ 'ra-faq__item--open': open === 1 }"><button class="ra-faq__q" @click="open = open === 1 ? null : 1">Do I need an Instagram account to use this?<svg class="ra-faq__arrow" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg></button><div class="ra-faq__a" x-show="open === 1" x-collapse><p>No Instagram account is needed. Just paste the public Story URL and download immediately — we never ask for your credentials.</p></div></div>
            <div class="ra-faq__item" :class="{ 'ra-faq__item--open': open === 2 }"><button class="ra-faq__q" @click="open = open === 2 ? null : 2">Is the audio watermark-free?<svg class="ra-faq__arrow" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg></button><div class="ra-faq__a" x-show="open === 2" x-collapse><p>Yes. The extracted audio is the raw stream from Instagram — no watermark, no branding, no audible tags added by us.</p></div></div>
            <div class="ra-faq__item" :class="{ 'ra-faq__item--open': open === 3 }"><button class="ra-faq__q" @click="open = open === 3 ? null : 3">Does this work on mobile?<svg class="ra-faq__arrow" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg></button><div class="ra-faq__a" x-show="open === 3" x-collapse><p>Yes — fully browser-based. Open this page in Safari or Chrome on your iPhone or Android device. No app installation required.</p></div></div>
        </div>
    </div>
</section>

</x-theme::layout>
