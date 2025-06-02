@extends('layouts.site')

@section('title', $title)

@section('content')
    <hr />

    <section class="position-relative">
        <div class="container" data-sticky-container>
            <div class="row">
                <div class="col-lg-9">
                    <div class="mb-4">
                        <h2 class="m-0">
                            {{ $title }}
                        </h2>
                    </div>

                    <div class="row gy-4">
                        @foreach($posts as $post)
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

                        {{ $posts->links() }}
                    </div>
                </div>

                @include('partials.site.sidebar')
            </div>
        </div>
    </section>
@endsection

