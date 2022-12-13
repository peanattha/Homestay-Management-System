@extends('layouts.admin')

@section('title', 'Manage homestay')

@section('manage-homestay', 'active')

<link rel="stylesheet" href="{{ asset('css/table.css') }}">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script type="text/javascript" src="{{ asset('js/manage-homestay.js') }}"></script>

@if (Session::get('sameName') == true)
    <script>
        $(window).on('load', function() {
            $('#sameName').modal('show');
        });
    </script>
@endif

@section('content')
    {{-- Model Duplicate homestay Type Name --}}
    <div class="modal fade" id="sameName" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">แจ้งเตือน</h5>
                </div>
                <div class="modal-body">
                    @if (Session::has('name'))
                        <p>มีประเภทที่พัก {{ Session::get('name') }} ในฐานข้อมูลเเล้ว</p>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" onclick="closeModel()">ตกลง</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Model Ples Input --}}
    <div class="modal fade" id="modal-plese-input" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">แจ้งเตือน</h5>
                </div>
                <div class="modal-body" id="textModelPleseInput"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" onclick="closeModel()">ยืนยัน</button>
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
                </div>
                <div class="modal-body" id="textModelAddhomestayType"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" onclick="closeModel()">ยกเลิก</button>
                    <button type="button" class="btn btn-success" onclick="confirmAddhomestayType()">ยืนยัน</button>
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
                </div>
                <div class="modal-body" id="textModelDelhomestayType"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" onclick="closeModel()">ยกเลิก</button>
                    <button type="button" class="btn btn-success" onclick="confirmDelhomestayType()">ยืนยัน</button>
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
                    <h5 class="modal-title" id="exampleModalCenterTitle">แก้ใขประเภทที่พัก</h5>
                </div>
                <div class="modal-body">
                    <form action="{{ route('edit-homestay-type') }}" method="POST" class="m-0">
                        @csrf
                        <div class="form-group">
                            <label for="exampleInputEmail1" class="mb-2">ประเภทที่พัก</label>
                            <input type="text" style="display: none" name="id" id="edit-homestay-type-id">
                            <input type="text" class="form-control mb-2" name="homestay_type_name" id="edit-homestay-type">
                            <small id="emailHelp" class="form-text text-muted mb-2">แก้ใขประเภทที่พัก</small>
                        </div>
                        <div class="mb-2 mt-2">
                            <button type="button" class="btn btn-danger" onclick="closeModel()">ยกเลิก</button>
                            <button type="submit" class="btn btn-success">ยืนยัน</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Table & Manage homestay Type --}}
    <div class="bg-white p-4 rounded-3 border border-1 shadow-lg">
        <h3>เพิ่ม/ลบ/แก้ใข ประเภทที่พัก</h3>
        <form action="{{ route('add-homestay-type') }}" method="POST" id="add-homestay-type">
            @csrf
            <div class="mb-3">
                <label for="homestay_type_name" class="form-label">ประเภทที่พัก *</label>
                <input type="text" class="form-control" id="homestay_type_name" name="homestay_type_name">
                <div id="emailHelp" class="form-text">กรอกประเภทที่พักเพื่อเพิ่มประเภทที่พัก</div>
            </div>
            <button type="button" class="btn btn-success" onclick="showModelAddhomestayType()"
                value="เพิ่มประเภทที่พัก">เพิ่มประเภทที่พัก</button>
        </form>
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
                                <a class="m-0 link-primary"
                                    onclick="showModelEdithomestayType({{ $homestay_type->id }},'{{ $homestay_type->homestay_type_name }}')">
                                    แก้ไขประเภทที่พัก</a>
                            </td>
                            <td style="width: 25%">
                                <form action="{{ route('delete-homestay-type', ['id' => $homestay_type->id]) }}"
                                    method="POST" id="del-homestay-type{{ $homestay_type->id }}" class="m-0 ">
                                    @csrf
                                    <a onclick="showModelDelhomestayType({{ $homestay_type->id }},'{{ $homestay_type->homestay_type_name }}')"
                                        class="m-0 link-danger">ลบประเภทที่พัก</a>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
