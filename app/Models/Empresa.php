<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = "empresa";
    protected $primaryKey = "id_empresa";
    protected $fillable = [
        'nombre',
        'nit',
        'sigla',
        'telefono',
        'correo',
        'direccion',
        'niveles',
        'id_usuario',
        'estado'
    ];
    public function usuario()
    {
        return $this->hasMany(Usuario::class, 'id_usuario', 'id_usuario');
    }
    public function cuentas()
    {
        return $this->hasMany(Cuenta::class, 'id_empresa', 'id_empresa');
    }
}