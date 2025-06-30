<?php

namespace App\Http\Controllers;

use App\Models\Aulas;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\User;
use App\Models\Pnfs;
use App\Models\UnidadCurricular;

class ReportPdfController extends Controller
{
    public function generarReporteUsers()
    {
        $datos = User::where('role_id', 2)->get();

        $columnas = [
            ['label' => 'Nombre', 'field' => 'name'],
            ['label' => 'Cédula', 'field' => 'cedula'],
            ['label' => 'Teléfono', 'field' => 'telefono_completo'],
            ['label' => 'Correo', 'field' => 'email'],
            ['label' => 'Rol', 'field' => 'role.name'], // Ejemplo de relación
        ];

        $titulo = 'Reporte de Usuarios';

        $pdf = Pdf::loadView('reportes.base', compact('datos', 'columnas', 'titulo'));
        return $pdf->stream('reporte_users.pdf');
    }

    public function generarReporteAulas()
    {
        $datos = Aulas::all();

        $columnas = [
            ['label' => 'Nombre', 'field' => 'nombre'],
            ['label' => 'Tipo Aula', 'field' => 'tipo_aula.nombre'],
            ['label' => 'Capacidad', 'field' => 'capacidad'],
        ];

        $titulo = 'Reporte de Aulas';

        $pdf = Pdf::loadView('reportes.base', compact('datos', 'columnas', 'titulo'));
        return $pdf->stream('reporte_aulas.pdf');
    }

    public function generarReportePnfs()
    {
        $datos = pnfs::all();

        $columnas = [
            ['label' => 'Nombre', 'field' => 'nombre'],
        ];

        $titulo = 'Reporte de PNFs';

        $pdf = Pdf::loadView('reportes.base', compact('datos', 'columnas', 'titulo'));
        return $pdf->stream('reporte_pnfs.pdf');
    }

    public function generarReporteUnidadCurricular()
    {
        $datos = UnidadCurricular::all();

        $columnas = [
            ['label' => 'Nombre', 'field' => 'nombre'],
            ['label' => 'Tipo Unidad Curricular', 'field' => 'tipo_unidad_curricular.nombre'],
            ['label' => 'Duración', 'field' => 'duracion.nombre'],
            ['label' => 'Estado', 'field' => 'estado'],
        ];

        $titulo = 'Reporte de Unidades Curriculares';

        $pdf = Pdf::loadView('reportes.base', compact('datos', 'columnas', 'titulo'));
        return $pdf->stream('reporte_unidad_curricular.pdf');
    }


}

