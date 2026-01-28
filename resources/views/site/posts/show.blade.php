@extends('layouts.site')

@section('title', $post->title)
@section('description', $post->subtitle)

@section('content')
    <hr >

    <section>
        <div class="container">
            <div class="row">
                <div class="col-lg-9 mx-auto pt-md-3">
                    <a href="#" class="badge text-bg-danger mb-2"><i class="fas fa-circle me-2 small fw-bold"></i>{{ $post->category->name }}</a>
                    <h1 class="display-4">{{ $post->title }}</h1>
                    <p class="lead">{{ $post->subtitle }} </p>
                    <!-- Info -->
                    <ul class="nav nav-divider align-items-center">
                        <li class="nav-item small fst-italic">{{ $post->published_at->isoFormat('dddd, D [de] MMMM [de] YYYY') }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section class="pt-0">
        <div class="container position-relative">
            <div class="row">

                <div class="col-lg-9 mx-auto">
                    <div class="sharethis-inline-share-buttons"></div>

                    <hr>

                    <article class="contentPost">
                        {!! $post->content !!}
                    </article>

                    <div class="row g-0 mt-5 mx-0 border-top border-bottom">
                        @foreach($relatedPosts->slice(0, 2) as $relatedPost)
                            <div class="col-sm-6 py-3 py-md-4 @if(($loop->iteration == 1)) text-sm-end @endif">
                                <div class="d-flex align-items-center position-relative">
                                    <div class="bg-primary py-1">
                                        <i class="bi bi-chevron-compact-left fs-3 text-white px-1 rtl-flip"></i>
                                    </div>

                                    <div class="ms-3">
                                        <h5 class="m-0">
                                            <a href="{{ $post->url }}" title="{{ $post->title }}" class="stretched-link btn-link text-reset">
                                                {{ $post->title }}
                                            </a>
                                        </h5>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // CTAs variações
            const ctaVariations = [
                {
                    title: 'Precisa de orientação jurídica?',
                    description: 'Conecte-se com advogados especializados e tire suas dúvidas',
                    buttonText: 'Consulta Jurídica Gratuita',
                    icon: 'fa-robot'
                },
                {
                    title: 'Tem dúvidas sobre seus direitos?',
                    description: 'Fale agora com advogados especializados',
                    buttonText: 'Falar com Advogado',
                    icon: 'fa-balance-scale'
                },
                {
                    title: 'Está passando por situação similar?',
                    description: 'Advogados prontos para te ajudar de forma rápida e segura',
                    buttonText: 'Receber Orientação',
                    icon: 'fa-hands-helping'
                },
                {
                    title: 'Não sabe como proceder?',
                    description: 'Tire suas dúvidas com profissionais qualificados',
                    buttonText: 'Consultar Especialista',
                    icon: 'fa-user-tie'
                }
            ];

            // Função para criar HTML do CTA
            function createCTA(variation) {
                return `
                    <div class="text-center my-4 p-4 bg-light rounded cta-inserted">
                        <h5 class="mb-3">${variation.title}</h5>
                        <p class="text-secondary mb-3 small">${variation.description}</p>
                        <a href="{{ route('chat.home.index') }}" class="btn btn-primary">
                            <i class="fas ${variation.icon} me-2"></i>${variation.buttonText}
                        </a>
                    </div>
                `;
            }

            // Inserir CTAs ao longo do texto
            const paragraphs = jQuery('.contentPost > p');
            const totalParagraphs = paragraphs.length;

            if (totalParagraphs >= 4) {
                // Define posições estratégicas (após 25%, 50% e 75% do conteúdo)
                const positions = [
                    Math.floor(totalParagraphs * 0.25),
                    Math.floor(totalParagraphs * 0.50),
                    Math.floor(totalParagraphs * 0.75)
                ];

                positions.forEach((position, index) => {
                    if (paragraphs.eq(position).length) {
                        const ctaHtml = createCTA(ctaVariations[index % ctaVariations.length]);
                        paragraphs.eq(position).after(ctaHtml);
                    }
                });
            } else if (totalParagraphs >= 2) {
                // Para textos menores, insere apenas no meio
                const middlePosition = Math.floor(totalParagraphs / 2);
                if (paragraphs.eq(middlePosition).length) {
                    const ctaHtml = createCTA(ctaVariations[0]);
                    paragraphs.eq(middlePosition).after(ctaHtml);
                }
            }

            // Adiciona CTA final após o último parágrafo
            if (paragraphs.length > 0) {
                const finalCta = createCTA(ctaVariations[3]);
                paragraphs.last().after(finalCta);
            }

            // Processamento de links para áudio/PDF
            jQuery('.contentPost p a').each(function() {
                let href = jQuery(this).attr("href");
                let replacement;

                switch (true) {
                    case href.includes(".ogg"):
                    case href.includes(".mp3"):
                        replacement = `<audio style="width: 100%;" controls><source src="${href}" type="audio/ogg"><source src="${href}" type="audio/mpeg"></audio>`;
                        break;
                    case href.includes(".pdf"):
                        replacement = `<iframe src="https://drive.google.com/viewerng/viewer?url=${href}?pid=explorer&efh=false&a=v&chrome=false&embedded=true" frameborder="1" scrolling="auto" height="600" width="100%"></iframe>`;
                        break;
                }

                if (replacement) {
                    jQuery(this).replaceWith(replacement);
                }
            });
        });
    </script>

    <script type="text/javascript" src="https://platform-api.sharethis.com/js/sharethis.js#property=664f832f3a56e900196c14e5&product=inline-share-buttons&source=platform" async="async"></script>

    <script async src="https://cdn.embedly.com/widgets/platform.js" charset="UTF-8"></script>
@endsection
