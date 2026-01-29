<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class AllCollectionController extends Controller
{
    public function index(Request $request)
    {
        $categoryId = $request->query('category');  // get ?category=1

        if ($categoryId) {
            $subcategories = SubCategory::where('category_id', $categoryId)
                ->where('status', 1)
                ->whereHas('category', fn($q) => $q->where('status', 1))
                ->get();
        } else {
            $subcategories = SubCategory::where('status', 1)
                ->whereHas('category', fn($q) => $q->where('status', 1))
                ->get();
        }

        return view('allcollection', compact('subcategories'));
    }
}
