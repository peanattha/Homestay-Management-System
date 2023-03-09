@extends('layouts.admin')

@section('active-manage-appliance', 'active')

@section('title', 'Manage Appliance')

<link rel="stylesheet" href="{{ asset('css/table.css') }}">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script>
    // DrawฺBack Booking
    function showModelDrawฺBackBooking(id) {
        window.id_widenBooking = id;
        $("#modelDrawฺBackBooking").modal("show");
    }

    function confirmDrawฺBackBooking() {
        document.getElementById("drawฺBackBooking" + window.id_widenBooking).submit();
        // console.log("AAA");
    }

    // Edit Widen Booking
    function showModelEditWidenBooking(widen) {
        $("#widen_id").val(widen.id);
        $("#edit_booking_id").val(widen.booking_id);
        $("#edit_appliance_id").val(widen.appliance.id);
        $("#editAmount").val(widen.amount);
        $("#widen_by").val(widen.widen_by);

        var widens = @json($widens).data;
        console.log(widens);
        let widen_id = document.getElementById("widen_id");
        for (let i = 0; i <= (widens).length - 1; i++) {
            if ((widens[i].id == widen_id.value) && (widens[i].status == "2")) {
                document.getElementById("exampleModalCenterTitle").innerHTML =
                    'แก้ใขรายการเบิกของใช้จากรายการจอง <span class="badge bg-success">คืนของเข้าคลัง</span>';
                $("#btn-EditWidenBooking").css("display", "none");
                $("#widen_id").attr("disabled", true);
                $("#edit_booking_id").attr("disabled", true);
                $("#edit_appliance_id").attr("disabled", true);
                $("#editAmount").attr("disabled", true);
                $("#widen_by").attr("disabled", true);
            } else if ((widens[i].id == widen_id.value) && (widens[i].status == "1")) {
                document.getElementById("exampleModalCenterTitle").innerHTML =
                    'แก้ใขรายการเบิกของใช้จากรายการจอง <span class="badge bg-warning text-dark">เบิก</span>';
                $("#btn-EditWidenBooking").css("display", "inline");
                $("#widen_id").attr("disabled", false);
                $("#edit_booking_id").attr("disabled", false);
                $("#edit_appliance_id").attr("disabled", false);
                $("#editAmount").attr("disabled", false);
                $("#widen_by").attr("disabled", false);
            }
        }


        var appliances = @json($appliances);
        for (let i = 0; i <= (appliances).length - 1; i++) { //setค่าตอนเเรก
            if (appliances[i].id == edit_appliance_id.value) {
                $("#stockAmountEdit").val(appliances[i].stock);
                document.getElementById("editAmount").max = appliances[i].stock;
                $("#priceEach").val(appliances[i].price);
                let amount = document.getElementById("editAmount").value;
                document.getElementById("editTotalPrice").value = amount * appliances[i].price;
            }
        }

        $("#modelEditWidenBooking").modal("show");
        // console.log(widen);
    }

    function confirmEditWidenBooking() {
        document.getElementById("formEditWidenbooking").submit();
    }

    window.onload = function() {
        var appliances = @json($appliances);
        const formA = document.getElementById("formA");
        let totalPriceAll = 0;
        formA.addEventListener('change', (event) => {
            let a = 0;
            for (let i = 0; i <= (appliances).length - 1; i++) {
                let amount = document.getElementById("amount" + appliances[i].id).value;
                if (amount > 0) {
                    document.getElementById("totalPrice" + appliances[i].id).value = amount * appliances[i]
                        .price;
                }
                let p = document.getElementById("totalPrice" + appliances[i].id).value;
                a += p * 1;
                document.getElementById("totalPriceAll").value = a;
            }
        });

        for (let i = 0; i <= (appliances).length - 1; i++) {
            document.getElementById("amount" + appliances[i].id).max = appliances[i].stock;
        }

        let edit_appliance_id = document.getElementById("edit_appliance_id");
        edit_appliance_id.addEventListener('change', (event) => {
            let amount = document.getElementById("editAmount").value;
            for (let i = 0; i <= (appliances).length - 1; i++) {
                if (appliances[i].id == edit_appliance_id.value) {
                    $("#stockAmountEdit").val(appliances[i].stock);
                    document.getElementById("editAmount").max = appliances[i].stock;
                    $("#priceEach").val(appliances[i].price);
                    document.getElementById("editTotalPrice").value = amount * appliances[i].price;
                }
            }

        });

        let editAmount = document.getElementById("editAmount");
        editAmount.addEventListener('change', (event) => {
            let amount = document.getElementById("editAmount").value;
            let edit_appliance_id = document.getElementById("edit_appliance_id");
            for (let i = 0; i <= (appliances).length - 1; i++) {
                if (appliances[i].id == edit_appliance_id.value) {
                    if (amount > 0) {
                        document.getElementById("editTotalPrice").value = amount * appliances[i].price;
                    }
                }
            }
        });

    }

    function visAmount(id) {
        var appliance_id = document.getElementById("appliance_id" + id);
        if (appliance_id.checked == true) {
            document.getElementById("amount" + id).readOnly = false;
        } else {
            document.getElementById("amount" + id).readOnly = true;
            document.getElementById("amount" + id).value = "";
            document.getElementById("totalPrice" + id).value = "";

            let a = 0;
            var appliances = @json($appliances);
            for (let i = 0; i <= (appliances).length - 1; i++) {
                let p = document.getElementById("totalPrice" + appliances[i].id).value;
                a += p * 1;
                document.getElementById("totalPriceAll").value = a;
            }
        }
    }
