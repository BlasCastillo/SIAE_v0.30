<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DynamicDataImport implements ToCollection
{
    protected $table;

    public function __construct($table)
    {
        $this->table = $table;
    }

    public function collection(Collection $rows)
    {
        $columns = Schema::getColumnListing($this->table);
        $excluded = ['id', 'created_at', 'updated_at'];
        $columns = array_filter($columns, fn($col) => !in_array($col, $excluded));
        $columns = array_values($columns);

        if ($rows->isEmpty()) {
            throw new \Exception("El archivo está vacío.");
        }

        $header = $rows->first()->toArray();

        // Normalizar para comparar sin importar orden
        $headerNormalized = array_map('strtolower', $header);
        $columnsNormalized = array_map('strtolower', $columns);

        $missingColumns = array_diff($columnsNormalized, $headerNormalized);
        if (!empty($missingColumns)) {
            throw new \Exception("Faltan columnas en el archivo: " . implode(', ', $missingColumns));
        }

        // Mapear índices de columnas en el Excel para el orden correcto
        $headerMap = [];
        foreach ($columnsNormalized as $col) {
            $index = array_search($col, $headerNormalized);
            if ($index === false) {
                throw new \Exception("Columna {$col} no encontrada en el archivo.");
            }
            $headerMap[] = $index;
        }

        $data = [];

        foreach ($rows->skip(1) as $row) {
            $rowArray = $row->toArray();

            // Ignorar filas vacías
            if (collect($rowArray)->filter(fn($val) => !is_null($val) && $val !== '')->isEmpty()) {
                continue;
            }

            // Construir fila con orden correcto según columnas esperadas
            $orderedRow = [];
            foreach ($headerMap as $idx) {
                $orderedRow[] = $rowArray[$idx] ?? null;
            }

            if (count($orderedRow) !== count($columns)) {
                throw new \Exception("Una fila tiene un número incorrecto de columnas.");
            }

            $data[] = array_combine($columns, $orderedRow);
        }

        if (!empty($data)) {
            DB::table($this->table)->insert($data);
        }
    }


}
