@php
    /** @var \App\Service\Theme\Theme $theme */
@endphp
    <!doctype html>
<html lang="{{app()->getLocale()}}" dir="{{$theme->isRTL(app()->getLocale()) ? 'rtl' : 'ltr'}}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=yes, initial-scale=1.0, maximum-scale=5.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$title ?? config('app.name')}}</title>
    <meta name="description"
          content="{{$description ?? str(config('app.description'))->replace('\n', '')}}">
    <meta name="keywords"
          content="{{config('app.keywords')}}">
    <link rel="shortcut icon" href="{{asset('favicon.png')}}" type="image/png">

    <meta property="og:title" content="{{$title ?? config('app.name')}}">
    <meta property="og:description" content="{{$description ?? str(config('app.description'))->replace('\n', '')}}">
    <meta property="og:image" content="{{asset('/cover.jpg')}}">
    <meta property="og:url" content="{{config('app.url')}}">
    <meta name="twitter:card" content="{{asset('cover.jpg')}}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;500;600;700;900&display=swap"
          as="style">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;500;600;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{$theme->asset('css/app.css')}}">
    {{$styles ?? ''}}
    <script defer src="https://unpkg.com/@alpinejs/collapse@3.10.3/dist/cdn.min.js"
            integrity="sha384-gE382HiLf7oZIQO4e8O4ursZqf9JAjQQgNCRsUyUKfWBMXOiEFm89KxNkJjycgEq"
            crossorigin="anonymous"></script>
    <script defer src="https://unpkg.com/alpinejs@3.10.3/dist/cdn.min.js"
            integrity="sha384-WJjkwfwjSA9R8jBkDaVBHc+idGbOa+2W4uq2SOwLCHXyNktpMVINGAD2fCYbUZn6"
            crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://unpkg.com/toastedjs@0.0.2/dist/toasted.min.css">
    <script defer src="https://unpkg.com/toastedjs@0.0.2/dist/toasted.min.js"
            integrity="sha384-/MVO8JFl9R2K32DQkRu+OOg3layD72sHHL9HBuMtiu2XCGeIYRL+WI3YizSdB3PF"
            crossorigin="anonymous"></script>
    <script defer>
        document.addEventListener('DOMContentLoaded', function () {
            window.toasted = new window.Toasted({
                theme: 'bootstrap',
                position: 'top-center',
                duration: 5000,
            })
        });
    </script>

    <x-theme::head/>
</head>
<body>
<x-theme::header/>
{{$slot}}
<x-theme::footer/>
<script>
    window.RequestError = class extends Error {
        constructor(response) {
            super(response.status);
            this.response = response;
        }
    }

    window.handleErrors = function (e) {
        if (!(e instanceof window.RequestError)) {
            if (window.toasted) {
                window.toasted.show(e.message, { type: "error" });
            }
            return;
        }

        const isJson = e.response.headers.get('Content-Type')?.includes('application/json');
        const promise = isJson ? e.response.json() : e.response.text();
        promise.then(function (data) {
            if (isJson) {
                if (window.toasted) window.toasted.show(data.message, { type: "error" });
            } else {
                const backdrop = document.createElement('div');
                const bdStyles = {
                    position: 'fixed', top: 0, left: 0,
                    width: '100%', height: '100%',
                    background: 'rgba(0,0,0,0.5)', zIndex: 9999,
                };
                for (let style in bdStyles) backdrop.style[style] = bdStyles[style];

                const iframe = document.createElement("iframe");
                const styles = {
                    position: "fixed", height: '90vh', width: '90vw',
                    top: '5vh', left: '5vw', borderRadius: '8px',
                    backgroundColor: '#18171B', border: '0px', zIndex: 99999
                };
                for (let style in styles) iframe.style[style] = styles[style];

                backdrop.addEventListener('click', function () {
                    backdrop.remove(); iframe.remove();
                });

                iframe.sandbox.add('allow-scripts', 'allow-same-origin', 'allow-popups', 'allow-forms');
                document.body.append(backdrop, iframe);

                const page = document.createElement('html');
                page.innerHTML = data;
                iframe.contentWindow.document.open();
                iframe.contentWindow.document.write(page.outerHTML);
                iframe.contentWindow.document.close();
            }
        });
    }
</script>
@stack('scripts')
</body>
</html>
