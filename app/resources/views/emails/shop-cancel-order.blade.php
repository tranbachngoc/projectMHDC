@extends('emails.template')

@section('title', 'Hủy đơn hàng')
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
                      Đăng ký Gian hàng miễn phí
                    </h1> 
                    <span style="display:block;padding:10px 0">Xin chào: <strong> {{$username}}</strong>,<br/>
                      <br/>
                      Bạn đã đăng ký thành công tài khoản trên azibai.com
                      <br/><br/>
                      <strong>Bạn đang muốn tăng doanh thu nhanh, tăng lợi nhuận?</strong>
                      <br/><strong>Bạn có muốn tuyển được ngay đội ngũ Cộng tác viên bán hàng chuyên nghiệp?</strong>
                      <br/> Hãy tham gia Cộng Đồng Doanh Nghiệp Kinh Doanh Online Azibai để cùng chia sẻ các kinh nghiệm kinh doanh hiệu quả.
                      <br/> <a href="https://www.facebook.com/groups/1233843429961548/" target="_blank" >Click vào đây để tham gia Miễn phí....</a>
                      <br/><br/><br/>
                      <a href="{{$link}}">Click vào đây</a> để xác nhận tài khoản đã đăng ký trên azibai.com
                      <br/><br/><br/>
                      <a href="{{env('APP_URL')}}content/391">Qui định đối với người bán</a>
                      <br/>
                      <a href="{{env('APP_URL')}}account' . '">Link quản trị tài khoản</a>
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

