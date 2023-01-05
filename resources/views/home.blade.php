@extends('layouts.user')

@section('title', 'หน้าหลัก')

@section('home', 'active')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

@if (Session::has('notAdmin'))
    <script>
        $(window).on('load', function() {
            $('#exampleModal').modal('show');
        });
    </script>
@endif

@section('content')
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <p class="modal-title" id="exampleModalLabel">แจ้งเตือน</p>
                </div>
                <div class="modal-body">
                    คุณไม่ใช่ผู้ดูเเลระบบ
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยืนยัน</button>
                </div>
            </div>
        </div>
    </div>
    <div class="wallpaper-home mb-4">
        <img src="{{ asset('images/wallpaper (3).jpg') }}" class="imgHome">
        <div class="text">
            <h1>{{ config('app.name') }}</h1>
            <p>โฮมสเตย์ตากะยาย ภูผาม่าน, 210 บ้าน ตำบล ภูผาม่าน อำเภอ ภูผาม่าน ขอนแก่น 40350</p>
        </div>
    </div>

    <div>
        <div class="container mb-4">
            <div class="d-flex flex-wrap justify-content-between align-self-center">
                <div class="col-md-5 text-ey">
                    <h1>โฮมสเตย์ตากะยาย ภูผาม่าน ขอนแก่น</h1>
                    <p class="p1">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Hic, sapiente!
                    </p>
                    <p>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Culpa deserunt sint expedita blanditiis
                        eligendi officiis labore soluta optio sapiente tenetur nobis, et iste quia inventore in velit quasi
                        facere dolorum numquam. Corrupti illum quam, delectus qui, placeat reiciendis, nemo quaerat ipsam
                        consectetur nobis beatae quos nisi rerum optio quibusdam sit?
                    </p>
                </div>
                <img src="{{ asset('images/info1.png') }}" alt="img1" class="img_info" />
            </div>
        </div>
        <div class="container mb-4">
            <div class="d-flex flex-wrap justify-content-between align-self-center">
                <img src="{{ asset('images/info3.png') }}" alt="img1" class="img_info" />
                <div class="col-md-5 text-ey">
                    <h1>“บ้านอิงผา”</h1>
                    <p>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Culpa deserunt sint expedita blanditiis
                        eligendi officiis labore soluta optio sapiente tenetur nobis, et iste quia inventore in velit quasi
                        facere dolorum numquam. Corrupti illum quam, delectus qui, placeat reiciendis, nemo quaerat ipsam
                        consectetur nobis beatae quos nisi rerum optio quibusdam sit?
                    </p>
                </div>
            </div>
        </div>
        <div class="container mb-4">
            <div class="d-flex flex-wrap justify-content-between align-self-center">
                <div class="col-md-5 text-ey">
                    <h1>“บ้านผาอิงภู”</h1>
                    <p>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Culpa deserunt sint expedita blanditiis
                        eligendi officiis labore soluta optio sapiente tenetur nobis, et iste quia inventore in velit quasi
                        facere dolorum numquam. Corrupti illum quam, delectus qui, placeat reiciendis, nemo quaerat ipsam
                        consectetur nobis beatae quos nisi rerum optio quibusdam sit?
                    </p>
                </div>
                <img src="{{ asset('images/info2.png') }}" alt="img1" class="img_info" />
            </div>
        </div>
    </div>
@endsection
