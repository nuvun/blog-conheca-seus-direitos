<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreImageRequest;
use App\Http\Requests\UpdateImageRequest;
use App\Http\Resources\Admin\ImageResource;
use App\Models\Image;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ImageApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('image_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ImageResource(Image::all());
    }

    public function store(StoreImageRequest $request)
    {
        $image = Image::create($request->all());

        if ($request->input('photo', false)) {
            $image->addMedia(storage_path('tmp/uploads/' . basename($request->input('photo'))))->toMediaCollection('photo');
        }

        return (new ImageResource($image))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Image $image)
    {
        abort_if(Gate::denies('image_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ImageResource($image);
    }

    public function update(UpdateImageRequest $request, Image $image)
    {
        $image->update($request->all());

        if ($request->input('photo', false)) {
            if (! $image->photo || $request->input('photo') !== $image->photo->file_name) {
                if ($image->photo) {
                    $image->photo->delete();
                }
                $image->addMedia(storage_path('tmp/uploads/' . basename($request->input('photo'))))->toMediaCollection('photo');
            }
        } elseif ($image->photo) {
            $image->photo->delete();
        }

        return (new ImageResource($image))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Image $image)
    {
        abort_if(Gate::denies('image_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $image->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
