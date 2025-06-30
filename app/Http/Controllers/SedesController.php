<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sedes;

class SedesController extends Controller
{
    public function index(Request $request)
    {
        $mostrarInactivas = $request->query('ver_inactivas', false);
        $sedes = $mostrarInactivas
            ? Sedes::orderBy('codigo', 'asc')->get()
            : Sedes::where('estatus', '1')->orderBy('codigo', 'asc')->get();
        return view('sedes.index', compact('sedes', 'mostrarInactivas'));
    }

    public function create()
    {
        return view('sedes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'codigo' => 'required|string|size:2|unique:sedes,codigo',
            'nombre' => 'required|string|max:100|unique:sedes,nombre',
            'descripcion' => 'required|string|max:100',
        ]);

        Sedes::create([
            'codigo' => strtoupper($request->codigo),
            'nombre' => strtoupper($request->nombre),
            'descripcion' => strtoupper($request->descripcion),
            'estatus' => '1', // 🔥 Se asigna automáticamente como activo
        ]);

        return redirect()->route('sedes.index')->with('success', 'Sede creada correctamente');
    }

    public function edit(Sedes $sede)
    {
        return view('sedes.edit', compact('sede'));
    }

    public function update(Request $request, Sedes $sede)
    {
        $request->validate([
            'codigo' => "required|string|size:2|unique:sedes,codigo,{$sede->id}",
            'nombre' => "required|string|max:100|unique:sedes,nombre,{$sede->id}",
            'descripcion' => 'required|string|max:100',
            'estatus' => 'required|in:0,1',
        ]);

        $sede->update([
            'codigo' => strtoupper($request->codigo),
            'nombre' => strtoupper($request->nombre),
            'descripcion' => strtoupper($request->descripcion),
            'estatus' => $request->estatus,
        ]);

        return redirect()->route('sedes.index')->with('success', 'Sede actualizada correctamente');
    }

    public function destroy(Sedes $sede)
    {
        $sede->desactivar(); // 🔥 Eliminación lógica
        return redirect()->route('sedes.index')->with('success', 'Sede inactivada correctamente');
    }
}
