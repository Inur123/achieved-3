@extends('layouts.app')

@section('title', 'Edit User')

@section('sidebar')
    @include('layouts.sidebar')
@endsection

@section('header')
    @include('layouts.header')
@endsection

@section('content')
    <div class="container-fluid">
        <h1>Edit User</h1>

        <form action="{{ route('admin.user.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 position-relative">
                <label for="password" class="form-label">Password (Leave blank if you don't want to change)</label>
                <div class="position-relative">
                    <input type="password" class="form-control pe-5 @error('password') is-invalid @enderror" placeholder="Password" id="password" name="password">
                    <i class="fa fa-eye-slash position-absolute top-50 end-0 me-3 translate-middle-y" id="togglePassword" style="cursor: pointer;" onclick="togglePassword()"></i>
                </div>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>


            <a href="{{ route('admin.user.index') }}" class="btn btn-outline-secondary">Cancel</a>
            <button type="submit" class="btn btn-outline-primary">Update User</button>
        </form>
    </div>
@endsection
<script>
    function togglePassword() {
    const passwordInput = document.getElementById('password');
    const eyeIcon = document.getElementById('togglePassword');

    // Toggle the password field visibility
    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        eyeIcon.classList.remove('fa-eye-slash');
        eyeIcon.classList.add('fa-eye');  // Change to open-eye icon
    } else {
        passwordInput.type = "password";
        eyeIcon.classList.remove('fa-eye');
        eyeIcon.classList.add('fa-eye-slash');  // Change to closed-eye icon
    }
}

</script>
@section('footer')
    @include('layouts.footer')
@endsection
