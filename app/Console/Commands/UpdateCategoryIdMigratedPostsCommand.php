<?php

namespace App\Console\Commands;

use App\Models\ContentCategory;
use App\Models\Post;
use Illuminate\Console\Command;
use PharIo\Manifest\Email;

class UpdateCategoryIdMigratedPostsCommand extends Command
{
    protected $signature = 'posts:update-category-id-migrated-posts';

    protected $description = 'Update category_id in migrated posts';

    public function handle(): void
    {
        $migratedPosts = Post::query()
            ->whereNotNull('attributes->secao_id')
            ->get();

        $contentCategories = ContentCategory::all('id', 'name');

        $this->withProgressBar($migratedPosts, function ($post) use ($contentCategories) {
            $contentCategoryPost = $contentCategories->firstWhere('id', $post->attributes['secao_id']);

            if ($contentCategoryPost) {
                $post->categories()->sync([$contentCategoryPost->id]);
            }

            // set user to post
            $post->users()->sync([1]);
        });
    }

}
