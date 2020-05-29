@extends('adminlte::page')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary mx-auto">
                <div class="card-header">
                    <h3 class="card-title">ค้นหาข้อมูลทะเบียนคุมหนังสือรับ</h3>
                </div>
                <div class="container-fluid mx-auto mt-2 mb-2">
                    <form>
                        @csrf
                        <div class="form-group">
                            <label>เรื่อง :</label>
                            <!-- Search form -->
                            <input class="form-control" type="text" placeholder="ชื่อเรื่องเอกสาร" aria-label="Search"
                                id="title">

                        </div>
                        <div class="row">
                            <div class="col-md">
                                <div class="form-group">
                                    <label>เลขหนังสือ :</label>
                                    <font color="#FF0000"> อว7415(20)</font>
                                    <input class="form-control" type="text" placeholder="ไม่ระบุข้อมูล"
                                        aria-label="Search" id="sending_no">
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="form-group">
                                    <label>วันที่ :</label>
                                    *รับหนังสือ
                                    {{ Form::date('start_date',\Carbon\Carbon::today(),['class' => 'date form-control','id' => 'document_created_at', 'name' => 'document_created_at']) }}
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="form-group">
                                    <label>แผนกปลายทาง :</label>
                                    <input class="form-control" type="text" placeholder="ไม่ระบุข้อมูล"
                                        aria-label="Search" id="destination">
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
                    <h3 class="card-title">แสดงรายการทะเบียนหนังสือรับ</h3>
                </div>
                <div class="container-fluid mx-auto mt-2 mb-2">
                    <div align="right">
                        <a href="{{ route('form.receiving-add') }}" title="send add">
                            <button type="button" class="btn btn-default" data-toggle="modal"
                                data-target="#modal-default">
                                <i class="fa fa-plus-circle"></i>
                                สร้างทะเบียนหนังสือรับ
                            </button>
                        </a>
                    </div>
                    <form method="post">
                        <div class="col-sm-12 col-md-12">
                            <div align="left">

                                <a class="btn btn-danger btn-primary text-white" data-toggle="tooltip"
                                    title="พิมพ์ข้อมูล">
                                    <i class="fas fa-file-excel"></i></span> PDF
                                </a>
                                <a class="btn btn-success btn-primary text-white" data-toggle="tooltip"
                                    title="รับออกข้อมูล">
                                    <i class="fas fa-file-excel"></i></span> Excel
                                </a></p>
                    </form>
                    <div class="modal fade" id="modal-default-edit">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title">แก้ไขข้อมูล</h4>
                                </div>

                                <form>
                                    <div class="modal-body ">

                                        <input type="hidden">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default pull-left"
                                            data-dismiss="modal">Close</button>
                                        <button type="submit" id="submit" class="btn btn-primary">
                                            Save
                                            changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="row mx-auto">
                        <table id="tableSending" class="table table-bordered table-striped w-100">
                            <thead>
                                <tr>
                                    <th>
                                        ลำดับ
                                    </th>
                                    <th>
                                        เลขที่หนังสือ
                                    </th>
                                    <th>
                                        ชื่อเรื่อง
                                    </th>
                                    <th>
                                        ต้นสังกัด
                                    </th>
                                    <th>
                                        ปลายทาง
                                    </th>
                                    <th>
                                        ผู้บันทึก
                                    </th>
                                    <th>
                                        วันที่ลงเอกสาร
                                    </th>
                                    <th>
                                        หมายเหตุ
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

@section('css')
<style>
td.details-control {
    background: url("{{ URL::to('/') }}/images/details_open.png") no-repeat center center;
    cursor: pointer;
}

tr.shown td.details-control {
    background: url("{{ URL::to('/') }}/images/details_close.png") no-repeat center center;
}

.dataTables_filter {
    display: none;
}
</style>
<style lang="scss">
.subtable-file-list+.subtable-file-list {
    margin-bottom: 1px
}

div#tableSending_wrapper {
    width: 100% !important;
}
</style>
@stop

@section('js')
<script src="{{ asset('js/app.js') }}"></script>
<script lang="text/javascript">
function formatForfileLoop(d) {
    var fileType = {
        'pdf': "<i class='far fa-file-pdf text-danger'></i>",
        'docx': "<i class='far fa-file-word text-primary'></i>",
        'doc': "<i class='far fa-file-word text-primary'></i>",
        'xls': "<i class='far fa-file-excel text-success'></i>",
        'xlsx': "<i class='far fa-file-excel text-success'></i>",
        'ppt': "<i class='far fa-file-powerpoint text-warning'></i>",
        'pptx': "<i class='far fa-file-powerpoint text-warning'></i>",
        'zip,rar': "<i class='far fa-file-archive'></i>",
        'txt': "<i class='far fa-file-alt text-secondary'></i>",
        'png,jpeg,jpg': "<i class='far fa-file-image'></i>",
    };
    // `d` is the original data object for the row
    return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">' +
        '<tr>' +
        '<td>เลขที่ทะเบียนส่ง:</td>' +
        '<td>' + d.id + '</td>' +
        '</tr>' +
        '<tr>' +
        '<td>ไฟล์แนบ:</td>' +
        '<td>' + d.attach_file.map((file) => {
            var icon = fileType[file.extension] || "<i class='far fa-question-circle'></i>";
            return "<div class='subtable-file-list'>" + icon +
                "<a class='ml-2' href='{{ URL::to('/') }}/retrieveFile/" +
                file.filename + "'>" +
                file.originalname + "</a></div>"
        }) +
        '</td>' +
        '</tr>' +
        '</table>';
}

