<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register</title>
    <link rel="shortcut icon" type="image/png" href="{{ asset('template/assets/images/logos/logo-2.png') }}" />
    <link rel="stylesheet" href="{{ asset('template/assets/css/styles.min.css') }}" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        /* Loading screen styles */
        #loading-screen {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .spinner {
            border: 4px solid rgba(255, 255, 255, 0.3);
            border-top: 4px solid #5D87FF;
            /* Green success color */
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
</head>

<body>
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        <div id="loading-screen">
            <div class="spinner"></div>
        </div>
        <div
            class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
            <div class="d-flex align-items-center justify-content-center w-100">
                <div class="row justify-content-center w-100">
                    <div class="col-md-8 col-lg-6 col-xxl-4">
                        <div class="card mb-0">
                            <div class="card-body">
                                <div class="d-flex justify-content-center mb-2">
                                    <img src="{{ asset('template/assets/images/logos/logo-3.svg') }}"
                                         style="width: 200px; height: auto;"
                                         alt="">
                                </div>
                                <p class="text-center">Silahkan Daftar</p>
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
                                <form action="{{ route('register.submit') }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="exampleInputNama1" class="form-label">Nama Lengkap</label>
                                        <input type="text" class="form-control" placeholder="Nama Lengkap"
                                            id="exampleInputNama1" aria-describedby="namelHelp" name="name"
                                            value="{{ old('name') }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="exampleInputEmail1" class="form-label">Email</label>
                                        <input type="email" class="form-control" placeholder="Email"
                                            id="exampleInputEmail1" aria-describedby="emailHelp" name="email"
                                            value="{{ old('email') }}" required>
                                    </div>
                                    <div class="mb-3 position-relative">
                                        <label for="exampleInputPassword1" class="form-label">Password</label>
                                        <div class="position-relative">
                                            <input type="password" class="form-control pe-5" placeholder="Password"
                                                id="exampleInputPassword1" name="password" required>
                                            <i class="fa fa-eye-slash position-absolute top-50 end-0 me-3 translate-middle-y"
                                                id="togglePassword" style="cursor: pointer;"></i>
                                        </div>
                                    </div>
                                    <button type="submit"
                                        class="btn btn-primary w-100 py-8 fs-4 mb-2 rounded-2">Daftar</button>

                                    <div class="d-flex align-items-center mb-1">
                                        <hr class="flex-grow-1">
                                        <span class="mx-2 text-muted">atau</span>
                                        <hr class="flex-grow-1">
                                    </div>
                                    <a href="auth/redirect" class="btn btn-danger w-100 py-8 fs-4 mb-2 rounded-2">
                                        <i class="fab fa-google me-2"></i> Daftar dengan Google
                                    </a>
                                    <div class="d-flex align-items-center justify-content-center">
                                        <p class="fs-4 mb-0 fw-normal">Sudah punya akun? Ayo</p>
                                        <a class="text-primary fw-bold ms-2" href="/login">Masuk Sekarang</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('template/assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('template/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script>
        document.getElementById("togglePassword").addEventListener("click", function() {
            const passwordField = document.getElementById("exampleInputPassword1");
            const eyeIcon = document.getElementById("togglePassword");

            if (passwordField.type === "password") {
                passwordField.type = "text";
                eyeIcon.classList.remove("fa-eye-slash");
                eyeIcon.classList.add("fa-eye");
            } else {
                passwordField.type = "password";
                eyeIcon.classList.remove("fa-eye");
                eyeIcon.classList.add("fa-eye-slash");
            }
        });
    </script>

    <script>
        // Hide loading screen once the page is fully loaded
        window.addEventListener("load", function() {
            document.getElementById("loading-screen").style.display = "none";
        });
    </script>
</body>

</html>
