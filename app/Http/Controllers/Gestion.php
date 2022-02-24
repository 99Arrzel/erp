<?php

namespace App\Http\Controllers;

use App\Models\Gestion as ModelsGestion;
use App\Models\Empresa;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;


class Gestion extends Controller
{
    public function editarGestion(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:20|min:3',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after:fecha_inicio'
        ]);
        /* Validar si el nombre de la gestion ya esta tomado en la empresa*/
        $nombre_gestion = ModelsGestion::where('nombre', $request->nombre)->where('id_empresa', $request->id_empresa)->get()->count();
        if($nombre_gestion > 0){
            return response()->json(['success' => false, 'message' => "El nombre de la gestión ya está tomado."], 400);
        }
        /* Validar existencia */
        $gestion = ModelsGestion::find($request->id_gestion);
        if ($gestion->first()->id_usuario != Auth::user()->id_usuario) {
            return response()->json(['success' => false], 400);
        }
        /* Validar solapamiento de fechas */
        $nsolapa = ModelsGestion::whereBetween('fecha_inicio', [$request->fecha_inicio, $request->fecha_fin])->where('id_empresa', $request->id_empresa)->get()->count();
        $nsolapa2 = ModelsGestion::whereBetween('fecha_fin', [$request->fecha_inicio, $request->fecha_fin])->where('id_empresa', $request->id_empresa)->get()->count();
        if ($nsolapa + $nsolapa2 > 0) {
            return response()->json(['success' => false, 'message' => "No puede crear una gestión sobre otra."], 400);
        }
        $gestion->update([
            'nombre' => $request->nombre,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin
        ]);
        return response()->json(['success' => true, 'message' => "Gestion actualizada con éxito."]);
    }
    public function create(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:20|min:3',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after:fecha_inicio',
            'id_empresa' => 'required|exists:empresa,id_empresa'
        ]);
        /* Validar si el nombre de la gestion ya esta tomado en la empresa*/
        $nombre_gestion = ModelsGestion::where('nombre', $request->nombre)->where('id_empresa', $request->id_empresa)->get()->count();
        if($nombre_gestion > 0){
            return response()->json(['success' => false, 'message' => "El nombre de la gestión ya está tomado."], 400);
        }
        /* Validar si esta empresa le pertenece al usuario */
        $empresa = Empresa::where('id_empresa', $request->id_empresa)->where('id_usuario', Auth::user()->id_usuario)->get()->count();
        if ($empresa == 0) {
            return response()->json(['success' => false], 400);
        }
        /* Validar que no hayan mas de 2 gestiones para esta empresa */
        $validar2nomas = ModelsGestion::where('estado', 1)->where('id_empresa', $request->id_empresa)->get()->count();
        if ($validar2nomas >= 2) {
            return response()->json(['success' => false, 'message' => "Hay 2 gestiones abiertas."], 400);
        }
        /* Validar solapamiento de fechas */
        $nsolapa = ModelsGestion::whereBetween('fecha_inicio', [$request->fecha_inicio, $request->fecha_fin])->where('id_empresa', $request->id_empresa)->get()->count();
        $nsolapa2 = ModelsGestion::whereBetween('fecha_fin', [$request->fecha_inicio, $request->fecha_fin])->where('id_empresa', $request->id_empresa)->get()->count();
        if ($nsolapa + $nsolapa2 > 0) {
            return response()->json(['success' => false, 'message' => "No puede crear una gestión sobre otra."], 400);
        }
        ModelsGestion::create([
            'nombre' => $request->nombre,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
            'id_usuario' => Auth::user()->id_usuario,
            'id_empresa' => $request->id_empresa,
            'estado' => 1
        ]);
        return response()->json(['success' => true, 'message' => "Gestion creada con éxito."]);
    }

    public function getDataEmpresaGestion(Request $request)
    {
        $gestiones_usuario = ModelsGestion::where('gestion.id_usuario', Auth::user()->id_usuario)
            ->leftJoin('empresa', 'empresa.id_empresa', '=', 'gestion.id_empresa')
            ->where('empresa.nombre', $request->empresa)
            ->select('gestion.*');
        if (empty($gestiones_usuario)) {
            return redirect(route('lista'));
        }
        return Datatables::of($gestiones_usuario)->make(true);
    }
    //Lo utilizamos para obtener los datos del header
    public function listar_gestiones($empresa)
    {
        $usuario =  Usuario::with(['empresas' => function ($query) use ($empresa) {
            $query->where('nombre', $empresa);
        }])->where('usuario', Auth::user()->usuario)->first();

        if ($usuario->toArray()['empresas'] == []) {
            return redirect(route('lista'));
        }
        return view('seleccion-gestion', compact('usuario'));
    }

    public function cerrarGestion(Request $request) //Delete logico
    {
        //Validamos si existe la gestion
        $request->validate([
            'id_gestion' => 'required|exists:gestion,id_gestion'
        ]);
        $gestion = ModelsGestion::where('id_usuario', Auth::user()->id_usuario)->where('id_gestion', $request->id_gestion)->first();
        if (!isset($gestion)) {
            return response()->json(['success' => false], 400);
        }
        ModelsGestion::find($request->id_gestion)->update(['estado' => 0]);
        return response()->json(['success' => true]);
    }
    public function abrirGestion(Request $request)
    {
        //Validamos si existe la gestion
        $request->validate([
            'id_gestion' => 'required|exists:gestion,id_gestion'
        ]);
        $gestion = ModelsGestion::where('id_usuario', Auth::user()->id_usuario)->where('id_gestion', $request->id_gestion)->first();
        if (!isset($gestion)) {
            return response()->json(['success' => false], 400);
        }
        /*Validamos que no hayan mas de 2 gestiones para esta empresa */
        $validar2nomas = ModelsGestion::where('id_empresa', $gestion->id_empresa)->where('estado', 1)->get()->count();
        if ($validar2nomas >= 2) {
            return response()->json(['success' => false, 'message' => "Hay 2 gestiones abiertas."], 400);
        }
        ModelsGestion::find($request->id_gestion)->update(['estado' => 1]);
        return response()->json(['success' => true]);
    }

    public function pruebita(Request $request)
    {
        return basename($request->url());
    }
}