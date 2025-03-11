<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

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
        return Product::where('user_id', '=', $user_id)->orderBy('id', 'desc')->get();
    }

    // Create Product
    public function productCreate(Request $request)
    {
        // dd($request);
        $user_id = $request->header('userId');

        $t = time();
        $img = $request->file('img_url');
        $getImgName = $img->getClientOriginalName();

        $newCreateImgName = "{$user_id}-{$t}-{$getImgName}";
        $img_url = "uploads/{$newCreateImgName}";
        $img->move(public_path('uploads'), $newCreateImgName);

        $result =  Product::create([
            'name' => $request->input('name'),
            'price' => $request->input('price'),
            'unit' => $request->input('unit'),
            'img_url' => $img_url,
            'user_id' => $user_id,
            'category_id' => $request->input('category_id'),
        ]);
        // dd($result);
        return $result;
    }

    // product delete by id
    public function productDelete(Request $request)
    {
        // dd($request);
        $user_id = $request->header('userId');
        $product_id = $request->input('id');
        $file_path = $request->input('img_url');
        File::delete($file_path);
        return Product::where(['id' => $product_id, 'user_id' => $user_id])->delete();
    }

    // product get by id
    public function productGetById(Request $request, $id)
    {
        $user_id = $request->header('userId');
        $product_id = $id;
        return Product::where(['id' => $product_id, 'user_id' => $user_id])->first();
    }

    // Product Update
    public function productUpdate(Request $request, $id)
    {
        $user_id = $request->header('userId');
        $product_id = $id;

        if ($request->hasFile('img_url')) {
            // Upload New File
            $img = $request->file('img_url');
            $t = time();
            $getImgName = $img->getClientOriginalName();
            $newImgName = "{$user_id}-{$t}-{$getImgName}";
            $img_url = "uploads/{$newImgName}";
            $img->move(public_path('uploads'), $newImgName);

            // Delete Old Image

            $oldImg = $request->input('old_img_url');
            File::delete($oldImg);

            // Update Product
            return Product::where(['id' => $product_id, 'user_id' => $user_id])->update([
                'name' => $request->input('name'),
                'price' => $request->input('price'),
                'unit' => $request->input('unit'),
                'img_url' => $img_url,
                'category_id' => $request->input('category_id'),
            ]);
        } else {
            return Product::where(['id' => $product_id, 'user_id' => $user_id])->update([
                'name' => $request->input('name'),
                'price' => $request->input('price'),
                'unit' => $request->input('unit'),
                'category_id' => $request->input('category_id'),
            ]);
        }
    }
}
