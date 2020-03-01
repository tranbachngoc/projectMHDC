<?php $this->load->view('admin/common/header'); ?>
<?php $this->load->view('admin/common/menu'); ?>
<?php

if($_SERVER['HTTP_REFERER']!=base_url()."administ/content/edit_cohoi/".$this->uri->segment(4)."")
{
  $_SESSION['trangtruoc']=$_SERVER['HTTP_REFERER'];
}
?>
<script language="javascript">
  document.onclick=check;
  function check(e){
    var evt = (e)?e:event;
    var theElem = (evt.srcElement)?evt.srcElement:evt.target;
    while(theElem!=null){        
      if(theElem.id == "office-location"){
       jQuery('#office-location').remove();
       jQuery("#img_list").css("display","none");
       jQuery("#img_list_en").css("display","none");  
       break;
     }
     else
     {
      break;
    }
  }
}
</script>
<tr>
  <td valign="top"><table width="100%" border="0" align="center" class="main" cellpadding="0" cellspacing="0">
    <tr>
      <td width="2"></td>
      <td width="10" class="left_main" valign="top"></td>
      <td align="center" valign="top"><!--BEGIN: Main-->
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td height="10"></td>
          </tr>
          <tr>
            <td>
              <!--BEGIN: Item Menu-->
              <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="5%" height="67" class="item_menu_left"><img src="<?php echo base_url(); ?>templates/admin/images/item_editnotify.gif" border="0" /></td>
                  <td width="40%" height="67" class="item_menu_middle"><?php echo $this->lang->line('title_edit'); ?></td>
                  <td width="55%" height="67" class="item_menu_right"><?php if($successEdit == false){ ?>
                    <div class="icon_item" id="icon_item_1" onclick="ActionLink('<?php echo base_url(); ?>administ/content/cohoi')" onmouseover="ChangeStyleIconItem('icon_item_1',1)" onmouseout="ChangeStyleIconItem('icon_item_1',2)">
                      <table width="100%" height="100%" align="center" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                          <td align="center"><img src="<?php echo base_url(); ?>templates/admin/images/icon_reset.png" border="0" /></td>
                        </tr>
                        <tr>
                          <td class="text_icon_item" nowrap="nowrap"><?php echo $this->lang->line('cancel_tool'); ?></td>
                        </tr>
                      </table>
                    </div>
                    <div class="icon_item" id="icon_item_2" onclick="CheckInput_AddContent()" onmouseover="ChangeStyleIconItem('icon_item_2',1)" onmouseout="ChangeStyleIconItem('icon_item_2',2)">
                      <table width="100%" height="100%" align="center" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                          <td align="center"><img src="<?php echo base_url(); ?>templates/admin/images/icon_save.png" border="0" /></td>
                        </tr>
                        <tr>
                          <td class="text_icon_item" nowrap="nowrap"><?php echo $this->lang->line('save_tool'); ?></td>
                        </tr>
                      </table>
                    </div>
                    <?php }else{ ?>
                    <div class="icon_item" id="icon_item_2" onclick="ActionLink('<?php echo base_url(); ?>administ/content/addcohoi')" onmouseover="ChangeStyleIconItem('icon_item_2',1)" onmouseout="ChangeStyleIconItem('icon_item_2',2)">
                      <table width="100%" height="100%" align="center" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                          <td align="center"><img src="<?php echo base_url(); ?>templates/admin/images/icon_add.png" border="0" /></td>
                        </tr>
                        <tr>
                          <td class="text_icon_item" nowrap="nowrap"><?php echo $this->lang->line('add_tool'); ?></td>
                        </tr>
                      </table>
                    </div>
                    <?php } ?>
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
            <td align="center" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td width="20" height="20" class="corner_lt_post"></td>
                <td height="20" class="top_post"></td>
                <td width="20" height="20" class="corner_rt_post"></td>
              </tr>
              <tr>
                <td width="20" class="left_post"></td>
                <td align="center" valign="top"><!--BEGIN: Content-->
                  <table width="100%" class="form_main1" cellpadding="0" cellspacing="0" border="0">
                    <tr>
                      <td colspan="2" height="30" class="form_top"></td>
                    </tr>
                    <?php if($successEdit == false){ ?>
                    <form name="frmAddNotify" method="post" enctype="multipart/form-data" >
                      <tr>
                        <td width="150" valign="top" class="list_post">Danh mục tài liệu:</td>
                        <td align="left"><div  style=" padding-top:14px;">
                          <div id="hoidap_0" style="float: left; ">
                            <select id="hd_select_0" class="form_control_hoidap_select" onclick="check_edit_content_cate(this.value,0,'<?php echo base_url(); ?>');" size="14">
                              <option value="" <?php if($category_shop!="") ?> selected="selected"  >Chọn danh mục tài liệu</option>
                              <?php 
                              if(isset($catlevel0)){
                                foreach($catlevel0 as $item){
                                 ?>
                                 <?php if($cat_getcategory0!="") { ?>
                                 <?php  if($category_shop == $item->cat_id){ ?>
                                 <option value="<?php echo $item->cat_id; ?>" selected="selected" ><?php echo $item->cat_name; ?></option>
                                 <?php if($item->child_count >0){echo ' >';}?>
                                 <?php }else { ?>
                                 <option value="<?php echo $item->cat_id; ?>"  ><?php echo $item->cat_name; ?></option >
                                  <?php
                                }?>
                                <?php
                              }
                              else
                               { ?>
                             <?php  if( $cat_parent_parent_0 -> parent_id == $item->cat_id){ ?>
                             <option value="<?php echo $item->cat_id; ?>" selected="selected" ><?php echo $item->cat_name; ?></option                             
                              >
                              <?php }   else { ?>
                              <option value="<?php echo $item->cat_id;?>"><?php echo $item->cat_name;?>
                                <?php if($item->child_count >0){echo ' >';}?>
                              </option>
                              <?php }}}}?>
                            </select>
                          </div>
                          <div id="hoidap_1" style="float: left; margin-left: 15px;">
                            <?php if(isset($cat_level_1)){ ?>
                            <select name="category_pro" id="category_proaa" class="selectcategory_formpost_edit" size="14" onclick="check_edit_content_cate(this.value,1,'<?php echo base_url(); ?>');" >
                              <?php 
                              foreach($cat_level_1 as $item){
                               ?>
                               <?php if( $cat_parent_parent -> parent_id == $item->cat_id){ ?>
                               <option value="<?php echo $item->cat_id; ?>" selected="selected" ><?php echo $item->cat_name; ?></option
                                >
                                <?php } else { if(isset($category_shop) && $category_shop == $item->cat_id)  { ?>
                                <option value="<?php echo $item->cat_id; ?>"  selected="selected" ><?php echo $item->cat_name; ?></option>
                                <?php } else {  ?>
                                <option value="<?php echo $item->cat_id; ?>" ><?php echo $item->cat_name; ?></option>
                                <?php } } } ?>
                              </select>
                              <?php }?>
                            </div>
                            <div id="hoidap_2" style="float: left;  margin-left: 15px;">
                              <?php if(isset($cat_level_2)){ ?>
                              <select name="category_proz" id="category_pro_edit" class="selectcategory_formpost_edit" size="14" onblur="getManAndCategory4Search_edit('<?php echo base_url(); ?>');" onclick="check_edit_content_cate(this.value,2,'<?php echo base_url(); ?>');" >
                                <?php 
                                foreach($cat_level_2 as $item){
                                 ?>
                                 <?php if(isset($category_shop) && $category_shop == $item->cat_id){ ?>
                                 <option value="<?php echo $item->cat_id; ?>" selected="selected"><?php echo $item->cat_name; ?></option
                                  >
                                  <?php } else { ?>
                                  <option value="<?php echo $item->cat_id; ?>" ><?php echo $item->cat_name; ?></option>
                                  <?php } } ?>
                                </select>
                                <?php }?>
                              </div>
                              <input type="hidden" id="hd_category_id" name="hd_category_id" value="<?php echo $category_shop ; ?>"/>
                            </div>
                          </td>
                        </tr>
                        <tr>
                          <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('title_title_edit'); ?>:</td>
                          <td align="left"><input type="text" name="title_content" id="title_content" value="<?php echo $title_content; ?>" maxlength="130" class="input_formpost" onkeyup="BlockChar(this,'SpecialChar')" onfocus="ChangeStyle('title_content',1)" onblur="ChangeStyle('title_content',2)" />
                            <?php echo form_error('title_content'); ?></td>
                          </tr>

                          <tr>
                            <td width="150" valign="middle" class="list_post">Hình đại diện</td>
                            <td align="left" style=" padding-top:6px;">
                              <input type="file" name="image" id="image" class="inputimage_formpost" />    
                              <img style="vertical-align:middle; height:100px" src="<?php echo base_url().'media/images/cohoi/'.$not_dir_image.'/'.$not_image; ?>"/>                                           
                            </td>
                          </tr>
                          <tr>
                            <td height="10" colspan="2"></td>
                          </tr>
                          <tr>
                            <td width="150" valign="middle" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('content_edit'); ?>:</td>
                            <td align="left"><table border="0" cellpadding="0" cellspacing="0">
                              <tr>
                                <td><?php $this->load->view('admin/common/tinymce'); ?>
                                  <textarea name="txtContent" style="width:100%">
                                    <?php 
                                    $vovel=array("&curren;"); echo html_entity_decode(str_replace($vovel,"#",$txtContent));
                                    ?>
                                  </textarea>
                                </td>
                                <td style="padding-top:7px;"></td>
                              </tr>
                            </table>
                            <?php echo form_error('txtContent'); ?></td>
                          </tr>
                          <tr>
                            <td></td>
                            <td>
                              <input type="button" value="Chèn Hình" onclick="popsimages('img_list');"/>
                              <div id="img_list" class="img_list">
                                <div style="width:620px; text-align: right; margin-left:10px; margin-top:-10px;"><img style="cursor:pointer" onclick="closeimagespop();" src="<?php echo base_url(); ?>templates/home/images/close_x.png"/></div>
                                <div class="image_items">
                                  <?php if(isset($images)){
                                   foreach($images as $image){
                                    $imglink = base_url().'images/'.$image;
                                    ?>
                                    <div class="img_item"> <?php echo '<a style="cursor:pointer;" onclick="insertimg(\''.$imglink.'\')" title="'.$image.'"><img src="'.base_url().'images/'.$image.'"></a>'; ?> </div>
                                    <?php } }?>
                                    <div style="clear:both"></div>
                                  </div>
                                </div>
                            </td>
                              </tr>
                              <tr>
                                <td width="150" valign="top" class="list_post"><?php echo $this->lang->line('status_edit'); ?>:</td>
                                <td align="left" style="padding-top:7px;"><input type="checkbox" name="active_content" id="active_content" value="1" <?php if($active_content == '1'){echo 'checked="checked"';} ?> /></td>
                              </tr>
                            </form>
                            <?php }else{ ?>
                            <tr class="success_post">
                              <td colspan="2"><p class="text-center"><a href="<?php echo $_SESSION['trangtruoc']; ?>">Click vào đây để tiếp tục</a></p>
                                <?php echo $this->lang->line('success_edit'); ?></td>
                              </tr>
                              <?php } ?>
                              <tr>
                                <td colspan="2" height="30" class="form_bottom"></td>
                              </tr>
                            </table>
                            <!--END Content--></td>
                            <td width="20" class="right_post"></td>
                          </tr>
                          <tr>
                            <td width="20" height="20" class="corner_lb_post"></td>
                            <td height="20" class="bottom_post"></td>
                            <td width="20" height="20" class="corner_rb_post"></td>
                          </tr>
                        </table></td>
                      </tr>
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
