@extends('layouts.admin')

@section('title', 'Check-In')

<link rel="stylesheet" href="{{ asset('css/table.css') }}">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
@if (Session::has('error'))
    <script>
        $(window).on('load', function() {
            $('#modal-search-none').modal('show');
        });
    </script>
@endif

<script>
    function showModelCheckIn(booking) {
        // Object.keys(booking).forEach(key => {
        //     console.log(key, booking[key]);
        // });

        $("#idCheckIn").val(booking.id);
        $("#firstNameCheckin").val(booking.user.firstName);
        $("#lastNameCheckin").val(booking.user.lastName);
        $("#date").val(booking.start_date + " - " + booking.end_date);

        var result = "";
        for (let i = 0; i <= (booking.booking_details).length - 1; i++) {
            var string = booking.booking_details[i].homestay.homestay_name;
            var result = result.concat(string);
            if (i == (booking.booking_details).length - 1) {
                $("#homestay").val(result);
            }
        }
        $("#num_guests").val(booking.number_guests);
        $("#total_price").val(booking.total_price);
        $("#discount").val(booking.total_price - booking.total_price_discount);
        $("#total_price_discount").val(booking.total_price_discount);
        $("#deposit").val(booking.deposit);
        $("#toPay").val(booking.total_price_discount - booking.deposit);

        $("#checkInModel").modal("show");

        const payPrice = document.getElementById('payPrice');
        const change = document.getElementById('result');

        const inputHandler = function(e) {
            if (isNaN(e.target.value)) {
                $("#change").val("กรุณาใส่จำนวนเงินตัวเลขจำนวนเต็ม");
                $("#subminCheckIn").prop("readonly", true);
            } else {
                if (((e.target.value)) < booking.deposit) {
                    $("#change").val("กรุณาใส่จำนวนเงินให้มากกว่าเงินที่ต้องจ่าย");
                    $("#subminCheckIn").prop("readonly", true);
                } else {
                    $("#change").val((e.target.value) - booking.deposit);
                    $("#subminCheckIn").prop("readonly", false);
                }
            }
        }
        payPrice.addEventListener('input', inputHandler);
        payPrice.addEventListener('propertychange', inputHandler);
    }
</script>
@section('page-name')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb m-0">
      <li class="breadcrumb-item"><a href="#">รายการจอง</a></li>
      <li class="breadcrumb-item active" aria-current="page">Check-In</li>
    </ol>
  </nav>
