@extends('layouts.site')

@section('title', $post->title)
@section('description', $post->subtitle)

@section('content')
    <div class="blog-section">
        <div class="container">

            @if($post->isFromBlog)
                <div class="post-author mt-2 d-flex align-items-center" style="background: #b9bbc0b3; border-radius: 3px; margin-bottom: -17px;">
                    <div class="post-author-img h-auto w-auto transtion_zoom" style="border-right: 1px solid white; margin-right: 10px; padding-right: 5px;">
                        <a href="{{ $post->category->url }}" title="{{ $post->category->name }}">
                            <img src="{{ $post->category->photo->url }}"
                                 alt="{{ $post->category->name }}"
                                 style="width: 120px; height: 120px; border-radius: 50%;object-fit: contain;"
                                 loading="lazy"
                            />
                        </a>
                    </div>
                    <div class="post-author-info">
                        <h4 class="mb-0">
                            <a href="{{ $post->category->url }}" title="{{ $post->category->name }}" class="text-dark fw-bold">
                                {{ $post->category->name }}
                            </a>
                        </h4>
                    </div>
                </div>
            @endif

            <div class="row gx-5">
                <div class="col-xxl-8 col-xl-8 col-lg-12 mt-4">
                    <article class="bg-white">
                        <span class="badge bg-brand text-uppercase">
                            {{ $post->category->name }}
                        </span>

                        <h1 class="post-title mb-10">
                            {{ $post->title }}
                        </h1>

                        <p class="text-muted post-subtitle">
                            {{ $post->subtitle }}
                        </p>

                        <ul class="d-flex align-items-center gap-4 list-style mb-3 post-infos">
                            <li>
                                <i class="fa-regular fa-calendar"></i>
                                {{ $post->published_at->isoFormat('dddd, D [de] MMMM [de] YYYY') }}
                            </li>

                            <li>
                                <i class="fa-solid fa-circle-user"></i>
                                @if(filled($post->attributes->editor))
                                    {{ $post->attributes->editor }}
                                @else
                                    @forelse($post->users as $author)
                                        {{ $author->name }}

                                        @if(!$loop->last)
                                        ,
                                        @endif
                                    @empty
                                    @endforelse
                                @endif
                            </li>
                        </ul>

                        <div class="sharethis-inline-share-buttons"></div>

                        <hr>

                        <div class="post-para contentPost">
                           {!! $post->content !!}

                            @if($post->attributes->showNoticeTextBlogger == 'yes')
                                <div class="post-author small fst-italic p-2">
                                    Este artigo não reflete, necessariamente, a opinião do {{ config('app.name') }}
                                </div>
                            @endif

                            <div class="p1 mb-3">
                                <div class="clearfix" style="display: flex; align-items: center;">
                                    <div>
                                        <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="48" height="48" viewBox="0 0 48 48">
                                            <path fill="#fff" d="M4.868,43.303l2.694-9.835C5.9,30.59,5.026,27.324,5.027,23.979C5.032,13.514,13.548,5,24.014,5c5.079,0.002,9.845,1.979,13.43,5.566c3.584,3.588,5.558,8.356,5.556,13.428c-0.004,10.465-8.522,18.98-18.986,18.98c-0.001,0,0,0,0,0h-0.008c-3.177-0.001-6.3-0.798-9.073-2.311L4.868,43.303z"></path><path fill="#fff" d="M4.868,43.803c-0.132,0-0.26-0.052-0.355-0.148c-0.125-0.127-0.174-0.312-0.127-0.483l2.639-9.636c-1.636-2.906-2.499-6.206-2.497-9.556C4.532,13.238,13.273,4.5,24.014,4.5c5.21,0.002,10.105,2.031,13.784,5.713c3.679,3.683,5.704,8.577,5.702,13.781c-0.004,10.741-8.746,19.48-19.486,19.48c-3.189-0.001-6.344-0.788-9.144-2.277l-9.875,2.589C4.953,43.798,4.911,43.803,4.868,43.803z"></path><path fill="#cfd8dc" d="M24.014,5c5.079,0.002,9.845,1.979,13.43,5.566c3.584,3.588,5.558,8.356,5.556,13.428c-0.004,10.465-8.522,18.98-18.986,18.98h-0.008c-3.177-0.001-6.3-0.798-9.073-2.311L4.868,43.303l2.694-9.835C5.9,30.59,5.026,27.324,5.027,23.979C5.032,13.514,13.548,5,24.014,5 M24.014,42.974C24.014,42.974,24.014,42.974,24.014,42.974C24.014,42.974,24.014,42.974,24.014,42.974 M24.014,42.974C24.014,42.974,24.014,42.974,24.014,42.974C24.014,42.974,24.014,42.974,24.014,42.974 M24.014,4C24.014,4,24.014,4,24.014,4C12.998,4,4.032,12.962,4.027,23.979c-0.001,3.367,0.849,6.685,2.461,9.622l-2.585,9.439c-0.094,0.345,0.002,0.713,0.254,0.967c0.19,0.192,0.447,0.297,0.711,0.297c0.085,0,0.17-0.011,0.254-0.033l9.687-2.54c2.828,1.468,5.998,2.243,9.197,2.244c11.024,0,19.99-8.963,19.995-19.98c0.002-5.339-2.075-10.359-5.848-14.135C34.378,6.083,29.357,4.002,24.014,4L24.014,4z"></path><path fill="#40c351" d="M35.176,12.832c-2.98-2.982-6.941-4.625-11.157-4.626c-8.704,0-15.783,7.076-15.787,15.774c-0.001,2.981,0.833,5.883,2.413,8.396l0.376,0.597l-1.595,5.821l5.973-1.566l0.577,0.342c2.422,1.438,5.2,2.198,8.032,2.199h0.006c8.698,0,15.777-7.077,15.78-15.776C39.795,19.778,38.156,15.814,35.176,12.832z"></path><path fill="#fff" fill-rule="evenodd" d="M19.268,16.045c-0.355-0.79-0.729-0.806-1.068-0.82c-0.277-0.012-0.593-0.011-0.909-0.011c-0.316,0-0.83,0.119-1.265,0.594c-0.435,0.475-1.661,1.622-1.661,3.956c0,2.334,1.7,4.59,1.937,4.906c0.237,0.316,3.282,5.259,8.104,7.161c4.007,1.58,4.823,1.266,5.693,1.187c0.87-0.079,2.807-1.147,3.202-2.255c0.395-1.108,0.395-2.057,0.277-2.255c-0.119-0.198-0.435-0.316-0.909-0.554s-2.807-1.385-3.242-1.543c-0.435-0.158-0.751-0.237-1.068,0.238c-0.316,0.474-1.225,1.543-1.502,1.859c-0.277,0.317-0.554,0.357-1.028,0.119c-0.474-0.238-2.002-0.738-3.815-2.354c-1.41-1.257-2.362-2.81-2.639-3.285c-0.277-0.474-0.03-0.731,0.208-0.968c0.213-0.213,0.474-0.554,0.712-0.831c0.237-0.277,0.316-0.475,0.474-0.791c0.158-0.317,0.079-0.594-0.04-0.831C20.612,19.329,19.69,16.983,19.268,16.045z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <a href="{{ $settings['site.grupo_whatsapp'] ?? '' }}" title="Receba direto no seu WhatsApp as principais notícias do {{ config('app.name') }}" target="_blank" style="color: #008000;text-decoration: none; font-weight: normal;">
                                            • Clique aqui e receba nossas notícias
                                        </a>
                                    </div>
                                </div>

                                <div class="clearfix" style="display: flex; align-items: center;">
                                    <div>
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="48" height="48" fill="rgba(36,161,222,1)">
                                            <path fill="none" d="M0 0h24v24H0z"></path><path d="M22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12ZM12.3584 9.38246C11.3857 9.78702 9.4418 10.6244 6.5266 11.8945C6.05321 12.0827 5.80524 12.2669 5.78266 12.4469C5.74451 12.7513 6.12561 12.8711 6.64458 13.0343C6.71517 13.0565 6.78832 13.0795 6.8633 13.1039C7.37388 13.2698 8.06071 13.464 8.41776 13.4717C8.74164 13.4787 9.10313 13.3452 9.50222 13.0711C12.226 11.2325 13.632 10.3032 13.7203 10.2832C13.7826 10.269 13.8689 10.2513 13.9273 10.3032C13.9858 10.3552 13.98 10.4536 13.9739 10.48C13.9361 10.641 12.4401 12.0318 11.666 12.7515C11.4351 12.9661 11.2101 13.1853 10.9833 13.4039C10.509 13.8611 10.1533 14.204 11.003 14.764C11.8644 15.3317 12.7323 15.8982 13.5724 16.4971C13.9867 16.7925 14.359 17.0579 14.8188 17.0156C15.0861 16.991 15.3621 16.7397 15.5022 15.9903C15.8335 14.2193 16.4847 10.3821 16.6352 8.80083C16.6484 8.6623 16.6318 8.485 16.6185 8.40717C16.6052 8.32934 16.5773 8.21844 16.4762 8.13635C16.3563 8.03913 16.1714 8.01863 16.0887 8.02009C15.7125 8.02672 15.1355 8.22737 12.3584 9.38246Z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <a href="{{ $settings['site.link_telegram'] ?? '' }}" title="Receba direto no seu Telegram as principais notícias do {{ config('app.name') }}" target="_blank" style="color: #21a1de;text-decoration: none; font-weight: normal;">
                                            • Clique aqui e receba nossas notícias
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </article>

                    <div class="post-meta-option mb-5">
                        <div class="row">
                            <div class="col-6">
                                <h5 class="fw-bold text-dark mb-0 title-follow-social-networks" style="color: #008000; font-weight: normal; font-size: 16px;">
                                    Siga nossas redes sociais
                                </h5>
                                <div class="mt-lg-2" style="display: flex; gap: 5px;">
                                    <a href="{{ $settings['site.link_facebook'] ?? '' }}" title="Facebook" target="_blank">
                                        <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="40" height="40" viewBox="0 0 48 48">
                                            <path fill="#039be5" d="M24 5A19 19 0 1 0 24 43A19 19 0 1 0 24 5Z"></path><path fill="#fff" d="M26.572,29.036h4.917l0.772-4.995h-5.69v-2.73c0-2.075,0.678-3.915,2.619-3.915h3.119v-4.359c-0.548-0.074-1.707-0.236-3.897-0.236c-4.573,0-7.254,2.415-7.254,7.917v3.323h-4.701v4.995h4.701v13.729C22.089,42.905,23.032,43,24,43c0.875,0,1.729-0.08,2.572-0.194V29.036z"></path>
                                        </svg>
                                    </a>

                                    <a href="{{ $settings['site.link_instagram'] ?? '' }}" title="Instagram" target="_blank">
                                        <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="40" height="40" viewBox="0 0 48 48">
                                            <radialGradient id="yOrnnhliCrdS2gy~4tD8ma_Xy10Jcu1L2Su_gr1" cx="19.38" cy="42.035" r="44.899" gradientUnits="userSpaceOnUse"><stop offset="0" stop-color="#fd5"></stop><stop offset=".328" stop-color="#ff543f"></stop><stop offset=".348" stop-color="#fc5245"></stop><stop offset=".504" stop-color="#e64771"></stop><stop offset=".643" stop-color="#d53e91"></stop><stop offset=".761" stop-color="#cc39a4"></stop><stop offset=".841" stop-color="#c837ab"></stop></radialGradient><path fill="url(#yOrnnhliCrdS2gy~4tD8ma_Xy10Jcu1L2Su_gr1)" d="M34.017,41.99l-20,0.019c-4.4,0.004-8.003-3.592-8.008-7.992l-0.019-20	c-0.004-4.4,3.592-8.003,7.992-8.008l20-0.019c4.4-0.004,8.003,3.592,8.008,7.992l0.019,20	C42.014,38.383,38.417,41.986,34.017,41.99z"></path><radialGradient id="yOrnnhliCrdS2gy~4tD8mb_Xy10Jcu1L2Su_gr2" cx="11.786" cy="5.54" r="29.813" gradientTransform="matrix(1 0 0 .6663 0 1.849)" gradientUnits="userSpaceOnUse"><stop offset="0" stop-color="#4168c9"></stop><stop offset=".999" stop-color="#4168c9" stop-opacity="0"></stop></radialGradient><path fill="url(#yOrnnhliCrdS2gy~4tD8mb_Xy10Jcu1L2Su_gr2)" d="M34.017,41.99l-20,0.019c-4.4,0.004-8.003-3.592-8.008-7.992l-0.019-20	c-0.004-4.4,3.592-8.003,7.992-8.008l20-0.019c4.4-0.004,8.003,3.592,8.008,7.992l0.019,20	C42.014,38.383,38.417,41.986,34.017,41.99z"></path><path fill="#fff" d="M24,31c-3.859,0-7-3.14-7-7s3.141-7,7-7s7,3.14,7,7S27.859,31,24,31z M24,19c-2.757,0-5,2.243-5,5	s2.243,5,5,5s5-2.243,5-5S26.757,19,24,19z"></path><circle cx="31.5" cy="16.5" r="1.5" fill="#fff"></circle><path fill="#fff" d="M30,37H18c-3.859,0-7-3.14-7-7V18c0-3.86,3.141-7,7-7h12c3.859,0,7,3.14,7,7v12	C37,33.86,33.859,37,30,37z M18,13c-2.757,0-5,2.243-5,5v12c0,2.757,2.243,5,5,5h12c2.757,0,5-2.243,5-5V18c0-2.757-2.243-5-5-5H18z"></path>
                                        </svg>
                                    </a>

                                    <a href="{{ $settings['site.link_youtube'] ?? '' }}" title="Youtube" target="_blank">
                                        <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="40" height="40" viewBox="0 0 48 48">
                                            <path fill="#FF3D00" d="M43.2,33.9c-0.4,2.1-2.1,3.7-4.2,4c-3.3,0.5-8.8,1.1-15,1.1c-6.1,0-11.6-0.6-15-1.1c-2.1-0.3-3.8-1.9-4.2-4C4.4,31.6,4,28.2,4,24c0-4.2,0.4-7.6,0.8-9.9c0.4-2.1,2.1-3.7,4.2-4C12.3,9.6,17.8,9,24,9c6.2,0,11.6,0.6,15,1.1c2.1,0.3,3.8,1.9,4.2,4c0.4,2.3,0.9,5.7,0.9,9.9C44,28.2,43.6,31.6,43.2,33.9z"></path><path fill="#FFF" d="M20 31L20 17 32 24z"></path>
                                        </svg>
                                    </a>

                                    <a href="{{ $settings['site.link_tiktok'] ?? '' }}" title="Tiktok" target="_blank">
                                        <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="40" height="40" viewBox="0 0 50 50">
                                            <path d="M41,4H9C6.243,4,4,6.243,4,9v32c0,2.757,2.243,5,5,5h32c2.757,0,5-2.243,5-5V9C46,6.243,43.757,4,41,4z M37.006,22.323 c-0.227,0.021-0.457,0.035-0.69,0.035c-2.623,0-4.928-1.349-6.269-3.388c0,5.349,0,11.435,0,11.537c0,4.709-3.818,8.527-8.527,8.527 s-8.527-3.818-8.527-8.527s3.818-8.527,8.527-8.527c0.178,0,0.352,0.016,0.527,0.027v4.202c-0.175-0.021-0.347-0.053-0.527-0.053 c-2.404,0-4.352,1.948-4.352,4.352s1.948,4.352,4.352,4.352s4.527-1.894,4.527-4.298c0-0.095,0.042-19.594,0.042-19.594h4.016 c0.378,3.591,3.277,6.425,6.901,6.685V22.323z"></path>
                                        </svg>
                                    </a>
                                </div>
                            </div>

                            <div class="col-6 ms-auto text-md-end text-start">
                                <h5 class="fw-bold text-dark mb-0 title-follow-social-networks text-end" style="color: #008000; font-weight: normal; font-size: 16px;">
                                    Compartilhe
                                </h5>
                                <div class="mt-lg-2 social__link" style="display: flex; gap: 18px; float: right;">
                                    <a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}" class="facebook" title="Compartilhar no facebook">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>

                                    <a target="_blank" href="https://api.whatsapp.com/send?text={{ $post->title }} - {{ url()->current() }}" class="whatsapp" title="Compartilhar no WhatsApp">
                                        <i class="fab fa-whatsapp"></i>
                                    </a>

                                    <a target="_blank" href="{{ $settings['site.link_instagram'] ?? '' }}" class="instagram" title="Compartilhar no Instagram">
                                        <i class="fab fa-instagram"></i>
                                    </a>

                                    <a target="_blank" href="https://twitter.com/intent/tweet?text={{ $post->title }} - {{ url()->current() }}" class="twitter" title="Compartilhar no twitter">
                                        <i class="fab fa-x-twitter"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-3">
                        <div class="comment-box-wrap post-comment">
                            <h4 class="comment-box-title">Deixe sua opinião:</h4>
                        </div>

                        <div class='fb-comments' data-width='100%'
                             data-href="https://fb.arquivo1.com.br{{ request()->getPathInfo() }}"
                             data-numposts='50'
                        >
                        </div>
                    </div>
                </div>

                <div class="col-xxl-4 col-xl-4 col-lg-12">
                    @include('partials.site.sidebar')
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        window.onload = (event) => {
            $('.contentPost p a').each(function() {
                let href = $(this).attr("href");
                let replacement;

                switch (true) {
                    case href.includes(".ogg"):
                    case href.includes(".mp3"):
                        replacement = `<audio style="width: 100%;" controls><source src="${href}" type="audio/ogg"><source src="${href}" type="audio/mpeg"></audio>`;
                        break;
                    case href.includes(".pdf"):
                        replacement = `<iframe src="https://drive.google.com/viewerng/viewer?url=${href}?pid=explorer&efh=false&a=v&chrome=false&embedded=true" frameborder="1" scrolling="auto" height="600" width="100%"></iframe>`;
                        break;
                }

                if (replacement) {
                    $(this).replaceWith(replacement);
                }
            });
        };
    </script>

    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/pt_BR/sdk.js#xfbml=1&version=v20.0&autoLogAppEvents=1" nonce="hP5bBOGw"></script>

    <script type="text/javascript" src="https://platform-api.sharethis.com/js/sharethis.js#property=664f832f3a56e900196c14e5&product=inline-share-buttons&source=platform" async="async"></script>

    <script async src="https://cdn.embedly.com/widgets/platform.js" charset="UTF-8"></script>
@endsection
