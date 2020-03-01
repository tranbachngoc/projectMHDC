<?php $this->load->view('home/common/header'); ?>
<?php $this->load->view('home/common/left'); ?>
<!--BEGIN: CENTER-->
<td width="602" valign="top">
    <table width="602" border="0" cellpadding="0" cellspacing="0">
        <?php $this->load->view('home/advertise/center1'); ?>
        <tr>
            <td height="30" >
            	
                <div class="temp_3"> <h3><?php echo $this->lang->line('hoidap_title'); ?> </h3></div>
            </td>
        </tr>
        <tr>
            <td  >
                <table width="585" align="center" cellpadding="0" cellspacing="0" border="0">
                 
                    <form name="frmSearchShop" method="post">
                    <tr>
                        <td>
                            <?php /*?><table border="0" width="100%" align="center" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td colspan="2" height="12"></td>
                                </tr>
                                <tr>
                                    <td width="85" valign="top" class="list_post"><?php echo $this->lang->line('hoidap_title_input'); ?>:</td>
                                    <td>
                                        <input type="text" name="name_search" id="name_search" value="<?php if(isset($nameKeyword)){echo $nameKeyword;} ?>" maxlength="80" class="input_formpost" onKeyUp="BlockChar(this,'AllSpecialChar')" onfocus="ChangeStyle('name_search',1)" onblur="ChangeStyle('name_search',2)" />
                                    </td>
                                </tr>
                               
                                
                                <tr>
                                    <td width="85" valign="top" class="list_post"><?php echo $this->lang->line('category_shop'); ?>:</td>
                                    <td>
                                        <select name="category_search" id="category_search" class="selectcategory_formpost">
                                            <option value="0" selected="selected"><?php echo $this->lang->line('select_category_shop'); ?></option>
                                            <?php foreach($category as $categoryArray){ ?>
			                                <?php if(isset($categoryKeyword) && $categoryKeyword == $categoryArray->cat_id){ ?>
			                                <option value="<?php echo $categoryArray->cat_id; ?>" selected="selected"><?php echo $categoryArray->cat_name; ?></option>
			                                <?php }else{ ?>
			                                <option value="<?php echo $categoryArray->cat_id; ?>"><?php echo $categoryArray->cat_name; ?></option>
			                                <?php } ?>
			                                <?php } ?>
                                        </select>
                                    </td>
                                </tr>
                               
                                <tr>
                                    <td width="85"></td>
                                    <td height="30" valign="bottom" align="center">
                                        <table border="0" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td colspan="3" height="15"></td>
                                            </tr>
                                            <tr>
                                                <td><input type="button" onclick="CheckInput_SearchShop('<?php echo base_url(); ?>search/hoidap/')" name="submit_searchshop" value="<?php echo $this->lang->line('button_search_shop'); ?>" class="button_form" /></td>
                                                <td width="15"></td>
                                                <td><input type="reset" name="reset_searchshop" value="<?php echo $this->lang->line('button_reset_shop'); ?>" class="button_form" /></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table><?php */?>
                        </td>
                    </tr>
                    </form>
                  
                </table>
            </td>
        </tr>
        <tr>
            <td  height="16" ></td>
        </tr>
        <?php if(isset($searchHoidap)){ ?>
        <tr>
            <td><div class="h1-styleding">
             <h1><?php echo $h1tagSiteGlobal; ?></h1>
             </div></td>
        </tr>
        <tr>
            <td  height="30">
                <div class="tile_modules"><?php echo $this->lang->line('title_result_search_main'); ?> <span class="result_number">(<?php if(isset($totalResult)){echo $totalResult;}else{echo '0';} ?>)</span></div>
            </td>
        </tr>
        <?php if(count($searchHoidap) > 0){ ?>
        <tr>
            <td  >
              
                    
                    <div class="content">
                    <div style="clear:both; padding-top:10px;">
                    </div>
                   <?php foreach($searchHoidap as $item){ ?>
                <div style="height: auto; margin-bottom:5px;">
                    <div class="avatar_xx_small"><a href="<?php echo base_url(); ?>hoidap/<?php echo $item->hds_category; ?>/<?php echo $item->hds_id; ?>/<?php echo RemoveSign($item->hds_title); ?>"><img alt="<?php echo ($item->hds_title);?>" width="50" height="50" src="<?php if($item->sho_logo =='icon_noAvatar.png'){echo base_url().'templates/home/images/icon_noAvatar.png';}else{echo  base_url().'media/shop/logos/'.$item->sho_dir_logo.'/'.$item->sho_logo;}?>"></a></div>
                    <div class="data">
                        <div class="name">
                            <a href="<?php echo base_url(); ?>hoidap/<?php echo $item->hds_category; ?>/<?php echo $item->hds_id; ?>/<?php echo RemoveSign($item->hds_title); ?>" class="text_link_bold"><?php echo $item->hds_username;?></a> 
                            <a href="<?php echo base_url(); ?>hoidap/<?php echo $item->hds_category; ?>/<?php echo $item->hds_id; ?>/<?php echo RemoveSign($item->hds_title); ?>" class="tooltip"><?php echo $item->hds_title;?></a>
                            <span>
                                (<span class="view" title="Lượt xem: <?php echo $item->hds_view;?>"><?php echo $item->hds_view;?></span>&nbsp;
                                <span class="reply" title="Trả lời: <?php echo $item->hds_answers;?>"><?php echo $item->hds_answers;?></span>&nbsp;
                                <span class="thumb_up" title="Câu hỏi hữu ích: <?php echo $item->hds_like;?> người chọn"><?php echo $item->hds_like;?></span>
                                <span class="thumb_down" title="Không thích câu này: <?php echo $item->hds_unlike;?>"><?php echo $item->hds_unlike;?></span>)
                            </span>
                            <!--<pre class="hidden">


          <div class="teaser"></div>


</pre>-->
                        </div>
                        <div class="update"><?php echo $item->up_date;?> <span> trong </span><a class="text_link_pale" href="<?php echo base_url(); ?>hoidap/<?php echo $item->hds_category; ?>/<?php echo RemoveSign($item->cat_name);?>"><?php echo $item->cat_name;?></a></div>
                    </div>
                    <div style="clear:both"></div>
                    <div class="break_module_line"></div>
                </div>
            <?php } ?>
        </div>
                 
             </td>
        </tr>
        <?php }else{ ?>
        <tr>
        	<td class="none_record_search" style="padding-top: 10px;" >
           		<?php echo $this->lang->line('none_record_search_hoidap'); ?>
			</td>
		</tr>
        <?php } ?>
        <tr>
            <td  height="16" ></td>
        </tr>
        <?php } ?>
        <?php $this->load->view('home/advertise/footer'); ?>
    </table>
</td>
<!-- END CENTER-->
<?php $this->load->view('home/common/right'); ?>
<?php $this->load->view('home/common/footer'); ?>