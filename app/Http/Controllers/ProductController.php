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
}
