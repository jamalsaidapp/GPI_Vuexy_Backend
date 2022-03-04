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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', [App\Http\Controllers\AuthController::class, 'login'])->name('login');

Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::post('logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');
    Route::post('refresh', [App\Http\Controllers\AuthController::class, 'refresh'])->name('refresh');

    Route::apiResource('users', App\Http\Controllers\API\Settings\UserController::class);
    Route::get('users/{id}', [App\Http\Controllers\API\Settings\UserController::class, 'export']);
    Route::get('getuserpermissions/{id}', [App\Http\Controllers\API\Settings\UserController::class, 'GetUserPermissions']);

    Route::apiResource('roles', App\Http\Controllers\API\Settings\RoleController::class);
    Route::apiResource('permissions', App\Http\Controllers\API\Settings\PermissionController::class);
    Route::post('set_user_permissions/{id}', [App\Http\Controllers\API\Settings\PermissionController::class, 'setUserPermissions']);

    Route::apiResource('salaries', App\Http\Controllers\API\Settings\SalarieController::class);
    Route::apiResource('ordinateurs', App\Http\Controllers\API\Gestion_Pc\OrdinateurController::class);
    Route::apiResource('affectations', App\Http\Controllers\API\Gestion_Pc\AffectationsController::class);
    Route::apiResource('retours', App\Http\Controllers\API\Gestion_Pc\RetoursController::class);
    Route::get('get_sn_salaries', [App\Http\Controllers\API\Gestion_Pc\AffectationsController::class, 'get_SN_Salaries']);

    //restores FN
    Route::post('restore_user/{id}', [App\Http\Controllers\API\Settings\UserController::class, 'restore']);
    Route::post('restore_ordinateur/{id}', [App\Http\Controllers\API\Gestion_Pc\OrdinateurController::class, 'restore']);
    Route::post('restore_affectation_pc/{id}', [App\Http\Controllers\API\Gestion_Pc\AffectationsController::class, 'restore']);
    Route::post('restore_salarie/{id}', [App\Http\Controllers\API\Settings\SalarieController::class, 'restore']);
});

