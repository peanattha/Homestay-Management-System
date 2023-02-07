@extends('layouts.admin')

@section('title', 'Manage Promotion')

<link rel="stylesheet" href="{{ asset('css/table.css') }}">

<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>

<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>

<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<script>
    window.onload = function() {
        const select_type = document.getElementById("select_type");
        let type = document.getElementById("select_type").value;
        if (type == 2) {
            document.getElementById("percent").required = true;
            document.getElementById("price").required = false;
            document.getElementById("dis_per").style.display = "block";
            document.getElementById("dis_price").style.display = "none";
        } else {
            document.getElementById("price").required = true;
            document.getElementById("percent").required = false;
            document.getElementById("dis_per").style.display = "none";
            document.getElementById("dis_price").style.display = "block";
        }
        select_type.addEventListener('change', (event) => {
            let type = document.getElementById("select_type").value;
            if (type == 2) {
                document.getElementById("percent").required = true;
                document.getElementById("price").required = false;
                document.getElementById("dis_per").style.display = "block";
                document.getElementById("dis_price").style.display = "none";
            } else {
                document.getElementById("price").required = true;
                document.getElementById("percent").required = false;
                document.getElementById("dis_per").style.display = "none";
                document.getElementById("dis_price").style.display = "block";
            }
        });
    };
</script>

@section('page-name')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="{{ route('manage-promotion') }}">จัดการโปรโมชั่น</a></li>
            <li class="breadcrumb-item active" aria-current="page">แก้ใข โปรโมชั่น</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="card rounded-3 border border-1 shadow-lg">
        <div class="card-header">
            แก้ใข {{ $promotion->promotion_name }}
            @if ($promotion->status == 1)
                <span class="badge bg-success">ใช้งาน</span>
            @elseif($promotion->status == 2)
                <span class="badge bg-danger">ยกเลิกใช้งาน</span>
            @elseif($promotion->status == 3)
                <span class="badge bg-warning text-dark">รอเปิดใช้งาน</span>
            @endif
        </div>
        <div class="card-body">
            <form action="{{ route('edit-promotion', ['id' => $promotion->id]) }}" method="POST">
                @csrf
                <select class="form-select mb-3" id="select_type" name="select_type">
                    @if ($promotion->discount_price != null)
                        <option selected value="1">ส่วนลดราคา (บาท)</option>
                        <option value="2">ส่วนลดเปอร์เซ็นต์</option>
                    @else
                        <option value="1">ส่วนลดราคา (บาท)</option>
                        <option selected value="2">ส่วนลดเปอร์เซ็นต์</option>
                    @endif
                </select>
                <div class="mb-3">
                    <label for="promotion_name" class="form-label">ชื่อโปรโมชั่น *</label>
                    <input type="text" class="form-control" id="promotion_name" name="promotion_name"
                        value="{{ $promotion->promotion_name }}" required>
                </div>
                @if ($promotion->percent != null)
                    <div class="mb-3" id="dis_per">
                        <label for="percent" class="form-label">ราคาส่วนลด (เปอร์เซ็นต์) *</label>
                        <div class="input-group">
                            <input type="number" min="1" class="form-control" id="percent" name="percent"
                                value="{{ $promotion->percent }}">
                            <span class="input-group-text">เปอร์เซ็นต์ (%)</span>
                        </div>
                    </div>
                @endif

                @if ($promotion->discount_price != null)
                    <div class="mb-3" id="dis_price">
                        <label for="price" class="form-label">ราคาส่วนลด (บาท) *</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="price" name="price"
                                value="{{ $promotion->discount_price }}">
                            <span class="input-group-text">บาท</span>
                        </div>
                    </div>
                @endif

                <div class="mb-3">
                    <label for="datetimes" class="form-label">ช่วงวันโปรโมชั่น *</label>
                    <?php
                    $start_date = date('d-m-Y', strtotime($promotion->start_date));
                    $end_date = date('d-m-Y', strtotime($promotion->end_date));

                    $start_time = date('H:i', strtotime($promotion->start_time));
                    $end_time = date('H:i', strtotime($promotion->end_time));

                    $valueDate = $start_date . $start_time . ' - ' . $end_date . $end_time;
                    ?>
                    <input type="text" name="datetimes" value="{{ $valueDate }}" class="form-control" required />
                    <script>
                        $(function() {
                            var today = new Date();
                            var date = (today.getDate()) + '-' + (today.getMonth() + 1) + '-' + today.getFullYear()
                            $('input[name="datetimes"]').daterangepicker({
                                timePicker: true,
                                opens: 'left',
                                minDate: date,
                                locale: {
                                    format: 'DD-MM-YYYY hh:mm A'
                                }
                            });
                        });
                    </script>
                </div>
                <div class="mb-3">
                    <label for="promotion_detail" class="form-label">รายละเอียด *</label>
                    <textarea class="form-control" id="promotion_detail" name="promotion_detail" rows="3" required>{{ $promotion->promotion_detail }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="num_use" class="form-label">จำนวนผู้ใช้ส่วนลดนี้</label>
                    <input type="text" class="form-control" id="num_use" name="num_use"
                        value="{{ $bookings->count() }}" required disabled>
                </div>
                <?php
                $price_use = $bookings->count() * $promotion->discount_price;
                ?>
                <div class="mb-3">
                    <label for="price_use" class="form-label">ราคารวมการใช้งานส่วนลด (บาท)</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="price_use" name="price_use"
                            value="{{ $price_use }}" required disabled>
                        <span class="input-group-text">บาท</span>
                    </div>
                </div>
                <input type="submit" class="btn btn-success" value="แก้ใขโปรโมชั่น">
            </form>
        </div>
    @endsection
