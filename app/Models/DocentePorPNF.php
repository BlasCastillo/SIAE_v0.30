<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocentePorPNF extends Model
{
    use HasFactory;

    protected $table = 'docente_por_pnf';

    protected $fillable = [
        'user_id',
        'pnf_id',
    ];

    // Relación con el modelo User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación con el modelo PNF
    public function pnf()
    {
        return $this->belongsTo(Pnfs::class);
    }
}

