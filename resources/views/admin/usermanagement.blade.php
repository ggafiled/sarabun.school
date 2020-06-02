@extends('adminlte::page')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">ทะเบียนผู้ใช้งาน</h3>
                    <button type="button" class="btn btn-default float-right" data-toggle="modal"
                        data-target="#modal-default">
                        <i class="fa fa-plus-circle"></i>
                        สร้างบัญชีใหม่
                    </button>
                </div>
                <div class="container-fluid mx-auto mt-2 mb-2">
                    <form>
                        @csrf
                        <div class="row">
                            <div class="col-md">
                                <div class="form-group">
                                    <label>ชื่อ-นามสกุล :</label>
                                    <!-- Search form -->
                                    <input class="form-control" type="text" placeholder="ชื่อผู้ใช้งาน"
                                        aria-label="Search" id="username">
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="form-group">
                                    <label>อีเมล์ :</label>
                                    <input class="form-control" type="email" placeholder="school@mail.com"
                                        aria-label="Search" id="useremail">
                                </div>
                            </div>
                        </div>
                        <div align="right">
                            <button type="button" class="btn btn-default" id="btn-clear">
                                <i class="fas fa-eraser"></i>
                                ล้างการค้นหา
                            </button>
                            <button type="button" class="btn btn-default" data-toggle="modal"
                                data-target="#modal-default">
                                <i class="fas fa-search"></i>
                                ค้นหา
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary mx-auto">
                <div class="card-header">
                    <h3 class="card-title">แสดงรายชื่อผู้ใช้งานระบบ</h3>
                </div>
                <div class="container-fluid mx-auto mt-2 mb-2">
                    <div class="row mx-auto">
                        <table id="tableUser" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>
                                        ลำดับ
                                    </th>
                                    <th>
                                        รูปภาพโปรไฟล์
                                    </th>
                                    <th>
                                        สถานะการใช้งาน
                                    </th>
                                    <th>
                                        ชื่อผู้ใช้งาน
                                    </th>
                                    <th>
                                        อีเมล์
                                    </th>
                                    <th>
                                        การยืนยันบัญชี
                                    </th>
                                    <th width="10%">
                                        จัดการ
                                    </th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('js')
<script src="{{ asset('js/app.js') }}"></script>
<script>
    $(document).ready(function () {

        $("#username").focusTextToEnd();

        var table = $('#tableUser').DataTable({
            processing: true,
            serverSide: true,
            retrieve: true,
            orderCellsTop: true,
            fixedHeader: true,
            ajax: "{{ url('api/usercontent') }}",
            columns: [{
                    className: "dt-center",
                    orderable: false,
                    render: function (data, type, full, meta) {
                        return meta.row + 1;
                    }
                },
                {
                    className: "dt-center",
                    data: "image",
                    render: function (data, type, row) {
                        return '<img src="' + data +
                            '" class="rounded  img-thumbnail mw-100" width="48px" height="48px"/>';
                    }
                },
                {
                    className: 'dt-center',
                    data: "status"
                },
                {
                    data: 'name'
                },
                {
                    data: 'email'
                },
                {
                    className: "dt-center",
                    data: 'email_verified_at',
                    render: function (data, type, row) {
                        if (data == null || data.trim() == "") {
                            return "<div class='badge badge-warning'>ยังไม่ได้ยืนยันบัญชี</div>";
                            
                        } else {
                            return "<div class='badge badge-success'>ยืนยันบัญชีแล้ว</div>";
                        }
                    },
                },
                {
                    className: 'data-control',
                    orderable: false,
                    render: function (data, type, row) {
                        return "<div class='d-flex justify-content-around'>" +
                            "<div class='btn btn-sm btn-danger btn-delete'> ลบ </div>" +
                            "<div class='btn btn-sm btn-warning btn-edit'> แก้ไข </div>" +
                            "</div>";
                    },
                }
            ]
        });

        $('#tableUser tbody').on('click', 'td.data-control .btn-delete', function (e) {
            e.preventDefault();
            var tr = $(this).closest('tr');
            var row = table.row(tr);
            var user = table.row(row).data();
            if (document != null) {
                swal("ต้องการลบบัญชีการใช้งานนี้ใช่หรือไม่?", user.name, {
                    dangerMode: true,
                    buttons: {
                        cancel: "ยกเลิก",
                        confirm: "ยืนยัน",
                    },
                }).then((val) => {
                    
                });
            }
        });

        $('#tableSending tbody').on('click', 'td.data-control .btn-edit', function (e) {
            e.preventDefault();
            var tr = $(this).closest('tr');
            var row = table.row(tr);
            var user = table.row(row).data();
        });

        $('#btn-clear').on('click', function () {
            $("#username").val('');
            $("#useremail").val('');
            $("#username").focusTextToEnd();
            table.search('').columns().search('').draw();
        });

        $('#username', this).on('keyup change', function () {
            if (table.column(2).search() !== this.value) {
                table
                    .column(2)
                    .search(this.value)
                    .draw();
            }
        });

        $('#useremail', this).on('keyup change', function () {
            if (table.column(3).search() !== this.value) {
                table
                    .column(3)
                    .search(this.value)
                    .draw();
            }
        });

    });

</script>
@stop

@section('css')
<style>
    .dataTables_filter {
        display: none;
    }

    div#tableUser_wrapper {
        width: 100% !important;
    }

</style>
@stop
