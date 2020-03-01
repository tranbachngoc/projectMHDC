<h3><?php echo $this->lang->line('title_top_lastest_product_right'); ?></h3>
<div class="content">
	<div class="list_link">
		<ul>
			<?php foreach($topLastestProduct as $topLastestProductArray){ ?>
				<li>
					<a class="menu_1" href="<?php echo base_url(); ?><?php echo $topLastestProductArray->pro_category; ?>/<?php echo $topLastestProductArray->pro_id; ?>/<?php echo RemoveSign($topLastestProductArray->pro_name); ?>" onmouseover="ddrivetip('<table border=0 width=300 cellpadding=1 cellspacing=0><tr><td width=\'20\' valign=\'top\' align=\'left\'><img src=\'<?php echo base_url(); ?>media/images/product/<?php echo $topLastestProductArray->pro_dir; ?>/<?php echo show_thumbnail($topLastestProductArray->pro_dir, $topLastestProductArray->pro_image); ?>\' class=\'image_top_tip\'></td><td valign=\'top\' align=\'left\'><?php echo $topLastestProductArray->pro_descr; ?></td></tr></table>',300,'#F0F8FF');" onmouseout="hideddrivetip();"><?php echo $topLastestProductArray->pro_name; ?></a>
				</li>
			<?php } ?>
		</ul>
	</div>
	<div class="view_all">
		<a class="text_link" href="<?php echo base_url(); ?>"><?php echo $this->lang->line('view_all_right'); ?></a>
	</div>
	<div class="clear"></div>
</div>
            