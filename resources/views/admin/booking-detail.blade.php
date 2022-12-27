@extends('layouts.admin')

@section('title', 'booking Details')

<link rel="stylesheet" href="{{ asset('css/table.css') }}">

<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>

<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>

<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

@section('page-name')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="{{ route('booking-admin') }}">รายการจอง</a></li>
            <li class="breadcrumb-item active" aria-current="page">รายละเอียดการจอง</li>
        </ol>
    </nav>
@endsection

@section('content')
    <input type="button" id="edit-btn" class="btn btn-success" value="แก้ใขรายการจอง">
    <input type="button" class="btn btn-success" value="ปริ้นใบรายการจอง">
    <div class="card rounded-3 border border-1 shadow-lg mt-4 mb-4">
        <div class="card-header">
            รายละเอียดการจอง
            @if ($booking->status == 1)
                <span class="badge bg-success">Check In</span>
            @elseif ($booking->status == 2)
                <span class="badge bg-success">Check Out</span>
            @elseif ($booking->status == 3)
                <span class="badge bg-warning text-dark">รอ Check In</span>
            @elseif ($booking->status == 4)
                <span class="badge bg-danger">ยกเลิกการจอง</span></td>
            @elseif ($booking->status == 5)
                <span class="badge bg-warning text-dark">รอชำระเงิน</span>
            @elseif ($booking->status == 6)
                <span class="badge bg-warning text-dark">รอยืนยันการชำระเงิน</span>
            @elseif ($booking->status == 7)
                <span class="badge bg-warning text-dark">รอยืนยันยกเลิกการจอง</span>
            @endif
        </div>
        <div class="card-body">
            <form action="#" method="POST" id="form_edit_booking" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="labels">ชื่อ *</label>
                            <input type="text" name="firstName" class="form-control"
                                value="{{ $booking->user->firstName }}" disabled>
                        </div>
                        <div class="col-md-6">
                            <label class="labels">นามสกุล *</label>
                            <input type="text" name="lastName" class="form-control"
                                value="{{ $booking->user->lastName }}" disabled>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="homestay_name" class="form-label">ที่พัก *</label><br>
                        @foreach ($booking->booking_details as $booking_detail)
                            @foreach ($homestays as $homestay)
                                @if ($booking_detail->homestay->homestay_name == $homestay->homestay_name)
                                    <input type="checkbox" id="hn{{ $homestay->id }}" name="homestay_name"
                                        value="{{ $booking_detail->homestay_id }}" checked disabled>
                                    <label>{{ $booking_detail->homestay->homestay_name }}</label><br>
                                @endif
                            @endforeach
                        @endforeach

                        @foreach ($homestaysN as $n)
                            <input type="checkbox" id="hn {{ $n->id }}" name="homestay_name"
                                value=" {{ $n->id }}" disabled>
                            <label> {{ $n->homestay_name }}</label><br>
                        @endforeach

                    </div>

                    <div class="mb-3">
                        <label for="number_guests" class="form-label">จำนวนผู้เข้าพัก *</label>
                        <input type="number" min="1" step="1" pattern="\d*" class="form-control"
                            id="number_guests" name="number_guests" placeholder="จำนวนผู้เข้าพัก"
                            value="{{ $booking->number_guests }}" disabled required>
                    </div>
                    <div class="mb-3">
                        <label for="number_guests" class="form-label">โปรโมชั่น *</label>
                        <select class="form-select" aria-label="Default select example" disabled>
                            @if ($booking->promotion_id == null)
                                <option selected hidden>เลือกโปรโมชั่น</option>
                                @foreach ($promotions as $promotion)
                                    <option value="{{ $promotion->id }}">{{ $promotion->promotion_name }}</option>
                                @endforeach
                            @else
                                @foreach ($promotions as $promotion)
                                    @if ($booking->promotion_id == $promotion->id)
                                        <option value="{{ $booking->set_menu_id }}" selected>
                                            {{ $promotion->promotion_name }}</option>
                                    @else
                                        <option value="{{ $promotion->id }}">{{ $promotion->promotion_name }}</option>
                                    @endif
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="mb-3">
                        <div class="row mt-2">
                            <div class="col-md-6">
                                <label class="labels">ชุดเมนูอาหาร *</label>
                                <select class="form-select" aria-label="Default select example" disabled>
                                    @foreach ($set_menus as $set_menu)
                                        @if ($booking->set_menu_id == $set_menu->id)
                                            <option value="{{ $booking->set_menu_id }}" selected>
                                                {{ $set_menu->set_menu_name }}</option>
                                        @else
                                            <option value="{{ $set_menu->id }}">{{ $set_menu->set_menu_name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="labels">จำนวนชุดเมนูอาหาร *</label>
                                <input type="number" name="num_menu" class="form-control" value="{{ $booking->num_menu }}"
                                    disabled>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="row mt-2">
                            <div class="col-md-6">
                                <label class="labels">check In *</label>
                                <input type="text" name="firstName" class="form-control"
                                    value="{{ $booking->check_in }}" disabled>
                            </div>
                            <div class="col-md-6">
                                <label class="labels">check In โดย *</label>
                                <input type="text" name="lastName" class="form-control"
                                    value="{{ $booking->check_in_by }}" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="row mt-2">
                            <div class="col-md-6">
                                <label class="labels">check Out *</label>
                                <input type="text" name="firstName" class="form-control"
                                    value="{{ $booking->check_out }}" disabled>
                            </div>
                            <div class="col-md-6">
                                <label class="labels">Check Out โดย *</label>
                                <input type="text" name="lastName" class="form-control"
                                    value="{{ $booking->check_out_by }}" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3">
                        <label for="dateRange" class="form-label">ช่วงวันที่เข้าพัก *</label>
                        <?php
                        $start_date = date('d-m-Y', strtotime($booking->start_date));
                        $end_date = date('d-m-Y', strtotime($booking->end_date));
                        $valueDate = $start_date . ' - ' . $end_date;
                        ?>
                        <input type="text" name="dateRange" value="{{ $valueDate }}" class="form-control"
                            disabled required />
                        <script>
                            $(function() {
                                $('input[name="dateRange"]').daterangepicker({
                                    timePicker: true,
                                    opens: 'left',
                                    locale: {
                                        format: 'DD-MM-YYYY'
                                    }
                                });
                            });
                        </script>
                    </div>
                </div>
                <input type="submit" class="btn btn-success" form="form_edit_booking" value="ยืนยัน" disabled>
            </form>
        </div>
    </div>

    <div class="card rounded-3 border border-1 shadow-lg mt-4 mb-4">
        <div class="card-header">
            รายการเบิกของเพิ่มเติม
        </div>
        <div class="card-body">
            @if ($widens->count() == null)
                <div class="row mt-2">
                    <p>ไม่มีรายการเบิกของเพิ่มเติม</p>
                </div>
            @else
                @foreach ($widens as $widen)
                    <div class="row mt-2">
                        <div class="col-md-4">
                            <label class="labels">ของในคลัง *</label>
                            @if ($widen->appliances_id == $appliances->id)
                                <input type="number" name="appliances_anme" id="appliances_anme" disabled
                                    class="form-control" required value="{{ $appliances->appliances_name }}">
                            @endif
                        </div>
                        <div class="col-md-4">
                            <label class="labels">จำนวน *</label>
                            <input type="number" name="discount" id="discount" disabled class="form-control" required
                                value="{{ $widen->amount }}">
                        </div>
                        <div class="col-md-4">
                            <label class="labels">ราคาคิดเพิ่มเติม *</label>
                            <div class="input-group">
                                <input type="text" name="total_price_discount" id="total_price_discount" disabled
                                    required class="form-control" value="">
                                <span class="input-group-text">บาท</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>

    <div class="card rounded-3 border border-1 shadow-lg mt-4 mb-4">
        <div class="card-header">
            รายละเอียดการจ่ายเงิน
        </div>
        <div class="card-body">
            <div class="row mt-2">
                <div class="col-md-3">
                    <label class="labels">ราคาทั้งหมด *</label>
                    <div class="input-group">
                        <input type="text" name="total_price" id="total_price" disabled required class="form-control"
                            value="{{ $booking->total_price }}">
                        <span class="input-group-text">บาท</span>
                    </div>
                </div>
                <div class="col-md-3">
                    <label class="labels">ส่วนลด *</label>
                    <div class="input-group">
                        <input type="text" name="discount" id="discount" disabled class="form-control" required
                            value="{{ $booking->total_price - $booking->total_price_discount }}">
                        <span class="input-group-text">บาท</span>
                    </div>
                </div>
                <div class="col-md-3">
                    <label class="labels">ราคารวมส่วนลด *</label>
                    <div class="input-group">
                        <input type="text" name="total_price_discount" id="total_price_discount" disabled required
                            class="form-control" value="{{ $booking->total_price_discount }}">
                        <span class="input-group-text">บาท</span>
                    </div>
                </div>
                <div class="col-md-3">
                    <label class="labels">เงินมัดจำ *</label>
                    <div class="input-group">
                        <input type="text" name="deposit" id="deposit" disabled class="form-control" required
                            value="{{ $booking->deposit }}">
                        <span class="input-group-text">บาท</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
