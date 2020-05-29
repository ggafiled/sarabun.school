@extends('adminlte::page')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">ทะเบียนคุมหนังสือส่ง</h3>
                </div>
                <form action="/storeFileAndData" method="post" role="form">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="w3-text-blue">เลขทะเบียนส่ง :</label>
                                    <input type="text" class="form-control" id="sending_no" name="sending_no"
                                        value="{{ ($editmode)? $document['id'] : $lastid }}" required
                                        autocomplete="true" readonly>
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
                                    {{ Form::date('start_date',\Carbon\Carbon::today(),['class' => 'date form-control','id' => 'document_created_at', 'name' => 'document_created_at']) }}
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="w3-text-blue">จาก :</label>
                                    <input type="text" class="form-control" id="source" name="source" required
                                        value="{{ ($editmode)? $document['source'] : ''}}" autocomplete="true">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="w3-text-blue">ถึง :</label>
                                    <input type="text" class="form-control" id="destination" name="destination" required
                                        autocomplete="true" value="{{ ($editmode)? $document['destination'] : ''}}">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="w3-text-blue">เรื่อง :</label>
                                    <input type="text" class="form-control" id="title" name="title" required
                                        autocomplete="true" value="{{ ($editmode)? $document['title'] : ''}}">
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
                            <div class="col-sm-10">
                                <div class="form-group">
                                    <label class="w3-text-blue">แนบไฟล์ :</label>
                                    <div class="dropzone" id="myDropzone"></div>
                                </div>
                            </div>
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
</style>
@stop

@section('js')
<script>
$(document).ready(function() {
    $("#document_no").focus();
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
    init: function() {
        dzClosure = this; // Makes sure that 'this' is understood inside the functions below.

        // for Dropzone to process the queue (instead of default form behavior):
        $("#submit-all").on("click", function(e) {
            // Make sure that the form isn't actually being sent.
            e.preventDefault();
            e.stopPropagation();
            var formData = new FormData();
            formData.append("_token", "{{ csrf_token() }}");
            formData.append("sending_no", $("#sending_no").val());
            formData.append("document_no", $("#document_no").val());
            formData.append("document_created_at", $("#document_created_at").val());
            formData.append("source", $("#source").val());
            formData.append("destination", $("#destination").val());
            formData.append("document_type_id", 1);
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
                    success: function(data, status, xhr) {
                        var today = new Date().toISOString().split('T')[0];
                        swal("รายงานผล", "บันทึกคุมทะเบียนส่งสำเร็จแล้ว", "success");
                        $("#sending_no").val('');
                        $("#document_no").val('');
                        $("#source").val('');
                        $("#destination").val('');
                        $("#document_created_at").val(today);
                        $("#title").val('');
                        $("#note").val('');
                        this.removeAllFiles();
                        $("#document_no").focus();
                    },
                    error: function(jqXhr, textStatus, errorMessage) {
                        swal("รายงานผล", "มีบางอย่างผิดปกติโปรดลองอีกครั้ง",
                            "error");
                    }
                });
            }
            return false;
        });

        //send all the form data along with the files:
        this.on("sendingmultiple", function(data, xhr, formData) {
            formData.append("_token", "{{ csrf_token() }}");
            formData.append("sending_no", $("#sending_no").val());
            formData.append("document_no", $("#document_no").val());
            formData.append("document_created_at", $("#document_created_at").val());
            formData.append("source", $("#source").val());
            formData.append("destination", $("#destination").val());
            formData.append("document_type_id", 1);
            formData.append("title", $("#title").val());
            formData.append("user", "{{ Auth::user()->id }}");
            formData.append("editmode", "{{ $editmode }}");
            formData.append("note", $("#note").val());
        });

        this.on('addedfile', function(file) {
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
            } else if (ext.indexOf("ppt") != -1 || ext.indexOf("pptx") != -1 || ext.indexOf("ppsx") != -
                1) {
                $(file.previewElement).find(".dz-image img").attr("src",
                    "{{ URL::to('/') }}/images/powerpoint.png");
            } else if (ext.indexOf("zip") != -1 || ext.indexOf("rar") != -1 || ext.indexOf("7zip") != -
                1) {
                $(file.previewElement).find(".dz-image img").attr("src",
                    "{{ URL::to('/') }}/images/zip.png");
            }

            $(file.previewElement).find(".dz-image img").attr({
                width: '85%',
                height: '100%'
            }).addClass('mx-auto');
        });

        this.on("success", function(file, responseText) {
            var today = new Date().toISOString().split('T')[0];
            swal("รายงานผล", "บันทึกคุมทะเบียนส่งสำเร็จแล้ว", "success");
            $("#sending_no").val('');
            $("#document_no").val('');
            $("#source").val('');
            $("#destination").val('');
            $("#document_created_at").val(today);
            $("#title").val('');
            $("#note").val('');
            this.removeAllFiles();
            $("#document_no").focus();
        });
    }
}
</script>
@stop