<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('admin.blog.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.blog.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Generate slug from the name
        $slug = Str::slug($request->name);

        Category::create([
            'name' => $request->name,
            'slug' => $slug, // Assign the generated slug here
        ]);

        return redirect()->route('blog.categories.index')->with('success', 'Category created successfully.');
    }

    public function edit($id)
{
    $category = Category::findOrFail($id);
    return view('admin.blog.categories.edit', compact('category'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|max:255',
    ]);

    $category = Category::findOrFail($id);
    $category->name = $request->name;
    $category->slug = Str::slug($request->name); // Update the slug

    $category->save();

    return redirect()->route('blog.categories.index')->with('success', 'Category updated successfully.');
}

    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('blog.categories.index')->with('success', 'Category deleted successfully.');
    }
}
