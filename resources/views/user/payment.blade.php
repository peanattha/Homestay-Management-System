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

    /* .carousel-item img {
        border-top-left-radius: 3px;
        border-top-right-radius: 3px;
        height: 300px;
        object-position: 0% 100%;
        object-fit: cover;
    } */

    .price {
        color: #fd7e14;
    }
</style>
@section('content')
    <div class="container detail">
        <div class="card m-4" style="width: 22rem;">
            <div id="carouselExampleSlidesOnly" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="../images/qr_code.png" class="card-img-top" alt="...">
                    </div>
                </div>
            </div>
            <div class="card-body">
                <h5 class="card-title"><b>เลขบัญชี:</b> 1234567898 </h5>
                <p class="card-text text-black mt-4"><b>ชื่อ</b> เจ้าของโฮมสเตย์ นามสกุลเจ้าของโฮมสเตย์ <b>ธนาคาร:</b>
                    ไทยพาณิชย์</p>
            </div>
        </div>
        <div class="form m-4">
            <form action="#" method="post">
                @csrf
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
                <div class="mb-3">
                    <label for="FileImgMultiple" class="form-label">สลิปชำระเงิน *</label>
                    <input class="form-control" type="file" id="FileImgMultiple" name="qr_code">
                </div>
                <input type="submit" class="btn btn-success mt-3" value="ยืนยันการจอง">
            </form>
        </div>
    </div>
@endsection
