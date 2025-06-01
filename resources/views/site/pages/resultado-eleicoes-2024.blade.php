@extends('layouts.site')

@section('title', "Resultado das Eleições 2024 | Teresina - PI")

@section('content')
    <section class="">
        <div class="container">
            <h2 class="pb-30">Resultado das Eleições 2024 | Teresina - PI</h2>
        </div>

        <div class="container">
            <iframe src="https://resultadoeleicoes2024.revistaforum.com.br/~forum_tse/apuracao_realtime/resultados.html?municipio=Teresina%2C+PI"
                width="100%"
                    height="900"
                    style="overflow-y:scroll !important; overflow-x:hidden !important; overflow:hidden;height:100%;width:100%;min-height:1130px;"
                    scrolling="yes"
            >
            </iframe>
        </div>
    </section>
@endsection
