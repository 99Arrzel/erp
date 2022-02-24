<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gestion extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_gestion';
    public $timestamps = false;
    protected $table = "gestion";
    protected $fillable = [
        'nombre',
        'fecha_inicio',
        'fecha_fin',
        'estado',
        'id_usuario',
        'id_empresa'
    ];
    public function usuarios()
    {
        return $this->hasMany(Usuario::class, 'id_usuario', 'id_usuario');
    }
    public function empresa()
    {
        return $this->hasMany(Empresa::class, 'id_empresa', 'id_empresa');
    }
}
