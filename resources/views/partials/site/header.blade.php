<header class="navbar-light navbar-sticky header-static">
    <div class="navbar-top d-none d-lg-block small">
        <div class="container">
            <div class="d-md-flex justify-content-between align-items-center my-2">
                <ul class="nav">
                    <li class="nav-item">
                        <a class="nav-link ps-0" href="{{ route('site.pages.about') }}" title="Sobre nós">
                            Sobre nós
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link ps-0" href="" title="Fale conosco" target="_blank">
                            Fale conosco
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link ps-0" href="/#newsletter" title="Assine nossa newsletter">
                            Assine nossa newsletter
                        </a>
                    </li>
                </ul>

                <div class="d-flex align-items-center">
                    <ul class="nav">
                        <li class="nav-item">
                            <a class="nav-link px-2 fs-5"
                               href="#"
                               title=""
                               target="_blank"
                            >
                                <i class="fab fa-square-instagram"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link px-2 fs-5"
                               href="#"
                               title=""
                               target="_blank"
                            >
                                <i class="fab fa-facebook-square"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link px-2 fs-5"
                               href="#"
                               title=""
                               target="_blank"
                            >
                                <i class="fab fa-twitter-square"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link px-2 fs-5"
                               href="#"
                               title=""
                               target="_blank"
                            >
                                <i class="fab fa-linkedin"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link px-2 fs-5"
                               href="#"
                               title=""
                               target="_blank"
                            >
                                <i class="fab fa-youtube-square"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- Divider -->
            <div class="border-bottom border-2 border-primary opacity-1"></div>
        </div>
    </div>

    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="{{ route('site.home.index') }}" title="{{ config('app.name') }}">
                <img class="navbar-brand-item light-mode-item" src="{{ asset('assets/img/logo.png') }}" alt="{{ config('app.name') }}">
                <img class="navbar-brand-item dark-mode-item" src="{{ asset('assets/img/logo.png') }}" alt="{{ config('app.name') }}">
            </a>

            <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="text-body h6 d-none d-sm-inline-block">Menu</span>
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav navbar-nav-scroll mx-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="">
                            Últimas Postagens
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="">
                            Artigos
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="">
                            Conheça a nuvun
                        </a>
                    </li>
                </ul>
            </div>

            <div class="nav flex-nowrap align-items-center">
                <!-- Nav Button -->
                <div class="nav-item d-none d-md-block">
                    <a href="/#newsletter" title="Assina nossa newsletter" class="btn btn-sm btn-info mb-0 mx-2">
                        Assina nossa newsletter
                    </a>
                </div>


                <div class="nav-item dropdown dropdown-toggle-icon-none nav-search">
                    <a class="nav-link dropdown-toggle" role="button" href="#" id="navSearch" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-search fs-4"> </i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end shadow rounded p-2" aria-labelledby="navSearch">
                        <form class="input-group" action="{{ route('site.posts.search') }}">
                            <input class="form-control border-success" type="search" name="term" value="{{ request('term') }}" placeholder="faça uma busca" aria-label="faça uma busca">
                            <button class="btn btn-success m-0" type="submit">buscar</button>
                        </form>
                    </div>
                </div>

                <div class="nav-item">
                    <a class="nav-link p-0" data-bs-toggle="offcanvas" href="#offcanvasMenu" role="button" aria-controls="offcanvasMenu">
                        <i class="bi bi-text-right rtl-flip fs-2" data-bs-target="#offcanvasMenu"> </i>
                    </a>
                </div>
            </div>
        </div>
    </nav>
</header>
