<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyContentCategoryRequest;
use App\Http\Requests\StoreContentCategoryRequest;
use App\Http\Requests\UpdateContentCategoryRequest;
use App\Models\ContentCategory;
use App\Models\TypeCategory;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ContentCategoryController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('content_category_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $contentCategories = ContentCategory::with(['type_category'])
            ->when(request('search'), fn($query) => $query->where('name', 'like', '%' . request('search') . '%'))
            ->latest('id')
            ->get();

        return view('admin.contentCategories.index', compact('contentCategories'));
    }

    public function create()
    {
        abort_if(Gate::denies('content_category_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $type_categories = TypeCategory::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.contentCategories.form', compact('type_categories'));
    }

    public function store(StoreContentCategoryRequest $request)
    {
        $contentCategory = ContentCategory::create($request->all());

        if ($request->has('attributes')) {
            $contentCategory->attributes->set($request->input('attributes'));
            $contentCategory->save();
        }

        return redirect()->route('admin.content-categories.index');
    }

    public function edit(ContentCategory $contentCategory)
    {
        abort_if(Gate::denies('content_category_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $type_categories = TypeCategory::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $contentCategory->load('type_category');

        return view('admin.contentCategories.form', compact('contentCategory', 'type_categories'));
    }

    public function update(UpdateContentCategoryRequest $request, ContentCategory $contentCategory)
    {
        $contentCategory->update($request->all());

        if ($request->hasFile('photo')) {
            $contentCategory->addMedia($request->file('photo'))->toMediaCollection('photo');
        }

        if ($request->has('attributes')) {
            $contentCategory->attributes->set($request->input('attributes'));
            $contentCategory->save();
        }

        return redirect()->route('admin.content-categories.index');
    }

    public function show(ContentCategory $contentCategory)
    {
        abort_if(Gate::denies('content_category_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $contentCategory->load('type_category');

        return view('admin.contentCategories.show', compact('contentCategory'));
    }

    public function destroy(ContentCategory $contentCategory)
    {
        abort_if(Gate::denies('content_category_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $contentCategory->delete();

        return back();
    }

    public function massDestroy(MassDestroyContentCategoryRequest $request)
    {
        $contentCategories = ContentCategory::find(request('ids'));

        foreach ($contentCategories as $contentCategory) {
            $contentCategory->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
