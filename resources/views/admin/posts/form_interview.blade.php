@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">
            Salvar Entrevista
        </div>

        <div class="card-body">
            <form method="POST"
                  action="{{ isset($post) ? route("admin.posts.update", [$post->id]) :  route("admin.posts.store") }}"
                  enctype="multipart/form-data"
            >
                @method(isset($post) ? 'PUT' : 'POST')
                @csrf

                <!-- ID for category "Entrevista" -->
                <input  type="hidden" name="categories[]" value="202" required>

                <div class="form-group">
                    <label>{{ trans('cruds.post.fields.featured_position') }}</label>
                    <select class="form-control {{ $errors->has('featured_position') ? 'is-invalid' : '' }}" name="featured_position" id="featured_position">
                        <option value disabled {{ old('featured_position', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                        @foreach(\App\Enums\FeaturedPositionPostEnum::getDescriptions() as $item)
                            <option value="{{ $item['value'] }}"
                                {{ old('featured_position', isset($post) && $post->getRawOriginal('featured_position') ?? "") === (string) $item['value'] ? 'selected' : '' }}
                            >
                                {{ $item['description'] }}
                            </option>
                        @endforeach
                    </select>
                    @if($errors->has('featured_position'))
                        <div class="invalid-feedback">
                            {{ $errors->first('featured_position') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.post.fields.featured_position_helper') }}</span>
                </div>

                <div class="form-group">
                    <label class="required" for="title">{{ trans('cruds.post.fields.title') }}</label>
                    <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" type="text" name="title" id="title" value="{{ old('title', $post->title ?? "") }}" required>
                    @if($errors->has('title'))
                        <div class="invalid-feedback">
                            {{ $errors->first('title') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.post.fields.title_helper') }}</span>
                </div>

                <div class="form-group">
                    <label for="subtitle">{{ trans('cruds.post.fields.subtitle') }}</label>
                    <input class="form-control {{ $errors->has('subtitle') ? 'is-invalid' : '' }}" type="text" name="subtitle" id="subtitle" value="{{ old('subtitle', $post->subtitle ?? "") }}">
                    @if($errors->has('subtitle'))
                        <div class="invalid-feedback">
                            {{ $errors->first('subtitle') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.post.fields.subtitle_helper') }}</span>
                </div>

                <div class="form-group">
                    <label for="image_featured">Foto destaque</label>

                    <input type="file"
                           class="form-control"
                           id="image_featured"
                           name="image_featured"
                           accept="image/*"
                    />

                    @if(isset($post) && $post->hasMedia('image_featured'))
                        <img src="{{ $post->getFirstMediaUrl('image_featured') }}"
                             class="img-thumbnail mb-2"
                             style="height: 100px;"
                             loading="lazy"
                        />
                    @endif
                </div>

                <div class="form-group">
                    <label for="image_featured">Foto topo</label>

                    <input type="file"
                           class="form-control"
                           id="imageTopInterview"
                           name="imageTopInterview"
                           accept="image/*"
                    />
                    <p class="text-muted font-italic">Dimensões: 1440 x 1000 pixels</p>

                    @if(isset($post) && $post->hasMedia('imageTopInterview'))
                        <img src="{{ $post->getFirstMediaUrl('imageTopInterview') }}"
                             class="img-thumbnail mb-2"
                             style="height: 100px;"
                             loading="lazy"
                        />
                    @endif
                </div>

                <div id="div-imageFeaturedSpecialHighlight" @class(["form-group", "d-none" => isset($post) && ($post->getRawOriginal('featured_position') ?? "") !== \App\Enums\FeaturedPositionPostEnum::SPECIAL_HIGHLIGHT->name])>
                    <label for="imageFeaturedSpecialHighlight">Foto destaque especial</label>

                    <input type="file"
                           class="form-control"
                           id="imageFeaturedSpecialHighlight"
                           name="imageFeaturedSpecialHighlight"
                           accept="image/*"
                    />
                    <p class="text-muted font-italic">Dimensões: 1200 x 220 pixels</p>

                    @if(isset($post) && $post->hasMedia('imageFeaturedSpecialHighlight'))
                        <img src="{{ $post->getFirstMediaUrl('imageFeaturedSpecialHighlight') }}"
                             class="img-thumbnail mb-2"
                             style="height: 100px;"
                             loading="lazy"
                        />
                    @endif
                </div>

                <div class="form-group">
                    <label for="attributes[text1]">Texto 1</label>
                    <textarea class="form-control richEditor {{ $errors->has('attributes.text1') ? 'is-invalid' : '' }}" name="attributes[text1]" id="attributes[text1]">{!! old('attributes.text1', $post->attributes->text1 ?? "") !!}</textarea>
                    @if($errors->has('attributes.text1'))
                        <div class="invalid-feedback">
                            {{ $errors->first('attributes.text1') }}
                        </div>
                    @endif
                </div>

                <div class="form-group">
                    <label for="attributes[quote1]">Citação 1</label>
                    <textarea class="form-control {{ $errors->has('attributes.quote1') ? 'is-invalid' : '' }}" name="attributes[quote1]" id="attributes[quote1]">{!! old('attributes.quote1', $post->attributes->quote1 ?? "") !!}</textarea>
                    @if($errors->has('attributes.quote1'))
                        <div class="invalid-feedback">
                            {{ $errors->first('attributes.quote1') }}
                        </div>
                    @endif
                </div>

                <div class="form-group">
                    <label for="attributes[text2]">Texto 2</label>
                    <textarea class="form-control richEditor {{ $errors->has('attributes.text2') ? 'is-invalid' : '' }}" name="attributes[text2]" id="attributes[text2]">{!! old('attributes.text2', $post->attributes->text2 ?? "") !!}</textarea>
                    @if($errors->has('attributes.text2'))
                        <div class="invalid-feedback">
                            {{ $errors->first('attributes.text2') }}
                        </div>
                    @endif
                </div>

                <div class="form-group">
                    <label for="attributes[quote2]">Citação 2</label>
                    <textarea class="form-control {{ $errors->has('attributes.quote2') ? 'is-invalid' : '' }}" name="attributes[quote2]" id="attributes[quote2]">{!! old('attributes.quote2', $post->attributes->quote2 ?? "") !!}</textarea>
                    @if($errors->has('attributes.quote2'))
                        <div class="invalid-feedback">
                            {{ $errors->first('attributes.quote1') }}
                        </div>
                    @endif
                </div>

                <div class="form-group">
                    <label for="image2Interview">Foto 2</label>

                    <input type="file"
                           class="form-control"
                           id="image2Interview"
                           name="image2Interview"
                           accept="image/*"
                    />
                    <p class="text-muted font-italic">Dimensões: 1000 x 800 pixels</p>

                    @if(isset($post) && $post->hasMedia('image2Interview'))
                        <img src="{{ $post->getFirstMediaUrl('image2Interview') }}"
                             class="img-thumbnail mb-2"
                             style="height: 100px;"
                             loading="lazy"
                        />
                    @endif
                </div>

                <div class="form-group">
                    <label for="attributes[text3]">Texto 3</label>
                    <textarea class="form-control richEditor {{ $errors->has('attributes.text3') ? 'is-invalid' : '' }}" name="attributes[text3]" id="attributes[text3]">{!! old('attributes.text3', $post->attributes->text3 ?? "") !!}</textarea>
                    @if($errors->has('attributes.text3'))
                        <div class="invalid-feedback">
                            {{ $errors->first('attributes.text3') }}
                        </div>
                    @endif
                </div>

                <div class="form-group">
                    <label class="required" for="attributes[editor]">{{ trans('cruds.post.fields.user') }}</label>
                    <input class="form-control {{ $errors->has('attributes.editor') ? 'is-invalid' : '' }}" type="text" name="attributes[editor]" id="attributes[editor]" value="{{ old('attributes.editor', $post->attributes->editor ?? "") }}" required>
                    @error('attributes.editor')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="required" for="published_at">{{ trans('cruds.post.fields.published_at') }}</label>
                    <input class="form-control {{ $errors->has('published_at') ? 'is-invalid' : '' }}"
                           type="datetime-local"
                           name="published_at" id="published_at"
                           value="{{ old('published_at', $post->published_at ?? date('Y-m-d\TH:i:s')) }}"
                           step="1"
                           required
                    />
                    @if($errors->has('published_at'))
                        <div class="invalid-feedback">
                            {{ $errors->first('published_at') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.post.fields.published_at_helper') }}</span>
                </div>

                <div class="form-group">
                    <label class="required" for="attributes[tags]">{{ trans('cruds.post.fields.tag') }}</label>
                    <input class="form-control {{ $errors->has('attributes.tags') ? 'is-invalid' : '' }}" type="text" name="attributes[tags]" id="attributes[tags]" value="{{ old('attributes.tags', $post->attributes->tags ?? "") }}" required>
                    @error('attributes.tags')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="required">{{ trans('cruds.post.fields.status') }}</label>
                    @foreach(App\Models\Post::STATUS_RADIO as $key => $label)
                        <div class="form-check {{ $errors->has('status') ? 'is-invalid' : '' }}">
                            <input class="form-check-input" type="radio" id="status_{{ $key }}" name="status" value="{{ $key }}" {{ old('status', $post->status ?? \App\Enums\StatusEnum::ACTIVE->name) === (string) $key ? 'checked' : '' }} required>
                            <label class="form-check-label" for="status_{{ $key }}">{{ $label }}</label>
                        </div>
                    @endforeach
                    @if($errors->has('status'))
                        <div class="invalid-feedback">
                            {{ $errors->first('status') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.post.fields.status_helper') }}</span>
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
        $(document).ready(function() {
            $('#tags').select2({
                minimumInputLength: 3,
                language: {
                    inputTooShort: function() {
                        return 'Digite 3 ou mais caracteres...';
                    },
                    noResults: function() {
                        return 'Nenhum resultado encontrado...';
                    },
                    searching: function() {
                        return 'Pesquisando...';
                    }
                },
                ajax: {
                    url: '{{ route('admin.content-tags.search') }}',
                    dataType: 'json',
                    data: function (params) {
                        return {
                            search: params.term
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: $.map(data, function (item) {
                                return {
                                    text: item.name,
                                    id: item.id
                                }
                            })
                        };
                    },
                    cache: true
                }
            });
        });
    </script>

    <script>
        let post = @json($post ?? null);

        if (post) {
            let tags = post.tags.map(tag => {
                $('#tags')
                    .append(new Option(tag.name, tag.id, true, true))
                    .trigger('change');
            });
        }
    </script>

    @include('partials.froalaEditor', [
        'crud_id' => isset($post) ? $post->id : 0,
        'model'   => "Post",
    ]);

    <script>
        $(document).on('click', '#selectImage', function (e) {
            e.preventDefault();
            window.open('{{ route('admin.images.selectImage') }}', '', 'height=800 width='+($(window).width() - 50)+', top=' + ($(window).height() / 2 - 275) + ', left=' + ($(window).width() / 2 - 225) + ', toolbar=0, location=0, menubar=0, directories=0, scrollbars=0');
        });
    </script>

    <script>
        window.addEventListener("message", function(event) {
            let selectedImages = event.data.selectedImages || [];

            if (selectedImages.length === 0) {
                return false;
            }

            if (event.data.source === 'selectImage') {
                $('#image_id').val(selectedImages[0].id);

                $('#image_featured')
                    .prop('src', selectedImages[0].imageUrl)
                    .removeClass('d-none');
            }

        }, false);
    </script>

    <script>
        $(document).on('change', '#featured_position', function() {
            const specialFeaturePosition = '{{ \App\Enums\FeaturedPositionPostEnum::SPECIAL_HIGHLIGHT->name }}';

            $('#div-imageFeaturedSpecialHighlight').toggleClass('d-none', $(this).val() !== specialFeaturePosition);
        });

        window.onload = function() {
            $('#featured_position').trigger('change');
        };
    </script>
@endsection
