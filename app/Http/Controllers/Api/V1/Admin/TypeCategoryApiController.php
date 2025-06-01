<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTypeCategoryRequest;
use App\Http\Requests\UpdateTypeCategoryRequest;
use App\Http\Resources\Admin\TypeCategoryResource;
use App\Models\TypeCategory;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TypeCategoryApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('type_category_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new TypeCategoryResource(TypeCategory::all());
    }

    public function store(StoreTypeCategoryRequest $request)
    {
        $typeCategory = TypeCategory::create($request->all());

        return (new TypeCategoryResource($typeCategory))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(TypeCategory $typeCategory)
    {
        abort_if(Gate::denies('type_category_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new TypeCategoryResource($typeCategory);
    }

    public function update(UpdateTypeCategoryRequest $request, TypeCategory $typeCategory)
    {
        $typeCategory->update($request->all());

        return (new TypeCategoryResource($typeCategory))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(TypeCategory $typeCategory)
    {
        abort_if(Gate::denies('type_category_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $typeCategory->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
