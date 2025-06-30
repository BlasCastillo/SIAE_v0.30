<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aulas extends Model
{
    use HasFactory;

    protected $table = 'aulas';

    protected $fillable = ['nombre', 'descripcion', 'cantidad', 'estatus', 'fk_tipo_aulas'];

    // 🔥 Relación con TipoAula (un aula pertenece a un tipo de aula)
    public function tipoAulas()
    {
        return $this->belongsTo(TipoAulas::class, 'fk_tipo_aulas');
    }

    // 🔥 Método para desactivar un aula
    public function desactivar()
    {
        $this->update(['estatus' => '0']);
    }

    // 🔥 Método para activar un aula
    public function activar()
    {
        $this->update(['estatus' => '1']);
    }
}
