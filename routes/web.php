<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RakController;
use App\Http\Controllers\PublisherController;
use App\Http\Controllers\JoinController;

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
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
  
Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::get('products/trash', [ProductController::class, 'deletelist']);
    Route::get('products/trash/{product}/restore', [ProductController::class, 'restore']);
    Route::get('products/trash/{product}/forcedelete', [ProductController::class, 'deleteforce']);
    Route::resource('products', ProductController::class);
    Route::get('raks/trash', [RakController::class, 'deletelist']);
    Route::get('raks/trash/{product}/restore', [RakController::class, 'restore']);
    Route::get('raks/trash/{product}/forcedelete', [RakController::class, 'deleteforce']);
    Route::resource('raks', RakController::class);
    Route::get('publishers/trash', [PublisherController::class, 'deletelist']);
    Route::get('publishers/trash/{publisher}/restore', [PublisherController::class, 'restore']);
    Route::get('publishers/trash/{publisher}/forcedelete', [PublisherController::class, 'deleteforce']);
    Route::resource('publishers', PublisherController::class);
    Route::get('/totals', [JoinController::class, 'index']);
});