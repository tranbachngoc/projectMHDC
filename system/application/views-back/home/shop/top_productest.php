<tr>
	<td>
    	<div class="temp_2">
        	<div class="title">
            <div class="fl"></div>
            <div class="fc">
              <h3><?php echo $this->lang->line('title_top_productest_shop_right'); ?></h3>
            </div>
            <div class="fr"></div>
          </div>
          <div class="content">
          	<?php $idDiv = 1; ?>
			<?php foreach($topProductestShop as $topProductestShopArray){ ?>
            <div class="top_productest_shop" id="DivTopProductest_<?php echo $idDiv; ?>" <?php /*?>onmouseover="ChangeStyleBox('DivTopProductest_<?php echo $idDiv; ?>',1)"<?php */?> onmouseout="ChangeStyleBox('DivTopProductest_<?php echo $idDiv; ?>',2)">
                
                    <table align="center" width="59" cellpadding="0" cellspacing="0" style="height:50px">
                        <tr>
                            <td align="center"><div><a href="<?php echo base_url(); ?><?php echo $topProductestShopArray->sho_link; ?>" title="<?php echo $topProductestShopArray->sho_descr; ?>"><img alt="<?php echo $topProductestShopArray->sho_descr; ?>" src="<?php echo base_url(); ?>media/shop/logos/<?php echo $topProductestShopArray->sho_dir_logo; ?>/<?php echo $topProductestShopArray->sho_logo; ?>" class="image_top_productest_shop" /></a>
                            </div></td>
                        </tr>
                    </table>
                
            </div>
            <?php $idDiv++; ?>
            <?php } ?>
            <div style="clear:both;"></div>
          </div>
          <div class="bottom">
            <div class="fl"></div>
            <div class="fr"></div>
          </div>
        </div>
    </td>
</tr>