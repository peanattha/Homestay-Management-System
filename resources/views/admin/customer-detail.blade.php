@extends('layouts.admin')

@section('title', 'Profile')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<link rel="stylesheet" href="{{ asset('css/table.css') }}">

@section('content')
    {{-- Alert Message --}}
    @if (Session::has('message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ Session::get('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (Session::has('warning'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            {{ Session::get('warning') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <h3>รายละเอียดลูกค้า</h3>
    <div class="container bg-white rounded-3 border border-1 shadow-lg">
        <div class="d-flex justify-content-around">
            <div class="col-md-3 border-right">
                <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                    @if ($user->image == '')
                        <?php
                        $name = 'https://ui-avatars.com/api/?size=512&name=' . Auth::user()->firstName . '+' . Auth::user()->lastName;
                        ?>
                        <img class="mt-5" width="150px" height="150px" style="border-radius: 32px;"
                            src="{{ $name }}">
                    @else
                        <img class="mt-5" width="150px" height="150px" style="border-radius: 32px;"
                            src="{{ asset('storage/images/' . $user->image) }}">
                    @endif
                    <span class="font-weight-bold">{{ $user->firstName }} {{ $user->lastName }}</span>
                    <span class="text-black-50">{{ $user->email }}</span>
                </div>
            </div>
            <div class="col-md-5">
                <div class="p-3 py-5">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="text-right">โปรไฟล์</h4>
                    </div>
                    <form action="{{ route('edit-profile', ['id' => $user->id]) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row mt-2">
                            <div class="col-md-6">
                                <label class="labels">ชื่อ *</label>
                                <input type="text" name="firstName" class="form-control" value="{{ $user->firstName }}">
                            </div>
                            <div class="col-md-6">
                                <label class="labels">นามสกุล *</label>
                                <input type="text" name="lastName" class="form-control" value="{{ $user->lastName }}">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12 mb-2">
                                <label class="labels">อีเมล *</label>
                                <input type="email" name="email" class="form-control" value="{{ $user->email }}">
                            </div>
                            <div class="col-md-12 mb-2">
                                <label class="labels">เบอร์โทรศัพทร์</label>
                                <input type="text" name="tel" class="form-control" placeholder="099-XXX-XXXX"
                                    pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" value="{{ $user->tel }}">
                            </div>

                            <div class="col-md-12">
                                <label class="labels">เพศ</label>
                                <select class="form-select" name="gender">
                                    @if (Auth::user()->gender == null)
                                        <option selected hidden value="">เพศ</option>
                                        <option value="M">ชาย</option>
                                        <option value="F">หญิง</option>
                                        <option value="O">ไม่ต้องการระบุ</option>
                                    @elseif (Auth::user()->gender == 'M')
                                        <option selected hidden value="M">ชาย</option>
                                        <option value="F">หญิง</option>
                                        <option value="O">ไม่ต้องการระบุ</option>
                                    @elseif (Auth::user()->gender == 'F')
                                        <option selected hidden value="F">หญิง</option>
                                        <option value="M">ชาย</option>
                                        <option value="O">ไม่ต้องการระบุ</option>
                                    @else
                                        <option selected hidden value="o">ไม่ต้องการระบุ</option>
                                        <option value="M">ชาย</option>
                                        <option value="F">หญิง</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="mt-3">
                            <label for="img_profile" class="form-label">รูปโปรไฟล์</label>
                            <input class="form-control" type="file" id="img_profile" name="img_profile">
                        </div>
                        <div class="mt-5 text-center">
                            <button class="btn btn-success" type="submit">แก้ใขโปรไฟล์ลูกค้า</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <hr class="mt-4 mb-4">
    <h3 class="mt-4">รายการจองของลูกค้า</h3>
    <div class="table100 ver2 mb-4 mt-4">
        <div class="table100-head">
            <table>
                <thead>
                    <tr>
                        <th style="width: 5%">ลำดับ</th>
                        <th style="width: 20%">ชื่อผู้จอง</th>
                        <th style="width: 10%">ชื่อที่พัก</th>
                        <th style="width: 10%">จำนวนผู้เข้าพัก</th>
                        {{-- <th style="width: 15%"></th> --}}
                        <th style="width: 20%">สถานะการจอง</th>
                        <th style="width: 15%">รายละเอียดเพิ่มเติม</th>
                    </tr>
                </thead>
            </table>
        </div>
        <div class="table100-body js-pscroll">
            <table>
                <tbody>
                    @foreach ($bookings as $booking)
                        <tr>
                            <td style="width: 5%">{{ $loop->iteration }}</td>
                            <td style="width: 20%">{{ $booking->user->firstName }} {{ $booking->user->lastName }}</td>
                            <td style="width: 10%">
                                @foreach ($booking->booking_details as $booking_detail)
                                    {{ $booking_detail->homestay->homestay_name }}
                                @endforeach
                            </td>
                            <td style="width: 10%">{{ $booking->number_guests }}</td>

                            {{-- <td style="width: 15%"></td> --}}

                            @if ($booking->status == 1)
                                <td style="width: 20%">Checkin</td>
                            @elseif ($booking->status == 2)
                                <td style="width: 20%">Check Out</td>
                            @elseif ($booking->status == 3)
                                <td style="width: 20%">รอ Check In</td>
                            @elseif ($booking->status == 4)
                                <td style="width: 20%">ยกเลิกการจอง</td>
                            @elseif ($booking->status == 5)
                                <td style="width: 20%">รอชำระเงิน</td>
                            @elseif ($booking->status == 6)
                                <td style="width: 20%">รอยืนยันการชำระเงิน</td>
                            @elseif ($booking->status == 7)
                                <td style="width: 20%">รอยืนยันยกเลิกการจอง</td>
                            @endif
                            <td style="width: 15%"><a href="{{ route('booking-detail', $booking->id) }}"
                                    class="link-primary">รายละเอียด</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
