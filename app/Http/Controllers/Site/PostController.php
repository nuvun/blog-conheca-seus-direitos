<?php

namespace App\Http\Controllers\Site;

use App\Models\ContentCategory;
use App\Models\Post;
use App\Models\User;
use App\Services\PostService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
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

    public function blogs(): View
    {
        $title = 'Colunistas';

        $posts = Post::query()
            ->with(['media', 'categories'])
            ->isFromBlog()
            ->active()
            ->latest('published_at')
            ->simplePaginate()
            ->withQueryString();

        return view('site.posts.index', compact('title', 'posts'));

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

}
