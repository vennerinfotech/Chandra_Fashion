<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class AllCollectionController extends Controller
{
public function index(Request $request)
{
    $categoryId = $request->query('category'); // get ?category=1

    if ($categoryId) {
        $subcategories = SubCategory::where('category_id', $categoryId)->get();
    } else {
        $subcategories = SubCategory::all();
    }

    return view('allcollection', compact('subcategories'));
}


}
