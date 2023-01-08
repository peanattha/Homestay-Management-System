@extends('layouts.user')

@section('title', 'ประวัติการจอง')

@section('booking-history', 'active')

@section('content')
    <div class="container">
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
                                <span class="badge bg-success">ยกเลิกการจอง</span>
                            @elseif ($booking->status == 5)
                                <span class="badge bg-success">รอชำระเงิน</span>
                            @elseif ($booking->status == 6)
                                <span class="badge bg-success">รอยืนยันการชำระเงิน</span>
                            @elseif ($booking->status == 7)
                                <span class="badge bg-success">รอยืนยันยกเลิกการจอง</span>
                            @endif
                        </div>
                        <div class="card-body">
                            <?php
                            $start_date = date('d-m-Y', strtotime($booking->start_date));
                            $end_date = date('d-m-Y', strtotime($booking->end_date));
                            $valueDate = $start_date . ' - ' . $end_date;
                            ?>
                            <p class="card-text"><b>วันที่จอง: </b>{{ $valueDate }}</p>
                            <a href="{{ route('booking-history-details', $booking->id) }}"
                                class="btn btn-success">ดูรายละเอียดการจอง</a>
                        </div>
                    </div>
                @endforeach
                {!! $bookings->links() !!}
            </div>
        @endif
    </div>
@endsection
