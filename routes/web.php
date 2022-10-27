<?php

use App\Http\Controllers\ProductsController;
use App\Models\Category;
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



    // $cats = Category::with(['parent', 'children', 'Ads'])->whereNull('parent_id')->get();


    // $GLOBALS['html'] = [];

    // $htmlG = "";


    // function tree($cats)
    // {
    //     $html = "<ul>";

    //      if ($cats->Ads->count() > 0|| $cats->children->count() > 0){
    //         $html .= "<li>{$cats->id}: {$cats->name}</li>";
    //      }

    //     if ($cats->children->count() > 0) {

    //         foreach ($cats->children as $cat) {

    //             if($cat->ads->count() > 0){
    //                 $html .= "<li>{$cat->id}: {$cat->name}</li>";
    //             }
    //             if($cat->children->count() > 0){
    //                 $html .= "<li>" . tree($cat) . "</li>";
    //             }
    //         }
    //     }
    //     return "$html </ul>";
    // }

    // foreach ($cats as $cat) {

    //     $htmlG .= tree($cat);
    // }

    // return  "$htmlG";



    return view('nested');

















    $data = [
        'categories' => DB::table('dummy')->pluck("category")->unique(),
        'brands' => DB::table('dummy')->pluck("brand")->unique(),
    ];

    return view('index', $data);
});


Route::post("products", [ProductsController::class, "index"])->name("products.index");