</script>

<style>
    div.ks-cboxtags {
        border: rgba(0, 0, 0, 0.2) 1px solid;
        background-color: #F8FAFC;
        border-radius: 7px;
        height: 37px;

    }

    div.ks-cboxtags input {
        display: inline;
        padding: 6px;
        cursor: pointer;
    }
</style>

@section('page-name')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="{{ route('manage-appliance') }}">ของในคลัง</a></li>
            <li class="breadcrumb-item active" aria-current="page">เบิกของใช้ในคลังจากรายการจอง</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="modal fade" id="modelDrawฺBackBooking" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">แจ้งเตือน</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="textModelDrawฺBackHomedetail">คุณเเน่ใจที่จะคืนของเข้าคลัง</div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" onclick="confirmDrawฺBackBooking()">ยืนยัน</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modelEditWidenBooking" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <p class="modal-title" id="exampleModalCenterTitle">แก้ใขรายการเบิกของใช้จากรายการจอง</p>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('edit-widen-booking') }}" method="POST" class="m-0"
                        id="formEditWidenbooking">
                        @csrf
                        <div class="form-group">
                            <input type="text" style="display: none" name="widen_id" id="widen_id">
                            <div class="mb-3">
                                <label for="homestay_id" class="form-label">รหัสการจอง *</label>
                                <select class="form-select" id="edit_booking_id" name="edit_booking_id" required>
                                    @foreach ($bookings as $booking)
                                        <option value="{{ $booking->id }}">{{ $booking->id }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="amount" min=0 class="form-label">ผู้เบิก *</label>
                                <input type="text" class="form-control" id="widen_by" name="widen_by" required readonly>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="appliance_id" class="form-label">ของใช้ *</label>
                                    <select class="form-select" id="edit_appliance_id" name="edit_appliance_id" required>
                                        @foreach ($appliances as $appliance)
                                            <option value="{{ $appliance->id }}">{{ $appliance->appliance_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="stockAmountEdit" min=0 class="form-label">คงเหลือ *</label>
                                    <input type="number" class="form-control" min="1" id="stockAmountEdit"
                                        name="stockAmountEdit" readonly>
                                </div>
                                <div class="col-md-4">
                                    <label for="priceEach" min=0 class="form-label">ราคา/ชิ้น *</label>
                                    <input type="text" class="form-control" id="priceEach" name="priceEach" readonly>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="amount" min=0 class="form-label">จำนวน *</label>
                                    <input type="number" class="form-control" min="1" id="editAmount"
                                        name="editAmount" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="editTotalPrice" min=0 class="form-label">ราคารวม *</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="editTotalPrice"
                                            name="editTotalPrice" readonly>
                                        <span class="input-group-text">บาท</span>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <button type="button" class="btn btn-success" id="btn-EditWidenBooking"
                                    onclick="confirmEditWidenBooking()">ยืนยัน</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="card rounded-3 border border-1 shadow-lg mb-4">
        <div class="card-header">
            เบิกของใช้ในคลังจากรายการจอง
        </div>
        <div class="card-body">
            <form action="{{ route('widen-booking') }}" method="POST" id="formA">
                @csrf
                <div class="mb-3">
                    <label for="booking_id" class="form-label">รายการจอง *</label>
                    <select class="form-select" id="booking_id" name="booking_id" required>
                        <option selected hidden>เลือกรายการจอง</option>
                        @foreach ($bookings as $booking)
                            <option value="{{ $booking->id }}">{{ $booking->id }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    @foreach ($appliances as $appliance)
                        @if ($loop->iteration == 1)
                            <div class="row mb-3">
                                <div class="col-md-2">
                                    <label class="form-label">ของใช้ *</label>
                                    <div class="ks-cboxtags p-2 m-0">
                                        <input type="checkbox" name="appliance_id[]"
                                            id="appliance_id{{ $appliance->id }}" value="{{ $appliance->id }}"
                                            onclick="visAmount({{ $appliance->id }})">
                                        <label class="form-check-label"
                                            for="appliance_id{{ $appliance->id }}">{{ $appliance->appliance_name }}</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <label for="stockAmount" min=0 class="form-label">คงเหลือ *</label>
                                    <input type="number" class="form-control" min="1" name="stockAmount"
                                        readonly value="{{ $appliance->stock }}">
                                </div>
                                <div class="col-md-2">
                                    <label for="price"class="form-label">ราคา *</label>
                                    <div class="input-group">
                                        <input type="text" name="price" id="price" readonly required
                                            class="form-control" value="{{ $appliance->price }}">
                                        <span class="input-group-text">บาท/ชิ้น</span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label for="amount" min=0 class="form-label">จำนวน *</label>
                                    <input type="number" class="form-control" min="1"
                                        id="amount{{ $appliance->id }}" name="amount{{ $appliance->id }}" readonly>
                                </div>
                                <div class="col-md-3">
                                    <label for="totalPrice"class="form-label">รวมราคา *</label>
                                    <div class="input-group">
                                        <input type="text" name="totalPrice{{ $appliance->id }}"
                                            id="totalPrice{{ $appliance->id }}" readonly required class="form-control">
                                        <span class="input-group-text">บาท</span>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="row mb-3">
                                <div class="col-md-2">
                                    <div class="ks-cboxtags p-2 m-0">
                                        <input type="checkbox" name="appliance_id[]"
                                            id="appliance_id{{ $appliance->id }}" value="{{ $appliance->id }}"
                                            onclick="visAmount({{ $appliance->id }})">
                                        <label class="form-check-label"
                                            for="appliance_id{{ $appliance->id }}">{{ $appliance->appliance_name }}</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <input type="number" class="form-control" min="1" name="stockAmount"
                                        readonly value="{{ $appliance->stock }}">
                                </div>
                                <div class="col-md-2">
                                    <div class="input-group">
                                        <input type="text" name="price" id="price" readonly required
                                            class="form-control" value="{{ $appliance->price }}">
                                        <span class="input-group-text">บาท/ชิ้น</span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <input type="number" class="form-control" min="1"
                                        id="amount{{ $appliance->id }}" name="amount{{ $appliance->id }}" readonly>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group">
                                        <input type="text" name="totalPrice{{ $appliance->id }}"
                                            id="totalPrice{{ $appliance->id }}" readonly required class="form-control">
                                        <span class="input-group-text">บาท</span>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
                <div class="row mb-3">
                    <label for="totalPriceAll"class="form-label">รวมราคา *</label>
                    <div class="input-group">
                        <input type="text" name="totalPriceAll" id="totalPriceAll" readonly required
                            class="form-control">
                        <span class="input-group-text">บาท</span>
                    </div>
                </div>
                <input type="submit" class="btn btn-success" value="เบิกของใช้ในคลัง">
            </form>
        </div>
    </div>

    <hr>

    <div class="card rounded-3 border border-1 shadow-lg mb-4">
        <div class="card-header">
            รายการเบิก
        </div>
        <div class="card-body">
            <form action="{{route('search-widen-booking')}}" method="GET">
                @csrf
                <div class="mb-3">
                    <label for="widen_id" class="form-label">ค้นหารายการเบิก</label>
                    <input type="text" class="form-control" id="widen_id" name="widen_id"
                        placeholder="รหัสรายการเบิก">
                    <div id="help" class="form-text">กรอกรหัสรายการเบิกเพื่อทำการค้นหารายการเบิก</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="labels">เลือกรายการจอง</label>
                        <select class="form-select" id="booking_id" name="booking_id" >
                            <option value="0" selected>เลือกรายการจอง</option>
                            @foreach ($bookings as $booking)
                                <option value="{{ $booking->id }}">{{ $booking->id }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="labels">เลือกของใช้</label>
                        <select class="form-select" id="appliance_id" name="appliance_id" >
                            <option value="0" selected>เลือกของใช้</option>
                            @foreach ($appliances as $appliance)
                                <option value="{{ $appliance->id }}">{{ $appliance->appliance_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="labels">เลือกของใช้</label>
                        <select class="form-select" id="status" name="status" >
                            <option value="0" selected>เลือกสถานะ</option>
                            <option value="1">เบิก</option>
                            <option value="2">คืนของใช้เเล้ว</option>
                        </select>
                    </div>
                </div>
                <input type="submit" class="btn btn-success" value="ค้นหารายการเบิก">
            </form>
        </div>
    </div>
    <div class="table100 ver2 mb-4">
        <div class="table100-head">
            <table>
                <thead>
                    <tr>
                        <th style="width: 5%">ลำดับ</th>
                        <th style="width: 10%">รหัสการจอง</th>
                        <th style="width: 10%">ชื่อของใช้ในคลัง</th>
                        <th style="width: 5%">จำนวน</th>
                        <th style="width: 10%">ราคา</th>
                        <th style="width: 10%">ชื่อบ้านพัก</th>
                        <th style="width: 10%">สถานะ</th>
                        <th style="width: 20%">แก้ไข</th>
                        <th style="width: 10%">คืนของใช้</th>
                    </tr>
                </thead>
            </table>
        </div>
        <div class="table100-body js-pscroll">
            <table>
                <tbody>
                    @foreach ($widens as $widen)
                        <tr>
                            <td style="width: 5%">{{ $loop->iteration }}</td>
                            <td style="width: 10%">{{ $widen->booking->id }}</td>
                            <td style="width: 10%">{{ $widen->appliance->appliance_name }}</td>
                            <td style="width: 5%">{{ $widen->amount }}</td>
                            <td style="width: 10%">
                                {{ $widen->price }}
                            </td>
                            <td style="width: 10%">
                                @foreach ($widen->booking->booking_details as $booking_detail)
                                    @if ($loop->iteration == $widen->booking->booking_details->count())
                                        {{ $booking_detail->homestay->homestay_name }}
                                    @else
                                        {{ $booking_detail->homestay->homestay_name }} ,
                                    @endif
                                @endforeach
                            </td>
                            <td style="width: 10%">
                                @if ($widen->status == 2)
                                    <span class="badge bg-success">คืนของเข้าคลัง</span>
                                @elseif ($widen->status == 1)
                                    <span class="badge bg-warning text-dark">เบิก</span>
                                @endif
                            </td>
                            <td style="width: 20%"><button class="btn btn-primary"
                                    onclick="showModelEditWidenBooking({{ $widen }})">รายละเอียด/แก้ไข</button>
                            </td>
                            {{-- {{ route('drawฺ-back-widen', ['id' => $widen->id]) }} --}}
                            <td style="width: 10%">
                                <form action="{{ route('drawฺ-back-booking', $widen->id) }}" method="POST"
                                    id="drawฺBackBooking{{ $widen->id }}" class="m-0">
                                    @csrf
                                </form>
                                @if ($widen->status == 2)
                                    <button type="button" class="btn btn-danger" disabled>
                                        คืนของใช้
                                    </button>
                                @elseif ($widen->status == 1)
                                    <button type="button" class="btn btn-danger"
                                        onclick="showModelDrawฺBackBooking({{ $widen->id }})">
                                        คืนของใช้
                                    </button>
                                @endif

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    @endsection
