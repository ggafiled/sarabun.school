@extends('adminlte::page')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">ทะเบียนคุมคำสั่ง</h3>
                </div>
                <!-- /.card-header -->
                <form action="command_save.php" method="post" role="form">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="w3-text-blue">คำสั่งที่ :</label>
                                    <input type="text" class="form-control" id="txtid" name="txtid" value="" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="w3-text-blue">ลงวันที่ :</label>
                                    {{ Form::date('start_date',\Carbon\Carbon::today(),['class' => 'date form-control','id' => 'timestamp', 'name' => 'timestamp']) }}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="w3-text-blue">เรื่อง :</label>
                                    <input type="text" class="form-control" id="txtsub" name="txtsub" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="w3-text-blue">การปฏิบัติ :</label>
                                    <input type="text" class="form-control" id="txtpra" name="txtpra"
                                        value="{{ Auth::user()->name }}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="w3-text-blue">หมายเหตุ :</label>
                                    <input type="text" class="form-control" id="txtnotee" name="txtnotee">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">บันทึก</button>
                        <button type="reset" class="btn btn-warning">ยกเลิก</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@stop