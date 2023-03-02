@extends('layouts.admin')

@section('active-manage-appliance', 'active')

@section('title', 'Manage Appliance')

<link rel="stylesheet" href="{{ asset('css/table.css') }}">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script>
    // Delete appliance
    function showModelDelappliance(id, appliance_name) {
        window.id_appliance = id;
        document.getElementById("textModelDelAppliance").innerHTML =
            "คุณเเน่ใจที่จะลบของใช้ " + appliance_name;
        $("#modal-del-appliance").modal("show");
    }

    function confirmDelAppliance() {
        document
            .getElementById("del-appliance" + window.id_appliance)
            .submit();
    }

    // Edit appliance
    function showModelEditappliance(id, appliance_name, amount, price) {
        $("#appliance_name_edit").val(appliance_name);
        $("#appliance_id").val(id);
        $("#amount_edit").val(amount);
        $("#price_edit").val(price);

        $("#modelEditappliance").modal("show");
    }

    function confirmAddEditappliance() {
        document.getElementById("formEditappliance").submit();
    }
</script>

@section('page-name')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item active" aria-current="page">เพิ่ม/ลบ/แก้ใข ของใช้ในคลัง</li>
        </ol>
    </nav>
@endsection

@section('content')

    <div class="modal fade" id="modelEditappliance" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <p class="modal-title" id="exampleModalCenterTitle">แก้ใขของใช้ในคลัง</p>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('edit-appliance') }}" method="POST" class="m-0" id="formEditappliance">
                        @csrf
                        <div class="form-group">
                            <div class="row mb-4">
                                <input type="text" style="display: none" name="id" id="appliance_id">
                                <div class="mb-3">
                                    <label for="appliance_name" class="labels">ชื่อของใช้ *</label>
                                    <input type="text" class="form-control" id="appliance_name_edit"
                                        name="appliance_name" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="amount" min=0 class="labels">จำนวน *</label>
                                    <input type="number" class="form-control" id="amount_edit" name="amount" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="labels">ราคา *</label>
                                    <div class="input-group">
                                        <input type="text" name="price" id="price_edit" class="form-control" required>
                                        <span class="input-group-text">บาท</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-2 mt-2">
                            <button type="button" class="btn btn-success"
                                onclick="confirmAddEditappliance()">ยืนยัน</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-del-appliance" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">แจ้งเตือน</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="textModelDelAppliance"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" onclick="confirmDelAppliance()">ยืนยัน</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                </div>
            </div>
        </div>
    </div>

    <div>
        <div class="card rounded-3 border border-1 shadow-lg">
            <div class="card-header">
                เพิ่ม/ลบ/แก้ใข ของใช้ในคลัง
            </div>
            <div class="card-body">
                <form action="{{ route('add-appliance') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-4">
                        <div class="mb-3">
                            <label for="appliance_name" class="labels">ชื่อของใช้ *</label>
                            <input type="text" class="form-control" id="appliance_name" name="appliance_name" required>
                        </div>
                        <div class="col-md-6">
                            <label for="amount" min=0 class="labels">จำนวน *</label>
                            <input type="number" class="form-control" id="amount" name="amount" required>
                        </div>
                        <div class="col-md-6">
                            <label class="labels">ราคา *</label>
                            <div class="input-group">
                                <input type="text" name="price" id="price" class="form-control" required>
                                <span class="input-group-text">บาท</span>
                            </div>
                        </div>
                    </div>
                    <input type="submit" class="btn btn-success" value="เพิ่มของใช้ในคลัง">
                </form>
            </div>
        </div>

        <hr class="mb-4 mt-4">

        <div class="card rounded-3 border border-1 shadow-lg">
            <div class="card-header">
                ค้นหาของใช้ในคลัง
            </div>
            <div class="card-body">
                <form action="#" method="POST">
                    @csrf
                    <div class="mb-3">
                        <input type="text" class="form-control" id="appliance_name" name="appliance_name"
                            placeholder="ชื่อของใช้ในคลัง">
                        <div id="help" class="form-text">กรอกชื่อของใช้ในคลังเพื่อทำการค้นหาของใช้ในคลัง</div>
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
                            <th style="width: 25%">ชื่อของใช้ในคลัง</th>
                            <th style="width: 10%">จำนวนคงเหลือ</th>
                            <th style="width: 10%">ราคา</th>
                            <th style="width: 25%">รายละเอียด / แก้ไข</th>
                            <th style="width: 10%">ลบของใช้</th>
                        </tr>
                    </thead>
                </table>
            </div>
            <div class="table100-body js-pscroll">
                <table>
                    <tbody>
                        @foreach ($appliances as $appliance)
                            <tr>
                                <td style="width: 10%">{{ $loop->iteration }}</td>
                                <td style="width: 25%">{{ $appliance->appliance_name }}</td>
                                <td style="width: 10%">{{ $appliance->stock }}</td>
                                <td style="width: 10%">{{ $appliance->price }}</td>
                                <td style="width: 25%"><button class="btn btn-primary"
                                        onclick="showModelEditappliance({{ $appliance->id }},'{{ $appliance->appliance_name }}',{{ $appliance->stock }},{{ $appliance->price }})">แก้ไขของใช้</button>
                                </td>
                                <td style="width: 10%">
                                    <form action="{{ route('delete-appliance', ['id' => $appliance->id]) }}"
                                        method="POST" id="del-appliance{{ $appliance->id }}" class="m-0">
                                        @csrf
                                    </form>
                                    <button type="button" class="btn btn-danger"
                                        onclick="showModelDelappliance({{ $appliance->id }},'{{ $appliance->appliance_name }}')">
                                        ลบของใช้
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
