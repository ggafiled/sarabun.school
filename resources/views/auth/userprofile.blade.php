@extends('adminlte::page')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-4 col-lg-3">
            <div class="widget">
                <div class="user-photo">
                    <a href="#">
                        <img src="{{ $user->image }}" alt="User Photo">
                        <span id="user-photo-action" class="user-photo-action">กดที่นี่เพื่อเปลี่ยนรูปภาพ</span>
                    </a>
                </div><!-- /.user-photo -->
            </div><!-- /.widget -->


            <div class="widget">
                <ul class="nav nav-pills d-flex flex-column menu-advanced">
                    <li id="btnProfile" class="nav-items rounded active"><a class="nav-link" data-toggle="pill"
                            href="#profile"><i class="fa fa-user pr-1"></i>แก้ไขข้อมูลส่วนตัว</a></li>
                    <li class="nav-items rounded"><a class="nav-link" data-toggle="pill" href="#password"><i
                                class="fa fa-key pr-1"></i>
                            รหัสผ่าน</a></li>
                    <li id="btnLogout" class="nav-items bg-danger rounded"><a class="nav-link" href="#"><i
                                class="fas fa-sign-out-alt pr-1"></i>
                            ออกจากระบบ </a></li>
                </ul>
            </div>
        </div><!-- /.col-* -->

        <div class="col-sm-8 col-lg-9">
            <div class="tab-content">
                <div id="profile" class="tab-pane fade in active">
                    <div class="content">
                        <div class="page-title">
                            <h2> แก้ไขข้อมูลส่วนตัว </h2>
                        </div><!-- /.page-title -->

                        <div class="bg-white rounded pl-5 pt-3 pr-5 pb-5 ml-5 mr-5 mb-5">
                            <h3 class="page-title mt-0 pt-0">
                                ข้อมูลทั่วไป

                                <a href="#" class="btn btn-primary btn-xs pull-right">บันทึก</a>
                            </h3>
                            <form id="profileform">
                                @csrf
                                <div class="row">
                                    <div class="form-group col-sm-6">
                                        <label>ชื่อ-นามสกุล</label>
                                        <input type="text" class="form-control" id="userName" value="{{ $user->name }}"
                                            required>
                                        <div class="invalid-feedback">
                                            ชื่อบัญชีไม่ถูกต้อง
                                        </div>
                                    </div>

                                    <div class="form-group col-sm-6">
                                        <label>อีเมล์</label>
                                        <input type="email" class="form-control" id="userEmail"
                                            value="{{ $user->email }}" required>
                                        <div class="invalid-feedback">
                                            กรอกอีเมล์ใหม่
                                        </div>
                                    </div>
                                </div>
                                <input id="btnSave" type="submit" class="btn btn-primary float-right" value="บันทึก" />

                            </form>
                        </div>
                    </div>
                </div>
                <div id="password" class="tab-pane fade">
                    <div class="content">
                        <div class="page-title">
                            <h2> เปลี่ยนรหัสผ่าน </h2>
                        </div><!-- /.page-title -->

                        <div class="bg-white rounded pl-5 pt-3 pr-5 pb-5 ml-5 mr-5 mb-5">
                            <h3 class="page-title mt-0 pt-0">
                                รหัสผ่าน

                                <a href="#" class="btn btn-primary btn-xs pull-right">บันทึก</a>
                            </h3>
                            <form id="passwordform">
                                @csrf
                                <div class="row">
                                    <div class="form-group col-sm-6">
                                        <label>รหัสผ่านปัจจุบัน</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control pwd" id="currentPassword"
                                                aria-describedby="validationTooltipPasswordPrepend" required>
                                            <span class="input-group-append">
                                                <button class="btn btn-default input-group-text reveal" type="button"><i
                                                        class="fa fa-fw fa-eye"></i></button>
                                            </span>
                                            <div class="invalid-feedback">
                                                รหัสผ่านไม่ถูกต้อง
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label>รหัสผ่านใหม่</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control pwd" id="newPassword"
                                                aria-describedby="validationTooltipPasswordPrepend" required>
                                            <span class="input-group-append">
                                                <button class="btn btn-default input-group-text reveal" type="button"><i
                                                        class="fa fa-fw fa-eye"></i></button>
                                            </span>
                                            <div class="invalid-feedback">
                                                รหัสผ่านไม่ถูกต้อง
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label>ยืนยันรหัสผ่านใหม่</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control pwd" id="confirmPassword"
                                                aria-describedby="validationTooltipPasswordPrepend" required>
                                            <span class="input-group-append">
                                                <button class="btn btn-default input-group-text reveal" type="button"><i
                                                        class="fa fa-fw fa-eye"></i></button>
                                            </span>
                                            <div class="invalid-feedback">
                                                รหัสผ่านไม่ถูกต้อง
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <input id="btnSave" type="submit" class="btn btn-primary float-right" value="บันทึก" />

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section("css")
<style>
    .page-title {
        border-bottom: 1px solid #e9e9e9;
        margin: 0px 0px 30px 0px;
        padding: 0px 0px 20px 0px;
    }

    .user-photo img {
        height: auto;
        width: 100%;
    }

    .user-photo {
        background-color: #fff;
        border: 2px dashed #e9e9e9;
        padding: 15px;
        position: relative;
    }

    .widget {
        margin-bottom: 30px;
    }

    .widget .menu-advanced {
        background-color: #fff;
        list-style: none;
        margin: 0px;
        padding: 20px;
    }

    .widget .menu-advanced li {
        display: block;
        color: #444;
        width: 100%;
        border-radius: 5px;
    }

    .widget .menu-advanced li a {
        color: #444;
        display: block;
        padding: 10px 15px;
        width: 100%;
    }

    .user-photo-action {
        background-color: rgba(255, 255, 255, 0.85);
        bottom: 15px;
        color: #363636;
        left: 15px;
        padding: 8px 0px;
        position: absolute;
        text-align: center;
        right: 15px;
    }
