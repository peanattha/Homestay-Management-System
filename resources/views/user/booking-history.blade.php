@extends('layouts.user')

@section('title', 'BookingHistory')

@section('booking-history', 'active')

<style>
    .none-booking {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 45%;
    }

    .booking-history {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;

    }

    .booking-history div {
        /* margin: 10px; */
        width: 100%;
    }
</style>
@section('content')
    @if ($bookings->count() == 0)
        <div class="container none-booking">
            <p>คุณยังไม่มีประวัติการจอง. <a href="{{ route('homestay') }}">จองเลย !!</a></p>
        </div>
    @else
        <div class="booking-history container">
            @foreach ($bookings as $booking)
                <div class="card m-2">
                    <div class="card-header">
                        @foreach ($booking->booking_details as $booking_detail)
                            {{ $booking_detail->homestay->homestay_name }}
                        @endforeach
                    </div>
                    <div class="card-body">
                        <?php
                        $start_date = date('d-m-Y', strtotime($booking->start_date));
                        $end_date = date('d-m-Y', strtotime($booking->end_date));
                        $valueDate = $start_date . ' - ' . $end_date;
                        ?>
                        <p class="card-text"><b>วันที่จอง: </b>{{ $valueDate }}</p>

                        @if ($booking->status == 1)
                            <p class="card-text"><b>สถานะ: </b><span class="badge bg-success">Check In</span></p>
                        @elseif ($booking->status == 2)
                            <p class="card-text"><b>สถานะ: </b><span class="badge bg-success">Check Out</span></p>
                        @elseif ($booking->status == 3)
                            <p class="card-text"><b>สถานะ: </b><span class="badge bg-success">รอ Check In</span></p>
                        @elseif ($booking->status == 4)
                            <p class="card-text"><b>สถานะ: </b><span class="badge bg-success">ยกเลิกการจอง</span></p>
                        @elseif ($booking->status == 5)
                            <p class="card-text"><b>สถานะ: </b><span class="badge bg-success">รอชำระเงิน</span></p>
                        @elseif ($booking->status == 6)
                            <p class="card-text"><b>สถานะ: </b><span class="badge bg-success">รอยืนยันการชำระเงิน</span></p>
                        @elseif ($booking->status == 7)
                            <p class="card-text"><b>สถานะ: </b><span class="badge bg-success">รอยืนยันยกเลิกการจอง</span>
                            </p>
                        @endif
                        <a href="{{ route('booking-history-details', $booking->id) }}"
                            class="btn btn-success">ดูรายละเอียดการจอง</a>
                    </div>
                </div>
            @endforeach
            {!! $bookings->links() !!}
        </div>

    @endif
@endsection
