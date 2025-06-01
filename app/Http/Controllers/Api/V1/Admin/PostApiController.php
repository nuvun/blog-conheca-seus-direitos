<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\Admin\PostResource;
use App\Models\ContentTag;
use App\Models\Post;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PostApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('post_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new PostResource(Post::with(['type_categories', 'users', 'tags'])->get());
    }

    public function store(StorePostRequest $request)
    {
        $post = Post::create(array_merge(
            $request->all(),
            ['attributes' => json_encode(['crawler' => true, 'showable' => false])]
        ));

        $post->categories()->sync($request->input('categories', []));

        $post->users()->sync([$request->user()->id]);

        $post->tags()->sync(
            array_map(
                fn($tag) => ContentTag::firstOrCreate(['name' => trim($tag)])->id,
                $request->input('tags')
            )
        );

        if ($request->input('image_featured', false)) {
            $post->addMediaFromUrl($request->input('image_featured'))
                ->toMediaCollection('image_featured');
        }

        return response()->json(new PostResource($post));
    }

    public function show(Post $post)
    {
        abort_if(Gate::denies('post_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new PostResource($post->load(['type_categories', 'users', 'tags']));
    }

    public function update(UpdatePostRequest $request, Post $post)
    {
        $post->update($request->all());
        $post->type_categories()->sync($request->input('type_categories', []));
        $post->users()->sync($request->input('users', []));
        $post->tags()->sync($request->input('tags', []));
        if ($request->input('image_featured', false)) {
            if (! $post->image_featured || $request->input('image_featured') !== $post->image_featured->file_name) {
                if ($post->image_featured) {
                    $post->image_featured->delete();
                }
                $post->addMedia(storage_path('tmp/uploads/' . basename($request->input('image_featured'))))->toMediaCollection('image_featured');
            }
        } elseif ($post->image_featured) {
            $post->image_featured->delete();
        }

        return (new PostResource($post))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Post $post)
    {
        abort_if(Gate::denies('post_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $post->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
