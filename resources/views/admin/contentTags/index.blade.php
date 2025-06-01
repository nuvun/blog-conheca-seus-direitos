@extends('layouts.admin')

@section('content')
    @can('content_tag_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.content-tags.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.contentTag.title_singular') }}
            </a>
        </div>
    </div>
@endcan

    <div class="card">
        <div class="card-header">
            {{ trans('cruds.contentTag.title_singular') }} {{ trans('global.list') }}
        </div>

        <div class="card-body">

            <form action="{{ route('admin.content-tags.index') }}" method="get" class="row">
                <div class="form-group col-md-11">
                    <label><small>Nome</small></label>
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
                <table class=" table table-bordered table-striped table-hover datatable datatable-ContentTag">
                    <thead>
                        <tr>
                            <th>{{ trans('cruds.contentTag.fields.name') }}</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($contentTags as $key => $contentTag)
                            <tr data-entry-id="{{ $contentTag->id }}">
                                <td>{{ $contentTag->name ?? '' }}</td>
                                <td>
                                    @can('content_tag_show')
                                        <a class="btn btn-xs btn-primary" href="{{ route('admin.content-tags.show', $contentTag->id) }}">
                                            {{ trans('global.view') }}
                                        </a>
                                    @endcan

                                    @can('content_tag_edit')
                                        <a class="btn btn-xs btn-info" href="{{ route('admin.content-tags.edit', $contentTag->id) }}">
                                            {{ trans('global.edit') }}
                                        </a>
                                    @endcan

                                    @can('content_tag_delete')
                                        <form action="{{ route('admin.content-tags.destroy', $contentTag->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
