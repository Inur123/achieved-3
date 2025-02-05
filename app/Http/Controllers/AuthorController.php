<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AuthorController extends Controller
{
    public function index()
    {
        // Menampilkan daftar authors dengan pagination
        $authors = Author::latest()->paginate(10);
        return view('admin.blog.authors.index', compact('authors'));
    }

    public function create()
    {
        // Menampilkan form untuk menambahkan author baru
        return view('admin.blog.authors.create');
    }

    public function store(Request $request)
    {
        // Validasi data
        $request->validate([
            'name' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'description' => 'nullable|string'
        ]);

        // Menyimpan foto jika ada
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('author', 'public');
        }

        // Menyimpan data author ke database
        Author::create([
            'name' => $request->name,
            'photo' => $photoPath,
            'description' => $request->description,
        ]);

        // Redirect ke halaman daftar author
        return redirect()->route('blog.authors.index')->with('success', 'Author berhasil ditambahkan!');
    }

    public function edit(Author $author)
    {
        // Menampilkan form untuk mengedit data author
        return view('admin.blog.authors.edit', compact('author'));
    }

    public function update(Request $request, Author $author)
    {
        // Validasi data
        $request->validate([
            'name' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'description' => 'nullable|string'
        ]);

        // Jika ada foto baru, hapus foto lama dan simpan foto baru
        if ($request->hasFile('photo')) {
            // Hapus foto lama jika ada
            if ($author->photo) {
                Storage::disk('public')->delete('author/' . $author->photo);
            }
            // Menyimpan foto baru
            $author->photo = $request->file('photo')->store('author', 'public');
        }

        // Update data author
        $author->update([
            'name' => $request->name,
            'photo' => $author->photo, // Pastikan untuk menggunakan foto baru jika ada
            'description' => $request->description,
        ]);

        // Redirect ke halaman daftar author
        return redirect()->route('blog.authors.index')->with('success', 'Author berhasil diperbarui!');
    }

    public function destroy(Author $author)
    {
        // Hapus foto dari storage jika ada
        if ($author->photo) {
            Storage::disk('public')->delete('author/' . $author->photo);
        }

        // Hapus data author
        $author->delete();

        // Redirect ke halaman daftar author
        return redirect()->route('blog.authors.index')->with('success', 'Author berhasil dihapus!');
    }
}
