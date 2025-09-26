<?php

namespace App\Http\Controllers;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Fetch active categories
         $categories = Category::where('status', 1)->take(5)->get();

        // Pass to the home view
        return view('home', compact('categories'));
    }
}
