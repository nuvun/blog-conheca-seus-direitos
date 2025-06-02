@extends('layouts.admin')

@section('content')

    @can('post_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route('admin.posts.create') }}">
                    {{ trans('global.add') }} {{ trans('cruds.post.title_singular') }}
                </a>
            </div>
        </div>
    @endcan

    <div class="card">
        <div class="card-header">
            {{ trans('cruds.post.title_singular') }} {{ trans('global.list') }}
        </div>

        <div class="card-body">
            <div class="mb-3">
                <form action="{{ route('admin.posts.index') }}">
                    <div class="form-row">
                        <div class="col">
                            <input type="text"
                                   name="filter[period]"
                                   value="{{ request('filter.period') }}"
                                   class="form-control"
                                   placeholder="Selecione o período"
                                   autocomplete="off"
                            />
                        </div>

                        <div class="col">
                            <input type="text"
                                   name="filter[term]"
                                   value="{{ request('filter.term') }}"
                                   class="form-control"
                                   placeholder="Digite o termo de busca"
                            />
                        </div>

                        <div class="col-auto">
                            <button type="submit" class="btn btn-primary mb-2">
                                <i class="fa fa-search"></i>
                                Filtrar
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>{{ trans('cruds.post.fields.image_featured') }}</th>
                            <th>{{ trans('cruds.post.fields.categories') }}</th>
                            <th>{{ trans('cruds.post.fields.title') }}</th>
                            <th>{{ trans('cruds.post.fields.published_at') }}</th>
                            <th>{{ trans('cruds.post.fields.status') }}</th>
                            <th></th>
                        </tr>

                        <form action="{{ route('admin.posts.index') }}">
                            <tr>
                                <td></td>
                                <td><input type="text" name="filter[category]" value="{{ request('filter.category') }}" placeholder="{{ trans('global.search') }}"></td>
                                <td><input type="text" name="filter[title]" value="{{ request('filter.title') }}" placeholder="{{ trans('global.search') }}"></td>
                                <td><input type="date" name="filter[published_at]" value="{{ request('filter.published_at') }}" placeholder="{{ trans('global.search') }}"></td>
                                <td>
                                    <select name="filter[status]"
                                            class="form-control-sm w-100"
                                            onchange="this.form.submit()"
                                    >
                                        <option value="">Selecione</option>
                                        @foreach(\App\Enums\StatusEnum::getDescriptions() as $status)
                                            <option value="{{ $status['value'] }}"
                                                @selected(request('filter.status') == $status['value'])
                                            >
                                                {{ $status['description'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td></td>
                            </tr>

                            <input type="submit" hidden />
                        </form>
                    </thead>
                    <tbody>
                        @foreach($posts as $key => $post)
                            <tr data-entry-id="{{ $post->id }}">
                                <td>
                                    @if(!empty($post->featuredImageUrl))
                                        <a href="{{ $post->featuredImageUrl }}" target="_blank" style="display: inline-block">
                                            <img src="{{ $post->featuredImageUrl }}"
                                                 style="width: 80px; height: 80px; object-fit: cover;"
                                                 loading="lazy"
                                            />
                                        </a>
                                    @endisset
                                </td>
                                <td>
                                    @foreach($post->categories as $key => $item)
                                        <span class="badge badge-info">{{ $item->name }}</span>
                                    @endforeach
                                </td>
                                <td>
                                    <p>{{ $post->title ?? '' }}</p>
                                    <p>
                                        {{ $post->views_count }} <em>visualizações</em>
                                    </p>
                                    <a href="{{ $post->url }}" target="_blank" title="Ver notícia">
                                        <i class="fa fa-external-link"></i>
                                        VER POST
                                    </a>
                                </td>
                                <td>
                                    {{ $post->published_at ? $post->published_at->format('d/m/Y H:i') : '' }}
                                </td>
                                <td>
                                    {{ $post->statusFormatted }}
                                </td>
                                <td>
                                    <div class="d-flex flex-column align-items-center" style="gap: 4px">
                                        @can('post_edit')
                                            <a class="btn btn-xs btn-info" href="{{ route('admin.posts.edit', $post->id) }}">
                                                {{ trans('global.edit') }}
                                            </a>
                                        @endcan

                                        @can('post_delete')
                                            <form action="{{ route('admin.posts.destroy', $post->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                                <input type="hidden" name="_method" value="DELETE">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                            </form>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="text-center">
                {{ $posts->links() }}
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.css" media="print" onload="this.media='all'" />
    <script>
        $(function() {
            let minDate     = moment().subtract(2, 'years');
            let end         = moment();
            let inputPeriod = $('input[name="filter[period]"]');

            inputPeriod.daterangepicker({
                autoUpdateInput: false,
                ranges: {
                    'Hoje': [moment(), moment()],
                    'Ontem': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Últimos 7 dias': [moment().subtract(6, 'days'), moment()],
                    'Últimos 30 dias': [moment().subtract(29, 'days'), moment()],
                    'Esse mês': [moment().startOf('month'), moment().endOf('month')],
                    'Tudo': [moment(minDate), moment(end)]
                },
                separator: ' até ',
                locale: {
                    format: 'DD/MM/YYYY',
                    applyLabel: 'Aplicar',
                    cancelLabel: 'Limpar',
                    fromLabel: 'De',
                    toLabel: 'Até',
                    customRangeLabel: 'Personalizado',
                    daysOfWeek: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb'],
                    monthNames: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
                    firstDay: 1
                }
            });

            inputPeriod.on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
            });

            inputPeriod.on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            });
        });
    </script>
@endsection
