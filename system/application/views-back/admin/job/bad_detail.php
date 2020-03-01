<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>templates/admin/css/templates.css" />
<script language="javascript" src="<?php echo base_url(); ?>templates/admin/js/general.js"></script>
<title><?php echo $this->lang->line('administrator_header'); ?></title>
</head>
<body style="margin-left:2px;">
<table width="650" border="0" cellpadding="0" cellspacing="0">
    <?php $idDiv = 1; ?>
    <?php foreach($job as $jobArray){ ?>
    <form name="frmDetailBadJob_<?php echo $idDiv; ?>" method="post">
	<tr bgcolor="#E1F0FF">
    	<td width="145" valign="top" class="list_post"><?php echo $this->lang->line('title_detail_bad'); ?>:</td>
        <td class="title_detail_bad">
        	<?php echo $jobArray->jba_title; ?>&nbsp;&nbsp;
        	<img src="<?php echo base_url(); ?>templates/admin/images/icon_delete_bad.gif" onclick="ActionDelete('frmDetailBadJob_<?php echo $idDiv; ?>')" style="cursor:pointer;" border="0" title="<?php echo $this->lang->line('delete_tip_detail_bad'); ?>" />
        </td>
    </tr>
    <tr bgcolor="#F7F7F7">
    	<td width="145" valign="top" class="list_post"><?php echo $this->lang->line('email_detail_bad'); ?>:</td>
        <td class="title_detail_bad">
        	<a class="menu" href="mailto:<?php echo $jobArray->jba_email; ?>"><?php echo $jobArray->jba_email; ?></a>
        </td>
    </tr>
    <tr bgcolor="#E1F0FF">
    	<td width="145" valign="middle" class="list_post"><?php echo $this->lang->line('detail_detail_bad'); ?>:</td>
        <td class="content_detail_bad" align="left">
        	<?php echo nl2br($jobArray->jba_detail); ?>
        </td>
    </tr>
    <tr bgcolor="#F7F7F7">
    	<td width="145" valign="top" class="list_post"><?php echo $this->lang->line('date_detail_bad'); ?>:</td>
        <td class="time_detail_bad"><?php echo date('h\h:i, d-m-Y', $jobArray->jba_date); ?></td>
    </tr>
    <input type="hidden" name="idBad" value="<?php echo $jobArray->jba_id; ?>" />
    </form>
    <?php $idDiv++; ?>
    <?php } ?>
    <tr>
    	<td class="show_page" colspan="2"><?php echo $linkPage; ?></td>
 	</tr>
</table>
</body>
</html>