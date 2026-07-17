<section class="splash" aria-label="Downloader Section" x-data="SplashApp()">
    <div class="container">

        {{-- ===== INSTAGRAM AUDIO ===== --}}
        <div>

            {{-- Search form (hidden when result shown) --}}
            <div x-show="!instaResult">
                <h1>Instagram Audio Downloader</h1>
                <form @submit.prevent="submitInsta()" x-ref="instaForm" method="POST" action="/insta-fetch">
                    <div class="splash-search pi">
                        @csrf
                        <input x-model="instaUrl" name="url" type="url"
                               placeholder="Paste Instagram Reel, Post or Story link here..."
                               aria-label="Instagram URL" class="splash-search-input pi-end" required>
                        <button type="button" @click.prevent="pasteInsta()" x-show="canPaste"
                                class="splash-paste-button mi-end" aria-label="Paste">
                            <x-theme::icon.clipboard class="icon mi-end" aria-hidden="true"/>
                            <span aria-hidden="true">Paste</span>
                        </button>
                        <button :disabled="instaProcessing" type="submit" class="splash-search-button splash-search-button--insta">
                            <span x-show="!instaProcessing">Extract Audio</span>
                            <x-theme::icon.loading x-show="instaProcessing" class="icon" x-cloak="true"/>
                        </button>
                    </div>
                    <div class="insta-format-row">
                        <span class="insta-format-label">Format:</span>
                        <label class="insta-format-option" :class="{ active: instaFormat === 'mp3' }">
                            <input type="radio" x-model="instaFormat" value="mp3" name="format" hidden> MP3
                        </label>
                        <label class="insta-format-option" :class="{ active: instaFormat === 'm4a' }">
                            <input type="radio" x-model="instaFormat" value="m4a" name="format" hidden> M4A
                        </label>
                    </div>
                </form>
            </div>

            {{-- Result card with player --}}
            <template x-if="instaResult">
                <div class="insta-result-card">

                    {{-- Thumbnail + overlay --}}
                    <div class="insta-thumb-wrap">
                        <img class="insta-thumb-img"
                             :src="instaResult.thumbnail"
                             :alt="instaResult.title"
                             x-show="instaResult.thumbnail"
                             @@error="$el.style.display='none'">
                        <div class="insta-thumb-overlay">
                            <div class="insta-thumb-badge">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                                Instagram
                            </div>
                        </div>
                    </div>

                    {{-- Meta info --}}
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

                    {{-- Audio player --}}
                    <div class="insta-player-wrap">
                        <div class="insta-player-label">
                            <svg width="15" height="15" fill="none" viewBox="0 0 24 24"><path d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            Preview Audio
                        </div>
                        <audio
                            class="insta-audio-player"
                            controls
                            preload="metadata"
                            :src="previewSrc"
                            x-ref="audioEl">
                            Your browser does not support the audio element.
                        </audio>
                        <p class="insta-player-note">⚡ Preview loads from server — may take a moment</p>
                    </div>

                    {{-- Download buttons --}}
                    <div class="insta-download-btns">
                        <a class="insta-dl-btn insta-dl-btn--mp3"
                           :href="instaDownloadUrl('mp3')"
                           @click.prevent="startInstaDownload('mp3')"
                           target="_blank">
                            <svg width="16" height="16" fill="none" viewBox="0 0 24 24"><path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            Download MP3
                        </a>
                        <a class="insta-dl-btn insta-dl-btn--m4a"
                           :href="instaDownloadUrl('m4a')"
                           @click.prevent="startInstaDownload('m4a')"
                           target="_blank">
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

            {{-- Error banner --}}
            <div x-show="instaError" x-cloak class="insta-error-banner">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24"><path d="M12 9v4m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                <span x-text="instaError"></span>
                <button @click="instaError = null" aria-label="Dismiss">✕</button>
            </div>
        </div>

    </div>
</section>

@pushonce('scripts')
<script>
function SplashApp() {
    return {
        /* ─── Instagram ─── */
        instaResult: null,
        instaUrl: "",
        instaFormat: "mp3",
        instaProcessing: false,
        instaDownloading: false,
        instaError: null,
        previewSrc: "",

        get canPaste() { return !!window.navigator.clipboard; },

        /* ====== INSTAGRAM ====== */
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
                .then(d => {
                    self.instaResult = d;
                    // Use direct CDN audio URL from yt-dlp JSON
                    self.previewSrc = d.audio_url || '';
                })
                .catch(err => {
                    self.instaError = (err && err.message)
                        ? err.message
                        : 'Could not process that link. Make sure the post is public.';
                })
                .finally(() => { self.instaProcessing = false; });
        },
        pasteInsta() {
            if (this.canPaste) navigator.clipboard.readText().then(t => { this.instaUrl = t; });
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

function bytesToSize(bytes) {
    const units = ["byte", "kilobyte", "megabyte", "terabyte", "petabyte"];
    const unit = Math.floor(Math.log(bytes) / Math.log(1024));
    return new Intl.NumberFormat("en", {
        style: "unit", unit: units[unit], unitDisplay: 'narrow', notation: 'compact'
    }).format(bytes / 1024 ** unit);
}

function validateInstagramURL(url) {
    return /https?:\/\/(www\.)?instagram\.com\/(p|reel|reels|tv|stories)\/[a-zA-Z0-9_\-]+/i.test(url);
}
</script>
@endpushonce
