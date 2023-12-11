<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\DeleteController;
use App\Http\Controllers\Admin\EditorController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\LanguageController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "admin" middleware group. Now create something great!
|
 */

Broadcast::routes(); // for /broadcasting/auth

Route::get('login', function () {
    if (auth('admin')->user()) {
        return redirect()->route('admin.cp');
    }
    return view('Admin.login');
})->name('admin.login');

Route::post('login', [LoginController::class, 'authenticate'])->name('admin.login');

Route::group(['middleware' => ['auth:admin'], 'as' => 'admin.'], function () {
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('cp', [HomeController::class, 'cp'])->name('cp');

    Route::get('swap', [LanguageController::class, 'swap'])->name('swap');

    Route::group(['prefix' => 'users', 'as' => 'users.'], function () {
        Route::controller(UserController::class)->group(function () {
            Route::get('index', 'index')->name('index');
            Route::get('show', 'show')->name('show');
            Route::get('show-add', 'showAdd')->name('showAdd');
            Route::post('add', 'add')->name('add');
            Route::get('show-edit', 'showEdit')->name('showEdit');
            Route::post('edit', 'edit')->name('edit');
            Route::get('export', 'export')->name('export');
        });

        Route::delete('delete', DeleteController::class)->name('delete');
    });

    Route::group(['prefix' => 'admins', 'as' => 'admins.'], function () {
        Route::controller(AdminController::class)->group(function () {
            Route::get('index', 'index')->name('index');
            Route::get('show-add', 'showAdd')->name('showAdd');
            Route::post('add', 'add')->name('add');
            Route::get('show-edit', 'showEdit')->name('showEdit');
            Route::post('edit', 'edit')->name('edit');
        });

        Route::delete('delete', DeleteController::class)->name('delete');
    });

    Route::group(['prefix' => 'editors', 'as' => 'editors.'], function () {
        Route::controller(EditorController::class)->group(function () {
            Route::get('index', 'index')->name('index');
            Route::get('show-add', 'showAdd')->name('showAdd');
            Route::post('add', 'add')->name('add');
            Route::get('show-edit', 'showEdit')->name('showEdit');
            Route::post('edit', 'edit')->name('edit');
        });

        Route::delete('delete', DeleteController::class)->name('delete');
    });

    Route::group(['prefix' => 'roles', 'as' => 'roles.'], function () {
        Route::controller(RoleController::class)->group(function () {
            Route::get('index', 'index')->name('index');
            Route::get('show-add', 'showAdd')->name('showAdd');
            Route::post('add', 'add')->name('add');
            Route::get('show-edit', 'showEdit')->name('showEdit');
            Route::post('edit', 'edit')->name('edit');
            Route::delete('delete', 'delete')->name('delete');
        });
    });

    Route::group(['prefix' => 'articles', 'as' => 'articles.'], function () {
        Route::controller(ArticleController::class)->group(function () {
            Route::get('index', 'index')->name('index');
            Route::get('find', 'find')->name('find');
            Route::post('add', 'add')->name('add');
            Route::post('edit', 'edit')->name('edit');
        });

        Route::delete('delete', DeleteController::class)->name('delete');
    });

});
