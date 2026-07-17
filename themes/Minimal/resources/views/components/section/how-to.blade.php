<section class="how-to-section" aria-label="How to Section">
    <div class="container">
        <h2>@lang("How to download TikTok & Instagram")</h2>
        <p>@lang(":appHost is a free tool helping you to download TikTok videos without watermarks and extract Instagram audio online. No app installation needed — just paste your link below.", ['appHost'=> request()->getHost()])
        </p>

        <div class="how-to-card">
            <h3>@lang("How to download TikTok without watermark?")</h3>
            <ol>
                <li class="inset-i-start">
                    <b>@lang("Find a TikTok")</b>
                    <span>@lang("play a video that you want to save to your mobile device, using the TikTok app")</span>
                </li>
                <li class="inset-i-start">
                    <b>@lang("Copy the link")</b>
                    <span>@lang("tap \"Share\" (the arrow button on top of a chosen video), and then tap \"Copy link\"")</span>
                </li>
                <li class="inset-i-start">
                    <b>@lang("Download")</b>
                    <span>@lang("go back to :appName, select the TikTok tab, paste the link and tap \"Download\"", ['appName'=> config('app.name')])</span>
                </li>
            </ol>
        </div>

        <div class="how-to-card" style="background: linear-gradient(to right, #833AB4, #E1306C); margin-top: 2rem;">
            <h3>@lang("How to download Instagram audio?")</h3>
            <ol>
                <li class="inset-i-start">
                    <b>@lang("Find an Instagram Reel or Post")</b>
                    <span>@lang("open a public Instagram Reel, Post, or Video in the Instagram app or browser")</span>
                </li>
                <li class="inset-i-start">
                    <b>@lang("Copy the link")</b>
                    <span>@lang("tap the three-dot menu and select \"Copy link\"")</span>
                </li>
                <li class="inset-i-start">
                    <b>@lang("Download Audio")</b>
                    <span>@lang("select the Instagram Audio tab, paste the link, choose MP3 or M4A, and tap \"Download Audio\"")</span>
                </li>
            </ol>
        </div>
    </div>
</section>
