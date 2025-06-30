<?php

namespace App\Http\Controllers;

use App\Models\Hora;
use Illuminate\Http\Request;

class HoraController extends Controller
{
    public function index(Request $request)
    {
        $mostrarInactivas = $request->query('ver_inactivas', false);
        $horas = $mostrarInactivas
            ? Hora::orderBy('hora_inicio', 'asc')->get()
            : Hora::where('estatus', '1')->orderBy('hora_inicio', 'asc')->get();
        return view('horas.index', compact('horas', 'mostrarInactivas'));
    }

    public function create()
    {
        return view('horas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'hora_inicio' => 'required|date_format:H:i|unique:horas',
            'hora_fin' => 'required|date_format:H:i|unique:horas',
        ]);

        Hora::create([
            'hora_inicio' => $request->hora_inicio,
            'hora_fin' => $request->hora_fin,
            'estatus' => '1',
        ]);

        return redirect()->route('horas.index')->with('success', 'Hora creada correctamente');
    }

    public function edit(Hora $hora)
    {
        return view('horas.edit', compact('hora'));
    }

    public function update(Request $request, Hora $hora)
    {
        $request->validate([
            'hora_inicio' => "required|date_format:H:i|unique:horas,hora_inicio,{$hora->id}",
            'hora_fin' => "required|date_format:H:i|unique:horas,hora_fin,{$hora->id}",
            'estatus' => 'required|in:0,1',
        ]);

        $hora->update([
            'hora_inicio' => $request->hora_inicio,
            'hora_fin' => $request->hora_fin,
            'estatus' => $request->estatus,
        ]);

        return redirect()->route('horas.index')->with('success', 'Hora actualizada correctamente');
    }

    public function destroy(Hora $hora)
    {
        $hora->desactivar();
        return redirect()->route('horas.index')->with('success', 'Hora inactivada correctamente');
    }
}
