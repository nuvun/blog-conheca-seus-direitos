@extends('layouts.admin')

@section('content')
    @can('video_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route('admin.videos.create') }}">
                    {{ trans('global.add') }} {{ trans('cruds.video.title_singular') }}
                </a>
            </div>
        </div>
    @endcan

    <div class="card">
        <div class="card-header">
            {{ trans('cruds.video.title_singular') }} {{ trans('global.list') }}
        </div>

        <div class="card-body">
            <form action="{{ route('admin.videos.index') }}" method="get" class="row">
                <div class="form-group col-md-11">
                    <label><small>Título ou descrição</small></label>
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
                <table class=" table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>{{ trans('cruds.video.fields.featured_image') }}</th>
                            <th>{{ trans('cruds.video.fields.title') }}</th>
                            <th>{{ trans('cruds.video.fields.category') }}</th>
                            <th>{{ trans('cruds.video.fields.description') }}</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($videos as $key => $video)
                            <tr data-entry-id="{{ $video->id }}">
                                <td>
                                    @if($video->featured_image)
                                        <a href="{{ $video->external_link }}" target="_blank" style="display: inline-block">
                                            <img src="{{ $video->featured_image->url ?? $video->featured_image->getUrl('thumb') }}"
                                                alt="{{ $video->title ?? '' }}"
                                                 style="max-width: 100px; border-radius: 5px"
                                                 loading="lazy"
                                            />
                                        </a>
                                    @endif
                                </td>
                                <td>
                                    <p>{{ $video->title ?? '' }}</p>

                                    <a href="{{ $video->url }}" target="_blank" title="Ver notícia">
                                        <i class="fa fa-external-link"></i>
                                        VER VÍDEO
                                    </a>
                                </td>
                                <td>{{ $video->category->name ?? '' }}</td>
                                <td>{{ $video->description ?? '' }}</td>
                                <td>
                                    <div class="d-flex flex-column align-items-center" style="gap: 4px">
                                        @can('video_show')
                                            <a class="btn btn-xs btn-primary" href="{{ route('admin.videos.show', $video->id) }}">
                                                {{ trans('global.view') }}
                                            </a>
                                        @endcan

                                        @can('video_edit')
                                            <a class="btn btn-xs btn-info" href="{{ route('admin.videos.edit', $video->id) }}">
                                                {{ trans('global.edit') }}
                                            </a>
                                        @endcan

                                        @can('video_delete')
                                            <form action="{{ route('admin.videos.destroy', $video->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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

            {{ $videos->links() }}
        </div>
    </div>
@endsection
