@extends('layouts.admin')

@section('title', 'Manage homestay')

@section('manage-homestay', 'active')

<link rel="stylesheet" href="{{ asset('css/table.css') }}">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script type="text/javascript" src="{{ asset('js/manage-homestay.js') }}"></script>

@section('page-name')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb m-0">
      <li class="breadcrumb-item"><a href="{{route('homestay-admin')}}">รายการที่พัก</a></li>
      <li class="breadcrumb-item active" aria-current="page">จัดการประเภทที่พัก</li>
    </ol>
  </nav>
@endsection
@section('content')
    {{-- Alert Message --}}
    @if (Session::has('message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ Session::get('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (Session::has('warning'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            {{ Session::get('warning') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Model Ples Input --}}
    <div class="modal fade" id="modal-plese-input" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">แจ้งเตือน</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="textModelPleseInput"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยืนยัน</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Model Add homestay Type --}}
    <div class="modal fade" id="modal-add-homestay-type" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">แจ้งเตือน</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="textModelAddhomestayType"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" onclick="confirmAddhomestayType()">ยืนยัน</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Model Delete homestay Type --}}
    <div class="modal fade" id="modal-del-homestay-type" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">แจ้งเตือน</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="textModelDelhomestayType"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" onclick="confirmDelhomestayType()">ยืนยัน</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Model Edit homestay Type --}}
    <div class="modal fade" id="modelEdithomestayType" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <p class="modal-title" id="exampleModalCenterTitle">แก้ใขประเภทที่พัก</p>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('edit-homestay-type') }}" method="POST" class="m-0">
                        @csrf
                        <div class="form-group">
                            <label for="exampleInputEmail1" class="mb-2">ประเภทที่พัก</label>
                            <input type="text" style="display: none" name="id" id="edit-homestay-type-id">
                            <input type="text" class="form-control mb-2" name="homestay_type_name"
                                id="edit-homestay-type" required>
                            <small id="emailHelp" class="form-text text-muted mb-2">แก้ใขประเภทที่พัก</small>
                        </div>
                        <div class="mb-2 mt-2">
                            <button type="submit" class="btn btn-success">ยืนยัน</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Table & Manage homestay Type --}}
    <div class="card rounded-3 border border-1 shadow-lg">
        <div class="card-header">
            เพิ่ม/ลบ/แก้ใข ประเภทที่พัก
        </div>
        <div class="card-body">
            <form action="{{ route('add-homestay-type') }}" method="POST" id="add-homestay-type">
                @csrf
                <div class="mb-3">
                    <label for="homestay_type_name" class="form-label">ประเภทที่พัก *</label>
                    <input type="text" class="form-control" id="homestay_type_name" name="homestay_type_name">
                    <div id="emailHelp" class="form-text">กรอกประเภทที่พักเพื่อเพิ่มประเภทที่พัก</div>
                </div>
                <button type="button" class="btn btn-success" onclick="showModelAddhomestayType()">เพิ่มประเภทที่พัก</button>
            </form>
        </div>
    </div>
    <div class="table100 ver2 mb-4 mt-4">
        <div class="table100-head">
            <table>
                <thead>
                    <tr>
                        <th style="width: 25%">ลำดับ</th>
                        <th style="width: 25%">ประเภทที่พัก</th>
                        <th style="width: 25%">เเก้ไขประเภทที่พัก</th>
                        <th style="width: 25%">ลบประเภทที่พัก</th>
                    </tr>
                </thead>
            </table>
        </div>
        <div class="table100-body js-pscroll">
            <table>
                <tbody>
                    @foreach ($homestay_types as $homestay_type)
                        <tr>
                            <td style="width: 25%">{{ $loop->iteration }}</td>
                            <td style="width: 25%">{{ $homestay_type->homestay_type_name }}</td>
                            <td style="width: 25%">
                                <button type="button" class="btn btn-primary"
                                    onclick="showModelEdithomestayType({{ $homestay_type->id }},'{{ $homestay_type->homestay_type_name }}')">
                                    แก้ไขประเภทที่พัก
                                </button>
                            </td>
                            <td style="width: 25%">
                                <form action="{{ route('delete-homestay-type', ['id' => $homestay_type->id]) }}"
                                    method="POST" id="del-homestay-type{{ $homestay_type->id }}" class="m-0 ">
                                    @csrf
                                </form>
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#modal-del-homestay-type"
                                    onclick="showModelDelhomestayType({{ $homestay_type->id }},'{{ $homestay_type->homestay_type_name }}')">
                                    ลบประเภทที่พัก
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
