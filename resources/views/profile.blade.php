@extends('layouts.user')

@section('title', 'โปรไฟล์')

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
    <div class="container">
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
        <div class="container card rounded-3 border border-1 shadow-lg mb-4">
            <div class="d-flex justify-content-around flex-wrap">
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
                                    <input type="text" name="firstName" class="form-control"
                                        value="{{ $user->firstName }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="labels">นามสกุล *</label>
                                    <input type="text" name="lastName" class="form-control"
                                        value="{{ $user->lastName }}">
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
        <div class="container card rounded-3 border border-1 shadow-lg mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="text-right">เเก้ใขรหัสผ่าน</h4>
                </div>
                @if (Session::has('error'))
                    <div class="alert alert-danger alert-dismissible fade show">
                        {{ Session::get('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if (Session::has('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        {{ Session::get('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
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
                            <div class="input-group">
                                <input type="password" name="current-password" id="current-password"
                                    placeholder="รหัสผ่านปัจจุบัน" class="form-control" required value="">
                                <span class="input-group-text" style="cursor: pointer" id="toggle-btn"
                                    onclick="togglePassword()">Show</span>
                            </div>
                            <script>
                                function togglePassword() {
                                    var currentPassword = document.getElementById("current-password");
                                    var toggleBtn = document.getElementById("toggle-btn");
                                    if (currentPassword.type === "password") {
                                        currentPassword.type = "text";
                                        toggleBtn.textContent = "Hide";
                                    } else {
                                        currentPassword.type = "password";
                                        toggleBtn.textContent = "Show";
                                    }
                                }
                            </script>
                        </div>
                        <div class="col-md-12 mb-2">
                            <label class="labels">รหัสผ่านใหม่ *</label>
                            <div class="input-group">
                                <input type="password" name="new-password" id="new-password" placeholder="รหัสผ่านใหม่"
                                    class="form-control" required value="">
                                <span class="input-group-text" style="cursor: pointer" id="toggle-btn2"
                                    onclick="togglePassword2()">Show</span>
                            </div>
                            <script>
                                function togglePassword2() {
                                    var newPassword = document.getElementById("new-password");
                                    var toggleBtn2 = document.getElementById("toggle-btn2");
                                    if (newPassword.type === "password") {
                                        newPassword.type = "text";
                                        toggleBtn2.textContent = "Hide";
                                    } else {
                                        newPassword.type = "password";
                                        toggleBtn2.textContent = "Show";
                                    }
                                }
                            </script>
                        </div>
                        <div class="col-md-12">
                            <label class="labels">ยืนยันรหัสผ่านใหม่ *</label>

                            <div class="input-group">
                                <input type="password" name="new-password-confirm" id="new-password-confirm" placeholder="ยืนยันรหัสผ่านใหม่" required
                                class="form-control" value="">
                                <span class="input-group-text" style="cursor: pointer" id="toggle-btn3"
                                    onclick="togglePassword3()">Show</span>
                            </div>
                            <script>
                                function togglePassword3() {
                                    var newPasswordConfirm = document.getElementById("new-password-confirm");
                                    var toggleBtn3 = document.getElementById("toggle-btn3");
                                    if (newPasswordConfirm.type === "password") {
                                        newPasswordConfirm.type = "text";
                                        toggleBtn3.textContent = "Hide";
                                    } else {
                                        newPasswordConfirm.type = "password";
                                        toggleBtn3.textContent = "Show";
                                    }
                                }
                            </script>
                        </div>
                    </div>
                    <div class="mt-3">
                        <button class="btn btn-success" type="submit">แก้ใขรหัสผ่าน</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="container card rounded-3 border border-1 shadow-lg mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="text-right">ลบบัญชี</h4>
                </div>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Culpa deserunt sint expedita blanditiis
                    eligendi officiis labore soluta optio sapiente tenetur nobis, et iste quia inventore in velit quasi
                    facere dolorum numquam. Corrupti illum quam, delectus qui, placeat reiciendis, nemo quaerat ipsam
                    consectetur nobis beatae quos nisi rerum optio quibusdam sit?</p>
                <form action="{{ route('delete-account') }}" method="POST" id="del-account" class="m-0">
                    @csrf
                    <button type="button" onclick="showModelDel('{{ $user->email }}')"
                        class="btn btn-danger">ลบบัญชี</button>
                </form>
            </div>
        </div>
    </div>
@endsection
