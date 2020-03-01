<h3><a  href="<?php echo base_url(); ?>muanhieunhat"><?php echo $this->lang->line('title_top_buyest_product_right'); ?></a></h3>
<div class="content">
	<div class="list_link">
		<ul>
		<?php foreach($topBuyestProduct as $topBuyestProductArray){ ?>
			<li>
			<a href="<?php echo base_url(); ?><?php echo $topBuyestProductArray->pro_category; ?>/<?php echo $topBuyestProductArray->pro_id; ?>/<?php echo RemoveSign($topBuyestProductArray->pro_name); ?>" title="<?php echo $topBuyestProductArray->pro_name; ?>"><?php echo $topBuyestProductArray->pro_name; ?></a><span class="number_buy">(<?php echo $topBuyestProductArray->pro_buy; ?>)</span>
			</li>
		<?php } ?>
		</ul>
	</div>
	<div class="view_all">
		<a class="text_link" href="<?php echo base_url(); ?>muanhieunhat"><?php echo $this->lang->line('view_all_right'); ?></a>
	</div>
	<div class="clear"></div>
</div>