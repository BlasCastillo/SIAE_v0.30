<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trayectos extends Model
{
    use HasFactory;

    protected $table = 'trayectos';

    protected $fillable = ['codigo', 'nombre', 'descripcion', 'estatus', 'fk_pnf'];

    // 🔥 Relación con PNF (Un trayecto pertenece a un PNF)
    public function pnf()
    {
        return $this->belongsTo(Pnfs::class, 'fk_pnf');
    }

    // 🔥 Método para desactivar un trayecto
    public function desactivar()
    {
        $this->update(['estatus' => '0']);
    }

    // 🔥 Método para activar un trayecto
    public function activar()
    {
        $this->update(['estatus' => '1']);
    }
}

