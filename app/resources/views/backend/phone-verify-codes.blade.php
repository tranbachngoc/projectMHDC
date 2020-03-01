@extends('backend.template')

@section('main')
<h1>Verify phone codes</h1>
<table class="table table-striped">
  <thead>
    <tr>
      <th>Code</th>
      <th>Phone</th>
      <th>Name</th>
      <th>Email</th>
      <th>User type</th>
      <th>Created at</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($codes as $code)
    <tr>
      <td>{{$code->code}}</td>
      <td>{{$code->phone}}</td>
      <td>{{$code->name}}</td>
      <td>{{$code->email}}</td>
      <td>{{$code->userType}}</td>
      <td>{{$code->createdAt}}</td>
    </tr>
    @endforeach

  </tbody>
</table>
@stop