<?php

use App\Http\Controllers\Editor\ArticleController;
use App\Http\Controllers\Admin\DeleteController;
use App\Http\Controllers\Editor\EditorController;
use App\Http\Controllers\Editor\HomeController;
use App\Http\Controllers\Editor\LanguageController;
use App\Http\Controllers\Editor\LoginController;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Editor Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "admin" middleware group. Now create something great!
|
 */

Broadcast::routes(); // for /broadcasting/auth

Route::get('login', function () {
    if (auth('editor')->user()) {
        return redirect()->route('editor.cp');
    }
    return view('Editor.login');
})->name('editor.login');

Route::post('login', [LoginController::class, 'authenticate'])->name('editor.login');

Route::group(['middleware' => ['auth:editor'], 'as' => 'editor.'], function () {
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('cp', [HomeController::class, 'cp'])->name('cp');

    Route::get('swap', [LanguageController::class, 'swap'])->name('swap');
    
    Route::group(['prefix' => 'editors', 'as' => 'editors.'], function () {
        Route::controller(EditorController::class)->group(function () {
            Route::get('show-edit', 'showEdit')->name('showEdit');
            Route::post('edit', 'edit')->name('edit');
        });
    });

    Route::group(['prefix' => 'articles', 'as' => 'articles.'], function () {
        Route::controller(ArticleController::class)->group(function () {
            Route::get('index', 'index')->name('index')->can('VIEW_ARTICLES');
            Route::get('find', 'find')->name('find')->can('VIEW_ARTICLES');
            Route::post('add', 'add')->name('add')->can('CREATE_ARTICLES');
            Route::post('edit', 'edit')->name('edit')->can('UPDATE_ARTICLES');
        });

        Route::delete('delete', DeleteController::class)->name('delete')->can('DELETE_ARTICLES');
    });

});
