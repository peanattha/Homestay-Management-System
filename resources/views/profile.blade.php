@extends('layouts.user')

@section('title', 'Profile')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script>
    // Delete Account
    function showModelDel(email) {
        document.getElementById("textModelDel").innerHTML =
            "คุณเเน่ใจที่จะลบบัญชี " + email;
        $("#modal-del").modal("show");
    }

    function confirmDel() {
        document.getElementById("del-account").submit();
    }
    // Close Model
    function closeModel() {
        $("#modal-del").modal("hide");
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
    @if (Session::has('warning'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            {{ Session::get('warning') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    {{-- Model Delete Account --}}
    <div class="modal fade" id="modal-del" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">แจ้งเตือน</h5>
                </div>
                <div class="modal-body" id="textModelDel"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" onclick="closeModel()">ยกเลิก</button>
                    <button type="button" class="btn btn-success" onclick="confirmDel()">ยืนยัน</button>
                </div>
            </div>
        </div>
    </div>
    <div class="container rounded bg-white">
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
                            <button class="btn btn-success" type="submit">บันทึกโปรไฟล์</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="container rounded bg-white mt-5">
        <div class="row">
            <div class="col-md-5">
                <div class="p-3 py-5">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="text-right">เเก้ใขรหัสผ่าน</h4>
                    </div>
                    @if (Session::has('error'))
                        <div class="alert alert-danger alert-dismissible fade show">
                            {{ Session::get('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif
                    @if (Session::has('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            {{ Session::get('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif
                    @if ($errors)
                        @foreach ($errors->all() as $error)
                            <div class="alert alert-danger alert-dismissible fade show">
                                {{ $error }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endforeach
                    @endif
                    <form action="{{ route('change-password') }}" method="POST">
                        @csrf
                        <div class="row mt-3">
                            <div class="col-md-12 mb-2">
                                <label class="labels">รหัสผ่านปัจจุบัน *</label>
                                <input type="password" name="current-password" placeholder="รหัสผ่านปัจจุบัน"
                                    class="form-control" required value="">
                            </div>
                            <div class="col-md-12 mb-2">
                                <label class="labels">รหัสผ่านใหม่ *</label>
                                <input type="password" name="new-password" placeholder="รหัสผ่านใหม่"
                                    class="form-control" required value="">
                            </div>
                            <div class="col-md-12">
                                <label class="labels">ยืนยันรหัสผ่านใหม่ *</label>
                                <input type="password" name="new-password-confirm" placeholder="ยืนยันรหัสผ่านใหม่"
                                    required class="form-control" value="">
                            </div>
                        </div>
                        <div class="mt-5">
                            <button class="btn btn-success" type="submit">แก้ใขรหัสผ่าน</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="container rounded bg-white mt-5 mb-5">
        <div class="row">
            <div class="col-md-5">
                <div class="p-3 py-5">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="text-right">ลบบัญชี</h4>
                    </div>
                    <form action="{{ route('delete-account') }}" method="POST" id="del-account">
                        @csrf
                        <div class="mt-5">
                            <button type="button" onclick="showModelDel('{{ $user->email }}')"
                                class="btn btn-danger">ลบบัญชี</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
