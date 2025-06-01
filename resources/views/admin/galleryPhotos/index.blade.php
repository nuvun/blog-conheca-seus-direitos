@extends('layouts.admin')

@section('content')
    @can('gallery_photo_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route('admin.gallery-photos.create') }}">
                    {{ trans('global.add') }} {{ trans('cruds.galleryPhoto.title_singular') }}
                </a>
            </div>
        </div>
    @endcan

    <div class="card">
        <div class="card-header">
            {{ trans('cruds.galleryPhoto.title_singular') }} {{ trans('global.list') }}
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>{{ trans('cruds.galleryPhoto.fields.images') }}</th>
                            <th>{{ trans('cruds.galleryPhoto.fields.title') }}</th>
                            <th>{{ trans('cruds.galleryPhoto.fields.description') }}</th>
                            <th>{{ trans('cruds.galleryPhoto.fields.status') }}</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($galleryPhotos as $key => $galleryPhoto)
                            <tr data-entry-id="{{ $galleryPhoto->id }}">
                                <td>
                                    <div class="row">
                                        @foreach($galleryPhoto->images as $key => $media)
                                            <div class="col-lg-4 col-md-6 d-flex justify-content-center mb-2">
                                                <a href="{{ $media->getUrl() }}" target="_blank" style="display: inline-block">
                                                    <img src="{{ $media->getUrl('thumb') }}"
                                                         loading="lazy"
                                                    />
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                </td>
                                <td>{{ $galleryPhoto->title ?? '' }}</td>
                                <td>{{ $galleryPhoto->description ?? '' }}</td>
                                <td>{{ App\Models\GalleryPhoto::STATUS_RADIO[$galleryPhoto->status] ?? '' }}</td>
                                <td>
                                    <div class="d-flex flex-column align-items-center" style="gap: 4px">
                                        @can('gallery_photo_show')
                                            <a class="btn btn-xs btn-primary" href="{{ route('admin.gallery-photos.show', $galleryPhoto->id) }}">
                                                {{ trans('global.view') }}
                                            </a>

                                            <a class="btn btn-xs btn-primary copyToClipboard"
                                               href="javascript:void(0)"
                                               data-clipboard-text='{{ $galleryPhoto->iframeToIncorporate }}'
                                            >
                                                <i class="fas fa-code"></i>
                                                Incorporar
                                            </a>
                                        @endcan

                                        @can('gallery_photo_edit')
                                            <a class="btn btn-xs btn-info" href="{{ route('admin.gallery-photos.edit', $galleryPhoto->id) }}">
                                                {{ trans('global.edit') }}
                                            </a>
                                        @endcan

                                        @can('gallery_photo_delete')
                                            <form action="{{ route('admin.gallery-photos.destroy', $galleryPhoto->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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

@section('scripts')
    <script>
        $(document).on('click', '.copyToClipboard', function () {
            const text = $(this).data('clipboard-text');

            navigator.clipboard.writeText(text).then(function() {
                alert('Copiado para a área de transferência');
            });
        });
    </script>
@endsection

