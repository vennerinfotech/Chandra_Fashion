<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subcategories = SubCategory::with('category')->latest()->paginate(10);
        return view('admin.categories.subcategories.index', compact('subcategories'));
    }

    /**
     * Get subcategories by category id
     */
    // public function getByCategory($categoryId)
    // {
    //     $subcategories = SubCategory::where('category_id', $categoryId)
    //         ->where('status', 1)
    //         ->get();

    //     return response()->json($subcategories);
    // }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.categories.subcategories.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|unique:sub_categories,name',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $imageName = null;
        if ($request->hasFile('image')) {
            $imageName = time() . '_' . $request->image->getClientOriginalName();
            $request->image->move(public_path('images/subcategories'), $imageName);
        }

        SubCategory::create([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'description' => $request->description,
            'status' => $request->status ?? 1,
            'image' => $imageName,
        ]);

        return redirect()->route('admin.subcategories.index')->with('success', 'SubCategory created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SubCategory $subcategory)
    {
        $categories = Category::all();
        return view('admin.categories.subcategories.edit', compact('subcategory', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SubCategory $subcategory)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|unique:sub_categories,name,' . $subcategory->id,
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $imageName = $subcategory->image;

        if ($request->hasFile('image')) {
            if ($subcategory->image && file_exists(public_path('images/subcategories/' . $subcategory->image))) {
                unlink(public_path('images/subcategories/' . $subcategory->image));
            }

            $imageName = time() . '_' . $request->image->getClientOriginalName();
            $request->image->move(public_path('images/subcategories'), $imageName);
        }

        $subcategory->update([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'description' => $request->description,
            'status' => $request->status ?? 1,
            'image' => $imageName,
        ]);

        return redirect()->route('admin.subcategories.index')->with('success', 'SubCategory updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy(SubCategory $subcategory)
    {
        if ($subcategory->image && file_exists(public_path('images/subcategories/' . $subcategory->image))) {
            unlink(public_path('images/subcategories/' . $subcategory->image));
        }

        $subcategory->delete();

        return redirect()->route('admin.subcategories.index')->with('success', 'SubCategory deleted successfully!');
    }
}
