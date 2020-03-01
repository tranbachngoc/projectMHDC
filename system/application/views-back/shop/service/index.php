<?php $this->load->view('home/personal/affiliate/element/element-css-js')?>

<p class="f16 mb20 mt20">Dịch vụ azibai</p>
<div class="affiliate-content">
  <div class="affiliate-content-service">
    <div class="row">
      <?php if(isset($services) && !empty($services)) { ?>
        <?php foreach($services as $k => $sp): ?>
      <div class="col-xl-3 col-md-6">
        <div class="service-item">
          <div class="service-title">
            <a href="<?=azibai_url()?>/shop/service/detail/<?=$sp['id']?>">
              <img src="<?=$sp['sImage']?>" class="main-img" alt="">
            </a>
            <div class="tt one-line"><a href="<?=azibai_url()?>/shop/service/detail/<?=$sp['id']?>"><?php echo $sp['name']; ?></a></div>
            <!-- <a href="<?=azibai_url()?>/shop/service/detail/<?=$sp['id']?>" class="btn-detail">Chi tiết</a> -->
          </div>
          <div class="service-content">
            <table>
              <tr>
                <th>Số lượng</th>
                <td><?=$sp['limits']?></td>
              </tr>
              <tr>
                <th>Giá gốc</th>
                <td><?=number_format($sp['iPrice'], 0, ',', '.');?> VNĐ</td>
              </tr>
              <tr>
                <th>Giá giảm</th>
                <td><?=number_format($sp['iDiscountPrice'], 0, ',', '.');?> VNĐ</td>
              </tr>
            </table>
          </div>
        </div>
      </div>
        <?php endforeach; ?>
      <?php } ?>
    </div>

    <?=$pagination?>
  </div>
</div>