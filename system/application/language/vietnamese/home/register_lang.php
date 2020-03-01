<?php
#****************************************#
# * @Author: lehieu008                   #
# * @Email: lehieu008@gmail.com          #
# * @Website: http://www.iscvietnam.net  #
# * @Copyright: 2008 - 2009              #
#****************************************#
#BEGIN: Defaults
$lang['title_defaults'] = 'ĐĂNG KÝ';
$lang['username_defaults'] = 'Tài khoản';
$lang['password_defaults'] = 'Mật khẩu';
$lang['repassword_defaults'] = 'Nhập lại mật khẩu';
$lang['email_defaults'] = 'Email';
$lang['reemail_defaults'] = 'Nhập lại Email';
$lang['fullname_defaults'] = 'Họ tên';
$lang['bran_user'] = 'Thuộc chi nhánh';
$lang['staff_user'] = 'Thuộc nhân viên';
$lang['store_user'] = 'Thuộc gian hàng';
$lang['staffstore_user'] = 'Thuộc nhân viên GH';
$lang['doanhthu_user'] = 'Doanh thu';
$lang['birthday_defaults'] = 'Ngày sinh';
$lang['sex_defaults'] = 'Giới tính';
$lang['address_defaults'] = 'Địa chỉ';
$lang['province_defaults'] = 'Tỉnh / Thành phố';
$lang['phone_defaults'] = 'Điện thoại';
$lang['yahoo_defaults'] = 'Nick Yahoo';
$lang['skype_defaults'] = 'Nick Skype';
$lang['avatar_defaults'] = 'Avatar/Logo';
$lang['regis_vip_defaults'] = 'Đăng ký thành viên VIP';
$lang['regis_shop_defaults'] = 'Đăng ký gian hàng';
$lang['button_register_defaults'] = 'Đăng ký';
$lang['button_reset_defaults'] = 'Làm lại';
$lang['male_defaults'] = 'Nam';
$lang['female_defaults'] = 'Nữ';
$lang['stop_regis_defaults'] = '<font color="#FF0000">Website tạm ngưng đăng ký thành viên</font>';
$lang['guide_regis_vip_defaults'] = 'Tài khoản <font color="#FF0000"><b>VIP</b></font> của bạn sau khi đăng ký <font color="#0099FF"><b><i>chưa được phép sử dụng</i></b></font>. Để kích hoạt tài khoản <font color="#FF0000"><b>VIP</b></font> bạn vui lòng <a class="menu_1" href="./contact" alt="Liên hệ" target="_blank" style="font-weight:bold;">liên hệ</a> với chúng tôi để được hướng dẫn cụ thể.
									<p><b>Chi phí di trì tài khoản <font color="#FF0000"><b>VIP</b></font>:</b></p>
									<blockquote>
										<b>&bull;</b> 50.000 VNĐ/1 tháng.<br/>
										<b>&bull;</b> 200.000 VNĐ/6 tháng.<br/>
										<b>&bull;</b> 300.000 VNĐ/1 năm.
									</blockquote>
									<b>Mọi chi tiết bạn có thể <a class="menu_1" href="./contact" target="_blank" alt="Liên hệ" style="font-weight:bold;">liên hệ</a> với chúng tôi theo:</b>
									<blockquote>
										<b>&bull; Điện thoại:</b> '.settingPhone.'<br/>
										<b><i>&bull; Hotline:</i></b> '.settingMobile.'<br/>
										<b>&bull; Email:</b> <a class="menu_1" href="mailto:'.settingEmail_1.'">'.settingEmail_1.'</a><br/>
										<b>&bull; Nick Yahoo:</b> <a class="menu_1" href="ymsgr:SendIM?'.settingYahoo_1.'">'.settingYahoo_1.'</a>
									</blockquote>
									<i>(Hình thức thanh toán: thanh toán chuyển khoản qua ngân hàng)</i>';
