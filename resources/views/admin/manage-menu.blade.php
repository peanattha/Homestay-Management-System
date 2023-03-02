@extends('layouts.admin')

@section('active-manage-menu', 'active')

@section('title', 'Manage Menu')

<link rel="stylesheet" href="{{ asset('css/table.css') }}">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script type="text/javascript" src="{{ asset('js/manage-menu.js') }}"></script>

<script>
    // Delete menu
    function showModelDelMenu(id, name) {
        window.id_menu = id;
        document.getElementById("textModelDelMenu").innerHTML =
            "คุณเเน่ใจที่จะลบ " + name;
        $("#modal-del-menu").modal("show");
    }

    function confirmDelmenu() {
        document.getElementById("del-menu" + window.id_menu).submit();
    }
</script>

@section('page-name')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item active">จัดการชุดเมนูอาหาร</li>
        </ol>
    </nav>
@endsection

@section('content')
    {{-- Model Delete menu --}}
    <div class="modal fade" id="modal-del-menu" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">แจ้งเตือน</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="textModelDelMenu"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" onclick="confirmDelmenu()">ยืนยัน</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Table & manage Menu --}}
    <div class="card rounded-3 border border-1 shadow-lg">
        <div class="card-header">
            เพิ่มชุดเมนูอาหาร
        </div>
        <div class="card-body">
            <form action="{{ route('add-menu') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="set_menu_name" class="form-label">ชุดเมนูอาหาร *</label>
                    <input type="text" class="form-control" id="set_menu_name" name="set_menu_name" required>
                </div>
                <div class="mb-3">
                    <label for="price" class="form-label">ราคา (บาท) *</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="price" name="price" required>
                        <span class="input-group-text">บาท</span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="status" class="form-label">สถานะการใช้งาน *</label>
                    <select class="form-select" id="status" name="status" required>
                        <option selected hidden>สถานะการใช้งาน</option>
                        <option value="1">ใช้งาน</option>
                        <option value="2">ยกเลิกใช้งาน</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="details" class="form-label">รายละเอียด *</label>
                    <textarea class="form-control" id="details" name="details" rows="3" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="FileImgMultiple" class="form-label">รูปภาพ (Multiple files input) *</label>
                    <input class="form-control" type="file" id="FileImgMultiple" name="menu_img[]" multiple required>
                </div>
                <input type="submit" class="btn btn-success" value="เพิ่มชุดเมนูอาหาร">
            </form>
        </div>
    </div>
    <hr class="mb-4 mt-4">
    <div class="card rounded-3 border border-1 shadow-lg">
        <div class="card-header">
            ชุดเมนูอาหาร
        </div>
        <div class="card-body">
            <form action="{{ route('search-set-menu') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <input type="text" class="form-control" id="set_menu_name" name="set_menu_name"
                        placeholder="ชื่อชุดเมนูอาหาร">
                    <div id="help" class="form-text">กรอกชื่อชุดเมนูอาหารเพื่อทำการค้นหาชุดเมนูอาหาร</div>
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
                        <th style="width: 10%">ลำดับ</th>
                        <th style="width: 25%">ชื่อชุดเมนูอาหาร</th>
                        <th style="width: 10%">สถานะการใช้งาน</th>
                        <th style="width: 25%">รายละเอียด / แก้ไข</th>
                        <th style="width: 10%">ลบชุดเมนู</th>
                    </tr>
                </thead>
            </table>
        </div>
        <div class="table100-body js-pscroll">
            <table>
                <tbody>
                    @foreach ($set_menus as $set_menu)
                        <tr>
                            <td style="width: 10%">{{ $loop->iteration }}</td>
                            <td style="width: 25%">{{ $set_menu->set_menu_name }}</td>
                            @if ($set_menu->status == 1)
                                <td style="width: 10%">ใช้งาน</td>
                            @else
                                <td style="width: 10%">ยกเลิกใช้งาน</td>
                            @endif
                            <td style="width: 25%"><a class="btn btn-primary"
                                    href="{{ route('menu-details', ['id' => $set_menu->id]) }}">รายละเอียด /
                                    แก้ไข</a>
                            </td>
                            <td style="width: 10%">
                                <form action="{{ route('delete-menu', ['id' => $set_menu->id]) }}" method="POST"
                                    id="del-menu{{ $set_menu->id }}">
                                    @csrf
                                </form>
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#modal-del-menu"
                                    onclick="showModelDelMenu({{ $set_menu->id }},'{{ $set_menu->set_menu_name }}')">
                                    ลบชุดเมนู
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
