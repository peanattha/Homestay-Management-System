@extends('layouts.user')

@section('title', 'หน้าหลัก')

@section('home', 'active')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

@if (Session::get('notAdmin') == true)
    <script>
        $(window).on('load', function() {
            $('#exampleModal').modal('show');
        });
    </script>
@endif

<script>
    function closeModel() {
        $('#exampleModal').modal('hide');
    }
</script>

@section('content')
    {{-- Model You Not Admin --}}
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">แจ้งเตือน</h5>
                </div>
                <div class="modal-body">
                    คุณไม่ใช่ผู้ดูเเลระบบ
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" onclick="closeModel()">ตกลง</button>
                </div>
            </div>
        </div>
    </div>
    <div class="wallpaper-home">
        <img src="{{ asset('images/wallpaper.jpg') }}" class="imgHome">
        <div class="text">
            <h1>{{ config('app.name') }}</h1>
            <p>โฮมสเตย์ตากะยาย ภูผาม่าน, 210 บ้าน ตำบล ภูผาม่าน อำเภอ ภูผาม่าน ขอนแก่น 40350</p>
        </div>
    </div>
@endsection