$lang['guide_regis_shop_defaults'] = 'Tài khoản <font color="#FF0000"><b>gian hàng ảo</b></font> của bạn sau khi đăng ký <font color="#0099FF"><b><i>chưa được phép sử dụng</i></b></font>. Để kích hoạt tài khoản <font color="#FF0000"><b>gian hàng ảo</b></font> bạn vui lòng thực hiện 1 trong 2 cách sau:
									<p><b>&diams; Cách 1:</b></p>
									<blockquote>
										1. Cung cấp thông tin gian hàng theo mẫu (<a class="menu_1" href="'.base_url().'templates/guide/data/maucungcapthongtin.doc" style="font-weight:bold;" target="_blank" alt="Tải mẫu cung cấp thông tin">Tải tại đây</a>).<br/>
										2. Gởi mẫu thông tin gian hàng tới Email <a class="menu_1" href="mailto:info@azibai.com" style="font-weight:bold;">info@azibai.com</a>.<br/>
										3. Gởi kèm theo logo, banner (nếu có).
									</blockquote>
									<p><b>&diams; Cách 2:</b></p>
									<blockquote>
										Cung cấp thông tin gian hàng qua Yahoo Chat <a class="menu_1" href="ymsgr:SendIM?'.settingYahoo_1.'" style="font-weight:bold;" alt="'.settingYahoo_1.'">'.settingYahoo_1.'</a> với các thông tin sau: <b><i>tên tài khoản, Tên công ty, địa chỉ gian hàng, điện thoại, danh mục gian hàng</i></b>.
									</blockquote>
									<i>Chúng tôi sẽ setup <font color="#FF0000"><b>gian hàng ảo</b></font> trong vòng 24 giờ (trừ thứ bảy và chủ nhật) sau khi tiếp nhận đầy đủ thông tin gian hàng theo yêu cầu. Bạn có thể chỉnh sửa thông tin <font color="#FF0000"><b>gian hàng ảo</b></font> qua chức năng quản lý của website.</i>';
$lang['title_role_normal_defaults'] = 'Quy định đối với thành viên';
$lang['title_role_vip_defaults'] = 'Quy định và quyền lợi của thành viên VIP';
$lang['title_role_saler_defaults'] = 'Quy định và quyền lợi khi đăng ký gian hàng';
$lang['role_normal_defaults'] = '<b><i>Khi bạn trở thành thành viên của <a class="menu" href="http://www.azibai.com">azibai.com</a> bạn cần tuân theo những quy định sau:</i></b>
                                <p><b>A. Những quy định về việc đăng ký và quản lý tài  khoản:</b></p>
                                    <ol>
                                        <li>Tài  khoản đăng ký, thông tin cá nhân của bạn phải hợp lệ (không được dùng các từ ngữ  thô tục, kém văn hóa, gây ảnh hưởng xấu đến <a class="menu" href="http://www.azibai.com">azibai.com</a>, xúc phạm đến người  khác, vi phạm pháp luật…).</li>
                                        <li>Thành  viên sau khi đăng ký phải có trách nhiệm tự quản lý tài khoản và mật khẩu. Nếu  thành viên không quản lý tốt để người thứ ba lấy được tài khoản, chúng tôi sẽ không chịu trách nhiệm về bất cứ những tổn thất phát sinh  do việc để mất tài khoản  gây ra.Trong trường hợp mất  tài khoản, bạn phải báo với chúng tôi để được giải quyết kịp thời.</li>
                                        <li>Nếu  bạn quên mật khẩu bạn có thể <a class="menu" href="./contact">liên hệ</a> với bộ phận kỹ thuật để được giải quyết cấp  mới mật khẩu. Trong trường hợp bạn quên cả tên tài khoản lẫn mật khẩu, chúng  tôi sẽ căn cứ vào những thông tin mà bạn cung cấp có phù hợp với thông tin mà bạn  đã đăng ký trên <a class="menu" href="http://www.azibai.com">azibai.com</a> hay không.</li>
                                        <li>Nếu  tài khoản của bạn không hoạt động trong một khoản thời gian nhất định chúng tôi  sẽ xóa tài khoản của bạn mà không cần báo trước.</li>
                                        <li>Thông  tin các bạn đăng ký trên <a class="menu" href="http://www.azibai.com">azibai.com</a> thuộc quyền sở hữu của <a class="menu" href="http://www.azibai.com">azibai.com</a>.  Chúng tôi có quyền sử dụng những thông tin của bạn khi cần thiết.</li>
                                        <li>Trong  trường hợp bạn không muốn sử dụng tài khoản của mình nữa, bạn có thể <a class="menu" href="./contact">liên hệ</a> với  chúng tôi để chúng tôi hủy bỏ tài khoản của bạn.</li>
                                    </ol>
                                <p><b>B. Những quy định khi tham gia vào <a class="menu" href="http://www.azibai.com">azibai.com</a>:</b></p>
                                    <ol>
                                        <li>Tài  khoản của bạn được phép đăng tin rao vặt, đăng tin tuyển dụng, đăng tin tìm việc  (không được phép đăng sản phẩm).</li>
                                        <li>Những  tin đăng không đúng sự thật, không đúng quy định (thông tin cung cấp quá ít, nội  dung không rõ ràng, sử dụng từ ngữ kém văn hóa, vi phạm pháp luật…) sẽ bị xóa  mà không cần báo trước.</li>
                                        <li>Tất  cả các thành viên của <a class="menu" href="http://www.azibai.com">azibai.com</a> đều được chúng tôi trợ giúp khi có yêu cầu.</li>
                                        <li>Các  thành viên không được phép sử dụng <a class="menu" href="http://www.azibai.com">azibai.com</a> sai mục đích, không được lợi  dụng vào <a class="menu" href="http://www.azibai.com">azibai.com</a> để lừa đảo, thực hiện những hành vi vi phạm pháp luật,  gây tổn hại đến cá nhân hoặc công ty khác.</li>
                                        <li>Các  thành viên không được gây tổn hại đến <a class="menu" href="http://www.azibai.com">azibai.com</a>, thực hiện những hành vi để  làm giảm uy tín của <a class="menu" href="http://www.azibai.com">azibai.com</a>.</li>
                                        <li>Trong  trường hợp có tranh chấp, khiếu nại các thành viên có thể <a class="menu" href="./contact">liên hệ</a> với chúng tôi  để được giải quyết thích đáng. Trong trường hợp chúng tôi không thể giải quyết  được thì chúng tôi sẽ đưa ra pháp luật để giải quyết.</li>
                                        <li>Chúng  tôi có toàn quyền quyết định để xử lý các thành viên nếu vi phạm những quy định  trên.</li>
                                    </ol>';
