@extends('backend.template')

@section('title', 'Thống kê ví tiền tất cả tài xế')
@section('main')
<div ng-controller="revenueManagerCtrl" class="portlet light bordered">
 <div class="portlet-title">
    <div class="caption font-red-sunglo">
      <i class="fa fa-search font-red-sunglo"></i>
      <span class="caption-subject bold uppercase"> Lọc dữ liệu</span>
    </div>
  </div>
  <div class="portlet-body form">
    {{ Form::open($layout['action'])}}
    <div class="form-horizontal">
      <div class="row ">

        <div class="col-sm-6">
          <div class="form-group">
            <label class="col-sm-3">Từ ngày</label>
            <div class="col-sm-9">
              <div class="input-group date" >
                {{Form::text('startDate', isset($input['startDate']) ? $input['startDate']:'',['placeholder'=>'Từ ngày','readonly'=>true,'id'=>'startDate','class'=>'form-control '])}}


                <div class="input-group-addon">
                  <span class="glyphicon glyphicon-calendar"></span>
                </div>
              </div>
            </div>
          </div>

        </div>
        <div class="col-sm-6">
          <div class="form-group">
            <label class="col-sm-3">Tới ngày</label>
            <div class="col-sm-9">
              <div class="input-group date" >
                {{Form::text('endDate', isset($input['endDate']) ? $input['endDate']:'',['placeholder'=>'Đến ngày','readonly'=>true,'id'=>'endDate','class'=>'form-control'])}}


                <div class="input-group-addon">
                  <span class="glyphicon glyphicon-calendar"></span>
                </div>
              </div>

            </div>
          </div>
        </div>


        <div class="col-sm-6">
          <div class="form-group">
            <label class="col-sm-3">Loại </label>
            <div class="col-sm-9">
              {{Form::select('type',array_merge(['' => 'Chọn loại'], $types),isset($input['type'])? $input['type']:'',['class'=>'form-control'])}}
            </div>
          </div>
        </div>
        <div class="col-sm-6">
          <div class="form-group">
            <label class="col-sm-3">Tài xế</label>
            <div class="col-sm-9">
              {{Form::text('driverKeywords', isset($input['driverKeyWords']) ? $input['driverKeywords']:'',['placeholder'=>'Tên tài xế / số điện thoại email','class'=>'form-control'])}}
            </div>
          </div>
        </div>
    
        <div class="clearfix"></div>
        <div class="text-right">
          {{ Form::reset('Reset', ['class' => 'btn ','id'=>'reset-button']) }}
          <button type="submit" class="btn green">Search</button>
        </div>
      </div>
    </div>
    {{ Form::close() }}
  </div>
</div>
<div class="portlet light bordered">
  <div class="portlet-body">
    <div class="form-group">
      <div class="row">
        <div class="col-md-4 col-sm-4 col-xs-6 text-stat">
          <span class="label label-sm label-danger"> Tổng doanh thu: </span>
          <h3>{{number_format($totalSummary)}} đ</h3>
        </div>
        <div class="col-md-4 col-sm-4 col-xs-6 text-stat">
          <span class="label label-sm label-default"> Số tiền chuyển đổi ( từ ví sang limo): </span>
          <h3>{{number_format($totalExchange)}} đ</h3>
        </div>
        <div class="col-md-4 col-sm-4 col-xs-6 text-stat">
          <span class="label label-sm label-info"> Limo phải thanh toán: </span>
          <h3>{{number_format($moneyLimoPay)}} đ</h3>
        </div>
      </div>
    </div>
  
  </div>
</div>
<div class="portlet light bordered">
 <?= $grid ?>
</div>
@stop