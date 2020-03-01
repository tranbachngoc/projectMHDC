<?php $this->load->view('home/common/account/header'); ?>
<div id="main" class="container">
	<div class="page-title"><?php echo $this->lang->line('title_list_defaults'); ?></div>

	<?php foreach($listNotify as $listNotifyArray){ ?>
		<img src="<?php echo base_url(); ?>templates/home/images/list_ten.gif" border="0" /> &nbsp;&nbsp;&nbsp;<a style="line-height:40px" class="<?php if($listNotifyArray->not_id == $id){echo 'menu_2';}else{echo 'menu_1';} ?>" href="<?php echo base_url(); ?>thongbao/<?php echo $listNotifyArray->not_id; ?>/<?php echo RemoveSign($listNotifyArray->not_title); ?><?php if(isset($page) && (int)$page > 0){ ?>/page/<?php echo $page; ?><?php } ?>" title="<?php echo $this->lang->line('detail_tip'); ?>"><?php echo $listNotifyArray->not_title; ?></a>
		<span class="date_view">(<?php echo date('d-m-Y', $listNotifyArray->not_begindate); ?>)</span>
	<?php } ?>

	
	<?php echo $linkPage; ?>
	
	
	<h3><?php echo $this->lang->line('title_info_defaults'); ?></h3>
	<div><?php echo $this->lang->line('welcome_notify_defaults'); ?></div>

	<div><?php echo $this->lang->line('global_info'); ?></div>
</div>

<?php $this->load->view('home/common/footer'); ?>