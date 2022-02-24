<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class User extends Controller
{
    public function listar_empresas(Request $request)
    {
        $data = Usuario::with('empresas')->where('usuario', Auth::user()->usuario)->first();
        return view('seleccion-empresa', compact('data'));
    }
}
