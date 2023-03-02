@extends('layouts.admin')

@section('active-manage-appliance', 'active')

@section('title', 'Manage Appliance')

<link rel="stylesheet" href="{{ asset('css/table.css') }}">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script>
    // DrawฺBack Homedetail
    function showModelDrawฺBackHomedetail(id) {
        window.id_homedetail = id;
        $("#modelDrawฺBackHomedetail").modal("show");
    }

    function confirmDrawฺBackHomedetail() {
        document.getElementById("drawฺBack-homestaydetail" + window.id_homedetail).submit();
        console.log("AAA");
    }

    // Edit homestay detail
    function showModelEditHomedetail(homestay_detail) {
        $("#homestay_detail_id").val(homestay_detail.id);
        $("#edit_homestay_id").val(homestay_detail.homestay.id);
        $("#edit_appliance_id").val(homestay_detail.appliance.id);
        $("#editAmount").val(homestay_detail.amount);
        $("#widen_by").val(homestay_detail.widen_by);
        var homestay_details = @json($homestay_details);
        // console.log(homestay_details);
        let homestay_detail_id = document.getElementById("homestay_detail_id");
        for (let i = 0; i <= (homestay_details).length - 1; i++) {
            if ((homestay_details[i].id == homestay_detail_id.value) && (homestay_details[i].status == "2")) {
                // console.log(homestay_detail_id.value);
                document.getElementById("exampleModalCenterTitle").innerHTML =
                    'แก้ไขรายการเบิกของเข้าบ้านพัก <span class="badge bg-success">คืนของเข้าคลัง</span>';
                $("#btn-EditHomedetail").css("display", "none");
                $("#edit_homestay_id").attr("disabled", true);
                $("#edit_appliance_id").attr("disabled", true);
                $("#stockAmountEdit").attr("disabled", true);
                $("#editAmount").attr("disabled", true);
            } else if ((homestay_details[i].id == homestay_detail_id.value) && (homestay_details[i].status == "1")) {
                document.getElementById("exampleModalCenterTitle").innerHTML =
                    'แก้ไขรายการเบิกของเข้าบ้านพัก <span class="badge bg-warning text-dark">เบิก</span>';
                $("#btn-EditHomedetail").css("display", "inline");
                $("#edit_homestay_id").attr("disabled", false);
                $("#edit_appliance_id").attr("disabled", false);
                $("#stockAmountEdit").attr("disabled", false);
                $("#editAmount").attr("disabled", false);
            }
        }

        var appliances = @json($appliances);
        for (let i = 0; i <= (appliances).length - 1; i++) {
            if (appliances[i].id == edit_appliance_id.value) {
                $("#stockAmountEdit").val(appliances[i].stock);
            }
        }

        $("#modelEditHomedetail").modal("show");
        // console.log(homestay_detail);
    }

    function confirmAddEditHomedetail() {
        document.getElementById("formEditHomedetail").submit();
    }

    window.onload = function() {
        let appliance_id = document.getElementById("appliance_id");
        var appliances = @json($appliances);
        // console.log(appliances);
        appliance_id.addEventListener('change', (event) => {

            for (let i = 0; i <= (appliances).length - 1; i++) {
                if (appliances[i].id == appliance_id.value) {
                    $("#stockAmount").val(appliances[i].stock);
                }
            }

        });

        let edit_appliance_id = document.getElementById("edit_appliance_id");
        edit_appliance_id.addEventListener('change', (event) => {
            for (let i = 0; i <= (appliances).length - 1; i++) {
                if (appliances[i].id == edit_appliance_id.value) {
                    $("#stockAmountEdit").val(appliances[i].stock);
                }
            }

        });

    }
</script>

