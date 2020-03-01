<?php $this->load->view('admin/common/header'); ?>
<?php $this->load->view('admin/common/menu'); ?>
<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>templates/home/css/bootstrap-combined.min.css" />
<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
<script src="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>templates/home/js/bootstrap-tree.js"></script>
<tr>
  <td valign="top"><table width="100%" border="0" align="center" class="main" cellpadding="0" cellspacing="0">
      <tr>
        <td width="2"></td>
        <td width="10" class="left_main" valign="top"></td>
        <td align="center" valign="top">
          
          <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td height="10"></td>
            </tr>
            <tr>
              <td><!--BEGIN: Item Menu-->
                
                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td width="5%" height="67" class="item_menu_left"><a href="<?php echo base_url(); ?>administ/user/usertree/624"> <img src="<?php echo base_url(); ?>templates/home/images/icon/treesystem-icon.png" border="0" /> </a></td>
                    <td width="40%" height="67" class="item_menu_middle">Thành viên Cây hệ thống của <a class="userroot" href="<?php echo base_url(); ?>administ/user/edit/<?php echo $rootUser->use_id; ?>"><?php echo $rootUser->use_username; ?></a></td>
                    <td width="55%" height="67" class="item_menu_right"><!--<div class="icon_item" id="icon_item_1" onclick="ActionDelete('frmInActUser')" onmouseover="ChangeStyleIconItem('icon_item_1',1)" onmouseout="ChangeStyleIconItem('icon_item_1',2)">
                        <table width="100%" height="100%" align="center" border="0" cellpadding="0" cellspacing="0">
                          <tr>
                            <td align="center"><img src="<?php echo base_url(); ?>templates/admin/images/icon_delete.png" border="0" /></td>
                          </tr>
                          <tr>
                            <td class="text_icon_item" nowrap="nowrap"><?php echo $this->lang->line('delete_tool'); ?></td>
                          </tr>
                        </table>
                      </div>-->
                      <div class="icon_item" id="icon_item_2" onclick="ActionLink('<?php echo base_url(); ?>administ/user/add')" onmouseover="ChangeStyleIconItem('icon_item_2',1)" onmouseout="ChangeStyleIconItem('icon_item_2',2)">
                        <table width="100%" height="100%" align="center" border="0" cellpadding="0" cellspacing="0">
                          <tr>
                            <td align="center"><img src="<?php echo base_url(); ?>templates/admin/images/icon_add.png" border="0" /></td>
                          </tr>
                          <tr>
                            <td class="text_icon_item" nowrap="nowrap"><?php echo $this->lang->line('add_tool'); ?></td>
                          </tr>
                        </table>
                      </div></td>
                  </tr>
                </table>
                
                <!--END Item Menu--></td>
            </tr>
            <tr>
              <td height="10"></td>
            </tr>
            <tr>
              <td align="left">
              <div class="treeinlist"><a class="awesome" href="<?php echo base_url(); ?>administ/user/usertree/<?php echo $this->uri->segment(4); ?>"><i class="fa fa-cubes"></i> Xem danh sách</a></div>
              <div id="treesystem">
                  <div class="row-fluid">
                    <section id="demonstration" role="main" class="span12">
                      <div class="tree well">
                        <?php 
					//showTree();
					
					if($htmlTree == ''){
						echo 'Không có thành viên nào!';
					}else{
						echo $htmlTree; 
					}
					?>
                      </div>
                    </section>
                  </div>
                </div></td>
            </tr>
              </form>
            
          </table>
          
          <!--END Main--></td>
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
    </table></td>
</tr>
<?php $this->load->view('admin/common/footer'); ?>
