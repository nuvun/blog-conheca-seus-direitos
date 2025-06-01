@extends('layouts.site')

@section('title', $title)

@section('content')
    <div class="blog-section">
        <div class="container">
            <div class="row gx-5">
                <div class="col-xxl-8 col-xl-8 col-lg-12">
                    <h1 class="mt-4 fw-bold">
                        {{ $title }}
                    </h1>

                    <hr />

                    @forelse($posts as $post)
                        <div class="news-box d-flex align-items-center">
                            <div class="me-3 col-lg-4">
                                <a href="{{ $post->url }}" title="{{ $post->title }}" class="news-img">
                                    <img src="/resize-image?src={{ $post->featuredImageUrl }}&w=300&h=300&a=t"
                                         alt="{{ $post->title }}"
                                         loading="lazy"
                                         class="rounded"
                                    />
                                </a>
                            </div>

                            <div class="news-info col-lg-8">
                                <span class="badge bg-brand">
                                    {{ $post?->category?->name }}
                                </span>

                                <h3 class="mt-2">
                                    <a href="{{ $post->url }}" title="{{ $post->title }}" class="text-dark fw-semibold">
                                        {{ $post->title }}
                                    </a>
                                </h3>

                                <i class="fa-regular fa-calendar"></i>
                                {{ $post->published_at->isoFormat('LL [às] HH:mm') }}
                            </div>
                        </div>

                        <hr>
                    @empty
                        <div class="alert alert-warning">
                            Nenhum notícia encontrada.
                        </div>
                    @endforelse

                    {{ $posts->links() }}
                </div>

                <div class="col-xxl-4 col-xl-4 col-lg-12">
                    @include('partials.site.sidebar')
                </div>
            </div>
        </div>
    </div>
@endsection
