<?php

namespace App\Providers;

use App\Models\Banner;
use App\Models\ContentCategory;
use App\Models\Post;
use App\Models\Setting;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        if ($this->app->environment('production')) {
            $this->app['request']->server->set('HTTPS','on');
            \URL::forceScheme('https');
        }

        Paginator::useBootstrapFive();

        view()->composer(['site.*'], function ($view) {
            // banners publicitários
            $banners = Cache::rememberForever('banners', function () {
                return Banner::active()
                    ->with(['media', 'type_banner:id,name'])
                    ->validPeriod()
                    ->orderBy('position')
                    ->get()
                    ->groupBy('type_banner.name');
            });

            // configurações gerais
            $settings = Cache::rememberForever('settings', function () {
                return Setting::pluck('value', 'key')->toArray();
            });

            // últimas postagens
            $lastPosts = Cache::rememberForever('lastPosts', function () {
                return Post::with(['media', 'categories', 'image'])
                    ->active()
                    ->validPeriod()
                    ->where(function ($query) {
                        $query->whereRaw('NOT JSON_CONTAINS_PATH(attributes, "one", \'$."showable"\')')
                            ->orWhereRaw('JSON_EXTRACT(attributes, \'$."showable"\') = "false"');
                    })
                    ->latest('published_at')
                    ->take(10)
                    ->get();
            });

            $listBlogs = Cache::rememberForever('listBlogs', function () {
                return ContentCategory::active()
                    ->isBlog()
                    ->toBase()
                    ->get(['id', 'name', 'slug']);
            });

            $listCategoriesNews = Cache::rememberForever('listCategoriesNews', function () {
                return ContentCategory::active()
                    ->isNews()
                    ->toBase()
                    ->get(['id', 'name', 'slug']);
            });

            $view->with([
                'banners'   => $banners,
                'settings'  => $settings,
                'lastPosts' => $lastPosts,
                'listBlogs' => $listBlogs,
                'listCategoriesNews' => $listCategoriesNews,
            ]);
        });
    }
}
