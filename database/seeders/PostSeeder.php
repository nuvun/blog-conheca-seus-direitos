<?php

namespace Database\Seeders;

use App\Models\ContentCategory;
use App\Enums\{StatusEnum};
use App\Models\Post;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        Post::each(fn ($post) => $post->clearMediaCollection('image_featured'));

        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Post::truncate();
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $quantityPosts = 10;
        $categories    = ContentCategory::active()->toBase()->get(['id']);

        for ($i = 0; $i < $quantityPosts; $i++) {
            $data = [
                'title'        => fake()->sentence(4),
                'subtitle'     => fake()->sentence(),
                'content'      => fake()->paragraphs(5, true),
                'published_at' => now(),
                'status'       => StatusEnum::ACTIVE->value,
            ];

            $post = Post::create($data);

            $post->categories()->sync(
                $categories->random(1)->pluck('id')
            );

            $imageFeatured = 'https://picsum.photos/600/400.jpg';

            $post->addMediaFromUrl($imageFeatured)->toMediaCollection('image_featured');
        }
    }
}
