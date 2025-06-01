@extends('layouts.admin')
@section('content')
    @can('banner_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route('admin.banners.create') }}">
                    {{ trans('global.add') }} {{ trans('cruds.banner.title_singular') }}
                </a>
            </div>
        </div>
    @endcan

    <div class="card">
        <div class="card-header">
            {{ trans('cruds.banner.title_singular') }} {{ trans('global.list') }}
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-Banner">
                    <thead>
                        <tr>
                            <th>{{ trans('cruds.banner.fields.type_banner') }}</th>
                            <th>{{ trans('cruds.banner.fields.name') }}</th>
                            <th>{{ trans('cruds.banner.fields.image') }}</th>
                            <th>{{ trans('cruds.banner.fields.start_at') }}</th>
                            <th>{{ trans('cruds.banner.fields.end_at') }}</th>
                            <th scope="col">{{ trans('cruds.banner.fields.link') }}</th>
                            <th>{{ trans('cruds.banner.fields.position') }}</th>
                            <th>{{ trans('cruds.banner.fields.status') }}</th>
                            <th></th>
                        </tr>
                        <form action="">
                            <tr>
                                <td><input class="search" type="text"  name="filter[type_banner]" value="{{ request('filter.type_banner') }}" placeholder="{{ trans('global.search') }}"></td>
                                <td><input class="search" type="text" name="filter[name]" value="{{ request('filter.name') }}" placeholder="{{ trans('global.search') }}"></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>
                                    <select name="filter[status]"
                                            class="form-control-sm w-100"
                                            onchange="this.form.submit()"
                                    >
                                        <option value>{{ trans('global.all') }}</option>
                                        @foreach(App\Models\Banner::STATUS_RADIO as $key => $item)
                                            <option value="{{ $key }}"
                                                    @selected(old('filter.status', request('filter.status') == $key))
                                            >
                                                {{ $item }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td></td>
                            </tr>

                            <input type="submit" hidden />
                        </form>
                    </thead>
                    <tbody>
                        @foreach($banners as $key => $banner)
                            <tr data-entry-id="{{ $banner->id }}">
                                <td>{{ $banner->type_banner->name ?? '' }}</td>
                                <td>
                                    <p>{{ $banner->name ?? '' }}</p>
                                    <p class="text-muted font-italic small">
                                        Formato: {{ $banner->formatTranslated }}
                                    </p>
                                </td>
                                <td>
                                    @if($banner->format == \App\Enums\FormatBannerEnum::FILE->name && $banner->image)
                                        <a href="{{ $banner->image->getUrl() }}" target="_blank" style="display: inline-block">
                                            <img src="{{ $banner->image->getUrl('thumb') }}">
                                        </a>
                                    @else
                                        <p class="text-muted font-italic small">Código</p>
                                    @endif
                                </td>
                                <td>{{ !empty($banner->start_at) ? $banner->start_at->format('d/m/Y H:i') : '' }}</td>
                                <td>{{ !empty($banner->end_at) ? $banner->end_at->format('d/m/Y H:i') : '' }}</td>
                                <td style="max-width: 150px; overflow: hidden; text-overflow: ellipsis;">
                                    {{ $banner->link ?? '' }}
                                </td>
                                <td>{{ $banner->position ?? '' }}</td>
                                <td>{{ App\Models\Banner::STATUS_RADIO[$banner->status] ?? '' }}</td>
                                <td>
                                    <div class="d-flex flex-column align-items-center" style="gap: 4px">
                                        @can('banner_show')
                                            <a class="btn btn-xs btn-primary" href="{{ route('admin.banners.show', $banner->id) }}">
                                                {{ trans('global.view') }}
                                            </a>
                                        @endcan

                                        @can('banner_edit')
                                            <a class="btn btn-xs btn-info" href="{{ route('admin.banners.edit', $banner->id) }}">
                                                {{ trans('global.edit') }}
                                            </a>
                                        @endcan

                                        @can('banner_delete')
                                            <form action="{{ route('admin.banners.destroy', $banner->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
        </div>
    </div>
@endsection
