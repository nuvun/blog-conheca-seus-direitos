@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">
            Salvar {{ trans('cruds.image.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST"
                  action="{{ isset($image) ? route("admin.images.update", [$image->id]) :  route("admin.images.store") }}"
                  enctype="multipart/form-data"
            >
                @method(isset($image) ? 'PUT' : 'POST')
                @csrf

                <div class="form-group">
                    <label class="required" for="photo">{{ trans('cruds.image.fields.photo') }}</label>
                    <div class="needsclick dropzone {{ $errors->has('photo') ? 'is-invalid' : '' }}" id="photo-dropzone">
                    </div>
                    @if($errors->has('photo'))
                        <div class="invalid-feedback">
                            {{ $errors->first('photo') }}
                        </div>
                    @endif
                    <span class="help-block font-italic">{{ trans('cruds.image.fields.photo_helper') }}</span>
                </div>

                <div class="form-group">
                    <label class="required" for="legend">{{ trans('cruds.image.fields.legend') }}</label>
                    <input class="form-control {{ $errors->has('legend') ? 'is-invalid' : '' }}" type="text" name="legend" id="legend" value="{{ old('legend', $image->legend ?? "") }}" required>
                    @if($errors->has('legend'))
                        <div class="invalid-feedback">
                            {{ $errors->first('legend') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.image.fields.legend_helper') }}</span>
                </div>

                <div class="form-group">
                    <label for="credit">{{ trans('cruds.image.fields.credit') }}</label>
                    <input class="form-control {{ $errors->has('credit') ? 'is-invalid' : '' }}" type="text" name="credit" id="credit" value="{{ old('credit', $image->credit ?? "") }}">
                    @if($errors->has('credit'))
                        <div class="invalid-feedback">
                            {{ $errors->first('credit') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.image.fields.credit_helper') }}</span>
                </div>

                <div class="form-group">
                    <label for="photographer">{{ trans('cruds.image.fields.photographer') }}</label>
                    <input class="form-control {{ $errors->has('photographer') ? 'is-invalid' : '' }}" type="text" name="photographer" id="photographer" value="{{ old('photographer', $image->photographer ?? "") }}">
                    @if($errors->has('photographer'))
                        <div class="invalid-feedback">
                            {{ $errors->first('photographer') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.image.fields.photographer_helper') }}</span>
                </div>

                <div class="form-group">
                    <label for="local">{{ trans('cruds.image.fields.local') }}</label>
                    <input class="form-control {{ $errors->has('local') ? 'is-invalid' : '' }}" type="text" name="local" id="local" value="{{ old('local', $image->local ?? "") }}">
                    @if($errors->has('local'))
                        <div class="invalid-feedback">
                            {{ $errors->first('local') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.image.fields.local_helper') }}</span>
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
        Dropzone.options.photoDropzone = {
            url: '{{ route('admin.images.storeMedia') }}',
            maxFilesize: 5, // MB
            acceptedFiles: '.jpeg,.jpg,.png,.gif',
            maxFiles: 1,
            addRemoveLinks: true,
            headers: {
              'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            params: {
              size: 5,
              width: 4096,
              height: 4096
            },
            success: function (file, response) {
              $('form').find('input[name="photo"]').remove()
              $('form').append('<input type="hidden" name="photo" value="' + response.name + '">')
            },
            removedfile: function (file) {
              file.previewElement.remove()
              if (file.status !== 'error') {
                $('form').find('input[name="photo"]').remove()
                this.options.maxFiles = this.options.maxFiles + 1
              }
            },
            init: function () {
        @if(isset($image) && $image->photo)
              var file = {!! json_encode($image->photo) !!}
                  this.options.addedfile.call(this, file)
              this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
              file.previewElement.classList.add('dz-complete')
              $('form').append('<input type="hidden" name="photo" value="' + file.file_name + '">')
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
@endsection