$lang['role_vip_defaults'] = '<b><i>Những quy định và quyền lợi của bạn khi bạn đăng ký thành viên VIP trên <a class="menu" href="http://www.azibai.com">azibai.com</a>:</i></b>
                              <p><b>A. Những quy định về việc đăng ký và quản lý  tài khoản:</b></p>
                                    <ol>
                                        <li>Tài  khoản của bạn sau khi đăng ký chưa sử dụng được, để sử dụng tài khoản này bạn  vui lòng <a class="menu" href="./contact">liên hệ</a> với chúng tôi để được hướng dẫn chi tiết.</li>
                                        <li>Nếu  quá thời hạn 7 ngày sau khi đăng ký mà bạn không <a class="menu" href="./contact">liên hệ</a> với chúng tôi thì  chúng tôi sẽ xóa tài khoản này.</li>
                                        <li>Tài  khoản đăng ký, thông tin cá nhân của bạn phải hợp lệ (không được dùng các từ ngữ  thô tục, kém văn hóa, gây ảnh hưởng xấu đến <a class="menu" href="http://www.azibai.com">azibai.com</a>, xúc phạm đến người  khác, vi phạm pháp luật…).</li>
                                        <li>Thành  viên sau khi đăng ký phải có trách nhiệm tự quản lý tài khoản và mật khẩu. Nếu  thành viên không quản lý tốt để người thứ ba lấy được tài khoản, chúng tôi sẽ không chịu trách nhiệm về bất cứ những tổn thất phát sinh  do việc để mất tài khoản  gây ra.Trong trường hợp mất  tài khoản, bạn phải báo với chúng tôi để được giải quyết kịp thời.</li>
                                        <li>Nếu  bạn quên mật khẩu bạn có thể <a class="menu" href="./contact">liên hệ</a> với bộ phận kỹ thuật để được giải quyết cấp  mới mật khẩu. Trong trường hợp bạn quên cả tên tài khoản lẫn mật khẩu, chúng  tôi sẽ căn cứ vào những thông tin mà bạn cung cấp có phù hợp với thông tin mà bạn  đã đăng ký trên <a class="menu" href="http://www.azibai.com">azibai.com</a> hay không.</li>
                                        <li>Nếu  tài khoản của bạn hết thời hạn sử dụng chúng tôi sẽ khóa tài khoản của bạn . Nếu  bạn muốn sử dụng tiếp tài khoản của mình, bạn có thể <a class="menu" href="./contact">liên hệ</a> với chúng tôi để  được hướng dẫn.</li>
                                        <li>Những  thông tin của bạn sẽ được bảo mật và chúng tôi sẽ không sử dụng những thông tin  đó khi không được sự cho phép của bạn.</li>
                                        <li>Trong  trường hợp bạn không muốn sử dụng tài khoản của mình nữa, bạn có thể <a class="menu" href="./contact">liên hệ</a> với  chúng tôi để chúng tôi hủy bỏ tài khoản của bạn.</li>
                                    </ol>
                              <p><b>B. Những quy định khi tham gia vào  <a class="menu" href="http://www.azibai.com">azibai.com</a>:</b></p>
                                    <ol>
                                        <li>Tài  khoản của bạn được phép đăng sản phẩm, đăng tin rao vặt, đăng tin tuyển dụng,  đăng tin tìm việc.</li>
                                        <li>Những  tin đăng không đúng sự thật, không đúng quy định (thông tin cung cấp quá ít, nội  dung không rõ ràng, sử dụng từ ngữ kém văn hóa, vi phạm pháp luật…) sẽ bị xóa  mà không cần báo trước.</li>
                                        <li>Các  thành viên không được phép sử dụng <a class="menu" href="http://www.azibai.com">azibai.com</a> sai mục đích, không được lợi  dụng vào <a class="menu" href="http://www.azibai.com">azibai.com</a> để lừa đảo, thực hiện những hành vi vi phạm pháp luật,  gây tổn hại đến cá nhân hoặc công ty   khác.</li>
                                        <li>Các  thành viên không được gây tổn hại đến <a class="menu" href="http://www.azibai.com">azibai.com</a>, thực hiện những hành vi để  làm giảm uy tín của <a class="menu" href="http://www.azibai.com">azibai.com</a>.</li>
                                        <li>Trong  trường hợp có tranh chấp, khiếu nại các thành viên có thể <a class="menu" href="./contact">liên hệ</a> với chúng tôi  để được giải quyết thích đáng. Trong trường hợp chúng tôi không thể giải quyết  được thì chúng tôi sẽ đưa ra pháp luật để giải quyết.</li>
                                        <li>Chúng  tôi có toàn quyền quyết định để xử lý các thành viên nếu vi phạm những quy định  trên.</li>
                                    </ol>
                              <p><b>C. Những quyền lợi của thành viên VIP:</b></p>
                                    <ol>
                                        <li>Bạn  có quyền đăng sản phẩm, đăng tin rao vặt, đăng tin tuyển dụng, đăng tin tìm việc  trên <a class="menu" href="http://www.azibai.com">azibai.com</a>.</li>
                                        <li>Hệ  thống quản lý tài khoản của bạn được cung cấp thêm hai chức năng là quản lý sản  phẩm và quản lý khách mua hàng.</li>
                                        <li>Những sản phẩm, tin đăng của bạn sẽ được ưu tiên đưa lên hàng đầu.</li>
                                        <li>Những sản phẩm, tin đăng của bạn sẽ được <a class="menu" href="http://www.azibai.com">azibai.com</a> ưu tiên giới thiệu với khách  hàng.</li>
                                        <li>Tất  cả các thành viên VIP của <a class="menu" href="http://www.azibai.com">azibai.com</a> đều được chúng tôi ưu tiên trợ giúp  khi có yêu cầu.</li>
                                    </ol>
                              <p><b>D. Chi phí di trì tài khoản VIP trên  <a class="menu" href="http://www.azibai.com">azibai.com</a>:</b></p>
                              <blockquote>
                                    <font color="#004B7A">* 50.000  VNĐ/1 tháng.</font><br />
                                    <font color="#004B7A">* 200.000  VNĐ/6 tháng.</font><br />
                                    <font color="#004B7A">* 300.000  VNĐ/1 năm.</font><br />
                                    <font color="#004B7A" size="1"><i>(Đăng ký tối  thiểu 1 tháng)</i></font><br />
                              </blockquote>
                                    &nbsp;&nbsp;&nbsp;<font color="#FF0000">Mọi chi tiết  bạn có thể <a class="menu" href="./contact">liên hệ</a> với chúng tôi theo:</font><br />
                              <blockquote>
									<img src="'.base_url().'templates/home/images/phone_1.gif" border="0"/>&nbsp;<font color="#004B7A"><b>Điện thoại:</b> '.settingPhone.'</font><br/>
									<img src="'.base_url().'templates/home/images/mobile_1.gif" border="0"/>&nbsp;<font color="#004B7A"><b><i>Hotline:</i></b> '.settingMobile.'</font><br/>
                                    <a class="menu" href="mailto:'.settingEmail_1.'"><img src="'.base_url().'templates/home/images/mail.gif" border="0"/>&nbsp;'.settingEmail_1.'</a><br />
                                    <a class="menu" href="ymsgr:SendIM?'.settingYahoo_1.'"><img src="'.base_url().'templates/home/images/yahoo.gif" border="0"/>&nbsp;'.settingYahoo_1.'</a>
                              </blockquote>';
