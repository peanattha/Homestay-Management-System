@extends('layouts.user')

@section('title', 'ยืนยันที่อยู่อีเมลของคุณ')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card m-4 shadow-lg">
                <div class="card-header">{{ __('ยืนยันที่อยู่อีเมลของคุณ') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('ลิงก์การยืนยันใหม่ถูกส่งไปยังที่อยู่อีเมลของคุณแล้ว') }}
                        </div>
                    @endif

                    {{ __('ก่อนดำเนินการต่อ โปรดตรวจสอบอีเมลของคุณสำหรับลิงก์ยืนยัน') }}
                    {{ __('หากคุณไม่ได้รับอีเมล') }},
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('คลิกที่นี่เพื่อขออื่น') }}</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
