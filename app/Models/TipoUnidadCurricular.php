<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoUnidadCurricular extends Model
{
    use HasFactory;

    protected $table = 'tipo_unidad_curricular';

    protected $fillable = ['nombre', 'descripcion', 'estatus'];

    // 🔥 Método para desactivar un tipo de unidad curricular
    public function desactivar()
    {
        $this->update(['estatus' => '0']);
    }

    // 🔥 Método para activar un tipo de unidad curricular
    public function activar()
    {
        $this->update(['estatus' => '1']);
    }
}
