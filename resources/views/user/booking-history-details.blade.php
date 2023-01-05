@extends('layouts.user')

@section('title', 'Booking History Details')

@section('booking-history', 'active')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script src="{{ asset('js/print.min.js') }}"></script>

<link href="{{ asset('css/print.min.css') }}" rel="stylesheet">

<style>
    .carousel-item img {
        height: 300px;
        width: 630px;
        object-fit: cover;
    }
</style>

<script>
    function showCanclePay() {
        $("#modal-cancle-pay").modal("show");
    }

    function confirmCanclePay() {
        document.getElementById("cancel-pay-user").submit();
    }
</script>
@section('content')
    <div class="modal fade" id="modal-cancle-pay" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">แจ้งเตือน</h5>
                </div>
                <div class="modal-body" id="textModelCanclePay">คุณเเน่ใจที่จะยกเลิกการจอง</div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" onclick="confirmCanclePay()">ยืนยัน</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                </div>
            </div>
        </div>
    </div>
    <div class="container d-flex justify-content-around flex-row flex-wrap">
        <div class="col-md-4" style="overflow-y: scroll; height:700px;">
            @foreach ($booking->booking_details as $booking_detail)
                <div class="card mb-3" style="max-width: 630px; height: 301px;">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <div id="carouselExampleSlidesOnly" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-inner">
                                    <?php $i = 0; ?>
                                    @foreach (json_decode($booking_detail->homestay->homestay_img) as $img)
                                        @if ($i == 0)
                                            <?php $i += 1; ?>
                                            <div class="carousel-item active">
                                                <img src="{{ asset('storage/images/' . $img) }}"
                                                    class="img-fluid rounded-start" alt="...">
                                            </div>
                                        @else
                                            <div class="carousel-item">
                                                <img src="{{ asset('storage/images/' . $img) }}"
                                                    class="img-fluid rounded-start" alt="...">
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h4 class="card-title"><b>{{ $booking_detail->homestay->homestay_name }}</b></h4>
                                <pre class="card-text">{{ $booking_detail->homestay->homestay_detail }}</pre>
                                <h5 class="card-text text-success"><b>ราคา : {{ $booking_detail->homestay->homestay_price }}
                                        / คืน</b></h5>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="col-md-7 card rounded-3 border border-1 shadow-lg mb-4">
            <div class="card-header">
                รายละเอียดการจอง
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
            <div class="card-body" id="history_booking">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="labels">ชื่อ *</label>
                        <input type="text" name="firstName" class="form-control" value="{{ $booking->user->firstName }}"
                            readonly>
                    </div>
                    <div class="col-md-4">
                        <label class="labels">นามสกุล *</label>
                        <input type="text" name="lastName" class="form-control" value="{{ $booking->user->lastName }}"
                            readonly>
                    </div>
                    <div class="col-md-4">
                        <label class="labels">เบอร์โทรศัพท์ *</label>
                        <input type="text" name="lastName" class="form-control" value="{{ $booking->user->tel }}"
                            readonly>
                    </div>
                </div>
                <hr>
                <div class="mb-3">
                    <label for="homestay_name" class="form-label">ที่พัก *</label><br>
                    <?php
                    $homestay_price_total = 0;
                    ?>
                    @foreach ($booking->booking_details as $booking_detail)
                        @foreach ($homestays as $homestay)
                            @if ($booking_detail->homestay->homestay_name == $homestay->homestay_name)
                                <input type="checkbox" id="hn{{ $homestay->id }}" name="homestay_name"
                                    value="{{ $booking_detail->homestay_id }}" checked disabled>
                                <label>{{ $booking_detail->homestay->homestay_name }}</label>
                                <?php
                                $homestay_price_total += $homestay->homestay_price;
                                ?>
                            @endif
                        @endforeach
                    @endforeach
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="dateRange" class="form-label">ช่วงวันที่เข้าพัก *</label>
                        <?php
                        $start_date = date('d-m-Y', strtotime($booking->start_date));
                        $end_date = date('d-m-Y', strtotime($booking->end_date));
                        $valueDate = $start_date . ' - ' . $end_date;
                        ?>
                        <input type="text" name="dateRange" value="{{ $valueDate }}" class="form-control" readonly
                            required />
                    </div>
                    <div class="col-md-4">
                        <label for="number_guests" class="form-label">จำนวนผู้เข้าพัก *</label>
                        <input type="number" min="1" step="1" max="" pattern="\d*"
                            class="form-control" id="number_guests" name="number_guests" placeholder="จำนวนผู้เข้าพัก"
                            value="2" required readonly>
                    </div>
                    <div class="col-md-4">
                        <label for="homestay_price_total" class="form-label">ราคา *</label>
                        <div class="input-group">
                            <input type="text" name="homestay_price_total" id="homestay_price_total" disabled required
                                class="form-control" value="{{ $homestay_price_total }}">
                            <span class="input-group-text">บาท</span>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="setmenu" class="form-label">ชุดเมนูอาหาร *</label>
                        <input type="text" name="setmenu" value="{{ $booking->set_menu->set_menu_name }}"
                            class="form-control" required readonly />
                    </div>
                    <div class="col-md-4">
                        <label for="setmenu" class="form-label">จำนวนชุดเมนูอาหาร *</label>
                        <input type="number" min="0" step="1" pattern="\d*" class="form-control"
                            id="numsetmenu" name="numsetmenu" placeholder="จำนวนชุดเมนูอาการ"
                            value="{{ $booking->num_menu }}" required readonly>
                    </div>
                    <div class="col-md-4">
                        <label for="menu_priec_total" class="form-label">ราคา *</label>
                        <?php
                        $menu_priec_total = $booking->set_menu->price * $booking->num_menu;
                        ?>
                        <div class="input-group">
                            <input type="text" name="menu_priec_total" id="menu_priec_total" disabled required
                                class="form-control" value="{{ $menu_priec_total }}">
                            <span class="input-group-text">บาท</span>
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
                                        placeholder="เลือกโปรโมชั่น" value="{{ $promotion->promotion_name }}" required
                                        readonly>
                                    <?php
                                    $discount_price = $promotion->discount_price;
                                    ?>
                                @endif
                            @endforeach
                        @endif
                    </div>
                    <div class="col-md-6">
                        <label for="discount_price" class="form-label">ราคา *</label>
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
                            <input type="text" name="total_price" id="total_price" disabled required
                                class="form-control" value="{{ $booking->total_price }}">
                            <span class="input-group-text">บาท</span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label class="labels">ส่วนลด *</label>
                        <div class="input-group">
                            <input type="text" name="discount" id="discount" disabled class="form-control" required
                                value="{{ $booking->total_price - $booking->total_price_discount }}">
                            <span class="input-group-text">บาท</span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label class="labels">ราคารวมส่วนลด *</label>
                        <div class="input-group">
                            <input type="text" name="total_price_discount" id="total_price_discount" disabled required
                                class="form-control" value="{{ $booking->total_price_discount }}">
                            <span class="input-group-text">บาท</span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label class="labels">เงินมัดจำ *</label>
                        <div class="input-group">
                            <input type="text" name="deposit" id="deposit" disabled class="form-control" required
                                value="{{ $booking->deposit }}">
                            <span class="input-group-text">บาท</span>
                        </div>
                    </div>
                </div>
                <hr>
                @foreach ($booking->payments as $payment)
                    @if ($payment->payment_type == 1 || $payment->payment_type == 4)
                        @if ($payment->payment_type == 1)
                            <div class="row mt-2">
                                <div class="col-md-4">
                                    <label class="labels">เงินมัดจำ *</label>
                                    <div class="input-group">
                                        <input type="text" name="deposit" id="deposit" disabled
                                            class="form-control" required value="{{ $payment->total_price }}">
                                        <span class="input-group-text">บาท</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="labels">จ่าย *</label>
                                    <div class="input-group">
                                        <input type="text" name="depositPay" id="depositPay" disabled required
                                            class="form-control" value="{{ $payment->pay_price }}">
                                        <span class="input-group-text">บาท</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="labels">เงินทอน *</label>
                                    <div class="input-group">
                                        <input type="text" name="change_deposit" id="change_deposit" disabled required
                                            class="form-control" value="{{ $payment->change }}">
                                        <span class="input-group-text">บาท</span>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="row mt-2">
                                <div class="col-md-4">
                                    <label class="labels">เงินจ่ายเต็มจำนวน *</label>
                                    <div class="input-group">
                                        <input type="text" name="total_price" id="total_price" disabled
                                            class="form-control" required value="{{ $payment->total_price }}">
                                        <span class="input-group-text">บาท</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="labels">จ่าย *</label>
                                    <div class="input-group">
                                        <input type="text" name="total_price_pay" id="total_price_pay" disabled
                                            required class="form-control" value="{{ $payment->pay_price }}">
                                        <span class="input-group-text">บาท</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="labels">เงินทอน *</label>
                                    <div class="input-group">
                                        <input type="text" name="total_price_change" id="total_price_change" disabled
                                            required class="form-control" value="{{ $payment->change }}">
                                        <span class="input-group-text">บาท</span>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @elseif ($payment->payment_type == 2)
                        <div class="row mt-2">
                            <div class="col-md-4">
                                <label class="labels">เงินจ่ายมัดจำที่เหลือ *</label>
                                <div class="input-group">
                                    <input type="text" name="total_price" id="total_price" disabled
                                        class="form-control" required value="{{ $payment->total_price }}">
                                    <span class="input-group-text">บาท</span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="labels">จ่าย *</label>
                                <div class="input-group">
                                    <input type="text" name="total_price_pay" id="total_price_pay" disabled required
                                        class="form-control" value="{{ $payment->pay_price }}">
                                    <span class="input-group-text">บาท</span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="labels">เงินทอน *</label>
                                <div class="input-group">
                                    <input type="text" name="total_price_change" id="total_price_change" disabled
                                        required class="form-control" value="{{ $payment->change }}">
                                    <span class="input-group-text">บาท</span>
                                </div>
                            </div>
                        </div>
                    @elseif ($payment->payment_type == 3)
                        <div class="row mt-2">
                            <div class="col-md-4">
                                <label class="labels">เงินจ่ายเพิ่มเติม *</label>
                                <div class="input-group">
                                    <input type="text" name="total_price" id="total_price" disabled
                                        class="form-control" required value="{{ $payment->total_price }}">
                                    <span class="input-group-text">บาท</span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="labels">จ่าย *</label>
                                <div class="input-group">
                                    <input type="text" name="total_price_pay" id="total_price_pay" disabled required
                                        class="form-control" value="{{ $payment->pay_price }}">
                                    <span class="input-group-text">บาท</span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="labels">เงินทอน *</label>
                                <div class="input-group">
                                    <input type="text" name="total_price_change" id="total_price_change" disabled
                                        required class="form-control" value="{{ $payment->change }}">
                                    <span class="input-group-text">บาท</span>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach

                <div class="mt-4">
                    @if ($booking->status == 5 || $booking->status == 6 || $booking->status == 3)
                        <form action="{{ route('cancel-pay-user', $booking->id) }}" method="POST" id="cancel-pay-user">
                            @csrf
                        </form>
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modal-del"
                            onclick="showCanclePay()">
                            ยกเลิกการจอง
                        </button>
                    @endif
                    <button type="button" class="btn btn-success"
                        onclick="printJS({ printable: 'history_booking', type: 'html', header: 'ใบรายการจอง', css:'{{ asset('css/app.css') }}', documentTitle:'ใบรายการจอง - {{ config('app.name') }}'})">
                        <i class='bx bx-printer'></i> ปริ้นใบรายการจอง </button>
                </div>
            </div>
        </div>

    </div>


    {{-- <div class="container mb-3">
        <label for="details" class="form-label">รีวิวการจองของคุณ *</label>
        <textarea class="form-control" id="details" name="details" rows="3" readonly required>บรรยากาศดี บริการดี  วิวสวย สะอาด  กาแฟอร่อย คาเฟ่สวยน่ารัก แนะนำเลยถ้ามาภูผาม่านต้องมาค่าเฟ่ที่นี้ แต่ส่วนที่พักจองบ้านภูผาม่านราคา1000 ไม่คุ้มเงินเลยบอกเลยไม่คุ้มเงิน จริงๆ ถ้า1000ก็ควรจะทำห้องให้ดีกว่านี้เครื่องทำน้ำอุ่นก็ใช้ไม่ได้
ทีวีเปิดไม่ติด  ตรงที่ตั้งกาน้ำร้อนก็ไม่มีที่เสียบปลั้กแถมยังมีน้ำในกาเหลือจากคนเก่าที่พักก่อนน่าด้วย ส่วนบ้าน Family house เป็นห้องน้ำรวม แต่ประตูห้องน้ำล็อคไม่ได้เลย  เเนะนำแค่คาเฟ่เท่านั้นเฉพาะคนชอบกินกาแฟถ่ายรูป</textarea>
        <input type="submit" class="btn btn-success mt-3" value="แก้ใขรีวิวการจอง">
        <input type="submit" class="btn btn-danger mt-3" value="ลบรีวิวการจอง">
    </div> --}}

@endsection
