<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoAulas extends Model
{
    use HasFactory;

    protected $table = 'tipo_aulas';

    protected $fillable = ['nombre', 'descripcion', 'estatus'];

    // 🔥 Método para desactivar el tipo de aula
    public function desactivar()
    {
        $this->update(['estatus' => '0']);
    }

    // 🔥 Método para activar el tipo de aula
    public function activar()
    {
        $this->update(['estatus' => '1']);
    }
}

