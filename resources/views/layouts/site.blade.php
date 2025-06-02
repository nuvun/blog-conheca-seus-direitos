<!doctype html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name='robots' content='index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1' />

        @include('partials.dns-prefech-and-preconnect')
        @include('partials.google-analytics')
        @include('partials.pwa')
        @include('partials.oneSignal')
        @include('partials.site.shareFacebook')
        @include('partials.site.structuredData')
        @include('partials.site.tagAmp')

        <title>@yield('title', config('app.name'))</title>
        <meta name="description" content="@yield('description', config('site.site_description'))">
        <link rel="canonical" href="{{ url()->current() }}" />

        <link rel="icon" href="{{ asset('assets/img/favicon.png') }}" sizes="32x32" />
        <link rel="icon" href="{{ asset('assets/img/favicon.png') }}" sizes="192x192" />
        <link rel="apple-touch-icon" href="{{ asset('assets/img/favicon.png') }}" />
        <meta name="msapplication-TileImage" content="{{ asset('assets/img/favicon.png') }}" />

        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@400;700&family=Rubik:wght@400;500;700&display=swap" rel="stylesheet">

        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" media="print" onload="this.media='all'" />
        <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}?v={{ date('Ymd') }}">

        <style>

        </style>

        @yield('styles')
    </head>

    <body>
        <main>

            @include('partials.site.header')

            @yield('content')

            @include('partials.site.footer')

        </main>

        <div class="back-top"><i class="bi bi-arrow-up-short"></i></div>

        <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('assets/js/tiny-slider.js') }}"></script>
        <script src="{{ asset('assets/js/main.js') }}"></script>

        <script>

        </script>

        @yield('scripts')

        @include('partials.cookie-consent')

        <div id="fb-root"></div>
        <script async defer crossorigin="anonymous" src="https://connect.facebook.net/pt_BR/sdk.js#xfbml=1&version=v22.0"></script>
    </body>
</html>
