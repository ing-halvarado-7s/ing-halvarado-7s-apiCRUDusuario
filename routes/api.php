<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::post('iniciarsesion', 'App\Http\Controllers\UserController@iniciarsesion');


Route::group(['middleware' => ['jwt.verify']], function() {
   
    Route::post('crear', 'App\Http\Controllers\UserController@crear');
    
    Route::get('listar','App\Http\Controllers\UserController@listar');
    
    Route::post('actualizar/{id}', 'App\Http\Controllers\UserController@actualizar');
    
    Route::delete('eliminar/{id}','App\Http\Controllers\UserController@eliminar');
    
    Route::get('mostrardetalle/{id}','App\Http\Controllers\UserController@mostrarDetalle');
    
    Route::post('cerrarsesion', 'App\Http\Controllers\UserController@cerrarSesion');

    Route::post('asignarol/{id}', 'App\Http\Controllers\RoleController@asignarRol');

    Route::post('agregarpermisorol', 'App\Http\Controllers\RoleController@agregarPermisoRol');

    Route::post('quitarpermisorol', 'App\Http\Controllers\RoleController@quitarPermisoRol');

});
