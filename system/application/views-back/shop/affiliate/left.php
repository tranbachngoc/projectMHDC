<form name="formfilter" action="/affiliate/<?php echo $actionForm ?>" method="POST" class="formfilter form-horizontal">
   <br> 
   <div class="form-group">
      <div class="col-xs-12"><input name="name" type="text" class="form-control" placeholder="Tìm kiếm theo tên" value="<?php echo $name ?>"></div>
   </div>
   <hr>
   <p><strong>Giá tiền (VNĐ)</strong></p>
   <div class="form-group">
      <div class="col-xs-6"><input name="price_form" type="number" class="form-control" placeholder="Giá từ" value="<?php echo $price_form ?>"></div>
      <div class="col-xs-6"><input name="price_to" type="number" class="form-control" placeholder="Giá đến" value="<?php echo $price_to ?>"></div>
   </div>
   <hr>
   <p><strong>Khuyến mãi</strong></p>
   <div class="radio"><label><input name="saleoff" <?php if($saleoff != '' && $saleoff == 0){ echo 'checked';} ?> value="0" type="radio" > Không khuyến mãi</label></div>
   <div class="radio"><label><input name="saleoff" <?php if($saleoff && $saleoff == 1){ echo 'checked';} ?> value="1" type="radio" > Có khuyến mãi</label></div>
   <hr>
   <p><strong>Thời gian bảo hành</strong></p>
   <div class="radio"> <label> <input name="baohanh" <?php if($baohanh != '' && $baohanh == 0){ echo 'checked';} ?> value="0" type="radio" > Không bảo hành </label> </div>
   <div class="radio"> <label> <input name="baohanh" <?php if($baohanh && $baohanh == 1){ echo 'checked';} ?> value="1" type="radio" > 1 Tháng - 3 Tháng </label> </div>
   <div class="radio"> <label> <input name="baohanh" <?php if($baohanh && $baohanh == 2){ echo 'checked';} ?> value="2" type="radio" > 4 Tháng - 6 Tháng </label> </div>
   <div class="radio"> <label> <input name="baohanh" <?php if($baohanh && $baohanh == 3){ echo 'checked';} ?> value="3" type="radio" > 7 Tháng - 9 Tháng </label> </div>
   <div class="radio"> <label> <input name="baohanh" <?php if($baohanh && $baohanh == 4){ echo 'checked';} ?> value="4" type="radio" > 10 Tháng - 12 Tháng </label> </div>
   <hr>
   <div class="form-group">
      <div class="col-xs-5" style="float: right;"><input name="search" type="submit" class="form-control btn-primary" value="Tìm kiếm"></div>
   </div>
</form>