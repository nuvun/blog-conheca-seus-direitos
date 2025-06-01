<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyRelatorioRequest;
use App\Http\Requests\StoreRelatorioRequest;
use App\Http\Requests\UpdateRelatorioRequest;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RelatoriosController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('relatorio_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.relatorios.index');
    }

    public function create()
    {
        abort_if(Gate::denies('relatorio_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.relatorios.create');
    }

    public function store(StoreRelatorioRequest $request)
    {
        $relatorio = Relatorio::create($request->all());

        return redirect()->route('admin.relatorios.index');
    }

    public function edit(Relatorio $relatorio)
    {
        abort_if(Gate::denies('relatorio_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.relatorios.edit', compact('relatorio'));
    }

    public function update(UpdateRelatorioRequest $request, Relatorio $relatorio)
    {
        $relatorio->update($request->all());

        return redirect()->route('admin.relatorios.index');
    }

    public function show(Relatorio $relatorio)
    {
        abort_if(Gate::denies('relatorio_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.relatorios.show', compact('relatorio'));
    }

    public function destroy(Relatorio $relatorio)
    {
        abort_if(Gate::denies('relatorio_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $relatorio->delete();

        return back();
    }

    public function massDestroy(MassDestroyRelatorioRequest $request)
    {
        $relatorios = Relatorio::find(request('ids'));

        foreach ($relatorios as $relatorio) {
            $relatorio->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
