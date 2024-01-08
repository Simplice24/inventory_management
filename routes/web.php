<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProductionMaterialController;
use App\Http\Controllers\ProductionMaterialRequestController;
use App\Http\Controllers\RawMaterialController;
use App\Http\Controllers\RawMaterialRequestController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::group(['middleware' => ['auth']], function () {
  // Home
  Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

  // Users
  Route::resource('users', UserController::class);

  // permissions
  Route::get('/permissions', [PermissionController::class, 'index'])->name('permissions.index');
  Route::post('/permissions', [PermissionController::class, 'store'])->name('permissions.store');
  Route::delete('/permissions/{id}', [PermissionController::class, 'destroy'])->name('permissions.destroy');

  // roles
  Route::resource('roles', RoleController::class);

  // Raw Materials
  Route::resource('/raw-materials', RawMaterialController::class);

  // Raw material requests
  Route::resource('raw-material-requests', RawMaterialRequestController::class);
  Route::post('/raw-material-requests/get-item-types', [RawMaterialRequestController::class, 'get_item_types']);
  Route::get('/raw-mat-req/queue-list', [RawMaterialRequestController::class, 'queue_list'])->name('raw-material-requests.queue-list');
  Route::put('/raw-mat-req/confirmation/{id}', [RawMaterialRequestController::class, 'confirmation'])->name('raw-material-requests.confirmation');

  // production Materials
  Route::resource('production-materials', ProductionMaterialController::class);

  // production Material Requests
  Route::resource('production-material-requests', ProductionMaterialRequestController::class);
  Route::post('/production-material-requests/get-pac-sizes', [ProductionMaterialRequestController::class, 'get_pac_sizes']);
  Route::get('/prod-mat-req/queue-list', [ProductionMaterialRequestController::class, 'queue_list'])->name('production-material-requests.queue-list');
  Route::put('/prod-mat-req/confirmation/{id}', [ProductionMaterialRequestController::class, 'confirmation'])->name('production-material-requests.confirmation');
});

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');