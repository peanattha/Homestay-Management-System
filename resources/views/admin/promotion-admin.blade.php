@extends('layouts.admin')

@section('title', 'Promotion')

<link rel="stylesheet" href="{{ asset('css/table.css') }}">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

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
        $('#modal-search-none').modal('hide');
    }
</script>
@if (Session::has('error'))
    <script>
        $(window).on('load', function() {
            $('#modal-search-none').modal('show');
        });
    </script>
@endif

<style>
    .aa {
        width: 150px;
    }

    .info {
        display: flex;
        flex-direction: row;
        justify-content: flex-end;
    }
</style>
@section('content')
    <h3>โปรโมชั่น</h3>
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
    {{-- Model search none --}}
    <div class="modal fade" id="modal-search-none" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">แจ้งเตือน</h5>
                </div>
                <div class="modal-body" id="textModelSearchNone">ไม่มีรายการตรงกับที่คุณค้นหา</div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" onclick="closeModel()">ยืนยัน</button>
                </div>
            </div>
        </div>
    </div>
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
        <input type="submit" class="btn btn-success" value="ค้นหาโปรโมชั่น">
    </form>
    <div class="info">
        <div></div>
        <form action="{{ route('promotion-filter') }}" method="POST" class="filter">
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
                            <option value="2">ปรับปรุง</option>
                            <option value="3">ยกเลิกใช้งาน</option>
                        @elseif ($status == 2)
                            <option value="1">ใช้งาน</option>
                            <option selected hidden value="2">ปรับปรุง</option>
                            <option value="3">ยกเลิกใช้งาน</option>
                        @elseif ($status == 3)
                            <option value="1">ใช้งาน</option>
                            <option value="2">ปรับปรุง</option>
                            <option selected hidden value="3">ยกเลิกใช้งาน</option>
                        @endif
                    @else
                        <option selected hidden>สถานะการใช้งาน</option>
                        <option value="1">ใช้งาน</option>
                        <option value="2">ปรับปรุง</option>
                        <option value="3">ยกเลิกใช้งาน</option>
                    @endif
                </select>
            </div>
        </form>
    </div>
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
                            <td style="width: 25%"><a class="link-primary"
                                    href="{{ route('promotion-detail', ['id' => $promotion->id]) }}">รายละเอียด / แก้ไข</a>
                            </td>
                            <td style="width: 10%">
                                <form action="{{ route('delete-promotion', ['id' => $promotion->id]) }}" method="POST"
                                    id="del-promo{{ $promotion->id }}" class="m-0">
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
