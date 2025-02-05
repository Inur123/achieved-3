@extends('layouts.app')

@section('title', 'Create New Post')

@section('sidebar')
    @include('layouts.sidebar')
@endsection

@section('header')
    @include('layouts.header')
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.jquery.min.js"></script>
<link href="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.min.css" rel="stylesheet" />
@section('content')
    <div class="container-fluid">
        <h4 class="mb-3">Create New Post</h4>

        {{-- Success message --}}
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        {{-- Post Form --}}
        <div class="card">
            <div class="card-body">
                <form action="{{ route('blog.posts.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        {{-- Left Column --}}
                        <div class="col-md-6">
                            {{-- Title --}}
                            <div class="mb-3">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" class="form-control" id="title" name="title"
                                    value="{{ old('title') }}" required>
                            </div>

                            {{-- Category --}}
                            <div class="mb-3">
                                <label for="category_id" class="form-label">Category</label>
                                <select class="form-select" id="category_id" name="category_id" required>
                                    <option value="" disabled selected>Select a Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Author --}}
                            <div class="mb-3">
                                <label for="author_id" class="form-label">Author</label>
                                <select class="form-select" id="author_id" name="author_id" required>
                                    <option value="" disabled selected>Select an Author</option>
                                    @foreach ($authors as $author)
                                        <option value="{{ $author->id }}"
                                            {{ old('author_id') == $author->id ? 'selected' : '' }}>
                                            {{ $author->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Content --}}
                            <div class="mb-3">
                                <label for="content" class="form-label">Content</label>
                                <textarea class="form-control" id="content" name="content" rows="5" required>{{ old('content') }}</textarea>
                            </div>
                        </div>

                        {{-- Right Column --}}
                        <div class="col-md-6">
                            {{-- Excerpt --}}
                            <div class="mb-3">
                                <label for="excerpt" class="form-label">Excerpt</label>
                                <textarea class="form-control" id="excerpt" name="excerpt" rows="3">{{ old('excerpt') }}</textarea>
                            </div>
                            <div class="mb-3">
                                <select data-placeholder="Pilih tag..." multiple class="chosen-select" name="test[]">
                                    <option value=""></option>
                                    @foreach ($tags as $tag)
                                        <option value="{{ $tag->id }}"
                                            @if (in_array($tag->id, old('test', []))) selected @endif>
                                            {{ $tag->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>


                            {{-- Thumbnail --}}
                            <div class="mb-3">
                                <label for="thumbnail" class="form-label">Thumbnail</label>
                                <input type="file" class="form-control" id="thumbnail" name="thumbnail">
                            </div>

                            {{-- Publish Status --}}
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="is_published" name="is_published" value="1"
                                       {{ old('is_published') ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_published">Publish</label>
                            </div>


                            {{-- Published Date --}}
                            <div class="mb-3">
                                <label for="published_at" class="form-label">Published At</label>
                                <input type="datetime-local" class="form-control" id="published_at" name="published_at"
                                    value="{{ old('published_at') }}">
                            </div>

                            {{-- Submit Button --}}
                            <a href="{{ route('blog.posts.index') }}" class="btn btn-outline-secondary">Back</a>
                            <button type="submit" class="btn btn-outline-primary">Create Post</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
    <script>
        $(".chosen-select").chosen({
             width: "95%",
            no_results_text: "Oops, nothing found!"
        })
    </script>

@endsection
