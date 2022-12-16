<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script src="{{ asset('js/app.js') }}" defer></script>

    <script src="{{ asset('js/goToTop.js') }}" defer></script>

    <script src="{{ asset('js/admin-sidebar.js') }}" defer></script>

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">

    <title>@yield('title') - {{ config('app.name') }}</title>

    {{-- <link rel="icon" type="image/svg" href="{{ asset('images/Logo.svg') }}" /> --}}

    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
    <div class="sidebar" id="sidebar">
        <div class="logo-details">
            <div class="logo_name">{{ config('app.name') }}</div>
        </div>
        <ul class="nav-links">
            <li>
                <a href="{{ route('admin-dashboard') }}">
                    <i class='bx bx-pie-chart-alt-2'></i>
                    <span class="link_name">เเดชบอร์ด</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="{{ route('admin-dashboard') }}">เเดชบอร์ด</a></li>
                </ul>
            </li>
            <li>
                <div class="iocn-link">
                    <a href="{{ route('booking-admin') }}">
                        <i class='bx bx-collection'></i>
                        <span class="link_name">
                            รายการจอง
                            @if (Session::get('noti')['cBookings'] != 0)
                                <span class="ms-2 top-50 translate-middle badge rounded-pill bg-danger">
                                    {{ Session::get('noti')['cBookings'] }}
                                    <span class="visually-hidden">unread messages</span>
                                </span>
                            @endif
                        </span>
                    </a>
                    <i class='bx bxs-chevron-down arrow'></i>
                </div>
                <ul class="sub-menu">
                    <li><a class="link_name" href="{{ route('booking-admin') }}">รายการจอง</a></li>
                    <li><a href="{{ route('booking-admin') }}">รายการจองทั้งหมด</a></li>
                    <li><a href="#">เพิ่มรายการจอง</a></li>
                    <li>
                        <a href="{{ route('check-in-admin') }}">
                            Check In
                            @if (Session::get('noti')['cCheckIn'] != 0)
                                <span class="ms-2 top-50 translate-middle badge rounded-pill bg-danger">
                                    {{ Session::get('noti')['cCheckIn'] }}
                                    <span class="visually-hidden">unread messages</span>
                                </span>
                            @endif
                        </a>
                    </li>
                    <li><a href="{{ route('check-out-admin') }}">
                            Check Out
                            @if (Session::get('noti')['cCheckOut'] != 0)
                                <span class="ms-2 top-50 translate-middle badge rounded-pill bg-danger">
                                    {{ Session::get('noti')['cCheckOut'] }}
                                    <span class="visually-hidden">unread messages</span>
                                </span>
                            @endif
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('confirm-booking') }}">
                            ยืนยันการจอง
                            @if (Session::get('noti')['cWaitConfirm'] != 0)
                                <span class="ms-2 top-50 translate-middle badge rounded-pill bg-danger">
                                    {{ Session::get('noti')['cWaitConfirm'] }}
                                    <span class="visually-hidden">unread messages</span>
                                </span>
                            @endif
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('confirm-cancel-booking') }}">
                            ยืนยันการยกเลิกการจอง
                            @if (Session::get('noti')['cWaitcancel'] != 0)
                                <span class="ms-2 top-50 translate-middle badge rounded-pill bg-danger">
                                    {{ Session::get('noti')['cWaitcancel'] }}
                                    <span class="visually-hidden">unread messages</span>
                                </span>
                            @endif
                        </a>
                    </li>
                </ul>
            </li>

            <li>
                <div class="iocn-link">
                    <a href="{{ route('homestay-admin') }}">
                        <i class='bx bx-collection'></i>
                        <span class="link_name">รายการที่พัก</span>
                    </a>
                    <i class='bx bxs-chevron-down arrow'></i>
                </div>
                <ul class="sub-menu">
                    <li><a class="link_name" href="{{ route('homestay-admin') }}">รายการที่พัก</a></li>
                    <li><a href="{{ route('homestay-admin') }}">รายการที่พัก</a></li>
                    <li><a href="{{ route('manage-homestay-type') }}">เพิ่ม/ลบ/แก้ ประเภทที่พัก</a></li>
                    <li><a href="{{ route('manage-homestay') }}">เพิ่ม/ลบ/แก้ ที่พัก</a></li>
                </ul>
            </li>
            <li>
                <a href="{{ route('manage-menu') }}">
                    <i class='bx bx-collection'></i>
                    <span class="link_name">จัดการชุดเมนูอาหาร</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="{{ route('manage-menu') }}">จัดการชุดเมนูอาหาร</a></li>
                </ul>
            </li>
            <li>
                <a href="{{ route('manage-customer') }}">
                    <i class='bx bx-collection'></i>
                    <span class="link_name">จัดการลูกค้า</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="{{ route('manage-customer') }}">จัดการลูกค้า</a></li>
                </ul>
            </li>
            <li>
                <a href="{{ route('manage-admin') }}">
                    <i class='bx bx-collection'></i>
                    <span class="link_name">ผู้ดูเเลระบบ</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="{{ route('manage-admin') }}">ผู้ดูเเลระบบ</a></li>
                </ul>
            </li>
            <li>
                <a href="{{ route('manage-bank') }}">
                    <i class='bx bx-collection'></i>
                    <span class="link_name">วิธีการชำระเงิน</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="{{ route('manage-bank') }}">วิธีการชำระเงิน</a></li>
                </ul>
            </li>
            <li>
                <a href="{{ route('manage-promotion') }}">
                    <i class='bx bx-collection'></i>
                    <span class="link_name">จัดการโปรโมชั่น</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="{{ route('manage-promotion') }}">จัดการโปรโมชั่น</a></li>
                </ul>
            </li>
            <li>
                <div class="iocn-link">
                    <a href="{{ route('manage-appliance') }}">
                        <i class='bx bx-collection'></i>
                        <span class="link_name">ของในคลัง</span>
                    </a>
                    <i class='bx bxs-chevron-down arrow'></i>
                </div>
                <ul class="sub-menu">
                    <li><a class="link_name" href="{{ route('manage-appliance') }}">ของในคลัง</a></li>
                    <li><a href="{{ route('manage-appliance-booking') }}">เบิก/คืน ของจากการจอง</a></li>
                    <li><a href="{{ route('manage-appliance-homestay') }}">เบิก/คืน ของเข้าบ้านพัก</a></li>
                    <li><a href="{{ route('manage-appliance') }}">เพิ่ม/ลบ/เเก้ใข ของในคลัง</a></li>
                </ul>
            </li>
            <li>
                <div class="iocn-link">
                    <a href="{{ route('review-admin') }}">
                        <i class='bx bx-collection'></i>
                        <span class="link_name">การรีวิวบ้านพัก</span>
                    </a>
                    <i class='bx bxs-chevron-down arrow'></i>
                </div>
                <ul class="sub-menu">
                    <li><a class="link_name" href="{{ route('review-admin') }}">การรีวิวบ้านพัก</a></li>
                    <li><a href="{{ route('review-admin') }}">การรีวิวบ้านพัก</a></li>
                    <li>
                        <a href="{{ route('manage-review') }}">
                            ตอบกลับรีวิวบ้านพัก
                            @if (Session::get('noti')['cWaitReply'] != 0)
                                <span class="ms-2 top-50 translate-middle badge rounded-pill bg-danger">
                                    {{ Session::get('noti')['cWaitReply'] }}
                                    <span class="visually-hidden">unread messages</span>
                                </span>
                            @endif
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <div class="profile-details">
                    <div class="profile-content">
                        @if (Auth::user()->image == '')
                            <?php
                            $name = 'https://ui-avatars.com/api/?size=512&name=' . Auth::user()->firstName . '+' . Auth::user()->lastName;
                            ?>
                            <img src="{{ $name }}">
                        @else
                            <img src="{{ asset('storage/images/' . $user->image) }}">
                        @endif
                    </div>
                    <div class="name-job">
                        <a href="{{ route('profile-admin') }}">
                            <div class="profile_name">{{ Auth::user()->firstName }}
                                {{ Auth::user()->lastName }}</div>
                        </a>
                    </div>
                    <a href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class='bx bx-log-out'></i>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </li>
        </ul>
    </div>

    <section class=" home-section">
        <div class="home-content">
            <i class='bx bx-menu'></i>
            @section('page-name')

            @show
        </div>
        <div class="container">
            @section('content')

            @show
        </div>
    </section>

    <a href="#" id="toTopBtn" class="cd-top text-replace rounded-3 border border-1" data-abc="true"></a>

</body>

</html>
