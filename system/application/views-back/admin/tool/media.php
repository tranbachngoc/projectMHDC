<?php $this->load->view('admin/common/header'); ?>
<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>templates/home/js/jalert/jquery.alerts.css" />
<script language="javascript" src="<?php echo base_url(); ?>templates/home/js/jalert/jquery.alerts.js"></script>
<?php $this->load->view('admin/common/menu'); ?>
<tr>
    <td valign="top">
        <table width="100%" border="0" align="center" class="main" cellpadding="0" cellspacing="0">
            <tr>
                <td width="2"></td>
                <td width="10" class="left_main" valign="top"></td>
                <td align="center" valign="top">
                    <!--BEGIN: Main-->
                    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td height="10"></td>
                        </tr>
                        <tr>
                            <td>
                                <!--BEGIN: Item Menu-->
                                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td width="5%" height="67" class="item_menu_left">
                                            <img src="<?php echo base_url(); ?>templates/admin/images/item_addadvertise.gif" border="0" />
                                        </td>
                                        <td width="40%" height="67" class="item_menu_middle"><?php echo 'Upload Image'; ?></td>
                                        <td width="55%" height="67" class="item_menu_right">
                                            
                                        </td>
                                    </tr>
                                </table>
                                <!--END Item Menu-->
                            </td>
                        </tr>
                        <tr>
                            <td height="10"></td>
                        </tr>
                        <tr>
                            <td align="center" valign="top">
                                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td width="20" height="20" class="corner_lt_post"></td>
                                        <td height="20" class="top_post"></td>
                                        <td width="20" height="20" class="corner_rt_post"></td>
                                    </tr>
                                    <tr>
                                        <td width="20" class="left_post"></td>
                                        <td align="center" valign="top">
                                            <!--BEGIN: Content-->
                                             <div class="image_items">
                                                 <?php if(isset($images)){
													foreach($images as $image){
													$imglink = base_url().'images/'.$image;
												?>
                                                    <div class="img_item">
                                                        <?php echo '<a style="cursor:pointer;" title="'.$image.'"><img src="'.base_url().'images/'.$image.'"></a>'; ?> 
                                                        
                                                    </div>
                                                    <div class="img_del" ><img class="img_db" 
                                                 src="<?php echo base_url(); ?>templates/home/images/xoaimg.png"
                                                 border="0" title="Xóa hình này"
                                                 onclick="return delete_img_ajax_db('<?php echo base_url(); ?>','<?php echo $image; ?>');"/></div>
                                                 <?php } }?>
                                                 <div style="clear:both"></div>
                                              </div>
                                            <!--END Content-->
                                        </td>
                                        <td width="20" class="right_post"></td>
                                    </tr>
                                    <tr>
                                        <td width="20" height="20" class="corner_lb_post"></td>
                                        <td height="20" class="bottom_post"></td>
                                        <td width="20" height="20" class="corner_rb_post"></td>
                                    </tr>
                                </table>
                                <form id="frmUpload" name="frmUpload" method="post" enctype="multipart/form-data">
                                	<input type="file" id="upload_file" name="upload_file" />
                                    <input type="button" value="Upload Image" onclick="uploadimage();"/>
                                    <input type="hidden" id="isupload" name="isupload" value="0"/>
                                </form>
                            </td>
                        </tr>
                    </table>
                    <!--END Main-->
                </td>
                <td width="10" class="right_main" valign="top"></td>
                <td width="2"></td>
            </tr>
            <tr>
                <td width="2" height="11"></td>
                <td width="10" height="11" class="corner_lb_main" valign="top"></td>
                <td height="11" class="middle_bottom_main"></td>
                <td width="10" height="11" class="corner_rb_main" valign="top"></td>
                <td width="2" height="11"></td>
            </tr>
        </table>
    </td>
</tr>
<?php $this->load->view('admin/common/footer'); ?>