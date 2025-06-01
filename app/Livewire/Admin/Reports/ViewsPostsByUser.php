<?php

namespace App\Livewire\Admin\Reports;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\Url;
use Livewire\Component;

#[Lazy]
class ViewsPostsByUser extends Component
{

    #[Url]
    public string $inputPeriod = '';

    public $postsUsers = [];

    public function mount(): void
    {
        $this->postsUsers = User::select(
            'users.name as user_name',
            DB::raw('COUNT(DISTINCT posts.id) as total_posts'),
            DB::raw('SUM(v.total_views) as total_views')
        )
            ->join('post_user', 'users.id', '=', 'post_user.user_id')
            ->join('posts', function($join) {
                $join->on('posts.id', '=', 'post_user.post_id')
                    ->where('posts.status', 'active')
                    ->where('posts.published_at', '<=', now())
                    ->whereNull('posts.deleted_at');

                if ($this->inputPeriod) {
                    [$start, $end] = explode(' - ', $this->inputPeriod);

                    $join->whereBetween('posts.published_at', [Carbon::createFromFormat('d/m/Y', $start)->startOfDay(), Carbon::createFromFormat('d/m/Y', $end)->endOfDay()]);
                }
            })
            ->join(DB::raw('(SELECT viewable_id, COUNT(id) AS total_views FROM views GROUP BY viewable_id) as v'), function($join) {
                $join->on('posts.id', '=', 'v.viewable_id');
            })
            ->groupBy('users.id')
            ->orderByDesc('total_views')
            ->limit(10)
            ->get();
    }

    public function render(): View
    {
        return view('livewire.admin.reports.views-posts-by-user');
    }

    public function placeholder(): View
    {
        return view('livewire.loading');
    }

}
