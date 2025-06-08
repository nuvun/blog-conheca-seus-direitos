<?php

namespace App\Http\Controllers\Site;

use App\Http\Requests\Site\Posts\ReceiveArticleRequest;
use App\Models\ContentCategory;
use App\Models\Post;
use App\Models\User;
use App\Services\PostService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class PostController
{

    public function __construct(
        public PostService $postService,
    ) { }

    public function index(): View
    {
        $title = 'Últimas Postagens';

        $posts = Post::query()
            ->with(['media', 'categories'])
            ->validPeriod()
            ->active()
            ->latest('published_at')
            ->simplePaginate()
            ->withQueryString();

        return view('site.posts.index', compact('title', 'posts'));
    }

    public function show(string $slug, Post $post): View
    {
        abort_if(!$post->isActive, 404);

        views($post)->record();

        $post = $this->postService->getPost($post->id);

        $relatedPosts = $this->postService->getRelatedPosts($post->id);

        if (request()->routeIs('site.posts.showAmp')) {
            return view('site.posts.showAmp', compact('post', 'relatedPosts'));
        }

        return view('site.posts.show', compact('post', 'relatedPosts'));
    }

    public function category(ContentCategory $categoryPost): View
    {
        $title = $categoryPost->name;

        $posts = $categoryPost->posts()
            ->with(['media', 'categories'])
            ->active()
            ->latest('published_at')
            ->simplePaginate()
            ->withQueryString();

        return view('site.posts.index', compact('title', 'categoryPost', 'posts'));
    }

    public function search(Request $request): View
    {
        $title = 'Resultados da busca por: "' . request('term'). '"';

        $posts = Post::query()
            ->with(['media', 'categories'])
            ->searchTerm($request->input('term'))
            ->active()
            ->latest('published_at')
            ->simplePaginate()
            ->withQueryString();

        return view('site.posts.index', compact('title', 'posts'));
    }

    public function user(string $slug): View
    {
        $user = User::query()
            ->whereRaw("REPLACE(LOWER(name), ' ', '-') = ?", [$slug])
            ->firstOrFail(['id', 'name']);

        $title = 'Perfil do(a) jornalista ' . $user->name;

        $posts = Post::query()
            ->whereHas('users', fn($query) => $query->where('user_id', $user->id))
            ->with(['media', 'categories'])
            ->validPeriod()
            ->active()
            ->latest('published_at')
            ->simplePaginate()
            ->withQueryString();

        return view('site.posts.index', compact('title', 'posts'));
    }

    public function feeds(): Response
    {
        $posts = Post::query()
            ->with(['media'])
            ->validPeriod()
            ->active()
            ->latest('published_at')
            ->take(100)
            ->get();

        return response()->view('site.posts.feeds', compact('posts'))
            ->header('Content-Type', 'application/xml');
    }

    public function articles(): View
    {
        $title = 'Artigos';

        $posts = Post::query()
            ->with(['media', 'categories'])
            ->isFromArticle()
            ->validPeriod()
            ->active()
            ->latest('published_at')
            ->simplePaginate()
            ->withQueryString();

        return view('site.posts.index', compact('title', 'posts'));
    }

    public function formArticle(): View
    {
        $title = 'Enviar Artigo';

        return view('site.posts.formArticle', compact('title'));
    }

    public function receiveArticle(ReceiveArticleRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $htmlContent = "
            <p><b>Nome:</b> {$data['name']} </p>
            <p><b>E-mail:</b> {$data['email']} </p>";

        \Mail::send([], [], function ($message) use ($data, $htmlContent) {
            $message->from("contato@nuvun.app", $data['name']);
            $message->replyTo($data['email'], $data['name']);
            $message->to("italoplus@gmail.com", config('mail.from.name'));
            $message->subject('Envio de artigo - ' . config('app.name'));
            $message->html($htmlContent);

            $message->attach($data['file']->getRealPath(), [
                'as'   => $data['file']->getClientOriginalName(),
                'mime' => $data['file']->getMimeType(),
            ]);

        });

        return back()->with('success', 'Artigo enviado com sucesso. Nossa equipe irá analisar e entrar em contato caso seja aprovado.');
    }

}
