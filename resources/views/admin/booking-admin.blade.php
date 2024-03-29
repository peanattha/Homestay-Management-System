@extends('layouts.admin')

@section('active-booking-admin', 'active')

@section('title', 'Booking Admin')

<link rel="stylesheet" href="{{ asset('css/table.css') }}">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

@section('page-name')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item active" aria-current="page">รายการจองทั้งหมด</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="card rounded-3 border border-1 shadow-lg">
        <div class="card-header">
            รายการจองทั้งหมด
        </div>
        <div class="card-body">
            <form action="{{ route('search-booking-admin') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label class="form-label">ค้นหารายการจอง</label>
                    <input type="text" class="form-control" id="booking_id" name="booking_id" placeholder="รหัสการจอง">
                    <div id="help" class="form-text">กรอกรหัสการจองเพื่อทำการค้นหารายการจอง</div>
                </div>
                <div class="mb-3">
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <input type="text" name="firstName" class="form-control" placeholder="ชื่อผู้จอง">
                        </div>
                        <div class="col-md-6">
                            <input type="text" name="lastName" class="form-control" placeholder="นามสกุลผู้จอง">
                        </div>
                    </div>
                    <div id="help" class="form-text">กรอกชื่อผู้จองเพื่อทำการค้นหารายการจอง</div>
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
                        <th style="width: 5%">ลำดับ</th>
                        <th style="width: 20%">ชื่อผู้จอง</th>
                        <th style="width: 10%">ชื่อที่พัก</th>
                        <th style="width: 10%">จำนวนผู้เข้าพัก</th>
                        <th style="width: 20%">สถานะ</th>
                        <th style="width: 15%">รายละเอียดเพิ่มเติม</th>
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
                            @if ($booking->status == 1)
                                <td style="width: 20%"><span class="badge bg-success">Check In</span></td>
                            @elseif ($booking->status == 2)
                                <td style="width: 20%"><span class="badge bg-success">Check Out</span></td>
                            @elseif ($booking->status == 3)
                                <td style="width: 20%"><span class="badge bg-warning text-dark">รอ Check In</span></td>
                            @elseif ($booking->status == 4)
                                <td style="width: 20%"><span class="badge bg-danger">ยกเลิกการจอง</span></td>
                            @elseif ($booking->status == 5)
                                <td style="width: 20%"><span class="badge bg-warning text-dark">รอชำระเงิน</span></td>
                            @elseif ($booking->status == 6)
                                <td style="width: 20%"><span class="badge bg-warning text-dark">รอยืนยันการชำระเงิน</span>
                                </td>
                            @elseif ($booking->status == 7)
                                <td style="width: 20%"><span class="badge bg-warning text-dark">รอยืนยันยกเลิกการจอง</span>
                                </td>
                            @endif
                            <td style="width: 15%"><a href="{{ route('booking-detail', $booking->id) }}"
                                    class="btn btn-primary">รายละเอียด</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="d-flex justify-content-center">
        {!! $bookings->links() !!}
    </div>
@endsection
