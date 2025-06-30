<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;

class DynamicTemplateExport implements FromArray
{
    protected $columns;

    public function __construct(array $columns)
    {
        $this->columns = $columns;
    }

    public function array(): array
    {
        // Devuelve solo la fila de encabezados con los nombres de columnas
        return [$this->columns];
    }
}
