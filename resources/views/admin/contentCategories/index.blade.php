@extends('layouts.admin')

@section('content')
    @can('content_category_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route('admin.content-categories.create') }}">
                    {{ trans('global.add') }} {{ trans('cruds.contentCategory.title_singular') }}
                </a>
            </div>
        </div>
    @endcan

    <div class="card">
        <div class="card-header">
            {{ trans('cruds.contentCategory.title_singular') }} {{ trans('global.list') }}
        </div>

        <div class="card-body">
            <form action="{{ route('admin.content-categories.index') }}" method="get" class="row">
                <div class="form-group col-md-11">
                    <label><small>Nome ou descrição</small></label>
                    <input type="text" class="form-control" name="search" value="{{ request('search') }}" placeholder="faça uma busca" />
                </div>

                <div class="form-group col-md-1">
                    <label class="hidden-xs hidden-sm hidden-md">&nbsp;</label>
                    <button class="btn btn-block btn-primary">
                        <i class="fa fa-search"></i>
                    </button>
                </div>
            </form>

            <hr />

            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-ContentCategory">
                    <thead>
                        <tr>
                            <th>{{ trans('cruds.contentCategory.fields.type_category') }}</th>
                            <th>{{ trans('cruds.contentCategory.fields.name') }}</th>
                            <th>{{ trans('cruds.contentCategory.fields.status') }}</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($contentCategories as $key => $contentCategory)
                            <tr data-entry-id="{{ $contentCategory->id }}">
                                <td>{{ $contentCategory->type_category->name ?? '' }}</td>
                                <td>{{ $contentCategory->name ?? '' }}</td>
                                <td>{{ App\Models\ContentCategory::STATUS_RADIO[$contentCategory->status] ?? '' }}</td>
                                <td>
                                    @can('content_category_show')
                                        <a class="btn btn-xs btn-primary" href="{{ route('admin.content-categories.show', $contentCategory->id) }}">
                                            {{ trans('global.view') }}
                                        </a>
                                    @endcan

                                    @can('content_category_edit')
                                        <a class="btn btn-xs btn-info" href="{{ route('admin.content-categories.edit', $contentCategory->id) }}">
                                            {{ trans('global.edit') }}
                                        </a>
                                    @endcan

                                    @can('content_category_delete')
                                        <form action="{{ route('admin.content-categories.destroy', $contentCategory->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                        </form>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
