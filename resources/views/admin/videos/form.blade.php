@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">
            Salvar {{ trans('cruds.video.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST"
                  action="{{ isset($video) ? route("admin.videos.update", [$video->id]) : route("admin.videos.store") }}"
                  enctype="multipart/form-data"
            >
                @method(isset($video) ? 'PUT' : 'POST')
                @csrf

                <div class="form-group">
                    <label class="required" for="category_id">{{ trans('cruds.post.fields.categories') }}</label>
                    <select class="form-control {{ $errors->has('category_id') ? 'is-invalid' : '' }}" name="category_id" id="category_id" required>
                        <option value="">Selecione</option>
                        @foreach($categories as $id => $category)
                            <option value="{{ $id }}" {{ (in_array($id, old('categories', [])) || isset($video) && $video->category_id == $id) ? 'selected' : '' }}>
                                {{ $category }}
                            </option>
                        @endforeach
                    </select>
                    @if($errors->has('category_id'))
                        <div class="invalid-feedback">
                            {{ $errors->first('categories') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.post.fields.categories_helper') }}</span>
                </div>

                <div class="form-group">
                    <label class="required" for="external_link">{{ trans('cruds.video.fields.external_link') }}</label>
                    <input
                        class="form-control {{ $errors->has('external_link') ? 'is-invalid' : '' }}"
                        type="url"
                        name="external_link"
                        id="external_link"
                        value="{{ old('external_link', $video->external_link ?? "") }}"
                        @readonly(isset($video))
                        required
                    />
                    @if($errors->has('external_link'))
                        <div class="invalid-feedback">
                            {{ $errors->first('external_link') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.video.fields.external_link_helper') }}</span>
                </div>

                <div class="form-group">
                    <label class="required" for="title">{{ trans('cruds.video.fields.title') }}</label>
                    <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" type="text" name="title" id="title" value="{{ old('title', $video->title ?? "") }}" required>
                    @if($errors->has('title'))
                        <div class="invalid-feedback">
                            {{ $errors->first('title') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.video.fields.title_helper') }}</span>
                </div>

                <div class="form-group">
                    <label for="description">{{ trans('cruds.video.fields.description') }}</label>
                    <textarea class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description" id="description">{{ old('description', $video->description ?? "") }}</textarea>
                    @if($errors->has('description'))
                        <div class="invalid-feedback">
                            {{ $errors->first('description') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.video.fields.description_helper') }}</span>
                </div>

                <div class="form-group">
                    <label for="duration">{{ trans('cruds.video.fields.duration') }}</label>
                    <input class="form-control {{ $errors->has('duration') ? 'is-invalid' : '' }}" type="text" name="duration" id="duration" value="{{ old('duration', $video->duration ?? "") }}">
                    @if($errors->has('duration'))
                        <div class="invalid-feedback">
                            {{ $errors->first('duration') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.video.fields.duration_helper') }}</span>
                </div>

                <div class="form-group">
                    <label for="content">{{ trans('cruds.video.fields.content') }}</label>
                    <textarea class="form-control ckeditor {{ $errors->has('content') ? 'is-invalid' : '' }}" name="content" id="content">{!! old('content', $video->content ?? "") !!}</textarea>
                    @if($errors->has('content'))
                        <div class="invalid-feedback">
                            {{ $errors->first('content') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.video.fields.content_helper') }}</span>
                </div>

                <div class="form-group">
                    <label class="required" for="featured_image">{{ trans('cruds.video.fields.featured_image') }}</label>
                    <div class="needsclick dropzone {{ $errors->has('featured_image') ? 'is-invalid' : '' }}" id="featured_image-dropzone">
                    </div>
                    @if($errors->has('featured_image'))
                        <div class="invalid-feedback">
                            {{ $errors->first('featured_image') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.video.fields.featured_image_helper') }}</span>
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
        $(document).ready(function () {
          function SimpleUploadAdapter(editor) {
            editor.plugins.get('FileRepository').createUploadAdapter = function(loader) {
              return {
                upload: function() {
                  return loader.file
                    .then(function (file) {
                      return new Promise(function(resolve, reject) {
                        // Init request
                        var xhr = new XMLHttpRequest();
                        xhr.open('POST', '{{ route('admin.videos.storeCKEditorImages') }}', true);
                        xhr.setRequestHeader('x-csrf-token', window._token);
                        xhr.setRequestHeader('Accept', 'application/json');
                        xhr.responseType = 'json';

                        // Init listeners
                        var genericErrorText = `Couldn't upload file: ${ file.name }.`;
                        xhr.addEventListener('error', function() { reject(genericErrorText) });
                        xhr.addEventListener('abort', function() { reject() });
                        xhr.addEventListener('load', function() {
                          var response = xhr.response;

                          if (!response || xhr.status !== 201) {
                            return reject(response && response.message ? `${genericErrorText}\n${xhr.status} ${response.message}` : `${genericErrorText}\n ${xhr.status} ${xhr.statusText}`);
                          }

                          $('form').append('<input type="hidden" name="ck-media[]" value="' + response.id + '">');

                          resolve({ default: response.url });
                        });

                        if (xhr.upload) {
                          xhr.upload.addEventListener('progress', function(e) {
                            if (e.lengthComputable) {
                              loader.uploadTotal = e.total;
                              loader.uploaded = e.loaded;
                            }
                          });
                        }

                        // Send request
                        var data = new FormData();
                        data.append('upload', file);
                        data.append('crud_id', '{{ $video->id ?? 0 }}');
                        xhr.send(data);
                      });
                    })
                }
              };
            }
          }

          var allEditors = document.querySelectorAll('.ckeditor');
          for (var i = 0; i < allEditors.length; ++i) {
            ClassicEditor.create(
              allEditors[i], {
                extraPlugins: [SimpleUploadAdapter]
              }
            );
          }
        });
    </script>

    <script>
        Dropzone.options.featuredImageDropzone = {
            url: '{{ route('admin.videos.storeMedia') }}',
            maxFilesize: 3, // MB
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
              $('form').find('input[name="featured_image"]').remove()
              $('form').append('<input type="hidden" name="featured_image" value="' + response.name + '">')
            },
            removedfile: function (file) {
              file.previewElement.remove()
              if (file.status !== 'error') {
                $('form').find('input[name="featured_image"]').remove()
                this.options.maxFiles = this.options.maxFiles + 1
              }
            },
            init: function () {
                @if(isset($video) && $video->featured_image)
                      var file = {!! json_encode($video->featured_image) !!}

                      this.options.addedfile.call(this, file)
                      this.options.thumbnail.call(this, file, file.preview)
                      file.previewElement.classList.add('dz-complete')
                      $('form').append('<input type="hidden" name="featured_image" value="' + file.file_name + '">')
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
        function getYoutubeIdByUrl(youtubeUrl)
        {
            let id = youtubeUrl.split('v=')[1];
            let ampersandPosition = id.indexOf('&');

            if(ampersandPosition !== -1) {
                id = id.substring(0, ampersandPosition);
            }

            return id;
        }

        function getDataFromYouTubeApi(youtubeId)
        {
            const YOUTUBE_API_KEY = "AIzaSyAXvPUcKUaK6BF7SyaXRDDFT3ynG8h_aqs";
            const url = `https://www.googleapis.com/youtube/v3/videos?id=${youtubeId}&part=snippet%2Cstatistics%2CcontentDetails&key=${YOUTUBE_API_KEY}`;

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    data = data.items[0];

                    setInputData(data);
                });
        }

        function setInputData(dataFromYouTubeApi)
        {
            $("input#title").val(dataFromYouTubeApi.snippet.title || '');

            $("textarea#description").val(dataFromYouTubeApi.snippet.description || '');

            let duration = dataFromYouTubeApi.contentDetails.duration || '';
            if (duration) {
                let durationInSeconds = convertDateIso8601ToSeconds(duration);
                let durationHms = convertSecondstoHms(durationInSeconds);

                $("input#duration").val(durationHms);
            }

            $('form')
                .append('<input type="hidden" name="featured_image" value="' + dataFromYouTubeApi.snippet.thumbnails.maxres.url + '">')
        }

        function convertDateIso8601ToSeconds(date)
        {
            let reptms = /^PT(?:(\d+)H)?(?:(\d+)M)?(?:(\d+)S)?$/;
            let hours = 0, minutes = 0, seconds = 0, totalseconds;

            if (reptms.test(date)) {
                let matches = reptms.exec(date);
                if (matches[1]) hours = Number(matches[1]);
                if (matches[2]) minutes = Number(matches[2]);
                if (matches[3]) seconds = Number(matches[3]);
                totalseconds = hours * 3600  + minutes * 60 + seconds;
            }

            return totalseconds;
        }

        function convertSecondstoHms(d)
        {
            d = Number(d);
            let h = Math.floor(d / 3600);
            let m = Math.floor(d % 3600 / 60);
            let s = Math.floor(d % 3600 % 60);

            return ((h > 0 ? h + ":" + (m < 10 ? "0" : "") : "") + m + ":" + (s < 10 ? "0" : "") + s);
        }

        $("input#external_link").on("blur", function() {
            let youtubeUrl = $("input#external_link").val() || "";

            if (!youtubeUrl || !youtubeUrl.includes("youtube")) {
                return;
            }

            let youtubeId = getYoutubeIdByUrl(youtubeUrl);

            getDataFromYouTubeApi(youtubeId);
        });
    </script>
@endsection
