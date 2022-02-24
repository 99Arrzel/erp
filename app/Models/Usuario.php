<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Usuario extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'usuario';
    protected $primaryKey = 'id_usuario';
    protected $fillable = [
        'nombre',
        'usuario',
        'pass',
        'tipo',
        'remember_token' /* Para recordar al usuario */
    ];

    public function getAuthPassword()
    {
        return $this->pass;
    }
    //Obteniendo IDS 👍
    public function empresas()
    {
        return $this->hasMany(Empresa::class, 'id_usuario', 'id_usuario');
    }
    public function gestiones()
    {
        return $this->hasMany(Gestion::class, 'id_usuario', 'id_usuario');
    }
    public function periodos()
    {
        return $this->hasMany(Periodo::class, 'id_usuario', 'id_usuario');
    }
    public function cuenta()
    {
        return $this->hasManyThrough(Cuenta::class, Empresa::class, 'id_usuario', 'id_usuario', 'id_usuario', 'id_empresa');
    }
}