@extends('layouts.admin')

@section('title', 'Manage Appliance')

<link rel="stylesheet" href="{{ asset('css/table.css') }}">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

@section('content')

    <div>
        <h3>เบิกของใช้ในคลังเข้าบ้านพัก</h3>
        <form action="#" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="status" class="form-label">บ้านพัก *</label>
                <select class="form-select" id="status" name="status" required>
                    <option selected hidden>เลือกบ้านพัก</option>
                    <option value="1">ใช้งาน</option>
                    <option value="2">ยกเลิกใช้งาน</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">ของใช้ *</label>
                <select class="form-select" id="status" name="status" required>
                    <option selected hidden>เลือกของใช้</option>
                    <option value="1">ใช้งาน</option>
                    <option value="2">ยกเลิกใช้งาน</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="amount" min=0 class="form-label">จำนวน *</label>
                <input type="number" class="form-control" id="amount" name="amount" required>
            </div>
            <input type="submit" class="btn btn-success" value="เบิกของใช้ในคลัง">
        </form>
        <br>
        <hr>
        <br>
        <h3>รายการเบิก</h3>
        <form action="#" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="set_menu_id" class="form-label">ค้นหารายการเบิก</label>
                <input type="text" class="form-control" id="set_menu_id" name="set_menu_id"
                    placeholder="รหัสรายการเบิก">
                <div id="help" class="form-text">กรอกรหัสรายการเบิกเพื่อทำการค้นหารายการเบิก</div>
            </div>
            <div class="mb-3">
                <select class="form-select" id="status" name="status" required>
                    <option selected hidden>เลือกบ้านพัก</option>
                    <option value="1">ใช้งาน</option>
                    <option value="2">ยกเลิกใช้งาน</option>
                </select>
                <div id="help" class="form-text">เลือกชื่อของบ้านพักเพื่อทำการค้นหาบ้านพัก</div>
            </div>
            <div class="mb-3">
                <select class="form-select" id="status" name="status" required>
                    <option selected hidden>เลือกสถานะ</option>
                    <option value="1">ใช้งาน</option>
                    <option value="2">ยกเลิกใช้งาน</option>
                </select>
                <div id="help" class="form-text">เลือกชื่อของบ้านพักเพื่อทำการค้นหาบ้านพัก</div>
            </div>
            <input type="submit" class="btn btn-success" value="ค้นหารายการเบิก">
        </form>
        <div class="table100 ver2 mb-4">
            <div class="table100-head">
                <table>
                    <thead>
                        <tr>
                            <th style="width: 10%">ลำดับ</th>
                            <th style="width: 25%">ชื่อของใช้ในคลัง</th>
                            <th style="width: 10%">จำนวนการเบิก</th>
                            <th style="width: 10%">ชื่อบ้านพัก</th>
                            <th style="width: 25%">รายละเอียด / แก้ไข</th>
                            <th style="width: 10%">คืนของใช้</th>
                        </tr>
                    </thead>
                </table>
            </div>
            <div class="table100-body js-pscroll">
                <table>
                    <tbody>

                            <tr>
                                <td style="width: 10%">1</td>
                                <td style="width: 25%">กาน้ำร้อน</td>
                                <td style="width: 10%">1</td>
                                <td style="width: 10%">บ้านอันดา</td>
                                <td style="width: 25%"><a class="link-primary">รายละเอียด / แก้ไข</a></td>
                                <td style="width: 10%"><a href=""
                                    onclick="return confirm('คุณเเน่ใจที่จะ ยืนยันการชำระเงิน')"
                                    class="btn btn-success">คืนของใช้</a></td>
                            </tr>
                            <tr>
                                <td style="width: 10%">2</td>
                                <td style="width: 25%">ไดรเป่าผม</td>
                                <td style="width: 10%">2</td>
                                <td style="width: 10%">บ้านอันดา</td>
                                <td style="width: 25%"><a class="link-primary">รายละเอียด / แก้ไข</a></td>
                                <td style="width: 10%"><a href=""
                                    onclick="return confirm('คุณเเน่ใจที่จะ ยืนยันการชำระเงิน')"
                                    class="btn btn-success">คืนของใช้</a></td>

                            </tr>
                            <tr>
                                <td style="width: 10%">3</td>
                                <td style="width: 25%">กาน้ำร้อน</td>
                                <td style="width: 10%">1</td>
                                <td style="width: 10%">กระโจม1</td>
                                <td style="width: 25%"><a class="link-primary">รายละเอียด / แก้ไข</a></td>
                                <td style="width: 10%"><a href=""
                                    onclick="return confirm('คุณเเน่ใจที่จะ ยืนยันการชำระเงิน')"
                                    class="btn btn-success">คืนของใช้</a></td>

                            </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
