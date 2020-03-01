<?php $this->load->view('home/common/account/header'); ?>
    <div class="container-fluid">
    <div class="row">
<?php $this->load->view('home/common/left'); ?>

<script language="javascript" src="<?php echo base_url(); ?>templates/home/js/check_email.js"></script>
<script language="javascript" src="<?php echo base_url(); ?>templates/home/js/jquey.color.js"></script>
<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>templates/home/css/ui.colorpicker.css" />
<script language="JavaScript">
	jQuery(document).ready(function() {

		jQuery('#colorpicker').ColorPicker({
			onSubmit: function(hsb, hex, rgb, el) {
				jQuery(el).val(hex);
				jQuery(el).ColorPickerHide();
			},
			onBeforeShow: function () {
				jQuery(this).ColorPickerSetColor(this.value);
			}
		})
		.bind('keyup', function(){
			jQuery(this).ColorPickerSetColor(this.value);
		});
	});
</script>

<SCRIPT TYPE="text/javascript">
<!--
function submitenter(myfield,e)
{
var keycode;
if (window.event) keycode = window.event.keyCode;
else if (e) keycode = e.which;
else return true;

if (keycode == 13)
   {
   CheckInput_EditShop();
   return false;
   }
else
   return true;
}
//-->
</SCRIPT>
<!--BEGIN: RIGHT-->
<?php if($this->session->userdata('sessionGroup')!=3){ ?>
<div class="col-md-9 col-sm-8 col-xs-12">
    <table class="table table-bordered" width="100%" border="0" cellpadding="0" cellspacing="0" >
        <tr>
            <td>
                <div class="tile_modules tile_modules_blue">
                <div class="fl"></div>
                <div class="fc">
				<?php echo $this->lang->line('title_shop_account'); ?>
                </div>
                <div class="fr"></div>
                </div>
            </td>
        </tr>
        <tr>
        <td class="k_fixpaddingie"   valign="top" >



<?php ############################################################################################ ?>
                <table width="576" class="post_main" align="center" cellpadding="0" cellspacing="0" border="0">
                    <tr>
                        <td colspan="2" height="20" class="post_top">
                        </td>
                    </tr>
                    <form name="frmUpgradeToShop" method="post" enctype="multipart/form-data">
                    <tr>
                    	<td>
                        	<input type="checkbox" name="k_upgradetoshop" id="k_upgradetoshop" value="upgrade_account_account_menu" />  <?php echo $this->lang->line('upgrade_account_account_menu');?>
                        </td>
                        <td><input type="button" onclick="checkInput_UpgradeToShop();" name="submit_editshop" value="<?php echo $this->lang->line('button_update_shop_account'); ?>" class="button_form" /></td>
                    </tr>
                    </form>
                </table>
            </td>
        </tr>
        <tr>
            <td>
            	<div class="border_bottom_blue">
                	<div class="fl"></div>
                    <div class="fr"></div>
                </div>
            </td>
        </tr>
    </table>
</td>
<?php }else{ ?>
<td valign="top">
    <table class="table table-bordered" width="100%" border="0" cellpadding="0" cellspacing="0" >
        <tr>
            <td>
                <div class="tile_modules tile_modules_blue">
                <div class="fl"></div>
                <div class="fc">
				<?php echo $this->lang->line('title_shop_account'); ?>
                </div>
                <div class="fr"></div>
                </div>
            </td>
        </tr>
        <tr>
        <td class="k_fixpaddingie"   valign="top" >



<?php ############################################################################################ ?>
                <table width="576" class="post_main" align="center" cellpadding="0" cellspacing="0" border="0">
                    <tr>
                        <td colspan="2" height="20" class="post_top">
                        </td>
                    </tr>

                    <tr>
                    	<td>
                        	<?php echo $this->lang->line('suceessupgradetoshop'); ?>
                        </td>
                        <td>
                        	<a href="<?php echo base_url(); ?>account/shop"><?php echo $this->lang->line('edit_shop_account_menu'); ?></a>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
        <tr>
            <td>
            	<div class="border_bottom_blue">
                	<div class="fl"></div>
                    <div class="fr"></div>
                </div>
            </td>
        </tr>
    </table>
    </div>
<?php } ?>
</div>
    </div>
<!--END LEFT-->
<?php $this->load->view('home/common/footer'); ?>