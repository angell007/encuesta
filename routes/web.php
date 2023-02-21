<?php

use App\Http\Controllers\PaginaPrincipalController;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;


// mytextarea

Route::get('/test', function () {

   $date = Carbon::now()->format('Ymd');
   $doc = 91520702;
   $base64 = base64_encode("1,$doc,$date");
   $base64url = strtr($base64, '+/=', '-_ ');
   $url = 'http://genetitc20.test/ae/' . $base64url;

   return $url;
   // return Hash::make('secret');
});

// Route::resource('tenants', TenantController::class);
// Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
Route::get('/{excepcion}', [PaginaPrincipalController::class, 'index'])->where('excepcion', '^(?!api\/)[\/\w\.-]*');
