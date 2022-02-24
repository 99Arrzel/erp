<?php

use App\Http\Controllers\Empresa;
use App\Http\Controllers\Gestion;
use App\Http\Controllers\Periodo;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Login;
use App\Http\Controllers\Logout;
use App\Http\Controllers\User;
use App\Http\Controllers\Cuenta;
use Illuminate\Support\Facades\Hash;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//LOGIN
Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard')->middleware('isLoged');
Route::get('/', [Login::class, 'showLogin'])->name('login');
Route::post('/login', [Login::class, 'customLogin'])->name('checkLogin');

//LOGOUT
Route::get('/logout', [Logout::class, 'signOut'])->name('logout');

//Hashtruco
Route::get('/hash/{hasheameesta}', function ($hash) {
    return Hash::make($hash);
});

//Empresa
Route::get('/lista/{empresa}', [Empresa::class, 'dashboard_empresax'])->name('dash')->middleware('isLoged');
Route::post('/registrarEmpresa', [Empresa::class, 'create'])->name('registrar_e')->middleware('isLoged');
Route::post('/getDataEmpresa', [Empresa::class, 'getEmpresa'])->name('getData_e')->middleware('isLoged');
Route::post('/softDeleteEmpresa', [Empresa::class, 'softDelete'])->name('softDelete_e')->middleware('isLoged');
Route::post('/editEmpresa', [Empresa::class, 'editEmpresa'])->name('editEmpresa')->middleware('isLoged');
Route::get('/lista', [User::class, 'listar_empresas'])->name('lista')->middleware('isLoged');

//Gestion
Route::get('/lista/{empresa}/gestiones', [Gestion::class, 'listar_gestiones'])->name('lista-gestiones')->middleware('isLoged');
Route::post('/registrarGestion', [Gestion::class, 'create'])->name('registrar_g')->middleware('isLoged');
Route::get('/getDataEmpresaGestion', [Gestion::class, 'getDataEmpresaGestion'])->name('gestionData')->middleware('isLoged');
Route::post('/editarGestion', [Gestion::class, 'editarGestion'])->name('editar_g')->middleware('isLoged');
Route::post('/cerrarGestion', [Gestion::class, 'cerrarGestion'])->name('cerrarGestion')->middleware('isLoged');
Route::post('/abrirGestion', [Gestion::class, 'abrirGestion'])->name('abrirGestion')->middleware('isLoged');
Route::get('/pruebitaaa', [Gestion::class, 'pruebita'])->name('pruebita');

//Periodo
Route::post('/listarPeriodos', [Periodo::class, 'getPeriodoDeGestion'])->name('listarPeriodos')->middleware('isLoged');
Route::post('/cambiarEstadoPeriodo', [Periodo::class, 'cambiarEstadoPeriodo'])->name('cambiarEstadoPeriodo')->middleware('isLoged');
Route::post('/actualizarPeriodo', [Periodo::class, 'actualizarPeriodo'])->name('actualiza_periodo')->middleware('isLoged');
Route::post('/creaPeriodo', [Periodo::class, 'create'])->name('crear_periodo')->middleware('isLoged');

//Cuentas
Route::get('/lista/{empresa}/cuentas', [Cuenta::class, 'listar_cuentas'])->name('lista-cuentas')->middleware('isLoged');
Route::post('/listarCuentasApi', [Cuenta::class, 'ajaxCall'])->name('listarCuentasApi')->middleware('isLoged');