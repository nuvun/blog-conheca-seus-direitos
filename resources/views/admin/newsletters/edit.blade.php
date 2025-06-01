@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.newsletter.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.newsletters.update", [$newsletter->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.newsletter.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $newsletter->name) }}" required>
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.newsletter.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="email">{{ trans('cruds.newsletter.fields.email') }}</label>
                <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="email" name="email" id="email" value="{{ old('email', $newsletter->email) }}">
                @if($errors->has('email'))
                    <div class="invalid-feedback">
                        {{ $errors->first('email') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.newsletter.fields.email_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="phone_number">{{ trans('cruds.newsletter.fields.phone_number') }}</label>
                <input class="form-control {{ $errors->has('phone_number') ? 'is-invalid' : '' }}" type="text" name="phone_number" id="phone_number" value="{{ old('phone_number', $newsletter->phone_number) }}">
                @if($errors->has('phone_number'))
                    <div class="invalid-feedback">
                        {{ $errors->first('phone_number') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.newsletter.fields.phone_number_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="document_number">{{ trans('cruds.newsletter.fields.document_number') }}</label>
                <input class="form-control {{ $errors->has('document_number') ? 'is-invalid' : '' }}" type="text" name="document_number" id="document_number" value="{{ old('document_number', $newsletter->document_number) }}">
                @if($errors->has('document_number'))
                    <div class="invalid-feedback">
                        {{ $errors->first('document_number') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.newsletter.fields.document_number_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="interest">{{ trans('cruds.newsletter.fields.interest') }}</label>
                <input class="form-control {{ $errors->has('interest') ? 'is-invalid' : '' }}" type="text" name="interest" id="interest" value="{{ old('interest', $newsletter->interest) }}">
                @if($errors->has('interest'))
                    <div class="invalid-feedback">
                        {{ $errors->first('interest') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.newsletter.fields.interest_helper') }}</span>
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