<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sedes extends Model
{
    use HasFactory;

    protected $table = 'sedes';

    protected $fillable = ['codigo', 'nombre', 'descripcion', 'estatus'];

    // 🔥 Método para desactivar una sede
    public function desactivar()
    {
        $this->update(['estatus' => '0']);
    }

    // 🔥 Método para activar una sede
    public function activar()
    {
        $this->update(['estatus' => '1']);
    }
}
