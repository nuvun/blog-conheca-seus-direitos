<?php

namespace App\Http\Controllers\Site;

use App\Models\Newsletter;
use App\Services\PostService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController
{

    public function index(): View
    {
        $posts = app(PostService::class)->getPosts();

        return view('site.home.index', compact('posts'));
    }

    public function saveLead(Request $request): RedirectResponse
    {
        $request->validate(
            ['email' => ['required', 'email:rfc', 'unique:newsletters,email']],
            [
                'email.required' => 'O campo e-mail é obrigatório.',
                'email.email'    => 'O e-mail informado é inválido.',
                'email.unique'   => 'E-mail já cadastrado.',
            ]
        );

        Newsletter::create($request->only('email'));

        return back()->with('success', 'E-mail cadastrado com sucesso! Aguarde novidades.');
    }

}
