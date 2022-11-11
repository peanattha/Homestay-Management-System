@extends('layouts.admin')

@section('title', 'Manage Promotion')

<link rel="stylesheet" href="{{ asset('css/table.css') }}">
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

@section('content')
    <div>
        <h3>จัดการโปรโมชั่น > แก้ใข โปรโมชั่น</h3>
        <form action="#" method="POST">
            @csrf
            <div class="mb-3">
                <label for="set_menu_name" class="form-label">ชื่อโปรโมชั่น *</label>
                <input type="text" class="form-control" id="set_menu_name" name="set_menu_name" required>
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
                <label for="details" class="form-label">รายละเอียด *</label>
                <textarea class="form-control" id="details" name="details" rows="3" required></textarea>
            </div>
            <input type="submit" class="btn btn-success" value="แก้ใขโปรโมชั่น">
        </form>
    @endsection
