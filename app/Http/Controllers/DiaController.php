<?php

namespace App\Http\Controllers;

use App\Models\Dia;
use Illuminate\Http\Request;

class DiaController extends Controller
{
    public function index(Request $request)
    {
        $mostrarInactivos = $request->query('ver_inactivos', false);
        $dias = $mostrarInactivos
            ? Dia::orderBy('valor', 'asc')->get()
            : Dia::where('estatus', '1')->orderBy('valor', 'asc')->get();
        return view('dias.index', compact('dias', 'mostrarInactivos'));
    }

    public function create()
    {
        return view('dias.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:10|unique:dias',
            'valor' => 'required|integer|unique:dias',
        ]);

        Dia::create([
            'nombre' => strtoupper($request->nombre),
            'valor' => $request->valor,
            'estatus' => '1',
        ]);

        return redirect()->route('dias.index')->with('success', 'Día creado correctamente');
    }

    public function edit(Dia $dia)
    {
        return view('dias.edit', compact('dia'));
    }

    public function update(Request $request, Dia $dia)
    {
        $request->validate([
            'nombre' => "required|string|max:10|unique:dias,nombre,{$dia->id}",
            'valor' => "required|integer|unique:dias,valor,{$dia->id}",
            'estatus' => 'required|in:0,1',
        ]);

        $dia->update([
            'nombre' => strtoupper($request->nombre),
            'valor' => $request->valor,
            'estatus' => $request->estatus,
        ]);

        return redirect()->route('dias.index')->with('success', 'Día actualizado correctamente');
    }

    public function destroy(Dia $dia)
    {
        $dia->desactivar();
        return redirect()->route('dias.index')->with('success', 'Día inactivado correctamente');
    }
}
