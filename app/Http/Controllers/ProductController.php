<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    //

    public function productPage()
    {
        return view('pages.dashboard.product-page');
    }

    // get All Products
    public function productList(Request $request)
    {
        $user_id = $request->header('userId');
        return Product::where('user_id', '=', $user_id)->get();
    }

    // product delete by id
    public function productDelete(Request $request, $id)
    {
        $user_id = $request->header('userId');
        // return Product::where('id', '=', $id)->where('user_id', '=', $user_id)->delete();

        return Product::where(['id' => $id, 'user_id' => $user_id])->delete();

    }
}
