@extends('layouts.admin')

@section('title', 'Manage Customer')

<link rel="stylesheet" href="{{ asset('css/table.css') }}">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
@if (Session::has('error'))
    <script>
        $(window).on('load', function() {
            $('#modal-search-none').modal('show');
        });
    </script>
@endif

<script>
    function closeModel() {
        $('#modal-search-none').modal('hide');
    }
</script>
@section('content')
    <h3>จัดการลูกค้า</h3>
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
    <form action="{{ route('search-customer') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label class="form-label">ค้นหาลูกค้า</label>
            <div class="d-flex flex-row">
                <input type="text" class="form-control" style="margin-right: 10px" id="firstName" name="firstName"
                    placeholder="ชื่อลูกค้า*" required>
                <input type="text" class="form-control" style="margin-left: 10px" id="lastName" name="lastName"
                    placeholder="นามสกุลลูกค้า*" required>
            </div>
            <div id="help" class="form-text">กรอกชื่อลูกค้าเพื่อทำการค้นหา</div>
        </div>
        <input type="submit" class="btn btn-success" value="ค้นหาลูกค้า">
    </form>
    <div class="table100 ver2 mb-4 mt-4">
        <div class="table100-head">
            <table>
                <thead>
                    <tr>
                        <th style="width: 5%">ลำดับ</th>
                        <th style="width: 20%">ชื่อ-นามสกุล</th>
                        <th style="width: 10%">บทบาท</th>
                        <th style="width: 10%">เบอร์โทรศัพท์</th>
                        <th style="width: 15%">รายละเอียดเพิ่มเติม</th>
                    </tr>
                </thead>
            </table>
        </div>
        <div class="table100-body js-pscroll">
            <table>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td style="width: 5%">{{ $loop->iteration }}</td>
                            <td style="width: 20%">{{ $user->firstName }} {{ $user->lastName }}</td>
                            @if ($user->role == 1)
                                <td style="width: 10%">ผู้ใช้งาน</td>
                            @elseif ($user->role == 2)
                                <td style="width: 10%">พนักงาน/ผู้ดูเเลระบบ</td>
                            @endif

                            @if ($user->tel == '')
                                <td style="width: 10%">-</td>
                            @else
                                <td style="width: 10%">{{ $user->tel }}</td>
                            @endif
                            <td style="width: 15%"><a href="{{ route('customer-detail', $user->id) }}"
                                    class="link-primary">รายละเอียด</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
