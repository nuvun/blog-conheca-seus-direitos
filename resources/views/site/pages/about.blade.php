@extends('layouts.site')

@section('title', $title);

@section('content')
    <section class="">
        <div class="container">
            <h1 class="pb-30">{{ $title }}</h1>
        </div>

        <div class="container">
            <article class="py-5">
                <p>Conhecendo seus direitos é um blog que explica leis e direitos de forma simples e prática, com exemplos do dia a dia. Informação clara para ajudar você a entender e exercer seus direitos com confiança.</p>
            </article>
        </div>
    </section>
@endsection
