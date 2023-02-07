@extends('layouts.admin')

@section('title', 'Manage Promotion')

<link rel="stylesheet" href="{{ asset('css/table.css') }}">

<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>

<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>

<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<script>
    function showModelDelPromo(id, name) {
        window.id_promo = id;
        document.getElementById("textModelDelPromo").innerHTML =
            "คุณเเน่ใจที่จะลบ " + name;
        $("#modal-del-promo").modal("show");
    }

    function confirmDelPromo() {
        document.getElementById("del-promo" + window.id_promo).submit();
    }

    window.onload = function() {
        const select_type = document.getElementById("select_type");
        document.getElementById("dis_per").style.display = "none";
        document.getElementById("dis_price").style.display = "block";

        document.getElementById("price").required = true;
        document.getElementById("percent").required = false;

        select_type.addEventListener('change', (event) => {
            let type = document.getElementById("select_type").value;
            if (type == 2) {
                document.getElementById("percent").required = true;
                document.getElementById("price").required = false;
                document.getElementById("dis_per").style.display = "block";
                document.getElementById("dis_price").style.display = "none";
            } else {
                document.getElementById("price").required = true;
                document.getElementById("percent").required = false;
                document.getElementById("dis_per").style.display = "none";
                document.getElementById("dis_price").style.display = "block";
            }
        });
    };
</script>

{{-- <style>
    .aa {
        width: 150px;
    }

    .info {
        display: flex;
        flex-direction: row;
        justify-content: flex-end;
    }
</style> --}}

@section('page-name')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item active">จัดการโปรโมชั่น</li>
        </ol>
    </nav>
@endsection

