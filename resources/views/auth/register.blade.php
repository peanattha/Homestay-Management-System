@extends('layouts.user')

@section('title', 'สมัครสมาชิก')

@section('reg', 'active')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card m-4">
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
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="new-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-md-12 mb-2">
                                    <label class="labels">ยืนยันรหัสผ่าน *</label>
                                    <input id="password-confirm" type="password" class="form-control"
                                        name="password_confirmation" required autocomplete="new-password">
                                </div>

                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-success">
                                        <i class='bx bx-log-in' ></i> สมัครสมาชิก
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
