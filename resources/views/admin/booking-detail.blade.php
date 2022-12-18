@extends('layouts.admin')

@section('title', 'booking Details')

<link rel="stylesheet" href="{{ asset('css/table.css') }}">

<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

@section('page-name')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">รายการจอง</a></li>
            <li class="breadcrumb-item"><a href="#">Library</a></li>
            <li class="breadcrumb-item active" aria-current="page">Data</li>
        </ol>
    </nav>
@endsection
@section('content')
    <h3>รายการจอง</h3>
    <input type="button" id="edit-btn" class="btn btn-success" value="แก้ใขรายการจอง">

    {{-- <input type="button" class="btn btn-success" value="ปริ้นใบรายการจอง"> --}}

    <form action="#" method="POST" id="form_edit_booking" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="homestay" class="form-label">ชื่อผู้จอง *</label>
            <div class="d-flex flex-row">
                <input type="text" class="form-control" style="margin-right: 10px" id="firstName" name="firstName"
                    value="{{ $booking->user->firstName }}" disabled required>
                <input type="text" class="form-control" style="margin-left: 10px" id="lastName" name="lastName"
                    value="{{ $booking->user->lastName }}" disabled required>
            </div>
            <div class="mb-3">
                <label for="homestay_name" class="form-label">ชื่อที่พัก *</label>
                <select class="form-select" id="homestay_name" name="homestay_name" form="form_edit_homestay" disabled
                    required>
                    @foreach ($homestays as $homestay)
                        {{-- @if ($booking->homestay->homestay_name == $homestay->homestay_name)
                            <option value="{{ $booking->homestay_id }}" selected>
                                {{ $booking->homestay->homestay_name }}</option>
                        @else
                            <option value="{{ $homestay->id }}">{{ $homestay->homestay_name }}</option>
                        @endif --}}
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="homestay_type" class="form-label">ประเภทที่พัก *</label>
                <select class="form-select" id="homestay_type" name="homestay_type" form="form_edit_homestay" disabled
                    required>
                    @foreach ($homestay_types as $homestay_type)
                        {{-- @if ($booking->homestay->homestay_type->homestay_type_name == $homestay_type->homestay_type_name)
                            <option value="{{ $booking->homestay_type_id }}" selected>
                                {{ $booking->homestay->homestay_type->homestay_type_name }}</option>
                        @else
                            <option value="{{ $homestay_type->id }}">{{ $homestay_type->homestay_type_name }}</option>
                        @endif --}}
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="number_guests" class="form-label">จำนวนผู้เข้าพัก</label>
                <input type="number" min="1" step="1" pattern="\d*" class="form-control" id="number_guests"
                    name="number_guests" placeholder="จำนวนผู้เข้าพัก" value="{{ $booking->number_guests }}" disabled
                    required>
            </div>
            <div class="mt-3 ">
                <label for="homestay" class="form-label">สถานะการจ่ายเงิน *</label>
                {{-- @if ($booking->status == 1)
                    <input type="text" class="form-control" style="margin-right: 10px" id="status"
                        name="status" value="ชำระเงินเเล้ว" disabled required>
                @elseif ($booking->status == 2)
                    <input type="text" class="form-control" style="margin-right: 10px" id="status"
                        name="status" value="รอชำระเงิน" disabled required>
                @elseif ($booking->status == 3)
                    <input type="text" class="form-control" style="margin-right: 10px" id="status"
                        name="status" value="รอยืนยันการชำระเงิน" disabled required>
                @elseif ($booking->status == 4)
                    <input type="text" class="form-control" style="margin-right: 10px" id="status"
                        name="status" value="คืนเงินเสร็จสิ้น" disabled required>
                @elseif ($booking->status == 5)
                    <input type="text" class="form-control" style="margin-right: 10px" id="status"
                        name="status" value="รอคืนเงิน" disabled required>
                @endif --}}
            </div>
            <div class="mt-3 ">
                <label for="homestay" class="form-label">Check In *</label>
                <input type="text" class="form-control" style="margin-right: 10px" id="check_in" name="check_in"
                    value="{{ $booking->check_in }}" disabled required>
            </div>
            <div class="mt-3 ">
                <label for="homestay" class="form-label">Check Out *</label>
                <input type="text" class="form-control" style="margin-right: 10px" id="check_out" name="check_out"
                    value="{{ $booking->check_out }}" disabled required>
            </div>
            <div class="mt-3">
                <label for="dateRange" class="form-label">ช่วงวันที่เข้าพัก *</label>
                <?php
                $start_date = date('d-m-Y', strtotime($booking->start_date));
                $end_date = date('d-m-Y', strtotime($booking->end_date));
                $valueDate = $start_date . ' - ' . $end_date;
                ?>
                <input type="text" name="dateRange" value="{{ $valueDate }}" class="form-control" disabled required />
                <script>
                    $(function() {
                        $('input[name="dateRange"]').daterangepicker({
                            opens: 'left',
                            minDate: date,
                            locale: {
                                format: 'DD-MM-YYYY'
                            }
                        });
                    });
                </script>
            </div>
            <div class="mt-3 ">
                <label for="homestay" class="form-label">ราคารวม *</label>
                <input type="text" class="form-control" style="margin-right: 10px" id="check_out" name="check_out"
                    value="{{ $booking->total_price_discount }}" disabled required>
            </div>
        </div>
        <input type="submit" class="btn btn-success" form="form_edit_booking" value="ยืนยัน" disabled>
    </form>
    <script>
        var form = document.getElementById('form_edit_booking')
        var btn1 = document.getElementById('edit-btn')

        btn1.addEventListener('click', lockForm)

        function lockForm() {
            if (document.getElementById("edit-btn").value == "ยกเลิก") {
                document.getElementById("edit-btn").value = "แก้ใขรายการจอง";
                location.reload();
            } else {
                document.getElementById("edit-btn").value = "ยกเลิก";
                [].slice.call(form.elements).forEach(function(item) {
                    item.disabled = !item.disabled;
                });
                document.getElementById("homestay_name").disabled = false;
                document.getElementById("homestay_type").disabled = false;
                document.getElementById('edit-btn').className = 'btn btn-danger';
            }
        }
    </script>
@endsection
