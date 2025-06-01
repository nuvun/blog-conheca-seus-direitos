<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreGalleryPhotoRequest;
use App\Http\Requests\UpdateGalleryPhotoRequest;
use App\Http\Resources\Admin\GalleryPhotoResource;
use App\Models\GalleryPhoto;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class GalleryPhotoApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('gallery_photo_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new GalleryPhotoResource(GalleryPhoto::all());
    }

    public function store(StoreGalleryPhotoRequest $request)
    {
        $galleryPhoto = GalleryPhoto::create($request->all());

        foreach ($request->input('images', []) as $file) {
            $galleryPhoto->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('images');
        }

        return (new GalleryPhotoResource($galleryPhoto))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(GalleryPhoto $galleryPhoto)
    {
        abort_if(Gate::denies('gallery_photo_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new GalleryPhotoResource($galleryPhoto);
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

        return (new GalleryPhotoResource($galleryPhoto))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(GalleryPhoto $galleryPhoto)
    {
        abort_if(Gate::denies('gallery_photo_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $galleryPhoto->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