</style>
@stop

@section('js')
<script src="{{ asset('js/app.js') }}"></script>
<script>
    $(document).ready(function () {

        $(".reveal").on('click', function () {
            var $pwd = $(".pwd");
            if ($pwd.attr('type') === 'password') {
                $pwd.attr('type', 'text');
            } else {
                $pwd.attr('type', 'password');
            }
        });

        $('#user-photo-action').on('click', async function () {
            Swal.fire({
                title: 'เปลี่ยนรูปภาพโปรไฟล์',
                html: '<input type="url" id="userimage" class="swal2-input" placeholder="วางลิงค์รูปภาพของคุณ"></input>',
                confirmButtonText: 'บันทึก',
                preConfirm: () => {
                    var urlRegex = /(https?:\/\/.*\.(?:png|jpg|jpeg))/;
                    let userimage = Swal.getPopup().querySelector('#userimage').value
                    if (userimage === '' || !urlRegex.test(userimage)) {
                        Swal.showValidationMessage(`ที่อยู่ไฟล์รูปภาพไม่ถูกต้อง`)
                    }
                    return {
                        userimage: userimage
                    }
                }
            }).then((result) => {
                var formData = new FormData();
                formData.append("image", result.value.userimage);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax("{{URL::to('/')}}/setUserImage", {
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (data, status, xhr) {
                        Swal.fire("รายงานผล", "เปลี่ยนรูปภาพสำเร็จแล้ว",
                            "success").then(function () {
                            location.reload();
                        });
                    },
                    error: function (jqXhr, textStatus, errorMessage) {
                        Swal.showValidationMessage(
                            `ที่อยู่ไฟล์รูปภาพไม่ถูกต้อง`);
                    }
                });
            })
        });

        $('#btnLogout').on('click', function () {
            $('#logout-form').submit();
        });

        var forms = $('#profileform');
        // Loop over them and prevent submission
        var validation = Array.prototype.filter.call(forms, function (form) {
            form.addEventListener('submit', function (event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                } else {
                    swal("รายงานผล", "บันทึกโปรไฟล์สำเร็จแล้ว", "success").then(function () {
                        event.preventDefault();
                        event.stopPropagation();
                    });
                }
                form.classList.add('was-validated');
            }, false);
        });
    });

</script>
@stop