@endsection
@section('content')
    {{-- Alert Message --}}
    @if (Session::has('message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ Session::get('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (Session::has('warning'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            {{ Session::get('warning') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="modal fade" id="checkInModel" tabindex="-1" aria-labelledby="checkInModelLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <p class="modal-title" id="checkInModelLabel">Check In</p>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('check-in') }}" method="POST">
                        @csrf
                        <input type="text" style="display: none" name="idCheckIn" readonly id="idCheckIn" required>
                        <div class="row mt-2">
                            <div class="col-md-6">
                                <label class="labels">ชื่อ *</label>
                                <input type="text" name="firstNameCheckin" id="firstNameCheckin" readonly
                                    class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="labels">นามสกุล *</label>
                                <input type="text" name="lastNameCheckin" id="lastNameCheckin" readonly
                                    class="form-control" required>
                            </div>
                        </div>
                        <label class="labels">ช่วงวันเข้าพัก *</label>
                        <input type="text" name="date" id="date" readonly class="form-control" required>
                        <div class="row mt-2">
                            <div class="col-md-6">
                                <label class="labels">บ้านพัก *</label>
                                <input type="text" name="homestay" id="homestay" readonly class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="labels">จำนวนผู้เข้าพัก *</label>
                                <input type="text" name="num_guests" id="num_guests" readonly class="form-control"
                                    required>
                            </div>
                        </div>
                        <hr class="mt-4 mb-4">
                        <div class="row mt-2">
                            <div class="col-md-4">
                                <label class="labels">ราคาทั้งหมด *</label>
                                <div class="input-group">
                                    <input type="text" name="total_price" id="total_price" readonly required
                                        class="form-control">
                                    <span class="input-group-text">บาท</span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="labels">ส่วนลด *</label>
                                <div class="input-group">
                                    <input type="text" name="discount" id="discount" readonly class="form-control"
                                        required>
                                    <span class="input-group-text">บาท</span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="labels">ราคารวมส่วนลด *</label>
                                <div class="input-group">
                                    <input type="text" name="total_price_discount" id="total_price_discount" readonly
                                        required class="form-control">
                                    <span class="input-group-text">บาท</span>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-6">
                                <label class="labels">เงินมัดจำ *</label>
                                <div class="input-group">
                                    <input type="text" name="deposit" id="deposit" readonly class="form-control"
                                        required>
                                    <span class="input-group-text">บาท</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="labels">เงินที่ต้องจ่าย *</label>
                                <div class="input-group">
                                    <input type="text" name="toPay" id="toPay" readonly class="form-control"
                                        required>
                                    <span class="input-group-text">บาท</span>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-6">
                                <label class="labels">รับเงินมา *</label>
                                <div class="input-group">
                                    <input type="text" name="payPrice" id="payPrice" autofocus required
                                        class="form-control" pattern="([0-9]){1,}">
                                    <span class="input-group-text">บาท</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="labels">เงินทอน *</label>
                                <div class="input-group">
                                    <input type="text" name="change" id="change" readonly required
                                        class="form-control">
                                    <span class="input-group-text">บาท</span>
                                </div>
                            </div>
                        </div>
                        <div class="mb-2 mt-2">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                            <button type="submit" class="btn btn-success" id="subminCheckIn" readonly>ยืนยัน Check
                                In</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-search-none" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">แจ้งเตือน</h5>
                </div>
                <div class="modal-body" id="textModelSearchNone">ไม่มีรายการตรงกับที่คุณค้นหา</div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    {{-- ค้นหาCheckIn --}}
    <div class="card rounded-3 border border-1 shadow-lg">
        <div class="card-header">
            Check-In
        </div>
        <div class="card-body">
            <form action="{{ route('search-check-in') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label class="form-label">ค้นหารายการจอง</label>
                    <input type="text" class="form-control" style="margin-right: 10px" id="booking_id"
                        name="booking_id" placeholder="รหัสการจอง">
                    <div id="help" class="form-text">กรอกรหัสการจองเพื่อทำการค้นหารายการจอง</div>
                </div>
                <div class="mb-3">
                    <div class="d-flex flex-row">
                        <input type="text" class="form-control" style="margin-right: 10px" id="firstName"
                            name="firstName" placeholder="ชื่อผู้จอง">
                        <input type="text" class="form-control" style="margin-left: 10px" id="lastName"
                            name="lastName" placeholder="นามสกุลผู้จอง">
                    </div>
                    <div id="help" class="form-text">กรอกชื่อผู้จองเพื่อทำการค้นหารายการจอง</div>
                </div>
                <input type="submit" class="btn btn-success" value="ค้นหา">
            </form>
        </div>
    </div>
    <div class="table100 ver2 mb-4 mt-4">
        <div class="table100-head">
            <table>
                <thead>
                    <tr>
                        <th style="width: 5%">ลำดับ</th>
                        <th style="width: 15%">ชื่อผู้จอง</th>
                        <th style="width: 10%">ชื่อที่พัก</th>
                        <th style="width: 10%">จำนวนผู้เข้าพัก</th>
                        {{-- <th style="width: 10%">สถานะการจ่ายเงิน</th> --}}
                        <th style="width: 10%">สถานะ</th>
                        <th style="width: 15%">เข้าพัก</th>
                        <th style="width: 15%">รายละเอียดเพิ่มเติม</th>
                        <th style="width: 15%">Check-In</th>
                    </tr>
                </thead>
            </table>
        </div>
        <div class="table100-body js-pscroll">
            <table>
                <tbody>
                    @foreach ($bookings as $booking)
                        <tr>
                            <td style="width: 5%">{{ $loop->iteration }}</td>
                            <td style="width: 15%">{{ $booking->user->firstName }} {{ $booking->user->lastName }}</td>
                            <td style="width: 10%">
                                @foreach ($booking->booking_details as $booking_detail)
                                    {{ $booking_detail->homestay->homestay_name }}
                                @endforeach
                            </td>
                            <td style="width: 10%">{{ $booking->number_guests }}</td>
                            <td style="width: 10%"><span class="badge bg-warning text-dark">รอ Check In</span></td>
                            <?php
                            $start_date = date('d-m-Y', strtotime($booking->start_date));
                            $end_date = date('d-m-Y', strtotime($booking->end_date));
                            $valueDate = $start_date . ' - ' . $end_date;
                            ?>
                            <td style="width: 15%">{{ $valueDate }}</td>
                            <td style="width: 15%"><a href="#" class="btn btn-primary">รายละเอียด</a></td>
                            <td style="width: 15%">
                                <button type="button" class="btn btn-success"
                                    onclick="showModelCheckIn({{ $booking }})">
                                    Check In
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
