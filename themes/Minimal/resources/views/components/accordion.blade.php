<div class="accordion" x-data="AccordionComponent()">
    <button class="accordion-toggle" @click="toggleShow()" :class="{'is-open': show}">
        <h4>{{$title}}</h4>
        <x-theme::icon.chevron-down class="icon" aria-hidden="true"/>
    </button>
    <div class="accordion-content" x-collapse x-cloak x-show="show">
        {{$slot}}
    </div>
</div>

@pushonce('scripts')
    <script>
        function AccordionComponent() {
            return {
                show: false,
                toggleShow() {
                    this.show = !this.show;
                }
            };
        }
    </script>
@endpushonce
