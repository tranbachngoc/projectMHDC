<?php $this->load->view('shop/common/header'); ?>
<?php $this->load->view('shop/common/left'); ?>
<?php echo $headerjs; ?>
<?php echo $headermap; ?>
<?php if(isset($siteGlobal)){ ?>
<td valign="top" align="center">
<?php echo $onload; ?>
<?php echo $map; ?>
<?php echo $sidebar; ?>
</td>
<!--END Center-->
<?php } ?>
<?php $this->load->view('shop/common/footer'); ?>