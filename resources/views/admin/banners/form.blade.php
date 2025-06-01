@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('global.edit') }} {{ trans('cruds.banner.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST"
                  action="{{ isset($banner) ? route("admin.banners.update", [$banner->id]) :  route("admin.banners.store") }}"
                  enctype="multipart/form-data"
            >
                @method(isset($banner) ? 'PUT' : 'POST')
                @csrf

                <div class="form-group">
                    <label class="required" for="type_banner_id">{{ trans('cruds.banner.fields.type_banner') }}</label>
                    <select class="form-control select2 {{ $errors->has('type_banner') ? 'is-invalid' : '' }}" name="type_banner_id" id="type_banner_id" required>
                        @foreach($type_banners as $id => $entry)
                            <option value="{{ $id }}" {{ (old('type_banner_id') ? old('type_banner_id') : $banner->type_banner->id ?? '') == $id ? 'selected' : '' }}>
                                {{ $entry }}
                            </option>
                        @endforeach
                    </select>
                    @if($errors->has('type_banner'))
                        <div class="invalid-feedback">
                            {{ $errors->first('type_banner') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.banner.fields.type_banner_helper') }}</span>
                </div>

                <div class="form-group">
                    <label class="required">{{ trans('cruds.banner.fields.format') }}</label>
                    @foreach(\App\Enums\FormatBannerEnum::getDescriptions() as $key => $item)
                        <div class="form-check {{ $errors->has('format') ? 'is-invalid' : '' }}">
                            <input class="form-check-input" type="radio"
                                   id="format_{{ $item['value'] }}"
                                   name="format" value="{{ $item['value'] }}"
                                   {{ old('format', $banner->format ?? \App\Enums\FormatBannerEnum::FILE->value) === $item['value'] ? 'checked' : '' }}
                                   required
                            />
                            <label class="form-check-label" for="format_{{ $item['value'] }}">{{ $item['name'] }}</label>
                        </div>
                    @endforeach
                    @if($errors->has('format'))
                        <div class="invalid-feedback">
                            {{ $errors->first('format') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.banner.fields.format_helper') }}</span>
                </div>

                <div class="form-group divCodeInput d-none">
                    <label for="code">{{ trans('cruds.banner.fields.code') }}</label>
                    <textarea class="form-control {{ $errors->has('code') ? 'is-invalid' : '' }}" name="code" id="code">{{ old('code', $banner->code ?? "") }}</textarea>
                    @if($errors->has('code'))
                        <div class="invalid-feedback">
                            {{ $errors->first('code') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.banner.fields.code_helper') }}</span>
                </div>

                <div class="form-group">
                    <label for="name">{{ trans('cruds.banner.fields.name') }}</label>
                    <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $banner->name ?? "") }}">
                    @if($errors->has('name'))
                        <div class="invalid-feedback">
                            {{ $errors->first('name') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.banner.fields.name_helper') }}</span>
                </div>

                <div class="form-group divImageInput">
                    <label class="required" for="image">{{ trans('cruds.banner.fields.image') }}</label>
                    <div class="needsclick dropzone {{ $errors->has('image') ? 'is-invalid' : '' }}" id="image-dropzone">
                    </div>
                    @if($errors->has('image'))
                        <div class="invalid-feedback">
                            {{ $errors->first('image') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.banner.fields.image_helper') }}</span>
                </div>

                <div class="form-group">
                    <label class="required" for="start_at">{{ trans('cruds.banner.fields.start_at') }}</label>
                    <input class="form-control {{ $errors->has('start_at') ? 'is-invalid' : '' }}" type="datetime-local" name="start_at" id="start_at" value="{{ old('start_at', $banner->start_at ?? now()) }}" required>
                    @if($errors->has('start_at'))
                        <div class="invalid-feedback">
                            {{ $errors->first('start_at') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.banner.fields.start_at_helper') }}</span>
                </div>

                <div class="form-group">
                    <label class="required" for="end_at">{{ trans('cruds.banner.fields.end_at') }}</label>
                    <input class="form-control {{ $errors->has('end_at') ? 'is-invalid' : '' }}" type="datetime-local" name="end_at" id="end_at" value="{{ old('end_at', $banner->end_at ?? now()->addMonth()) }}" required>
                    @if($errors->has('end_at'))
                        <div class="invalid-feedback">
                            {{ $errors->first('end_at') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.banner.fields.end_at_helper') }}</span>
                </div>

                <div class="form-group">
                    <label for="link">{{ trans('cruds.banner.fields.link') }}</label>
                    <input class="form-control {{ $errors->has('link') ? 'is-invalid' : '' }}" type="text" name="link" id="link" value="{{ old('link', $banner->link ?? "") }}">
                    @if($errors->has('link'))
                        <div class="invalid-feedback">
                            {{ $errors->first('link') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.banner.fields.link_helper') }}</span>
                </div>

                <div class="form-group">
                    <label class="required" for="position">{{ trans('cruds.banner.fields.position') }}</label>
                    <input class="form-control {{ $errors->has('position') ? 'is-invalid' : '' }}" type="number" name="position" id="position" value="{{ old('position', $banner->position ?? 1) }}" step="1" required>
                    @if($errors->has('position'))
                        <div class="invalid-feedback">
                            {{ $errors->first('position') }}
                        </div>
                    @endif
                    <span c
                          lass="help-block">{{ trans('cruds.banner.fields.position_helper') }}</span>
                </div>

                <div class="form-group">
                    <label class="required">{{ trans('cruds.banner.fields.status') }}</label>
                    @foreach(App\Models\Banner::STATUS_RADIO as $key => $label)
                        <div class="form-check {{ $errors->has('status') ? 'is-invalid' : '' }}">
                            <input class="form-check-input" type="radio" id="status_{{ $key }}" name="status" value="{{ $key }}" {{ old('status', $banner->status ?? \App\Enums\StatusEnum::ACTIVE->value) === (string) $key ? 'checked' : '' }} required>
                            <label class="form-check-label" for="status_{{ $key }}">{{ $label }}</label>
                        </div>
                    @endforeach
                    @if($errors->has('status'))
                        <div class="invalid-feedback">
                            {{ $errors->first('status') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.banner.fields.status_helper') }}</span>
                </div>

                <div class="form-group">
                    <button class="btn btn-danger" type="submit">
                        {{ trans('global.save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        Dropzone.options.imageDropzone = {
            url: '{{ route('admin.banners.storeMedia') }}',
            maxFilesize: 30, // MB
            acceptedFiles: '.jpeg,.jpg,.png,.gif',
            maxFiles: 1,
            addRemoveLinks: true,
            headers: {
              'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            params: {
              size: 3,
              width: 4096,
              height: 4096
            },
            success: function (file, response) {
              $('form').find('input[name="image"]').remove()
              $('form').append('<input type="hidden" name="image" value="' + response.name + '">')
            },
            removedfile: function (file) {
              file.previewElement.remove()
              if (file.status !== 'error') {
                $('form').find('input[name="image"]').remove()
                this.options.maxFiles = this.options.maxFiles + 1
              }
            },
            init: function () {
        @if(isset($banner) && $banner->image)
              var file = {!! json_encode($banner->image) !!}
                  this.options.addedfile.call(this, file)
              this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
              file.previewElement.classList.add('dz-complete')
              $('form').append('<input type="hidden" name="image" value="' + file.file_name + '">')
              this.options.maxFiles = this.options.maxFiles - 1
        @endif
            },
            error: function (file, response) {
                if ($.type(response) === 'string') {
                    var message = response //dropzone sends it's own error messages in string
                } else {
                    var message = response.errors.file
                }
                file.previewElement.classList.add('dz-error')
                _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
                _results = []
                for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                    node = _ref[_i]
                    _results.push(node.textContent = message)
                }

                return _results
            }
        }
    </script>

    <script>
        $(document).on('change', 'input[name="format"]', function () {
            if ($(this).val() === '{{ \App\Enums\FormatBannerEnum::CODE->name }}') {
                $('.divCodeInput').removeClass('d-none');
                $('.divImageInput').addClass('d-none');
            } else {
                $('.divCodeInput').addClass('d-none');
                $('.divImageInput').removeClass('d-none');
            }
        });
    </script>

    <script>
        let banner = @json($banner ?? null);

        if (banner && banner.format !== '') {
            $('input[name="format"]').trigger('change');
        }
    </script>
@endsection
