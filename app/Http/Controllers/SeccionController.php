<?php

namespace App\Http\Controllers;

use App\Models\Seccion;
use App\Models\Pnfs;
use App\Models\Trayectos;
use App\Models\UnidadCurricular;
use Illuminate\Http\Request;

class SeccionController extends Controller
{
    public function getUnidadesPorTrayecto($pnfId, $trayectoId)
{
    $unidades = UnidadCurricular::where('fk_pnf', $pnfId)
        ->where('fk_trayecto', $trayectoId)
        ->get();

    return response()->json($unidades);
}

    public function index(Request $request)
    {
        $mostrarInactivas = $request->query('ver_inactivas', false);
        $filterPnf = $request->query('filter_pnf');
        $filterTrayecto = $request->query('filter_trayecto');

        $pnfs = Pnfs::all();
        $trayectos = $filterPnf 
            ? Trayectos::where('fk_pnf', $filterPnf)->get()
            : Trayectos::all();

        $secciones = Seccion::with(['pnf', 'trayecto', 'unidadCurricular'])
            ->when(!$mostrarInactivas, function ($query) {
                $query->where('estatus', '1');
            })
            ->when($filterPnf, function ($query, $filterPnf) {
                $query->where('fk_pnf', $filterPnf);
            })
            ->when($filterTrayecto, function ($query, $filterTrayecto) {
                $query->where('fk_trayecto', $filterTrayecto);
            })
            ->get();

        return view('secciones.index', compact('secciones', 'pnfs', 'trayectos', 'mostrarInactivas', 'filterPnf'));
    }

    public function create()
    {
        $pnfs = Pnfs::where('estatus', '1')->get();
        $trayectos = Trayectos::where('estatus', '1')->get();
        $unidadesCurriculares = UnidadCurricular::where('estatus', '1')->get();
        return view('secciones.create', compact('pnfs', 'trayectos', 'unidadesCurriculares'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|size:3|unique:secciones,nombre',
            'cantidad_alumnos' => 'required|integer|min:1',
            'fk_pnf' => 'required|exists:pnfs,id',
            'fk_trayecto' => 'required|exists:trayectos,id',
            'fk_unidad_curricular' => 'required|exists:unidad_curricular,id',
        ]);

        $codigo = $request->fk_pnf . $request->fk_trayecto . $request->nombre . '-' . $request->fk_unidad_curricular;

        Seccion::create([
            'nombre' => $request->nombre,
            'codigo' => $codigo,
            'cantidad_alumnos' => $request->cantidad_alumnos,
            'fk_pnf' => $request->fk_pnf,
            'fk_trayecto' => $request->fk_trayecto,
            'fk_unidad_curricular' => $request->fk_unidad_curricular,
            'estatus' => '1'
        ]);

        return redirect()->route('secciones.index')->with('success', 'Sección creada correctamente');
    }

    public function edit(Seccion $seccion)
    {
        $pnfs = Pnfs::where('estatus', '1')->get();
        $trayectos = Trayectos::where('estatus', '1')->get();
        $unidadesCurriculares = UnidadCurricular::where('estatus', '1')->get();
        return view('secciones.edit', compact('seccion', 'pnfs', 'trayectos', 'unidadesCurriculares'));
    }

    public function update(Request $request, Seccion $seccion)
    {
        $request->validate([
            'nombre' => "required|string|size:3|unique:secciones,nombre,{$seccion->id}",
            'cantidad_alumnos' => 'required|integer|min:1',
            'fk_pnf' => 'required|exists:pnfs,id',
            'fk_trayecto' => 'required|exists:trayectos,id',
            'fk_unidad_curricular' => 'required|exists:unidad_curricular,id',
            'estatus' => 'required|in:0,1',
        ]);

        $codigo = $request->fk_pnf . $request->fk_trayecto . $request->nombre . '-' . $request->fk_unidad_curricular;

        $seccion->update([
            'nombre' => $request->nombre,
            'codigo' => $codigo,
            'cantidad_alumnos' => $request->cantidad_alumnos,
            'fk_pnf' => $request->fk_pnf,
            'fk_trayecto' => $request->fk_trayecto,
            'fk_unidad_curricular' => $request->fk_unidad_curricular,
            'estatus' => $request->estatus
        ]);

        return redirect()->route('secciones.index')->with('success', 'Sección actualizada correctamente');
    }

    public function destroy(Seccion $seccion)
    {
        $seccion->desactivar();
        return redirect()->route('secciones.index')->with('success', 'Sección inactivada correctamente');
    }
}
