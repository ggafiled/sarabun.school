@props(['files'])

@php
$fileType = array('pdf'=> "<i class='far fa-file-pdf text-danger'></i>",
'docx'=> "<i class='far fa-file-word text-primary'></i>",
'doc'=> "<i class='far fa-file-word text-primary'></i>",
'xls'=> "<i class='far fa-file-excel text-success'></i>",
'xlsx'=> "<i class='far fa-file-excel text-success'></i>",
'ppt'=> "<i class='far fa-file-powerpoint text-warning'></i>",
'pptx'=> "<i class='far fa-file-powerpoint text-warning'></i>",
'zip,rar'=> "<i class='far fa-file-archive'></i>",
'txt'=> "<i class='far fa-file-alt text-secondary'></i>",
'png'=> "<i class='far fa-file-image'></i>",
'jpeg'=> "<i class='far fa-file-image'></i>",
'jpg'=> "<i class='far fa-file-image'></i>");
@endphp

<div id="file-list" class="col-xl-12 col-md-12 col-sm-12 col-nopadding mt-sm-3">
    <div class="flex-fill ml-1">
        <label class="w3-text-blue">ไฟล์ที่ถูกแนบในเอกสาร :</label>
        @if(count($files) > 0)
        <ul class="mailbox-attachments d-flex flex-wrap align-content-center align-items-stretch clearfix">
            @foreach ($files as $file)
            <li class="mailbox-content d-flex flex-column">
                <a href="{{ URL::to('/') }}/retrieveFile/{{ $file->filename }}" target="_blank">
                    @if(!in_array($file->extension,['jpg','jpeg','png']))
                    <span class="mailbox-attachment-icon">
                        @php
                        echo ($fileType[$file->extension])? $fileType[$file->extension]:"<i
                            class='far fa-question-circle'></i>";
                        @endphp
                    </span>
                    @else
                    <span class="mailbox-attachment-icon has-img">
                        <img src="{{ URL::to('/') }}/retrieveFile/{{ $file->filename }}" alt="Attachment">
                    </span>
                    @endif
                </a>
                <div class="mailbox-attachment-info">
                    <a href="{{ URL::to('/') }}/retrieveFile/{{ $file->filename }}" target="_blank"
                        class="mailbox-attachment-name">
                        {{ $file->originalname }}
                    </a>
                    <div class="mailbox-attachment-size clearfix mt-1">
                        <span>{{ $file->size }} KB</span>
                        <div id="action-control" class="d-flex float-right justify-content-around">
                            <div class="btn btn-default btn-sm" onclick="attachfileRenameAction({{ $file }})">
                                <i class="fas fa-terminal"></i>
                            </div>
                            <div class="btn btn-default btn-sm bg-danger" onclick="attachfileDeleteAction({{ $file }})">
                                <i class="far fa-trash-alt"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
            @endforeach
        </ul>
        @else
        ไม่มีไฟล์แนบ
        @endif
    </div>
</div>

<script src="{{ asset('js/app.js') }}"></script>
<script>
    $(document).ready(function () {

    });

    function attachfileRenameAction(file) {
        Swal.fire({
            title: '<h4>เปลี่ยนชื่อไฟล์</h4>',
            html: '<input type="text" id="newfilename" class="swal2-input form-control" value="' + file
                .originalname + '"></input>',
            confirmButtonText: 'บันทึก',
            preConfirm: () => {
                let newfilename = Swal.getPopup().querySelector('#newfilename').value
                if (newfilename === '') {
                    Swal.showValidationMessage(`ชื่อไฟล์ไม่สามารถว่างไว้ได้`)
                }
                return {
                    newfilename: newfilename
                }
            }
        }).then(result => {
            if (!result.value.newfilename) return null;

            var formData = new FormData();
            formData.append("_token", "{{ csrf_token() }}");
            formData.append("fileid", file.id);
            formData.append("newname", result.value.newfilename.trim());

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax("/renameFile", {
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (data, status, xhr) {
                    console.log("Success");
                    Swal.fire("รายงานผล", "ลบข้อมูลคุมทะเบียนสำเร็จแล้ว",
                        "success").then(function () {
                        location.reload();
                    });
                },
                error: function (jqXhr, textStatus, errorMessage) {
                    console.log("failed");
                    Swal.fire("รายงานผล", "มีบางอย่างผิดปกติโปรดลองอีกครั้ง",
                        "error").then(function () {
                        location.reload();
                    });
                }
            });
        });
    }

    function attachfileDeleteAction(file) {
        Swal.fire({
            title: 'ต้องการลบไฟล์แนบนี้ใช่หรือไม่?',
            text: file.originalname,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'ยกเลิก',
            confirmButtonText: 'ลบ'
        }).then((result) => {
            if (result.value) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax("/deleteFile/" + file.id, {
                    type: 'POST',
                    success: function (data, status, xhr) {
                        Swal.fire("รายงานผล", "ลบไฟล์แนบสำเร็จแล้ว",
                            "success").then(function () {
                            location.reload();
                        });
                    },
                    error: function (jqXhr, textStatus, errorMessage) {
                        Swal.fire("รายงานผล", "มีบางอย่างผิดปกติโปรดลองอีกครั้ง",
                            "error").then(function () {
                            // location.reload();
                        });
                    }
                });
            }
        });
    }

</script>

<style lang="scss">
    #action-control>.btn:not(:last-child) {
        margin-right: 1em;
    }

    .mailbox-content {
        flex-grow: auto;
        flex-basis: 1;
        justify-content: space-between;
    }

    .mailbox-attachment-size {
        justify-content: end;
    }
</style>