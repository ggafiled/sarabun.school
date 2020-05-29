@extends('adminlte::page')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ $sending | 0 }}</h3>

                                <p>ทะเบียนส่ง</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-fw fa-book"></i>
                            </div>
                            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $receiving | 0 }}</h3>

                                <p>ทะเบียนรับ</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-fw fa-book"></i>
                            </div>
                            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3>{{ $command | 0 }}</h3>

                                <p>คำสั่ง</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-fw fa-file-alt"></i>
                            </div>
                            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3>{{ $memorandum | 0 }}</h3>

                                <p>บันทึกข้อความ</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-fw fa-paperclip"></i>
                            </div>
                            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@stop

@section('css')
<style lang="scss">
.small-box:hover {
    cursor: pointer;
}
</style>
@stop