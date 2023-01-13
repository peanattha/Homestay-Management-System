@extends('layouts.user')

@section('homestay', 'active')

@section('title', 'จองบ้านพัก')

@section('page-name')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">หน้าหลัก</a></li>
            <li class="breadcrumb-item"><a href="javascript:history.back()">ค้นหาโฮมสเตย์</a></li>
            <li class="breadcrumb-item active" aria-current="page">จองบ้านพัก</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="container">
        {{ $homestays }}
        {{ $dateRange }}
    </div>
@endsection
