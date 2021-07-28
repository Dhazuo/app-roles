<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


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
Route::get('/', [\App\Http\Controllers\IndexController::class, 'index'])->name('home');
Route::post('/', [\App\Http\Controllers\IndexController::class, 'login'])->name('user.login');
Route::get('admin', [\App\Http\Controllers\AdminController::class, 'index'])->name('admin.home');
Route::post('admin', [\App\Http\Controllers\AdminController::class, 'login'])->name('admin.login');
Route::resource('admin/products', \App\Http\Controllers\ProductController::class)
    ->middleware('can:admin.products.index');
Route::resource('admin/users', \App\Http\Controllers\UserController::class)
    ->only(['index', 'destroy'])
    ->middleware('can:admin.users.index');
