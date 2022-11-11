@extends('layouts.admin')

@section('title', 'Manage Appliance')

<link rel="stylesheet" href="{{ asset('css/table.css') }}">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

@section('content')

    <div>
        <h3>เบิกของใช้ในคลังจากรายการจอง</h3>
        <form action="#" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="price" min=0 class="form-label">รหัสรายการจอง *</label>
                <input type="text" class="form-control" id="price" name="price" value="1" readonly required>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">ของใช้ *</label>
                <select class="form-select" id="status" name="status" required>
                    <option selected hidden>กาน้ำร้อน</option>
                    <option value="1">ใช้งาน</option>
                    <option value="2">ยกเลิกใช้งาน</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="amount" min=0 class="form-label">จำนวน *</label>
                <input type="number" class="form-control" id="amount" name="amount" required>
            </div>
            <div class="mb-3">
                <label for="price" min=0 class="form-label">ราคา (บาท) *</label>
                <input type="text" class="form-control" id="price" name="price" required>
            </div>
            <div class="mb-3">
                <label for="winden_by" min=0 class="form-label">สถานะ *</label>
                <input type="text" class="form-control" id="winden_by" name="winden_by" value="เบิก" readonly required>
            </div>
            <div class="mb-3">
                <label for="winden_by" min=0 class="form-label">ผู้เบิก *</label>
                <input type="text" class="form-control" id="winden_by" name="winden_by" value="Nuttapopng Thongya" readonly required>
            </div>
            <input type="submit" class="btn btn-success" value="แก้ใขการเบิกของใช้ในคลัง">
        </form>
    </div>
@endsection
