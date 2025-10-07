<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubCategory;
class AllCollectionController extends Controller
{
    public function index()
    {
         $subcategories = SubCategory::all();
         return view('allcollection', compact('subcategories'));
    }
}
