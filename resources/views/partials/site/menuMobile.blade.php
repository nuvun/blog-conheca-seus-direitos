<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
    <div class="offcanvas-header">
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <form method="GET" action="{{ route('site.posts.search') }}">
            <div class="header__search">
                <input type="search" name="term" placeholder="O que voce procura?" required />
                <button class="btn p-0" type="submit" style="font-size: 20px; color: #434446;">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </form>

        <div class="offcanvas__menu accordion">
            <div class="header__menu">
                <ul>
                    <li>
                        <a href="{{ route('site.posts.category', ['categoryPost' => 'politica']) }}" class="" title="POLÍTICA">
                            POLÍTICA
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('site.posts.blogs') }}" title="COLUNISTAS">
                            COLUNISTAS
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('site.posts.category', ['categoryPost' => 'policia']) }}" title="POLÍCIA">
                            POLÍCIA
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('site.posts.category', ['categoryPost' => 'municipios']) }}" title="MUNICÍPIOS">
                            MUNICÍPIOS
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('site.posts.category', ['categoryPost' => 'podcast-visao-360']) }}" title="PODCAST VISÃO 360">
                            PODCAST
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('site.posts.category', ['categoryPost' => 'entrevistas']) }}" title="ENTREVISTAS">
                            ENTREVISTA
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('site.posts.category', ['categoryPost' => 'guia-de-compras']) }}" title="GUIA DE COMPRAS">
                            GUIA DE COMPRAS
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('site.posts.category', ['categoryPost' => 'cinema-e-livros']) }}" title="CINEMA e LIVROS">
                            CINEMA E LIVROS
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('site.posts.category', ['categoryPost' => 'alem-da-imaginacao']) }}" title="ALÉM DA IMAGINAÇÃO">
                            ALÉM DA IMAGINAÇÃO
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('site.posts.category', ['categoryPost' => 'vozes-do-piaui']) }}" title="VOZES DO PIAUÍ">
                            VOZES DO PIAUÍ
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('site.posts.category', ['categoryPost' => 'contador-de-emocoes']) }}" title="CONTADOR DE EMOÇÕES">
                            CONTADOR DE EMOÇÕES
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('site.posts.category', ['categoryPost' => 'geral']) }}" title="GERAL">
                            GERAL
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('site.posts.index') }}" title="ÚLTIMAS Notícias">
                            ÚLTIMAS
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="social__link">
            <a href="{{ $settings['site.link_facebook'] ?? '' }}" title="Facebook" target="_blank">
                <i class="fab fa-facebook-f"></i>
            </a>
            <a href="{{ $settings['site.link_instagram'] ?? '' }}" title="Instagram" target="_blank">
                <i class="fab fa-instagram"></i>
            </a>
            <a href="{{ $settings['site.link_youtube'] ?? '' }}" title="YouTube" target="_blank">
                <i class="fab fa-youtube"></i>
            </a>
            <a href="{{ $settings['site.grupo_whatsapp'] ?? '' }}" title="WhatsApp" target="_blank">
                <i class="fab fa-whatsapp"></i>
            </a>
            <a href="{{ $settings['site.link_telegram'] ?? '' }}" title="Telegram" target="_blank">
                <i class="fab fa-telegram-plane"></i>
            </a>
            <a href="{{ $settings['site.link_tiktok'] ?? '' }}" title="tiktok" class="tiktok" target="_blank">
                <i class="fab fa-tiktok"></i>
            </a>
        </div>
    </div>
</div>
