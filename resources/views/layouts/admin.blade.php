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

    <link rel="icon" type="image/svg" href="{{ asset('images/Logo.svg') }}" />

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
    <div class="sidebar" id="sidebar">
        <div class="logo-details">
            {{-- <img src="{{ asset('images/Logo.svg') }}" alt="Logo"> --}}
            <div class="logo_name mt-2">{{ config('app.name') }}</div>
            <button type="button" class="btn-close" id="btnClose"></button>
        </div>
        <hr class="m-2">
        <ul class="nav-links">
            <li>
                <a href="{{ route('admin-dashboard') }}">
                    <i class='bx bx-bar-chart-alt-2'></i>
                    <span class="link_name">เเดชบอร์ด</span>
                </a>
            </li>
            <li>
                <div class="iocn-link">
                    <a href="{{ route('booking-admin') }}">
                        @if (Session::get('noti')['cBookings'] != 0)
                            <i class='bx bx-collection bx-tada'></i>
                        @else
                            <i class='bx bx-collection'></i>
                        @endif

                        <span class="link_name">
                            รายการจอง
                        </span>
                    </a>
                    @if (Session::get('noti')['cBookings'] != 0)
                        <span class="badge bg-secondary">{{ Session::get('noti')['cBookings'] }}</span>
                    @endif
                    <i class='bx bxs-chevron-down arrow'></i>
                </div>
                <ul class="sub-menu">
                    <li><a href="{{ route('booking-admin') }}">รายการจองทั้งหมด</a></li>
                    <li><a href="{{route('add-booking-admin')}}">เพิ่มรายการจอง</a></li>
                    <li>
                        <a href="{{ route('check-in-admin') }}">
                            Check In
                        </a>
                        @if (Session::get('noti')['cCheckIn'] != 0)
                            <span class="badge bg-secondary">{{ Session::get('noti')['cCheckIn'] }}</span>
                        @endif
                    </li>
                    <li><a href="{{ route('check-out-admin') }}">
                            Check Out
                        </a>
                        @if (Session::get('noti')['cCheckOut'] != 0)
                            <span class="badge bg-secondary">{{ Session::get('noti')['cCheckOut'] }}</span>
                        @endif
                    </li>
                    <li>
                        <a href="{{ route('confirm-booking') }}">
                            ยืนยันการจอง
                        </a>
                        @if (Session::get('noti')['cWaitConfirm'] != 0)
                            <span class="badge bg-secondary">{{ Session::get('noti')['cWaitConfirm'] }}</span>
                        @endif
                    </li>
                    <li>
                        <a href="{{ route('confirm-cancel-booking') }}">
                            ยืนยันการยกเลิกการจอง
                        </a>
                        @if (Session::get('noti')['cWaitcancel'] != 0)
                            <span class="badge bg-secondary">{{ Session::get('noti')['cWaitcancel'] }}</span>
                        @endif
                    </li>
                </ul>
            </li>

            <li>
                <div class="iocn-link">
                    <a href="{{ route('homestay-admin') }}">
                        <i class='bx bx-home'></i>
                        <span class="link_name">รายการที่พัก</span>
                    </a>
                    <i class='bx bxs-chevron-down arrow'></i>
                </div>
                <ul class="sub-menu">
                    <li><a href="{{ route('homestay-admin') }}">รายการที่พัก</a></li>
                    <li><a href="{{ route('manage-homestay-type') }}">เพิ่ม/ลบ/แก้ใข ประเภทที่พัก</a></li>
                    <li><a href="{{ route('manage-homestay') }}">เพิ่ม/ลบ/แก้ใข ที่พัก</a></li>
                </ul>
            </li>
            <li>
                <a href="{{ route('manage-customer') }}">
                    <i class='bx bx-user'></i>
                    <span class="link_name">จัดการลูกค้า</span>
                </a>
            </li>
            <li>
                <a href="{{ route('manage-admin') }}">
                    <i class='bx bx-user-circle'></i>
                    <span class="link_name">ผู้ดูเเลระบบ</span>
                </a>
            </li>
            <li>
                <div class="iocn-link">
                    <a href="{{ route('manage-bank') }}">
                        <i class='bx bx-money-withdraw'></i>
                        <span class="link_name">วิธีการชำระเงิน</span>
                    </a>
                    <i class='bx bxs-chevron-down arrow'></i>
                </div>
                <ul class="sub-menu">
                    <li><a href="{{ route('manage-bank') }}">วิธีการชำระเงิน</a></li>
                    <li><a href="{{ route('manage-bank-name') }}">เพิ่ม/ลบ/แก้ใข ชื่อธนาคาร</a></li>
                </ul>
            </li>
            <li>
                <a href="{{ route('manage-menu') }}">
                    <i class='bx bx-bowl-rice'></i>
                    <span class="link_name">จัดการชุดเมนูอาหาร</span>
                </a>
            </li>
            <li>
                <a href="{{ route('manage-promotion') }}">
                    <i class='bx bxs-discount'></i>
                    <span class="link_name">จัดการโปรโมชั่น</span>
                </a>
            </li>
            <li>
                <div class="iocn-link">
                    <a href="{{ route('manage-appliance') }}">
                        <i class='bx bx-store'></i>
                        <span class="link_name">ของในคลัง</span>
                    </a>
                    <i class='bx bxs-chevron-down arrow'></i>
                </div>
                <ul class="sub-menu">
                    <li><a href="{{ route('manage-appliance-booking') }}">เบิก/คืน ของจากการจอง</a></li>
                    <li><a href="{{ route('manage-appliance-homestay') }}">เบิก/คืน ของเข้าบ้านพัก</a></li>
                    <li><a href="{{ route('manage-appliance') }}">เพิ่ม/ลบ/เเก้ใข ของในคลัง</a></li>
                </ul>
            </li>
            <li>
                <div class="iocn-link">
                    <a href="{{ route('review-admin') }}">
                        @if (Session::get('noti')['cWaitReply'] != 0)
                            <i class='bx bx-message-rounded-dots bx-tada'></i>
                        @else
                            <i class='bx bx-message-rounded-dots'></i>
                        @endif

                        <span class="link_name">การรีวิวบ้านพัก</span>
                    </a>
                    <i class='bx bxs-chevron-down arrow'></i>
                </div>
                <ul class="sub-menu">
                    <li><a href="{{ route('review-admin') }}">การรีวิวบ้านพัก</a></li>
                    <li>
                        <a href="{{ route('manage-review') }}">
                            ตอบกลับรีวิวบ้านพัก
                        </a>
                        @if (Session::get('noti')['cWaitReply'] != 0)
                            <span class="badge bg-secondary">{{ Session::get('noti')['cWaitReply'] }}</span>
                        @endif
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
                            <img src="{{ asset('storage/images/' . Auth::user()->image) }}">
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

    <section class="home-section">
        <div class="home-content container">
            <i class='bx bx-menu ms-0 me-2'></i>
            @section('page-name')

            @show
        </div>
        <div class="container">
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
            @if (Session::has('danger'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ Session::get('danger') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @section('content')

            @show
        </div>
    </section>

    <a href="#" id="toTopBtn" class="cd-top text-replace rounded-3 border border-1" data-abc="true"></a>

</body>

</html>
