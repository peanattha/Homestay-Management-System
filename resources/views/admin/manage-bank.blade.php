@extends('layouts.admin')

@section('title', 'Manage bank detail')

@section('manage-bank-detail', 'active')

<link rel="stylesheet" href="{{ asset('css/table.css') }}">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script>
    // Delete Bank
    function showModelDelBank(accNumber) {
        document.getElementById("textModelDelBank").innerHTML =
            "คุณเเน่ใจที่จะลบบัญชี " + accNumber;
        $("#showModelDelBank").modal("show");
    }

    function confirmDelBank() {
        document.getElementById("form-delBank").submit();
    }
</script>

@section('content')
    {{-- Alert Message --}}
    @if (Session::has('message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ Session::get('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    {{-- Model Delete Bank --}}
    <div class="modal fade" id="showModelDelBank" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">แจ้งเตือน</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="textModelDelBank"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" onclick="confirmDelBank()">ยืนยัน</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                </div>
            </div>
        </div>
    </div>
    <div class="bg-white p-4 rounded-3 border border-1 shadow-lg mb-4">
        <h3>วิธีการชำระเงิน</h3>
        @if ($banks->isEmpty())
            <form action="{{ route('add-bank') }}" method="POST" enctype="multipart/form-data" id="form-addBank">
                @csrf
                <div class="row mt-2">
                    <div class="col-md-6">
                        <label class="labels">ชื่อ *</label>
                        <input type="text" name="firstName" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="labels">นามสกุล *</label>
                        <input type="text" name="lastName" class="form-control" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="bank_name" class="form-label">ธนาคาร *</label>
                    <input type="text" class="form-control" id="bank_name" name="bank_name" required>
                </div>
                <div class="mb-3">
                    <label for="acc_number" class="form-label">เลขบัญชี *</label>
                    <input type="text" class="form-control" id="acc_number" name="acc_number" placeholder="เลขบัญชี">
                </div>
                <div class="mb-3">
                    <label class="labels">Prompt Pay</label>
                    <input type="text" name="prompt_pay" class="form-control" placeholder="099-XXX-XXXX"
                        pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}">
                </div>
                <div class="mb-3">
                    <label for="FileImgMultiple" class="form-label">QR Code *</label>
                    <input class="form-control" type="file" id="FileImgMultiple" name="qr_code" required>
                </div>
                <input type="submit" class="btn btn-success" value="เพิ่มบัญชีธนาคาร" form="form-addBank">
            </form>
        @else
            <form action="{{ route('edit-bank', $banks[0]->id) }}" method="POST" enctype="multipart/form-data"
                id="form-editBank">
                @csrf
                <div class="mb-3">
                    <label for="firstName" class="form-label">ชื่อ *</label>
                    <input type="text" class="form-control" id="firstName" name="firstName"
                        value="{{ $banks[0]->firstName }}" required>
                </div>
                <div class="mb-3">
                    <label for="lastName" class="form-label">นามสกุล *</label>
                    <input type="text" class="form-control" id="lastName" name="lastName"
                        value="{{ $banks[0]->lastName }}" required>
                </div>
                <div class="mb-3">
                    <label for="bank_name" class="form-label">ธนาคาร *</label>
                    <input type="text" class="form-control" id="bank_name" name="bank_name"
                        value="{{ $banks[0]->bank_name }}" required>
                </div>
                <div class="mb-3">
                    <label for="acc_number" class="form-label">เลขบัญชี *</label>
                    <input type="text" class="form-control" id="acc_number" name="acc_number"
                        value="{{ $banks[0]->acc_number }}" placeholder="เลขบัญชี">
                </div>
                <div class="mb-3">
                    <label class="labels">Prompt Pay</label>
                    <input type="text" name="prompt_pay" class="form-control" value="{{ $banks[0]->prompt_pay }}"
                        placeholder="099-XXX-XXXX" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}">
                </div>
                <div class="mb-3">
                    <label for="FileImgMultiple" class="form-label">QR Code</label>
                    <input class="form-control" type="file" id="FileImgMultiple" name="qr_code">
                </div>
            </form>
            <?php
            $img = $banks[0]->qr_code;
            ?>
            <a href="{{ asset('storage/images/' . $img) }}" target="_bank">
                <img src="{{ asset('storage/images/' . $img) }}" width="200px" height="360px" alt={{ $img }}>
            </a>
            <br>
            <div class="d-flex justify-content-start mt-4 mb-4">
                <input type="submit" class="btn btn-success" value="แก้ใขบัญชีธนาคาร" form="form-editBank"
                    style="margin-right: 5px">
                <form action="{{ route('delete-bank', $banks[0]->id) }}" method="POST" id="form-delBank"
                    class="m-0">
                    @csrf
                </form>
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#showModelDelBank"
                onclick="showModelDelBank('{{ $banks[0]->acc_number }}')">
                ลบบัญชีธนาคาร
                </button>
            </div>
        @endif
    </div>
@endsection
