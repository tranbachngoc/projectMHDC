<?php if(count($topSaleoffShop) > 0){ ?>
<tr>
	<td>
    	<div class="temp_2">
        	<div class="title">
            <div class="fl"></div>
            <div class="fc">
              <h3><?php echo $this->lang->line('title_top_saleoff_shop_right'); ?></h3>
            </div>
            <div class="fr"></div>
          </div>
          <div class="content">
        	 <div class="list_link">
             <ul>
             	<?php foreach($topSaleoffShop as $topSaleoffShopArray){ ?>
                	<li>
                    	<a class="menu_1" href="<?php echo base_url(); ?><?php echo $topSaleoffShopArray->sho_link; ?>" <?php /*?>onmouseover="ddrivetip('<?php echo $topSaleoffShopArray->sho_descr; ?>',300,'#F0F8FF');"<?php */?> onmouseout="hideddrivetip();"><?php echo $topSaleoffShopArray->sho_name; ?></a>
						<?php if($topSaleoffShopArray->sho_begindate >= mktime(0, 0, 0, date('m'), date('d'), date('Y'))){ ?>
                        <img alt="" src="<?php echo base_url(); ?>templates/home/images/icon_new.gif" height="14" border="0" />
                        <?php } ?>
                    </li>
                <?php } ?>
             </ul>
             </div>
             <div class="view_all"><a href="<?php echo base_url() ?>shop/saleoff" class="text_link"><?php echo $this->lang->line('view_all_right'); ?></a></div>
        	<div class="clear"></div>
          </div>
          <div class="bottom">
            <div class="fl"></div>
            <div class="fr"></div>
          </div>
        </div>
    </td>
</tr>
<?php } ?>