@extends('layouts.site')

@section('content')
    <section class="py-0 card-grid">
        <div class="container">
            <div class="row g-4">
                @foreach($posts->slice(0, 2) as $post)
                    <div class="col-lg-6">
                        <div class="card card-overlay-bottom card-grid-lg card-bg-scale" style="background-image:url({{ $post->featuredImageUrl }}); background-position: center left; background-size: cover;">
                            <div class="card-img-overlay d-flex align-items-center p-3 p-sm-4">
                                <div class="w-100 mt-auto">

                                    <a href="{{ $post->url }}" title="Posts sobre {{ $post->category->name }}" class="badge text-bg-danger mb-2">
                                        <i class="fas fa-circle me-2 small fw-bold"></i>
                                        {{ $post->category->name }}
                                    </a>

                                    <h2 class="text-white h1">
                                        <a href="{{ $post->url }}" title="{{ $post->title }}" class="btn-link stretched-link text-reset">
                                            {{ $post->title }}
                                        </a>
                                    </h2>

                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="position-relative">
        <div class="container" data-sticky-container>
            <div class="row">
                <div class="col-lg-9">
                    <div class="mb-4">
                        <h2 class="m-0">
                            <i class="fa-solid fa-newspaper"></i>
                            Dicas e novidades
                        </h2>
                        <p>
                            Últimas notícias, dicas e novidades sobre seus diretos.
                        </p>
                    </div>
                    <div class="row gy-4">
                        @foreach($posts->slice(2) as $post)
                            <div class="col-sm-6">
                                <div class="card">
                                    <div class="position-relative">
                                        <img class="card-img"
                                             src="{{ $post->featuredImageUrl }}"
                                             alt="{{ $post->title }}"
                                             loading="lazy"
                                        />

                                        <div class="card-img-overlay d-flex align-items-start flex-column p-3">
                                            <div class="w-100 mt-auto">
                                                <a href="{{ $post->url }}" title="Posts sobre {{ $post->category->name }}" class="badge text-bg-info mb-2">
                                                    <i class="fas fa-circle me-2 small fw-bold"></i>
                                                    {{ $post->category->name }}
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-body px-0 pt-3">
                                        <h4 class="card-title mt-2">
                                            <a href="{{ $post->url }}" title="{{ $post->title }}" class="btn-link text-reset fw-bold">
                                                {{ $post->title }}
                                            </a>
                                        </h4>

                                        <p class="card-text">
                                            {{ $post->subtitle }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <div class="col-12 text-center mt-5">
                            <a href="{{ route('site.posts.index') }}" title="Ver todas as postagens" class="btn btn-primary-soft">
                                Ver mais
                                <i class="fa fa-arrow-down ms-2 align-middle"></i>
                            </a>
                        </div>
                    </div>
                </div>

                @include('partials.site.sidebar')
            </div>
        </div>
    </section>

    <div class="container">
        <div class="border-bottom border-primary border-2 opacity-1"></div>
    </div>

    <section class="pt-4">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="mb-4 d-md-flex justify-content-between align-items-center">
                        <h2 class="m-0">
                            <i class="fa-solid fa-file-lines"></i>
                            Artigos
                        </h2>
                    </div>

                    <div class="tiny-slider arrow-hover arrow-blur arrow-dark arrow-round">
                        <div class="tiny-slider-inner"
                             data-autoplay="true"
                             data-hoverpause="true"
                             data-gutter="24"
                             data-arrow="true"
                             data-dots="false"
                             data-items-xl="4"
                             data-items-md="3"
                             data-items-sm="2"
                             data-items-xs="1">

                            @foreach($articlesHome as $article)
                                <div class="card">
                                    <div class="position-relative">
                                        <img class="card-img"
                                             src="{{ $article->featuredImageUrl }}"
                                             alt="{{ $article->title }}"
                                             loading="lazy"
                                        />
                                    </div>

                                    <div class="card-body px-0 pt-3">
                                        <h5 class="card-title">
                                            <a href="{{ $article->url }}" title="{{ $article->title }}" class="btn-link text-reset fw-bold">
                                                {{ $article->title }}
                                            </a>
                                        </h5>

                                        <ul class="nav nav-divider align-items-center d-none d-sm-inline-block">
                                            <li class="nav-item">
                                                <div class="nav-link">
                                                    <div class="d-flex align-items-center position-relative">
{{--                                                        <div class="avatar avatar-xs">--}}
{{--                                                            <img class="avatar-img rounded-circle"--}}
{{--                                                                 src=""--}}
{{--                                                                 alt="avatar"--}}
{{--                                                                 loading="lazy"--}}
{{--                                                            />--}}
{{--                                                        </div>--}}
{{--                                                        <span class="ms-3">--}}
                                                        <span>
                                                            por
                                                            <em>{{ $article->getValueSchemalessAttributes('authorArticle') }}</em>
                                                        </span>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

