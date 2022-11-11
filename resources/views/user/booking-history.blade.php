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
                        {{ $booking->homestay->homestay_name }}
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $booking->homestay->homestay_name }}</h5>
                        <p class="card-text"><b>วันที่จอง: </b>08/10/2022 - 09/10/2022</p>
                        <p class="card-text"><b>สถานะ: </b>ชำระเงินมัดจำเเล้ว รอยืนยันชำระเงินจากจากเจ้าของโฮมสเตย์</p>
                        <a href="#" class="btn btn-success">ดูรายละเอียดการจอง</a>
                    </div>
                </div>
            @endforeach
            <div class="card m-2">
                <div class="card-header">
                    กระโจม1
                </div>
                <div class="card-body">
                    <h5 class="card-title">กระโจม1</h5>
                    <p class="card-text"><b>วันที่จอง: </b>08/09/2022 - 09/09/2022</p>
                    <p class="card-text"><b>สถานะ: </b>Check Out</p>
                    <a href="{{route('booking-history-details',1)}}" class="btn btn-success">ดูรายละเอียดการจอง</a>
                </div>
            </div>
        </div>
    @endif
@endsection
