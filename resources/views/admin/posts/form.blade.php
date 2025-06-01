@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">
            Salvar {{ trans('cruds.post.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST"
                  action="{{ isset($post) ? route("admin.posts.update", [$post->id]) :  route("admin.posts.store") }}"
                  enctype="multipart/form-data"
            >
                @method(isset($post) ? 'PUT' : 'POST')
                @csrf

                <div class="form-group">
                    <label class="required" for="categories">{{ trans('cruds.post.fields.categories') }}</label>
                    <select class="form-control select2 {{ $errors->has('categories') ? 'is-invalid' : '' }}" name="categories[]" id="categories" multiple required>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}"
                                data-typeCategory="{{ $category->type_category->name }}"
                                @selected((in_array($category->id, old('categories', [])) || isset($post) && $post->categories->contains($category->id)))
                            >
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @if($errors->has('categories'))
                        <div class="invalid-feedback">
                            {{ $errors->first('categories') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.post.fields.categories_helper') }}</span>
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
                        <img src="{{ $post->getMedia('image_featured')->last()->getUrl() }}"
                             class="img-thumbnail mb-2"
                             style="height: 100px;"
                             loading="lazy"
                        />
                    @endif
                </div>

                <div class="form-group">
                    <label for="content">{{ trans('cruds.post.fields.content') }}</label>
                    <textarea class="form-control richEditor {{ $errors->has('content') ? 'is-invalid' : '' }}" name="content" id="content">{!! old('content', $post->content ?? "") !!}</textarea>
                    @if($errors->has('content'))
                        <div class="invalid-feedback">
                            {{ $errors->first('content') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.post.fields.content_helper') }}</span>
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
                    <label class="required">{{ trans('cruds.post.fields.status') }}</label>
                    @foreach (\App\Enums\StatusEnum::getDescriptions() as $key => $item)
                        <div class="form-check {{ $errors->has('status') ? 'is-invalid' : '' }}">
                            <input class="form-check-input" type="radio" id="status_{{ $item['value'] }}"
                                   name="status"
                                   value="{{ $item['value'] }}"
                                   {{ old('status', $post->status ?? \App\Enums\StatusEnum::ACTIVE->value) === $item['value'] ? 'checked' : '' }}
                                   required
                            />
                            <label class="form-check-label" for="status_{{ $item['value'] }}">
                                {{ $item['description'] }}
                            </label>
                        </div>
                    @endforeach
                    @if ($errors->has('status'))
                        <div class="invalid-feedback">
                            {{ $errors->first('status') }}
                        </div>
                    @endif
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
@endsection
