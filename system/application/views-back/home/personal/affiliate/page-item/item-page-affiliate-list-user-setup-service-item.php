<div class="item">
  <div class="orders-detail">
    <div class="left">
      <div class="img">
        <img src="<?=$item['sImage']?>" alt="">
      </div>
      <div class="text">
        <h4 class="tt"><?=$item['name']?></h4>
        <?php if (!empty($item['iDiscountPrice'])) { ?>
        <p class="price-before">Giá gốc: &nbsp;
          <span><?=number_format($item['iPrice'], 0, ',', '.');?>
            <span class="f12">VNĐ</span>
          </span>
        </p>
        <p class="price-after">Giá giảm: &nbsp;
          <span class="price"><?=number_format($item['iDiscountPrice'], 0, ',', '.');?>
            <span class="f12">VNĐ</span>
          </span>
        </p>
        <?php } else { ?>
        <p class="price-after">Giá gốc: &nbsp;
          <span><?=number_format($item['iPrice'], 0, ',', '.');?> 
            <span class="f12">VNĐ</span>
          </span>
        </p>
        <?php } ?>
        <p>Hoa hồng: &nbsp;
          <span class="text-red text-bold f16"><?=$item['iDiscountPercen']?> <span class="f12">%</span></span>
        </p>
        <?php if($_REQUEST['type_sv'] == 1) { ?>
        <div class="setting">
          <a href="javascript:void(0)" title="Cài đặt"
            class="js-setup-service"
            data-user="<?=$id?>"
            data-id="<?=$item['id'];?>">
            <img src="/templates/home/styles/images/svg/settings.svg" alt="">
          </a>
        </div>
        <?php } ?>
      </div>
    </div>
  </div>
</div>