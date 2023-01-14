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

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

</head>

<body>
    @if (Route::has('login'))
        @auth
            <!-- Header -->
            <header>
                <nav class="container navbar navbar-expand-lg navbar-light py-3">
                    <div class="container-fluid p-0">
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
                                <a href="{{ route('booking-history') }}"
                                    class="nav-item nav-link @yield('booking-history')">ประวัติการจอง</a></li>
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
        @else
            <!-- Header -->
            <header>
                <nav class="container navbar navbar-expand-lg navbar-light py-3">
                    <div class="container-fluid p-0">
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
                                <a href="{{ route('login') }}" class="nav-item nav-link @yield('login')">เข้าสู่ระบบ</a>
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
        @endauth
    @endif

    <!-- Section -->
    <section>
        <div class="container">
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
        </div>
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
                    <i class='bx bxl-facebook'></i>
                </a>
                <a href="" class="me-4 text-reset text-decoration-none">
                    <i class='bx bxl-twitter'></i>
                </a>
                <a href="" class="me-4 text-reset text-decoration-none">
                    <i class='bx bxl-instagram'></i>
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
                        <iframe class="map"
                            src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d15289.377841669955!2d101.9024255!3d16.6596376!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x4391dac7bf891955!2z4LmC4Liu4Lih4Liq4LmA4LiV4Lii4LmM4LiV4Liy4LiB4Liw4Lii4Liy4LiiIOC4oOC4ueC4nOC4suC4oeC5iOC4suC4mQ!5e0!3m2!1sth!2sth!4v1657632801624!5m2!1sth!2sth"
                            style="border:0;" allowfullscreen="" loading="lazy"
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
                            <a href="{{ route('booking-history') }}"
                                class="text-reset text-decoration-none">ประวัติการจอง</a>
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
                            <a href="{{ route('description-details') }}"
                                class="text-reset text-decoration-none">รายละเอียดเพิ่มเติม</a>
                        </p>
                        <p>
                            <a href="{{ route('accommodation-rules') }}"
                                class="text-reset text-decoration-none">กฏระเบียบที่พัก</a>
                        </p>
                        <p>
                            <a href="{{ route('service-charge') }}"
                                class="text-reset text-decoration-none">ค่าบริการ</a>
                        </p>
                    </div>
                    <!-- Grid column -->

                    <!-- Grid column -->
                    <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">
                        <!-- Links -->
                        <h6 class="text-uppercase fw-bold mb-4">
                            ติดต่อ
                        </h6>
                        <p><i class='bx bx-home-heart'></i> {{ config('app.name') }}</p>
                        <p>
                            <i class='bx bx-envelope'></i> homestaytakayai@gmail.com
                        </p>
                        <p><i class='bx bx-phone'></i> 085 563 0322</p>
                        <p><i class='bx bx-printer'></i> 085 563 0322</p>
                    </div>
                    <!-- Grid column -->
                </div>
                <!-- Grid row -->
            </div>
        </section>
        <!-- Section: Links  -->

        <!-- Copyright -->
        <div class="text-center p-4 w-100" style="background-color: rgba(0, 0, 0, 0.05);">
            <i class='bx bx-copyright'></i> 2023
            <a class="text-reset fw-bold" href="{{ route('home') }}">{{ config('app.name') }}</a>, Inc. All
            rights
            reserved.
        </div>
        <!-- Copyright -->
    </footer>
    <!-- Footer -->

    <!-- Messenger ปลั๊กอินแชท Code -->
    <div id="fb-root"></div>

    <!-- Your ปลั๊กอินแชท code -->
    <div id="fb-customer-chat" class="fb-customerchat">
    </div>

    <script>
        var chatbox = document.getElementById('fb-customer-chat');
        chatbox.setAttribute("page_id", "114913974823497");
        chatbox.setAttribute("attribution", "biz_inbox");
    </script>

    <!-- Your SDK code -->
    <script>
        window.fbAsyncInit = function() {
            FB.init({
                xfbml: true,
                version: 'v15.0'
            });
        };

        (function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s);
            js.id = id;
            js.src = 'https://connect.facebook.net/th_TH/sdk/xfbml.customerchat.js';
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>
    
    <a href="#" id="toTopBtn" class="cd-top text-replace rounded-3"></a>

</body>

</html>