@section('content')
    {{-- Model Delete Promotion --}}
    <div class="modal fade" id="modal-del-promo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">แจ้งเตือน</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="textModelDelPromo"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" onclick="confirmDelPromo()">ยืนยัน</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                </div>
            </div>
        </div>
    </div>

    <div class="card rounded-3 border border-1 shadow-lg">
        <div class="card-header">
            เพิ่ม / ลบ / แก้ใข โปรโมชั่น
        </div>
        <div class="card-body">
            <form action="{{ route('add-promotion') }}" method="POST">
                @csrf
                <select class="form-select mb-3" id="select_type" name="select_type">
                    <option selected value="1">ส่วนลดราคา (บาท)</option>
                    <option value="2">ส่วนลดเปอร์เซ็นต์</option>
                </select>
                <div class="mb-3">
                    <label for="promotion_name" class="form-label">ชื่อโปรโมชั่น *</label>
                    <input type="text" class="form-control" id="promotion_name" name="promotion_name" required>
                </div>
                <div class="mb-3" id="dis_price">
                    <label for="price" class="form-label">ราคาส่วนลด (บาท) *</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="price" name="price">
                        <span class="input-group-text">บาท</span>
                    </div>
                </div>
                <div class="mb-3" id="dis_per">
                    <label for="percent" class="form-label">ราคาส่วนลด (เปอร์เซ็นต์) *</label>
                    <div class="input-group">
                        <input type="number" min="1" class="form-control" id="percent" name="percent">
                        <span class="input-group-text">เปอร์เซ็นต์ (%)</span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="datetimes" class="form-label">ช่วงวันโปรโมชั่น *</label>
                    @if (isset($datetimes))
                        <?php
                        $dateArr = explode(' - ', $datetimes);
                        $start_date = date('d-m-Y', strtotime($dateArr[0]));
                        $end_date = date('d-m-Y', strtotime($dateArr[1]));
                        $valueDate = $start_date . ' - ' . $end_date;
                        ?>
                    @else
                        <?php
                        $currentDate = date('d-m-Y');
                        $d = date('d-m-Y', strtotime($currentDate . ' +1 days'));
                        $valueDate = $currentDate . ' - ' . $d;
                        ?>
                    @endif
                    <input type="text" name="datetimes" value="{{ $valueDate }}" class="form-control" required />
                    <script>
                        $(function() {
                            var today = new Date();
                            var date = (today.getDate()) + '-' + (today.getMonth() + 1) + '-' + today.getFullYear()
                            $('input[name="datetimes"]').daterangepicker({
                                timePicker: true,
                                opens: 'left',
                                minDate: date,
                                startDate: moment().startOf('hour'),
                                endDate: moment().startOf('hour').add(32, 'hour'),
                                locale: {
                                    format: 'DD-MM-YYYY hh:mm A'
                                }
                            });
                        });
                    </script>
                </div>
                <div class="mb-3">
                    <label for="promotion_detail" class="form-label">รายละเอียด *</label>
                    <textarea class="form-control" id="promotion_detail" name="promotion_detail" rows="3" required></textarea>
                </div>
                <input type="submit" class="btn btn-success" value="เพิ่มโปรโมชั่น">
            </form>
        </div>
    </div>

    <hr class="mb-4 mt-4">

    <div class="card rounded-3 border border-1 shadow-lg">
        <div class="card-header">
            รายการโปรโมชั่น
        </div>
        <div class="card-body">
            <form action="{{ route('search-promotion') }}" method="POST">
                @csrf
                <div class="mb-3">
                    @if (empty($promotion_name))
                        <input type="text" class="form-control" id="promotion_name" name="promotion_name"
                            placeholder="ชื่อโปรโมชั่น" required>
                    @else
                        <input type="text" class="form-control" id="promotion_name" name="promotion_name"
                            placeholder="ชื่อโปรโมชั่น" value="{{ $promotion_name }}" required>
                    @endif
                    <div id="help" class="form-text">กรอกชื่อโปรโมชั่นเพื่อทำการค้นหาโปรโมชั่น</div>
                </div>
                <button type="submit" class="btn btn-success">
                    <i class='bx bx-search'></i>
                    ค้นหา
                </button>
            </form>
        </div>
    </div>

    {{-- <div class="info mt-4">
        <div></div>
        <form action="{{ route('promotion-filter') }}" method="POST" class="filter m-0">
            @csrf
            <div class="aa">
                @if (!empty($promotion_name))
                    <input type="text" class="form-control" id="promotion_name" name="promotion_name"
                        placeholder="ชื่อโปรโมชั่น" value="{{ $promotion_name }}" required style="display: none;">
                @endif
                <select class="form-select" id="status" name="status" onchange="this.form.submit()">
                    @if (!empty($status))
                        @if ($status == 1)
                            <option selected hidden value="1">ใช้งาน</option>
                            <option value="2">ยกเลิกใช้งาน</option>
                        @elseif ($status == 2)
                            <option value="1">ใช้งาน</option>
                            <option selected hidden value="2">ยกเลิกใช้งาน</option>
                        @endif
                    @else
                        <option selected hidden>สถานะการใช้งาน</option>
                        <option value="1">ใช้งาน</option>
                        <option value="2">ยกเลิกใช้งาน</option>
                    @endif
                </select>
            </div>
        </form>
    </div> --}}

    <div class="table100 ver2 mb-4 mt-4">
        <div class="table100-head">
            <table>
                <thead>
                    <tr>
                        <th style="width: 10%">ลำดับ</th>
                        <th style="width: 10%">ชื่อโปรโมชั่น</th>
                        <th style="width: 25%">ระยะเวลา</th>
                        <th style="width: 10%">สถานะ</th>
                        <th style="width: 25%">รายละเอียด / แก้ไข</th>
                        <th style="width: 10%">ลบโปรโมชั่น</th>
                    </tr>
                </thead>
            </table>
        </div>
        <div class="table100-body js-pscroll">
            <table>
                <tbody>
                    @foreach ($promotions as $promotion)
                        <tr>
                            <td style="width: 10%">{{ $loop->iteration }}</td>
                            <td style="width: 10%">{{ $promotion->promotion_name }}</td>
                            <?php
                            $start_date = date('d-m-Y', strtotime($promotion->start_date));
                            $end_date = date('d-m-Y', strtotime($promotion->end_date));
                            ?>
                            <td style="width: 25%">{{ $start_date }} - {{ $end_date }}</td>
                            <td style="width: 10%">
                                @if ($promotion->status == 1)
                                    <span class="badge bg-success">ใช้งาน</span>
                                @elseif($promotion->status == 2)
                                    <span class="badge bg-danger">ยกเลิกใช้งาน</span>
                                @elseif($promotion->status == 3)
                                    <span class="badge bg-warning text-dark">รอเปิดใช้งาน</span>
                                @endif
                            </td>
                            <td style="width: 25%"><a class="btn btn-primary"
                                    href="{{ route('promotion-detail', ['id' => $promotion->id]) }}">รายละเอียด /
                                    แก้ไข</a>
                            </td>
                            <td style="width: 10%">
                                <form action="{{ route('delete-promotion', ['id' => $promotion->id]) }}" method="POST"
                                    id="del-promo{{ $promotion->id }}">
                                    @csrf
                                </form>
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#modal-del-promo"
                                    onclick="showModelDelPromo({{ $promotion->id }},'{{ $promotion->promotion_name }}')">
                                    ลบโปรโมชั่น
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
