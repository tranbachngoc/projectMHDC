<?php if(count($topSaleoffProduct) > 0){ ?>
<tr>
	<td>
    	<div class="temp_2_Product">
        	<div class="title">
                <div class="fl"></div>
                        <div class="fc">
            	<h3><a  href="<?php echo base_url(); ?>giamgia"> <?php echo $this->lang->line('title_top_saleoff_product_right'); ?> </a></h3>
                </div>
        <div class="fr"></div>
            </div>
            <div class="content">
            	<div class="list_link">
                	<ul>
                    	<?php foreach($topSaleoffProduct as $topSaleoffProductArray){ ?>
                        	<li>
                            	<a title="<?php echo $topSaleoffProductArray->pro_name; ?>" href="<?php echo base_url(); ?><?php echo $topSaleoffProductArray->pro_category; ?>/<?php echo $topSaleoffProductArray->pro_id; ?>/<?php echo RemoveSign($topSaleoffProductArray->pro_name); ?>"><?php echo $topSaleoffProductArray->pro_name; ?></a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            	<div class="view_all">
                	<a class="text_link" href="<?php echo base_url(); ?>giamgia"><?php echo $this->lang->line('view_all_right'); ?></a>
                </div>
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