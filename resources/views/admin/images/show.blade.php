@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.image.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.images.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.image.fields.id') }}
                        </th>
                        <td>
                            {{ $image->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.image.fields.photo') }}
                        </th>
                        <td>
                            @if($image->photo)
                                <a href="{{ $image->photo->thumbnail }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $image->photo->thumbnail }}"
                                         style="width: 120px; height: 120px; object-fit: cover;"
                                         loading="lazy"
                                    />
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.image.fields.legend') }}
                        </th>
                        <td>
                            {{ $image->legend }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.image.fields.credit') }}
                        </th>
                        <td>
                            {{ $image->credit }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.image.fields.photographer') }}
                        </th>
                        <td>
                            {{ $image->photographer }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.image.fields.local') }}
                        </th>
                        <td>
                            {{ $image->local }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.images.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection
