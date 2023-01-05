@extends('layouts.admin')

@section('title', 'Add Booking Admin')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>

<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>

<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<script>
    let homestay_price = 0;
    let set_menu_price = 0;
    let discount = 0;
    let total_price_discount = 0;
    let num_date = 0;
    let myArray = [];

    //num_date
    function funcDateRange(date) {
        num_date = 0;
        myArray = [];
        myArray = date.split(" - ");

        let myArray1 = myArray[1].split("-");
        let myArray2 = myArray[0].split("-");
        let d1 = myArray1[2] + "/" + myArray1[1] + "/" + myArray1[0];
        let d2 = myArray2[2] + "/" + myArray2[1] + "/" + myArray2[0];

        num_date = (Date.parse(d1) - Date.parse(d2)) / (1000 * 60 * 60 * 24);

        $("#discount").val(discount);
        $("#priceMenu").val(set_menu_price);
        $("#total_price").val((homestay_price * num_date) + set_menu_price);
        total_price_discount = ((homestay_price * num_date) + set_menu_price) - discount;
        $("#total_price_discount").val(total_price_discount);
        document.getElementById("paytype1").checked = false;
        document.getElementById("paytype2").checked = false;
        $("#deposit").val('');
        $("#toPay").val('');
        $("#payPrice").val('');
        $("#change").val('');
    }

    window.onload = function() {
        const formA = document.getElementById("formA");
        formA.addEventListener('change', (event) => {

            //homestay_name
            let checkboxes = document.querySelectorAll('input[name="homestay_name[]"]:checked');
            let output = [];
            let max_number_guests = 0;
            checkboxes.forEach((checkbox) => {
                output.push(checkbox.value);
            });

            homestay_price = 0;
            for (let i = 0; i <= (output).length - 1; i++) {
                for (let s = 0; s <= (homestays).length - 1; s++) {
                    if (output[i] == homestays[s].id) {
                        homestay_price += homestays[s].homestay_price;
                        max_number_guests += homestays[s].number_guests;
                    }
                }

            }
            const number_guests = document.getElementById('number_guests');
            number_guests.setAttribute('max', max_number_guests);

            //discount
            discount = 0;
            for (let i = 0; i <= (promotions).length - 1; i++) {
                if (document.getElementById("promotion").value == promotions[i].id) {
                    discount = promotions[i].discount_price;
                    break
                }
            }

            //set_menu_price
            set_menu_price = 0;
            for (let i = 0; i <= (set_menus).length - 1; i++) {
                if (document.getElementById("set_menus").value == set_menus[i].id) {
                    set_menu_price = document.getElementById("priceMenu").value * set_menus[i].price;
                    break
                }
            }

            $("#discount").val(discount);
            $("#priceMenu").val(set_menu_price);
            $("#total_price").val((homestay_price * num_date) + set_menu_price);
            total_price_discount = ((homestay_price * num_date) + set_menu_price) - discount;
            $("#total_price_discount").val(total_price_discount);
            document.getElementById("paytype1").checked = false;
            document.getElementById("paytype2").checked = false;
            $("#deposit").val('');
            $("#toPay").val('');
            $("#payPrice").val('');
            $("#change").val('');

            //pay type
            $('input[type="radio"]').on('click', function(e) {
                if (e.target.value == 2) {
                    $("#deposit").val(0);
                    $("#toPay").val(total_price_discount);
                    $("#payPrice").val('');
                    $("#change").val('');
                } else {
                    $("#deposit").val(total_price_discount / 2);
                    $("#toPay").val(total_price_discount / 2);
                    $("#payPrice").val('');
                    $("#change").val('');
                }
            });
        });

        //addEventListener Email Member
        const email = document.getElementById('email');
        const firstName = document.getElementById('firstName');
        const lastName = document.getElementById('lastName');

        var users = @json($users);
        var promotions = @json($promotions);
        var set_menus = @json($set_menus);
        var homestays = @json($homestays);

        const inputHandler = function(e) {
            if (isNaN(e.target.value)) {
                for (let i = 0; i <= (users).length - 1; i++) {
                    if (e.target.value == users[i].email) {
                        $("#firstName").val(users[i].firstName);
                        $("#lastName").val(users[i].lastName);
                        $("#tel").val(users[i].tel);
                        $("#firstName").prop("readonly", true);
                        $("#lastName").prop("readonly", true);
                        $("#tel").prop("readonly", true);
                        document.getElementById("c").innerHTML =
                            'เพิ่มรายการจอง <span class="badge bg-success">เป็นสมาชิกสมาชิก</span>';
                        break
                    } else {
                        document.getElementById("c").innerHTML =
                            'เพิ่มรายการจอง <span class="badge bg-danger">ไม่มีสมาชิก</span>';
                    }
                }
            } else {
                $("#firstName").val('');
                $("#lastName").val('');
                $("#tel").val('');
                $("#firstName").prop("readonly", false);
                $("#lastName").prop("readonly", false);
                $("#tel").prop("readonly", false);
                document.getElementById("c").innerHTML =
                    'เพิ่มรายการจอง <span class="badge bg-danger">ไม่มีสมาชิก</span>';
            }
        }
        email.addEventListener('input', inputHandler);
        email.addEventListener('propertychange', inputHandler);

        //addEventListener payPrice
        const payPrice = document.getElementById('payPrice');
        const change = document.getElementById('result');

        const inputHandler2 = function(e) {
            if (isNaN(e.target.value)) {
                $("#change").val("กรุณาใส่จำนวนเงินตัวเลขจำนวนเต็ม");
                $("#add_booking").prop("disabled", true);
            } else {
                let toPay = document.getElementById("toPay").value;
                if (parseInt(e.target.value) < toPay) {
                    $("#change").val("กรุณาใส่จำนวนเงินให้มากกว่าเงินที่ต้องจ่าย");
                    $("#add_booking").prop("disabled", true);
                } else {
                    $("#change").val(parseInt(e.target.value) - toPay);
                    $("#add_booking").prop("disabled", false);
                }
            }
        }
        payPrice.addEventListener('input', inputHandler2);
        payPrice.addEventListener('propertychange', inputHandler2);

        //Set Date Range Picker
        var today = new Date();
        var date = (today.getDate()) + '-' + (today.getMonth() + 1) + '-' + today.getFullYear()
        $('input[name="dateRange"]').daterangepicker({
            opens: 'left',
            minDate: date,
            locale: {
                format: 'DD-MM-YYYY',
                cancelLabel: 'Clear'
            }
        });
    }
