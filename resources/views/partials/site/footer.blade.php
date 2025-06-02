<footer class="bg-dark pt-5">
    <div class="container">
        <div class="row pt-3 pb-4">
            <div class="col-md-3">
                <img src="{{ asset('assets/img/logo.png') }}"
                     alt="{{ config('app.name') }}"
                     loading="lazy"
                >
            </div>

            <div class="col-md-5">
                <p class="text-body-secondary">
                    {{ config('site.site_description') }}
                </p>
            </div>

            <div class="col-md-4" id="#newsletter">
                <form method="{{ route('site.home.saveLead') }}" method="POST" class="row row-cols-lg-auto g-2">
                    @csrf

                    <div class="col-12">
                        <input type="email"
                               class="form-control"
                               name="email"
                               placeholder="digite seu e-mail"
                               aria-label="Digite seu e-mail"
                               required
                        />
                    </div>

                    <div class="col-12">
                        <button type="submit" class="btn btn-primary m-0">OK</button>
                    </div>

                    <div class="form-text mt-2">
                        Ao se inscrever, você concorda com nossos
                        <a href="https://docs.google.com/document/d/e/2PACX-1vRXIhJHkt7X6de3pQDes5pMmamMacA2lRdgtelWBQIMi8gtQhRH4lxhy3gsA_2b3NJJp794EnMDhLh_/pub"
                           title="Política de Privacidade"
                           target="_blank"
                           class="text-decoration-underline text-reset"
                        >
                            Política de Privacidade
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <hr>
    </div>

    <div class="bg-dark-overlay-3 mt-5">
        <div class="container">
            <div class="row align-items-center justify-content-md-between py-4">
                <div class="col-md-6">
                    <div class="text-center text-md-start text-primary-hover text-body-secondary">
                        ©{{ date('Y') }}
                        - {{ config('app.name') }} -
                        Todos os direitos reservados.
                    </div>
                </div>

                <div class="col-md-6 d-sm-flex align-items-center justify-content-center justify-content-md-end">
                    <ul class="nav text-primary-hover text-center text-sm-end justify-content-center justify-content-center mt-3 mt-md-0">
                        <li class="nav-item">
                            <a class="nav-link"
                               href="https://docs.google.com/document/d/e/2PACX-1vRXIhJHkt7X6de3pQDes5pMmamMacA2lRdgtelWBQIMi8gtQhRH4lxhy3gsA_2b3NJJp794EnMDhLh_/pub"
                               title="Política de Privacidade"
                            >
                                Política de Privacidade
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>
