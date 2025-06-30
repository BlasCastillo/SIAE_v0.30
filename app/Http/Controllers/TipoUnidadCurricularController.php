<?php

namespace App\Http\Controllers;

use App\Models\TipoUnidadCurricular;
use Illuminate\Http\Request;

class TipoUnidadCurricularController extends Controller
{
    public function index(Request $request)
    {
        $mostrarInactivas = $request->query('ver_inactivas', false);
        $tipoUnidadesCurriculares = $mostrarInactivas ? TipoUnidadCurricular::all() : TipoUnidadCurricular::where('estatus', '1')->get();
        return view('tipo_unidad_curricular.index', compact('tipoUnidadesCurriculares', 'mostrarInactivas'));
    }

    public function create()
    {
        return view('tipo_unidad_curricular.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100|unique:tipo_unidad_curricular',
            'descripcion' => 'required|string|max:100',
        ]);

        TipoUnidadCurricular::create([
            'nombre' => strtoupper($request->nombre),
            'descripcion' => strtoupper($request->descripcion),
            'estatus' => '1' // 🔥 Se crea como activo
        ]);

        return redirect()->route('tipo_unidad_curricular.index')->with('success', 'Tipo de Unidad Curricular creada correctamente');
    }

    public function edit(TipoUnidadCurricular $tipoUnidadCurricular)
    {
        return view('tipo_unidad_curricular.edit', compact('tipoUnidadCurricular'));
    }

    public function update(Request $request, TipoUnidadCurricular $tipoUnidadCurricular)
    {
        $request->validate([
            'nombre' => "required|string|max:100|unique:tipo_unidad_curricular,nombre,{$tipoUnidadCurricular->id}",
            'descripcion' => 'required|string|max:100',
            'estatus' => 'required|in:0,1',
        ]);

        $tipoUnidadCurricular->update([
            'nombre' => strtoupper($request->nombre),
            'descripcion' => strtoupper($request->descripcion),
            'estatus' => $request->estatus
        ]);

        return redirect()->route('tipo_unidad_curricular.index')->with('success', 'Tipo de Unidad Curricular actualizada correctamente');
    }

    public function destroy(TipoUnidadCurricular $tipoUnidadCurricular)
    {
        $tipoUnidadCurricular->desactivar(); // 🔥 Eliminación lógica
        return redirect()->route('tipo_unidad_curricular.index')->with('success', 'Tipo de Unidad Curricular inactivada correctamente');
    }
}

