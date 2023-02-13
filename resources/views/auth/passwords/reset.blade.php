<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>รีเซ็ตรหัสผ่าน - Homestay Takayai</title>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <link rel="icon" type="image/svg" href="{{ asset('images/Logo.svg') }}" />

</head>

<body>
    <div class="container mb-2">
        <!-- Header -->
        <header>
            <nav class="container navbar navbar-expand-lg navbar-light py-3">
                <div class="container-fluid">
                    <!-- Logo -->
                    <a href="{{ route('home') }}" class="d-flex align-items-center text-dark text-decoration-none">
                        <span class="fs-4">{{ config('app.name') }}</span>
                    </a>
                    <!-- Logo -->
                    <!-- Responsive Hamburger Menu -->
                    <button type="button" class="navbar-toggler" data-bs-toggle="collapse"
                        data-bs-target="#navbarCollapse">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <!-- Responsive Hamburger Menu -->
                    <!-- Menu -->
                    <div class="collapse navbar-collapse" id="navbarCollapse">
                        <div class="navbar-nav ms-auto">
                            <a href="{{ route('login') }}" class="nav-item nav-link @yield('active-login')">เข้าสู่ระบบ</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}"
                                    class="nav-item nav-link @yield('active-reg')">สมัครสมาชิก</a>
                            @endif
                        </div>
                    </div>
                    <!-- Menu -->
                </div>
            </nav>
        </header>
        <!-- Header -->
    </div>

    <section class="d-flex align-item-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card shadow-lg">
                        <div class="card-header">{{ __('รีเซ็ตรหัสผ่าน') }}</div>

                        <div class="card-body">
                            <form method="POST" action="{{ route('password.update') }}">
                                @csrf

                                <input type="hidden" name="token" value="{{ $token }}">

                                <div class="row mb-3">
                                    <label class="labels">อีเมล *</label>

                                    <div class="col-md-12">
                                        <input id="email" type="email"
                                            class="form-control @error('email') is-invalid @enderror" name="email"
                                            value="{{ $email ?? old('email') }}" required autocomplete="email"
                                            autofocus readonly="readonly">

                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-12 mb-2">
                                    <label class="labels">รหัสผ่าน *</label>
                                    <div class="input-group mb-3">
                                        <input id="password" type="password"
                                            class="form-control @error('password') is-invalid @enderror" name="password"
                                            required autocomplete="new-password">
                                        <span class="input-group-text" style="cursor: pointer" id="toggle-btn"
                                            onclick="togglePassword()">Show</span>
                                    </div>
                                    <script>
                                        function togglePassword() {
                                            var passwordInput = document.getElementById("password");
                                            var toggleBtn = document.getElementById("toggle-btn");
                                            if (passwordInput.type === "password") {
                                                passwordInput.type = "text";
                                                toggleBtn.textContent = "Hide";
                                            } else {
                                                passwordInput.type = "password";
                                                toggleBtn.textContent = "Show";
                                            }
                                        }
                                    </script>
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-md-12 mb-2">
                                    <label class="labels">ยืนยันรหัสผ่าน *</label>

                                    <div class="input-group mb-3">
                                        <input id="password-confirm" type="password" class="form-control"
                                            name="password_confirmation" required autocomplete="new-password">
                                        <span class="input-group-text" style="cursor: pointer" id="toggle-btn2"
                                            onclick="togglePassword2()">Show</span>
                                    </div>
                                    <script>
                                        function togglePassword2() {
                                            var passwordConfirm = document.getElementById("password-confirm");
                                            var toggleBtn2 = document.getElementById("toggle-btn2");
                                            if (passwordConfirm.type === "password") {
                                                passwordConfirm.type = "text";
                                                toggleBtn2.textContent = "Hide";
                                            } else {
                                                passwordConfirm.type = "password";
                                                toggleBtn2.textContent = "Show";
                                            }
                                        }
                                    </script>
                                </div>

                                <div class="row mb-0">
                                    <div>
                                        <button type="submit" class="btn btn-success">
                                            {{ __('รีเซ็ตรหัสผ่าน') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

</html>
