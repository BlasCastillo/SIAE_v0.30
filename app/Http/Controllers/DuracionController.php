<?php

namespace App\Http\Controllers;

use App\Models\Duracion;
use Illuminate\Http\Request;

class DuracionController extends Controller
{
    public function index(Request $request)
    {
        $mostrarInactivas = $request->query('ver_inactivas', false);
        $duraciones = $mostrarInactivas ? Duracion::all() : Duracion::where('estatus', '1')->get();
        return view('duraciones.index', compact('duraciones', 'mostrarInactivas'));
    }

    public function create()
    {
        return view('duraciones.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100|unique:duraciones',
            'descripcion' => 'required|string|max:100',
        ]);

        Duracion::create([
            'nombre' => strtoupper($request->nombre),
            'descripcion' => strtoupper($request->descripcion),
            'estatus' => '1'
        ]);

        return redirect()->route('duraciones.index')->with('success', 'Duración creada correctamente');
    }

    public function edit(Duracion $duracion)
    {
        return view('duraciones.edit', compact('duracion'));
    }

    public function update(Request $request, Duracion $duracion)
    {
        $request->validate([
            'nombre' => "required|string|max:100|unique:duraciones,nombre,{$duracion->id}",
            'descripcion' => 'required|string|max:100',
            'estatus' => 'required|in:0,1',
        ]);

        $duracion->update([
            'nombre' => strtoupper($request->nombre),
            'descripcion' => strtoupper($request->descripcion),
            'estatus' => $request->estatus,
        ]);

        return redirect()->route('duraciones.index')->with('success', 'Duración actualizada correctamente');
    }

    public function destroy(Duracion $duracion)
    {
        $duracion->desactivar();
        return redirect()->route('duraciones.index')->with('success', 'Duración inactivada correctamente');
    }
}
