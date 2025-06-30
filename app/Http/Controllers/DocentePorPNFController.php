<?php

namespace App\Http\Controllers;

use App\Models\DocentePorPNF;
use App\Models\User;
use App\Models\Pnfs;
use Illuminate\Http\Request;

class DocentePorPNFController extends Controller
{
    public function index(Request $request)
{
    // Filtrar por PNF si se especifica
    $filterPnf = $request->query('filter_pnf');

    // Agrupar PNFs por docente
    $docentesPorPNF = DocentePorPNF::with(['user', 'pnf'])
        ->when($filterPnf, function ($query, $filterPnf) {
            $query->where('pnf_id', $filterPnf);
        })
        ->get()
        ->groupBy('user.name'); // Agrupar por nombre del docente

    $pnfs = Pnfs::all();

    return view('docentesporpnf.index', compact('docentesPorPNF', 'pnfs', 'filterPnf'));
}

    public function create()
{
    // Usamos whereHas para filtrar por roles correctamente
    $docentes = User::whereHas('roles', function ($query) {
        $query->whereIn('name', ['DOCENTE', 'COORDINADOR', 'DIRECTOR']);
    })->get();

    // Obtener solo los PNF activos
    $pnfs = Pnfs::where('estatus', true)->get();

    return view('docentesporpnf.create', compact('docentes', 'pnfs'));
}

public function store(Request $request)
{
    $request->validate([
        'user_id' => 'required|exists:users,id',
        'pnf_id' => 'required|array', // Validar que sea un array
        'pnf_id.*' => 'exists:pnfs,id', // Validar que cada elemento del array existe en la tabla PNFs
    ]);

    foreach ($request->pnf_id as $pnfId) {
        DocentePorPNF::create([
            'user_id' => $request->user_id,
            'pnf_id' => $pnfId,
        ]);
    }

    return redirect()->route('docentesporpnf.index')->with('success', 'Asignaciones creadas correctamente.');
}
public function edit($id)
{
    // Obtener el nombre del docente
    $docente = User::findOrFail($id);

    // Obtener los PNFs asignados al docente
    $asignados = DocentePorPNF::where('user_id', $id)->pluck('pnf_id')->toArray();

    // Obtener todos los PNFs activos
    $pnfs = Pnfs::where('estatus', true)->get();

    return view('docentesporpnf.edit', compact('docente', 'pnfs', 'asignados'));
}
public function update(Request $request, $id)
{
    $request->validate([
        'pnf_id' => 'nullable|array', // Puede ser null si no hay PNFs seleccionados
        'pnf_id.*' => 'exists:pnfs,id', // Validar que los IDs existan en la tabla PNFs
    ]);

    // Si no hay PNFs seleccionados, mostrar una alerta para confirmar inactivación
    if (empty($request->pnf_id)) {
        DocentePorPNF::where('user_id', $id)->delete(); // Borrar todas las asignaciones
        return redirect()->route('docentesporpnf.index')->with('success', 'Docente inactivado correctamente.');
    }

    // Actualizar las asignaciones del docente
    DocentePorPNF::where('user_id', $id)->delete(); // Eliminar asignaciones existentes

    foreach ($request->pnf_id as $pnfId) {
        DocentePorPNF::create([
            'user_id' => $id,
            'pnf_id' => $pnfId,
        ]);
    }

    return redirect()->route('docentesporpnf.index')->with('success', 'Asignaciones actualizadas correctamente.');
}

public function destroy($id)
{
    // Eliminar todas las asignaciones del docente en cuestión
    DocentePorPNF::where('user_id', $id)->delete();

    // Devuelve una respuesta JSON para confirmar el éxito
    return response()->json(['message' => 'Docente inactivado correctamente.'], 200);
}


}
