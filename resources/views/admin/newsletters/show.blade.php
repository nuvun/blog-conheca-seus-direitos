@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.newsletter.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.newsletters.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.newsletter.fields.id') }}
                        </th>
                        <td>
                            {{ $newsletter->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.newsletter.fields.name') }}
                        </th>
                        <td>
                            {{ $newsletter->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.newsletter.fields.email') }}
                        </th>
                        <td>
                            {{ $newsletter->email }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.newsletter.fields.phone_number') }}
                        </th>
                        <td>
                            {{ $newsletter->phone_number }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.newsletter.fields.document_number') }}
                        </th>
                        <td>
                            {{ $newsletter->document_number }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.newsletter.fields.interest') }}
                        </th>
                        <td>
                            {{ $newsletter->interest }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.newsletters.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection