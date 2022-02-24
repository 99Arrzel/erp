<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cuenta extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = "cuenta";
    protected $primaryKey = "id_cuenta";
    protected $fillable = [
        'codigo',
        'nombre',
        'nivel',
        'id_cuenta_padre',
        'tipo_cuenta',
        'id_empresa',
        'id_usuario'
    ];
    public function hijos($query)
    {
        $query->where('id_cuenta_padre', $this->id_cuenta);
    }
    public function padre()
    {
        return $this->belongsTo(Cuenta::class, 'id_cuenta_padre', 'id_cuenta');
    }
    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'id_empresa', 'id_empresa');
    }
}