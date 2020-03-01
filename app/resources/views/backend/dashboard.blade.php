@extends('backend.template')
@section('title', 'Dashboard')
@section('main')
<div class="row">
  <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
    <a class="dashboard-stat dashboard-stat-v2 grey" href="#">
      <div class="visual">
        <i class="fa fa-warning"></i>
      </div>
      <div class="details">
        <div class="number">
          <span data-counter="counterup" ></span>
        </div>
        <div class="desc"> Chuyến xe nhận </div>
      </div>
    </a>
  </div>
  <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
    <a class="dashboard-stat dashboard-stat-v2 red" href="#">
      <div class="visual">
        <i class="fa fa-exclamation-circle"></i>
      </div>
      <div class="details">
        <div class="number">
          <span data-counter="counterup" ></span> </div>
        <div class="desc">  Chuyến xe bị hủy </div>
      </div>
    </a>
  </div>
  <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
    <a class="dashboard-stat dashboard-stat-v2 green" href="#">
      <div class="visual">
        <i class="fa fa-cab"></i>
      </div>
      <div class="details">
        <div class="number">
          <span data-counter="counterup" ></span>
        </div>
        <div class="desc"> Đang trong chuyến đi </div>
      </div>
    </a>
  </div>
  <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
    <a class="dashboard-stat dashboard-stat-v2 green-jungle" href="#">
      <div class="visual">
        <i class="fa fa-check"></i>
      </div>
      <div class="details">
        <div class="number">
          <span data-counter="counterup" ></span>
        </div>
        <div class="desc"> Thành công </div>
      </div>
    </a>
  </div>
</div>
@stop