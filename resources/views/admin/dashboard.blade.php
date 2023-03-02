@extends('layouts.admin')

@section('active-dashboard', 'active')

@section('title', 'Dashboard')

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
