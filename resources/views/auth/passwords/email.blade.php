@extends('layouts.user')

@section('title', 'เปลี่ยนรหัสผ่าน')

@section('content')
    <div class="container">

        <div class="row justify-content-center">
            <div class="col-md-8">
                @if (session('status'))
                    <div class="m-4 alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                <div class="card m-4">
                    <div class="card-header">{{ __('เปลี่ยนรหัสผ่าน') }}</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf
                            <div class="row mb-3">
                                <label for="email" class="form-label row-md-4">{{ __('อีเมล') }}</label>

                                <div class="col-md-12">
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required autocomplete="email" autofocus>

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div>
                                    <button type="submit" class="btn btn-success">ส่งลิงก์รีเซ็ตรหัสผ่าน</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
