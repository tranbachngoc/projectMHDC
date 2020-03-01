<?php if(count($topShopAds) > 0){ ?>
<tr>
	<td>
    	<div class="temp_2">
        	<div class="title">
            	<div class="fl"></div>
                <div class="fc">
                	<h3><?php echo $this->lang->line('title_top_shop_ads_right'); ?></h3>
                </div>
                <div class="fr"></div>
            </div>
            <div class="content">
            	<div class="list_link">
                	<ul>
                    	 <?php foreach($topShopAds as $topShopAdsArray){ ?>
                         	<li>
                            	<a class="menu_1" href="<?php echo base_url(); ?>ads/category/detail/<?php echo $topShopAdsArray->ads_category; ?>/<?php echo $topShopAdsArray->ads_id; ?>/<?php echo RemoveSign($topShopAdsArray->ads_title); ?>"  onmouseout="hideddrivetip();"><?php echo $topShopAdsArray->ads_title; ?></a>
                            </li>
                         <?php } ?>
                    </ul>
                </div>
                <div class="view_all">
                    <a href="<?php echo base_url(); ?>ads/shop" class="text_link"><?php echo $this->lang->line('view_all_right'); ?></a>
                </div>
                <div class="clear"></div>
            </div>
            <div class="clear"></div>
            <div class="bottom">
                <div class="fl"></div>
                <div class="fr"></div>
          </div>
        </div>
    </td>
</tr>
<?php } ?>