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

        <title>@yield('title', config('app.name'))</title>
        <meta name="description" content="@yield('description', config('site.site_description'))">
        <link rel="canonical" href="{{ url()->current() }}" />

        <link rel="icon" href="{{ asset('assets/img/favicon.png') }}" sizes="32x32" />
        <link rel="icon" href="{{ asset('assets/img/favicon.png') }}" sizes="192x192" />
        <link rel="apple-touch-icon" href="{{ asset('assets/img/favicon.png') }}" />
        <meta name="msapplication-TileImage" content="{{ asset('assets/img/favicon.png') }}" />

        <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" media="print" onload="this.media='all'" rel="stylesheet">
        <style>
            :root {
                --primary-green: #317caf;
                --light-gray: #f8f9fa;
                --medium-gray: #6c757d;
                --dark-gray: #495057;
            }

            body {
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                background-color: var(--light-gray);
            }

            .navbar-brand {
                font-weight: bold;
                font-size: 1.5rem;
            }

            .brand-green {
                color: var(--primary-green);
            }

            .hero-section {
                min-height: 100vh;
                display: flex;
                align-items: center;
                background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            }

            .lawyer-card {
                background: white;
                border-radius: 20px;
                padding: 2rem;
                box-shadow: 0 10px 30px rgba(0,0,0,0.1);
                margin: 0 auto;
                text-align: center;
                position: relative;
            }

            .lawyer-avatar {
                width: 80px;
                height: 80px;
                border-radius: 50%;
                object-fit: contain;
                border: 4px solid white;
                box-shadow: 0 5px 15px rgba(0,0,0,0.2);
                margin: -60px auto 5px;
            }

            .lawyer-message {
                background: #f8f9fa;
                border-radius: 15px;
                padding: 1.5rem;
                margin: 1.5rem 0;
                position: relative;
                border-left: 4px solid var(--primary-green);
            }

            .lawyer-message::before {
                content: '';
                position: absolute;
                left: -10px;
                top: 20px;
                width: 0;
                height: 0;
                border-top: 10px solid transparent;
                border-bottom: 10px solid transparent;
                border-right: 10px solid #f8f9fa;
            }

            .message-input {
                border-radius: 25px;
                border: 2px solid #e9ecef;
                padding: 40px 20px;
                font-size: 1rem;
                transition: all 0.3s ease;
            }

            .message-input:focus {
                border-color: var(--primary-green);
                box-shadow: 0 0 0 0.2rem rgba(76, 175, 80, 0.25);
            }

            .send-btn {
                background-color: var(--medium-gray);
                border: none;
                border-radius: 50%;
                width: 50px;
                height: auto;
                display: flex;
                align-items: center;
                justify-content: center;
                transition: all 0.3s ease;
            }

            .send-btn:hover {
                background-color: var(--primary-green);
                transform: scale(1.05);
            }

            .feature-item {
                display: flex;
                align-items: center;
                gap: 15px;
                padding: 1rem;
                background: white;
                border-radius: 15px;
                box-shadow: 0 2px 10px rgba(0,0,0,0.05);
                transition: transform 0.3s ease;
            }

            .feature-item:hover {
                transform: translateY(-2px);
            }

            .feature-icon {
                width: 50px;
                height: 50px;
                background: var(--light-gray);
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                color: var(--primary-green);
            }

            .fade-in {
                animation: fadeIn 1s ease-in-out;
            }

            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(20px); }
                to { opacity: 1; transform: translateY(0); }
            }

            .pulse {
                animation: pulse 2s infinite;
            }

            @keyframes pulse {
                0% { transform: scale(1); }
                50% { transform: scale(1.02); }
                100% { transform: scale(1); }
            }
        </style>

        @yield('styles')
    </head>

    <body>
        <main>

            <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top">
                <div class="container d-flex justify-content-center">
                    <a class="navbar-brand" href="{{ route('site.home.index') }}" title="Voltar para a página inicial">
                        <img src="{{ asset('assets/img/logo.png') }}"
                             alt="{{ config('app.name') }}"
                             class="d-inline-block align-text-top"
                             style="height: 60px;"
                        />
                    </a>
                </div>
            </nav>

            @yield('content')

        </main>

        @yield('scripts')

    </body>
</html>
