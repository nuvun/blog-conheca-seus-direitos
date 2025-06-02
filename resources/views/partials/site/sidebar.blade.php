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
        <!-- Category item -->
        <div class="text-center mb-3 card-bg-scale position-relative overflow-hidden rounded bg-dark-overlay-4 " style="background-image:url(https://blogzine.webestica.com/assets/images/blog/4by3/01.jpg); background-position: center left; background-size: cover;">
            <div class="p-3">
                <a href="#" class="stretched-link btn-link fw-bold text-white h5">
                    Direto do Consumidor
                </a>
            </div>
        </div>

        <div class="text-center mb-3 card-bg-scale position-relative overflow-hidden rounded" style="background-image:url(https://blogzine.webestica.com/assets/images/blog/4by3/03.jpg); background-position: center left; background-size: cover;">
            <div class="bg-dark-overlay-4 p-3">
                <a href="#" class="stretched-link btn-link fw-bold text-white h5">
                    Direito do Trabalho
                </a>
            </div>
        </div>

        <div class="text-center mb-3 card-bg-scale position-relative overflow-hidden rounded" style="background-image:url(https://blogzine.webestica.com/assets/images/blog/4by3/04.jpg); background-position: center left; background-size: cover;">
            <div class="bg-dark-overlay-4 p-3">
                <a href="#" class="stretched-link btn-link fw-bold text-white h5">
                    Direito Civil
                </a>
            </div>
        </div>

        <div class="text-center mb-3 card-bg-scale position-relative overflow-hidden rounded" style="background-image:url(https://blogzine.webestica.com/assets/images/blog/4by3/05.jpg); background-position: center left; background-size: cover;">
            <div class="bg-dark-overlay-4 p-3">
                <a href="#" class="stretched-link btn-link fw-bold text-white h5">
                    Direto de Família
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Recent post widget START -->
        <div class="col-12 col-sm-6 col-lg-12">
            <h4 class="mt-4 mb-3">
                <i class="fas fa-fire"></i>
                Posts mais vistos
            </h4>

            @for($i = 0; $i < 5; $i++)
                <div class="card mb-3">
                <div class="row g-3">
                    <div class="col-4">
                        <img class="rounded" src="https://blogzine.webestica.com/assets/images/blog/4by3/thumb/01.jpg" alt="">
                    </div>
                    <div class="col-8">
                        <h6>
                            <a href="post-single-2.html" class="btn-link stretched-link text-reset fw-bold small">
                                Deveres parentais, afetos invertidos e dignidade fragilizada.
                            </a>
                        </h6>
                    </div>
                </div>
            </div>
            @endfor
        </div>

        <div class="col-12 col-sm-6 col-lg-12 my-4">
            <a href="#" class="d-block card-img-flash">
                <img src="https://placehold.co/300x500?text=publicidade" alt="">
            </a>
            <div class="smaller text-end mt-2">publicidade</div>
        </div>
    </div>
</div>
