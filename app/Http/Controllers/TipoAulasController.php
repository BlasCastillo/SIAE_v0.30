<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TipoAulas;
use App\Models\Aulas;


class TipoAulasController extends Controller
{
    public function index(Request $request)
    {
        $mostrarInactivas = $request->query('ver_inactivas', false);
        $tipoAulas = $mostrarInactivas ? TipoAulas::all() : TipoAulas::where('estatus', '1')->get();
        return view('tipo-aulas.index', compact('tipoAulas', 'mostrarInactivas'));
    }

    public function create()
    {
        return view('tipo-aulas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100|unique:tipo_aulas',
            'descripcion' => 'required|string|max:100',
        ]);

        TipoAulas::create([
            'nombre' => strtoupper($request->nombre),
            'descripcion' => strtoupper($request->descripcion),
            'estatus' => '1' // 🔥 Se crea como activo
        ]);

        return redirect()->route('tipo-aulas.index')->with('success', 'Tipo de aula creada correctamente');
    }

    public function edit(TipoAulas $tipoAula)
    {
        return view('tipo-aulas.edit', compact('tipoAula'));
    }

    public function update(Request $request, TipoAulas $tipoAula)
    {
        $request->validate([
            'nombre' => "required|string|max:100|unique:tipo_aulas,nombre,{$tipoAula->id}",
            'descripcion' => 'required|string|max:100',
            'estatus' => 'required|in:0,1',
        ]);

        $tipoAula->update([
            'nombre' => strtoupper($request->nombre),
            'descripcion' => strtoupper($request->descripcion),
            'estatus' => $request->estatus
        ]);

        return redirect()->route('tipo-aulas.index')->with('success', 'Tipo de aula actualizado correctamente');
    }

    public function destroy(TipoAulas $tipoAula)
    {
        $tipoAula->desactivar(); // 🔥 Eliminación lógica
        return redirect()->route('tipo-aulas.index')->with('success', 'Tipo de aula inactivada correctamente');
    }
}
