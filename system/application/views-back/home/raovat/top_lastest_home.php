<tr>
	<td >

<div class="temp_2" style="width:180px;">
      <div class="title">
        <div class="fl"></div>
        <div class="fc">
          <h3><a href="<?php echo base_url(); ?>raovat">RAO VẶT MỚI NHẤT</a></h3>
        </div>
        <div class="fr"></div>
      </div>
      <div class="content">
        <div class="list_link">
          <ul>
            <?php foreach($topLastestAds as $topLastestAdsArray){ ?>
            <li>  <a class="menu_1" href="<?php echo base_url(); ?>raovat/<?php echo $topLastestAdsArray->ads_category; ?>/<?php echo $topLastestAdsArray->ads_id; ?>/<?php echo RemoveSign($topLastestAdsArray->ads_title); ?>"  onmouseout="hideddrivetip();"><?php echo cut_string_unicodeutf8($topLastestAdsArray->ads_title,40); ?></a></li>
           
            <?php } ?>
          </ul>
        </div>
        <div class="view_all"><a href="<?php echo base_url(); ?>raovat">Xem tất cả</a></div>
        <div class="clear"></div>
      </div>
      <div class="bottom">
        <div class="fl"></div>
        <div class="fr"></div>
      </div>
    </div>
    </td>
</tr>
