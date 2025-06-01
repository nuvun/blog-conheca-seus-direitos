<!doctype html>
<html>
    <head>
        @include('partials.dns-prefech-and-preconnect')
        @include('partials.google-analytics')
        @include('partials.pwa')
        @include('partials.oneSignal')
        @include('partials.site.shareFacebook')
        @include('partials.site.structuredData')
        @include('partials.site.tagAmp')

        <meta charset="utf-8">
        <title>{{ $post->title }}</title>
        <meta name="description" content="{{ $post->description }}">
        <link rel="canonical" href="{{ url()->current() }}" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes, minimum-scale=1.0,maximum-scale=10.0">
        <meta name="format-detection" content="telephone=no">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400;0,600;0,700;1,400;1,600;1,700&display=swap" rel="stylesheet">
        <link href='//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css' rel='stylesheet' media="print" onload="this.media='all'">
        <style>
            body, .special-cover:not(.tab-tpl) .hs-title, .special-cover .hs-subtitle, section p {
                font-family: 'Lora', sans-serif !important;
            }
            .header .brand {
                height: 80px !important;
            }
            .special-quote.escuro {
                background: black !important;
            }
            .special-quote.escuro .author-info p strong {
                color: white !important;
            }
            .special-cover .mask-opacity {
                background: -webkit-gradient(linear,left top,left bottom,from(transparent),to(#000000),color-stop(.3,rgba(31,26,66,0))) !important;
            }
            .special-video.padrao .video-box .wrap-icon {
                border: 8px solid black !important;
            }
            .special-quote .quotation {
                margin-left: 30px !important;
            }

            .special-cover .wrap-video {
                top: 60% !important;
            }

            .special-quote .wrap-content {
                padding-top: 0px !important;
                border: none;
                padding-bottom: 0;
                margin-bottom: 0;
            }

            .thematic {
                padding: 0px 0 !important;
            }

            header {
                position: absolute;
                top: 32px;
                left: 15px;
            }

            .menu-anchor {
                width: 35px;
                height: 50px;
                display: inline-block;
                vertical-align: middle;
                position: relative;
                text-indent: -9999px;
                overflow: hidden;
                cursor: pointer;
                color:
                    /*background: #FFF;*/
            }

            .menu-anchor:before {
                content: "";
                display: block;
                margin: 7px auto;
                width: 100%;
                height: 0.3em;
                background: black;
                box-shadow: 0 0.7em 0 0 black, 0 1.4em 0 0 black;
            }

            .menu-active .menu-anchor {
                /*margin-left: -25px; */
                display: none;
            }

            .menu-active .menu-anchor:before {
                background: white;
                box-shadow: 0 0.7em 0 0 white, 0 1.4em 0 0 white;
            }

            menu {
                position: fixed;
                top: 0;
                left: 0;
                z-index: 99;
                width: 220px;
                height: auto;
                background: black;
                box-shadow: inset -5px -10px 10px 0 rgba(0,0,0,.3)
            }

            menu li a {
                display: block;
                border-bottom: 1px solid rgba(255,255,255,.3);
                margin: 0 9px;
                padding: 0px 6px 7px 6px;
                color: #FFF;
                text-decoration: none;
                font-size: 1.15em;
                font-weight: bold;
            }

            menu li a:hover {
                /*background: #FFF;*/
                color: #fff;
            }


            /*
                Aqui você esconde o menu para fora da tela
                O valor é exatamente a largura da sidebar
            */
            menu {
                -webkit-transform: translateX(-220px);
                -moz-transform: translateX(-220px);
                -ms-transform: translateX(-220px);
                transform: translateX(-220px);
                -webkit-transition: all .25s linear;
                -moz-transition: all .25s linear;
                -ms-transition: all .25s linear;
                transition: all .25s linear;
            }

            /*
                Essa é a posição original do HEADER e do MAIN
            */
            header, .main {
                -webkit-transform: translateX(0);
                -moz-transform: translateX(0);
                -ms-transform: translateX(0);
                transform: translateX(0);
                -webkit-transition: all .25s linear;
                -moz-transition: all .25s linear;
                -ms-transition: all .25s linear;
                transition: all .25s linear;
            }

            /*
               Com a classe menu-active na tag HTML
            */
            .menu-active menu {
                -webkit-transform: translateX(0);
                -moz-transform: translateX(0);
                -ms-transform: translateX(0);
                transform: translateX(0);
                transition: .5s all;
            }

            .menu-active menu {
                width: 240px;
                left: -80px;
            }

            .menu-active menu ul li {
                padding-bottom: 10px;
            }

            .menu-active header,
            .menu-active .main {
                -webkit-transform: translateX(220px);
                -moz-transform: translateX(220px);
                -ms-transform: translateX(220px);
                transform: translateX(220px);
            }

            blockquote {
                font-size: 18px;
                border-left: 5px solid #cccccc;
                margin-right: 0;
                margin-bottom: 30px;
                margin-left: 0;
                padding-top: 10px;
                padding-right: 20px;
                padding-bottom: 10px;
                padding-left: 20px;
                font-style: italic;
            }

            blockquote p:last-child, blockquote ul:last-child, blockquote ol:last-child {
                margin-bottom: 0;
            }

            @media (min-width: 992px) {
                .special-cover .wrap-tit {
                    margin-bottom: 0px !important;
                }
            }

            @media (min-width: 768px) {
                section p {
                    line-height: 1.4 !important;
                    text-align: justify;
                }
            }

            @media (min-width: 1230px) {
                section p {
                    padding-bottom: 15px !important;
                }

                .special-cover .hs-title {
                    font-size: 34px !important;
                    font-weight: bold !important;
                }

                .special-cover .hs-subtitle {
                    font-size: 28px !important;
                    font-weight: 500 !important;
                }

                .special-quote {
                    padding: 30px 0 !important;
                }

                .special-quote.frases-1 .wrap-content .quotation p {
                    font-weight: 600;
                    font-size: 36px !important;
                }

                .thematic.um-texto .hs-title {
                    font-size: 32px !important;
                }

                .special-quote .wrap-content .wrap-icon {
                    border-top: none !important;
                }
            }

            @media only screen and (max-width: 450px) {
                .special-cover .hs-title {
                    font-size: 26px !important;
                    font-weight: 600 !important;
                }

                .thematic p {
                    text-align: justify !important;
                    line-height: 1.5 !important;
                }

                .special-quote {
                    padding: 25px 0px !important;
                }

                .special-cover .wrap-video {
                    top: 35% !important;
                    min-height: 40% !important;
                }

                .special-cover {
                    height: calc(92vh - 50px) !important;
                }
            }
        </style>
        <link href="/assets/css/entrevistas/estilo1.css" rel="stylesheet">
        <link href="/assets/css/entrevistas/estilo2.css" rel="stylesheet">
        <link href="/assets/css/entrevistas/estilo3.css" rel="stylesheet">
        <link href="/assets/css/entrevistas/estilo4.css" rel="stylesheet">
        <link href="/assets/css/entrevistas/estilo5.css" rel="stylesheet">
        <link href="/assets/css/entrevistas/estilo6.css" rel="stylesheet">
        <link href="/assets/css/entrevistas/estilo7.css" rel="stylesheet">
    </head>

    <body class="">
        <header> MENU mobile <span class="menu-anchor"></span> </header>

        <menu>
            <ul>
                <li class='menu-item menu-item-type-post_type menu-item-object-page'><a style="padding: 12px 6px 7px 6px;" title='POLÍTICA' href='/noticias/politica'>Política</a></li>
                <li class='menu-item menu-item-type-post_type menu-item-object-page'><a title='PASSANDO A RÉGUA' href='/colunas/passando-a-regua'>Passando a Régua</a></li>
                <li class='menu-item menu-item-type-post_type menu-item-object-page'><a title='COLUNISTAS' href='/noticias/colunas'>Colunistas</a></li>
                <li class='menu-item menu-item-type-post_type menu-item-object-page'><a title='MUNICÍPIOS' href='/noticias/municipios'>Municípios</a></li>
                <li class='menu-item menu-item-type-post_type menu-item-object-page'><a title='TV PIAUÍ' href='/videos'>TV Piauí</a></li>
                <li class='menu-item menu-item-type-post_type menu-item-object-page'><a title='NOTÍCIAS POLÍCIA' href='/noticias/noticias'>Polícia</a></li>
                <li class='menu-item menu-item-type-post_type menu-item-object-page'><a title='ARTIGOS' href='/noticias/artigos'>Articulistas</a></li>
                <li class='menu-item menu-item-type-post_type menu-item-object-page'><a title='NOTÍCIAS ENTRETENIMENTO' href='/noticias/entretenimento'>Entretê</a></li>
                <li class='menu-item menu-item-type-post_type menu-item-object-page'><a title='NOTÍCIAS ESPORTES' href='/noticias/esporte'>Esportes</a></li>
                <li class='menu-item menu-item-type-post_type menu-item-object-page'><a title='NOTÍCIAS CURIOSIDADES' href='/noticias/curiosidades'>Curiosidades</a></li>
                <li class='menu-item menu-item-type-post_type menu-item-object-page'><a title='REPORTAGENS ESPECIAIS' href='/noticias/reportagens-especiais'>Especiais</a></li>
                <li class='menu-item menu-item-type-post_type menu-item-object-page'><a title='NOTÍCIAS GERAL' href='/noticias/geral'>Geral</a></li>

                <li class='menu-item menu-item-type-post_type menu-item-object-page fechar'>
                    <a style="border: 1px solid; text-align: center; border-radius: 3px; margin-top: 5px; font-weight: bold;padding-top: 7px;" title='FECHAR' href='javascript:void(0)'>FECHAR</a>
                </li>
            </ul>
        </menu>

        <div class="header header-thin">
            <div class="wrapper-header invert specials">
                <div class="container">
                    <div class="brand" style="text-align: center;">
                        <a title="{{ config('app.name') }}" href="{{ route('site.home.index') }}">
                            <img src="{{ asset('assets/img/logo.png') }}" alt="{{ config('app.name') }}" style="width: 200px; margin-top: 3px;" />
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <section class="special-cover cover-video valign calign container-fluid dft-tpl">
            <div class="mask-opacity"></div>
            <div id="fixed-holder" class="valign">
                <div class="wrap-content">
                    <div class="wrap-tit">
                        <div class="container">
                            <div class="row">
                                <div class="col-xs-12 col-sm-24">
                                    <h1 class="hs-title fade-in">
                                        {{ $post->title }}
                                    </h1>
                                    <h2 class="hs-subtitle">
                                        {{ $post->subtitle }}
                                    </h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="wrap-icon bounce">
                    <i class="fa fa-3x fa-angle-double-down"></i>
                </div>
            </div>

            <img src="{{ $post->getMedia('imageTopInterview')->last()->getUrl() }}" class="wrap-video" loading="lazy" alt="{{ $post->title }}">

        </section>

        <section data-name="tematico-1" data-metrics-special="tematico-1|special-thematic" class="special-thematic thematic universa um-texto caption-off claro um-texto" style="padding-top: 15px;">
            <div class="container">
                <div class="row">
                    <div class=" col-md-offset-3 col-md-18 col-lg-offset-4 col-lg-16 col-sm-offset-2 col-sm-20 col-xs-12">
                        <div class="wrap-content">
                            <div class="wrap-inner">
                                <div class="wrap-txt">
                                    <p style="font-weight: 600; margin-top: 15px;">
                                        <em>Reportagem de {{ $post->getValueSchemalessAttributes('editor') }}</em>
                                    </p>

                                    {!! $post->attributes->text1 !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section data-name="frases-1" data-metrics-special="frases-1|special-quote" class="special-quote universa isQuoteWeb escuro frases-1 dft-tpl caption-off ">
            <div class="container">
                <div class="row">
                    <blockquote class="wrap-content col-xs-12 col-sm-offset-1 col-sm-22 col-md-18 col-md-offset-3">
                        <div class="quotation">
                            <p style="margin-bottom: -15px;">
                                <i class="fa fa-quote-left"></i>
                                {!! $post->attributes->quote1 !!}
                                <i class="fa fa-quote-right"></i>
                                .
                            </p>
                        </div>
                    </blockquote>
                </div>
            </div>
        </section>

        <section data-name="Separação midiática" data-metrics-special="Separação midiática|special-thematic" class="special-thematic thematic universa um-texto caption-on claro um-texto" style="padding-top: 15px !important;">
            <div class="container">
                <div class="row">
                    <div class=" col-md-offset-3 col-md-18 col-lg-offset-4 col-lg-16 col-sm-offset-2 col-sm-20 col-xs-12">
                        <div class="wrap-content">
                            <div class="wrap-inner">
                                {!! $post->attributes->text2 !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section data-name="frases-1" data-metrics-special="frases-1|special-quote" class="special-quote universa isQuoteWeb escuro frases-1 dft-tpl caption-off ">
            <div class="container">
                <div class="row">
                    <blockquote class="wrap-content col-xs-12 col-sm-offset-1 col-sm-22 col-md-18 col-md-offset-3">
                        <div class="quotation">
                            <p style="margin-bottom: -10px;">
                                <i class="fa fa-quote-left"></i>
                                {!! $post->attributes->quote2 !!}
                                <i class="fa fa-quote-right"></i>
                                .
                            </p>
                        </div>
                    </blockquote>
                </div>
            </div>
        </section>

        <section data-name="imagem-3" data-metrics-special="imagem-3|special-image" class="special-image text-center caption-off infografico isImageWeb dft-tpl">
            <div class="container-full">
                <div class="rel">
                    <img class="hidden-xs" src="{{ $post->getMedia('image2Interview')->last()->getUrl() }}" alt="" data-crop='{"xs":"300x1","sm":"1024x768","md":"1920x1080","lg":"1920x1"}'/>
                    <img class="visible-xs" src="{{ $post->getMedia('image2Interview')->last()->getUrl() }}" alt="" data-crop='{"xs":"300x1","sm":"1024x768","md":"1920x1080","lg":"1920x1"}'/>
                </div>
            </div>
        </section>

        <section data-name="Vida portuguesa" data-metrics-special="Vida portuguesa|special-thematic" class="special-thematic thematic universa um-texto caption-on claro um-texto" style="padding-top: 15px !important;">
            <div class="container">
                <div class="row">
                    <div class=" col-md-offset-3 col-md-18 col-lg-offset-4 col-lg-16 col-sm-offset-2 col-sm-20 col-xs-12">
                        <div class="wrap-content">
                            <div class="wrap-inner">
                                {!! $post->attributes->text3 !!}

                                <p></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section data-name="Vida portuguesa" data-metrics-special="Vida portuguesa|special-thematic" class="special-thematic thematic universa um-texto caption-on claro um-texto" style="padding-top: 15px !important;">
            <div class="container">
                <div class="row">
                    <div class=" col-md-offset-3 col-md-18 col-lg-offset-4 col-lg-16 col-sm-offset-2 col-sm-20 col-xs-12">
                        <div class="wrap-content">
                            <div class="wrap-inner">
                                <div class='fb-comments' data-width='100%' data-href="https://fb.arquivo1.com.br{{ request()->getPathInfo() }}" data-numposts='50'></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="special-quote universa isQuoteWeb escuro frases-1 dft-tpl caption-off" style="padding: 50px 0">
            <div class="container">
                <div class="row">
                    <center>
                        © <?= date('Y'); ?> . {{ config('app.name') }} - Jornalismo é contar histórias. Todos os direitos reservados. Este material não pode ser publicado, transmitido por broadcast, reeescrito ou redistribuido sem autorização.
                    </center>
                </div>
            </div>
        </section>

        <div id="fb-root"></div>
        <script async defer crossorigin="anonymous" src="https://connect.facebook.net/pt_BR/sdk.js#xfbml=1&version=v20.0&autoLogAppEvents=1" nonce="hP5bBOGw"></script>

        <script type="text/javascript" src="https://platform-api.sharethis.com/js/sharethis.js#property=664f832f3a56e900196c14e5&product=inline-share-buttons&source=platform" async="async"></script>

        <script async src="https://cdn.embedly.com/widgets/platform.js" charset="UTF-8"></script>
    </body>
</html>
