@extends('layouts.admin')

@section('title', 'Menu Details')

<link rel="stylesheet" href="{{ asset('css/table.css') }}">

@section('content')
    {{-- Alert Message --}}
    @if (Session::has('message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ Session::get('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="bg-white p-4 rounded-3 border border-1 shadow-lg">
        <h3>แก้ไขรายละเอียดชุดเมนูอาหาร</h3>
        <form action="{{ route('edit-menu', ['id' => $set_menu->id]) }}" method="POST" id="form_edit_menu"
            enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="menu" class="form-label">ชุดเมนูอาหาร *</label>
                <input type="text" class="form-control" id="menu" name="set_menu_name"
                    value="{{ $set_menu->set_menu_name }}" form="form_edit_menu" required>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">ราคา (บาท) *</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="price" name="price" value="{{ $set_menu->price }}"
                        required>
                    <span class="input-group-text">บาท</span>
                </div>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">สถานะการใช้งาน *</label>
                <select class="form-select" id="status" name="status" required>
                    @if ($set_menu->status == 1)
                        <option value="1" selected>ใช้งาน</option>
                        <option value="2">ยกเลิกใช้งาน</option>
                    @else
                        <option value="1">ใช้งาน</option>
                        <option value="2" selected>ยกเลิกใช้งาน</option>
                    @endif
                </select>
            </div>
            <div class="mb-3">
                <label for="details" class="form-label">รายละเอียด *</label>
                <textarea class="form-control" id="details" name="details" rows="3" form="form_edit_menu" required>{{ $set_menu->detail }}</textarea>
            </div>
            <div class="mb-3">
                <label for="FileImgMultiple" class="form-label">เพิ่มรูปภาพ (Multiple files input)</label>
                <input class="form-control" type="file" id="FileImgMultiple" name="menu_img[]" multiple
                    form="form_edit_menu">
            </div>
            <input type="submit" class="btn btn-success" form="form_edit_menu" value="แก้ใขชุดเมนูอาหาร">
        </form>
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
                    @foreach (json_decode($set_menu->menu_img) as $img)
                        <tr>
                            <td style="width: 10%">{{ $loop->iteration }}</td>
                            <td style="width: 80%">
                                <a href="{{ asset('storage/images/' . $img) }}" target="_bank">
                                    <img src="{{ asset('storage/images/' . $img) }}" width="100px" height="160px"
                                        alt={{ $img }}>
                                </a>
                            </td>
                            <td style="width: 10%">
                                <form action="{{ route('delete-img-menu', ['id' => $set_menu->id, 'menu_img' => $img]) }}"
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
