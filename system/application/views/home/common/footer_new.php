<footer id="footer" class="footer-border-top">
      <div class="container footer">
        <ul class="footer-link">
          <li>
            <h3>HỖ TRỢ  KHÁCH HÀNG</h3>
            <p><a href="">Hướng dẫn mua hàng</a></p>
            <p><a href="">Hướng dẫn bán hàng</a></p>
            <p><a href="">Phương thức vận chuyển</a></p>
            <p><a href="">Hướng dẫn thanh toán</a></p>
            <p><a href="">Chính sách đổi trả & hoàn tiền</a></p>
            <p><a href="">Chính sách giải quyết khiếu nại</a></p>
            <p><a href="">Chính sách bảo mật thanh toán</a></p>
            <p><a href="">Các câu hỏi thường gặp</a></p>
          </li>
          <li>
            <h3>VỀ AZIBAI</h3>
            <p><a href="">Giới thiệu về azibai</a></p>
            <p><a href="">Tuyển dụng</a></p>
            <p><a href="">Điều khoản azibai</a></p>
            <p><a href="">Chính sách bảo mật</a></p>
            <p><a href="">Chính hãng</a></p>
            <p><a href="">Kênh người bán</a></p>
            <p><a href="">Fash sales</a></p>
          </li>
          <li>
            <h3>THANH TOÁN</h3>
            <h3 class="mt5pc md">ĐƠN VỊ VẬN CHUYỂN</h3>
          </li>
          <li class="sm"><h3>ĐƠN VỊ VẬN CHUYỂN</h3></li>
          <li>
            <h3>THEO DÕI CHÚNG TÔI TRÊN</h3>
            <p><a href=""><img src="/templates/home/images/svg/instagram.svg" width="24" class="mr05" alt="">facebook</a></p>
            <p><a href=""><img src="/templates/home/images/svg/instagram.svg" width="24" class="mr05" alt="">instagram</a></p>
          </li>
          <li>
            <h3>TẢI ỨNG DỤNG AZIBAI NGAY</h3>
            <div class="app-store">
              <p class="mb10"><img src="/templates/home/styles/images/cover/app_apple.png" alt=""></p>
              <p><img src="/templates/home/styles/images/cover/app_gg.png" alt=""></p>
            </div>
          </li>
        </ul>
        <div class="footer-link03">
          <p><img src="/templates/home/images/svg/bocongthuong.jpg" alt=""></p>
          <p>Công ty TNHH dịch vụ mọi người cùng vui</p>
          <p><strong>Trụ sở chính</strong>: 92 Trần Quốc Toản, Phường 8, Quận 3, Tp.HCM . Tổng đài: <?=settingPhone?>  - Email: <?=settingEmail_1?></p>
          <p>Mã số doanh nghiệp: 0314300068 do Sở Kế hoạch & Đầu tư Tp. Hồ Chí Minh cấp ngày 24/03/2017.</p>
          <p>© 2018 - Bản quyền thuộc về Công ty TNHH dịch vụ mọi người cùng vui</p>
        </div>
      </div>
    </footer>
  </div>
  <!-- <script src="asset/styles/js/common.js"></script> -->
  <script type="text/javascript">
     function readURL(input) {
	    if (input.files && input.files[0]) {
	        var reader = new FileReader();

	       $(this).toggleClass('acv');
	        reader.onload = function (e) {
	            $('#show-avata').attr('src', e.target.result);
	            $('#show-avata').attr('class', 'added');
	        };

	        reader.readAsDataURL(input.files[0]);
	    }
    }
  </script>
</body>
</html>