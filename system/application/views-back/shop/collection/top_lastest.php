<tr>
	<td>
    	<div class="temp_2">
        	<div class="title">
            <div class="fl"></div>
            <div class="fc">
              <h3><?php echo $this->lang->line('title_top_lastest_shop_right'); ?></h3>
            </div>
            <div class="fr"></div>
          </div>
          <div class="content">
        	 <div class="list_link">
             <ul>
             	<?php foreach($topLastestShop as $topLastestShopArray){ ?>
                	<li>
                    	<a class="menu_1" href="<?php echo base_url(); ?><?php echo $topLastestShopArray->sho_link; ?>" <?php /*?>onmouseover="ddrivetip('<?php echo $topLastestShopArray->sho_descr; ?>',300,'#F0F8FF');" <?php */?>onmouseout="hideddrivetip();"><?php echo $topLastestShopArray->sho_name; ?></a>
                    </li>
                <?php } ?>
             </ul>
             </div>
             <div class="view_all"><a href="<?php echo base_url() ?>shop" class="text_link"><?php echo $this->lang->line('view_all_right'); ?></a></div>
        	<div class="clear"></div>
          </div>
          <div class="bottom">
            <div class="fl"></div>
            <div class="fr"></div>
          </div>
        </div>
    </td>
</tr>