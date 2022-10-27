<?php

use App\Http\Controllers\ProductsController;
use Illuminate\Support\Facades\DB;
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
    $data = [
        'categories' => DB::table('dummy')->pluck("category")->unique(),
        'brands' => DB::table('dummy')->pluck("brand")->unique(),
    ];

    return view('index',$data);
});


Route::post("products",[ProductsController::class,"index"])->name("products.index");
