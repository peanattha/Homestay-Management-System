@extends('layouts.user')

@section('homestay', 'active')

@section('title', 'homestay')

<link rel="stylesheet" href="{{ asset('css/table.css') }}">

<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>

<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>

<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

@section('page-name')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">หน้าหลัก</a></li>
            <li class="breadcrumb-item active" aria-current="page">ค้นหาโฮมสเตย์</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="container">
        <div class="col-md-12 card rounded-3 border border-1 shadow-lg mb-4 mt-4">
            <div class="card-header">
                ค้นหาโฮมสเตย์
            </div>
            <div class="card-body">
                <form action="{{ route('search-homestay') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="dateRange" class="form-label">ช่วงวันที่เข้าพัก *</label>
                        @if (isset($dateRange))
                            <?php
                            $dateArr = explode(' - ', $dateRange);
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
                        <input type="text" name="dateRange" value="{{ $valueDate }}" class="form-control" required />
                        <script>
                            $(function() {
                                var today = new Date();
                                var date = (today.getDate()) + '-' + (today.getMonth() + 1) + '-' + today.getFullYear()
                                $('input[name="dateRange"]').daterangepicker({
                                    opens: 'left',
                                    minDate: date,
                                    locale: {
                                        format: 'DD-MM-YYYY'
                                    }
                                });
                            });
                        </script>
                    </div>
                    <button type="submit" class="btn btn-success"><i class='bx bx-search'></i> ค้นหา</button>
                </form>
            </div>
        </div>

        @if (isset($homestays))
            <div class="table100 ver2 mb-4 mt-4">
                <div class="table100-head">
                    <table>
                        <thead>
                            <tr>
                                <th style="width: 5%">ลำดับ</th>
                                <th style="width: 20%">ชื่อบ้านพัก</th>
                                <th style="width: 10%">จำนวนผู้เข้าพัก</th>
                                <th style="width: 20%">ดูรายละเอียดเพิ่มเติม</th>
                                <th style="width: 15%">เลือกบ้านพัก</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div class="table100-body js-pscroll">
                    <table>
                        <tbody>
                            <form action="#" method="POST">
                                @foreach ($homestays as $homestay)
                                    <tr>
                                        <td style="width: 5%">{{ $loop->iteration }}</td>
                                        <td style="width: 20%">{{ $homestay->homestay_name }}</td>
                                        <td style="width: 10%">{{ $homestay->number_guests }}</td>
                                        <td style="width: 20%"><a href="#" class="btn btn-primary">รายละเอียด</a></td>
                                        <td style="width: 15%">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="hId{{ $homestay->id }}" name="homestay_id[]">
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </form>
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>

@endsection
