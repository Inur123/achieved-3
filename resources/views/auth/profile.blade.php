@extends('layouts.app')
@section('title', 'My Profile')
@section('sidebar')
    @include('layouts.sidebar')
@endsection
@section('header')
    @include('layouts.header')
@endsection
@section('content')
    <div id="toastContainer" style="position: fixed; top: 10px; right: 10px; z-index: 1050;">
        @if ($errors->any())
            <div class="toast align-items-center text-white bg-danger border-0 show" role="alert" aria-live="assertive"
                aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                        aria-label="Close"></button>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="toast align-items-center text-white bg-danger border-0 show" role="alert" aria-live="assertive"
                aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        {{ session('error') }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                        aria-label="Close"></button>
                </div>
            </div>
        @endif

        @if (session('success'))
            <div class="toast align-items-center text-white bg-success border-0 show" role="alert" aria-live="assertive"
                aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        {{ session('success') }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                        aria-label="Close"></button>
                </div>
            </div>
        @endif
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h3 class="mb-0">My Profile</h3>
                    </div>
                    <div class="card-body">
                        <!-- Profile Update Form -->
                        <form action="{{ route('profile.update') }}" method="POST" id="profileForm"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" name="name" id="name" class="form-control"
                                    value="{{ $user->name }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" id="email" class="form-control"
                                    value="{{ $user->email }}" required>
                            </div>
                            <!-- Profile Image Section -->
                            <div class="mb-3">
                                <label for="avatar" class="form-label me-3">Profile Image</label>
                                <div class="d-flex align-items-center">
                                    <input type="file" name="avatar" id="avatar" class="form-control w-auto" accept="image/*" onchange="previewImage()">
                                    <div class="ms-3" id="imagePreviewContainer">
                                        @if ($user->avatar && file_exists(public_path('storage/' . $user->avatar)))
                                            <img src="{{ asset('storage/' . $user->avatar) }}" alt="Profile Image" width="50" height="50" class="rounded-circle" id="imagePreview">
                                        @else
                                            <div style="width: 50px; height: 50px; background-color: #ccc; color: #fff; display: flex; align-items: center; justify-content: center; border-radius: 50%;">
                                                {{ strtoupper(implode('', array_map(function($name) { return $name[0]; }, array_slice(explode(' ', $user->name), 0, 2)))) }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-outline-primary hidden" id="updateButton">Update Profile</button>
                            <a href="{{ auth()->user()->role_id == 1 ? url('/admin/dashboard') : url('/user/dashboard') }}" class="btn btn-outline-secondary">Kembali</a>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        // Get all the form fields and the update button
        const nameField = document.getElementById('name');
        const emailField = document.getElementById('email');
        const roleField = document.getElementById('role');
        const updateButton = document.getElementById('updateButton');

        // Get the original values to compare against
        const originalName = '{{ $user->name }}';
        const originalEmail = '{{ $user->email }}';
        const originalRole = '{{ $user->role_id }}';

        // Function to check if any changes have been made
        function checkForChanges() {
            const nameChanged = nameField.value !== originalName;
            const emailChanged = emailField.value !== originalEmail;
            const roleChanged = roleField ? roleField.value !== originalRole : false;

            // Show the update button if any change is detected
            if (nameChanged || emailChanged || roleChanged) {
                updateButton.classList.remove('hidden');
            } else {
                updateButton.classList.add('hidden');
            }
        }

        // Attach event listeners to the fields
        nameField.addEventListener('input', checkForChanges);
        emailField.addEventListener('input', checkForChanges);
        if (roleField) {
            roleField.addEventListener('change', checkForChanges);
        }

        // Function to preview the selected image
        function previewImage() {
            const file = document.getElementById('avatar').files[0];
            const reader = new FileReader();

            reader.onload = function(e) {
                const imagePreview = document.getElementById('imagePreview');
                if (imagePreview) {
                    imagePreview.src = e.target.result;
                } else {
                    const previewContainer = document.getElementById('imagePreviewContainer');
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.alt = 'Profile Image';
                    img.width = 50;
                    img.height = 50;
                    img.classList.add('rounded-circle');
                    previewContainer.innerHTML = '';
                    previewContainer.appendChild(img);
                }
            };

            if (file) {
                reader.readAsDataURL(file);
            }
        }
    </script>

@endsection
