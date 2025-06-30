<?php

namespace App\Http\Controllers;

use App\Models\Pnfs;
use Illuminate\Http\Request;
use App\Models\Trayectos;

class TrayectosController extends Controller
{
    public function index(Request $request)
    {
        $mostrarInactivas = $request->query('ver_inactivas', false);
        $trayectos = $mostrarInactivas ? Trayectos::all() : Trayectos::where('estatus', '1')->get();
        return view('trayectos.index', compact('trayectos', 'mostrarInactivas'));
    }

    public function create()
    {
        $pnfs = Pnfs::where('estatus', '1')->get(); // 🔥 Solo PNF activos
        return view('trayectos.create', compact('pnfs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'codigo' => 'required|string|size:2',
            'nombre' => 'required|string|max:100',
            'descripcion' => 'required|string|max:100',
            'fk_pnf' => 'required|exists:pnfs,id',
            // 🔥 Validación condicional: bloquea duplicados solo dentro del mismo PNF
            'codigo' => "unique:trayectos,codigo,NULL,id,nombre,{$request->nombre},fk_pnf,{$request->fk_pnf}",
            'nombre' => "unique:trayectos,nombre,NULL,id,codigo,{$request->codigo},fk_pnf,{$request->fk_pnf}"
        ]);


        Trayectos::create([
            'codigo' => $request->codigo,
            'nombre' => strtoupper($request->nombre),
            'descripcion' => strtoupper($request->descripcion),
            'estatus' => '1',
            'fk_pnf' => $request->fk_pnf
        ]);

        return redirect()->route('trayectos.index')->with('success', 'Trayecto creado correctamente');

    }

    public function edit(Trayectos $trayecto)
    {
        $pnfs = Pnfs::where('estatus', '1')->get();
        return view('trayectos.edit', compact('trayecto', 'pnfs'));
    }

    public function update(Request $request, Trayectos $trayecto)
    {
        $request->validate([
            'codigo' => "required|string|size:2|unique:trayectos,codigo,{$trayecto->id},id,nombre,{$request->nombre},fk_pnf,{$request->fk_pnf}",
            'nombre' => "required|string|max:100|unique:trayectos,nombre,{$trayecto->id},id,codigo,{$request->codigo},fk_pnf,{$request->fk_pnf}",
            'descripcion' => 'required|string|max:100',
            'estatus' => 'required|in:0,1',
            'fk_pnf' => 'required|exists:pnfs,id',
        ]);

        $trayecto->update([
            'codigo' => $request->codigo,
            'nombre' => strtoupper($request->nombre),
            'descripcion' => strtoupper($request->descripcion),
            'estatus' => $request->estatus,
            'fk_pnf' => $request->fk_pnf,
        ]);

        return redirect()->route('trayectos.index')->with('success', 'Trayecto actualizado correctamente');
    }

    public function destroy(Trayectos $trayecto)
    {
        $trayecto->desactivar(); // 🔥 Eliminación lógica
        return redirect()->route('trayectos.index')->with('success', 'Trayecto inactivado correctamente');
    }
}
