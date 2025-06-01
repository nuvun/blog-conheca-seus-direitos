<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyBannerRequest;
use App\Http\Requests\StoreBannerRequest;
use App\Http\Requests\UpdateBannerRequest;
use App\Models\Banner;
use App\Models\TypeBanner;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use Symfony\Component\HttpFoundation\Response;

class BannerController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('banner_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $banners = QueryBuilder::for(Banner::class)
            ->with(['type_banner', 'media'])
            ->allowedFilters([
                AllowedFilter::partial('type_banner', 'type_banner.name'),
                'name',
                'featured_position',
                AllowedFilter::exact('status'),
            ])
            ->latest('id')
            ->paginate(100)
            ->withQueryString();

        $type_banners = TypeBanner::get();

        return view('admin.banners.index', compact('banners', 'type_banners'));
    }

    public function create()
    {
        abort_if(Gate::denies('banner_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $type_banners = TypeBanner::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.banners.form', compact('type_banners'));
    }

    public function store(StoreBannerRequest $request)
    {
        $banner = Banner::create($request->all());

        if ($request->input('image', false)) {
            $banner->addMedia(storage_path('tmp/uploads/' . basename($request->input('image'))))->toMediaCollection('image');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $banner->id]);
        }

        return to_route('admin.banners.index');
    }

    public function edit(Banner $banner)
    {
        abort_if(Gate::denies('banner_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $type_banners = TypeBanner::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $banner->load('type_banner');

        return view('admin.banners.form', compact('banner', 'type_banners'));
    }

    public function update(UpdateBannerRequest $request, Banner $banner)
    {
        $banner->update($request->all());

        if ($request->input('image', false)) {
            if (! $banner->image || $request->input('image') !== $banner->image->file_name) {
                if ($banner->image) {
                    $banner->image->delete();
                }
                $banner->addMedia(storage_path('tmp/uploads/' . basename($request->input('image'))))->toMediaCollection('image');
            }
        } elseif ($banner->image) {
            $banner->image->delete();
        }

        return to_route('admin.banners.index');
    }

    public function show(Banner $banner)
    {
        abort_if(Gate::denies('banner_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $banner->load('type_banner');

        return view('admin.banners.show', compact('banner'));
    }

    public function destroy(Banner $banner)
    {
        abort_if(Gate::denies('banner_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $banner->delete();

        return back();
    }

    public function massDestroy(MassDestroyBannerRequest $request)
    {
        $banners = Banner::find(request('ids'));

        foreach ($banners as $banner) {
            $banner->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('banner_create') && Gate::denies('banner_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Banner();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
