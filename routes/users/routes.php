<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Users\UsersController;
use App\Http\Controllers\Users\ProfilesController;
use App\Http\Controllers\Users\PermissionsController;

Route::prefix('usuarios')->middleware('verify.permissions')->group(function () {
    Route::get('/', [UsersController::class, 'index'])->name('users');
    Route::get('/list', [UsersController::class, 'usersList'])->name('users.list');
    Route::get('/{id}', [UsersController::class, 'editUser'])->name('users.edit')->where('id', '[0-9]+');
    Route::post('/{id}', [UsersController::class, 'updateUser'])->name('users.update')->where('id', '[0-9]+');
    Route::patch('/{id}/{status}', [UsersController::class, 'changeUserStatus'])->name('users.status')->where('id', '[0-9]+');
    Route::get('/novo', [UsersController::class, 'newUser'])->name('users.new');
    Route::post('/novo', [UsersController::class, 'addUser'])->name('users.add');
});

Route::prefix('perfis')->middleware('verify.permissions')->group(function () {
    Route::get('/', [ProfilesController::class, 'index'])->name('profiles');
    Route::get('/list', [ProfilesController::class, 'profilesList'])->name('profiles.list');
    Route::get('/{id}', [ProfilesController::class, 'editProfile'])->name('profiles.edit')->where('id', '[0-9]+');
    Route::post('/{id}', [ProfilesController::class, 'updateProfile'])->name('profiles.update')->where('id', '[0-9]+');
    Route::patch('/{id}/{status}', [ProfilesController::class, 'changeProfileStatus'])->name('profiles.status')->where('id', '[0-9]+');
    Route::get('/novo', [ProfilesController::class, 'newProfile'])->name('profiles.new');
    Route::post('/novo', [ProfilesController::class, 'addProfile'])->name('profiles.add');
});

Route::prefix('permissoes')->middleware('verify.permissions')->group(function () {
    Route::get('/{id}', [PermissionsController::class, 'permissions'])->where('id', '[0-9]+')->name('permissions');
    Route::get('/perfil/{id}', [PermissionsController::class, 'permissionsList'])->where('id', '[0-9]+')->name('permissions.get');
    Route::get('modulos', [PermissionsController::class, 'modules'])->name('permissions.new');
    Route::post('/', [PermissionsController::class, 'addPermission'])->name('permissions.store');
});

Route::prefix('perfil')->group(function () {
    Route::get('/', [UserController::class, 'personalInfo'])->name('user.personal');
    Route::post('/', [UserController::class, 'personalInfoUpdate'])->name('user.personal.update');
    Route::get('/alterar-senha', [UserController::class, 'userPassword'])->name('user.password');
    Route::post('/alterar-senha', [UserController::class, 'updatePassword'])->name('user.password.update');
});
