<section class="usage-section insta-formats-section" aria-label="Instagram Formats Section">
    <div class="container">
        <x-theme::ad.usage-section-ad />

        <div class="insta-formats-header">
            <h2>@lang("Download Audio from Every Instagram Format")</h2>
            <p>@lang("Reels, Stories, Videos, Carousels, Live replays, Highlights — :appName extracts audio from every content type on Instagram. No format left behind.", ['appName' => config('app.name')])</p>
        </div>

        <div class="insta-formats-grid">

            <div class="insta-format-card">
                <div class="insta-format-icon" style="background: linear-gradient(135deg,#833AB4,#E1306C);">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2"/><polyline points="8 21 12 17 16 21"/></svg>
                </div>
                <h3>@lang("Instagram Reels")</h3>
                <p>@lang("Reels are where trends start. When a viral sound hits, :appName captures it instantly — extract the trending track in seconds, download as MP3 or M4A, and use it before the trend cycle ends.", ['appName' => config('app.name')])</p>
            </div>

            <div class="insta-format-card">
                <div class="insta-format-icon" style="background: linear-gradient(135deg,#E1306C,#F77737);">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
                </div>
                <h3>@lang("Instagram Stories")</h3>
                <p>@lang("Stories vanish after 24 hours. If a creator soundtracked their day with a song you need, download it before it's gone. Works for spoken announcements, ambient audio, and one-off music clips.")</p>
            </div>

            <div class="insta-format-card">
                <div class="insta-format-icon" style="background: linear-gradient(135deg,#F77737,#FCAF45);">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polygon points="10 8 16 12 10 16 10 8"/></svg>
                </div>
                <h3>@lang("Instagram Videos")</h3>
                <p>@lang("Long-form Instagram videos — interviews, tutorials, event recordings — often contain substantial spoken content worth keeping. Extract the full audio from clips and reference offline without rewatching.")</p>
            </div>

            <div class="insta-format-card">
                <div class="insta-format-icon" style="background: linear-gradient(135deg,#E1306C,#833AB4);">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                </div>
                <h3>@lang("Instagram Photos")</h3>
                <p>@lang("Some photo posts include background audio. :appName extracts the audio layer when present. If a photo post has no audio attached, the tool will indicate no audio track was found.", ['appName' => config('app.name')])</p>
            </div>

            <div class="insta-format-card">
                <div class="insta-format-icon" style="background: linear-gradient(135deg,#FCAF45,#E1306C);">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg>
                </div>
                <h3>@lang("Instagram Carousel")</h3>
                <p>@lang("Carousel posts may contain audio — either background music or video audio from individual slides. :appName extracts the primary audio track from the carousel, just like it does from single posts.", ['appName' => config('app.name')])</p>
            </div>

            <div class="insta-format-card">
                <div class="insta-format-icon" style="background: linear-gradient(135deg,#833AB4,#405DE6);">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21l-7-5-7 5V5a2 2 0 012-2h10a2 2 0 012 2z"/></svg>
                </div>
                <h3>@lang("Instagram Highlights")</h3>
                <p>@lang("Unlike Stories that vanish, Highlights stay on creator profiles forever. Extract audio from archived Stories anytime — perfect for revisiting tutorials, discovering music you missed.")</p>
            </div>

            <div class="insta-format-card">
                <div class="insta-format-icon" style="background: linear-gradient(135deg,#E1306C,#F77737);">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 1a3 3 0 00-3 3v8a3 3 0 006 0V4a3 3 0 00-3-3z"/><path d="M19 10v2a7 7 0 01-14 0v-2"/><line x1="12" y1="19" x2="12" y2="23"/><line x1="8" y1="23" x2="16" y2="23"/></svg>
                </div>
                <h3>@lang("Voiceovers")</h3>
                <p>@lang("Creators narrate over footage constantly — recipes, skincare routines, tutorials. Extract full voiceover audio from posts to revisit steps, reference teaching style, or keep spoken instructions.")</p>
            </div>

            <div class="insta-format-card">
                <div class="insta-format-icon" style="background: linear-gradient(135deg,#405DE6,#833AB4);">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 18V5l12-2v13"/><circle cx="6" cy="18" r="3"/><circle cx="18" cy="16" r="3"/></svg>
                </div>
                <h3>@lang("Music & Original Audio")</h3>
                <p>@lang("Instagram mixes licensed tracks with original creator beats and recordings. When you hear a production you can't identify, extract the raw audio file and analyze production quality.")</p>
            </div>

        </div>
    </div>
</section>
