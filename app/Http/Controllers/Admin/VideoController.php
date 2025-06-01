<?php

namespace App\Http\Controllers\Admin;

use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyVideoRequest;
use App\Http\Requests\StoreVideoRequest;
use App\Http\Requests\UpdateVideoRequest;
use App\Models\ContentCategory;
use App\Models\TypeCategory;
use App\Models\Video;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class VideoController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('video_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $videos = Video::with(['media', 'category:id,name'])
            ->when(request('search'), function ($query) {
                $query->whereAll(['title', 'description'], 'LIKE', '%' . request('search') . '%');
            })
            ->latest('id')
            ->paginate(100)
            ->withQueryString();

        return view('admin.videos.index', compact('videos'));
    }

    public function create()
    {
        abort_if(Gate::denies('video_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $categories = ContentCategory::query()
            ->whereHas('type_category', fn($query) => $query->where('name', 'Vídeos'))
            ->where(function ($query) {
                $query->where('attributes->showOnFormNews', StatusEnum::ACTIVE->value)
                        ->orWhereRaw("JSON_UNQUOTE(JSON_EXTRACT(attributes, '$.showOnFormNews')) IS NULL");
                })
            ->pluck('name', 'id');

        return view('admin.videos.form', compact('categories'));
    }

    public function store(StoreVideoRequest $request)
    {
        $video = Video::create($request->all());

        $featured_image = $request->input('featured_image', false);

        if ($featured_image && filter_var($featured_image, FILTER_VALIDATE_URL)) {
            $video
                ->addMediaFromUrl($featured_image)
                ->usingFileName(Str::slug($request->title).'.'.pathinfo($featured_image, PATHINFO_EXTENSION))
                ->toMediaCollection('featured_image');
        } else {
            $video->addMedia(storage_path('tmp/uploads/' . basename($request->input('featured_image'))))->toMediaCollection('featured_image');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $video->id]);
        }

        return redirect()->route('admin.videos.index');
    }

    public function edit(Video $video)
    {
        abort_if(Gate::denies('video_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $categories = ContentCategory::query()
            ->whereHas('type_category', fn($query) => $query->where('name', 'Vídeos'))
            ->where(function ($query) {
                $query->where('attributes->showOnFormNews', StatusEnum::ACTIVE->value)
                    ->orWhereRaw("JSON_UNQUOTE(JSON_EXTRACT(attributes, '$.showOnFormNews')) IS NULL");
            })
            ->pluck('name', 'id');

        return view('admin.videos.form', compact('video', 'categories'));
    }

    public function update(UpdateVideoRequest $request, Video $video)
    {
        $video->update($request->all());

        if ($request->input('featured_image', false)) {
            if (!$video->featured_image || $request->input('featured_image') !== $video->featured_image->file_name) {
                if ($video->featured_image) {
                    $video->featured_image->delete();
                }
                $video->addMedia(storage_path('tmp/uploads/' . basename($request->input('featured_image'))))->toMediaCollection('featured_image');
            }
        } elseif ($video->featured_image) {
            $video->featured_image->delete();
        }

        return redirect()->route('admin.videos.index');
    }

    public function show(Video $video)
    {
        abort_if(Gate::denies('video_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.videos.show', compact('video'));
    }

    public function destroy(Video $video)
    {
        abort_if(Gate::denies('video_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $video->delete();

        return back();
    }

    public function massDestroy(MassDestroyVideoRequest $request)
    {
        $videos = Video::find(request('ids'));

        foreach ($videos as $video) {
            $video->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('video_create') && Gate::denies('video_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Video();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
