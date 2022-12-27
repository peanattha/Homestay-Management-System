@extends('layouts.admin')

@section('title', 'Check-Out')

<link rel="stylesheet" href="{{ asset('css/table.css') }}">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script>
    function showModelCheckOut(booking, set_menus) {
        Object.keys(booking).forEach(key => {
            console.log(key, booking[key]);
        });
        Object.keys(set_menus).forEach(key => {
            console.log(key, set_menus[key]);
        });
        $("#idCheckIn").val(booking.id);
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

        $("#numMenu").val(booking.num_menu);
        $("#num_guests").val(booking.number_guests);

        let totalPrice = 0;
        if (booking.widen) {
            for (let s = 0; s <= (booking.widen).length - 1; s++) {
                document.getElementById("appliance").innerHTML +=
                    '<div class="row mt-2"><div class="col-md-6"><label class="labels">ของใช้ *</label><input type="text" name="applianceName" id="applianceName" readonly required class="form-control"></div> <div class="col-md-6"> <label class="labels">ราคา *</label> <div class="input-group"> <input type="text" name="priceAppliance" id="priceAppliance" readonly class="form-control" required> <span class="input-group-text">บาท</span> </div> </div> </div>';
                totalPrice += booking.widen[i].price;
            }

           
        } else {
            document.getElementById("appliance").innerHTML = 'ไม่มีค่าใช้จ่ายเพิ่มเติม';
            $("#subminCheckOut").prop("disabled", false);
        }


        $("#checkOutModel").modal("show");
    }
</script>

@section('page-name')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="#">รายการจอง</a></li>
            <li class="breadcrumb-item active" aria-current="page">Check-Out</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="modal fade" id="checkOutModel" tabindex="-1" aria-labelledby="checkOutModelLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <p class="modal-title" id="checkOutModelLabel">Check Out <span class="badge bg-warning text-dark">รอ
                            Check Out</span></p>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <input type="text" style="display: none" name="idCheckIn" readonly id="idCheckIn" required>
                    <div class="row mt-2">
                        <div class="col-md-6">
                            <label class="labels">ชื่อ *</label>
                            <input type="text" name="firstNameCheckin" id="firstNameCheckin" readonly
                                class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="labels">นามสกุล *</label>
                            <input type="text" name="lastNameCheckin" id="lastNameCheckin" readonly class="form-control"
                                required>
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
                            <input type="text" name="num_guests" id="num_guests" readonly class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="labels">ราคา *</label>
                            <div class="input-group">
                                <input type="text" name="homestayPrice" id="homestayPrice" readonly class="form-control"
                                    required>
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
                </div>
                <hr class="m-0">
                <div class="modal-header">
                    <p class="modal-title" id="">ค่าใช้จ่ายเพิ่มเติม</p>
                </div>
                <div class="modal-body">
                    <form action="#" method="POST">
                        @csrf

                        <div id="appliance">

                        </div>

                        <div id="toPay">
                            <div class="row mt-2">
                                <div class="col-md-4"> <label class="labels">รวมราคาที่ต้องจ่ายเพิ่มเติม *</label>
                                    <div class="input-group"> <input type="text" name="payExtra" id="payExtra"
                                            readonly required class="form-control"> <span
                                            class="input-group-text">บาท</span> </div>
                                </div>
                                <div class="col-md-4"> <label class="labels">รับเงินมา *</label>
                                    <div class="input-group"> <input type="text" name="payPrice" id="payPrice"
                                            autofocus required class="form-control" pattern="([0-9]){1,}"> <span
                                            class="input-group-text">บาท</span> </div>
                                </div>
                                <div class="col-md-4"> <label class="labels">เงินทอน *</label>
                                    <div class="input-group"> <input type="text" name="change" id="change"
                                            readonly required class="form-control"> <span
                                            class="input-group-text">บาท</span> </div>
                                </div>
                            </div>
                        </div>



                        <div class="mb-2 mt-2">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                            <button type="submit" class="btn btn-success" id="subminCheckOut" disabled>ยืนยัน Check
                                Out</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="card rounded-3 border border-1 shadow-lg">
        <div class="card-header">
            Check-Out
        </div>
        <div class="card-body">
            <form action="{{ route('search-check-out') }}" method="POST" enctype="multipart/form-data">
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
                <button type="submit" class="btn btn-success">
                    <i class='bx bx-search'></i>
                    ค้นหา
                </button>
            </form>
        </div>
    </div>

    <div class="table100 ver2 mb-4 mt-4">
        <div class="table100-head">
            <table>
                <thead>
                    <tr>
                        <th style="width: 5%">ลำดับ</th>
                        <th style="width: 15%">ชื่อผู้จอง</th>
                        <th style="width: 10%">ชื่อที่พัก</th>
                        <th style="width: 10%">จำนวนผู้เข้าพัก</th>
                        <th style="width: 10%">สถานะ</th>
                        <th style="width: 15%">เข้าพัก</th>
                        <th style="width: 15%">รายละเอียดเพิ่มเติม</th>
                        <th style="width: 15%">Check-Out</th>
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
                            <td style="width: 15%">{{ $booking->user->firstName }} {{ $booking->user->lastName }}</td>
                            <td style="width: 10%">
                                @foreach ($booking->booking_details as $booking_detail)
                                    {{ $booking_detail->homestay->homestay_name }}
                                @endforeach
                            </td>
                            <td style="width: 10%">{{ $booking->number_guests }}</td>
                            <td style="width: 10%"><span class="badge bg-warning text-dark">รอ Check Out</span></td>
                            <?php
                            $start_date = date('d-m-Y', strtotime($booking->start_date));
                            $end_date = date('d-m-Y', strtotime($booking->end_date));
                            $valueDate = $start_date . ' - ' . $end_date;
                            ?>
                            <td style="width: 15%">{{ $valueDate }}</td>
                            <td style="width: 15%"><a href="{{ route('booking-detail', $booking->id) }}"
                                    class="btn btn-primary">รายละเอียด</a></td>
                            <td style="width: 15%">
                                <button type="button" class="btn btn-success"
                                    onclick="showModelCheckOut({{ $booking }},{{ $set_menus }})">
                                    Check Out
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