$lang['role_saler_defaults'] = '<b><i>Những quy định và quyền lợi của bạn khi bạn đăng ký gian hàng trên <a class="menu" href="http://www.azibai.com">azibai.com</a>:</i></b>
                                <p><b>A. Những quy định về việc đăng ký và quản lý  tài khoản:</b></p>
                                    <ol>
                                        <li>Tài  khoản của bạn sau khi đăng ký chưa sử dụng được, để sử dụng tài khoản này bạn  vui lòng <a class="menu" href="./contact">liên hệ</a> với chúng tôi để được hướng dẫn chi tiết.</li>
                                        <li>Nếu  quá thời hạn 7 ngày sau khi đăng ký mà bạn không <a class="menu" href="./contact">liên hệ</a> với chúng tôi thì  chúng tôi sẽ xóa tài khoản này.</li>
                                        <li>Tài  khoản đăng ký, thông tin cá nhân của bạn phải hợp lệ (không được dùng các từ ngữ  thô tục, kém văn hóa, gây ảnh hưởng xấu đến <a class="menu" href="http://www.azibai.com">azibai.com</a>, xúc phạm đến người  khác, vi phạm pháp luật…).</li>
                                        <li>Thành  viên sau khi đăng ký phải có trách nhiệm tự quản lý tài khoản và mật khẩu. Nếu  thành viên không quản lý tốt để người thứ ba lấy được tài khoản, chúng tôi sẽ không chịu trách nhiệm về bất cứ những tổn thất phát sinh  do việc để mất tài khoản  gây ra.Trong trường hợp mất  tài khoản, bạn phải báo với chúng tôi để được giải quyết kịp thời.</li>
                                        <li>Nếu  bạn quên mật khẩu bạn có thể <a class="menu" href="./contact">liên hệ</a> với bộ phận kỹ thuật để được giải quyết cấp  mới mật khẩu. Trong trường hợp bạn quên cả tên tài khoản lẫn mật khẩu, chúng  tôi sẽ căn cứ vào những thông tin mà bạn cung cấp có phù hợp với thông tin mà bạn  đã đăng ký trên <a class="menu" href="http://www.azibai.com">azibai.com</a> hay không.</li>
                                        <li>Nếu  tài khoản của bạn hết thời hạn sử dụng chúng tôi sẽ khóa tài khoản và gian hàng  của bạn. Nếu bạn muốn sử dụng tiếp tài khoản của mình, bạn có thể <a class="menu" href="./contact">liên hệ</a> với  chúng tôi để được hướng dẫn.</li>
                                        <li>Những  thông tin của bạn sẽ được bảo mật và chúng tôi sẽ không sử dụng những thông tin  đó khi không được sự cho phép của bạn.</li>
                                        <li>Trong  trường hợp bạn không muốn sử dụng tài khoản của mình nữa, bạn có thể <a class="menu" href="./contact">liên hệ</a> với  chúng tôi để chúng tôi hủy bỏ tài khoản của bạn.</li>
                                    </ol>
                                <p><b>B. Những quy định khi tham gia vào  <a class="menu" href="http://www.azibai.com">azibai.com</a>:</b></p>
                                    <ol>
                                        <li>Tài  khoản của bạn được phép đăng sản phẩm, đăng tin rao vặt, đăng tin tuyển dụng,  đăng tin tìm việc.</li>
                                        <li>Những  tin đăng không đúng sự thật, không đúng quy định (thông tin cung cấp quá ít, nội  dung không rõ ràng, sử dụng từ ngữ kém văn hóa, vi phạm pháp luật…) sẽ bị xóa  mà không cần báo trước.</li>
                                        <li>Các  gian hàng không được phép sử dụng <a class="menu" href="http://www.azibai.com">azibai.com</a> sai mục đích, không được lợi dụng  vào <a class="menu" href="http://www.azibai.com">azibai.com</a> để lừa đảo, thực hiện những hành vi vi phạm pháp luật, gây tổn  hại đến cá nhân, gian hàng hoặc công ty   khác.</li>
                                        <li>Các  gian hàng không được gây tổn hại đến <a class="menu" href="http://www.azibai.com">azibai.com</a>, thực hiện những hành vi để  làm giảm uy tín của <a class="menu" href="http://www.azibai.com">azibai.com</a>.</li>
                                        <li>Trong  trường hợp có tranh chấp, khiếu nại các chủ gian hàng có thể <a class="menu" href="./contact">liên hệ</a> với chúng  tôi để được giải quyết thích đáng. Trong trường hợp chúng tôi không thể giải quyết được thì chúng tôi sẽ đưa ra pháp luật để giải quyết.</li>
                                        <li>Chúng  tôi có toàn quyền quyết định để xử lý các gian hàng nếu vi phạm những quy định  trên.</li>
                                    </ol>
                                <p><b>C. Những quy định khi mở gian hàng trên <a class="menu" href="http://www.azibai.com">azibai.com</a>:</b></p>
                                    <ol>
                                        <li>Bạn  phải cung cấp đây đủ thông tin mà chúng tôi yêu cầu (Tên công ty, địa chỉ, điện  thoại, logo…).</li>
                                        <li>Thông  tin về gian hàng của bạn phải chính xác, đúng sự thật.</li>
                                        <li>Cửa  hàng của bạn vẫn còn đang hoạt động đúng pháp luật.</li>
                                        <li>Những  sản phẩm, tin đăng của bạn phải chính xác, đảm bảo chất lượng.</li>
                                        <li>Bạn  nên tuân theo một số quy ước khi đăng sản phẩm, tin rao vặt mà chúng tôi cung cấp  để đảm bảo sản phẩm, tin rao vặt của bạn hiển thị tốt trên <a class="menu" href="http://www.azibai.com">azibai.com</a>.</li>
                                        <li>Số  lượng sản phẩm của gian hàng trên <a class="menu" href="http://www.azibai.com">azibai.com</a> phải trên 12 sản phẩm.</li>
                                        <li>Nếu có sự thay đổi về thông tin sản  phẩm, các gian hàng phải kịp thời thay đổi để cho phù hợp với khả năng cung cấp sản phẩm  dịch vụ thực tế.</li>
                                        <li>Trong trường hợp gian hàng đăng sản phẩm mới, thì phải đảm bảo sản  phẩm của mình đăng là  mới 100% (sản phẩm chưa sử dụng, vẫn còn thời gian bảo hành nếu  có… ).</li>
                                        <li>gian hàng chỉ nên đăng những sản phẩm có thể gởi cho khách hàng trong thời  gian 7 ngày khi có khách hàng yêu cầu.</li>
                                        <li>gian hàng phải có trách nhiệm làm đúng những gì đã cam kết với khách hàng.  Nếu khách hàng có khiếu nại về chất lượng, giá cả… của sản phẩm mà khách hàng  đã mua ở gian hàng và chứng minh được đó là đúng sự thật thì gian hàng phải có  trách nhiệm bồi thường cho khách hàng. Nếu gian hàng không thực hiện đúng quy định  thì khách hàng có quyền khiếu nại với cơ quan chức năng có thẩm quyền và <a class="menu" href="http://www.azibai.com">azibai.com</a> sẽ không bảo trợ cho  gian hàng.</li>
                                        <li>Nếu gian hàng vi phạm những quy định trên thì chúng tôi sẽ xóa gian hàng  mà không cần chịu bất cứ trách nhiệm, hay tổn thất nào của gian hàng.</li>
                                    </ol>
                                <p><b>D. Những quyền lợi khi mở gian hàng trên <a class="menu" href="http://www.azibai.com">azibai.com</a>:</b></p>
                                    <ol>
                                        <li>Bạn  sẽ được khởi tạo một gian hàng dành riêng cho bạn.</li>
                                        <li>Hệ  thống quản lý của bạn được cung cấp đầy đủ các chức năng quản lý.</li>
                                        <li>Những  sản phẩm, tin đăng của bạn sẽ được ưu tiên đưa lên hàng đầu và được đưa vào mục <font color="#004B7A">sản phẩm tin cậy</font>, <font color="#004B7A">rao vặt tin cậy</font>.</li>
                                        <li>Những  sản phẩm, tin đăng của bạn sẽ được <a class="menu" href="http://www.azibai.com">azibai.com</a> ưu tiên giới thiệu với khách  hàng.</li>
                                        <li>gian hàng của bạn sẽ được đặt logo của gian hàng và được quảng cáo trên <a class="menu" href="http://www.azibai.com">azibai.com</a>.</li>
                                        <li>Tất  cả các gian hàng trên <a class="menu" href="http://www.azibai.com">azibai.com</a> đều được chúng tôi ưu tiên trợ giúp khi có  yêu cầu.</li>
                                    </ol>
                                <p><b>E. Chi phí di trì gian hàng trên  <a class="menu" href="http://www.azibai.com">azibai.com</a>:</b></p>
                                    <blockquote>
										<font color="#004B7A">* 300.000 VNĐ/3  tháng.</font><br />
                                        <font color="#004B7A">* 500.000 VNĐ/6  tháng.</font><br />
                                        <font color="#004B7A">* 900.000  VNĐ/1 năm.</font><br />
                                        <font color="#004B7A" size="1"><i>(Đăng ký tối thiểu 3 tháng)</i></font><br />
                                    </blockquote>
                                    &nbsp;&nbsp;&nbsp;<font color="#FF0000">Mọi chi tiết  bạn có thể <a class="menu" href="./contact">liên hệ</a> với chúng tôi theo:</font><br />
                                    <blockquote>
                                        <img src="'.base_url().'templates/home/images/phone_1.gif" border="0"/>&nbsp;<font color="#004B7A"><b>Điện thoại:</b> '.settingPhone.'</font><br/>
										<img src="'.base_url().'templates/home/images/mobile_1.gif" border="0"/>&nbsp;<font color="#004B7A"><b><i>Hotline:</i></b> '.settingMobile.'</font><br/>
										<a class="menu" href="mailto:'.settingEmail_1.'"><img src="'.base_url().'templates/home/images/mail.gif" border="0"/>&nbsp;'.settingEmail_1.'</a><br />
										<a class="menu" href="ymsgr:SendIM?'.settingYahoo_1.'"><img src="'.base_url().'templates/home/images/yahoo.gif" border="0"/>&nbsp;'.settingYahoo_1.'</a>
                                    </blockquote>';
