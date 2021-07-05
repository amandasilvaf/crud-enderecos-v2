<?php

use App\Http\Controllers\Navigation\MenusController;
use App\Http\Controllers\Navigation\ModulesController;
use App\Http\Controllers\Navigation\SubmenusController;
use Illuminate\Support\Facades\Route;

Route::get('navegacao-lateral', [ModulesController::class, 'sideNav']);
Route::prefix('modulos')->middleware('verify.permissions')->group(function () {
    Route::get('/', [ModulesController::class, 'index'])->name('modules');
    Route::get('/list', [ModulesController::class, 'modulesList'])->name('modules.list');
    Route::get('/{id}', [ModulesController::class, 'editModule'])->name('modules.edit')->where('id', '[0-9]+');
    Route::post('/{id}', [ModulesController::class, 'updateModule'])->name('modules.update')->where('id', '[0-9]+');
    Route::patch('/{id}/{status}', [ModulesController::class, 'changeModuleStatus'])->name('modules.status')->where('id', '[0-9]+');
    Route::get('/novo', [ModulesController::class, 'newModule'])->name('modules.new');
    Route::post('/novo', [ModulesController::class, 'addModule'])->name('modules.add');
});

Route::prefix('menus')->middleware('verify.permissions')->group(function () {
    Route::get('/', [MenusController::class, 'index'])->name('menus');
    Route::get('/list', [MenusController::class, 'menusList'])->name('menus.list');
    Route::get('/{id}', [MenusController::class, 'editMenu'])->name('menus.edit')->where('id', '[0-9]+');
    Route::post('/{id}', [MenusController::class, 'updateMenu'])->name('menus.update')->where('id', '[0-9]+');
    Route::patch('/{id}/{status}', [MenusController::class, 'changeMenuStatus'])->name('menus.status')->where('id', '[0-9]+');
    Route::get('/novo', [MenusController::class, 'newMenu'])->name('menus.new');
    Route::post('/novo', [MenusController::class, 'addMenu'])->name('menus.add');
});

Route::prefix('submenus')->middleware('verify.permissions')->group(function () {
    Route::get('/', [SubmenusController::class, 'index'])->name('submenus');
    Route::get('/list', [SubmenusController::class, 'submenusList'])->name('submenus.list');
    Route::get('/{id}', [SubmenusController::class, 'editSubmenu'])->name('submenus.edit')->where('id', '[0-9]+');
    Route::post('/{id}', [SubmenusController::class, 'updateSubmenu'])->name('submenus.update')->where('id', '[0-9]+');
    Route::patch('/{id}/{status}', [SubmenusController::class, 'changeSubmenuStatus'])->name('submenus.status')->where('id', '[0-9]+');
    Route::get('/novo', [SubmenusController::class, 'newSubmenu'])->name('submenus.new');
    Route::post('/novo', [SubmenusController::class, 'addSubmenu'])->name('submenus.add');
});
