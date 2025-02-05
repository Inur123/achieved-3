@extends('layouts.app')
@section('title', 'Create Author')
@section('sidebar')
    @include('layouts.sidebar')
@endsection
@section('header')
    @include('layouts.header')
@endsection
@section('content')
    {{-- Form to create a new author --}}
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <h4 class="mb-3">Create Author</h4>
                <div class="card">
                    <div class="card-body">
                        <!-- Form for creating a new author -->
                        <form action="{{ route('blog.authors.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="photo" class="form-label">Photo</label>
                                <input type="file" class="form-control" id="photo" name="photo" accept="image/*">
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                            </div>

                            <div class="flex justify-between mt-3">
                                <a href="{{ route('blog.authors.index') }}" class="btn btn-outline-secondary">Back</a>
                                <button type="submit" class="btn btn-outline-primary ml-3">Save Author</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
