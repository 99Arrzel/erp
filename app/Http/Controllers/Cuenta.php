<?php

namespace App\Http\Controllers;

use App\Models\Cuenta as ModelsCuenta;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Cuenta extends Controller
{
    public function listar_cuentas($empresa)
    {
        $usuario =  Usuario::with(['empresas' => function ($query) use ($empresa) {
            $query->where('nombre', $empresa)->with(['cuentas' => function ($query) {
                $query->orderBy('codigo', 'desc');
            }]);
        }])->where('id_usuario', Auth::user()->id_usuario)->first();
        if ($usuario->toArray()['empresas'] == []) {
            return redirect(route('lista'));
        }
        return view('cuenta.dashboard', compact('usuario'));
    }
    public function ajaxCall(Request $request)
    {
        $array = [];
        $cuentas = ModelsCuenta::where('id_empresa', $request->id_empresa)->where('id_usuario', Auth::user()->id_usuario)->get()->toArray();
        foreach ($cuentas as $cuenta) {
            $array['id'] = $cuenta['id_cuenta'];
            $array['text'] = $cuenta['codigo'] . ' --- ' . $cuenta['nombre'];
            $array['parent'] = $cuenta['id_padre'] ?? '#';
        }
        return response()->json($array);
    }
}