<?php
namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Post;
use App\Models\Author;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::all();
        return view('admin.blog.posts.index', compact('posts'));
    }

    public function create()
    {
        $categories = Category::all();
        $authors = Author::all();
        $tags = Tag::all(); // Fetch all tags for selection
        return view('admin.blog.posts.create', compact('categories', 'authors', 'tags'));
    }

    public function store(Request $request)
    {
        // Validate the input
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'author_id' => 'required|exists:authors,id',
            'content' => 'required|string',
            'excerpt' => 'nullable|string|max:255',
            'test' => 'nullable|array',
            'test.*' => 'exists:tags,id',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'is_published' => 'nullable|boolean',  // Validate the is_published checkbox
        ]);

        // Check for excerpt word limit
        if ($request->has('excerpt')) {
            $excerptWordCount = str_word_count($request->input('excerpt'));
            $maxExcerptWords = 50;
            if ($excerptWordCount > $maxExcerptWords) {
                return back()->withErrors(['excerpt' => "Excerpt must not exceed $maxExcerptWords words."]);
            }
        }

        // Assuming the user is authenticated
        $userId = auth()->user()->id;

        // Generate a slug from the title
        $slug = Str::slug($validated['title'], '-');

        // Handle thumbnail upload if a file is uploaded
        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('thumbnail', 'public');
        }

        // Capture the checkbox value, default to false if not checked
        $isPublished = $request->has('is_published') && $request->input('is_published') == '1';

        // Create the post and include the user_id, slug, and thumbnail path
        $post = Post::create([
            'title' => $validated['title'],
            'slug' => $slug,
            'category_id' => $validated['category_id'],
            'author_id' => $validated['author_id'],
            'content' => $validated['content'],
            'excerpt' => $request->input('excerpt'),
            'user_id' => $userId,
            'thumbnail' => $thumbnailPath,
            'is_published' => $isPublished, // Set the is_published value based on the checkbox
        ]);

        // Attach the tags to the post
        if (!empty($validated['test'])) {
            $post->tags()->sync($validated['test']);
        }

        // Redirect with success message
        return redirect()->route('blog.posts.index')->with('success', 'Post created successfully!');
    }





    public function edit($id)
    {
        $post = Post::findOrFail($id);
        $categories = Category::all();
        $authors = Author::all();
        $tags = Tag::all(); // Fetch all tags for selection
        return view('admin.blog.posts.edit', compact('post', 'categories', 'authors', 'tags'));
    }


    public function update(Request $request, $id)
{
    // Validate the input
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'category_id' => 'required|exists:categories,id',
        'author_id' => 'required|exists:authors,id',
        'content' => 'required|string',
        'excerpt' => 'nullable|string|max:255', // Optional: Add max length or word limit
        'test' => 'nullable|array', // Validate tags as an array
        'test.*' => 'exists:tags,id', // Validate each tag as an existing tag ID
        'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validate thumbnail
       'is_published' => 'nullable|boolean',  // Make sure 'is_published' is handled as a boolean
    ]);

    // Check for excerpt word limit
    if ($request->has('excerpt')) {
        $excerptWordCount = str_word_count($request->input('excerpt'));
        $maxExcerptWords = 50;  // Set the maximum word count for the excerpt
        if ($excerptWordCount > $maxExcerptWords) {
            return back()->withErrors(['excerpt' => "Excerpt must not exceed $maxExcerptWords words."]);
        }
    }

    // Find the post
    $post = Post::findOrFail($id);
    $isPublished = $request->has('is_published') ? true : false;
    // Generate a slug from the title
    $slug = Str::slug($validated['title'], '-');

    // Handle thumbnail upload if a file is uploaded
    $thumbnailPath = $post->thumbnail; // Keep the existing thumbnail path by default
    if ($request->hasFile('thumbnail')) {
        // Store the uploaded thumbnail image in the public/thumbnail folder
        $thumbnailPath = $request->file('thumbnail')->store('thumbnail', 'public');

        // Optionally, delete the old thumbnail if it exists and you are replacing it
        if ($post->thumbnail && file_exists(storage_path('app/public/' . $post->thumbnail))) {
            unlink(storage_path('app/public/' . $post->thumbnail));
        }
    }

    // Update the post with the validated data and new thumbnail path if available
    $post->update([
        'title' => $validated['title'],
        'slug' => $slug, // Add the slug field
        'category_id' => $validated['category_id'],
        'author_id' => $validated['author_id'],
        'content' => $validated['content'],
        'excerpt' => $request->input('excerpt'), // Update the excerpt field
        'thumbnail' => $thumbnailPath, // Save the updated thumbnail path
        'is_published' => $isPublished,
    ]);

    // Sync tags with the post (update tags)
    if (isset($validated['test'])) {
        $post->tags()->sync($validated['test']);
    }

    // Redirect with success message
    return redirect()->route('blog.posts.index')->with('success', 'Post updated successfully!');
}



    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('blog.posts.index')->with('success', 'Post deleted successfully.');
    }
}
