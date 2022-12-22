@extends('layouts.admin')

@section('title', 'Dashboard')

@section('dashboard', 'active')
@section('page-name')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item active" aria-current="page">แดชบอร์ด</li>
        </ol>
    </nav>
@endsection
@section('content')
    {{-- {{ dd(session()->all()) }} --}}
@endsection
