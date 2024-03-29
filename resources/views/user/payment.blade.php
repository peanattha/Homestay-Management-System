@extends('layouts.user')

@section('homestay', 'active')

@section('title', 'homestay Details')
<style>
    .bank-admin {
        margin-bottom: 0px;
        margin-right: 8px;
    }

    @media (max-width: 960px) {
        .payment {
            flex-wrap: wrap;
            justify-content: center;
        }

        .payment div {}

        .bank-admin {
            margin-bottom: 8px;
            margin-right: 0;
        }
    }
</style>
<script>
    setInterval(() => {
        const booking = @json($booking);
        const timestamp = new Date(booking.created_at);
        let endTime = new Date(timestamp.getTime() + 15 * 60000);
        let curTime = new Date();
        // let endTimeFormatted = endTime.toLocaleTimeString(undefined, {
        //     hour: '2-digit',
        //     minute: '2-digit',
        //     hour12: false
        // });
        // let curTimeFormatted = curTime.toLocaleTimeString(undefined, {
        //     hour: '2-digit',
        //     minute: '2-digit',
        //     hour12: false
        // });
        let timeLeft = endTime.getTime() - curTime.getTime();
        // console.log(curTime);
        // console.log(endTime);
        // console.log("---");
        if (timeLeft <= 0) {
            // console.log("Time's up!");
            window.location.replace("{{ asset('change-status-payment/') }}/" + booking.id);
        } else {
            // console.log('Time left');
        }
    }, 1000);
</script>

@section('content')
    <div class="container mb-4 d-flex flex-row payment ">
        <div class="card col-md-2 bank-admin rounded-3 border border-1 shadow-lg" style="width: 22rem;">
            <div id="carouselExampleSlidesOnly" class="carousel slide" data-bs-ride="carousel">
                <?php
                $Arr = explode(' ', $booking->created_at);
                $date = date('d-m-Y', strtotime($Arr[0]));
                $time = date('H:i:s', strtotime($Arr[1] . ' +15 min'));

                $dateTime = strtotime($date . ' ' . $time);
                $getDateTime = date('F d, Y H:i:s', $dateTime);
                ?>
                <h4 class="m-1 text-center" id="counter"></h4>
                <script>
                    var countDownTimer = new Date("<?php echo "$getDateTime"; ?>").getTime();
                    // Update the count down every 1 second
                    var interval = setInterval(function() {
                        var current = new Date().getTime();
                        // Find the difference between current and the count down date
                        var diff = countDownTimer - current;
                        // Countdown Time calculation for days, hours, minutes and seconds

                        var minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                        var seconds = Math.floor((diff % (1000 * 60)) / 1000);

                        document.getElementById("counter").innerHTML = "กรุณาจ่ายเงินภายใน <br>" + minutes + "นาที " + seconds +
                            "วินาที";
                        // Display Expired, if the count down is over
                        if (diff < 0) {
                            clearInterval(interval);
                            document.getElementById("counter").innerHTML = "EXPIRED";
                        }
                    }, 1000);
                </script>
                <div class="carousel-inner">
                    <div class="carousel-item active p-1">
                        <img src="{{ asset('images/thai_qr_payment.png') }}" class="card-img-top" alt="prompt-pay-logo">
                        <?php
                        function DelChar($str)
                        {
                            $res = str_replace('-', '', $str);
                            return $res;
                        }

                        $str = $bank_admin->prompt_pay;

                        $prompt_pay = DelChar($str);
                        ?>
                        <img src="https://promptpay.io/{{ $prompt_pay }}/{{ $booking->deposit }}" class="card-img-top"
                            alt="qr_code">
                    </div>
                </div>
                {{-- <div class="text-center">
                    <a href="https://promptpay.io/{{ $prompt_pay }}/{{ $booking->deposit }}.png"
                        download="AwesomeImage.png">
                        <input type="submit" class="btn btn-success mt-2" value="บันทึก QR Payment">
                    </a>
                </div> --}}
            </div>
            <div class="card-body text-center">
                <h4><b>เงินมัดจำ:</b> {{ $booking->deposit }} บาท</h4>
                <h4><b>{{ $bank_admin->firstName }} {{ $bank_admin->lastName }}</b></h4>
                <p class="m-0"><b>ธนาคาร:</b> {{ $bank_admin->bank_name->name }}</p>
                <p class="m-0"><b>เลขบัญชี:</b> {{ $bank_admin->acc_number }}</p>
                <p><a href="{{ asset('storage/images/' . $bank_admin->qr_code) }}"target="_blank">หากไม่สามารถชำระเงินผ่านทาง
                        QR Code ด้านบนได้</a></p>
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
                        <span class="badge bg-danger">ยกเลิกการจอง</span>
                    @elseif ($booking->status == 5)
                        <span class="badge bg-warning text-dark">รอชำระเงิน</span>
                    @elseif ($booking->status == 6)
                        <span class="badge bg-warning text-dark">รอยืนยันการชำระเงิน</span>
                    @elseif ($booking->status == 7)
                        <span class="badge bg-warning text-dark">รอยืนยันยกเลิกการจอง</span>
                    @endif
                </div>
                <div class="card-body" id="add_payment">
                    <form action="{{ route('payment') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="text" name="bank_admin_id" id="bank_admin_id" class="d-none"
                            value="{{ $bank_admin->id }}">
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
                            @if ($booking->promotion_id == null)
                                <div class="col-md" id="dis_price">
                                    <label class="form-label">ส่วนลด *</label>
                                    <div class="input-group">
                                        <input type="text" name="discount" id="discount" disabled
                                            class="form-control" required value="0">
                                        <span class="input-group-text">บาท</span>
                                    </div>
                                </div>
                            @else
                                @if ($booking->promotion->discount_price != null)
                                    <div class="col-md" id="dis_price">
                                        <label class="form-label">ส่วนลด *</label>
                                        <div class="input-group">
                                            <input type="text" name="discount" id="discount" disabled
                                                class="form-control" required
                                                value="{{ $booking->total_price - $booking->total_price_discount }}">
                                            <span class="input-group-text">บาท</span>
                                        </div>
                                    </div>
                                @else
                                    <div class="col-md" id="dis_price">
                                        <label class="form-label">ส่วนลด *</label>
                                        <div class="input-group">
                                            <input type="text" name="discount" id="discount" disabled
                                                class="form-control" required
                                                value="{{ $booking->total_price - $booking->total_price_discount }}">
                                            <span class="input-group-text">บาท</span>
                                        </div>
                                    </div>
                                    <div class="col-md" id="dis_per">
                                        <label class="form-label">ส่วนลด (เปอร์เซ็นต์)*</label>
                                        <div class="input-group">
                                            <input type="text" name="discount" id="discount_per" readonly
                                                class="form-control" required value="{{ $booking->promotion->percent }}">
                                            <span class="input-group-text">เปอร์เซ็นต์ (%)</span>
                                        </div>
                                    </div>
                                @endif
                            @endif
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
                                        value="{{ $booking->total_price - $booking->total_price_discount }}" required>
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
