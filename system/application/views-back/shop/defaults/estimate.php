<?php $this->load->view('shop/common/header'); ?>
<?php $this->load->view('shop/common/left'); ?>
<?php if(isset($siteGlobal)){ ?>
<script language="javascript">
	function generateVote(numberstar){
		maxStar		= 5;
		numberstar	= parseFloat(numberstar);
		var intStar	= parseInt(numberstar);
		if (intStar < 0) { intStar = 0; numberstar = 0; }
		if (intStar > maxStar) { intStar = maxStar; numberstar = maxStar; }
		//Ghi star xá»‹n ra
		for (i=1; i<=intStar; i++) document.write('<img src="' + '<?php echo $URLRoot; ?>templates/shop/<?php echo $siteGlobal->sho_style; ?>' + '/images/star_1.gif" />');
		//Neu intStar!=numberstar thi them 0,5 vao va cong intStar them 1
		if (intStar!=numberstar){ document.write('<img src="' + '<?php echo $URLRoot; ?>templates/shop/<?php echo $siteGlobal->sho_style; ?>' + '/images/star_2.gif" />'); intStar++;}
		//ghi ra so sao = 0 con lai 
		for (i=intStar+1; i<=maxStar; i++) document.write('<img src="' + '<?php echo $URLRoot; ?>templates/shop/<?php echo $siteGlobal->sho_style; ?>' + '/images/star_0.gif" />');
	}
</script>
<!--BEGIN: Center-->

<div id="DivContent">
<?php $this->load->view('shop/common/top'); ?>
    <table style="margin-top:0px;" border="0" cellpadding="0" cellspacing="0" width="100%">
         <tr>
              <td height="28">
                <div class="navigate">
                    <div class="L"></div>
                    <div class="C">
                        <a href="<?php echo $URLRoot; ?>" class="home"><?php echo $this->lang->line('index_page_menu_detail_global'); ?></a><img src="<?php echo $URLRoot; ?>templates/shop/<?php echo $siteGlobal->sho_style; ?>/images/navigate_icon.gif" alt="" />
                        <span><?php echo $this->lang->line('index_page_menu_estimate_global'); ?></span>
                     </div>
                     <div class="R"></div>
                 </div>
               </td>
         </tr>
         <tr>
         	<td style="padding: 0;">
            	<table class="table_module" cellspacing="0" cellpadding="0" border="0" style="margin-top:5px;" width="80%">
                	<tr>
                        <td height="28" class="title_module"><?php echo "Kết quả đánh giá"; ?></td>
                    </tr>
                    <tr>
                    	<td class="main_module_1">
                        	<div class="estimate_result">
                            	<table cellspacing="0" cellpadding="0" align="center" class="table" width="80%">
                                  <tbody>
                                	<tr class="title">
                                    	<td>Tiêu chí đánh giá</td>
                                        <td>Tỷ lệ trung bình</td>
                                    </tr>
                                    <tr>
                                    	<td class="col_left">Giá cả</td>
                                        <td class="col_right"><script>generateVote(<?php echo $vote_price_point;?>);</script><span class="star"><?php echo $vote_price_total;?></span></td>
                                     </tr>
                                     <tr>
                                     	<td class="col_left">Thái độ phục vụ</td>
                                        <td class="col_right"><script>generateVote(<?php echo $vote_service_point;?>);</script><span class="star"><?php echo $vote_service_total;?></span></td>
                                     </tr>
                                     <tr>
                                     	<td class="col_left">Chế độ bảo hành</td>
                                        <td class="col_right"><script>generateVote(<?php echo $vote_warranty_point;?>);</script><span class="star"><?php echo $vote_warranty_total;?></span></td>
                                     </tr>
                                     <tr>
                                     	<td class="col_left">Luôn có mặt hàng mới</td>
                                        <td class="col_right"><script>generateVote(<?php echo $vote_p_status_point;?>);</script><span class="star"><?php echo $vote_p_status_total;?></span></td>
                                     </tr>
                                     <tr>
                                     	<td class="col_left">Chất lượng sản phẩm</td>
                                        <td class="col_right"><script>generateVote(<?php echo $vote_p_quality_point;?>);</script><span class="star"><?php echo $vote_p_quality_total;?></span></td>
                                     </tr>
                                     <tr>
                                     	<td class="col_left">Xếp hạng chung</td>
                                        <td class="col_right"><script>generateVote(<?php echo $vote_general_point;?>);</script><span class="star"><?php echo $vote_general_total;?></span></td>
                                     </tr>
                                     <tr>
                                     	<td colspan="2" class="bottom">
                                        	<div class="fl"><span lang="vi">Số lượt bình chọn</span>: <?php echo $vote_total;?></div>
                                            <div class="fr"></div>
                                         </td>
                                      </tr>
                                  </tbody>
                              </table>
                           </div>
                           <div style="height:10px;"></div>
                           <div class="estimate_list" style="min-height:100px;">
                           	<div style="background: none repeat scroll 0 0 #F2F2F2;color: #FF0000;font-weight: bold;padding: 5px 8px;">Ý kiến nhận xét về gian hàng</div>
                            <?php if(isset($est_shops)){?>
                            	<div style="height:250px; overflow:auto;">
                                	<?php $viewitems = 5; if(count($est_shops) < 5) $viewitems= count($est_shops);
										foreach($est_shops as $key=>$item){
											if($key < $viewitems){
									?>
                                    	<div style="padding:5px; border: 1px solid #F2F2F2; margin-top:5px;">
                                        	<div style="background-color:#F2F2F2; padding: 5px 8px; font-weight:bold;"><?php echo $item->est_title;?></div>
                                            <div><?php echo $item->est_content;?></div>
                                        </div>
                                    <?php
											}
										} 
									?>
                                </div>
                            <?php }else{ ?>
                            	<div class="data_is_updating" style="text-align:center">Chưa có ý kiến nào!</div>
                            <?php } ?>
                           </div>
                        </td>
                    </tr>
                </table>
            </td>
         </tr>
         <tr>
         	<td style="padding: 0;">
            	<table class="table_module" cellspacing="0" cellpadding="0" border="0" style="margin-top:5px;">
                	<tr>
                        <td height="28" class="title_module"><?php echo "Gửi đánh giá"; ?></td>
                    </tr>
                    <tr>
                    	<td class="main_module_1">
                        <form name="frmShopVote" id="frmShopVote" method="post">
                        	<div class="estimate_form">
                              <table cellspacing="0" cellpadding="0" align="center" class="table">
                                <tbody>
                                  <tr class="title title_bg">
                                    <td lang="vi" rowspan="2" class="text">Tiêu chí đánh giá</td>
                                    <td lang="vi" colspan="3" class="poor">Kém</td>
                                    <td lang="vi" colspan="3" class="normal">Bình thường</td>
                                    <td lang="vi" colspan="2" class="good">Tốt</td>
                                    <td lang="vi" colspan="2" class="excellent">Xuất sắc</td>
                                    <td></td>
                                  </tr>
                                  <tr class="title_bg">
                                    <td width="4%" align="center">1</td>
                                    <td width="4%" align="center">2</td>
                                    <td width="4%" align="center">3</td>
                                    <td width="4%" align="center">4</td>
                                    <td width="4%" align="center">5</td>
                                    <td width="4%" align="center">6</td>
                                    <td width="4%" align="center">7</td>
                                    <td width="4%" align="center">8</td>
                                    <td width="4%" align="center">9</td>
                                    <td width="4%" align="center">10</td>
                                    <td width="4%" lang="vi" align="center">Không chọn</td>
                                  </tr>
                                  <tr>
                                    <td lang="vi" class="name">Giá cả</td>
                                    <td class="vote"><input type="radio" value="1" name="uper_poll_1" id="poll_1_1" title="1"></td>
                                    <td class="vote"><input type="radio" value="2" name="uper_poll_1" id="poll_1_2" title="2"></td>
                                    <td class="vote"><input type="radio" value="3" name="uper_poll_1" id="poll_1_3" title="3"></td>
                                    <td class="vote"><input type="radio" value="4" name="uper_poll_1" id="poll_1_4" title="4"></td>
                                    <td class="vote"><input type="radio" checked="checked" value="5" name="uper_poll_1" id="poll_1_5" title="5"></td>
                                    <td class="vote"><input type="radio" value="6" name="uper_poll_1" id="poll_1_6" title="6"></td>
                                    <td class="vote"><input type="radio" value="7" name="uper_poll_1" id="poll_1_7" title="7"></td>
                                    <td class="vote"><input type="radio" value="8" name="uper_poll_1" id="poll_1_8" title="8"></td>
                                    <td class="vote"><input type="radio" value="9" name="uper_poll_1" id="poll_1_9" title="9"></td>
                                    <td class="vote"><input type="radio" value="10" name="uper_poll_1" id="poll_1_10" title="10"></td>
                                    <td class="vote_none"><input type="radio" value="0" name="uper_poll_1" title="N/A"></td>
                                  </tr>
                                  <tr>
                                    <td lang="vi" class="name">Thái độ phục vụ</td>
                                    <td class="vote"><input type="radio" value="1" name="uper_poll_2" id="poll_2_1" title="1"></td>
                                    <td class="vote"><input type="radio" value="2" name="uper_poll_2" id="poll_2_2" title="2"></td>
                                    <td class="vote"><input type="radio" value="3" name="uper_poll_2" id="poll_2_3" title="3"></td>
                                    <td class="vote"><input type="radio" value="4" name="uper_poll_2" id="poll_2_4" title="4"></td>
                                    <td class="vote"><input type="radio" checked="checked" value="5" name="uper_poll_2" id="poll_2_5" title="5"></td>
                                    <td class="vote"><input type="radio" value="6" name="uper_poll_2" id="poll_2_6" title="6"></td>
                                    <td class="vote"><input type="radio" value="7" name="uper_poll_2" id="poll_2_7" title="7"></td>
                                    <td class="vote"><input type="radio" value="8" name="uper_poll_2" id="poll_2_8" title="8"></td>
                                    <td class="vote"><input type="radio" value="9" name="uper_poll_2" id="poll_2_9" title="9"></td>
                                    <td class="vote"><input type="radio" value="10" name="uper_poll_2" id="poll_2_10" title="10"></td>
                                    <td class="vote_none"><input type="radio" value="0" name="uper_poll_2" title="N/A"></td>
                                  </tr>
                                  <tr>
                                    <td lang="vi" class="name">Chế độ bảo hành</td>
                                    <td class="vote"><input type="radio" value="1" name="uper_poll_3" id="poll_3_1" title="1"></td>
                                    <td class="vote"><input type="radio" value="2" name="uper_poll_3" id="poll_3_2" title="2"></td>
                                    <td class="vote"><input type="radio" value="3" name="uper_poll_3" id="poll_3_3" title="3"></td>
                                    <td class="vote"><input type="radio" value="4" name="uper_poll_3" id="poll_3_4" title="4"></td>
                                    <td class="vote"><input type="radio" checked="checked" value="5" name="uper_poll_3" id="poll_3_5" title="5"></td>
                                    <td class="vote"><input type="radio" value="6" name="uper_poll_3" id="poll_3_6" title="6"></td>
                                    <td class="vote"><input type="radio" value="7" name="uper_poll_3" id="poll_3_7" title="7"></td>
                                    <td class="vote"><input type="radio" value="8" name="uper_poll_3" id="poll_3_8" title="8"></td>
                                    <td class="vote"><input type="radio" value="9" name="uper_poll_3" id="poll_3_9" title="9"></td>
                                    <td class="vote"><input type="radio" value="10" name="uper_poll_3" id="poll_3_10" title="10"></td>
                                    <td class="vote_none"><input type="radio" value="0" name="uper_poll_3" title="N/A"></td>
                                  </tr>
                                  <tr>
                                    <td lang="vi" class="name">Luôn có mặt hàng mới</td>
                                    <td class="vote"><input type="radio" value="1" name="uper_poll_4" id="poll_4_1" title="1"></td>
                                    <td class="vote"><input type="radio" value="2" name="uper_poll_4" id="poll_4_2" title="2"></td>
                                    <td class="vote"><input type="radio" value="3" name="uper_poll_4" id="poll_4_3" title="3"></td>
                                    <td class="vote"><input type="radio" value="4" name="uper_poll_4" id="poll_4_4" title="4"></td>
                                    <td class="vote"><input type="radio" checked="checked" value="5" name="uper_poll_4" id="poll_4_5" title="5"></td>
                                    <td class="vote"><input type="radio" value="6" name="uper_poll_4" id="poll_4_6" title="6"></td>
                                    <td class="vote"><input type="radio" value="7" name="uper_poll_4" id="poll_4_7" title="7"></td>
                                    <td class="vote"><input type="radio" value="8" name="uper_poll_4" id="poll_4_8" title="8"></td>
                                    <td class="vote"><input type="radio" value="9" name="uper_poll_4" id="poll_4_9" title="9"></td>
                                    <td class="vote"><input type="radio" value="10" name="uper_poll_4" id="poll_4_10" title="10"></td>
                                    <td class="vote_none"><input type="radio" value="0" name="uper_poll_4" title="N/A"></td>
                                  </tr>
                                  <tr>
                                    <td lang="vi" class="name">Chất lượng sản phẩm</td>
                                    <td class="vote"><input type="radio" value="1" name="uper_poll_5" id="poll_5_1" title="1"></td>
                                    <td class="vote"><input type="radio" value="2" name="uper_poll_5" id="poll_5_2" title="2"></td>
                                    <td class="vote"><input type="radio" value="3" name="uper_poll_5" id="poll_5_3" title="3"></td>
                                    <td class="vote"><input type="radio" value="4" name="uper_poll_5" id="poll_5_4" title="4"></td>
                                    <td class="vote"><input type="radio" checked="checked" value="5" name="uper_poll_5" id="poll_5_5" title="5"></td>
                                    <td class="vote"><input type="radio" value="6" name="uper_poll_5" id="poll_5_6" title="6"></td>
                                    <td class="vote"><input type="radio" value="7" name="uper_poll_5" id="poll_5_7" title="7"></td>
                                    <td class="vote"><input type="radio" value="8" name="uper_poll_5" id="poll_5_8" title="8"></td>
                                    <td class="vote"><input type="radio" value="9" name="uper_poll_5" id="poll_5_9" title="9"></td>
                                    <td class="vote"><input type="radio" value="10" name="uper_poll_5" id="poll_5_10" title="10"></td>
                                    <td class="vote_none"><input type="radio" value="0" name="uper_poll_5" title="N/A"></td>
                                  </tr>
                                  <tr class="bottom">
                                    <td lang="vi" class="name">Nhận xét chung</td>
                                    <td class="vote"><input type="radio" value="1" name="uper_poll_6" id="poll_6_1" title="1"></td>
                                    <td class="vote"><input type="radio" value="2" name="uper_poll_6" id="poll_6_2" title="2"></td>
                                    <td class="vote"><input type="radio" value="3" name="uper_poll_6" id="poll_6_3" title="3"></td>
                                    <td class="vote"><input type="radio" value="4" name="uper_poll_6" id="poll_6_4" title="4"></td>
                                    <td class="vote"><input type="radio" checked="checked" value="5" name="uper_poll_6" id="poll_6_5" title="5"></td>
                                    <td class="vote"><input type="radio" value="6" name="uper_poll_6" id="poll_6_6" title="6"></td>
                                    <td class="vote"><input type="radio" value="7" name="uper_poll_6" id="poll_6_7" title="7"></td>
                                    <td class="vote"><input type="radio" value="8" name="uper_poll_6" id="poll_6_8" title="8"></td>
                                    <td class="vote"><input type="radio" value="9" name="uper_poll_6" id="poll_6_9" title="9"></td>
                                    <td class="vote"><input type="radio" value="10" name="uper_poll_6" id="poll_6_10" title="10"></td>
                                    <td class="vote_none"><input type="radio" value="0" name="uper_poll_6" title="N/A"></td>
                                  </tr>
                                </tbody>
                              </table>
                            </div>
                            <div style="margin-top:10px;">
                            	<table cellspacing="0" cellpadding="0" align="center" class="estimate_form_table">
                                  <tbody>
                                    <tr>
                                      <td width="30%" class="form_name"></td>
                                      <td width="70%" gtrans="vi" class="form_text"><span class="form_text_note">Những ô có dấu sao (<font color="#FF0000"><b>*</b></font>) là bắt buộc phải nhập.</span></td>
                                    </tr>
                                    <tr>
                                      <td class="form_name"><font color="#FF0000"><b>*</b></font><span lang="vi">Tiêu đề</span> :</td>
                                      <td class="form_text"><input type="text" maxlength="255" style="width:250px" value="" name="uper_title" id="uper_title" title="Tiêu đề" class="form_control"></td>
                                    </tr>
                                    <tr>
                                      <td class="form_name"><font color="#FF0000"><b>*</b></font><span lang="vi">Nội dung</span> :</td>
                                      <td class="form_text"><textarea style="width:250px; height:100px" name="uper_comment" id="uper_comment" title="Nội dung" class="form_control"></textarea></td>
                                    </tr>
                                    <tr height="80">
                                        <td class="form_name"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('captcha_main'); ?>:</td>
                                        <td class="form_text">
                                            <img src="<?php echo $imageCaptchaShopVoteAccount; ?>" width="151" height="30" alt="" /><br />
                                            <input type="text" name="captcha_shop" id="captcha_shop" value="" maxlength="10" class="inputcaptcha_form" onfocus="ChangeStyle('captcha_shop',1);" onblur="ChangeStyle('captcha_shop',2);" />
                                        </td>
                                    </tr>
                                    <tr>
                                      <td class="form_name"></td>
                                      <td class="form_text">
                                      <input type="hidden" name="isShopVote" id="isShopVote" value=""/>
                   					  <input type="hidden" name="current_captcha" id="current_captcha" value="<?php echo $captcha;?>"/>
                                      <input type="button" onclick="CheckInput_vote();" name="submit_shopvote" value="Gửi đi" class="button_form" />
                                      <input type="reset" value="Làm lại" name="reset" id="reset" title="Làm lại" class="button_form"></td>
                                    </tr>
                                  </tbody>
                                </table>
                            </div>
                            </form>
                        </td>
                    </tr>
                </table>
            </td>
         </tr>
    </table>
</div>

<!--END Center-->
<?php } ?>
<?php $this->load->view('shop/common/right'); ?>
<?php $this->load->view('shop/common/footer'); ?>