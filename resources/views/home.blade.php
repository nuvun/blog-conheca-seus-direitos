@extends('layouts.admin')

@section('content')
    <div class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        Dashboard
                    </div>

                    <div class="card-body">

                        @if(session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <div class="mb-3">
                            <form action="">
                                <div class="form-row">
                                    <div class="col">
                                        <input type="text"
                                               name="filter[period]"
                                               value="{{ request('filter.period', $inputPeriod) }}"
                                               class="form-control"
                                               placeholder="Selecione o período"
                                               autocomplete="off"
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

                            <hr />
                        </div>

                        <div class="row">
                            <div class="col-xl-4 col-md-6">
                                <div class="card border-left-primary shadow">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Publicações</div>
                                                <div class="h2 mb-0 font-weight-bold text-gray-800">{{ $totalPosts }}</div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="far fa-newspaper fa-3x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-6">
                                <div class="card border-left-primary shadow">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Acessos</div>
                                                <div class="h2 mb-0 font-weight-bold text-gray-800">{{ $totalViewsPosts }}</div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="far fa-eye fa-3x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-6">
                                <div class="card border-left-primary shadow">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Média de Visitas</div>
                                                <div class="h2 mb-0 font-weight-bold text-gray-800">{{ $avgViewsPosts }}</div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-calculator fa-3x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-6">
                                <div class="card border-left-success shadow">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Mais Lida</div>
                                                <div class="h2 mb-0 font-weight-bold text-gray-800">{{ $totalViewsPostMostViewed }}</div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-rocket fa-3x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-6">
                                <div class="card border-left-danger shadow">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Menos Lida</div>
                                                <div class="h2 mb-0 font-weight-bold text-gray-800">{{ $totalViewsPostLessViewed }}</div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="far fa-thumbs-down fa-3x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-6">
                                <div class="card border-left-success shadow">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                    Campeã(o)
                                                </div>
                                                <div class="h2 mb-0 font-weight-bold text-gray-800">
                                                    {{ $userPostMostViewed }}
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-user fa-3x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-lg-12 mb-4">
                                <div class="card shadow mb-4">
                                    <div class="card-header py-3 position-relative">
                                        <h5 class="m-0 font-weight-bold">
                                            <i class="fas fa-rocket"></i> Mais lidas
                                        </h5>
                                    </div>
                                    <div class="card-body table-responsive">
                                        <table class="table table-striped">
                                            <thead class="text-center">
                                                <tr>
                                                    <th scope="col"><i class="fas fa-list-ol"></i></th>
                                                    <th scope="col" class="text-left">Título</th>
                                                    <th scope="col"><i class="far fa-clock"></i></th>
                                                    <th scope="col"><i class="far fa-user"></i></th>
                                                    <th scope="col"><i class="far fa-eye"></i></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($mostViewedPosts as $post)
                                                    <tr class="text-center">
                                                        <th scope="row" class="align-middle">{{ $loop->iteration }}º</th>
                                                        <td nowrap="" class="align-middle text-left">{{ $post->title }}</td>
                                                        <td class="align-middle small">
                                                            {{ $post->published_at->diffForHumans() }}
                                                        </td>
                                                        <td class="align-middle small">
                                                            {{ $post->users->implode('name', ', ') }}
                                                        </td>
                                                        <td class="align-middle" nowrap="">
                                                            {{ $post->total_views }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <livewire:admin.reports.views-posts-by-user :input-period="$inputPeriod" />

                            <livewire:admin.reports.categories-most-viewed :input-period="$inputPeriod" />
                        </div>
                    </div>
                </div>
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
