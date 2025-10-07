<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AllCollectionController extends Controller
{
    public function index()
    {

        return view('allcollection');
    }
}
