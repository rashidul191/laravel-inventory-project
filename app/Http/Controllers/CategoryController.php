<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Exception;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;

class CategoryController extends Controller
{
    //

    public function categoryPage()
    {
        return view('pages.dashboard.category-page');
    }

    public function createCategory(Request $request)
    {
        // try {

        // dd($request);
        $user_id = $request->header('userId');
        $categoryName = $request->input('name');
        return  Category::create([
            'name' => $categoryName,
            'user_id' =>  $user_id
        ]);
    }

    public function getCategory(Request $request)
    {
        $user_id = $request->header('userId');
        // dd($user_id);
        // $getCategory = Category::where('user_id', $user_id)->get();        
        $getCategory = Category::all();
        return $getCategory;
    }

    public function categoryDelete(Request $request)
    {
        $user_id = $request->header('userId');
        $cat_id = $request->input('id');
        return Category::where('id', $cat_id)->where('user_id', $user_id)->delete();
    }
    public function categoryById(Request $request, $id)
    {
        $user_id = $request->header('userId');
        // $cat_id = $request->input('id');
        $cat_id = $id;
        $result = Category::where('id', $cat_id)->where('user_id', $user_id)->first();
        return $result;
    }

    public function categoryUpdate(Request $request)
    {
        $user_id = $request->header('userId');
        $cat_id = $request->input('id');
        return Category::where('id', $cat_id)->where('user_id', $user_id)->update([
            'name' => $request->input('name')
        ]);
    }
}
