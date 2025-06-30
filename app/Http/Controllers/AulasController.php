<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Aulas;
use App\Models\TipoAulas;

class AulasController extends Controller
{
    public function index(Request $request)
    {
        $mostrarInactivas = $request->query('ver_inactivas', false);
        $aulas = $mostrarInactivas ? Aulas::all() : Aulas::where('estatus', '1')->get();
        return view('aulas.index', compact('aulas', 'mostrarInactivas'));
    }

    public function show(Aulas $aula)
    {
        return view('aulas.show', compact('aula'));
    }

    public function create()
    {
        $tipoAulas = TipoAulas::where('estatus', '1')->get(); // 🔥 Solo tipos de aula activos
        return view('aulas.create', compact('tipoAulas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100|unique:aulas',
            'descripcion' => 'required|string|max:100',
            'cantidad' => 'required|integer|min:20',
            'fk_tipo_aulas' => 'required|exists:tipo_aulas,id',
        ]);

        Aulas::create([
            'nombre' => strtoupper($request->nombre),
            'descripcion' => strtoupper($request->descripcion),
            'cantidad' => $request->cantidad,
            'estatus' => '1', // 🔥 Se crea como activo
            'fk_tipo_aulas' => $request->fk_tipo_aulas
        ]);

        return redirect()->route('aulas.index')->with('success', 'Aula creada correctamente');
    }

    public function edit(Aulas $aula)
    {
        $tipoAulas = TipoAulas::where('estatus', '1')->get();
        return view('aulas.edit', compact('aula', 'tipoAulas'));
    }

    public function update(Request $request, Aulas $aula)
    {
        $request->validate([
            'nombre' => "required|string|max:100|unique:aulas,nombre,{$aula->id}",
            'descripcion' => 'required|string|max:100',
            'cantidad' => 'required|integer|min:20',
            'estatus' => 'required|in:0,1',
            'fk_tipo_aulas' => 'required|exists:tipo_aulas,id',
        ]);

        $aula->update([
            'nombre' => strtoupper($request->nombre),
            'descripcion' => strtoupper($request->descripcion),
            'cantidad' => $request->cantidad,
            'estatus' => $request->estatus,
            'fk_tipo_aulas' => $request->fk_tipo_aulas,
        ]);

        return redirect()->route('aulas.index')->with('success', 'Aula actualizada correctamente');
    }

    public function destroy(Aulas $aula)
    {
        $aula->desactivar(); // 🔥 Eliminación lógica
        return redirect()->route('aulas.index')->with('success', 'Aula inactivada correctamente');
    }
}
