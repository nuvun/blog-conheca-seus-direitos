@extends('layouts.site')

@section('title', $title)
@section('description', $video->description)

@section('content')
    <div class="blog-section">
        <div class="container">
            <div class="row gx-5 justify-content-center">
                <div class="col-xxl-10 col-xl-10 col-lg-12 pb-50">
                    <article class="bg-white">
                        <h1 class="post-title mb-10 text-center mt-3">
                            {{ $video->title }}
                        </h1>

                        <div class="sharethis-inline-share-buttons"></div>

                        <hr>

                        <div class="post-para">
                            <iframe width="100%" height="560"
                                    src="https://www.youtube.com/embed/{{ $video->youtubeId }}?rel=0&showinfo=0"
                                    title="{{ $video->title }}"
                                    frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen
                                    loading="lazy"
                            >
                            </iframe>
                        </div>
                    </article>

                    <div class="comment-box-wrap post-comment mt-3">
                        <h4 class="comment-box-title">Deixe sua opinião:</h4>
                    </div>

                    <div class='fb-comments' data-width='100%' data-href="{{ url()->current() }}" data-numposts='50'></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/pt_BR/sdk.js#xfbml=1&version=v20.0&autoLogAppEvents=1" nonce="E6UM70MS"></script>

    <script type="text/javascript" src="https://platform-api.sharethis.com/js/sharethis.js#property=664f832f3a56e900196c14e5&product=inline-share-buttons&source=platform" async="async"></script>
@endsection
