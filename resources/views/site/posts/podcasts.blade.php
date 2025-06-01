@extends('layouts.site')

@section('title', $title)

@section('content')
    <div class="blog-section">
        <div class="container">
            <div class="row gx-5">
                <div class="col-12">
                    <img src="{{ asset('assets/img/podcastvisao360.jpg') }}" alt="{{ $title }}" loading="lazy" />

                    <hr />

                    <div class="row">
                        @forelse($posts as $post)
                            <div class="col-lg-4 col-12">
                                <div class="news-box style6 mb-40">
                                    <div class="news-img">
                                        <a href="{{ $post->url }}" title="{{ $post->title }}">
                                            <img src="/resize-image?src={{ $post->featuredImageUrl }}&w=400&h=350&a=t"
                                                 alt="{{ $post->title }}"
                                                 class="w-100 rounded"
                                                 loading="lazy"
                                            />
                                        </a>
                                    </div>

                                    <div class="news-info">
                                        <h5 class="">
                                            <a href="{{ $post->url }}" title="{{ $post->title }}" class="text-dark">
                                                {{ $post->title }}
                                            </a>
                                        </h5>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="alert alert-warning">
                                    Nenhum post encontrado.
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="mb-3">
                {{ $posts->links() }}
            </div>
        </div>
    </div>
@endsection
