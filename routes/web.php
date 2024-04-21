<?php

use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

/**********************************************************************************************/
                            /*Routes that handle Permission*/
/**********************************************************************************************/
Route::get('/', [PermissionController::class, 'index']); //Default route
Route::get('/perm', [PermissionController::class, 'index'])->name('perm.index');
Route::get('/perm/create', [PermissionController::class, 'create'])->name('perm.create');
Route::post('/perm', [PermissionController::class, 'store'])->name('perm.store');
Route::get('/perm/{id}', [PermissionController::class, 'show'])->name('perm.show');
Route::get('/perm/{id}/edit', [PermissionController::class, 'edit'])->name('perm.edit');
Route::put('/perm/{permission}', [PermissionController::class, 'update'])->name('perm.update');
Route::delete('/perm/{permissionId}', [PermissionController::class, 'destroy'])->name('perm.destroy');


/**********************************************************************************************/
                            /*Routes that handle Role*/
/**********************************************************************************************/

Route::get('/rol', [RoleController::class, 'index'])->name('rol.index');
Route::get('/rol/create', [RoleController::class, 'create'])->name('rol.create');
Route::post('rol', [RoleController::class, 'store'])->name('rol.store');
Route::get('rol/{id}', [RoleController::class, 'show'])->name('rol.show');
Route::get('/rol/{id}/edit', [RoleController::class, 'edit'])->name('rol.edit');
Route::put('/rol/{role}', [RoleController::class, 'update'])->name('rol.update');
Route::delete('rol/{roleId}', [RoleController::class, 'destroy'])->name('rol.destroy');
Route::get('/rol/{roleId}/give-permissions', [RoleController::class, 'addPermissionToRole'])->name('rol.give-permissions');
Route::put('/rol/{roleId}/give-permissions', [RoleController::class, 'givePermissionToRole'])->name('rol.give-permissions');


/**********************************************************************************************/
/*Routes that handle User*/
/**********************************************************************************************/

Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
Route::post('/users', [UserController::class, 'store'])->name('users.store');
Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show');
Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
Route::put('users/{userId}', [UserController::class, 'update'])->name('users.update');
Route::delete('users/{userId}', [UserController::class, 'destroy'])->name('users.destroy');
