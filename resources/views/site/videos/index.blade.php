@extends('layouts.site')

@section('title', $title)

@section('content')
    <div class="blog-section">
        <div class="container">
            <div class="row gx-5">
                <div class="col-12">
                    <h1 class="mt-3 mb-20 d-flex align-items-center">
                        <i class="las la-2x la-play-circle"></i>
                        {{ $title }}
                    </h1>
                    <hr>

                    <div class="row">
                        @forelse($videos as $video)
                            <div class="col-lg-4 col-12">
                                <div class="news-box style6 mb-40">
                                    <div class="news-img">
                                        <a href="{{ $video->url }}" title="{{ $video->title }}">
                                            <img src="{{ $video?->featured_image?->url }}"
                                                 alt="{{ $video->title }}"
                                                 class="w-100 rounded"
                                                 loading="lazy"
                                            />
                                            <div class="play-icon-overlay d-flex justify-content-center align-items-center">
                                                <i class="la la-3x la-play-circle text-white"></i>
                                            </div>
                                        </a>
                                    </div>

                                    <div class="news-info">
                                        <h5 class="">
                                            <a href="{{ $video->url }}" title="{{ $video->title }}" class="text-dark">
                                                {{ $video->title }}
                                            </a>
                                        </h5>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="alert alert-warning">
                                    Nenhum vídeo encontrado.
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="mb-3">
                {{ $videos->links() }}
            </div>
        </div>
    </div>
@endsection
