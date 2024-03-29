@extends('layouts.admin')

@section('active-manage-customer', 'active')

@section('title', 'Manage Customer')

<link rel="stylesheet" href="{{ asset('css/table.css') }}">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script>
    function showModelCustomer(id, firstName, lastName) {
        window.id_customer = id;
        document.getElementById("textModelCustomer").innerHTML =
            "คุณเเน่ใจที่จะลบข้อมูลลูกค้า " + firstName + " " + lastName;
        $("#modal-del-customer").modal("show");
    }

    function confirmDelCustomer() {
        document.getElementById("del-customer" + window.id_customer).submit();
    }
</script>

@section('page-name')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item active" aria-current="page">จัดการลูกค้า</li>
        </ol>
    </nav>
@endsection

@section('content')
    {{-- Model Delete Customer --}}
    <div class="modal fade" id="modal-del-customer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">แจ้งเตือน</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="textModelCustomer"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" onclick="confirmDelCustomer()">ยืนยัน</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                </div>
            </div>
        </div>
    </div>
    <div class="card rounded-3 border border-1 shadow-lg">
        <div class="card-header">
            เพิ่มข้อมูลลูกค้า
        </div>
        <div class="card-body">
            <form action="{{ route('add-customer') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row mt-3">
                    <div class="col-md-6">
                        <label class="labels">ชื่อ *</label>
                        <input type="text" name="firstName" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="labels">นามสกุล *</label>
                        <input type="text" name="lastName" class="form-control" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mt-3">
                        <label class="labels">อีเมล *</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="col-md-12 mt-3">
                        <label class="labels">รหัสผ่าน *</label>
                        <input id="password" type="password" class="form-control" name="password" pattern="[\s\S]{8,}"
                            required>
                    </div>
                    <div class="col-md-12 mt-3">
                        <label class="labels">เบอร์โทรศัพท์</label>
                        <input type="text" name="tel" class="form-control" placeholder="099-XXX-XXXX"
                            pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}">
                    </div>
                    <div class="col-md-12 mt-3">
                        <label class="labels">เพศ</label>
                        <select class="form-select" name="gender">
                            <option selected hidden value="">เพศ</option>
                            <option value="M">ชาย</option>
                            <option value="F">หญิง</option>
                            <option value="O">ไม่ต้องการระบุ</option>
                        </select>
                    </div>
                </div>
                {{-- <div class="mt-3">
                    <label for="img_profile" class="form-label">รูปโปรไฟล์</label>
                    <input class="form-control" type="file" id="img_profile" name="img_profile">
                </div> --}}
                <div class="mt-3">
                    <button class="btn btn-success" type="submit">เพิ่มข้อมูลลูกค้า</button>
                </div>
            </form>
        </div>
    </div>
    <hr class="mt-4 mb-4">

    <div class="card rounded-3 border border-1 shadow-lg">
        <div class="card-header">
            รายการข้อมูลลูกค้า
        </div>
        <div class="card-body">
            <form action="{{ route('search-customer') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label class="form-label">ค้นหาลูกค้า</label>
                    <div class="d-flex flex-row">
                        <input type="text" class="form-control" style="margin-right: 10px" id="firstName"
                            name="firstName" placeholder="ชื่อลูกค้า*">
                        <input type="text" class="form-control" style="margin-left: 10px" id="lastName"
                            name="lastName" placeholder="นามสกุลลูกค้า*">
                    </div>
                    <div id="help" class="form-text">กรอกชื่อลูกค้าเพื่อทำการค้นหา</div>
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
                        <th style="width: 20%">ชื่อ-นามสกุล</th>
                        <th style="width: 10%">บทบาท</th>
                        <th style="width: 10%">เบอร์โทรศัพท์</th>
                        <th style="width: 15%">รายละเอียดเพิ่มเติม</th>
                        <th style="width: 10%">ลบข้อมูลลูกค้า</th>
                    </tr>
                </thead>
            </table>
        </div>
        <div class="table100-body js-pscroll">
            <table>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td style="width: 5%">{{ $loop->iteration }}</td>
                            <td style="width: 20%">{{ $user->firstName }} {{ $user->lastName }}</td>
                            @if ($user->role == 1)
                                <td style="width: 10%">ผู้ใช้งาน</td>
                            @elseif ($user->role == 2)
                                <td style="width: 10%">พนักงาน/ผู้ดูเเลระบบ</td>
                            @endif

                            @if ($user->tel == '')
                                <td style="width: 10%">-</td>
                            @else
                                <td style="width: 10%">{{ $user->tel }}</td>
                            @endif
                            <td style="width: 15%"><a href="{{ route('customer-detail', $user->id) }}"
                                    class="btn btn-primary">รายละเอียด</a></td>
                            <td style="width: 10%">
                                <form action="{{ route('delete-customer', ['id' => $user->id]) }}" method="POST"
                                    id="del-customer{{ $user->id }}" class="m-0 ">
                                    @csrf
                                </form>
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#modal-del-customer"
                                    onclick="showModelCustomer({{ $user->id }},'{{ $user->firstName }}','{{ $user->lastName }}')">
                                    ลบข้อมูลลูกค้า
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
