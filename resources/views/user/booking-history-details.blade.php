@extends('layouts.user')

@section('title', 'Booking History Details')

@section('booking-history', 'active')

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
                    <img src="../images/anda.jpg" class="card-img-top" alt="...">
                </div>
                <div class="card-body">
                    <h5 class="card-title"></h5>
                    <p class="card-text text-black-50 mt-4">โฮมสเตย์ตากะยาย ภูผาม่าน, 210 บ้าน ตำบล ภูผาม่าน อำเภอ
                        ภูผาม่าน
                        ขอนแก่น 40350</p>
                    <p class="card-text text-black-50 mt-4"></p>
                </div>
            </div>
        </div>
        <div class="form m-4">
            <div>
                <div class="mb-3">
                    <label for="dateRange" class="form-label">ช่วงวันที่เข้าพัก *</label>
                    <input type="text" name="dateRange" value="01-10-2022 - 02-10-2022" class="form-control" required
                        readonly />
                </div>
                <div class="mb-3">
                    <label for="number_guests" class="form-label">จำนวนผู้เข้าพัก *</label>
                    <input type="number" min="1" step="1" max="" pattern="\d*" class="form-control"
                        id="number_guests" name="number_guests" placeholder="จำนวนผู้เข้าพัก" value="2" required
                        readonly>
                </div>
                <hr>
                <div class="mb-3">
                    <label for="setmenu" class="form-label">เลือกชุดเมนูอาการ *</label>
                    <input type="text" name="setmenu" value="ชุดเมนูอาหารเช้า" class="form-control" required readonly />
                </div>
                <div class="mb-3">
                    <label for="setmenu" class="form-label">จำนวนชุดเมนูอาการ *</label>
                    <input type="number" min="0" step="1" pattern="\d*" class="form-control" id="numsetmenu"
                        name="numsetmenu" placeholder="จำนวนชุดเมนูอาการ" value="2" required readonly>
                </div>
                <p style="white-space:pre">ใข่กระทะ + กาแฟ X 2</p>
                <hr>
                <div class="mb-3">
                    <label for="promotion" class="form-label">เลือกโปรโมชั่น</label>
                    <input type="text" class="form-control" id="promotion" name="promotion" placeholder="เลือกโปรโมชั่น"
                        value="โปรโมชั่น หน้าหนาว" required readonly>
                </div>
                <div>
                    รายละเอียดโปรโมชั่น
                    <p style="white-space:pre">โปรโมชั่น หน้าหนาว ส่วนลดราคา 100 บาท</p>
                </div>
                <hr>
                <b>รายละเอียดเพิ่มเติม</b>
                <p style="white-space:pre">เข้าพักได้ 2 ท่าน<br>ไม่อนุญาตให้นำสัตว์เลี้ยงเข้าที่พักโดยเด็ดขาด</p>
                <p><b>รวมราคา 1400 บาท</b></p>
                <h3 class="price"><b>ราคามัดจำ 700 บาท</b></h3>
                <p><b>สถานะ:</b>ชำระเงินมัดจำเสร็จสิ้น ริยืนยันการชำระเงินจากทางเจ้าของโฮมสเตย์</p>
                <img src="../images/qr_code.png" width="200px" alt="..."><br>
            </div>
            <input type="submit" class="btn btn-danger mt-3" value="ยกเลิกการจอง">
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
