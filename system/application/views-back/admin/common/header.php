<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="https://www.w3.org/1999/xhtml">
<head>

    <link rel="shortcut icon" href="<?php echo base_url(); ?>templates/home/images/favicon.png" type="image/x-icon"/>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>templates/admin/css/templates.css"/>
    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>templates/home/css/font-awesome.min.css" />
    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>templates/home/css/bootstrap.css"/>
    <?php if($this->uri->segment(2) == 'service'){ ?>
    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>templates/admin/js/jalert/jAlert-v3.css"/>
    <?php } ?>
    <script language="javascript" src="<?php echo base_url(); ?>templates/admin/js/jquery.js"></script>
    <script language="javascript" src="<?php echo base_url(); ?>templates/admin/js/check_email.js"></script>
    <script language="javascript" src="<?php echo base_url(); ?>templates/admin/js/general.js"></script>
    <script language="javascript" src="<?php echo base_url(); ?>templates/admin/js/chrome.js"></script>
    <script language="javascript" src="<?php echo base_url(); ?>templates/admin/js/tooltips.js"></script>
    <script language="javascript" src="<?php echo base_url(); ?>templates/admin/js/jquery.validate.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>templates/home/js/jquery.autocomplete.js"></script>
    <script type="text/javascript" language="javascript"
            src="<?php echo base_url(); ?>templates/home/js/bootstrap.min.js"></script>
    <?php if($this->uri->segment(2) == 'service'){ ?>
    <script type="text/javascript" src="<?php echo base_url(); ?>templates/admin/js/jalert/jAlert-v3.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>templates/admin/js/jalert/jAlert-functions.min.js"></script>
    <?php } ?>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>templates/home/css/jquery.autocomplete.css"
          media="screen"/>

    <title><?php echo $this->lang->line('administrator_header'); ?></title>
</head>
<body>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
        <td height="54" valign="top">
            <table width="100%" border="0" align="center" class="main table_top" cellpadding="0" cellspacing="0">
                <tr>
                    <td width="2" ></td>
                    <td height="54" class="middle_top_main" valign="top">
                        <div class="col-sm-6" id="title_header">
                            <a onclick="ActionLink('<?php echo base_url(); ?>administ')" style="cursor:pointer;"><i class="fa fa-home"></i> <?php echo $this->lang->line('administrator_header'); ?></a>
                        </div>
                        <div class="col-sm-6 text-right" id="title_header_exit">
                            <a onclick="ActionLink('<?php echo base_url(); ?>administ/logout/')" style="cursor:pointer;"><i class="fa fa-sign-out" aria-hidden="true"></i> <?php echo $this->lang->line('logout_menu'); ?></a>
                        </div>
                    </td>
                    <td width="2"></td>
                </tr>
            </table>
        </td>
    </tr>