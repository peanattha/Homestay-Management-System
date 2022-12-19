@extends('layouts.admin')

@section('title', 'Confirm Booking')

<link rel="stylesheet" href="{{ asset('css/table.css') }}">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script>
    function showModelConfirmPay(booking, promotions, set_menus) {
        Object.keys(booking).forEach(key => {
            console.log(key, booking[key]);
        });

        $("#idConfirmPay").val(booking.id);
        $("#firstNameCheckin").val(booking.user.firstName);
        $("#lastNameCheckin").val(booking.user.lastName);
        $("#date").val(booking.start_date + " - " + booking.end_date);

        var result = "";
        var price = 0;
        for (let i = 0; i <= (booking.booking_details).length - 1; i++) {
            var string = booking.booking_details[i].homestay.homestay_name;
            var result = result.concat(string);

            var price = price + booking.booking_details[i].homestay.homestay_price;
            if (i == (booking.booking_details).length - 1) {
                $("#homestay").val(result);
                $("#homestayPrice").val(price);
            }
        }
        for (let i = 0; i <= (set_menus).length - 1; i++) {
            if (booking.set_menu_id == set_menus[i].id) {
                $("#nameMenu").val(set_menus[i].set_menu_name);
                $("#priceMenu").val(set_menus[i].price);
            }
        }
        $("#image_src").attr("src", "{{ asset('storage/images/') }}/" + booking.payments[0].slip_img).val();
        $("#image_url").attr("href", "{{ asset('storage/images/') }}/" + booking.payments[0].slip_img).val();
        $("#numMenu").val(booking.num_menu);
        $("#num_guests").val(booking.number_guests);
        $("#total_price").val(booking.total_price);
        $("#discount").val(booking.total_price - booking.total_price_discount);
        $("#total_price_discount").val(booking.total_price_discount);
        $("#deposit").val(booking.deposit);
        $("#confirmPayModel").modal("show");
    }

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
            <li class="breadcrumb-item active" aria-current="page">รายการจองที่ต้องยืนยัน</li>
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

    {{-- Model Confirm Pay --}}
    <div class="modal fade" id="confirmPayModel" tabindex="-1" aria-labelledby="confirmPayModelLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <p class="modal-title" id="confirmPayModelLabel">ยืนยันการชำระเงินมันจำ</p>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('confirm-pay-admin') }}" method="POST">
                        @csrf
                        <input type="text" style="display: none" name="idConfirmPay" readonly id="idConfirmPay" required>
                        <div class="row mt-2">
                            <div class="col-md-6">
                                <label class="labels">ชื่อ *</label>
                                <input type="text" name="firstNameCheckin" id="firstNameCheckin" readonly
                                    class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="labels">นามสกุล *</label>
                                <input type="text" name="lastNameCheckin" id="lastNameCheckin" readonly
                                    class="form-control" required>
                            </div>
                        </div>
                        <label class="labels">ช่วงวันเข้าพัก *</label>
                        <input type="text" name="date" id="date" readonly class="form-control" required>
                        <div class="row mt-2">
                            <div class="col-md-4">
                                <label class="labels">บ้านพัก *</label>
                                <input type="text" name="homestay" id="homestay" readonly class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label class="labels">จำนวนผู้เข้าพัก *</label>
                                <input type="text" name="num_guests" id="num_guests" readonly class="form-control"
                                    required>
                            </div>
                            <div class="col-md-4">
                                <label class="labels">ราคา *</label>
                                <div class="input-group">
                                    <input type="text" name="homestayPrice" id="homestayPrice" readonly
                                        class="form-control" required>
                                    <span class="input-group-text">บาท</span>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-4">
                                <label class="labels">ชุดเมนูอาหาร *</label>
                                <input type="text" name="nameMenu" id="nameMenu" readonly required class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label class="labels">จำนวนชุดเมนูอาหาร *</label>
                                <input type="text" name="numMenu" id="numMenu" readonly class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label class="labels">ราคาชุดเมนูอาหาร *</label>
                                <div class="input-group">
                                    <input type="text" name="priceMenu" id="priceMenu" readonly required
                                        class="form-control">
                                    <span class="input-group-text">บาท</span>
                                </div>
                            </div>
                        </div>
                        <hr class="mt-4 mb-4">
                        <div class="d-flex">
                            <div class="col-md-4">
                                <a href="" id="image_url" target="_blank">
                                    <img src="" alt="" id="image_src" width="210px" height="320px">
                                </a>
                            </div>
                            <div class="col-md-8">
                                <div>
                                    <label class="labels">ราคาทั้งหมด *</label>
                                    <div class="input-group">
                                        <input type="text" name="total_price" id="total_price" readonly required
                                            class="form-control">
                                        <span class="input-group-text">บาท</span>
                                    </div>
                                </div>
                                <div>
                                    <label class="labels">ส่วนลด *</label>
                                    <div class="input-group">
                                        <input type="text" name="discount" id="discount" readonly
                                            class="form-control" required>
                                        <span class="input-group-text">บาท</span>
                                    </div>
                                </div>
                                <div>
                                    <label class="labels">ราคารวมส่วนลด *</label>
                                    <div class="input-group">
                                        <input type="text" name="total_price_discount" id="total_price_discount"
                                            readonly required class="form-control">
                                        <span class="input-group-text">บาท</span>
                                    </div>
                                </div>
                                <div>
                                    <label class="labels">เงินมัดจำ *</label>
                                    <div class="input-group">
                                        <input type="text" name="deposit" id="deposit" readonly
                                            class="form-control" required>
                                        <span class="input-group-text">บาท</span>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="mb-2 mt-2">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                            <button type="submit" class="btn btn-success" id="subminConfirmPay"
                                readonly>ยืนยันการชำระเงิน</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

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

    {{-- ค้นหารายการจองที่ต้องยืนยัน --}}
    <div class="card rounded-3 border border-1 shadow-lg">
        <div class="card-header">
            รายการจองที่ต้องยืนยัน
        </div>
        <div class="card-body">
            <form action="{{ route('search-confirm-booking') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label class="form-label">ค้นหารายการจอง</label>
                    <input type="text" class="form-control" style="margin-right: 10px" id="booking_id"
                        name="booking_id" placeholder="รหัสการจอง">
                    <div id="help" class="form-text">กรอกรหัสการจองเพื่อทำการค้นหารายการจอง</div>
                </div>
                <div class="mb-3">
                    <div class="d-flex flex-row">
                        <input type="text" class="form-control" style="margin-right: 10px" id="firstName"
                            name="firstName" placeholder="ชื่อผู้จอง">
                        <input type="text" class="form-control" style="margin-left: 10px" id="lastName"
                            name="lastName" placeholder="นามสกุลผู้จอง">
                    </div>
                    <div id="help" class="form-text">กรอกชื่อผู้จองเพื่อทำการค้นหารายการจอง</div>
                </div>
                <input type="submit" class="btn btn-success" value="ค้นหา">
            </form>
        </div>
    </div>

    {{-- Table รายการจองที่ต้องยืนยัน --}}
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
                        <th style="width: 20%">ยืนยันการชำระเงิน</th>
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
                            <td style="width: 20%">{{ $booking->user->firstName }} {{ $booking->user->lastName }}
                            </td>
                            <td style="width: 10%">
                                @foreach ($booking->booking_details as $booking_detail)
                                    {{ $booking_detail->homestay->homestay_name }}
                                @endforeach
                            </td>
                            <td style="width: 10%">{{ $booking->number_guests }}</td>
                            @for ($i = 0; $i < $booking->payments->count(); $i++)
                                @if ($booking->payments[$i]->payment_type == 1)
                                    <td style="width: 15%">
                                        <a href="{{ asset('storage/images/' . $booking->payments[$i]->slip_img) }}"
                                            target="_blank">สลิปจ่ายเงิน</a>
                                    </td>
                                @endif
                            @endfor
                            <td style="width: 15%"><a href="#"class="btn btn-primary">รายละเอียด</a></td>
                            <form action="{{ route('cancel-pay-admin', $booking->id) }}" method="POST"
                                id="cancle-pay-form{{ $booking->id }}" class="m-0">
                                @csrf
                            </form>
                            <td style="width: 20%">
                                <button type="button" class="btn btn-success"
                                    onclick="showModelConfirmPay({{ $booking }},{{ $promotions }},{{ $set_menus }})">
                                    ยืนยันการชำระเงิน
                                </button>
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
