@extends('layouts.admin')

@section('content')
    @can('image_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route('admin.images.create') }}">
                    {{ trans('global.add') }} {{ trans('cruds.image.title_singular') }}
                </a>
            </div>
        </div>
    @endcan

    <div class="card">
        <div class="card-header">
            {{ trans('cruds.image.title_singular') }} {{ trans('global.list') }}
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-Image">
                    <thead>
                        <tr>
                            <th>{{ trans('cruds.image.fields.photo') }}</th>
                            <th>{{ trans('cruds.image.fields.legend') }}</th>
                            <th>{{ trans('cruds.image.fields.credit') }}</th>
                            <th>{{ trans('cruds.image.fields.photographer') }}</th>
                            <th>{{ trans('cruds.image.fields.local') }}</th>
                            <th></th>
                        </tr>
                        <form action="{{ route('admin.images.index') }}">
                            <tr>
                                <td></td>
                                <td><input class="search" type="text" name="filter[legend]" value="{{ request('filter.legend') }}" placeholder="{{ trans('global.search') }}"></td>
                                <td><input class="search" type="text" name="filter[credit]" value="{{ request('filter.credit') }}" placeholder="{{ trans('global.search') }}"></td>
                                <td><input class="search" type="text" name="filter[photographer]" value="{{ request('filter.photographer') }}" placeholder="{{ trans('global.search') }}"></td>
                                <td><input class="search" type="text" name="filter[local]" value="{{ request('filter.local') }}" placeholder="{{ trans('global.search') }}"></td>
                                <td></td>
                            </tr>

                            <input type="submit" hidden />
                        </form>
                    </thead>
                    <tbody>
                        @foreach($images as $key => $image)
                            <tr data-entry-id="{{ $image->id }}">
                                <td>
                                    @if($image->photo)
                                        <a href="{{ $image->photo->getUrl() }}" target="_blank" style="display: inline-block">
                                            <img src="{{ $image->photo->thumbnail }}"
                                                 style="width: 120px; height: 120px; object-fit: cover;"
                                                 loading="lazy"
                                            />
                                        </a>
                                    @endif
                                </td>
                                <td>{{ $image->legend ?? '' }}</td>
                                <td>{{ $image->credit ?? '' }}</td>
                                <td>{{ $image->photographer ?? '' }}</td>
                                <td>{{ $image->local ?? '' }}</td>
                                <td>
                                    <div class="d-flex flex-column align-items-center" style="gap: 4px">
                                        @can('image_show')
                                            <a class="btn btn-xs btn-primary" href="{{ route('admin.images.show', $image->id) }}">
                                                {{ trans('global.view') }}
                                            </a>
                                        @endcan

                                        @can('image_edit')
                                            <a class="btn btn-xs btn-info" href="{{ route('admin.images.edit', $image->id) }}">
                                                {{ trans('global.edit') }}
                                            </a>
                                        @endcan

                                        @can('image_delete')
                                            <form action="{{ route('admin.images.destroy', $image->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                                <input type="hidden" name="_method" value="DELETE">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                            </form>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="text-center">
                {{ $images->links() }}
            </div>
        </div>
    </div>
@endsection
