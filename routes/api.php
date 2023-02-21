<?php


use App\Http\Controllers\AuthController;
use App\Http\Controllers\EncuestaController;
use App\Http\Controllers\GestionRutasController;
use App\Http\Controllers\MenuController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout',  [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
});

//  Controlando accesos

Route::get('/clear-cache', function () {

    $exitCode = Artisan::call('config:clear');

    $exitCode = Artisan::call('cache:clear');

    $exitCode = Artisan::call('config:cache');

    return 'DONE'; //Return anything

});

Route::post('gestion-rutas', [GestionRutasController::class, 'verPlan']);
Route::get('menu', [MenuController::class, 'index']);

Route::get('encuestas/datos', [EncuestaController::class, 'getEncuestas']);
Route::get('encuestas/datos/public', [EncuestaController::class, 'getEncuestaspublic']);
Route::post('/encuestas/crear', [EncuestaController::class, 'store']);
Route::delete('/encuestas/{id}/eliminar', [EncuestaController::class, 'destroy']);
Route::post('/encuestas/responder', [EncuestaController::class, 'responder']);
Route::get('encuestas/{id}/mostrar', [EncuestaController::class, 'getDatosEncuesta']);
Route::get('encuestas/{id}/{fecha}/validar', [EncuestaController::class, 'validarEncuesta']);
Route::get('encuestas/respuestas/{id}/{inicio}/{fin}', [EncuestaController::class, 'getRespuestas']);
Route::get('encuestas/indicadores/{id}/{inicio}/{fin}', [EncuestaController::class, 'getIndicadores']);
