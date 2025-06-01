<?php

namespace App\Http\Controllers\Admin;

use App\Models\ContentCategory;
use App\Models\Post;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class HomeController
{

    public function index(Request $request): View
    {
        $inputPeriod = $request->input('filter.period', now()->format('d/m/Y') . ' - ' . now()->format('d/m/Y'));

        $totalPosts = Post::active()->validPeriod()
            ->when($inputPeriod, fn($query) => $query->filterPeriod($inputPeriod))
            ->count();

        $totalViewsPosts = Post::active()->validPeriod()
            ->selectRaw('COALESCE(COUNT(views.id), 0) AS total_views')
            ->join('views', 'posts.id', '=', 'views.viewable_id')
            ->when($inputPeriod, fn($query) => $query->filterPeriod($inputPeriod))
            ->first()
            ->total_views;

        $avgViewsPosts = $totalPosts != 0 ? round($totalViewsPosts / $totalPosts) : 0;

        $mostViewedPosts = Post::active()->validPeriod()
            ->with(['users:name'])
            ->selectRaw('posts.id, posts.title, posts.published_at, COALESCE(COUNT(views.id), 0) AS total_views')
            ->join('views', 'posts.id', '=', 'views.viewable_id')
            ->when($inputPeriod, fn($query) => $query->filterPeriod($inputPeriod))
            ->groupBy('posts.id')
            ->orderByDesc('total_views')
            ->take(10)
            ->get();

        $totalViewsPostMostViewed = $mostViewedPosts->max('total_views');
        $totalViewsPostLessViewed = $mostViewedPosts->min('total_views');
        $userPostMostViewed       = $mostViewedPosts->where('total_views', $totalViewsPostMostViewed)?->first()?->users?->first()?->name;

        return view('home', compact(
            'inputPeriod',
            'totalPosts',
            'totalViewsPosts',
            'avgViewsPosts',
            'totalViewsPostMostViewed',
            'totalViewsPostLessViewed',
            'mostViewedPosts',
            'userPostMostViewed',
        ));
    }

}
