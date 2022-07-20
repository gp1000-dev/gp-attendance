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
Route::get('/user', [App\Http\Controllers\UserController::class, 'index'])->name('user.index');
/* update password page */
Route::get('/user/password', [App\Http\Controllers\UserController::class, 'password'])->name('user.password.edit');
Route::post('/user/password', [App\Http\Controllers\UserController::class, 'updatePassword'])->name('user.password.update');
/* update profile page */
Route::get('/user/update', [App\Http\Controllers\UserController::class, 'edit'])->name('user.edit');
Route::post('/user/update', [App\Http\Controllers\UserController::class, 'update'])->name('user.update');

/* attendance view page */
Route::get('/attendances', [App\Http\Controllers\AttendanceController::class, 'index'])->name('attendances.index');
/* attendance create page */
Route::get('/attendances/add', [App\Http\Controllers\AttendanceController::class, 'create'])->name('attendances.create');
Route::post('/attendances/add', [App\Http\Controllers\AttendanceController::class, 'store'])->name('attendances.store');
/* attendance edit page */
Route::get('/attendances/edit', [App\Http\Controllers\AttendanceController::class, 'edit'])->name('attendances.edit');
Route::post('/attendances/edit', [App\Http\Controllers\AttendanceController::class, 'update'])->name('attendances.update');
Route::post('/attendances/delete', [App\Http\Controllers\AttendanceController::class, 'delete'])->name('attendances.delete');

/**
 * 管理者画面
 */
Route::group(['prefix' => '/admin', 'namespace' => 'Admin', 'as' => 'admin.'], function () {
    Auth::routes(['verify' => true]);

    Route::get('/', [App\Http\Controllers\Admin\AdminController::class, 'index'])->name('index');
    /* users view page */
    Route::get('/users', [App\Http\Controllers\Admin\AdminUsersController::class, 'index'])->name('users.index');

    Route::get('/users/{id}', [App\Http\Controllers\Admin\AdminUsersController::class, 'show'])->name('users.show');

    Route::get('/users/{id}/edit', [App\Http\Controllers\Admin\AdminUsersController::class, 'edit'])->name('users.edit');

    Route::POST('/users/{id}/edit', [App\Http\Controllers\Admin\AdminUsersController::class, 'update'])->name('users.update');
});
