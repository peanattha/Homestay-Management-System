@extends('layouts.admin')

@section('active-manage-bank', 'active')

@section('title', 'Manage Bank Name')

<link rel="stylesheet" href="{{ asset('css/table.css') }}">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script>
    // Delete homestay Type
    function showModelDelBankName(id, name) {
        window.id_bank_name = id;
        document.getElementById("textModelDelBankName").innerHTML =
            "คุณเเน่ใจที่จะลบชื่อธนาคาร " + name;
        $("#modal-del-bank-name").modal("show");
    }

    function confirmDelBankName() {
        document
            .getElementById("del-bank-name" + window.id_bank_name)
            .submit();
    }

    // Edit homestay Type
    function showModelEditBankName(id, name) {
        $("#edit-bank-name").val(name);

        $("#edit-bank-name-id").val(id);

        $("#modelEditBankName").modal("show");
    }
</script>

@section('page-name')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="{{ route('manage-bank') }}">วิธีการชำระเงิน</a></li>
            <li class="breadcrumb-item active" aria-current="page">เพิ่ม/ลบ/แก้ใข ชื่อธนาคาร</li>
        </ol>
    </nav>
@endsection

@section('content')
    {{-- Model Delete Bank Name --}}
    <div class="modal fade" id="modal-del-bank-name" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">แจ้งเตือน</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="textModelDelBankName"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" onclick="confirmDelBankName()">ยืนยัน</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Model Edit Bank Name --}}
    <div class="modal fade" id="modelEditBankName" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <p class="modal-title" id="exampleModalCenterTitle">แก้ใขชื่อธนาคาร</p>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('edit-bank-name') }}" method="POST" class="m-0">
                        @csrf
                        <div class="form-group">
                            <label for="exampleInputEmail1" class="mb-2">ชื่อธนาคาร</label>
                            <input type="text" style="display: none" name="id" id="edit-bank-name-id">
                            <input type="text" class="form-control mb-2" name="bank_name" id="edit-bank-name" required>
                            <small id="emailHelp" class="form-text text-muted mb-2">แก้ใขชื่อธนาคาร</small>
                        </div>
                        <div class="mb-2 mt-2">
                            <button type="submit" class="btn btn-success">ยืนยัน</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="card rounded-3 border border-1 shadow-lg">
        <div class="card-header">
            เพิ่มชื่อธนาคาร
        </div>
        <div class="card-body">
            <form action="{{ route('add-bank-name') }}" method="POST" id="add-bank-name">
                @csrf
                <div class="mb-3">
                    <label for="bank_name" class="form-label">ชื่อธนาคาร *</label>
                    <input type="text" class="form-control" id="bank_name" name="bank_name" required>
                    <div id="emailHelp" class="form-text">กรอกชื่อธนาคารเพื่อเพิ่มชื่อธนาคาร</div>
                </div>
                <button type="submit" class="btn btn-success">เพิ่มชื่อธนาคาร</button>
            </form>
        </div>
    </div>

    <div class="table100 ver2 mb-4 mt-4">
        <div class="table100-head">
            <table>
                <thead>
                    <tr>
                        <th style="width: 25%">ลำดับ</th>
                        <th style="width: 25%">ชื่อธนาคาร</th>
                        <th style="width: 25%">เเก้ไขชื่อธนาคาร</th>
                        <th style="width: 25%">ลบชื่อธนาคาร</th>
                    </tr>
                </thead>
            </table>
        </div>
        <div class="table100-body js-pscroll">
            <table>
                <tbody>
                    @foreach ($bank_names as $bank_name)
                        <tr>
                            <td style="width: 25%">{{ $loop->iteration }}</td>
                            <td style="width: 25%">{{ $bank_name->name }}</td>
                            <td style="width: 25%">
                                <button type="button" class="btn btn-primary"
                                    onclick="showModelEditBankName({{ $bank_name->id }},'{{ $bank_name->name }}')">
                                    แก้ไขชื่อธนาคาร
                                </button>
                            </td>
                            <td style="width: 25%">
                                <form action="{{ route('delete-bank-name', $bank_name->id) }}" method="POST"
                                    id="del-bank-name{{ $bank_name->id }}" class="m-0 ">
                                    @csrf
                                </form>
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#modal-del-bank-name"
                                    onclick="showModelDelBankName({{ $bank_name->id }},'{{ $bank_name->name }}')">
                                    ลบชื่อธนาคาร
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
