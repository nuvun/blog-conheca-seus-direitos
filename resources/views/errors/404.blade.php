@extends('layouts.site')

@section('title', 'Página não encontrada')

@section('content')
    <div class="blog-section">
        <div class="container">
            <div class="row gx-5">
                <div class="col-12">
                    <div class="row">
                        <div class="py-5">
                            <h2>Página não encontrada.</h2>
                            <p>O endereço abaixo não existe no {{ config('site.site_name') }}</p>

                            <form action="{{ route('site.posts.search') }}" method="get">
                                <div class="input-group">
                                    <input type="search" name="term" class="form-control" placeholder="Pesquisar por..." required autofocus">
                                    <button class="btn btn-primary" type="submit">Pesquisar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
