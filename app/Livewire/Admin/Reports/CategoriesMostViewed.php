<?php

namespace App\Livewire\Admin\Reports;

use App\Models\ContentCategory;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\Url;
use Livewire\Component;

#[Lazy]
class CategoriesMostViewed extends Component
{

    #[Url]
    public string $inputPeriod = '';

    public $postsCategories = [];

    public function mount(): void
    {
        $this->postsCategories = ContentCategory::select(
            'content_categories.name as category_name',
            DB::raw('COUNT(DISTINCT posts.id) as total_posts'),
            DB::raw('SUM(v.total_views) as total_views')
        )
            ->join('content_category_post', 'content_categories.id', '=', 'content_category_post.content_category_id')
            ->join('posts', function ($join)  {
                $join->on('posts.id', '=', 'content_category_post.post_id')
                    ->where('posts.status', '=', 'active')
                    ->where('posts.published_at', '<=', now())
                    ->whereNull('posts.deleted_at');

                if ($this->inputPeriod) {
                    [$start, $end] = explode(' - ', $this->inputPeriod);

                    $join->whereBetween('posts.published_at', [Carbon::createFromFormat('d/m/Y', $start)->startOfDay(), Carbon::createFromFormat('d/m/Y', $end)->endOfDay()]);
                }
            })
            ->join(DB::raw('(SELECT viewable_id, COUNT(*) AS total_views FROM views GROUP BY viewable_id) as v'),
                'posts.id', '=', 'v.viewable_id')
            ->whereNull('content_categories.deleted_at')
            ->groupBy('content_categories.id')
            ->orderByDesc('total_views')
            ->take(10)
            ->get();
    }

    public function render(): View
    {
        return view('livewire.admin.reports.categories-most-viewed');
    }

    public function placeholder(): View
    {
        return view('livewire.loading');
    }

}