$lang['username_regis_label_defaults'] = 'Tài khoản';
$lang['password_regis_label_defaults'] = 'Mật khẩu';
$lang['repassword_regis_label_defaults'] = 'Mật khẩu xác nhận';
$lang['email_regis_label_defaults'] = 'Email';
$lang['reemail_regis_label_defaults'] = 'Email xác nhận';
$lang['fullname_regis_label_defaults'] = 'Họ tên';
$lang['address_regis_label_defaults'] = 'Địa chỉ';
$lang['province_regis_label_defaults'] = 'Tỉnh / Thành phố';
$lang['phone_regis_label_defaults'] = 'Điện thoại';
$lang['mobile_regis_label_defaults'] = 'Điện thoại thứ 2';
$lang['yahoo_regis_label_defaults'] = 'Nick Yahoo';
$lang['skype_regis_label_defaults'] = 'Nick Skype';
$lang['captcha_regis_label_defaults'] = 'Mã xác nhận';
$lang['_exist_username_message_defaults'] = 'Tài khoản này đã được sử dụng';
$lang['_exist_email_message_defaults'] = 'Email này đã được sử dụng';
$lang['_valid_captcha_message_defaults'] = '%s không đúng';
$lang['useragent_defaults'] = 'azibai.com';
$lang['subject_send_mail_defaults'] = 'Kích hoạt tài khoản tại azibai.com';
$lang['welcome_site_defaults'] = 'Bạn đã đăng ký thành viên của <a href="'.base_url().'" title="'.base_url().'">'.base_url().'</a> thành công<br/><br/>';
$lang['mail_activation_defaults'] = '<br/><br/>Nếu bạn muốn liên hệ với chúng tôi xin bạn đừng trả lời lại theo email này!<br/>
Để biết thêm thông tin, xin hãy liên hệ với chúng tôi theo thông tin dưới đây:<br/>
<div style="text-align:center;"><b>CÔNG TY TNHH DỊCH VỤ MỌI NGƯỜI CÙNG VUI</b><br/>
Địa chỉ: Số 262 Huỳnh Văn Bánh, Phường 11, Quận Phú Nhuận, Tp.HCM.<br/>
Điện thoại: (08) 667. 55241<br/>
Email: info@azibai.com </div>';
$lang['success_register_defaults'] = 'Chúc mừng bạn đã là thành viên của azibai.com!<br/>
';
$lang['success_register_defaults_request_member'] = 'Bạn đã yêu cầu tạo thành viên thành công. Thành viên bạn yêu cầu sẽ được chúng tôi xem xét kích hoạt sớm!<br/><br/>
';
$lang['success_register_not_send_activation_defaults'] = '<font color="#FF0000">Email kích hoạt tài khoản không thể gởi tới Email mà bạn đã đăng ký</font>. Bạn vui lòng liên hệ với chúng tôi để được hỗ trợ.';

