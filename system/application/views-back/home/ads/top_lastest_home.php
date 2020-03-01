<tr>
	<td >

<div class="temp_2" style="width:180px;">
      <div class="title">
        <div class="fl"></div>
        <div class="fc">
          <h3>RAO VẶT MỚI NHẤT</h3>
        </div>
        <div class="fr"></div>
      </div>
      <div class="content">
        <div class="list_link">
          <ul>
            <?php foreach($topLastestAds as $topLastestAdsArray){ ?>
            <li>  <a class="menu_1" href="<?php echo base_url(); ?>ads/category/<?php echo $topLastestAdsArray->ads_category; ?>/detail/<?php echo $topLastestAdsArray->ads_id; ?>"  onmouseout="hideddrivetip();"><?php echo $topLastestAdsArray->ads_title; ?></a></li>
           
            <?php } ?>
          </ul>
        </div>
        <div class="view_all"><a href="<?php echo base_url(); ?>ads">Xem tất cả</a></div>
        <div class="clear"></div>
      </div>
      <div class="bottom">
        <div class="fl"></div>
        <div class="fr"></div>
      </div>
    </div>
    </td>
</tr>
