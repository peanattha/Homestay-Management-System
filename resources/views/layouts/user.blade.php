<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script src="{{ asset('js/app.js') }}" defer></script>

    <script src="{{ asset('js/goToTop.js') }}" defer></script>

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <link href="{{ asset('css/home.css') }}" rel="stylesheet">

    <title>@yield('title') - {{ config('app.name') }}</title>

    <link rel="icon" type="image/svg" href="{{ asset('images/Logo.svg') }}" />

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">

</head>

<body>
    @if (Route::has('login'))
        @auth
            <!-- Header -->
            <header>
                <nav class="container navbar navbar-expand-lg navbar-light py-3">
                    <div class="container-fluid">
                        <!-- Logo -->
                        <a href="{{ route('home') }}" class="d-flex align-items-center text-dark text-decoration-none">
                            <span class="fs-4">{{ config('app.name') }}</span>
                        </a>
                        <!-- Logo -->
                        <!-- Responsive Hamburger Menu -->
                        <button type="button" class="navbar-toggler" data-bs-toggle="collapse"
                            data-bs-target="#navbarCollapse">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <!-- Responsive Hamburger Menu -->
                        <!-- Menu -->
                        <div class="collapse navbar-collapse" id="navbarCollapse">
                            <div class="navbar-nav ms-auto">
                                <a href="{{ route('home') }}" class="nav-item nav-link @yield('home')">หน้าหลัก</a>
                                <a href="{{ route('homestay') }}" class="nav-item nav-link @yield('homestay')">จอง</a>
                                <a href="{{ route('booking-history') }}" class="nav-item nav-link @yield('booking-history')">ประวัติการจอง</a></li>
                                <div class="nav-item dropdown">
                                    <a href="#" class="nav-link dropdown-toggle"
                                        data-bs-toggle="dropdown">{{ Auth::user()->firstName }}
                                        {{ Auth::user()->lastName }}</a>
                                    <div class="dropdown-menu">
                                        <a href="{{ route('profile') }}" class="dropdown-item">โปรไฟล์</a>
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">ออกจากระบบ</a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                            class="d-none">
                                            @csrf
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Menu -->
                    </div>
                </nav>
            </header>
            <!-- Header -->

            <!-- Section -->
            <section>
                @section('content')

                @show
            </section>
            <!-- Section -->

            <!-- Footer -->
            <footer class="text-center text-lg-start bg-white">
                <!-- Section: Social media -->
                <section class="d-flex justify-content-center justify-content-lg-between p-4 border-bottom">
                    <!-- Left -->
                    <div class="me-5 d-none d-lg-block">
                        <span>เชื่อมต่อกับเราบนโซเชียลเน็ตเวิร์ก:</span>
                    </div>
                    <!-- Left -->

                    <!-- Right -->
                    <div>
                        <a href="https://www.facebook.com/%E0%B9%82%E0%B8%AE%E0%B8%A1%E0%B8%AA%E0%B9%80%E0%B8%95%E0%B8%A2%E0%B9%8C%E0%B8%95%E0%B8%B2%E0%B8%81%E0%B8%B0%E0%B8%A2%E0%B8%B2%E0%B8%A2-%E0%B8%A0%E0%B8%B9%E0%B8%9C%E0%B8%B2%E0%B8%A1%E0%B9%88%E0%B8%B2%E0%B8%99-101218341803473"
                            target="_bank" class="me-4 text-reset text-decoration-none">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="" class="me-4 text-reset text-decoration-none">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="" class="me-4 text-reset text-decoration-none">
                            <i class="fab fa-instagram"></i>
                        </a>
                    </div>
                    <!-- Right -->
                </section>
                <!-- Section: Social media -->

                <!-- Section: Links  -->
                <section>
                    <div class="container text-center text-md-start mt-5">
                        <!-- Grid row -->
                        <div class="row mt-3">
                            <!-- Grid column -->
                            <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4">
                                <!-- Content -->
                                <h6 class="text-uppercase fw-bold mb-4">
                                    {{ config('app.name') }}
                                </h6>
                                <iframe
                                    src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d15289.377841669955!2d101.9024255!3d16.6596376!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x4391dac7bf891955!2z4LmC4Liu4Lih4Liq4LmA4LiV4Lii4LmM4LiV4Liy4LiB4Liw4Lii4Liy4LiiIOC4oOC4ueC4nOC4suC4oeC5iOC4suC4mQ!5e0!3m2!1sth!2sth!4v1657632801624!5m2!1sth!2sth"
                                    width="300" height="120" style="border:0;" allowfullscreen="" loading="lazy"
                                    referrerpolicy="no-referrer-when-downgrade"></iframe>
                            </div>
                            <!-- Grid column -->

                            <!-- Grid column -->
                            <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4">
                                <!-- Links -->
                                <h6 class="text-uppercase fw-bold mb-4">
                                    เมนู
                                </h6>
                                <p>
                                    <a href="{{ route('home') }}" class="text-reset text-decoration-none">หน้าหลัก</a>
                                </p>
                                <p>
                                    <a href="" class="text-reset text-decoration-none">เมนู</a>
                                </p>
                                <p>
                                    <a href="{{ route('homestay') }}" class="text-reset text-decoration-none">จอง</a>
                                </p>
                                <p>
                                    <a href="{{ route('booking-history') }}" class="text-reset text-decoration-none">ประวัติการจอง</a>
                                </p>
                            </div>
                            <!-- Grid column -->

                            <!-- Grid column -->
                            <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">
                                <!-- Links -->
                                <h6 class="text-uppercase fw-bold mb-4">
                                    รายละเอียดเพิ่มเติม
                                </h6>
                                <p>
                                    <a href="{{ route('description-details') }}" class="text-reset text-decoration-none">รายละเอียดเพิ่มเติม</a>
                                </p>
                                <p>
                                    <a href="{{ route('accommodation-rules') }}" class="text-reset text-decoration-none">กฏระเบียบที่พัก</a>
                                </p>
                                <p>
                                    <a href="{{ route('service-charge') }}" class="text-reset text-decoration-none">ค่าบริการ</a>
                                </p>
                            </div>
                            <!-- Grid column -->

                            <!-- Grid column -->
                            <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">
                                <!-- Links -->
                                <h6 class="text-uppercase fw-bold mb-4">
                                    ติดต่อ
                                </h6>
                                <p><i class="fas fa-home me-3"></i>{{ config('app.name') }}</p>
                                <p>
                                    <i class="fas fa-envelope me-3"></i>homestaytakayai@gmail.com
                                </p>
                                <p><i class="fas fa-phone me-3"></i>085 563 0322</p>
                                <p><i class="fas fa-print me-3"></i>085 563 0322</p>
                            </div>
                            <!-- Grid column -->
                        </div>
                        <!-- Grid row -->
                    </div>
                </section>
                <!-- Section: Links  -->

                <!-- Copyright -->
                <div class="text-center p-4 w-100" style="background-color: rgba(0, 0, 0, 0.05);">
                    © 2022
                    <a class="text-reset fw-bold" href="{{ route('home') }}">{{ config('app.name') }}</a>, Inc. All
                    rights
                    reserved.
                </div>
                <!-- Copyright -->
            </footer>
            <!-- Footer -->
        @else
            <!-- Header -->
            <header>
                <nav class="container navbar navbar-expand-lg navbar-light py-3">
                    <div class="container-fluid">
                        <!-- Logo -->
                        <a href="{{ route('home') }}" class="d-flex align-items-center text-dark text-decoration-none">
                            <span class="fs-4">{{ config('app.name') }}</span>
                        </a>
                        <!-- Logo -->
                        <!-- Responsive Hamburger Menu -->
                        <button type="button" class="navbar-toggler" data-bs-toggle="collapse"
                            data-bs-target="#navbarCollapse">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <!-- Responsive Hamburger Menu -->
                        <!-- Menu -->
                        <div class="collapse navbar-collapse" id="navbarCollapse">
                            <div class="navbar-nav ms-auto">
                                <a href="{{ route('home') }}" class="nav-item nav-link @yield('home')">หน้าหลัก</a>
                                <a href="{{ route('homestay') }}" class="nav-item nav-link @yield('booking')">จอง</a>
                                <a href="{{ route('login') }}"
                                    class="nav-item nav-link @yield('login')">เข้าสู่ระบบ</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}"
                                        class="nav-item nav-link @yield('reg')">สมัครสมาชิก</a>
                                @endif
                            </div>
                        </div>
                        <!-- Menu -->
                    </div>
                </nav>
            </header>
            <!-- Header -->

            <!-- Section -->
            <section>
                @section('content')

                @show
            </section>
            <!-- Section -->

            <!-- Footer -->
            <footer class="text-center text-lg-start bg-white">
                <!-- Section: Social media -->
                <section class="d-flex justify-content-center justify-content-lg-between p-4 border-bottom">
                    <!-- Left -->
                    <div class="me-5 d-none d-lg-block">
                        <span>เชื่อมต่อกับเราบนโซเชียลเน็ตเวิร์ก:</span>
                    </div>
                    <!-- Left -->

                    <!-- Right -->
                    <div>
                        <a href="https://www.facebook.com/%E0%B9%82%E0%B8%AE%E0%B8%A1%E0%B8%AA%E0%B9%80%E0%B8%95%E0%B8%A2%E0%B9%8C%E0%B8%95%E0%B8%B2%E0%B8%81%E0%B8%B0%E0%B8%A2%E0%B8%B2%E0%B8%A2-%E0%B8%A0%E0%B8%B9%E0%B8%9C%E0%B8%B2%E0%B8%A1%E0%B9%88%E0%B8%B2%E0%B8%99-101218341803473"
                            target="_bank" class="me-4 text-reset text-decoration-none">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="" class="me-4 text-reset text-decoration-none">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="" class="me-4 text-reset text-decoration-none">
                            <i class="fab fa-instagram"></i>
                        </a>
                    </div>
                    <!-- Right -->
                </section>
                <!-- Section: Social media -->

                <!-- Section: Links  -->
                <section>
                    <div class="container text-center text-md-start mt-5">
                        <!-- Grid row -->
                        <div class="row mt-3">
                            <!-- Grid column -->
                            <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4">
                                <!-- Content -->
                                <h6 class="text-uppercase fw-bold mb-4">
                                    {{ config('app.name') }}
                                </h6>
                                <iframe
                                    src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d15289.377841669955!2d101.9024255!3d16.6596376!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x4391dac7bf891955!2z4LmC4Liu4Lih4Liq4LmA4LiV4Lii4LmM4LiV4Liy4LiB4Liw4Lii4Liy4LiiIOC4oOC4ueC4nOC4suC4oeC5iOC4suC4mQ!5e0!3m2!1sth!2sth!4v1657632801624!5m2!1sth!2sth"
                                    width="160" height="120" style="border:0;" allowfullscreen="" loading="lazy"
                                    referrerpolicy="no-referrer-when-downgrade"></iframe>

                            </div>
                            <!-- Grid column -->

                            <!-- Grid column -->
                            <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4">
                                <!-- Links -->
                                <h6 class="text-uppercase fw-bold mb-4">
                                    เมนู
                                </h6>
                                <p>
                                    <a href="{{ route('home') }}" class="text-reset text-decoration-none">หน้าหลัก</a>
                                </p>
                                <p>
                                    <a href="" class="text-reset text-decoration-none">จอง</a>
                                </p>
                                <p>
                                    <a href="{{ route('login') }}"
                                        class="text-reset text-decoration-none">เข้าสู่ระบบ</a>
                                </p>
                                <p>
                                    <a href="{{ route('register') }}"
                                        class="text-reset text-decoration-none">สมัครสมาชิก</a>
                                </p>
                            </div>
                            <!-- Grid column -->

                            <!-- Grid column -->
                            <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">
                                <!-- Links -->
                                <h6 class="text-uppercase fw-bold mb-4">
                                    รายละเอียดเพิ่มเติม
                                </h6>
                                <p>
                                    <a href="{{ route('description-details') }}" class="text-reset text-decoration-none">รายละเอียดเพิ่มเติม</a>
                                </p>
                                <p>
                                    <a href="{{ route('accommodation-rules') }}" class="text-reset text-decoration-none">กฏระเบียบที่พัก</a>
                                </p>
                                <p>
                                    <a href="{{ route('service-charge') }}" class="text-reset text-decoration-none">ค่าบริการ</a>
                                </p>
                            </div>
                            <!-- Grid column -->

                            <!-- Grid column -->
                            <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">
                                <!-- Links -->
                                <h6 class="text-uppercase fw-bold mb-4">
                                    ติดต่อ
                                </h6>
                                <p><i class="fas fa-home me-3"></i>{{ config('app.name') }}</p>
                                <p>
                                    <i class="fas fa-envelope me-3"></i>homestaytakayai@gmail.com
                                </p>
                                <p><i class="fas fa-phone me-3"></i>085 563 0322</p>
                                <p><i class="fas fa-print me-3"></i>085 563 0322</p>
                            </div>
                            <!-- Grid column -->
                        </div>
                        <!-- Grid row -->
                    </div>
                </section>
                <!-- Section: Links  -->

                <!-- Copyright -->
                <div class="text-center p-4 w-100" style="background-color: rgba(0, 0, 0, 0.05);">
                    © 2022
                    <a class="text-reset fw-bold" href="{{ route('home') }}">{{ config('app.name') }}</a>, Inc. All
                    rights
                    reserved.
                </div>
                <!-- Copyright -->
            </footer>
            <!-- Footer -->
        @endauth
    @endif

    <a href="#" id="toTopBtn" class="cd-top text-replace rounded-3 border border-1" data-abc="true"></a>

</body>

</html>
