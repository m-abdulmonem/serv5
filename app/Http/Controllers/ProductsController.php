<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductsController extends Controller
{


    function index(Request $request)
    {
        \abort_if(!$request->ajax(), 404);

        $output = '';
        $last_id = '';

        $products = $this->data($request);

        if (!$products->isEmpty()) {
            foreach ($products as $product) {
                $output .= "<div class=product><h1>" . $product->product . "</h1></div>";

                $last_id = $product->id;
            }
            $output .= "<div class='btn btn-primary' id=more data-id='$last_id'>Load more</div>";
        } else {
            $output .= 'no data';
        }
        echo $output;

    }

    public function data($request)
    {
        $query = DB::table('dummy')->orderBy('id', 'DESC')->limit(5);

        if ($keyword = $request->search) {
            $query = $query->orWhere("product", "like", "%$keyword%")->orWhere("brand", "like", "%$keyword%")->orWhere("category", "like", "%$keyword%");
        }

        if (($filter = $request->filter)) {
            $query = $query->orWhereIn("brand", $filter)->orWhereIn("category", $filter);
        }

        if ($request->id > 0) {
            return $query->where('id', '<', $request->id)->get();
        }

        return $query->get();
    }
}