$lang['success_register_not_send_activation_defaults_request_member'] = '<font color="#FF0000">Một email chứa thông tin tài khoản thành viên bạn yêu cầu đã được gửi tới email của bạn và email của thành viên</font>. Bạn vui lòng chờ chúng tôi xác nhận kích hoạt tài khoản. Sau khi kích hoạt thành công, chúng tôi sẽ email cho bạn và thành viên.';

$lang['success_register_success_send_activation_defaults'] = '
Bạn vui lòng kiểm tra email bạn vừa đăng ký để kích hoạt tài khoản và sử dụng các dịch vụ của chúng tôi.
<br/>
Lưu ý: Email kích hoạt có thể rơi vào bulk hoặc spam mail.<br/>
Nếu bạn có gì cần hỗ trợ hãy liên lạc với chúng tôi qua Email: support@azibai.com hoặc <a href="'.base_url().'help">xem tại đây</a>! Xin cảm ơn.';
$lang['success_normal_defaults'] = 'Nếu bạn đăng ký tài khoản bình thường, ngay bây giờ bạn có thể sử dụng tài khoản của mình trên <a class="menu" href="'.base_url().'" alt="'.base_url().'">azibai.com</a>.';
#END Defaults
#BEGIN: Activation
$lang['title_activation'] = 'KÍCH HOẠT TÀI KHOẢN';
$lang['success_activation'] = 'Tài khoản của bạn đã được kích hoạt thành công.<br/>Ngay bây giờ bạn có thể sử dụng tài khoản của bạn trên <a class="menu" href="'.base_url().'">azibai.com</a>. Mọi thắc mắc bạn có thể liên hệ với chúng tôi để được hỗ trợ.';
$lang['vip_or_saler_activation'] = 'Tài khoản của bạn đã được kích hoạt thành công, bây giờ bạn có thể đăng nhập vào hệ thống. Cảm ơn!';
$lang['error_activation'] = '<font color="#FF0000">Thông tin kích hoạt tài khoản không đúng.</font><br/>Bạn vui lòng thử lại hoặc liên hệ với chúng tôi để được hỗ trợ.';
#END Activation