</script>

@section('page-name')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="{{ route('booking-admin') }}">รายการจอง</a></li>
            <li class="breadcrumb-item active" aria-current="page">เพิ่มรายการจอง</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="card rounded-3 border border-1 shadow-lg mb-4">
        <div class="card-header" id="c">
            เพิ่มรายการจอง <span class="badge bg-danger">ไม่มีสมาชิก</span>
        </div>
        <div class="card-body">
            <form action="{{ route('add-booking') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <div id="formA">
                        <div class="mb-3">
                            <label for="homestay_name" class="form-label">อีเมลสมาชิก</label>
                            <input type="email" name="email" id="email" class="form-control" autofocus>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="labels">ชื่อ *</label>
                                <input type="text" name="firstName" id="firstName" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label class="labels">นามสกุล *</label>
                                <input type="text" name="lastName" id="lastName" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label class="labels">เบอร์โทรศัพทร์</label>
                                <input type="text" name="tel" class="form-control" id="tel"
                                    placeholder="099-XXX-XXXX" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="homestay_name" class="form-label">ที่พัก *</label><br>
                            @foreach ($homestays as $homestay)
                                <input type="checkbox" id="hn{{ $homestay->id }}" name="homestay_name[]"
                                    value="{{ $homestay->id }}">
                                <label>{{ $homestay->homestay_name }}</label><br>
                            @endforeach
                        </div>
                        <div class="mb-3">
                            <label for="number_guests" class="form-label">จำนวนผู้เข้าพัก *</label>
                            <input type="number" min="1" step="1" pattern="\d*" class="form-control"
                                id="number_guests" name="number_guests" placeholder="จำนวนผู้เข้าพัก" required>
                        </div>
                        <div class="mb-3">
                            <label for="number_guests" class="form-label">โปรโมชั่น *</label>
                            <select class="form-select" aria-label="Default select example" name="promotion" id="promotion">
                                <option value="0" selected hidden>เลือกโปรโมชั่น</option>
                                @foreach ($promotions as $promotion)
                                    <option value="{{ $promotion->id }}">{{ $promotion->promotion_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <div class="row mt-2">
                                <div class="col-md-4">
                                    <label class="labels">ชุดเมนูอาหาร *</label>
                                    <select class="form-select" aria-label="Default select example" name="set_menu"
                                        id="set_menus">
                                        <option value="0" selected hidden>เลือกชุดเมนูอาหาร</option>
                                        @foreach ($set_menus as $set_menu)
                                            <option value="{{ $set_menu->id }}">{{ $set_menu->set_menu_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="labels">จำนวนชุดเมนูอาหาร *</label>
                                    <input type="number" name="num_menu" id="num_menu" class="form-control">
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
                        </div>
                        <div class="mt-3">
                            <label for="dateRange" class="form-label">ช่วงวันที่เข้าพัก *</label>
                            <?php
                            $currentDate = date('d-m-Y');
                            $d = date('d-m-Y', strtotime($currentDate . ' +1 days'));
                            $valueDate = $currentDate . ' - ' . $d;
                            ?>
                            <input type="text" name="dateRange" id="dateRange" value="{{ $valueDate }}"
                                class="form-control" required onchange="funcDateRange(this.value)" />

                        </div>
                    </div>
                </div>
                <hr class="mt-4 mb-4">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="paytype" id="paytype1" value="1">
                    <label class="form-check-label" for="paytype">จ่ายมัดจำ</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="paytype" id="paytype2" value="2">
                    <label class="form-check-label" for="paytype2">
                        จ่ายเต็มจำนวน
                    </label>
                </div>
                <div class="row mt-2">
                    <div class="col-md-3">
                        <label class="labels">ราคาทั้งหมด *</label>
                        <div class="input-group">
                            <input type="text" name="total_price" id="total_price" readonly required
                                class="form-control">
                            <span class="input-group-text">บาท</span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label class="labels">ส่วนลด *</label>
                        <div class="input-group">
                            <input type="text" name="discount" id="discount" readonly class="form-control" required>
                            <span class="input-group-text">บาท</span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label class="labels">ราคารวมส่วนลด *</label>
                        <div class="input-group">
                            <input type="text" name="total_price_discount" id="total_price_discount" readonly required
                                class="form-control">
                            <span class="input-group-text">บาท</span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label class="labels">เงินมัดจำ *</label>
                        <div class="input-group">
                            <input type="text" name="deposit" id="deposit" readonly class="form-control" required
                                checked>
                            <span class="input-group-text">บาท</span>
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-4">
                        <label class="labels">รับเงินมา *</label>
                        <div class="input-group">
                            <input type="text" name="payPrice" id="payPrice" required class="form-control"
                                pattern="([0-9]){1,}">
                            <span class="input-group-text">บาท</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="labels">เงินที่ต้องจ่าย *</label>
                        <div class="input-group">
                            <input type="text" name="toPay" id="toPay" readonly class="form-control" required>
                            <span class="input-group-text">บาท</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="labels">เงินทอน *</label>
                        <div class="input-group">
                            <input type="text" name="change" id="change" readonly required class="form-control">
                            <span class="input-group-text">บาท</span>
                        </div>
                    </div>
                </div>
                <input type="submit" class="btn btn-success mt-2" id="add_booking" value="ยืนยัน" disabled>
            </form>
        </div>
    </div>
@endsection
