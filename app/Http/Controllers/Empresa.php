<?php

namespace App\Http\Controllers;

use App\Models\Empresa as ModelsEmpresa;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Empresa extends Controller
{
    public function getEmpresa(Request $request)
    {
        /*
            Validamos si existe la empresa primero
         */
        $request->validate([
            'id_empresa' => 'required|exists:empresa,id_empresa'
        ]);
        /*
            Si existe la empresa, buscamos a nuestro usuario
         */
        $usuario =  Usuario::with('empresas')->where('usuario', Auth::user()->usuario)->first();
        /*
            Buscamos si al usuario se lo relaciona con esta empresa o no y dependiendo de eso le dejamos hacer el delete
        */
        $empresa = array_search($request->id_empresa, array_column($usuario->toArray()['empresas'], 'id_empresa'));
        if (!isset($empresa)) {
            return response()->json(['success' => false], 400);
        }
        return ModelsEmpresa::find($request->id_empresa);
    }
    //Lo utilizamos para obtener los datos del header en el dashboard
    public function dashboard_empresax($empresa)
    {
        $usuario =  Usuario::with(['empresas' => function ($query) use ($empresa) {
            $query->where('nombre', $empresa);
        }])->where('usuario', Auth::user()->usuario)->first();

        if ($usuario->toArray()['empresas'] == []) {
            return redirect(route('lista'));
        }

        return view('dashboard', compact('usuario'));
    }
    public function create(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:20|min:3|unique:empresa,nombre',
            'nit' => 'required|numeric|min:100000|max:9999999999|unique:empresa,nit',
            'sigla' => 'required|string|max:10|min:2|unique:empresa,sigla',
            'telefono' => 'required|numeric|min:100000|max:99999999',
            'correo' => 'required|email',
            'niveles' => 'required|numeric',
            'direccion' => 'required|string'
        ]);
        $nueva_empresa = ModelsEmpresa::create([
            'nombre' => $request->nombre,
            'nit' => $request->nit,
            'sigla' => $request->sigla,
            'telefono' => $request->telefono,
            'correo' => $request->correo,
            'niveles' => $request->niveles,
            'direccion' => $request->direccion,
            'id_usuario' => Auth::user()->id_usuario,
            'estado' => 1
        ]);
        return response()->json(['success' => true]);
    }
    public function softDelete(Request $request) //Como el nombre indica, soft delete para empresa
    {
        /*
            Validamos si existe la empresa primero
         */
        $request->validate([
            'id_empresa' => 'required|exists:empresa,id_empresa'
        ]);
        /*
            Si existe la empresa, buscamos a nuestro usuario
         */
        $usuario =  Usuario::with('empresas')->where('usuario', Auth::user()->usuario)->first();
        /*
            Buscamos si al usuario se lo relaciona con esta empresa o no y dependiendo de eso le dejamos hacer el delete
        */
        $empresa = array_search($request->id_empresa, array_column($usuario->toArray()['empresas'], 'id_empresa'));
        if (!isset($empresa)) {
            return response()->json(['success' => false], 400);
        }
        ModelsEmpresa::find($request->id_empresa)->update(['estado' => 0]);
        return response()->json(['success' => true]);
    }

    public function enable(Request $request) //Esta función es para habilitar empresas, por si las diste de baja.
    {
        $request->validate([
            'id_empresa' => 'required|exists:empresa,id_empresa'
        ]);
        /*
            Si existe la empresa, buscamos a nuestro usuario
         */
        $usuario =  Usuario::with('empresas')->where('usuario', Auth::user()->usuario)->first();
        /*
            Buscamos si al usuario se lo relaciona con esta empresa o no y dependiendo de eso le dejamos hacer el delete
        */
        $empresa = array_search($request->id_empresa, array_column($usuario->toArray()['empresas'], 'id_empresa'));
        if (!isset($empresa)) {
            return response()->json(['success' => false], 400);
        }
        ModelsEmpresa::find($request->id_empresa)->update(['estado' => 1]);
        return response()->json(['success' => true]);
    }

    public function editEmpresa(Request $request)
    {
        $request->validate([
            'id_empresa' => 'required|exists:empresa,id_empresa',
            'nombre' => 'required|string|max:20|min:3|unique:empresa,nombre,' . $request->id_empresa . ',id_empresa',
            'nit' => 'required|numeric|min:100000|max:9999999999|unique:empresa,nit,'.$request->id_empresa.',id_empresa',
            'sigla' => 'required|string|max:10|min:2|unique:empresa,sigla,'.$request->id_empresa.',id_empresa',
            'telefono' => 'required|numeric|min:100000|max:99999999',
            'correo' => 'required|email',
            'niveles' => 'required|numeric',
            'direccion' => 'required|string'
        ]);
        /*
            Si existe la empresa, buscamos a nuestro usuario
         */
        $usuario =  Usuario::with('empresas')->where('usuario', Auth::user()->usuario)->first();
        /*
            Buscamos si al usuario se lo relaciona con esta empresa o no y dependiendo de eso le dejamos hacer el delete
        */
        $empresa = array_search($request->id_empresa, array_column($usuario->toArray()['empresas'], 'id_empresa'));
        if (!isset($empresa)) {
            return response()->json(['success' => false], 400);
        }
        ModelsEmpresa::find($request->id_empresa)->update([
            'nombre' => $request->nombre,
            'nit' => $request->nit,
            'sigla' => $request->sigla,
            'telefono' => $request->telefono,
            'correo' => $request->correo,
            'niveles' => $request->niveles,
            'direccion' => $request->direccion,
        ]);
        return response()->json(['success' => true]);
    }
}
