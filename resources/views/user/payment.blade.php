@extends('layouts.user')

@section('homestay', 'active')

@section('title', 'homestay Details')
<style>
    .bank-admin {
        margin-bottom: 0px;
        margin-right: 8px;
    }

    @media (max-width: 768px) {
        .payment {
            flex-wrap: wrap;
        }

        .bank-admin {
            margin-bottom: 8px;
            margin-right: 0;
        }
    }
</style>
@section('content')
    <div class="container">
        <?php
        $Arr = explode(' ', $booking->created_at);
        $date = date('d-m-Y', strtotime($Arr[0]));
        $time = date('H:i', strtotime($Arr[1] . ' +15 min'));
        ?>
        กรุณาจ่ายเงินภายใน {{ $date }} {{ $time }}
    </div>
    <div class="container mb-4 d-flex flex-row justify-content-between payment">
        <div class="card col-md-2 bank-admin" style="width: 22rem;">
            <div id="carouselExampleSlidesOnly" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <a href="{{ asset('storage/images/' . $bank_admin->qr_code) }}" target="_blank">
                            <img src="{{ asset('storage/images/' . $bank_admin->qr_code) }}" class="card-img-top"
                                alt="...">
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <p>
                    <b>เลขบัญชี:</b> {{ $bank_admin->acc_number }}
                </p>
                <p>
                    <b>ธนาคาร:</b> {{ $bank_admin->bank_name->name }}
                </p>
                <p>
                    <b>ชื่อ-นามสกุล:</b> {{ $bank_admin->firstName }} {{ $bank_admin->lastName }}
                </p>
            </div>
        </div>
        <div>
            <div class="col-md-12 card rounded-3 border border-1 shadow-lg">
                <div class="card-header">
                    ข้อมูลการจอง
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
                <div class="card-body" id="add_payment">
                    <form action="{{ route('payment') }}" method="POST" enctype="multipart/form-data" >
                        @csrf
                        <input type="text" name="bank_admin_id" id="bank_admin_id" class="d-none" value="{{ $bank_admin->id }}">
                        <input type="text" name="booking_id" id="booking_id" class="d-none" value="{{ $booking->id }}">
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="labels">ชื่อ *</label>
                                <input type="text" name="firstName" class="form-control"
                                    value="{{ $booking->user->firstName }}" required readonly>
                            </div>
                            <div class="col-md-4">
                                <label class="labels">นามสกุล *</label>
                                <input type="text" name="lastName" class="form-control"
                                    value="{{ $booking->user->lastName }}" required readonly>
                            </div>
                            <div class="col-md-4">
                                <label class="labels">เบอร์โทรศัพท์ *</label>
                                <input type="text" name="tel" class="form-control" value="{{ $booking->user->tel }}"
                                    readonly>
                            </div>
                        </div>
                        <hr>
                        <div class="mb-3">
                            <label for="homestay_name" class="form-label">ที่พัก *</label><br>
                            @foreach ($booking->booking_details as $booking_detail)
                                @foreach ($homestays as $homestay)
                                    @if ($booking_detail->homestay->homestay_name == $homestay->homestay_name)
                                        <input type="checkbox" id="hn{{ $homestay->id }}" name="homestay_name"
                                            value="{{ $booking_detail->homestay_id }}" checked disabled>
                                        <label>{{ $booking_detail->homestay->homestay_name }}</label>
                                    @endif
                                @endforeach
                            @endforeach
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="dateRange" class="form-label">ช่วงวันที่เข้าพัก *</label>
                                <input type="text" name="dateRange"
                                    value=" {{ $booking->start_date }} - {{ $booking->end_date }}" class="form-control"
                                    required readonly />
                            </div>
                            <div class="col-md-4">
                                <label for="number_guests" class="form-label">จำนวนผู้เข้าพัก *</label>
                                <input type="number" min="1" step="1" max="" pattern="\d*"
                                    class="form-control" id="number_guests" name="number_guests"
                                    value="{{ $booking->number_guests }}" placeholder="จำนวนผู้เข้าพัก" readonly required>
                            </div>
                            <div class="col-md-4">
                                <label for="homestay_price_total" class="form-label">ราคา *</label>
                                <div class="input-group">
                                    <input type="text" name="homestay_price_total" id="homestay_price_total" readonly
                                        required class="form-control" value="{{ $booking->total_price }}">
                                    <span class="input-group-text">บาท</span>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="mb-3">
                            <div class="row mt-2">
                                <div class="col-md-4">
                                    <label class="labels">ชุดเมนูอาหาร *</label>
                                    <input type="text" name="set_menu" id="set_menu" class="form-control"
                                        value="{{ $booking->set_menu->set_menu_name }}" readonly required>
                                </div>
                                <div class="col-md-4">
                                    <label class="labels">จำนวนชุดเมนูอาหาร *</label>
                                    <input type="number" name="num_menu" id="num_menu" class="form-control"
                                        value="{{ $booking->num_menu }}" readonly required>
                                </div>
                                <div class="col-md-4">
                                    <label class="labels">ราคาชุดเมนูอาหาร *</label>
                                    <div class="input-group">
                                        <input type="text" name="priceMenu" id="priceMenu"
                                            value="{{ $booking->set_menu->price }}" readonly required
                                            class="form-control">
                                        <span class="input-group-text">บาท</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="promotion" class="form-label">โปรโมชั่น</label>
                                <?php
                                $discount_price = 0;
                                ?>
                                @if ($booking->promotion_id == null)
                                    <input type="text" class="form-control" id="promotion" name="promotion"
                                        placeholder="เลือกโปรโมชั่น" value="ไม่ใช้โปรโมชั่น" required readonly>
                                @else
                                    @foreach ($promotions as $promotion)
                                        @if ($booking->promotion_id == $promotion->id)
                                            <input type="text" class="form-control" id="promotion" name="promotion"
                                                placeholder="เลือกโปรโมชั่น" value="{{ $promotion->promotion_name }}"
                                                required readonly>
                                            <?php
                                            $discount_price = $promotion->discount_price;
                                            ?>
                                        @endif
                                    @endforeach
                                @endif
                            </div>
                            <div class="col-md-6">
                                <label for="discount_price" class="form-label">ส่วนลด *</label>
                                <div class="input-group">
                                    <input type="text" name="discount_price" id="discount_price" disabled required
                                        class="form-control" value="{{ $discount_price }}">
                                    <span class="input-group-text">บาท</span>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row mt-2">
                            <div class="col-md-3">
                                <label class="labels">ราคาทั้งหมด *</label>
                                <div class="input-group">
                                    <input type="text" name="total_price" id="total_price" readonly required
                                        class="form-control" value="{{ $booking->total_price }}">
                                    <span class="input-group-text">บาท</span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label class="labels">ส่วนลด *</label>
                                <div class="input-group">
                                    <input type="text" name="discount" id="discount" readonly class="form-control"
                                        required>
                                    <span class="input-group-text">บาท</span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label class="labels">ราคารวมส่วนลด *</label>
                                <div class="input-group">
                                    <input type="text" name="total_price_discount" id="total_price_discount" readonly
                                        required class="form-control" value="{{ $booking->total_price_discount }}">
                                    <span class="input-group-text">บาท</span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label class="labels">เงินมัดจำ *</label>
                                <div class="input-group">
                                    <input type="text" name="deposit" id="deposit" readonly class="form-control"
                                        required value="{{ $booking->deposit }}">
                                    <span class="input-group-text">บาท</span>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="mb-3">
                            <label for="FileImgMultiple" class="form-label">สลิปชำระเงิน *</label>
                            <input class="form-control" type="file" id="FileImgMultiple" name="slip_img" required>
                        </div>
                        <input type="submit" class="btn btn-success mt-2" id="add_payment" value="อัพโหลดการจ่ายเงิน">
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
