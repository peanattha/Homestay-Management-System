@extends('layouts.user')

@section('title', 'ประวัติการจอง')

@section('booking-history', 'active')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

@if (Session::has('booking-success'))
    <script>
        window.onload = (event) => {
            $('.toast').toast('show');
        }
    </script>
@endif

@section('page-name')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">หน้าหลัก</a></li>
            <li class="breadcrumb-item active" aria-current="page">ประวัติการจอง</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="toast top-0 end-0 position-fixed mt-4 me-4 " style="z-index: 97" role="alert" aria-live="assertive"
        aria-atomic="true">
        <div class="toast-header">
            <img src="{{ asset('images/Logo.svg') }}" class="rounded me-2" style="width: 20px; height: 20px;"
                alt="...">
            <strong class="me-auto">{{ config('app.name') }}</strong>
            <small>Now</small>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            ชำระเงินเสร็จสิ้น รอยืนยันจากทางเจ้าของโฮมสเตย์
        </div>
    </div>

    <div class="container mt-4">
        @if ($bookings->count() == 0)
            <div class="d-flex justify-content-center align-items-center h-50">
                <p>คุณยังไม่มีประวัติการจอง. <a href="{{ route('homestay') }}">จองเลย !!</a></p>
            </div>
        @else
            <div class="d-flex flex-column justify-content-center align-items-center ">
                @foreach ($bookings as $booking)
                    <div class="card rounded-3 border border-1 shadow-lg mb-4 w-100">
                        <div class="card-header">
                            @foreach ($booking->booking_details as $booking_detail)
                                @if ($loop->last)
                                    {{ $booking_detail->homestay->homestay_name }}
                                @else
                                    {{ $booking_detail->homestay->homestay_name }},
                                @endif
                            @endforeach
                            @if ($booking->status == 1)
                                <span class="badge bg-success">Check In</span>
                            @elseif ($booking->status == 2)
                                <span class="badge bg-success">Check Out</span>
                            @elseif ($booking->status == 3)
                                <span class="badge bg-success">รอ Check In</span>
                            @elseif ($booking->status == 4)
                                <span class="badge bg-danger">ยกเลิกการจอง</span>
                            @elseif ($booking->status == 5)
                                <span class="badge bg-warning text-dark">รอชำระเงิน</span>
                            @elseif ($booking->status == 6)
                                <span class="badge bg-warning text-dark">รอยืนยันการชำระเงิน</span>
                            @elseif ($booking->status == 7)
                                <span class="badge bg-warning text-dark">รอยืนยันยกเลิกการจอง</span>
                            @endif
                        </div>
                        <div class="card-body">
                            <?php
                            $start_date = date('d-m-Y', strtotime($booking->start_date));
                            $end_date = date('d-m-Y', strtotime($booking->end_date));
                            $valueDate = $start_date . ' - ' . $end_date;
                            ?>
                            <p class="card-text"><b>วันที่จอง: </b>{{ $valueDate }}</p>
                            <a href="{{ route('booking-history-details', $booking->id) }}" class="btn btn-success"><i
                                    class='bx bx-detail me-2'></i>ดูรายละเอียดการจอง</a>
                        </div>
                    </div>
                @endforeach
                {{ $bookings->links() }}
            </div>
        @endif
    </div>
@endsection
