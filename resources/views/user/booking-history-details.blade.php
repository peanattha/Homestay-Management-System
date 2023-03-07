@extends('layouts.user')

@section('title', 'รายละเอียดประวัติการจอง')

@section('booking-history', 'active')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script src="{{ asset('js/print.min.js') }}"></script>

<link href="{{ asset('css/print.min.css') }}" rel="stylesheet">

<script>
    function showCanclePay() {
        $("#modal-cancle-pay").modal("show");
    }

    function confirmCanclePay() {
        document.getElementById("cancel-pay-user").submit();
    }

    function checkPolicy() {
        console.log("aa");
        if ($("#policyCancle").is(":checked") == true) {
            document.getElementById("btn-confirmCanclePay").disabled = false;
        }
    }
</script>

@section('page-name')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">หน้าหลัก</a></li>
            <li class="breadcrumb-item"><a href="{{ route('booking-history') }}">ประวัติการจอง</a></li>
            <li class="breadcrumb-item active" aria-current="page">รายละอียดประวัติการจอง</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="modal fade" id="modal-cancle-pay" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">แจ้งเตือน</h5>
                </div>
                <div class="modal-body" id="textModelCanclePay">
                    คุณเเน่ใจที่จะยกเลิกการจอง <br>
                    --ข้อตกลงการยกเลิกการจอง--
                    <ul>
                        <li>หากยกเลิกการจอง <span class="text-danger">ก่อนถึงวันจอง 3 วัน</span> ทางโฮมสเตย์จะคืนเงินมันดจำ
                            ที่ได้ทำการจ่ายมาเต็มจะนวณ</li>
                        <li>หากยกเลิกการจอง <span class="text-danger">หลังจาก 3 วันก่อนวันจอง</span> ทางโฮมสเตย์จะ <span
                                class="text-danger">ไม่คืน</span>
                            เงินมันดจำ ไม่ว่ากรณีใด</li>
                    </ul>
                    <input type="checkbox" id="policyCancle" name="policyCancle" value="1" onclick="checkPolicy()">
                    <label>ยอมรับข้อตกลงการยกเลิก</label>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="btn-confirmCanclePay" onclick="confirmCanclePay()"
                        disabled>ยืนยัน</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                </div>
            </div>
        </div>
    </div>

    <div class="container d-flex justify-content-center flex-row flex-wrap mt-4">
        <div class="col-md-12 card rounded-3 border border-1 shadow-lg mb-4">
            <div class="card-header">
                รายละเอียดการจอง
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
                                placeholder="ไม่ใช้โปรโมชั่น" value="ไม่ใช้โปรโมชั่น" required readonly>
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
                    @if ($booking->promotion_id == null)
                        <div class="col-md" id="dis_price">
                            <label class="form-label">ส่วนลด *</label>
                            <div class="input-group">
                                <input type="text" name="discount" id="discount" disabled class="form-control"
                                    required value="0">
                                <span class="input-group-text">บาท</span>
                            </div>
                        </div>
                    @else
                        @if ($booking->promotion->discount_price != null)
                            <div class="col-md" id="dis_price">
                                <label class="form-label">ส่วนลด *</label>
                                <div class="input-group">
                                    <input type="text" name="discount" id="discount" disabled class="form-control"
                                        required value="{{ $booking->total_price - $booking->total_price_discount }}">
                                    <span class="input-group-text">บาท</span>
                                </div>
                            </div>
                        @else
                            <div class="col-md" id="dis_price">
                                <label class="form-label">ส่วนลด *</label>
                                <div class="input-group">
                                    <input type="text" name="discount" id="discount" disabled class="form-control"
                                        required value="{{ $booking->total_price - $booking->total_price_discount }}">
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
                    @if ($booking->status == 5)
                        <a href="{{ route('show-payment', $booking->id) }}" class="btn btn-success">ชำระเงิน</a>
                    @endif
                    <button type="button" class="btn btn-success"
                        onclick="printJS({ printable: 'history_booking', type: 'html', header: 'ใบรายการจอง', css:'{{ asset('css/app.css') }}', documentTitle:'ใบรายการจอง - {{ config('app.name') }}'})">
                        <i class='bx bx-printer'></i> ปริ้นใบรายการจอง </button>
                </div>
            </div>
        </div>

        @if ($booking->payments->count() != null)
            <div class="col-md-12 card rounded-3 border border-1 shadow-lg mb-4">
                <div class="card-header">
                    รายละเอียดการจ่ายเงิน
                </div>
                <div class="card-body" id="silp_pay">
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
                                            <input type="text" name="change_deposit" id="change_deposit" disabled
                                                required class="form-control" value="{{ $payment->change }}">
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
                                            <input type="text" name="total_price_change" id="total_price_change"
                                                disabled required class="form-control" value="{{ $payment->change }}">
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
                    @endforeach
                    <div class="mt-4">
                        @if ($booking->status == 2)
                            <button type="button" class="btn btn-success"
                                onclick="printJS({ printable: 'silp_pay', type: 'html', header: 'ใบเสร็จ', css:'{{ asset('css/app.css') }}', documentTitle:'ใบรายการจอง - {{ config('app.name') }}'})">
                                <i class='bx bx-printer'></i> ปริ้นใบเสร็จ </button>
                        @endif
                    </div>
                </div>
            </div>
        @endif
    </div>

    <div class="container">
        @if ($booking->status == 2)
            @if ($booking->review == null)
                <div class="card rounded-3 border border-1 shadow-lg mb-4">
                    <div class="card-header">
                        รีวิวการจองของคุณ *
                    </div>
                    <div class="card-body">
                        <form action="{{ route('add-review', $booking->id) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="labels">รีวิวการจอง *</label>
                                <textarea class="form-control" id="review" name="review" rows="3" required></textarea>
                                <div id="help" class="form-text">รีวิวการจองของคุณ</div>
                            </div>
                            <div class="mb-3">
                                <input type="submit" class="btn btn-success" value="รีวิวการจอง">
                            </div>
                        </form>
                    </div>
                </div>
            @else
                <div class="card rounded-3 border border-1 shadow-lg mb-4">
                    <div class="card-header">
                        รีวิวการจองของคุณ *
                    </div>
                    <div class="card-body">
                        <form action="{{ route('edit-review', $booking->review->id) }}" method="POST" id="edit_review">
                            @csrf
                            <div class="mb-3">
                                <label class="labels">รีวิวการจอง *</label>
                                <textarea class="form-control" form="edit_review" id="editReview" name="editReview" rows="3" required>{{ $booking->review->review_detail }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label class="labels">การตอบกลับจากเจ้าของโฮมสเตย์</label>
                                <textarea class="form-control" form="edit_review" id="reply" name="reply" rows="2" readonly>{{ $booking->review->reply }}</textarea>
                            </div>
                        </form>
                        <form action="{{ route('delete-review', $booking->review->id) }}" method="POST"
                            id="delete_review">
                            @csrf
                        </form>

                        <div class="mb-3">
                            <button type="submit" class="btn btn-success" form="edit_review">แก้ใขรีวิวการจอง</button>
                            <button type="submit" form="delete_review" class="btn btn-danger">ลบรีวิวการจอง</button>
                        </div>

                    </div>
                </div>
            @endif
        @endif
    </div>
@endsection
