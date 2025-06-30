<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DynamicTemplateExport;
use App\Imports\DynamicDataImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\HeadingRowImport;
use Illuminate\Support\Arr;

class ExcelController extends Controller
{

    //tablas a mostrar en la vista
    public function showImportView()
    {
        // Define las tablas permitidas para carga masiva
        $tables = [
            'Unidad Curricular' => 'unidad_curricular',
            'Programa Nacional de Formación' => 'pnfs',
            'Aulas Academicas' => 'aulas',
        ];

        // Retorna la vista 'import' con la lista de tablas
        return view('excel.import', compact('tables'));
    }

    protected function mapAliasToTable(string $alias): string
{
    $tables = [
        'Unidad Curricular' => 'unidad_curricular',
        'Programa Nacional de Formación' => 'pnfs',
        'Aulas Academicas' => 'aulas',
    ];

    if (!array_key_exists($alias, $tables)) {
        abort(403, 'Tabla no permitida');
    }

    return $tables[$alias];
}


    public function downloadTemplate(Request $request)
    {
        $tables = [
            'Unidad Curricular' => 'unidad_curricular',
            'Programa Nacional de Formación' => 'pnfs',
            'Aulas Academicas' => 'aulas',
        ];


        $alias = $request->table;

        if (!array_key_exists($alias, $tables)) {
            abort(403, 'Tabla no permitida');
        }

        $table = $tables[$alias];
        $columns = Schema::getColumnListing($table);
        $excluded = ['id', 'created_at', 'updated_at'];
        $columns = array_filter($columns, fn($col) => !in_array($col, $excluded));

        return Excel::download(new DynamicTemplateExport($columns), "{$table}_plantilla.xlsx");
    }

    public function handleImport(Request $request)
    {
        // Define las tablas permitidas para carga masiva
        $tables = [
            'Unidad Curricular' => 'unidad_curricular',
            'Programa Nacional de Formación' => 'pnfs',
            'Aulas Academicas' => 'aulas',
        ];

        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls',
            'table' => 'required|string',
        ]);

        $alias = $request->table;

        if (!array_key_exists($alias, $tables)) {
            abort(403, 'Tabla no permitida');
        }

        $table = $tables[$alias];

        // Columnas esperadas (sin id, created_at, updated_at)
        $columns = Schema::getColumnListing($table);
        $excluded = ['id', 'created_at', 'updated_at'];
        $columns = array_filter($columns, fn($col) => !in_array($col, $excluded));
        $columns = array_values($columns); // reindexar

        // Obtener cabecera del Excel usando HeadingRowImport
        $headingsArray = (new HeadingRowImport)->toArray($request->file('file'));
        if (empty($headingsArray) || empty($headingsArray[0])) {
            return back()->withErrors('No se pudo leer la cabecera del archivo.');
        }
        $header = $headingsArray[0][0]; // Primera hoja, primera fila

        // Función para normalizar (trim y strtolower)
        $normalize = fn($arr) => array_map(fn($v) => strtolower(trim($v)), $arr);

        $headerNormalized = $normalize($header);
        $columnsNormalized = $normalize($columns);

        // Validar que las columnas esperadas estén en la cabecera
        $missingColumns = array_diff($columnsNormalized, $headerNormalized);

        if (!empty($missingColumns)) {
            return back()->withErrors('Faltan columnas en el archivo: ' . implode(', ', $missingColumns));
        }

        try {
            Excel::import(new DynamicDataImport($table), $request->file('file'));
            return back()->with('success', 'Carga masiva realizada correctamente.');
        } catch (\Exception $e) {
            return back()->withErrors('Error en la importación: ' . $e->getMessage());
        }
    }


    public function previewImport(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls',
            'table' => 'required|string',
        ]);

        $table = $this->mapAliasToTable($request->table);

        // Obtener columnas reales de la tabla (puedes excluir id, timestamps si quieres)
        $columns = Schema::getColumnListing($table);
        $excluded = ['id', 'created_at', 'updated_at'];
        $columns = array_filter($columns, fn($col) => !in_array($col, $excluded));
        $columns = array_values($columns); // reindexar

        // Leer cabeceras del Excel
        $headingsArray = (new HeadingRowImport)->toArray($request->file('file'));
        $header = $headingsArray[0][0] ?? [];

        // Leer primeras filas (ejemplo 5 filas)
        $rows = Excel::toArray(null, $request->file('file'))[0] ?? [];

        // Quitar la fila de cabecera
        $dataRows = array_slice($rows, 1, 5);

        return response()->json([
            'header' => $header,
            'rows' => $dataRows,
            'table' => $table,
            'columns' => $columns,
        ]);
    }
}
