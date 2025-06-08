<?php

namespace App\Providers;

use App\Models\Banner;
use App\Models\ContentCategory;
use App\Models\Post;
use App\Models\Setting;
use App\Services\PostService;
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

            $listCategoriesNews = Cache::rememberForever('listCategoriesNews', function () {
                return ContentCategory::active()
                    ->isNews()
                    ->toBase()
                    ->get(['id', 'name', 'slug']);
            });

            $postsMostRead = app(PostService::class)->getPostsMostRead();

            $view->with([
                'banners'   => $banners,
                'settings'  => $settings,
                'listCategoriesNews' => $listCategoriesNews,
                'postsMostRead' => $postsMostRead,
            ]);
        });
    }
}
