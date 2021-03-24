<?php

use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UnitController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Store\OrderController;
use Illuminate\Support\Facades\Route;

//Route::get('', [Homecontroller::class, "index"]);

Route::get('', [HomeController::class, 'index'])->middleware('can:Ver dashboard')->name('home');

Route::resource('roles', RoleController::class)->names('roles');

Route::resource('users', UserController::class)->only('index','edit','update')->names('users');
// Route::resource('users', UserController::class)->only('index','edit','update')->names('users');
Route::get('brands', [BrandController::class,'index_view'])->name('brands');
Route::get('units', [UnitController::class,'index_view'])->name('units');
Route::get('categories', [CategoryController::class,'index_view'])->name('categories');
Route::get('products', [ProductController::class,'index_view'])->name('products');
Route::get('products-import', [ProductController::class,'index_import_view'])->name('products_import');
Route::get('orders/list', [OrderController::class,'index_view'])->name('orders_list');
Route::get('orders/list/show/{order_id}', [OrderController::class,'order_show_view'])->name('orders_list.order_show_view');

Route::get('orders/entregadas', [OrderController::class,'orders_entregadas'])->name('orders_entregadas');
Route::get('orders/entregadas/show/{order_id}', [OrderController::class,'order_entregadas_show_view'])->name('orders_entregadas.order_show_view');
Route::get('reportes/list', [OrderController::class,'reportes'])->name('reportes.list');


Route::get('orders/entregar', [OrderController::class,'orders_entregar'])->name('orders_entregar');
Route::get('orders/entregar/show/{order_id}', [OrderController::class,'order_entregar_show_view'])->name('orders_entregar.order_show_view');
