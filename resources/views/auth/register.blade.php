@extends('layouts.user')

@section('title', 'สมัครสมาชิก')

@section('reg', 'active')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card m-4 shadow-lg">
                    <div class="card-header">{{ __('สมัครสมาชิก') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="row mb-2">
                                <div class="col-md-6">
                                    <label class="labels">ชื่อ *</label>
                                    <input id="firstName" type="text"
                                        class="form-control @error('firstName') is-invalid @enderror" name="firstName"
                                        value="{{ old('firstName') }}" required autocomplete="firstName" autofocus>
                                    @error('firstName')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="labels">นามสกุล *</label>
                                    <input id="lastName" type="text"
                                        class="form-control @error('lastName') is-invalid @enderror" name="lastName"
                                        value="{{ old('lastName') }}" required autocomplete="lastName" autofocus>

                                    @error('lastName')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-12 mb-2">
                                    <label class="labels">อีเมล *</label>
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required autocomplete="email">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
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

                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-success">
                                        <i class='bx bx-log-in'></i> สมัครสมาชิก
                                    </button>
                                </div>
                            </div>




                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
