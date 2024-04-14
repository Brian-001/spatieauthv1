<?php

use App\Http\Controllers\PermissionController;
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
Route::get('/', [PermissionController::class, 'index']); //Default route
Route::get('/perm', [PermissionController::class, 'index'])->name('perm.index');
Route::get('/perm/create', [PermissionController::class, 'create'])->name('perm.create');
Route::post('/perm', [PermissionController::class, 'store'])->name('perm.store');
