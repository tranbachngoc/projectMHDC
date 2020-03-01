@extends('emails.template')
@section('title', 'Đăng Ký Azibai')
@section('main')
<table border="0" cellpadding="0" cellspacing="0" style="background:#ffffff" width="100%">
  <tbody>
    <tr>
      <td align="center" valign="top">
        <table border="0" cellpadding="0" cellspacing="0" style="width:650px;border-top:1px dotted #cccccc">
          <tbody>
            <tr>
              <td align="center" style="height:9px" valign="top"></td>
            </tr>
            <tr>
              <td align="left" style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#333333;background:#fff" valign="top">
                <div style="line-height:18px;color:#333">
                  <div style="background:#fff;padding:10px;width:100%;margin-top:10px">
                    <h1 style="font-size:20px;font-weight:bold;color:#666">
                      Đăng ký thành viên miễn phí
                    </h1>
                    <span style="display:block;padding:10px 0">Chào bạn: <strong>{{$username}} </strong>,<br/>
                      <br/>
                      Bạn đã đăng ký thành viên của <a href="{{env('APP_FONTEND_URL')}}" title="{{env('APP_FONTEND_URL')}}}}">{{env('APP_FONTEND_URL')}}}}</a>. Bạn hãy click vào linh này để kích hoạt tài khoản: 
                      <a href="{{$link}}">Link kích hoạt tài khoản</a>
                    </span>
                  </div>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </td>
    </tr>
  </tbody>
</table>
@stop