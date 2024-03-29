@extends('layouts.admin')

@section('active-homestay-admin', 'active')

@section('title', 'homestay Admin')

<link rel="stylesheet" href="{{ asset('css/table.css') }}">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script type="text/javascript" src="{{ asset('js/manage-homestay.js') }}"></script>

@section('page-name')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item active" aria-current="page">รายการที่พัก</li>
        </ol>
    </nav>
@endsection

@section('content')
    {{-- Model Delete homestay --}}
    <div class="modal fade" id="modal-del-homestay" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">แจ้งเตือน</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="textModelDelhomestay"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" onclick="confirmDelhomestay()">ยืนยัน</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                </div>
            </div>
        </div>
    </div>

    <div class="card rounded-3 border border-1 shadow-lg">
        <div class="card-header">
            รายการที่พัก
        </div>
        <div class="card-body">
            <form action="{{ route('search-homestay-admin') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="homestay" class="form-label">ค้นหารายการที่พัก</label>
                    <input type="text" class="form-control" id="homestay" name="homestay_name" placeholder="ชื่อที่พัก">
                    <div id="help" class="form-text">กรอกชื่อที่พักเพื่อทำการค้นหารายการที่พัก</div>
                </div>
                <div class="mb-3">
                    <input type="text" class="form-control" id="homestay_type" name="homestay_type"
                        placeholder="ชื่อประเภทที่พัก">
                    <div id="help" class="form-text">กรอกชื่อประเภทที่พักเพื่อทำการค้นหารายการที่พัก</div>
                </div>
                <button type="submit" class="btn btn-success">
                    <i class='bx bx-search'></i>
                    ค้นหา
                </button>
            </form>
        </div>
    </div>

    <div class="table100 ver2 mb-4 mt-4">
        <div class="table100-head">
            <table>
                <thead>
                    <tr>
                        <th style="width: 5%">ลำดับ</th>
                        <th style="width: 20%">ชื่อที่พัก</th>
                        <th style="width: 20%">ประเภทที่พัก</th>
                        <th style="width: 15%">สถานะ</th>
                        <th style="width: 25%">รายละเอียด / แก้ไข</th>
                        <th style="width: 10%">ลบที่พัก</th>
                    </tr>
                </thead>
            </table>
        </div>
        <div class="table100-body js-pscroll">
            <table>
                <tbody>
                    @foreach ($homestays as $homestay)
                        <tr>
                            <td style="width: 5%">{{ $loop->iteration }}</td>
                            <td style="width: 20%">{{ $homestay->homestay_name }}</td>
                            <td style="width: 20%">{{ $homestay->homestay_type->homestay_type_name }}</td>
                            @if ($homestay->status == 1)
                                <td style="width: 15%">ใช้งาน</td>
                            @elseif ($homestay->status == 2)
                                <td style="width: 15%">ปรับปรุง</td>
                            @else
                                <td style="width: 15%">ยกเลิกใช้งาน</td>
                            @endif
                            <td style="width: 25%"><a class="btn btn-primary"
                                    href="{{ route('homestay-details-admin', ['id' => $homestay->id]) }}">รายละเอียด /
                                    แก้ไข</a>
                            </td>
                            <td style="width: 10%">
                                <form action="{{ route('delete-homestay', ['id' => $homestay->id]) }}" method="POST"
                                    id="del-homestay{{ $homestay->id }}" class="m-0">
                                    @csrf

                                </form>
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#modal-del-homestay"
                                    onclick="showModelDelhomestay({{ $homestay->id }},'{{ $homestay->homestay_name }}')">
                                    ลบที่พัก
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
