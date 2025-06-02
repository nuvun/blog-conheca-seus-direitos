<header class="navbar-light navbar-sticky header-static">
    <div class="navbar-top d-none d-lg-block small">
        <div class="container">
            <div class="d-md-flex justify-content-between align-items-center my-2">
                <ul class="nav">
                    <li class="nav-item">
                        <a class="nav-link ps-0" href="" title="Sobre nós">
                            Sobre nós
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link ps-0" href="" title="Fale conosco">
                            Fale conosco
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
                <img class="navbar-brand-item light-mode-item" src="https://blogzine.webestica.com/assets/images/logo.svg" alt="{{ config('app.name') }}">
                <img class="navbar-brand-item dark-mode-item" src="https://blogzine.webestica.com/assets/images/logo-light.svg" alt="{{ config('app.name') }}">
            </a>

            <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="text-body h6 d-none d-sm-inline-block">Menu</span>
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- Main navbar START -->
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav navbar-nav-scroll mx-auto">
                    <li class="nav-item"> <a class="nav-link" href="dashboard.html">Link 1</a></li>
                    <li class="nav-item"> <a class="nav-link" href="dashboard.html">Link 2</a></li>
                    <li class="nav-item"> <a class="nav-link" href="dashboard.html">Link 3</a></li>
                    <li class="nav-item"> <a class="nav-link" href="dashboard.html">Link 4</a></li>
                    <li class="nav-item"> <a class="nav-link" href="dashboard.html">Link 5</a></li>
                </ul>
            </div>
            <!-- Main navbar END -->
            <!-- Nav right START -->
            <div class="nav flex-nowrap align-items-center">
                <!-- Nav Button -->
                <div class="nav-item d-none d-md-block">
                    <a href="#" class="btn btn-sm btn-danger mb-0 mx-2">
                        Subscribe!
                    </a>
                </div>
                <!-- Nav Search -->
                <div class="nav-item dropdown dropdown-toggle-icon-none nav-search">
                    <a class="nav-link dropdown-toggle" role="button" href="#" id="navSearch" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-search fs-4"> </i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end shadow rounded p-2" aria-labelledby="navSearch">
                        <form class="input-group">
                            <input class="form-control border-success" type="search" placeholder="Search" aria-label="Search">
                            <button class="btn btn-success m-0" type="submit">Search</button>
                        </form>
                    </div>
                </div>
                <!-- Offcanvas menu toggler -->
                <div class="nav-item">
                    <a class="nav-link p-0" data-bs-toggle="offcanvas" href="#offcanvasMenu" role="button" aria-controls="offcanvasMenu">
                        <i class="bi bi-text-right rtl-flip fs-2" data-bs-target="#offcanvasMenu"> </i>
                    </a>
                </div>
            </div>
            <!-- Nav right END -->
        </div>
    </nav>
    <!-- Logo Nav END -->
</header>
