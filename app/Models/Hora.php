<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hora extends Model
{
    use HasFactory;

    protected $table = 'horas';

    protected $fillable = ['hora_inicio', 'hora_fin', 'estatus'];

     // Método para desactivar una hora
    public function desactivar()
    {
        $this->update(['estatus' => '0']);
    }

    // Método para activar una hora
    public function activar()
    {
        $this->update(['estatus' => '1']);
    }
}
