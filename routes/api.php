<?php

use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UnitController;
use App\Http\Controllers\Store\OrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
// Products
Route::apiResource('/v1/products',ProductController::class);
Route::get('/v1/products/others/listado/{categorias}',[ProductController::class,'listado'])->name('products.listado');
Route::get('/v1/products/others/tops',[ProductController::class,'tops'])->name('products.tops');
Route::get('/v1/products/imagen/{imagen}',[ProductController::class,'get_imagen'])->name('products.get_imagen');
Route::get('/v1/products/swith-state/{product_id}/{valor}',[ProductController::class,'switch_state'])->name('products.get_imagen');
Route::post('/v1/products/importar-excel',[ProductController::class,'importar_excel'])->name('products.importar_excel');
Route::post('/v1/products/importar-excel-ya',[ProductController::class,'importar_excel_ya'])->name('products.importar_excel_ya');

//Categories
Route::apiResource('/v1/categories',CategoryController::class);
Route::get('/v1/categories/imagen/{imagen}',[CategoryController::class,'get_imagen'])->name('category.get_imagen');

//Brands
Route::apiResource('/v1/brands',BrandController::class);

//Units
Route::apiResource('/v1/units',UnitController::class);

//Orders
Route::apiResource('/v1/orders',OrderController::class);
Route::get('/v1/orders/{client_id}/get-all-client',[OrderController::class,'getAllClient'])->name('order.getAllClient');

