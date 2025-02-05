@extends('layouts.app')

@section('title', 'Post List')

@section('sidebar')
    @include('layouts.sidebar')
@endsection

@section('header')
    @include('layouts.header')
@endsection

@section('content')
  {{-- Toast Notification --}}
  <div id="toastContainer"
  style="position: fixed; top: 10px; right: 10px; z-index: 1050;">
  @if ($errors->any())
      <div class="toast align-items-center text-white bg-danger border-0 show"
          role="alert" aria-live="assertive" aria-atomic="true">
          <div class="d-flex">
              <div class="toast-body">
                  @foreach ($errors->all() as $error)
                      <p>{{ $error }}</p>
                  @endforeach
              </div>
              <button type="button" class="btn-close btn-close-white me-2 m-auto"
                  data-bs-dismiss="toast" aria-label="Close"></button>
          </div>
      </div>
  @endif

  @if (session('error'))
      <div class="toast align-items-center text-white bg-danger border-0 show"
          role="alert" aria-live="assertive" aria-atomic="true">
          <div class="d-flex">
              <div class="toast-body">
                  {{ session('error') }}
              </div>
              <button type="button" class="btn-close btn-close-white me-2 m-auto"
                  data-bs-dismiss="toast" aria-label="Close"></button>
          </div>
      </div>
  @endif

  @if (session('success'))
      <div class="toast align-items-center text-white bg-success border-0 show"
          role="alert" aria-live="assertive" aria-atomic="true">
          <div class="d-flex">
              <div class="toast-body">
                  {{ session('success') }}
              </div>
              <button type="button" class="btn-close btn-close-white me-2 m-auto"
                  data-bs-dismiss="toast" aria-label="Close"></button>
          </div>
      </div>
  @endif
</div>
    <div class="container-fluid">
        <h4 class="mb-3">Post List</h4>



        {{-- Create Button --}}
        <a href="{{ route('blog.posts.create') }}" class="btn btn-outline-primary mb-3">Create New Post</a>

        {{-- Post Table --}}
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Author</th>
                        <th>Tags</th>
                        <th>Thumbnail</th>
                        <th>Published</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($posts as $post)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $post->title }}</td>
                            <td>{{ $post->category->name ?? 'N/A' }}</td>
                            <td>{{ $post->author->name ?? 'N/A' }}</td>
                            <td>
                                <!-- Loop through tags and display them with badges -->
                                @foreach ($post->tags as $tag)
                                    <span class="badge bg-primary">{{ $tag->name }}</span> <!-- Badge for each tag -->
                                @endforeach
                            </td>
                            <td>
                                <img src="{{ asset('storage/' . $post->thumbnail) }}" alt="{{ $post->title }}" style="width: 100px;">
                            </td>
                            <td>{{ $post->is_published ? 'Yes' : 'No' }}</td>
                            <td>
                                <a href="{{ route('blog.posts.edit', $post->id) }}" class="btn btn-outline-warning btn-sm">Edit</a>

                                <form action="{{ route('blog.posts.destroy', $post->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
