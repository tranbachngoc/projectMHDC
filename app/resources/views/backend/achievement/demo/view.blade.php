@extends('backend.template')

@section('title', 'Thông tin thành tích')
@section('main')
<div class="col-sm-12" ng-controller="achievementDemoManagerCtrl as ctrl">

  <h1 class="page-title"> {{$achievement->name}} <label class="label label-sm label-success btn-circle uppercase"><i class="fa fa-folder-open-o"> {{$achievement->status}}</i></label></h1>

  <div class="note note-info">
  <p>{{$achievement->description}}</p>
  </div>
  
  @if($achievement->status == 'pending')
    <button class="btn btn-primary" ng-click="ctrl.confirmbox(EVENT_START_EVENT_MESSAGE, EVENT_START_EVENT)">Start</button>
  @else
  <confirmbox control="ctrl"></confirmbox>

  <div class="portlet light bordered" ng-controller="driverManagerCtrl as ctrl">
    <div class="portlet-title">
      <div class="caption">
        <i class="icon-settings font-red"></i>
        <span class="caption-subject font-red sbold uppercase">Danh sách tài xế trong thành tích</span>
      </div>
      
    </div>

    <table class="table table-striped">
    <thead>
      <tr>
        <th>Id</th>
        <th>Tên</th>
        <th>Điện thoại</th>
        <th>Email</th>
        <th>Ngày tạo</th>
        <th>Xem chi tiết</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($drivers as $driver)
      <tr>
        <td>{{$driver->id}}</td>
        <td>{{$driver->name}}</td>
        <td>{{$driver->phone}}</td>
        <td>{{$driver->email}}</td>
        <td>
          {{$driver->createdAt}}
        </td>
        <td>
          <a href="{{$achievement->getFrontendUrlByDriver($driver->id)}}" target="_blank">Xem</a>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
  </div>
</div>
@endif
@stop