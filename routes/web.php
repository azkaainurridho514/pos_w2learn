<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ProductsController;

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

Route::get('/', fn() => redirect()->route('login'));

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('home');
    })->name('dashboard');
});

Route::group(['middleware' => 'auth'], function(){
    Route::get('/categories/data', [CategoriesController::class, 'data'])->name('categories.data');
    Route::resource('/categories', CategoriesController::class);

    Route::get('/products/data', [ProductsController::class, 'data'])->name('products.data');
    Route::post('/products/delete-selected', [ProductsController::class, 'deleteSelected'])->name('products.delete_selected');
    Route::resource('/products', ProductsController::class);
});
