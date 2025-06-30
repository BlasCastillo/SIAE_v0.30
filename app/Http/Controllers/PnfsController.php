<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pnfs;

class PnfsController extends Controller
{
    public function index(Request $request)
    {
        $mostrarInactivas = $request->query('ver_inactivas', false);
        $pnfs = $mostrarInactivas
            ? Pnfs::orderBy('codigo', 'asc')->get()
            : Pnfs::where('estatus', '1')->orderBy('codigo', 'asc')->get();
        return view('pnfs.index', compact('pnfs', 'mostrarInactivas'));
    }

    public function create()
    {
        return view('pnfs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'codigo' => 'required|string|size:2|unique:pnfs',
            'nombre' => 'required|string|max:100|unique:pnfs,nombre',
            'descripcion' => 'required|string|max:100',
        ]);

        Pnfs::create([
            'codigo' => $request->codigo,
            'nombre' => strtoupper($request->nombre),
            'descripcion' => strtoupper($request->descripcion),
            'estatus' => '1', // 🔥 Se asigna automáticamente como activo
        ]);

        return redirect()->route('pnfs.index')->with('success', 'PNF creado correctamente');
    }


    public function edit(Pnfs $pnf)
    {
        return view('pnfs.edit', compact('pnf'));
    }

    public function update(Request $request, Pnfs $pnf)
    {
        $request->validate([
            'codigo' => "required|string|size:2|unique:pnfs,codigo,{$pnf->id}",
            'nombre' => "required|string|max:100|unique:pnfs,nombre,{$pnf->id}",
            'descripcion' => 'required|string|max:100',
            'estatus' => 'required|in:0,1',
        ]);

        $pnf->update([
            'codigo' => $request->codigo,
            'nombre' => strtoupper($request->nombre),
            'descripcion' => strtoupper($request->descripcion),
            'estatus' => $request->estatus,
        ]);

        return redirect()->route('pnfs.index')->with('success', 'PNF actualizado correctamente');
    }


    public function destroy(Pnfs $pnf)
    {
        $pnf->desactivar(); // 🔥 Eliminación lógica
        return redirect()->route('pnfs.index')->with('success', 'PNF inactivado correctamente');
    }
}
