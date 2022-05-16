<?php

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

Route::get('/', function () {
    return view('pages.dashboard');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
/* about page */
Route::get('/about', function () {
    return view('pages.about');
});
/* User page */
Route::get('/user/', [App\Http\Controllers\UserController::class, 'index'])->name('user.index');
/* update password page */
Route::get('/user/password', [App\Http\Controllers\UserController::class, 'password'])->name('user.password.edit');
Route::post('/user/password', [App\Http\Controllers\UserController::class, 'updatePassword'])->name('user.password.update');
/* update profile page */
Route::get('/user/update', [App\Http\Controllers\UserController::class, 'edit'])->name('user.edit');
Route::post('/user/update', [App\Http\Controllers\UserController::class, 'update'])->name('user.update');


/**
 * 管理者画面
 */
Route::group(['prefix' => '/admin', 'namespace' => 'Admin', 'as' => 'admin.'], function () {
    Auth::routes(['verify' => true]);

    Route::get('/', [App\Http\Controllers\Admin\AdminController::class, 'index'])->name('index');
});
