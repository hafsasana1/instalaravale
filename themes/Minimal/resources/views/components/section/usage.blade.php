<section class="usage-section" aria-label="Usage Section">
    <div class="container">
        <x-theme::ad.usage-section-ad />

        <div class="usage-list">
            <div class="usage">
                <div class="usage-content">
                    <h3>@lang("How to download TikTok video on PC")</h3>
                    <p>@lang("This method is universal and convenient. A file will be saved without any trademark in the highest quality. It works perfectly on Windows, Mac OS, and Linux. PC users are not required to install any additional apps to save TikTok videos, and this is another plus when using this method.")</p>
                    <p>@lang("In order to use the :appName app on PC, laptop (Windows 7, 10), Mac, or a laptop you will need to copy a link from the website.", ['appName'=> config('app.name')])</p>
                    <p>@lang("Next, go back to :appName tool and paste the link in the text field on the main page. After that, you need to click on the \"Download\" button to get the link.", ['appName'=> config('app.name')])</p>
                </div>
                <figure class="usage-image">
                    <img src="{{$theme->asset('images/usage-pc.min.png')}}" alt="TikTok downloader on PC" width="1080"
                         height="1080"/>
                </figure>
            </div>
            <div class="usage">
                <div class="usage-content">
                    <h3>@lang("How to download TikTok video on iPhone or iPad (iOS)")</h3>
                    <p>@lang("If you are an iPhone or iPad owner, you need to install the Documents by Readdle app from the App Store.", ['appName'=> config('app.name')])</p>
                    <p>@lang("Due to Apple security policy, iOS users starting with the 12th version can't save TikTok videos directly from the browser. Copy the link of any TikTok file via the app, and launch the Documents by Readdle.")</p>
                    <p>@lang('In the bottom right corner of the screen, you will see a web browser icon. Tap it.')</p>
                    <p>@lang("When the browser is open, go to :appHost and paste the link in the text field. Choose the option you like and press the button again. The video will be saved to your device.", ["appHost"=> request()->getHost()])</p>
                </div>
                <figure class="usage-image">
                    <img src="{{$theme->asset('images/usage-ios.min.png')}}" alt="TikTok downloader on iOS" width="1080"
                         height="1080"/>
                </figure>
            </div>
        </div>


    </div>
</section>
