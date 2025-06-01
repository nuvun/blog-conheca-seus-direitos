@extends('layouts.admin')

@section('content')
    @can('state_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route('admin.states.create') }}">
                    {{ trans('global.add') }} {{ trans('cruds.state.title_singular') }}
                </a>
            </div>
        </div>
    @endcan

    <div class="card">
        <div class="card-header">
            {{ trans('cruds.state.title_singular') }} {{ trans('global.list') }}
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-State">
                    <thead>
                        <tr>
                            <th>{{ trans('cruds.state.fields.name') }}</th>
                            <th>{{ trans('cruds.state.fields.uf') }}</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($states as $key => $state)
                            <tr data-entry-id="{{ $state->id }}">
                                <td>{{ $state->name ?? '' }}</td>
                                <td>{{ $state->uf ?? '' }}</td>
                                <td>
                                    @can('state_show')
                                        <a class="btn btn-xs btn-primary" href="{{ route('admin.states.show', $state->id) }}">
                                            {{ trans('global.view') }}
                                        </a>
                                    @endcan

                                    @can('state_edit')
                                        <a class="btn btn-xs btn-info" href="{{ route('admin.states.edit', $state->id) }}">
                                            {{ trans('global.edit') }}
                                        </a>
                                    @endcan

                                    @can('state_delete')
                                        <form action="{{ route('admin.states.destroy', $state->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                        </form>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
