@extends('layouts.app')
@section('title', 'Edit Author')
@section('sidebar')
    @include('layouts.sidebar')
@endsection
@section('header')
    @include('layouts.header')
@endsection
@section('content')
    {{-- Edit Author Form --}}
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <h4 class="mb-3">Edit Author</h4>
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('blog.authors.update', $author->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $author->name) }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="description">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="3">{{ old('description', $author->description) }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="photo">Photo</label>
                                <input type="file" class="form-control" id="photo" name="photo">
                                @if ($author->photo)
                                    <img src="{{ asset('storage/' . $author->photo) }}" alt="{{ $author->name }}" width="50" class="mt-2">
                                @endif
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-outline-primary">Save Author</button>
                                <a href="{{ route('blog.authors.index') }}" class="btn btn-outline-secondary">Back</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
