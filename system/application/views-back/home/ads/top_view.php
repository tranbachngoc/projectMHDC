<tr>
	<td>
    	<div class="temp_2">
        	<div class="title">
            	<div class="fl"></div>
                <div class="fc">
                	<h3><?php echo $this->lang->line('title_top_view_ads_right'); ?></h3>
                </div>
                <div class="fr"></div>
            </div>
            <div class="content">
            	<div class="list_link">
                	<ul>
                    	 <?php foreach($topViewAds as $topViewAdsArray){ ?>
                         	<li>
                            	<a class="menu_1" href="<?php echo base_url(); ?>ads/category/detail/<?php echo $topViewAdsArray->ads_category; ?>/<?php echo $topViewAdsArray->ads_id; ?>/<?php echo RemoveSign($topViewAdsArray->ads_title); ?>"  onmouseout="hideddrivetip();"><?php echo $topViewAdsArray->ads_title; ?></a>&nbsp;<span class="number_view">(<?php echo $topViewAdsArray->ads_view; ?>)</span>&nbsp;
                    <?php if($topViewAdsArray->ads_begindate >= mktime(0, 0, 0, date('m'), date('d'), date('Y'))){ ?>
                    <img alt="" src="<?php echo base_url(); ?>templates/home/images/icon_new.gif" height="14" border="0" />
                    <?php } ?>
                            </li>
                         <?php } ?>
                    </ul>
                </div>
            </div>
            <div class="clear"></div>
            <div class="bottom">
                <div class="fl"></div>
                <div class="fr"></div>
          </div>
        </div>
    </td>
</tr>