<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ProductController extends Controller
{
    public function index(Request $request)
    {
        $sort = json_decode($request->input('sort'));
        $range = json_decode($request->input('range'));
        $filter = json_decode($request->input('filter'));
        $numProducts = $range[1]-$range[0]+1;
        $totalProducts = DB::table('products')->count();
        if(is_null($range)){
            if(strcmp($sort[1],"ASC") == 0){
                $products = Product::orderBy($sort[0])->get();
            }
            else{
                $products = Product::orderByDesc($sort[0])->get();
            }
        }
        else{
            if(strcmp($sort[1],"ASC") == 0){
                $products = Product::orderBy($sort[0])->skip($range[0])->take($numProducts)->get();
            }
            else{
                $products = Product::orderByDesc($sort[0])->skip($range[0])->take($numProducts)->get();
            }
        }
        $response = response()->json($products,200);
        $response->header('Content-Range',"posts 0-".$numProducts."/".$totalProducts);
        $response->header('Access-Control-Expose-Headers','Content-Range');
        return $response;
    }

    public function show(Product $product)
    {
        return $product;
    }

    public function store(Request $request)
    {
        $product = Product::create($request->all());

        return response()->json($product, 201);
    }

    public function update(Request $request, Product $product)
    {
        $product->update($request->all());

        return response()->json($product, 200);
    }

    public function delete(User $product)
    {
        $product->delete();

        return response()->json(null, 204);
    }
}
