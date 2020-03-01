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
                     Đăng ký Tài khoản Đại lý bán lẻ online miễn phí
                   </h1>
                   <p>
                   <span style="display:block;padding:10px 0">Chào bạn: <strong> {{$username}} </strong>,<br/>
                      Bạn đã đăng ký thành công tài khoản trên azibai.com 
                    </span>
                  </p>
                  <p><strong>I.</strong> Tài khoản Đại lý bán lẻ online trên azibai.com của bạn đã được khởi tạo thành công. Ngay bây giờ, bạn có thể sử dụng tài khoản đã đăng ký và tham gia bán hàng trên azibai.<br/><br/></p>
                  <p><strong>II.</strong> Bạn có muốn được trang bị thêm các kỹ năng chuyên nghiệp giúp bán được hàng ngay không?
                    <br/> Hãy tham gia Diễn đàn chia sẻ các kỹ năng bán hàng chuyên nghiệp dành cho Đại lý bán lẻ online của Azibai.
                    <br/> <a href="https://www.facebook.com/groups/300797756941319/" target="_blank" >Tham gia Miễn phí ngay bây giờ...</a>
                  </p><br/>                         
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

