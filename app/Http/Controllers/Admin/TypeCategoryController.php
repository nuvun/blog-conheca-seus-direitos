<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyTypeCategoryRequest;
use App\Http\Requests\StoreTypeCategoryRequest;
use App\Http\Requests\UpdateTypeCategoryRequest;
use App\Models\TypeCategory;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TypeCategoryController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('type_category_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $typeCategories = TypeCategory::all();

        return view('admin.typeCategories.index', compact('typeCategories'));
    }

    public function create()
    {
        abort_if(Gate::denies('type_category_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.typeCategories.create');
    }

    public function store(StoreTypeCategoryRequest $request)
    {
        $typeCategory = TypeCategory::create($request->all());

        return redirect()->route('admin.type-categories.index');
    }

    public function edit(TypeCategory $typeCategory)
    {
        abort_if(Gate::denies('type_category_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.typeCategories.edit', compact('typeCategory'));
    }

    public function update(UpdateTypeCategoryRequest $request, TypeCategory $typeCategory)
    {
        $typeCategory->update($request->all());

        return redirect()->route('admin.type-categories.index');
    }

    public function show(TypeCategory $typeCategory)
    {
        abort_if(Gate::denies('type_category_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.typeCategories.show', compact('typeCategory'));
    }

    public function destroy(TypeCategory $typeCategory)
    {
        abort_if(Gate::denies('type_category_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $typeCategory->delete();

        return back();
    }

    public function massDestroy(MassDestroyTypeCategoryRequest $request)
    {
        $typeCategories = TypeCategory::find(request('ids'));

        foreach ($typeCategories as $typeCategory) {
            $typeCategory->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
