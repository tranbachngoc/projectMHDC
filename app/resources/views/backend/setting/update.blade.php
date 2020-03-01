@extends('backend.template')

@section('title', 'Cập nhật cài đặt #'.$req->id)
@section('main')
<div ng-controller="servicesManagerCtrl as ctrl">
@if ($errors->any())
<div class="alert alert-danger">
    {{!! implode('', $errors->all('<div>:message</div>')) !!}}
</div>
@endif

{{ Form::open(array('url' => action('Backend\SettingController@update', ['id'=>$req->id]), 'method' => 'put'))}}
  {{ csrf_field() }}
  <div class="form-group">
    <label>Tên (*)</label>
    <input type="text" class="form-control" required name="name" value="{{$setting->name}}" placeholder="Tên dịch vụ (*)" />
  </div>
  <div class="form-group">
    <label>Khóa</label>
    <input type="text" class="form-control" name="key" readonly value="{{$setting->key}}" />
  </div>
  <div class="form-group">
    <label>Nhận giá trị</label>
    <div class="form-horizontal">
      @foreach ($setting->meta as $key => $value)
      <div class="form-group">
        <label class="col-md-2 control-label">{{$key}}</label>
        <div class="col-md-6">
          <input type="text" class="form-control" name="{{$key}}" required placeholder="{{$key}}" value="{{$value}}"> </div>
      </div>
      <input type="text" name="metaAttributes[]" hidden value="{{$key}}" />
      @endforeach
    </div>
  </div>
  <div class="form-group">
    <label>Thông tin thêm</label>
    <textarea class="form-control" name="description" placeholder="Thông tin phụ">{{$setting->description}}</textarea>
  </div>
  <div class="form-actions">
    <button class="btn btn-primary">Lưu Lại</button>
  </div>
  {{ Form::close() }}
  </div>
@stop