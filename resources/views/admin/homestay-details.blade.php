@extends('layouts.admin')

@section('title', 'homestay Details')

@section('manage-homestay', 'active')

<link rel="stylesheet" href="{{ asset('css/table.css') }}">
@section('page-name')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="{{ route('homestay-admin') }}">รายการที่พัก</a></li>
            <li class="breadcrumb-item"><a href="{{ route('manage-homestay') }}">จัดการที่พัก</a></li>
            <li class="breadcrumb-item active" aria-current="page">แก้ไขรายละเอียดที่พัก</li>
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
    <div class="card rounded-3 border border-1 shadow-lg">
        <div class="card-header">
            แก้ไขรายละเอียดที่พัก
        </div>
        <div class="card-body">
            <form action="{{ route('edit-homestay', ['id' => $detail->id]) }}" method="POST" id="form_edit_homestay"
                enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="homestay" class="form-label">ที่พัก *</label>
                    <input type="text" class="form-control" id="homestay" name="homestay_name"
                        value="{{ $detail->homestay_name }}" form="form_edit_homestay" required>
                </div>
                <div class="mb-3">
                    <label for="homestay_type" class="form-label">ประเภทที่พัก *</label>
                    <select class="form-select" id="homestay_type" name="homestay_type" form="form_edit_homestay" required>
                        @foreach ($homestay_types as $homestay_type)
                            @if ($detail->homestay_type->homestay_type_name == $homestay_type->homestay_type_name)
                                <option value="{{ $detail->homestay_type_id }}" selected hidden>
                                    {{ $detail->homestay_type->homestay_type_name }}</option>
                            @else
                                <option value="{{ $homestay_type->id }}">{{ $homestay_type->homestay_type_name }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="peice" class="form-label">ราคา *</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="price" name="price" placeholder="ราคาต่อ 1 คืน"
                            value="{{ $detail->homestay_price }}" form="form_edit_homestay" required>
                        <span class="input-group-text">บาท</span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="number_guests" class="form-label">จำนวนผู้เข้าพักสูงสุด*</label>
                    <input type="number" min="1" step="1" pattern="\d*" class="form-control"
                        id="number_guests" name="number_guests" placeholder="จำนวนผู้เข้าพักสูงสุด"
                        value="{{ $detail->number_guests }}" required>
                </div>
                <div class="mb-3">
                    <label for="bedroom" class="form-label">จำนวนห้องนอน*</label>
                    <input type="number" min="1" step="1" pattern="\d*" class="form-control" id="bedroom"
                        name="bedroom" placeholder="จำนวนห้องนอน"value="{{ $detail->num_bedroom }}" required>
                </div>
                <div class="mb-3">
                    <label for="bathroom" class="form-label">จำนวนห้องน้ำ*</label>
                    <input type="number" min="1" step="1" pattern="\d*" class="form-control" id="bathroom"
                        name="bathroom" placeholder="จำนวนห้องน้ำ"value="{{ $detail->num_bathroom }}" required>
                </div>
                <div class="mb-3">
                    <label for="status" class="form-label">สถานะการใช้งาน *</label>
                    <select class="form-select" id="status" name="status" required>
                        @if ($detail->status == 1)
                            <option value="1" selected hidden>ใช้งาน</option>
                            <option value="2">ปรับปรุง</option>
                            <option value="3">ยกเลิกใช้งาน</option>
                        @elseif ($detail->status == 2)
                            <option value="1">ใช้งาน</option>
                            <option value="2" selected hidden>ปรับปรุง</option>
                            <option value="3">ยกเลิกใช้งาน</option>
                        @else
                            <option value="1">ใช้งาน</option>
                            <option value="2">ปรับปรุง</option>
                            <option value="3" selected hidden>ยกเลิกใช้งาน</option>
                        @endif
                    </select>
                </div>

                <div class="mb-3">
                    <label for="details" class="form-label">รายละเอียด *</label>
                    <textarea class="form-control" id="details" name="details" rows="3" form="form_edit_homestay" required>{{ $detail->homestay_detail }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="FileImgMultiple" class="form-label">เพิ่มรูปภาพ (Multiple files input)</label>
                    <input class="form-control" type="file" id="FileImgMultiple" name="homestay_img[]" multiple
                        form="form_edit_homestay">
                </div>
                <input type="submit" class="btn btn-success" form="form_edit_homestay" value="แก้ใขที่พัก">
            </form>
        </div>
    </div>
    <div class="table100 ver2 mb-4 mt-4">
        <div class="table100-head">
            <table>
                <thead>
                    <tr>
                        <th style="width: 10%">ลำดับ</th>
                        <th style="width: 80%">รูปภาพ</th>
                        <th style="width: 10%">ลบรูปภาพ</th>
                    </tr>
                </thead>
            </table>
        </div>
        <div class="table100-body js-pscroll">
            <table>
                <tbody>
                    @foreach (json_decode($detail->homestay_img) as $img)
                        <tr>
                            <td style="width: 10%">{{ $loop->iteration }}</td>
                            <td style="width: 80%">
                                <a href="{{ asset('storage/images/' . $img) }}" target="_bank">
                                    <img src="{{ asset('storage/images/' . $img) }}" width="100px" height="160px"
                                        alt={{ $img }}>
                                </a>
                            </td>
                            <td style="width: 10%">
                                <form action="{{ route('delete-img', ['id' => $detail->id, 'name_img' => $img]) }}"
                                    id="{{ $img }}" method="POST">
                                    @csrf
                                    <input type="submit" class="btn btn-danger" form="{{ $img }}"
                                        value="ลบรูปภาพ">
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
