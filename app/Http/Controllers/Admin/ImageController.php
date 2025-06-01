<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyImageRequest;
use App\Http\Requests\StoreImageRequest;
use App\Http\Requests\UpdateImageRequest;
use App\Models\Image;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use Symfony\Component\HttpFoundation\Response;

class ImageController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('image_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $images = QueryBuilder::for(Image::class)
            ->withWhereHas('media')
            ->allowedFilters([
                'legend',
                'credit',
                'photographer',
                'local',
            ])
            ->latest('id')
            ->paginate()
            ->withQueryString();

        return view('admin.images.index', compact('images'));
    }

    public function create()
    {
        abort_if(Gate::denies('image_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.images.form');
    }

    public function store(StoreImageRequest $request)
    {
        $image = Image::create($request->all());

        if ($request->input('photo', false)) {
            $fileName          = explode('.', $request->input('photo'));
            $slugMediaFileName = str(current($fileName))->slug()->value() . '.' . end($fileName);

            $image->addMedia(storage_path('tmp/uploads/' . basename($request->input('photo'))))
                ->usingFileName($slugMediaFileName)
                ->toMediaCollection('photo');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $image->id]);
        }

        return to_route('admin.images.index');
    }

    public function edit(Image $image)
    {
        abort_if(Gate::denies('image_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.images.form', compact('image'));
    }

    public function update(UpdateImageRequest $request, Image $image)
    {
        $image->update($request->all());

        if ($request->input('photo', false)) {
            if (! $image->photo || $request->input('photo') !== $image->photo->file_name) {
                if ($image->photo) {
                    $image->photo->delete();
                }

                $fileName          = explode('.', $request->input('photo'));
                $slugMediaFileName = str(current($fileName))->slug()->value() . '.' . end($fileName);

                $image->addMedia(storage_path('tmp/uploads/' . basename($request->input('photo'))))
                    ->usingFileName($slugMediaFileName)
                    ->toMediaCollection('photo');
            }
        } elseif ($image->photo) {
            $image->photo->delete();
        }

        return redirect()->route('admin.images.index');
    }

    public function show(Image $image)
    {
        abort_if(Gate::denies('image_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.images.show', compact('image'));
    }

    public function destroy(Image $image)
    {
        abort_if(Gate::denies('image_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $image->delete();

        return back();
    }

    public function massDestroy(MassDestroyImageRequest $request)
    {
        $images = Image::find(request('ids'));

        foreach ($images as $image) {
            $image->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('image_create') && Gate::denies('image_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Image();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }

    public function selectImage()
    {
        abort_if(Gate::denies('image_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $images = QueryBuilder::for(Image::class)
            ->withWhereHas('media')
            ->allowedFilters([
                'legend',
                'credit',
                'photographer',
                'local',
            ])
            ->latest()
            ->paginate(100)
            ->withQueryString();

        return view('admin.images.selectImage', compact('images'));
    }

}
