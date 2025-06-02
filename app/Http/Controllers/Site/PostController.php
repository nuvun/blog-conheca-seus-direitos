<?php

namespace App\Http\Controllers\Site;

use App\Models\ContentCategory;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class PostController
{

    public function index(): View
    {
        $title = 'Últimas Notícias';

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

        $cacheKey = 'post_' . $post->id;
        $post = Cache::rememberForever($cacheKey, function () use ($post) {
            return $post->load('categories', 'image', 'media', 'tags', 'users');
        });

        $relatedPosts = Cache::remember($cacheKey . '_related', now()->addMinutes(10), function () use ($post) {
            return Post::query()
                ->with(['media', 'categories', 'image'])
                ->whereHas('categories', function ($query) use ($post) {
                    $query->whereIn('content_categories.id', $post->categories->pluck('id'));
                })
                ->where('id', '!=', $post->id)
                ->validPeriod()
                ->latest('published_at')
                ->limit(3)
                ->get();
        });

        if (request()->routeIs('site.posts.showAmp')) {
            return view('site.posts.showAmp', compact('post', 'relatedPosts'));
        }

        $view = $post->isInterview ? 'site.posts.showInterview' : 'site.posts.show';

        return view($view, compact('post', 'relatedPosts'));
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
