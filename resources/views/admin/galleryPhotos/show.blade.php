@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.galleryPhoto.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.gallery-photos.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.galleryPhoto.fields.id') }}
                        </th>
                        <td>
                            {{ $galleryPhoto->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.galleryPhoto.fields.images') }}
                        </th>
                        <td>
                            @foreach($galleryPhoto->images as $key => $media)
                                <a href="{{ $media->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $media->getUrl('thumb') }}">
                                </a>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.galleryPhoto.fields.title') }}
                        </th>
                        <td>
                            {{ $galleryPhoto->title }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.galleryPhoto.fields.description') }}
                        </th>
                        <td>
                            {{ $galleryPhoto->description }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.galleryPhoto.fields.status') }}
                        </th>
                        <td>
                            {{ App\Models\GalleryPhoto::STATUS_RADIO[$galleryPhoto->status] ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.gallery-photos.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection