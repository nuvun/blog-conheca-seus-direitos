<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyGalleryPhotoRequest;
use App\Http\Requests\StoreGalleryPhotoRequest;
use App\Http\Requests\UpdateGalleryPhotoRequest;
use App\Models\GalleryPhoto;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class GalleryPhotoController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('gallery_photo_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $galleryPhotos = GalleryPhoto::with(['media'])
            ->latest('id')
            ->simplePaginate(100)
            ->withQueryString();

        return view('admin.galleryPhotos.index', compact('galleryPhotos'));
    }

    public function create()
    {
        abort_if(Gate::denies('gallery_photo_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.galleryPhotos.create');
    }

    public function store(StoreGalleryPhotoRequest $request)
    {
        $galleryPhoto = GalleryPhoto::create($request->all());

        foreach ($request->input('images', []) as $file) {
            $galleryPhoto->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('images');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $galleryPhoto->id]);
        }

        return redirect()->route('admin.gallery-photos.index');
    }

    public function edit(GalleryPhoto $galleryPhoto)
    {
        abort_if(Gate::denies('gallery_photo_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.galleryPhotos.edit', compact('galleryPhoto'));
    }

    public function update(UpdateGalleryPhotoRequest $request, GalleryPhoto $galleryPhoto)
    {
        $galleryPhoto->update($request->all());

        if (count($galleryPhoto->images) > 0) {
            foreach ($galleryPhoto->images as $media) {
                if (! in_array($media->file_name, $request->input('images', []))) {
                    $media->delete();
                }
            }
        }
        $media = $galleryPhoto->images->pluck('file_name')->toArray();
        foreach ($request->input('images', []) as $file) {
            if (count($media) === 0 || ! in_array($file, $media)) {
                $galleryPhoto->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('images');
            }
        }

        return redirect()->route('admin.gallery-photos.index');
    }

    public function show(GalleryPhoto $galleryPhoto)
    {
        abort_if(Gate::denies('gallery_photo_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.galleryPhotos.show', compact('galleryPhoto'));
    }

    public function destroy(GalleryPhoto $galleryPhoto)
    {
        abort_if(Gate::denies('gallery_photo_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $galleryPhoto->delete();

        return back();
    }

    public function massDestroy(MassDestroyGalleryPhotoRequest $request)
    {
        $galleryPhotos = GalleryPhoto::find(request('ids'));

        foreach ($galleryPhotos as $galleryPhoto) {
            $galleryPhoto->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('gallery_photo_create') && Gate::denies('gallery_photo_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new GalleryPhoto();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
