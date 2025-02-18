<?php

use App\Http\Controllers\RolController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuariosController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/administracion', [UsuariosController::class, 'index'])->name('admin.admin');
Route::get('/administracion/usuarios',[UsuariosController::class,'getUsers'])->name('admin.users');
Route::put('/administracion/usuarios/{id}', [UsuariosController::class, 'update'])->name('admin.updateUsuario');
Route::delete('/administracion/usuarios/{id}', [UsuariosController::class, 'deleteUser'])->name('admin.destroyUsuario');
Route::post('/administracion/usuarios', [UsuariosController::class, 'addUser'])->name('admin.storeUsuario'); 
Route::get('/administracion/usuarios/{id}/edit', [UsuariosController::class, 'editUser'])->name('admin.editUsuario');
Route::get('/administracion/roles',[RolController::class,'index'])->name('admin.roles');

Route::get('/administracion/roles',[RolController::class,'index'])->name('admin.roles');
Route::post('/administracion/roles', [RolController::class, 'store'])->name('admin.storeRol');
Route::put('/administracion/roles/{id}', [RolController::class, 'update'])->name('admin.updateRol');
Route::delete('/administracion/roles/{id}', [RolController::class, 'destroy'])->name('admin.deleteRol');