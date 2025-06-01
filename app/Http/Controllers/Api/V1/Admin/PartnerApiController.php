<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StorePartnerRequest;
use App\Http\Requests\UpdatePartnerRequest;
use App\Http\Resources\Admin\PartnerResource;
use App\Models\Partner;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PartnerApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('partner_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new PartnerResource(Partner::all());
    }

    public function store(StorePartnerRequest $request)
    {
        $partner = Partner::create($request->all());

        if ($request->input('featured_image', false)) {
            $partner->addMedia(storage_path('tmp/uploads/' . basename($request->input('featured_image'))))->toMediaCollection('featured_image');
        }

        return (new PartnerResource($partner))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Partner $partner)
    {
        abort_if(Gate::denies('partner_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new PartnerResource($partner);
    }

    public function update(UpdatePartnerRequest $request, Partner $partner)
    {
        $partner->update($request->all());

        if ($request->input('featured_image', false)) {
            if (! $partner->featured_image || $request->input('featured_image') !== $partner->featured_image->file_name) {
                if ($partner->featured_image) {
                    $partner->featured_image->delete();
                }
                $partner->addMedia(storage_path('tmp/uploads/' . basename($request->input('featured_image'))))->toMediaCollection('featured_image');
            }
        } elseif ($partner->featured_image) {
            $partner->featured_image->delete();
        }

        return (new PartnerResource($partner))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Partner $partner)
    {
        abort_if(Gate::denies('partner_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $partner->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
