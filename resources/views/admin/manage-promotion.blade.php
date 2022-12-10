@extends('layouts.admin')

@section('title', 'Manage Promotion')

<link rel="stylesheet" href="{{ asset('css/table.css') }}">
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />


<script>
    // Delete Promotion
    function showModelDelPromo(id, name) {
        window.id_promo = id;
        document.getElementById("textModelDelPromo").innerHTML =
            "คุณเเน่ใจที่จะลบ " + name;
        $("#modal-del-promo").modal("show");
    }

    function confirmDelPromo() {
        document.getElementById("del-promo" + window.id_promo).submit();
    }

    //Close Model
    function closeModel() {
        $("#modal-del-promo").modal("hide");
    }
</script>

@section('content')
    {{-- Model Delete Promotion --}}
    <div class="modal fade" id="modal-del-promo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">แจ้งเตือน</h5>
                </div>
                <div class="modal-body" id="textModelDelPromo"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" onclick="closeModel()">ยกเลิก</button>
                    <button type="button" class="btn btn-success" onclick="confirmDelPromo()">ยืนยัน</button>
                </div>
            </div>
        </div>
    </div>
    <div>
        <h3>จัดการโปรโมชั่น > เพิ่ม / ลบ / แก้ใข โปรโมชั่น</h3>
        <form action="{{ route('add-promotion') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="promotion_name" class="form-label">ชื่อโปรโมชั่น *</label>
                <input type="text" class="form-control" id="promotion_name" name="promotion_name" required>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">ราคาส่วนลด (บาท) *</label>
                <input type="text" class="form-control" id="price" name="price" required>
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
            {{-- <div class="mb-3">
                <label for="status" class="form-label">สถานะการใช้งาน *</label>
                <select class="form-select" id="status" name="status" required>
                    <option selected hidden>สถานะการใช้งาน</option>
                    <option value="1">ใช้งาน</option>
                    <option value="2">ปรับปรุง</option>
                    <option value="3">ยกเลิกใช้งาน</option>
                </select>
            </div> --}}
            <div class="mb-3">
                <label for="promotion_detail" class="form-label">รายละเอียด *</label>
                <textarea class="form-control" id="promotion_detail" name="promotion_detail" rows="3" required></textarea>
            </div>
            <input type="submit" class="btn btn-success" value="เพิ่มโปรโมชั่น">
        </form>
        <br>
        <div class="table100 ver2 mb-4">
            <div class="table100-head">
                <table>
                    <thead>
                        <tr>
                            <th style="width: 10%">ลำดับ</th>
                            <th style="width: 10%">ชื่อโปรโมชั่น</th>
                            <th style="width: 25%">ระยะเวลา</th>
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
                                <td style="width: 25%"><a class="link-primary" href="{{ route('promotion-detail', ['id' => $promotion->id]) }}">รายละเอียด / แก้ไข</a></td>
                                <td style="width: 10%">
                                    <form action="{{route('delete-promotion', ['id' => $promotion->id])}}" method="POST" id="del-promo{{ $promotion->id }}" class="m-0">
                                        @csrf
                                        <a onclick="showModelDelPromo({{ $promotion->id }},'{{ $promotion->promotion_name }}')"
                                            class="m-0 link-danger">ลบโปรโมชั่น</a>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endsection