function formatForNotHavefileLoop(d) {
    // `d` is the original data object for the row
    return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">' +
        '<tr>' +
        '<td>เลขที่ทะเบียนส่ง:</td>' +
        '<td>' + d.id + '</td>' +
        '</tr>' +
        '<tr>' +
        '<td>ไฟล์แนบ:</td>' +
        '<td> ไม่มีไฟล์แนบ </td>' +
        '</tr>' +
        '</table>';
}

$(document).ready(function() {

    $("#title").focus();

    var table = $('#tableSending').DataTable({
        processing: true,
        serverSide: true,
        retrieve: true,
        orderCellsTop: true,
        fixedHeader: true,
        ajax: "{{ url('api/receivingcontent') }}",
        columns: [{
                className: 'details-control',
                orderable: false,
                data: null,
                defaultContent: ''
            },
            {
                data: 'document_no'
            },
            {
                data: 'title'
            },
            {
                data: 'source'
            },
            {
                data: 'destination'
            },
            {
                data: 'user.name'
            },
            {
                data: 'document_created_at'
            },
            {
                data: 'note'
            },
            {
                className: 'data-control',
                orderable: false,
                render: function(data, type, row) {
                    return "<div class='d-flex justify-content-around'>" +
                        "<div class='btn btn-sm btn-danger btn-delete'> ลบ </div>" +
                        "<div class='btn btn-sm btn-warning btn-edit'> แก้ไข </div>" +
                        "</div>";
                },
            }
        ]
    });

    $('#tableSending tbody').on('click', 'td.details-control', function() {
        var tr = $(this).closest('tr');
        var row = table.row(tr);

        if (row.child.isShown()) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        } else {
            // Open this row
            var objLenght = Object.keys(row.data().attach_file).length;
            console.log(objLenght);
            if (objLenght > 0) {
                row.child(formatForfileLoop(row.data())).show();
            } else {
                row.child(formatForNotHavefileLoop(row.data())).show();
            }
            tr.addClass('shown');
        }
    });

    $('#tableSending tbody').on('click', 'td.data-control .btn-delete', function(e) {
        e.preventDefault();
        var tr = $(this).closest('tr');
        var row = table.row(tr);
        var document = table.row(row).data();
        console.info(document);
        if (document != null) {
            swal("ต้องการลบข้อมูลคุมทะเบียนนี้ใช่หรือไม่?", "เรื่อง " + document.title, {
                dangerMode: true,
                buttons: {
                    cancel: "ยกเลิก",
                    confirm: "ยืนยัน",
                },
            }).then((val) => {
                if (val) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax("/deleteFileAndData/" + document.id, {
                        type: 'POST',
                        success: function(data, status, xhr) {
                            swal("รายงานผล", "ลบข้อมูลคุมทะเบียนสำเร็จแล้ว",
                                "success");
                            table.search('').columns().search('').draw();
                        },
                        error: function(jqXhr, textStatus, errorMessage) {
                            swal("รายงานผล", "มีบางอย่างผิดปกติโปรดลองอีกครั้ง",
                                "error");
                        }
                    });
                }
            });
        }
    });

    $('#tableSending tbody').on('click', 'td.data-control .btn-edit', function(e) {
        e.preventDefault();
        var tr = $(this).closest('tr');
        var row = table.row(tr);
        var document = table.row(row).data();
        if (document != null) {
            window.location.href =
                `{{URL::to('form/receiving-add')}}?documentid=${document.id}&editmode=true`
        }
    });

    $('#sending_no', this).on('keyup change', function() {
        if (table.column(1).search() !== this.value) {
            table
                .column(1)
                .search(this.value)
                .draw();
        }
    });

    $('#title', this).on('keyup change', function() {
        if (table.column(2).search() !== this.value) {
            table
                .column(2)
                .search(this.value)
                .draw();
        }
    });

    $('#destination', this).on('keyup change', function() {
        if (table.column(4).search() !== this.value) {
            table
                .column(4)
                .search(this.value)
                .draw();
        }
    });

    $('#document_created_at', this).on('keyup change', function() {
        if (table.column(6).search() !== this.value) {
            table
                .column(6)
                .search(this.value)
                .draw();
        }
    });

    $('#btn-clear').on('click', function() {
        var today = new Date().toISOString().split('T')[0];
        $("#sending_no").val('');
        $("#title").val('');
        $("#destination").val('');
        $("#document_created_at").val(today);
        $("#title").focus();
        table.search('').columns().search('').draw();
    });

});
</script>
@stop