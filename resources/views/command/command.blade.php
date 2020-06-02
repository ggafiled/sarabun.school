@extends('adminlte::page')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">ทะเบียนคุมคำสั่ง</h3>
                    @if($editmode)
                    <a class="float-right" href="{{ route('form.command-add') }}" title="send add">
                        <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-default">
                            <i class="fa fa-plus-circle"></i>
                            เริ่มใหม่
                        </button>
                    </a>
                    @endif
                </div>
                <form action="/storeFileAndData" method="post" role="form">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="w3-text-blue">เลขที่คำสั่ง :</label>
                                    <input type="hidden" class="form-control" id="id" name="id"
                                        value="{{ ($editmode)? $document['id'] : '' }}" readonly>
                                    <input type="text" class="form-control" id="run_no" name="run_no"
                                        value="{{ ($editmode)? $document['run_no'] : '' }}" required autocomplete="true"
                                        readonly>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="w3-text-blue">ที่ :</label>
                                    <input type="text" class="form-control" id="document_no" name="document_no"
                                        placeholder="ศธ 04058.130/...."
                                        value="{{ ($editmode)? $document['document_no'] : ''}}" required
                                        autocomplete="true" autofocus>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="w3-text-blue">ลงวันที่ :</label>
                                    @if(!$editmode)
                                    {{ Form::date('start_date',\Carbon\Carbon::today(),['class' => 'date form-control','id'
                                    => 'document_created_at', 'name' => 'document_created_at']) }}
                                    @else
                                    {{ Form::date('start_date',\Carbon\Carbon::createFromFormat('Y-m-d', $document['document_created_at']),['class'
                                    => 'date form-control','id' => 'document_created_at', 'name' =>
                                    'document_created_at']) }}
                                    @endif
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="w3-text-blue">เรื่อง :</label>
                                    <input type="text" class="form-control" id="title" name="title" required
                                        value="{{ ($editmode)? $document['title'] : ''}}" autocomplete="true">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="w3-text-blue">การปฏิบัติ :</label>
                                    <input type="text" class="form-control" id="user" name="user"
                                        value="{{ Auth::user()->name }}" readonly>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="w3-text-blue">หมายเหตุ :</label>
                                    <input type="text" class="form-control" id="note" name="note" autocomplete="true"
                                        value="{{ ($editmode)? $document['note'] : ''}}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12 col-md-12 col-sm-12 col-nopadding">
                                <label class="w3-text-blue">@if($editmode) เพิ่มไฟล์แนบ @else แนบไฟล์ @endif:</label>
                                <div class="d-flex justify-content-around">
                                    <div class="dropzone flex-fill" id="myDropzone"></div>
                                </div>
                            </div>
                            @if($editmode)
                            <x-filelist :files="$document->attach_file"></x-filelist>
                            @endif
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" id="submit-all" class="btn btn-primary">@if($editmode)
                            {{ __('common.edit_button') }}
                            @else {{ __('common.save_button') }} @endif</button>
                        <button type="reset" class="btn btn-warning">{{ __('common.cancel_button') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
<style lang="scss">
    .dropzone {
        border: dashed #007BFF 2px !important;
    }

    .flex-md-fill+.flex-md-fill {
        margin: 1em;
    }
</style>
@stop

@section('js')
<script src="{{ asset('js/app.js') }}"></script>
<script>
    $(document).ready(function () {

        var editmode = "<?php echo $editmode ?>";

        $("#document_no").focusTextToEnd();

        if (!editmode) {
            getRunNo();
        }

        function getRunNo() {
            $.ajax("{{URL::to('/')}}/api/getCommandLastId", {
                type: 'POST',
                processData: false,
                contentType: false,
                success: function (data, status, xhr) {
                    console.log(data);
                    $('#run_no').val(data);
                },
                error: function (jqXhr, textStatus, errorMessage) {
                    swal("รายงานผล", "มีบางอย่างผิดปกติโปรดลองอีกครั้ง",
                        "error");
                }
            });
        }
    });
    Dropzone.options.myDropzone = {
        url: '/storeFileAndData',
        dictDefaultMessage: "ลากไฟล์มาที่นี่ หรือ คลิก เพื่ออัพโหลด สูงสุด 5 ไฟล์",
        autoProcessQueue: false,
        uploadMultiple: true,
        parallelUploads: 5,
        maxFiles: 5,
        maxFilesize: 6,
        zoom: 4,
        acceptedFiles: "{{ config('app.acceptedFiles') }}",
        addRemoveLinks: true,
        headers: {
            'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content
        },
        init: function () {
            dzClosure = this; // Makes sure that 'this' is understood inside the functions below.

            // for Dropzone to process the queue (instead of default form behavior):
            $("#submit-all").on("click", function (e) {
                // Make sure that the form isn't actually being sent.
                e.preventDefault();
                e.stopPropagation();
                var formData = new FormData();
                formData.append("_token", "{{ csrf_token() }}");
                formData.append("id", $("#id").val());
                formData.append("run_no", $("#run_no").val());
                formData.append("document_no", $("#document_no").val());
                formData.append("document_created_at", $("#document_created_at").val());
                formData.append("document_type_id", 3);
                formData.append("title", $("#title").val());
                formData.append("user", "{{ Auth::user()->id }}");
                formData.append("editmode", "{{ $editmode }}");
                formData.append("note", $("#note").val());

                if (dzClosure.getQueuedFiles().length > 0) {
                    dzClosure.processQueue();
                } else {
                    dzClosure.uploadFiles([]);
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax("/storeFileAndData", {
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function (data, status, xhr) {
                            var today = new Date().toISOString().split('T')[0];
                            swal("รายงานผล", "บันทึกคำสั่งสำเร็จแล้ว", "success");
                            $("#id").val('');
                            $("#document_no").val('');
                            $("#document_created_at").val(today);
                            $("#title").val('');
                            $("#note").val('');
                            $("#document_no").focusTextToEnd();
                            location.reload();
                        },
                        error: function (jqXhr, textStatus, errorMessage) {
                            swal("รายงานผล", "มีบางอย่างผิดปกติโปรดลองอีกครั้ง",
                                "error");
                        }
                    });
                }
                return false;
            });

            //send all the form data along with the files:
            this.on("sendingmultiple", function (data, xhr, formData) {
                formData.append("_token", "{{ csrf_token() }}");
                formData.append("id", $("#id").val());
                formData.append("run_no", $("#run_no").val());
                formData.append("document_no", $("#document_no").val());
                formData.append("document_created_at", $("#document_created_at").val());
                formData.append("document_type_id", 3);
                formData.append("title", $("#title").val());
                formData.append("user", "{{ Auth::user()->id }}");
                formData.append("editmode", "{{ $editmode }}");
                formData.append("note", $("#note").val());
            });

            this.on('addedfile', function (file) {
                var ext = file.name.split('.').pop();
                if (ext == "pdf") {
                    $(file.previewElement).find(".dz-image img").attr("src",
                        "{{ URL::to('/') }}/images/pdf.png");
                } else if (ext.indexOf("doc") != -1 || ext.indexOf("docx") != -1) {
                    $(file.previewElement).find(".dz-image img").attr("src",
                        "{{ URL::to('/') }}/images/word.png");
                } else if (ext.indexOf("xls") != -1 || ext.indexOf("xlsx") != -1) {
                    $(file.previewElement).find(".dz-image img").attr("src",
                        "{{ URL::to('/') }}/images/excel.png");
                } else if (ext.indexOf("txt") != -1) {
                    $(file.previewElement).find(".dz-image img").attr("src",
                        "{{ URL::to('/') }}/images/text.png");
                } else if (ext.indexOf("ppt") != -1 || ext.indexOf("pptx") != -1 || ext.indexOf(
                        "ppsx") != -
                    1) {
                    $(file.previewElement).find(".dz-image img").attr("src",
                        "{{ URL::to('/') }}/images/powerpoint.png");
                } else if (ext.indexOf("zip") != -1 || ext.indexOf("rar") != -1 || ext.indexOf(
                        "7zip") != -
                    1) {
                    $(file.previewElement).find(".dz-image img").attr("src",
                        "{{ URL::to('/') }}/images/zip.png");
                }

                $(file.previewElement).find(".dz-image img").attr({
                    width: '85%',
                    height: '100%'
                }).addClass('mx-auto');
            });

            this.on("success", function (file, responseText) {
                var today = new Date().toISOString().split('T')[0];
                swal("รายงานผล", "บันทึกคำสั่งสำเร็จแล้ว", "success");
                $("#id").val('');
                $("#document_no").val('');
                $("#document_created_at").val(today);
                $("#title").val('');
                $("#note").val('');
                this.removeAllFiles();
                $("#document_no").focusTextToEnd();
                location.reload();
            });
        }
    }

</script>
@stop