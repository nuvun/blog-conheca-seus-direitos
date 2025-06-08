<div class="sidebar col-lg-3 mt-5 mt-lg-0">
    <div class="row g-2">
        <div class="col-4">
            <a href="#" class="bg-facebook rounded text-center text-white-force p-3 d-block">
                <i class="fab fa-facebook-square fs-5 mb-2"></i>
                <h6 class="m-0">1.5K</h6>
                <span class="small">fãs</span>
            </a>
        </div>
        <div class="col-4">
            <a href="#" class="bg-instagram-gradient rounded text-center text-white-force p-3 d-block">
                <i class="fab fa-instagram fs-5 mb-2"></i>
                <h6 class="m-0">1.8M</h6>
                <span class="small">seguidores</span>
            </a>
        </div>
        <div class="col-4">
            <a href="#" class="bg-youtube rounded text-center text-white-force p-3 d-block">
                <i class="fab fa-youtube-square fs-5 mb-2"></i>
                <h6 class="m-0">22K</h6>
                <span class="small">inscritos</span>
            </a>
        </div>
    </div>

    <div>
        <h4 class="mt-4 mb-3">Categorias</h4>
        @foreach($listCategoriesNews as $category)
            <div class="text-center mb-3 card-bg-scale position-relative overflow-hidden rounded bg-dark-overlay-4"
                 style="background-image:url({{ asset('assets/img/bg-category.jpg') }}); background-position: center left; background-size: cover;"
            >
                <div class="p-3">
                    <a href="{{ route('site.posts.category', $category->slug) }}" title="Postagens - {{ $category->name }}" class="stretched-link btn-link fw-bold text-white h5">
                        {{ $category->name }}
                    </a>
                </div>
            </div>
        @endforeach
    </div>

    <div class="row">
        <div class="col-12 col-sm-6 col-lg-12">
            <h4 class="mt-4 mb-3">
                <i class="fas fa-fire"></i>
                Posts mais vistos
            </h4>

            @foreach($postsMostRead as $post)
                <div class="card mb-3">
                    <div class="row g-3">
                        <div class="col-4">
                            <img class="rounded"
                                 src="{{ $post->featuredImageUrl }}"
                                 alt="{{ $post->title }}"
                                 loading="lazy"
                            />
                        </div>
                        <div class="col-8">
                            <h6>
                                <a href="{{ $post->url }}" title="{{ $post->title }}" class="btn-link stretched-link text-reset fw-bold small">
                                    {{ $post->title }}
                                </a>
                            </h6>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="col-12 col-sm-6 col-lg-12 my-4">
            @isset($banners['Quadrado home'])
                <div class="container">
                    <div id="carouselExampleFb1" class="carousel slide" data-bs-ride="carousel" data-bs-interval="10000">
                        <div class="carousel-inner">
                            @foreach($banners['Quadrado home'] as $banner)
                                <div @class(['carousel-item', 'active' => $loop->first])>
                                    @if($banner->isFormatCode)
                                        <div class="d-block ad text-center mt-3">
                                            {!! $banner->code !!}
                                        </div>
                                    @else
                                        <a href="{{ $banner->link }}" title="{{ $banner->name }}" target="_blank" class="d-block card-img-flash ad text-center pt-30 pb-30">
                                            <img src="{{ $banner->image->getUrl() }}"
                                                 alt="{{ $banner->name }}"
                                                 class="w-100"
                                                 loading="lazy"
                                            />
                                        </a>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endisset

            <div class="smaller text-end mt-2">publicidade</div>
        </div>
    </div>
</div>
