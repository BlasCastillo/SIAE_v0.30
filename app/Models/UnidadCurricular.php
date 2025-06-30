<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnidadCurricular extends Model
{
    use HasFactory;

    protected $table = 'unidad_curricular';

    protected $fillable = ['nombre', 'descripcion', 'duracion', 'estatus', 'codigo', 'fk_pnf', 'fk_trayecto', 'fk_duracion'];


    // Relación con PNF
    public function pnf()
    {
        return $this->belongsTo(Pnfs::class, 'fk_pnf');
    }

    // Relación con Trayecto
    public function trayecto()
    {
        return $this->belongsTo(Trayectos::class, 'fk_trayecto');
    }

    // Relación con Duración
    public function duracionRelacion()
    {
        return $this->belongsTo(Duracion::class, 'fk_duracion');
    }

    // Activar Unidad Curricular
    public function activar()
    {
        $this->update(['estatus' => '1']);
    }

    // Desactivar Unidad Curricular
    public function desactivar()
    {
        $this->update(['estatus' => '0']);
    }
}
