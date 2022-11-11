@extends('layouts.admin')

@section('title', 'Promotion')

<link rel="stylesheet" href="{{ asset('css/table.css') }}">

@section('content')
    <h3>โปรโมชั่น</h3>
    <form action="#" method="POST">
        @csrf
        <div class="mb-3">
            <label for="set_menu_id" class="form-label">ค้นหาโปรโมชั่น</label>
            <input type="text" class="form-control" id="set_menu_id" name="set_menu_id" placeholder="รหัสโปรโมชั่น">
            <div id="help" class="form-text">กรอกรหัสโปรโมชั่นเพื่อทำการค้นหาโปรโมชั่น</div>
        </div>
        <div class="mb-3">
            <input type="text" class="form-control" id="set_menu_name" name="set_menu_name"
                placeholder="ชื่อโปรโมชั่น">
            <div id="help" class="form-text">กรอกชื่อโปรโมชั่นเพื่อทำการค้นหาโปรโมชั่น</div>
        </div>
        <input type="submit" class="btn btn-success" value="ค้นหาโปรโมชั่น">
    </form>
    <div class="table100 ver2 mb-4">
        <div class="table100-head">
            <table>
                <thead>
                    <tr>
                        <th style="width: 10%">ลำดับ</th>
                        <th style="width: 25%">ชื่อโปรโมชั่น</th>
                        <th style="width: 10%">ระยะเวลา</th>
                        <th style="width: 25%">รายละเอียด / แก้ไข</th>
                        <th style="width: 10%">ลบโปรโมชั่น</th>
                    </tr>
                </thead>
            </table>
        </div>
        <div class="table100-body js-pscroll">
            <table>
                <tbody>

                    <tr>
                        <td style="width: 10%">1</td>
                        <td style="width: 25%">โปรโมชั่นหน้าหนาว</td>

                        <td style="width: 10%">1/11/2022 - 1/01/2023</td>

                        <td style="width: 25%"><a class="link-primary" href="">รายละเอียด /
                                แก้ไข</a>
                        </td>
                        <td style="width: 10%">
                            <form action="" method="POST" id="" class="m-0">
                                @csrf
                                <a onclick="" class="m-0 link-danger">ลบโปรโมชั่น</a>
                            </form>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>
@endsection
