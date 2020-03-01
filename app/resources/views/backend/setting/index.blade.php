@extends('backend.template')

@section('title', 'Danh sách cài đặt')
@section('main')
<table class="table table-striped">
  <thead>
    <tr>
      <th>Id</th>
      <th>Tên</th>
      <th>Biến cài đặt</th>
      <th>Quyền</th>
      <th>Thông tin thêm</th>
      <th>#</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($settings as $setting)
    <tr>
      <td>{{$setting->id}}</td>
      <td>{{$setting->name}}</td>
      <td>{{$setting->metaToStrings()}}</td>
      <td><span class="badge {{$setting->accessType === 'public' ? 'badge-success' : ''}}">{{$setting->accessType === 'public' ? 'Public' : 'Private'}}</span></td>
      <td>{{$setting->description}}</td>
      <td>
        <td class="column-Action">
          <div class="actions">
            <div class="btn-group">
              <a class="btn btn-sm green dropdown-toggle" href="javascript:;" data-toggle="dropdown" aria-expanded="true">
                <i class="fa fa-cogs"></i><i class="fa fa-angle-down"></i></a>
                <ul class="dropdown-menu pull-right">
                  <li><a href="{{url('backend/settings/'.$setting->id.'/update')}}"><i class="fa fa-pencil"></i>Sửa dịch vụ</a></li>
                </ul>
              </div>
          </div>
        </td>
      </td>
    </tr>
    @endforeach
  </tbody>
</table>
@stop