@extends('layouts.site')

@section('title', $title);

@section('content')
    <section class="border-top">
        <div class="container">
            <div class="pb-4">
                <h1>{{ $title }}</h1>
                <p class="lead">
                    Utilize o formulário abaixo para enviar seu artigo. Certifique-se de que o arquivo esteja no formato PDF ou Word.
                    Após o envio, nossa equipe irá revisar e entrar em contato com você.
                </p>
            </div>
        </div>

        <div class="container">
            @if (session('success'))
                <div class="alert alert-success">
                    <strong>Sucesso!</strong> {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('site.posts.receiveArticle') }}"
                  method="POST"
                  enctype="multipart/form-data"
                  onsubmit="
                    if (!confirm('Tem certeza que deseja enviar o artigo?')) return false;
                    this.querySelector('button[type=submit]').disabled = true;
                    this.querySelector('button[type=submit]').innerHTML = '<i class=\'fa fa-spinner fa-spin\'></i> Enviando...';
                    return true;
                  "
            >
                @csrf

                <div class="form-group mb-4 {{ $errors->has('name') ? 'has-error' : '' }}">
                    <label for="name fw-bold">Nome</label>
                    <input type="text"
                           class="form-control form-control-lg"
                           name="name"
                           id="name"
                           value="{{ old('name') }}"
                           placeholder="digite seu nome"
                           maxlength="250"
                           required
                    />
                    @if ($errors->has('name'))
                        <span class="help-block text-danger">{{ $errors->first('name') }}</span>
                    @endif
                </div>

                <div class="form-group mb-4 {{ $errors->has('email') ? 'has-error' : '' }}">
                    <label for="email fw-bold">E-mail</label>
                    <input type="email"
                           class="form-control form-control-lg"
                           name="email"
                           id="email"
                           value="{{ old('email') }}"
                           placeholder="digite seu e-mail"
                           maxlength="100"
                           required
                    />
                    @if ($errors->has('email'))
                        <span class="help-block text-danger">{{ $errors->first('email') }}</span>
                    @endif
                </div>

                <div class="form-group mb-4 {{ $errors->has('title') ? 'has-error' : '' }}">
                    <label for="title fw-bold">Título</label>
                    <input type="text"
                           class="form-control form-control-lg"
                           name="title"
                           id="title"
                           value="{{ old('title') }}"
                           placeholder="digite o título do artigo"
                           maxlength="250"
                           required
                    />
                    @if ($errors->has('title'))
                        <span class="help-block text-danger">{{ $errors->first('title') }}</span>
                    @endif
                </div>

                <div class="form-group mb-4 {{ $errors->has('file') ? 'has-error' : '' }}">
                    <label for="file fw-bold">Arquivo (PDF ou Word)</label>
                    <input type="file"
                           class="form-control form-control-lg"
                           name="file"
                           id="file"
                           accept=".pdf,.doc,.docx"
                           required
                    />
                    @if ($errors->has('file'))
                        <span class="help-block text-danger">{{ $errors->first('file') }}</span>
                    @endif
                </div>

                <button type="submit" class="btn btn-lg btn-primary w-100">
                    <i class="fa fa-paper-plane"></i>
                    Enviar
                </button>

            </form>
        </div>
    </section>
@endsection
