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

                <div class="mb-2">
                    <a href="javascript:void(0)" class="btn btn-lg btn-primary useImages">
                        Usar
                    </a>
                </div>

                <table class=" table table-bordered table-striped table-hover datatable datatable-Image">
                    <thead>
                        <tr>
                            <th></th>
                            <th>{{ trans('cruds.image.fields.photo') }}</th>
                            <th>{{ trans('cruds.image.fields.legend') }}</th>
                            <th>{{ trans('cruds.image.fields.credit') }}</th>
                            <th>{{ trans('cruds.image.fields.photographer') }}</th>
                            <th>{{ trans('cruds.image.fields.local') }}</th>
                        </tr>
                        <form action="">
                            <tr>
                                <td></td>
                                <td></td>
                                <td><input class="search" type="text" name="filter[legend]" value="{{ request('filter.legend') }}" placeholder="{{ trans('global.search') }}"></td>
                                <td><input class="search" type="text" name="filter[credit]" value="{{ request('filter.credit') }}" placeholder="{{ trans('global.search') }}"></td>
                                <td><input class="search" type="text" name="filter[photographer]" value="{{ request('filter.photographer') }}" placeholder="{{ trans('global.search') }}"></td>
                                <td><input class="search" type="text" name="filter[local]" value="{{ request('filter.local') }}" placeholder="{{ trans('global.search') }}"></td>
                            </tr>

                            <input type="submit" hidden />
                        </form>
                    </thead>
                    <tbody>
                        @foreach($images as $key => $image)
                            <tr data-entry-id="{{ $image->id }}">
                                <td style="vertical-align: middle; text-align: center; transform: scale(1.5);">
                                    <input type="checkbox"
                                           name="idsImages[]"
                                           value="{{ $image->id }}"
                                           data-id="{{ $image->id }}"
                                           data-imageUrl="{{ $image->photo->url }}"
                                           data-legend="{{ $image->legend }}"
                                           data-credit="{{ $image->credit }}"
                                           style="transform: scale(1.5);"
                                    />
                                </td>
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

@section('scripts')
    <script>
        $("#sidebar").removeClass("c-sidebar-lg-show");
    </script>

    <script>
        $('.useImages').on('click',function () {
            let images = [];

            $('input[name="idsImages[]"]:checked').each(function () {
                images.push({
                    id: $(this).data('id'),
                    imageUrl: $(this).data('imageurl'),
                    legend: $(this).data('legend'),
                    credit: $(this).data('credit')
                });
            });

            if (images.length < 1) {
                alert("Selecione pelo menos uma imagem para usar.")
                return false;
            }

            const urlParams = new URLSearchParams(window.location.search);

            if (urlParams.has('richEditor')) {
                window.opener.postMessage({ source: 'richEditor', selectedImages: images }, "*");
            } else {
                window.opener.postMessage({ source: 'selectImage', selectedImages: images }, "*");
            }

            window.close();
        });
    </script>
@endsection
