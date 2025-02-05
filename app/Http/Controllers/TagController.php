<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str; // Import Str helper

class TagController extends Controller
{
    public function index()
    {
        $tags = Tag::all();  // Fetch all tags
        return view('admin.blog.tags.index', compact('tags'));  // Return the view with tags
    }

    public function create()
    {
        return view('admin.blog.tags.create');  // Return the view for creating a new tag
    }

    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255|unique:tags,name',
        ]);

        // Create the tag with the generated slug
        Tag::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name), // Generate slug from the name
        ]);

        // Redirect to index with success message
        return redirect()->route('blog.tags.index')->with('success', 'Tag added successfully!');
    }

    public function edit(Tag $tag)
    {
        return view('admin.blog.tags.edit', compact('tag'));  // Return the view for editing a tag
    }

    public function update(Request $request, Tag $tag)
    {
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255|unique:tags,name,' . $tag->id,
        ]);

        // Update the tag with the new name and slug
        $tag->name = $request->name;
        $tag->slug = Str::slug($request->name);  // Generate slug from the name
        $tag->save();

        // Redirect to index with success message
        return redirect()->route('blog.tags.index')->with('success', 'Tag updated successfully!');
    }

    public function destroy(Tag $tag)
    {
        $tag->delete();  // Delete the tag
        return redirect()->route('blog.tags.index')->with('success', 'Tag deleted successfully!');  // Redirect to index with success message
    }
}
