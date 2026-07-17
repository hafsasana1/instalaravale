<section class="about-section" aria-label="About Section">
    <div class="container">
        <x-theme::ad.about-section-ad />

        <p>@lang(":appName is one of the most popular tools to save no-watermark TikTok videos and extract Instagram audio. No need to install any apps to use our service — all you need is a browser and a valid link.", ['appName'=> config('app.name')])</p>

        <div class="service-cards">
            <div class="service-card">
                <div class="icon">
                    <x-theme::icon.mini.paper-clip/>
                </div>
                <p>@lang("It's a perfect solution for post-editing and publishing videos.")</p>
            </div>
            <div class="service-card">
                <div class="icon">
                    <x-theme::icon.mini.tag/>
                </div>
                <p>@lang("It is free. You can save as many mp4 files and audio tracks as you want.")</p>
            </div>
            <div class="service-card">
                <div class="icon">
                    <x-theme::icon.mini.user/>
                </div>
                <p>@lang("Registration is not required. Just open our website and paste the link.")</p>
            </div>

            <div class="service-card">
                <div class="icon">
                    <x-theme::icon.mini.bolt/>
                </div>
                <p>@lang("Download TikTok videos without watermark and Instagram audio at high speed.")</p>
            </div>
            <div class="service-card">
                <div class="icon">
                    <x-theme::icon.mini.music/>
                </div>
                <p>@lang("Save TikTok in mp4 or mp3 and Instagram audio in mp3 or m4a online.")</p>
            </div>
            <div class="service-card">
                <div class="icon">
                    <x-theme::icon.mini.computer-desktop/>
                </div>
                <p>@lang("Works in every browser and operating system — no installation needed.")</p>
            </div>
        </div>
    </div>
</section>
