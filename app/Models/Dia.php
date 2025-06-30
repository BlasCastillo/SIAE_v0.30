<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dia extends Model
{
    use HasFactory;

    protected $table = 'dias';

    protected $fillable = ['nombre', 'valor', 'estatus'];

    // Método para desactivar un día
    public function desactivar()
    {
        $this->update(['estatus' => '0']);
    }

    // Método para activar un día
    public function activar()
    {
        $this->update(['estatus' => '1']);
    }
}
