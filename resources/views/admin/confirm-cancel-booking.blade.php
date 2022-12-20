@extends('layouts.admin')

@section('title', 'Confirm Booking')

<link rel="stylesheet" href="{{ asset('css/table.css') }}">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script>
    function showModelCancle(id) {
        window.id = id;
        document.getElementById("textModelCancle").innerHTML =
            "คุณเเน่ใจที่จะยกเลิกการจอง";
        $("#modal-cancle").modal("show");
    }

    function confirmCancle() {
        document.getElementById("cancle-pay-form" + window.id).submit();
    }
</script>

@section('page-name')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="#">รายการจอง</a></li>
            <li class="breadcrumb-item active" aria-current="page">รายการจองที่ยืนยันการยกเลิก</li>
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

    {{-- Model Cancle --}}
    <div class="modal fade" id="modal-cancle" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">แจ้งเตือน</h5>
                </div>
                <div class="modal-body" id="textModelCancle"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" onclick="confirmCancle()">ยืนยัน</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                </div>
            </div>
        </div>
    </div>

    {{-- ค้นหารายการจองที่ต้องยืนยันยกเลิก --}}
    <div class="card rounded-3 border border-1 shadow-lg">
        <div class="card-header">
            รายการจองที่ยืนยันการยกเลิก
        </div>
        <div class="card-body">
            <form action="{{ route('search-confirm-cancel') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label class="form-label">ค้นหารายการจอง</label>
                    <input type="text" class="form-control" style="margin-right: 10px" id="booking_id" name="booking_id"
                        placeholder="รหัสการจอง">
                    <div id="help" class="form-text">กรอกรหัสการจองเพื่อทำการค้นหารายการจอง</div>
                </div>
                <div class="mb-3">
                    <div class="d-flex flex-row">
                        <input type="text" class="form-control" style="margin-right: 10px" id="firstName"
                            name="firstName" placeholder="ชื่อผู้จอง">
                        <input type="text" class="form-control" style="margin-left: 10px" id="lastName" name="lastName"
                            placeholder="นามสกุลผู้จอง">
                    </div>
                    <div id="help" class="form-text">กรอกชื่อผู้จองเพื่อทำการค้นหารายการจอง</div>
                </div>
                <button type="submit" class="btn btn-success">
                    <i class='bx bx-search' ></i>
                    ค้นหา
                </button>
            </form>
        </div>
    </div>

    {{-- Table รายการจองที่ต้องยืนยันยกเลิก --}}
    <div class="table100 ver2 mb-4 mt-4">
        <div class="table100-head">
            <table>
                <thead>
                    <tr>
                        <th style="width: 5%">ลำดับ</th>
                        <th style="width: 20%">ชื่อผู้จอง</th>
                        <th style="width: 10%">ชื่อที่พัก</th>
                        <th style="width: 10%">จำนวนผู้เข้าพัก</th>
                        <th style="width: 15%">รูปสลิปจ่ายเงิน</th>
                        <th style="width: 15%">รายละเอียดเพิ่มเติม</th>
                        <th style="width: 20%">ยืนยันการยกเลิก</th>
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
                            <td style="width: 20%">{{ $booking->user->firstName }} {{ $booking->user->lastName }}</td>
                            <td style="width: 10%">
                                @foreach ($booking->booking_details as $booking_detail)
                                    {{ $booking_detail->homestay->homestay_name }}
                                @endforeach
                            </td>
                            <td style="width: 10%">{{ $booking->number_guests }}</td>
                            <td style="width: 15%"><a href="#">สลิปจ่ายเงิน</a></td>
                            <td style="width: 15%"><a href="#"class="btn btn-primary">รายละเอียด</a></td>
                            <form action="{{ route('cancel-pay-admin', $booking->id) }}" method="POST"
                                id="cancle-pay-form{{ $booking->id }}" class="m-0">
                                @csrf
                            </form>
                            <td style="width: 20%">
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#modal-cancle" onclick="showModelCancle({{ $booking->id }})">
                                    ยกเลิกการจอง
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
