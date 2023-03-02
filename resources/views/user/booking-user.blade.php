@extends('layouts.user')

@section('homestay', 'active')

@section('title', 'จองบ้านพัก')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<style>
    .carousel-item img {
        height: 300px;
        width: 630px;
        object-fit: cover;
    }

    .cards {
        display: flex;
        padding: 25px 0px;
        list-style: none;
        overflow-x: scroll;
        scroll-snap-type: x mandatory;
    }

    .card {
        display: flex;
        flex-direction: column;
        flex: 0 0 100%;
        background: #FFF;
        scroll-snap-align: start;
        transition: all 0.2s;
    }

    .card:not(:last-child) {
        margin-right: 10px;
    }

    .card .card-title {
        font-size: 20px;
    }

    .card .card-link-wrapper {
        margin-top: auto;
    }

    .cards::-webkit-scrollbar {
        height: 12px;
    }

    .cards::-webkit-scrollbar-thumb,
    .cards::-webkit-scrollbar-track {
        border-radius: 92px;
    }

    .cards::-webkit-scrollbar-thumb {
        background: #7a9570;
    }

    .cards::-webkit-scrollbar-track {
        background: #edf2f4;
    }

    @media (min-width: 500px) {
        .card {
            flex-basis: calc(50% - 10px);
        }

        .card:not(:last-child) {
            margin-right: 20px;
        }
    }

    @media (min-width: 700px) {
        .card {
            flex-basis: calc(calc(100% / 3) - 20px);
        }

        .card:not(:last-child) {
            margin-right: 30px;
        }
    }

    @media (min-width: 1100px) {
        .card {
            flex-basis: calc(25% - 30px);
        }

        .card:not(:last-child) {
            margin-right: 40px;
        }
    }
</style>
<script>
    window.onload = function() {

        var homestays = @json($homestays);
        var promotions = @json($promotions);
        var set_menus = @json($set_menus);
        var dateRange = @json($dateRange);

        homestay_price = 0;
        for (let s = 0; s <= (homestays).length - 1; s++) {
            homestay_price += homestays[s].homestay_price;
        }
        num_date = 0;
        myArray = [];
        myArray = dateRange.split(" - ");

        let myArray1 = myArray[1].split("-");
        let myArray2 = myArray[0].split("-");
        let d1 = myArray1[2] + "/" + myArray1[1] + "/" + myArray1[0];
        let d2 = myArray2[2] + "/" + myArray2[1] + "/" + myArray2[0];

        num_date = (Date.parse(d1) - Date.parse(d2)) / (1000 * 60 * 60 * 24);

        //setค่าตอนแรก
        $("#discount").val(0);
        $("#total_price").val((homestay_price * num_date));
        total_price_discount = ((homestay_price * num_date));
        $("#total_price_discount").val(Math.floor(total_price_discount));
        $("#deposit").val(Math.floor(total_price_discount / 2));

        const booking_info = document.getElementById("booking_info");
        booking_info.addEventListener('change', (event) => {
            max_number_guests = 0;
            homestay_price = 0;
            for (let s = 0; s <= (homestays).length - 1; s++) {
                homestay_price += homestays[s].homestay_price;
                max_number_guests += homestays[s].number_guests;
            }
            const number_guests = document.getElementById('number_guests');
            number_guests.setAttribute('max', max_number_guests);

            //set_menu_price
            set_menu_price = 0;
            for (let i = 0; i <= (set_menus).length - 1; i++) {
                if (document.getElementById("set_menus").value == set_menus[i].id) {
                    set_menu_price = document.getElementById("num_menu").value * set_menus[i].price;
                    break
                }
            }

            //discount
            discount = 0;
            if (promotions.length == 0) {
                total_price_discount = ((homestay_price * num_date) + set_menu_price) - discount;
                $("#discount_price").val(discount);
                $("#discount").val(discount);
                $("#discount_per").val(discount);
            } else {
                for (let i = 0; i <= (promotions).length - 1; i++) {
                    if (document.getElementById("promotion").value == promotions[i].id) {
                        if (promotions[i].discount_price != null) {
                            promotion_type = 1;
                            discount = promotions[i].discount_price;
                            total_price_discount = ((homestay_price * num_date) + set_menu_price) -
                                discount;
                            document.getElementById("dis_per").style.display = "none";
                            document.getElementById("dis_price").style.display = "block";
                            $("#discount_price").val(discount);
                            $("#discount").val(discount);
                            break
                        } else {
                            promotion_type = 2;
                            discount = promotions[i].percent;
                            total_price_discount = ((homestay_price * num_date) + set_menu_price) - Math
                                .floor(
                                    homestay_price * (discount / 100));
                            document.getElementById("dis_per").style.display = "block";
                            document.getElementById("dis_price").style.display = "block";
                            $("#discount").val(Math.floor(homestay_price * (discount / 100)));
                            $("#discount_per").val(discount);
                            $("#discount_price").val(Math.floor(homestay_price * (discount / 100)));
                            break
                        }
                    }
                }
            }



            num_date = 0;
            myArray = [];
            myArray = dateRange.split(" - ");

            let myArray1 = myArray[1].split("-");
            let myArray2 = myArray[0].split("-");
            let d1 = myArray1[2] + "/" + myArray1[1] + "/" + myArray1[0];
            let d2 = myArray2[2] + "/" + myArray2[1] + "/" + myArray2[0];

            num_date = (Date.parse(d1) - Date.parse(d2)) / (1000 * 60 * 60 * 24);


            $("#priceMenu").val(set_menu_price);
            $("#total_price").val((homestay_price * num_date) + set_menu_price);
            $("#total_price_discount").val(Math.floor(total_price_discount));
            $("#deposit").val(Math.floor(total_price_discount / 2));

        });

    }
