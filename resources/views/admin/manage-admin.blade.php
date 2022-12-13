@extends('layouts.admin')

@section('title', 'Manage Admin')

@section('manage-admin', 'active')

<link rel="stylesheet" href="{{ asset('css/table.css') }}">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script type="text/javascript" src="{{ asset('js/manage-admin.js') }}"></script>

@if (Session::get('notEmail') == true)
    <script>
        $(window).on('load', function() {
            $('#notEmail').modal('show');
        });
    </script>
@endif

@section('content')
    {{-- Model Email Admin --}}
    <div class="modal fade" id="notEmail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">แจ้งเตือน</h5>
                </div>
                <div class="modal-body">
                    @if (Session::has('email'))
                        <p>ไม่มีอีเมล์ {{ Session::get('email') }} ในฐานข้อมูล</p>
                    @endif
                    @if (Session::has('emailAdmin'))
                        <p>อีเมล์ {{ Session::get('emailAdmin') }} มีสิทธิ์ผู้ดูเเลระบบเเล้ว</p>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" onclick="closeModel()">ตกลง</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Model Delete Admin --}}
    <div class="modal fade" id="modal-del" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">แจ้งเตือน</h5>
                </div>
                <div class="modal-body" id="textModelDel"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" onclick="closeModel()">ยกเลิก</button>
                    <button type="button" class="btn btn-success" onclick="confirmDel()">ยืนยัน</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Model Add Admin --}}
    <div class="modal fade" id="modal-add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">แจ้งเตือน</h5>
                </div>
                <div class="modal-body" id="textModelAdd"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" onclick="closeModel()">ยกเลิก</button>
                    <button type="button" class="btn btn-success" onclick="confirmAdd()">ยืนยัน</button>
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
                <div class="modal-body">กรุณากรอกอีเมล</div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" onclick="closeModel()">ยืนยัน</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Form Add Admin --}}
    <div class="bg-white p-4 rounded-3 border border-1 mb-4 shadow-lg">
        <h3>ผู้ดูเเลระบบ</h3>
        <form action="{{ route('add-admin') }}" method="POST" id="add-admin-form">
            @csrf
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">อีเมล *</label>
                <input type="email" class="form-control" name="email" id="InputAddAdmin" required>
                <div id="help" class="form-text">กรอกอีเมลผู้ใช้เพื่อเพิ่มสิทธิ์ผู้ดูเเลระบบ</div>
            </div>
            <button type="button" class="btn btn-success" onclick="showModelAdd()">เพิ่มผู้ดูเเลระบบ</button>
        </form>
    </div>
    <hr class="mb-4 mt-4">
    {{-- Table & Manage Admin --}}
    <div class="table100 ver2 mb-4">
        <div class="table100-head">
            <table>
                <thead>
                    <tr>
                        <th style="width: 10%">ชื่อ</th>
                        <th style="width: 25%">สกุล</th>
                        <th style="width: 25%">อีเมล</th>
                        <th style="width: 25%">เบอร์โทรศัพท์</th>
                        <th style="width: 15%">ลบสิทธิ์ผู้ดูเเลระบบ</th>
                    </tr>
                </thead>
            </table>
        </div>
        <div class="table100-body js-pscroll">
            <table>
                <tbody>
                    @foreach ($admins as $admin)
                        <tr>
                            <td style="width: 10%">{{ $admin->firstName }}</td>
                            <td style="width: 25%">{{ $admin->lastName }}</td>
                            <td style="width: 25%">{{ $admin->email }}</td>
                            @if ($admin->tel == null)
                                <td style="width: 25%">-</td>
                            @else
                                <td style="width: 25%">{{ $admin->tel }}</td>
                            @endif
                            <td style="width: 15%">
                                <form action="{{ route('delete-admin') }}" method="POST"
                                    id="del-admin-form{{ $admin->id }}" class="m-0 ">
                                    @csrf
                                    <input type="text" name="id" value="{{ $admin->id }}"
                                        style="display: none">
                                    <a onclick="showModelDel({{ $admin->id }},'{{ $admin->email }}')"
                                        class="m-0 link-danger">ลบสิทธิ์ผู้ดูเเลระบบ</a>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection
