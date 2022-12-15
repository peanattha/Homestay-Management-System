@extends('layouts.admin')

@section('title', 'Manage homestay')

<link rel="stylesheet" href="{{ asset('css/table.css') }}">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script type="text/javascript" src="{{ asset('js/manage-homestay.js') }}"></script>


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

    {{-- Table & manage homestay --}}
    <div class="bg-white p-4 rounded-3 border border-1 shadow-lg">
        <h3>เพิ่ม/ลบ/แก้ใข ที่พัก</h3>
        <form action="{{ route('add-homestay') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="homestay" class="form-label">ที่พัก *</label>
                <input type="text" class="form-control" id="homestay" name="homestay_name" required>
            </div>
            <div class="mb-3">
                <label for="homestay_type" class="form-label">ประเภทที่พัก *</label>
                <select class="form-select" id="homestay_type" name="homestay_type" required>
                    <option selected hidden>เลือกประเภทที่พัก</option>
                    @foreach ($homestay_types as $homestay_type)
                        <option value="{{ $homestay_type->id }}">{{ $homestay_type->homestay_type_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">ราคา (บาท) *</label>
                <input type="text" class="form-control" id="price" name="price" placeholder="ราคาต่อ 1 คืน"
                    required>
            </div>
            <div class="mb-3">
                <label for="number_guests" class="form-label">จำนวนผู้เข้าพักสูงสุด*</label>
                <input type="number" min="1" step="1" pattern="\d*" class="form-control" id="number_guests"
                    name="number_guests" placeholder="จำนวนผู้เข้าพักสูงสุด" required>
            </div>
            <div class="mb-3">
                <label for="bedroom" class="form-label">จำนวนห้องนอน*</label>
                <input type="number" min="1" step="1" pattern="\d*" class="form-control" id="bedroom"
                    name="bedroom" placeholder="จำนวนห้องนอน" required>
            </div>
            <div class="mb-3">
                <label for="bathroom" class="form-label">จำนวนห้องน้ำ*</label>
                <input type="number" min="1" step="1" pattern="\d*" class="form-control" id="bathroom"
                    name="bathroom" placeholder="จำนวนห้องน้ำ" required>
            </div>
            <div class="mb-3">
                <label for="details" class="form-label">รายละเอียด *</label>
                <textarea class="form-control" id="details" name="details" rows="3" required></textarea>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">สถานะการใช้งาน *</label>
                <select class="form-select" id="status" name="status" required>
                    <option selected hidden>สถานะการใช้งาน</option>
                    <option value="1">ใช้งาน</option>
                    <option value="2">ปรับปรุง</option>
                    <option value="3">ยกเลิกใช้งาน</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="FileImgMultiple" class="form-label">รูปภาพ (Multiple files input) *</label>
                <input class="form-control" type="file" id="FileImgMultiple" name="homestay_img[]" multiple required>
            </div>
            <input type="submit" class="btn btn-success" value="เพิ่มที่พัก">
        </form>
    </div>
    <div class="table100 ver2 mb-4 mt-4">
        <div class="table100-head">
            <table>
                <thead>
                    <tr>
                        <th style="width: 10%">ลำดับ</th>
                        <th style="width: 25%">ชื่อที่พัก</th>
                        <th style="width: 25%">ประเภทที่พัก</th>
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
                            <td style="width: 10%">{{ $loop->iteration }}</td>
                            <td style="width: 25%">{{ $homestay->homestay_name }}</td>
                            <td style="width: 25%">{{ $homestay->homestay_type->homestay_type_name }}</td>
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
