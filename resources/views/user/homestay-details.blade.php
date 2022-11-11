@extends('layouts.user')

@section('homestay', 'active')

@section('title', 'homestay Details')
<style>
    .detail {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        flex-direction: row;
        flex-wrap: nowrap;
    }

    .form {
        width: 500px;
    }

    .card-block {
        padding: 20px;
    }

    .carousel-item.active {
        background-color: rgba(0, 0, 0, 0);
    }

    .carousel-item img {
        border-top-left-radius: 3px;
        border-top-right-radius: 3px;
        height: 300px;
        object-position: 0% 100%;
        object-fit: cover;
    }

    .price {
        color: #fd7e14;
    }
</style>
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@section('content')
    <div class="container detail">
        <div class="card m-4" style="width: 22rem;">
            <div id="carouselExampleSlidesOnly" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <?php $i = 0; ?>
                    @foreach (json_decode($details->homestay_img) as $img)
                        @if ($i == 0)
                            <?php $i += 1; ?>
                            <div class="carousel-item active">
                                <img src="{{ asset('storage/images/' . $img) }}" class="card-img-top" alt="...">
                            </div>
                        @else
                            <div class="carousel-item">
                                <img src="{{ asset('storage/images/' . $img) }}" class="card-img-top" alt="...">
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
            <div class="card-body">
                <h5 class="card-title">{{ $details->homestay_name }}</h5>
                <p class="card-text text-black-50 mt-4">โฮมสเตย์ตากะยาย ภูผาม่าน, 210 บ้าน ตำบล ภูผาม่าน อำเภอ
                    ภูผาม่าน
                    ขอนแก่น 40350</p>
                <p class="card-text text-black-50 mt-4">{{ $details->homestay_detail }}</p>
                {{-- <hr class="mt-4 mb-4">
                <h5 class="card-title">สิ่งอำนวยความสะดวก</h5>
                <div class="facilities">
                    <img src="../images/wifi.svg" class="m-2" width="50" height="50" alt="">
                    <img src="../images/toilet.svg" class="m-2" width="50" height="50" alt="">
                    <img src="../images/parking.svg" class="m-2" width="50" height="50" alt="">
                    <img src="../images/cafe.svg" class="m-2" width="50" height="50" alt="">
                </div> --}}
            </div>
        </div>
        <div class="form m-4">
            <form action="{{ route('payment') }}" method="post">
                @csrf
                <div class="mb-3">
                    <label for="dateRange" class="form-label">ช่วงวันที่เข้าพัก *</label>
                    <input type="text" name="dateRange" value="{{ $date }}" class="form-control" required
                        readonly />
                </div>
                <div class="mb-3">
                    <label for="number_guests" class="form-label">จำนวนผู้เข้าพัก *</label>
                    <input type="number" min="1" step="1" max="{{ $details->number_guests }}" pattern="\d*"
                        class="form-control" id="number_guests" name="number_guests" placeholder="จำนวนผู้เข้าพัก"
                        value="{{ $guests }}" required readonly>
                </div>
                <hr>
                <div class="mb-3">
                    <label for="setmenu" class="form-label">เลือกชุดเมนูอาการ</label>
                    <select class="form-select" id="setmenu" name="setmenu" required>
                        <option selected hidden>เลือกชุดเมนูอาการ</option>
                        <option value="1">ชุดเมนูอาหารเช้า</option>
                        <option value="2">ชุดเมนูอาหารเช้า2</option>
                        <option value="3">ชุดเมนูอาหารเช้า3</option>
                    </select>
                </div>
                <div class="mb-3">
                    <input type="number" min="0" step="1" pattern="\d*" class="form-control" id="numsetmenu"
                        name="numsetmenu" placeholder="จำนวนชุดเมนูอาการ" required>
                </div>
                <p style="white-space:pre">ใข่กระทะ + กาแฟ X 2 ราคา ฟรี บาท</p>
                <hr>
                <div class="mb-3">
                    <label for="promotion" class="form-label">เลือกโปรโมชั่น</label>
                    <select class="form-select" id="promotion" name="promotion" required>
                        <option selected hidden>เลือกโปรโมชั่น</option>
                        <option value="1">โปรโมชั่น หน้าหนาว</option>
                        <option value="2">โปรโมชั่น2</option>
                        <option value="3">โปรโมชั่น3</option>
                    </select>
                </div>
                <div>
                    รายละเอียดโปรโมชั่น
                    <p style="white-space:pre">โปรโมชั่น หน้าหนาว ส่วนลดราคา 100 บาท</p>
                </div>
                <hr>
                <b>รายละเอียดเพิ่มเติม</b>
                <p style="white-space:pre">{{ $details->homestay_detail }}</p>
                <p style="white-space:pre">ราคา {{ $details->homestay_price }} บาท/คืน</p>
                <h3 class="price"><b>รวมราคา 790 บาท/คืน</b></h3>
                <input type="submit" class="btn btn-success mt-3" value="จอง">
            </form>
        </div>
    </div>
    <div class="container">
        <h4>รีวิวจากลูกค้า</h4>
        <div class="mt-4">
            <p class="mb-2"><b>รีวิว:</b> ห้องพักสะอาด ที่พักดีครับ ลืมของไว้โทรกลับมาส่งของให้เรียบร้อยอย่างไว 🙏🏻🙏🏻
            </p>
            <p><b>เจ้าของโฮมสเตย์:</b> ขอบคุณครับ🙏🏻</p>
        </div>
        <hr>
        <div class="mt-4">
            <p class="mb-2"><b>รีวิว:</b> วิวดี ที่พักโอเคค่ะ แต่เราประทับใจที่เราลืมกระเป๋าตังค์
                ที่พักติดต่อมาและส่งมาให้โดยที่เราไม่ต้องร้องขอ ตรงนี้ประทับใจมากค่ะ</p>
        </div>
        <hr>
        <div class="mt-4">
            <p class="mb-2"><b>รีวิว:</b> บริการดีมากค่ะ อาหารอร่อย ห้องน้ำสะอาด</p>
        </div>
        <hr>
        <div class="mt-4">
            <p class="mb-2"><b>รีวิว:</b> วิวสวย แต่คาเฟ่ แหละพนักงานที่พักบางคน
                ไม่มีความเต็มใจในการบริการชักสีหน้าใส่ลูกค้า</p>
            <p><b>เจ้าของโฮมสเตย์:</b> ทางโฮมสเตย์ต้องขออภัยด้วยครับ 🙏🏻</p>
        </div>
        <hr>
        <div class="mt-4">
            <p class="mb-2"><b>รีวิว:</b> บรรยากาศดี บริการดี วิวสวย สะอาด กาแฟอร่อย คาเฟ่สวยน่ารัก
                แนะนำเลยถ้ามาภูผาม่านต้องมาค่าเฟ่ที่นี้
                แต่ส่วนที่พักจองบ้านภูผาม่านราคา1000 ไม่คุ้มเงินเลยบอกเลยไม่คุ้มเงิน จริงๆ
                ถ้า1000ก็ควรจะทำห้องให้ดีกว่านี้เครื่องทำน้ำอุ่นก็ใช้ไม่ได้
                ทีวีเปิดไม่ติด ตรงที่ตั้งกาน้ำร้อนก็ไม่มีที่เสียบปลั้ก
                แถมยังมีน้ำในกาเหลือจากคนเก่าที่พักก่อนน่าด้วย
                ส่วนบ้าน Family house เป็นห้องน้ำรวม แต่ประตูห้องน้ำล็อคไม่ได้เลย
                เเนะนำแค่คาเฟ่เท่านั้นเฉพาะคนชอบกินกาแฟถ่ายรูป</p>
            <p><b>เจ้าของโฮมสเตย์:</b> ขอบคุณครับ🙏🏻</p>
        </div>
    </div>

@endsection
