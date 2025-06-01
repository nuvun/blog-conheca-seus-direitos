<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyTypeBannerRequest;
use App\Http\Requests\StoreTypeBannerRequest;
use App\Http\Requests\UpdateTypeBannerRequest;
use App\Models\TypeBanner;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TypeBannerController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('type_banner_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $typeBanners = TypeBanner::all();

        return view('admin.typeBanners.index', compact('typeBanners'));
    }

    public function create()
    {
        abort_if(Gate::denies('type_banner_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.typeBanners.create');
    }

    public function store(StoreTypeBannerRequest $request)
    {
        $typeBanner = TypeBanner::create($request->all());

        return redirect()->route('admin.type-banners.index');
    }

    public function edit(TypeBanner $typeBanner)
    {
        abort_if(Gate::denies('type_banner_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.typeBanners.edit', compact('typeBanner'));
    }

    public function update(UpdateTypeBannerRequest $request, TypeBanner $typeBanner)
    {
        $typeBanner->update($request->all());

        return redirect()->route('admin.type-banners.index');
    }

    public function show(TypeBanner $typeBanner)
    {
        abort_if(Gate::denies('type_banner_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.typeBanners.show', compact('typeBanner'));
    }

    public function destroy(TypeBanner $typeBanner)
    {
        abort_if(Gate::denies('type_banner_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $typeBanner->delete();

        return back();
    }

    public function massDestroy(MassDestroyTypeBannerRequest $request)
    {
        $typeBanners = TypeBanner::find(request('ids'));

        foreach ($typeBanners as $typeBanner) {
            $typeBanner->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
