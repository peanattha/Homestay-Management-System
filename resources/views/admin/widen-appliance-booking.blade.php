@extends('layouts.admin')

@section('active-manage-appliance', 'active')

@section('title', 'Manage Appliance')

<link rel="stylesheet" href="{{ asset('css/table.css') }}">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script>
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
                                        <input type="checkbox" name="appliance_id[]" id="appliance_id{{ $appliance->id }}"
                                            value="{{ $appliance->id }}" onclick="visAmount({{ $appliance->id }})">
                                        <label class="form-check-label"
                                            for="appliance_id{{ $appliance->id }}">{{ $appliance->appliance_name }}</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <label for="stockAmount" min=0 class="form-label">คงเหลือ *</label>
                                    <input type="number" class="form-control" min="1" name="stockAmount" readonly
                                        value="{{ $appliance->stock }}">
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
                                        <input type="text" name="totalPrice{{ $appliance->id }}" id="totalPrice{{ $appliance->id }}"
                                            readonly required class="form-control">
                                        <span class="input-group-text">บาท</span>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="row mb-3">
                                <div class="col-md-2">
                                    <div class="ks-cboxtags p-2 m-0">
                                        <input type="checkbox" name="appliance_id[]" id="appliance_id{{ $appliance->id }}"
                                            value="{{ $appliance->id }}" onclick="visAmount({{ $appliance->id }})">
                                        <label class="form-check-label"
                                            for="appliance_id{{ $appliance->id }}">{{ $appliance->appliance_name }}</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <input type="number" class="form-control" min="1" name="stockAmount" readonly
                                        value="{{ $appliance->stock }}">
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
                                        <input type="text" name="totalPrice{{ $appliance->id }}" id="totalPrice{{ $appliance->id }}"
                                            readonly required class="form-control">
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
            <form action="#" method="GET">
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
                        <select class="form-select" id="booking_id" name="booking_id" required>
                            <option selected hidden>เลือกรายการจอง</option>
                            @foreach ($bookings as $booking)
                                <option value="{{ $booking->id }}">{{ $booking->id }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="labels">เลือกของใช้</label>
                        <select class="form-select" id="appliance_id" name="appliance_id" required>
                            <option selected hidden>เลือกของใช้</option>
                            @foreach ($appliances as $appliance)
                                <option value="{{ $appliance->id }}">{{ $appliance->appliance_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="labels">เลือกของใช้</label>
                        <select class="form-select" id="status" name="status" required>
                            <option selected hidden>เลือกสถานะ</option>
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
                                    onclick="showModelEditHomedetail({{ $widen }})">รายละเอียด/แก้ไข</button>
                            </td>
                            {{-- {{ route('drawฺ-back-widen', ['id' => $widen->id]) }} --}}
                            <td style="width: 10%">
                                <form action="#" method="POST" id="drawฺBack-homestaydetail{{ $widen->id }}"
                                    class="m-0">
                                    @csrf
                                </form>
                                @if ($widen->status == 2)
                                    <button type="button" class="btn btn-danger"
                                        onclick="showModelDrawฺBackHomedetail({{ $widen->id }})" disabled>
                                        คืนของใช้
                                    </button>
                                @elseif ($widen->status == 1)
                                    <button type="button" class="btn btn-danger"
                                        onclick="showModelDrawฺBackHomedetail({{ $widen->id }})">
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
