<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Periodo extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_periodo';
    protected $table = 'periodo';
    public $timestamps = false;
    protected $fillable = [
        'nombre',
        'fecha_inicio',
        'fecha_fin',
        'estado',
        'id_usuario',
        'id_gestion'
    ];
    public function usuarios()
    {
        return $this->hasMany(Usuario::class, 'id_usuario', 'id_usuario');
    }
    public function gestiones()
    {
        return $this->hasMany(Gestion::class, 'id_gestion', 'id_gestion');
    }
}