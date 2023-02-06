@extends('layouts.admin')

@section('title', 'Manage bank detail')

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

@section('page-name')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item active">จัดการบัญชีชำระเงิน</li>
        </ol>
    </nav>
@endsection

@section('content')
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

    <div class="card rounded-3 border border-1 shadow-lg">
        <div class="card-header">
            วิธีการชำระเงิน
        </div>
        <div class="card-body">
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
                        <select class="form-select" aria-label="Default select example" id="bank_name" name="bank_name"
                            required>
                            <option selected hidden>เลือกธนาคาร</option>
                            @foreach ($bank_names as $bank_name)
                                <option value="{{ $bank_name->id }}">{{ $bank_name->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="acc_number" class="form-label">เลขบัญชี *</label>
                        <input type="text" class="form-control" id="acc_number" name="acc_number" placeholder="เลขบัญชี">
                    </div>
                    <div class="mb-3">
                        <label class="labels">Prompt Pay *</label>
                        <input type="text" name="prompt_pay" class="form-control" placeholder="099-XXX-XXXX"
                            pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" required>
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
                    <div class="row mt-2">
                        <div class="col-md-6">
                            <label class="labels">ชื่อ *</label>
                            <input type="text" class="form-control" id="firstName" name="firstName"
                                value="{{ $banks[0]->firstName }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="labels">นามสกุล *</label>
                            <input type="text" class="form-control" id="lastName" name="lastName"
                                value="{{ $banks[0]->lastName }}" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="bank_name" class="form-label">ธนาคาร *</label>
                        <select class="form-select" aria-label="Default select example" id="bank_name" name="bank_name"
                            required>
                            @foreach ($bank_names as $bank_name)
                                @if ($bank_name->id == $banks[0]->bank_name_id)
                                    <option selected hidden value="{{ $bank_name->id }}">{{ $bank_name->name }}</option>
                                @else
                                    <option value="{{ $bank_name->id }}">{{ $bank_name->name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="acc_number" class="form-label">เลขบัญชี *</label>
                        <input type="text" class="form-control" id="acc_number" name="acc_number"
                            value="{{ $banks[0]->acc_number }}" placeholder="เลขบัญชี">
                    </div>
                    <div class="mb-3">
                        <label class="labels">Prompt Pay</label>
                        <input type="text" name="prompt_pay" class="form-control"
                            value="{{ $banks[0]->prompt_pay }}" placeholder="099-XXX-XXXX"
                            pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}">
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
                    <img src="{{ asset('storage/images/' . $img) }}" width="200px" height="360px"
                        alt={{ $img }}>
                </a>
                <br>
                <div class="d-flex justify-content-start mt-4 mb-4">
                    <input type="submit" class="btn btn-success" value="แก้ใขบัญชีธนาคาร" form="form-editBank"
                        style="margin-right: 5px">
                    <form action="{{ route('delete-bank', $banks[0]->id) }}" method="POST" id="form-delBank"
                        class="m-0">
                        @csrf
                    </form>
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                        data-bs-target="#showModelDelBank" onclick="showModelDelBank('{{ $banks[0]->acc_number }}')">
                        ลบบัญชีธนาคาร
                    </button>
                </div>
            @endif
        </div>
    </div>
@endsection
