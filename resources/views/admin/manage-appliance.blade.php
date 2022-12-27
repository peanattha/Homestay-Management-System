@extends('layouts.admin')

@section('title', 'Manage Appliance')

<link rel="stylesheet" href="{{ asset('css/table.css') }}">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script>
    function showModelEdithomestayType() {
        $("#modelEdithomestayType").modal("show");
    }
</script>

@section('content')
    <div class="modal fade" id="modelEdithomestayType" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">แก้ใขของใช้ในคลัง</h5>
                </div>
                <div class="modal-body">
                    <form action="{{ route('edit-homestay-type') }}" method="POST" class="m-0">
                        @csrf
                        <div class="form-group">
                            <label for="exampleInputEmail1" class="mb-2">ชื่อของใช้</label>
                            <input type="text" style="display: none" name="id" id="edit-homestay-type-id">
                            <input type="text" class="form-control mb-2" name="homestay_type_name"
                                id="edit-homestay-type">
                            <label for="exampleInputEmail1" class="mb-2">จำนวน</label>
                            <input type="number" class="form-control mb-2" name="homestay_type_name"
                                id="edit-homestay-type">
                            <small id="emailHelp" class="form-text text-muted mb-2">แก้ใขของใช้ในคลัง</small>
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

    <div>
        <h3>จัดการของใช้ในคลัง > เพิ่ม/ลบ/แก้ใข ของใช้ในคลัง</h3>
        <form action="#" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="appliance_name" class="form-label">ชื่อของใช้ *</label>
                <input type="text" class="form-control" id="appliance_name" name="appliance_name" required>
            </div>
            <div class="mb-3">
                <label for="amount" min=0 class="form-label">จำนวน *</label>
                <input type="number" class="form-control" id="amount" name="amount" required>
            </div>
            <input type="submit" class="btn btn-success" value="เพิ่มของใช้ในคลัง">
        </form>
        <br>
        <hr>
        <br>
        <h3>ของใช้ในคลัง</h3>
        <form action="#" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="set_menu_id" class="form-label">ค้นหาของใช้ในคลัง</label>
                <input type="text" class="form-control" id="set_menu_id" name="set_menu_id"
                    placeholder="รหัสของใช้ในคลัง">
                <div id="help" class="form-text">กรอกรหัสของใช้ในคลังเพื่อทำการค้นหาของใช้ในคลัง</div>
            </div>
            <div class="mb-3">
                <input type="text" class="form-control" id="set_menu_name" name="set_menu_name"
                    placeholder="ชื่อของใช้ในคลัง">
                <div id="help" class="form-text">กรอกชื่อของใช้ในคลังเพื่อทำการค้นหาของใช้ในคลัง</div>
            </div>
            <input type="submit" class="btn btn-success" value="ค้นหาของใช้ในคลัง">
        </form>
        <div class="table100 ver2 mb-4">
            <div class="table100-head">
                <table>
                    <thead>
                        <tr>
                            <th style="width: 10%">ลำดับ</th>
                            <th style="width: 25%">ชื่อของใช้ในคลัง</th>
                            <th style="width: 10%">จำนวนคงเหลือ</th>
                            <th style="width: 25%">รายละเอียด / แก้ไข</th>
                            <th style="width: 10%">ลบของใช้</th>
                        </tr>
                    </thead>
                </table>
            </div>
            <div class="table100-body js-pscroll">
                <table>
                    <tbody>

                        <tr>
                            <td style="width: 10%">1</td>
                            <td style="width: 25%">หมอน</td>
                            <td style="width: 10%">10</td>
                            <td style="width: 25%"><a class="link-primary"onclick="showModelEdithomestayType()">รายละเอียด
                                    / แก้ไข</a></td>
                            <td style="width: 10%">
                                <form action="" method="POST" id="" class="m-0">
                                    @csrf
                                    <a onclick="" class="m-0 link-danger">ลบของใช้</a>
                                </form>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 10%">2</td>
                            <td style="width: 25%">หมอนข้าง</td>
                            <td style="width: 10%">10</td>
                            <td style="width: 25%"><a class="link-primary"href="">รายละเอียด / แก้ไข</a></td>
                            <td style="width: 10%">
                                <form action="" method="POST" id="" class="m-0">
                                    @csrf
                                    <a onclick="" class="m-0 link-danger">ลบของใช้</a>
                                </form>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 10%">3</td>
                            <td style="width: 25%">กาน้ำร้อน</td>
                            <td style="width: 10%">7</td>
                            <td style="width: 25%"><a class="link-primary"href="">รายละเอียด / แก้ไข</a></td>
                            <td style="width: 10%">
                                <form action="" method="POST" id="" class="m-0">
                                    @csrf
                                    <a onclick="" class="m-0 link-danger">ลบของใช้</a>
                                </form>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