@section('page-name')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="{{ route('manage-appliance') }}">ของในคลัง</a></li>
            <li class="breadcrumb-item active" aria-current="page">เบิกของใช้ในคลังเข้าบ้านพัก</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="modal fade" id="modelDrawฺBackHomedetail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">แจ้งเตือน</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="textModelDrawฺBackHomedetail">คุณเเน่ใจที่จะคืนของเข้าคลัง</div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" onclick="confirmDrawฺBackHomedetail()">ยืนยัน</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modelEditHomedetail" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <p class="modal-title" id="exampleModalCenterTitle"></p>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('edit-widen-homestay') }}" method="POST" class="m-0" id="formEditHomedetail">
                        @csrf
                        <div class="form-group">
                            <input type="text" style="display: none" name="homestay_detail_id" id="homestay_detail_id">
                            <div class="mb-3">
                                <label for="homestay_id" class="form-label">บ้านพัก *</label>
                                <select class="form-select" id="edit_homestay_id" name="edit_homestay_id" required>
                                    @foreach ($homestays as $homestay)
                                        <option value="{{ $homestay->id }}">{{ $homestay->homestay_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="appliance_id" class="form-label">ของใช้ *</label>
                                    <select class="form-select" id="edit_appliance_id" name="edit_appliance_id" required>
                                        @foreach ($appliances as $appliance)
                                            <option value="{{ $appliance->id }}">{{ $appliance->appliance_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="stockAmountEdit" min=0 class="form-label">คงเหลือ *</label>
                                    <input type="number" class="form-control" min="1" id="stockAmountEdit"
                                        name="stockAmountEdit" readonly>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="amount" min=0 class="form-label">ผู้เบิก *</label>
                                <input type="text" class="form-control" id="widen_by" name="widen_by" required readonly>
                            </div>
                            <div class="mb-3">
                                <label for="amount" min=0 class="form-label">จำนวน *</label>
                                <input type="number" class="form-control" min="1" id="editAmount" name="editAmount"
                                    required>
                            </div>
                            <div>
                                <button type="button" class="btn btn-success" id="btn-EditHomedetail"
                                    onclick="confirmAddEditHomedetail()">ยืนยัน</button>
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
            เบิกของใช้ในคลังเข้าบ้านพัก
        </div>
        <div class="card-body">
            <form action="{{ route('widen-homestay') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="homestay_id" class="form-label">บ้านพัก *</label>
                    <select class="form-select" id="homestay_id" name="homestay_id" required>
                        <option selected hidden>เลือกบ้านพัก</option>
                        @foreach ($homestays as $homestay)
                            <option value="{{ $homestay->id }}">{{ $homestay->homestay_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="appliance_id" class="form-label">ของใช้ *</label>
                        <select class="form-select" id="appliance_id" name="appliance_id" required>
                            <option selected hidden>เลือกของใช้</option>
                            @foreach ($appliances as $appliance)
                                <option value="{{ $appliance->id }}">{{ $appliance->appliance_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="stockAmount" min=0 class="form-label">คงเหลือ *</label>
                        <input type="number" class="form-control" min="1" id="stockAmount" name="stockAmount"
                            readonly>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="amount" min=0 class="form-label">จำนวน *</label>
                    <input type="number" class="form-control" min="1" id="amount" name="amount" required>
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
                        <label class="labels">เลือกบ้านพัก</label>
                        <select class="form-select" id="homestay_name" name="homestay_name" required>
                            <option selected hidden>เลือกบ้านพัก</option>
                            @foreach ($homestays as $homestay)
                                <option value="{{ $homestay->id }}">{{ $homestay->homestay_name }}</option>
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
                        <th style="width: 10%">ลำดับ</th>
                        <th style="width: 20%">ชื่อของใช้ในคลัง</th>
                        <th style="width: 5%">จำนวน</th>
                        <th style="width: 10%">ชื่อบ้านพัก</th>
                        <th style="width: 10%">สถานะ</th>
                        <th style="width: 25%">แก้ไข</th>
                        <th style="width: 10%">คืนของใช้</th>
                    </tr>
                </thead>
            </table>
        </div>
        <div class="table100-body js-pscroll">
            <table>
                <tbody>
                    @foreach ($homestay_details as $homestay_detail)
                        <tr>
                            <td style="width: 10%">{{ $loop->iteration }}</td>
                            <td style="width: 20%">{{ $homestay_detail->appliance->appliance_name }}</td>
                            <td style="width: 5%">{{ $homestay_detail->amount }}</td>
                            <td style="width: 10%">{{ $homestay_detail->homestay->homestay_name }}</td>
                            <td style="width: 10%">
                                @if ($homestay_detail->status == 2)
                                    <span class="badge bg-success">คืนของเข้าคลัง</span>
                                @elseif ($homestay_detail->status == 1)
                                    <span class="badge bg-warning text-dark">เบิก</span>
                                @endif
                            </td>
                            <td style="width: 25%"><button class="btn btn-primary"
                                    onclick="showModelEditHomedetail({{ $homestay_detail }})">รายละเอียด/แก้ไข</button>
                            </td>
                            <td style="width: 10%">
                                <form action="{{ route('drawฺ-back-homestay-detail', ['id' => $homestay_detail->id]) }}"
                                    method="POST" id="drawฺBack-homestaydetail{{ $homestay_detail->id }}"
                                    class="m-0">
                                    @csrf
                                </form>
                                @if ($homestay_detail->status == 2)
                                    <button type="button" class="btn btn-danger"
                                        onclick="showModelDrawฺBackHomedetail({{ $homestay_detail->id }})" disabled>
                                        คืนของใช้
                                    </button>
                                @elseif ($homestay_detail->status == 1)
                                    <button type="button" class="btn btn-danger"
                                        onclick="showModelDrawฺBackHomedetail({{ $homestay_detail->id }})">
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
