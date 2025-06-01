@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('global.edit') }} {{ trans('cruds.contentCategory.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST"
                  action="{{ isset($contentCategory) ? route("admin.content-categories.update", [$contentCategory->id]) :  route("admin.content-categories.store") }}"
                  enctype="multipart/form-data"
            >
                @method(isset($contentCategory) ? 'PUT' : 'POST')
                @csrf

                <div class="form-group">
                    <label class="required" for="type_category_id">{{ trans('cruds.contentCategory.fields.type_category') }}</label>
                    <select class="form-control select2 {{ $errors->has('type_category') ? 'is-invalid' : '' }}" name="type_category_id" id="type_category_id" required>
                        @foreach($type_categories as $id => $entry)
                            <option value="{{ $id }}" {{ (old('type_category_id') ? old('type_category_id') : $contentCategory?->type_category?->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('type_category'))
                        <div class="invalid-feedback">
                            {{ $errors->first('type_category') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.contentCategory.fields.type_category_helper') }}</span>
                </div>

                <div class="form-group">
                    <label class="required" for="name">{{ trans('cruds.contentCategory.fields.name') }}</label>
                    <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $contentCategory->name ?? "") }}" required>
                    @if($errors->has('name'))
                        <div class="invalid-feedback">
                            {{ $errors->first('name') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.contentCategory.fields.name_helper') }}</span>
                </div>

                <div class="form-group">
                    <label class="required" for="name">{{ trans('cruds.contentCategory.fields.description') }}</label>
                    <textarea class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description" id="description" required>{{ old('description', $contentCategory->description ?? "") }}</textarea>
                    @if($errors->has('description'))
                        <div class="invalid-feedback">
                            {{ $errors->first('description') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.contentCategory.fields.description_helper') }}</span>
                </div>

                <div class="form-group">
                    <label class="" for="photo">Foto</label>
                    <input type="file"
                           class="form-control"
                           name="photo" id="photo"
                           accept="image/*"
                    />

                    @if(isset($contentCategory) && $contentCategory->getMedia('photo')->count())
                        <p class="mt-2">
                            <a href="{{ $contentCategory->photo->url }}" target="_blank">
                                <img src="{{ $contentCategory->photo->url }}"
                                     alt="Foto"
                                     style="width: 120px; height: 120px; object-fit: cover;"
                                     loading="lazy"
                                />
                            </a>
                        </p>
                    @endif
                </div>

                <div class="form-group">
                    <label>{{ trans('cruds.contentCategory.fields.status') }}</label>
                    @foreach(App\Models\ContentCategory::STATUS_RADIO as $key => $label)
                        <div class="form-check {{ $errors->has('status') ? 'is-invalid' : '' }}">
                            <input class="form-check-input" type="radio" id="status_{{ $key }}" name="status" value="{{ $key }}" {{ old('status', $contentCategory->status ?? 'active') === (string) $key ? 'checked' : '' }}>
                            <label class="form-check-label" for="status_{{ $key }}">{{ $label }}</label>
                        </div>
                    @endforeach
                    @if($errors->has('status'))
                        <div class="invalid-feedback">
                            {{ $errors->first('status') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.contentCategory.fields.status_helper') }}</span>
                </div>

                <div class="form-group">
                    <label>Aparecer no formulário de cadastro de notícia?</label>
                    @foreach(App\Models\ContentCategory::STATUS_RADIO as $key => $label)
                        <div class="form-check {{ $errors->has('attributes.showOnFormNews') ? 'is-invalid' : '' }}">
                            <input class="form-check-input"
                                   type="radio"
                                   id="showOnFormNews_{{ $key }}"
                                   name="attributes[showOnFormNews]"
                                   value="{{ $key }}"
                                {{ old('attributes.showOnFormNews', $contentCategory->attributes->showOnFormNews ?? 'active') === (string) $key ? 'checked' : '' }}
                            >
                            <label class="form-check-label" for="showOnFormNews_{{ $key }}">{{ $label }}</label>
                        </div>
                    @endforeach
                    @if($errors->has('attributes.showOnFormNews'))
                        <div class="invalid-feedback">
                            {{ $errors->first('showOnFormNews') }}
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
