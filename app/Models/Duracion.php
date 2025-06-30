<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Duracion extends Model
{
    use HasFactory;

    protected $table = 'duraciones';

    protected $fillable = ['nombre', 'descripcion', 'estatus'];

    // Método para desactivar
    public function desactivar()
    {
        $this->update(['estatus' => '0']);
    }

    // Método para activar
    public function activar()
    {
        $this->update(['estatus' => '1']);
    }
}