</script>
@section('page-name')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">หน้าหลัก</a></li>
            <li class="breadcrumb-item"><a href="javascript:history.back()">ค้นหาโฮมสเตย์</a></li>
            <li class="breadcrumb-item active" aria-current="page">จองบ้านพัก</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="container">
        <ul class="cards">
            @foreach ($homestays as $homestay)
                <li class="card p-3 rounded-3 border border-1">
                    <div>
                        <h3 class="card-title">{{ $homestay->homestay_name }}</h3>
                        <div class="card-content">
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                        </div>
                    </div>
                    <div class="card-link-wrapper">
                        <a href="{{ route('homestay-details-user', $homestay->id) }}"
                            class="btn btn-success">ดูรายละเอียดเพิ่มเติม</a>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
    <div class="container">
        <div class="col-md-12 card rounded-3 border border-1 shadow-lg mb-4 mt-4">
            <div class="card-header">
                ข้อมูลการจอง
            </div>
            <div class="card-body" id="booking_info">
                <form action="{{ route('add-booking-user') }}" method="POST" class="m-0">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="labels">ชื่อ *</label>
                            <input type="text" name="firstName" class="form-control" value="{{ $user->firstName }}"
                                required readonly>
                        </div>
                        <div class="col-md-4">
                            <label class="labels">นามสกุล *</label>
                            <input type="text" name="lastName" class="form-control" value="{{ $user->lastName }}"
                                required readonly>
                        </div>
                        <div class="col-md-4">
                            <label class="labels">เบอร์โทรศัพท์ *</label>
                            <input type="text" name="tel" class="form-control" value="{{ $user->tel }}" readonly>
                        </div>
                    </div>
                    <hr>
                    <div class="mb-3">
                        <label for="homestay_name" class="form-label">ที่พัก *</label><br>
                        <?php
                        $homestay_price_total = 0;
                        ?>
                        @foreach ($homestays as $homestay)
                            <input type="checkbox" id="homestay_name" name="homestay_name[]" value="{{ $homestay->id }}"
                                checked onclick="return false;" />
                            <label>{{ $homestay->homestay_name }}</label>
                            <?php
                            $homestay_price_total += $homestay->homestay_price;
                            ?>
                        @endforeach

                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="dateRange" class="form-label">ช่วงวันที่เข้าพัก *</label>
                            <input type="text" name="dateRange" value=" {{ $dateRange }}" class="form-control"
                                required readonly />
                        </div>
                        <div class="col-md-4">
                            <label for="number_guests" class="form-label">จำนวนผู้เข้าพัก *</label>
                            <input type="number" min="1" step="1" max="" pattern="\d*"
                                class="form-control" id="number_guests" name="number_guests" placeholder="จำนวนผู้เข้าพัก"
                                required>
                        </div>
                        <div class="col-md-4">
                            <label for="homestay_price_total" class="form-label">ราคา *</label>
                            <div class="input-group">
                                <input type="text" name="homestay_price_total" id="homestay_price_total" readonly
                                    required class="form-control" value="{{ $homestay_price_total }}">
                                <span class="input-group-text">บาท</span>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="mb-3">
                        <div class="row mt-2">
                            <div class="col-md-4">
                                <label class="labels">ชุดเมนูอาหาร *</label>
                                <select class="form-select" aria-label="Default select example" name="set_menu"
                                    id="set_menus" required>
                                    <option value="" selected hidden>เลือกชุดเมนูอาหาร</option>
                                    @foreach ($set_menus as $set_menu)
                                        <option value="{{ $set_menu->id }}">{{ $set_menu->set_menu_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="labels">จำนวนชุดเมนูอาหาร *</label>
                                <input type="number" name="num_menu" id="num_menu" class="form-control" required>
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
                    <hr>
                    <div class="row mb-3">
                        <div class="col-md">
                            <label for="promotion" class="form-label">โปรโมชั่น</label>
                            <label for="number_guests" class="form-label">โปรโมชั่น</label>
                            <select class="form-select" aria-label="Default select example" name="promotion"
                                id="promotion">
                                <option value="0" selected hidden>เลือกโปรโมชั่น</option>
                                @if ($promotions->count() == null)
                                    <option value="0">ไม่มีโปรโมชั่น</option>
                                @else
                                    @foreach ($promotions as $promotion)
                                        <option value="{{ $promotion->id }}">{{ $promotion->promotion_name }}</option>
                                    @endforeach
                                @endif

                            </select>
                        </div>
                        <div class="col-md" id="dis_price">
                            <label for="discount_price" class="form-label">ส่วนลด (บาท)* </label>
                            <div class="input-group">
                                <input type="text" name="discount_price" id="discount_price" readonly
                                    class="form-control">
                                <span class="input-group-text">บาท</span>
                            </div>
                        </div>
                        <div class="col-md" id="dis_per">
                            <label class="form-label">ส่วนลด (เปอร์เซ็นต์)*</label>
                            <div class="input-group">
                                <input type="text" name="discount_per" id="discount_per" readonly
                                    class="form-control" required>
                                <span class="input-group-text">เปอร์เซ็นต์ (%)</span>
                            </div>
                        </div>
                    </div>
                    <hr>
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
                                <input type="text" name="discount" id="discount" readonly class="form-control"
                                    required>
                                <span class="input-group-text">บาท</span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="labels">ราคารวมส่วนลด *</label>
                            <div class="input-group">
                                <input type="text" name="total_price_discount" id="total_price_discount" readonly
                                    required class="form-control">
                                <span class="input-group-text">บาท</span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="labels">เงินมัดจำ *</label>
                            <div class="input-group">
                                <input type="text" name="deposit" id="deposit" readonly class="form-control"
                                    required>
                                <span class="input-group-text">บาท</span>
                            </div>
                        </div>
                    </div>
                    <input type="submit" class="btn btn-success mt-2" id="add_booking" value="จองที่พัก">
                </form>
            </div>
        </div>
    </div>

@endsection
