<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTypeBannerRequest;
use App\Http\Requests\UpdateTypeBannerRequest;
use App\Http\Resources\Admin\TypeBannerResource;
use App\Models\TypeBanner;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TypeBannerApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('type_banner_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new TypeBannerResource(TypeBanner::all());
    }

    public function store(StoreTypeBannerRequest $request)
    {
        $typeBanner = TypeBanner::create($request->all());

        return (new TypeBannerResource($typeBanner))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(TypeBanner $typeBanner)
    {
        abort_if(Gate::denies('type_banner_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new TypeBannerResource($typeBanner);
    }

    public function update(UpdateTypeBannerRequest $request, TypeBanner $typeBanner)
    {
        $typeBanner->update($request->all());

        return (new TypeBannerResource($typeBanner))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(TypeBanner $typeBanner)
    {
        abort_if(Gate::denies('type_banner_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $typeBanner->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
