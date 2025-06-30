<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seccion extends Model
{
    use HasFactory;

    protected $table = 'secciones';

    protected $fillable = [
        'nombre', 
        'codigo', 
        'cantidad_alumnos', 
        'fk_pnf', 
        'fk_trayecto', 
        'fk_unidad_curricular', 
        'estatus'
    ];

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

    // Relación con Unidad Curricular
    public function unidadCurricular()
    {
        return $this->belongsTo(UnidadCurricular::class, 'fk_unidad_curricular');
    }

    // Activar Sección
    public function activar()
    {
        $this->update(['estatus' => '1']);
    }

    // Desactivar Sección
    public function desactivar()
    {
        $this->update(['estatus' => '0']);
    }
}
