<section class="popular-videos-section" aria-label="Popular Videos">
    <div class="container">
        <h2>@lang('Popular Videos')</h2>
        <div @class(['popular-videos', 'is-empty'=> $videos->isEmpty()])>
            @forelse($videos as $video)
                <div x-data="VideoItem()" class="popular-video" dir="ltr">
                    <img class="popular-video-bg" x-show="!failed" src="{{$video->getCoverUrl()}}"
                         alt="Background image" crossorigin="anonymous" role="presentation" @@error.once="onFail()">
                    <img class="popular-video-bg" x-cloak="true" x-show="failed"
                         src="{{$theme->asset('images/video-placeholder.png')}}" alt="Background image"
                         role="presentation">
                    <div class="popular-video-action">
                        <button class="icon-button" @click="$dispatch('search-video', '{{$video->url}}')">
                            <x-theme::icon.mini.download class="icon"/>
                        </button>
                    </div>
                    <div class="popular-video-content">
                        <span>{{ '@' . $video->username }}</span>
                    </div>
                </div>
            @empty
                <div class="popular-video-empty">
                    <img src="{{$theme->asset('images/video-player.webp')}}" alt="a 3D video player art">
                    <h3>@lang("No popular videos this month so far.")</h3>
                </div>
            @endforelse
        </div>
    </div>
</section>
@pushonce('scripts')
    <script>
        function VideoItem() {
            return {
                onFail() {
                    this.failed = true
                },
                failed: false
            }
        }
    </script>
@endpushonce
