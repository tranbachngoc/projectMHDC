@extends('emails.template')

@section('title', 'YÊU CẦU LẤY LẠI MẬT KHẨU')
@section('main')
<table  align="center" border="0" cellpadding="0" cellspacing="0" style="font-size: 105%" width="100%">
  <tr>
    <td>
      <img width="150" alt="" src="http://azibai.com/images/logo-azibai.png">
    </td>
  </tr>
  <tr><td align="center"><h2>YÊU CẦU LẤY LẠI MẬT KHẨU</h2></td></tr>
  <tr><td>
      Xin chào {{$user_name}}, <br>
      <p>Bạn hoặc ai đó đã sử dụng địa chỉ email này để yêu cầu lấy lại mật khẩu đăng nhập trên <a href="azibai.com"> www.azibai.com</a><br/>
        Trường hợp bạn quên mật khẩu đăng nhập, Vui lòng <b><a href="{{$keySend}}">Click vào đây </a></b> để xác nhận mật khẩu mới.<br/>
        Hoặc copy đường dẫn bên dưới và dán vào trình duyệt web trên máy tính của bạn:<br/>
        <a href="{{$keySend}}">{{$keySend}}</a><br/>
      <p><b>Lưu ý : Link yêu cầu lấy lại mật khẩu chỉ có giá trị trong vòng 24h.</b></p>
      <p>Nếu bạn không phải là người đã gửi yêu cầu lấy lại mật khẩu, hãy bỏ qua email này và KHÔNG cần thao tác gì thêm.<br/> Tài khoản của bạn trên <a href="azibai.com"> www.azibai.com</a> vẫn đang an toàn.</p>
      <p>Trân trọng,</p>
      <p><a href="azibai.com"> www.azibai.com</a> – TECHNOLOGY 2B MODERN ART.<br/>
        CÔNG TY TNHH DỊCH VỤ MỌI NGƯỜI CÙNG VUI<br/>
        Địa chỉ: {{$settingAddress_1}}<br/>
        Điện thoại: {{$settingPhone}} – Email: <a href="mailto:{{$settingEmail_1}}" style="color:#666;text-decoration:none" target="_blank">{{$settingEmail_1}}</a></p>

    </td></tr>

</table>
@stop

