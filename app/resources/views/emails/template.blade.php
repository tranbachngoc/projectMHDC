<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Azibai API</title>
</head>
<body>
  <div class="flex-center position-ref full-height">
    <div class="content">
      <div id=":p8" class="ii gt m153a68f7aadeb171 adP adO">
        <div id=":n8" class="a3s" style="overflow: hidden;">
          <div class="adM">  </div>
          <table align="center" border="0" cellpadding="0" cellspacing="0" style="margin:0 auto;font-family:arial,sans-serif;font-size:12px;color:#000;text-align:left;line-height:24px;background-color:#f5f5f5" width="100%">
            <tbody>
              <tr>
                <td align="center" style="padding:20px 0">
                  <img alt="" src="http://azibai.com/images/logo-azibai.png" class="CToWUd">
                </td>
              </tr>   
              <tr><td></td></tr> 
            </tbody>
          </table> 
          @yield('main')
          <table align="center" border="0" cellpadding="0" cellspacing="0" style="margin:0 auto;font-family:arial,sans-serif;font-size:12px;color:#000;text-align:left;line-height:24px;background-color:#f5f5f5" width="100%">
            <tbody>
              <tr>
                <td>
                  <table border="0" cellpadding="0" cellspacing="0" style="margin:0 auto;border:1px solid #ececec;background-color:#fff" width="800"> 
                    <tbody>
                      <tr></tr>        
                      <tr>
                        <td style="border-top:1px solid #ececec;padding:30px 0;color:#666">
                          <table border="0" cellpadding="0" cellspacing="0" style="margin:0 auto" width="700">
                            <tbody>
                              <tr>
                                <td align="left" valign="top" width="55%">  
                                  <p style="line-height:24px;color:#2a2a2a;margin-top:10px;display:block">
                                  CÔNG TY TNHH DỊCH VỤ MỌI NGƯỜI CÙNG VUI, AZIBAI.COM<br>
                                   {{env('SETTING_ADDRESS_1')}}<br>
                                    Liên hệ: Số điện thoại <span style="color:#666"> {{env('SETTING_PHONE')}} </span> - Email <a href="mailto:+{{env('SETTING_EMAIL_1')}}" style="color:#666;text-decoration:none" target="_blank"> {{env('SETTING_EMAIL_1')}}</a> </p>
                                </td> 
                                <td align="right">
                                  <div style="padding-top:10px;margin-right:5px">
                                    <img alt="Banking" src="{{env('APP_URL')}}/templates/home/images/dichvuthanhtoan.jpg">
                                  </div>
                                </td> 
                              </tr> 
                            </tbody>
                          </table> 
                        </td>
                      </tr>  
                    </tbody>
                  </table> 
                </td> 
              </tr> 
            </tbody>
          </table>
        </div>
        <div class="yj6qo"> 
        </div>
      </div>
    </div>
  </div>
</body>
</html>
