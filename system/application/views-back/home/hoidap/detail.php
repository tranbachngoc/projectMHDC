<?php $this->load->view('home/common/header'); ?>

<script language="javascript">
	jQuery(document).ready(function(){
		jQuery('.hoidap_detail .data .description').width(jQuery('.hoidap_detail').width()-100);
		jQuery('.hoidap_reply .data .description').width(jQuery('.hoidap_detail').width()-75);
		jQuery('#txtContent').width(jQuery('.hoidap_detail').width());
	});
	function changeok(baseurl,id){
		if(id.indexOf('hds_up') >-1){
			jQuery('#'+id).attr('src',baseurl+'templates/home/images/thumb_up_ok.gif');
		}else{
			jQuery('#'+id).attr('src',baseurl+'templates/home/images/thumb_down_ok.gif');
		}
	}
	function changeoff(baseurl,id){
		if(id.indexOf('hds_up') >-1){
			jQuery('#'+id).attr('src',baseurl+'templates/home/images/thumb_up.gif');
		}else{
			jQuery('#'+id).attr('src',baseurl+'templates/home/images/thumb_down.gif');
		}
	}
	function hoidapAddReply(baseurl,userid)
	{
		jQuery('#editAnswerId').val('');
		tinyMCE.get('txtContent').setContent('');
		if(userid !='' && userid != 0)
		{
			jQuery("#hoidap_reply").show();
			jQuery(window).scrollTop(jQuery("#hoidap_reply").offset().top - 40);
		}
		else
		{
			window.location.href = baseurl+'login';
		}
	}
	function voteuphd(baseurl,userid,hdsid)
	{
		if(userid !='' && userid != 0)
		{
			jQuery.ajax({
				type: "POST",
				url: baseurl + "hoidap/ajaxvote",
				data: "hdsid=" + hdsid+"&type=up",
				success: function(data){
					jQuery('#vote_up_hd').html('<b class="vote_up">('+data+')</b>');
				},
				error: function(){}
			});
		}
		else
		{
			jConfirm('Xin bạn vui lòng đăng nhập để sử dụng tính năng này!<br/>Bạn hãy click vào OK để đến trang đăng nhập.','Yêu cầu đăng nhập',function(r){
				if(r == true){
					window.location.href = baseurl+'login';
				}else{
					return false;
				}
			});
		}
	}
	function votedownhd(baseurl,userid,hdsid)
	{
		if(userid !='' && userid != 0)
		{
			jQuery.ajax({
				type: "POST",
				url: baseurl + "hoidap/ajaxvote",
				data: "hdsid=" + hdsid+"&type=down",
				success: function(data){
					jQuery('#vote_down_hd').html('<b class="vote_down">('+data+')</b>');
				},
				error: function(){}
			});
		}
		else
		{
			jConfirm('Xin bạn vui lòng đăng nhập để sử dụng tính năng này!<br/>Bạn hãy click vào OK để đến trang đăng nhập.','Yêu cầu đăng nhập',function(r){
				if(r == true){
					window.location.href = baseurl+'login';
				}else{
					return false;
				}
			});
		}
	}
	function voteupanswers(baseurl,userid,answersid)
	{
		if(userid !='' && userid != 0)
		{
			jQuery.ajax({
				type: "POST",
				url: baseurl + "hoidap/ajaxvoteans",
				data: "answersid=" + answersid+"&type=up",
				success: function(data){
					jQuery('#vote_up_answer_'+answersid).html('<b class="vote_up">('+data+')</b>');
				},
				error: function(){}
			});
		}
		else
		{
			jConfirm('Xin bạn vui lòng đăng nhập để sử dụng tính năng này!<br/>Bạn hãy click vào OK để đến trang đăng nhập.','Yêu cầu đăng nhập',function(r){
				if(r == true){
					window.location.href = baseurl+'login';
				}else{
					return false;
				}
			});
		}
	}
	function votedownanswers(baseurl,userid,answersid)
	{
		if(userid !='' && userid != 0)
		{
			jQuery.ajax({
				type: "POST",
				url: baseurl + "hoidap/ajaxvoteans",
				data: "answersid=" + answersid+"&type=down",
				success: function(data){
					jQuery('#vote_down_answer_'+answersid).html('<b class="vote_down">('+data+')</b>');
				},
				error: function(){}
			});
		}
		else
		{
			jConfirm('Xin bạn vui lòng đăng nhập để sử dụng tính năng này!<br/>Bạn hãy click vào OK để đến trang đăng nhập.','Yêu cầu đăng nhập',function(r){
				if(r == true){
					window.location.href = baseurl+'login';
				}else{
					return false;
				}
			});
		}
	}
	function editanswer(ansid){
		jQuery('#editAnswerId').val(ansid);
		tinyMCE.get('txtContent').setContent(jQuery('#answer_content_'+ansid).html());
		jQuery("#hoidap_reply").show();
		jQuery(window).scrollTop(jQuery("#hoidap_reply").offset().top - 40);
	}
	function deleteanswer(baseurl,ansid,hdsid){
		jConfirm('Bạn muốn xóa câu trả lời này không?<br/>Bạn hãy click vào OK để xóa.','Xóa câu trả lời',function(r){
			if(r == true){
				jQuery.ajax({
				type: "POST",
				url: baseurl + "hoidap/ajaxdeleteans",
				data: "answersid=" + ansid+"&hdsid="+hdsid,
				success: function(data){
					  window.location.reload();
				},
				error: function(){}
			});
			}else{
				return false;
			}
		});
	}
</script>
<!--BEGIN: CENTER-->


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
   CheckInput_PostHdsReply();
   return false;
   }
else
   return true;
}
//-->
</SCRIPT>
<style>
.hoidapBackrum{
	height: 25px;
   
    overflow: hidden;
    padding-left: 20px;
}
</style>


<td valign="top" >
<div class="hoidapBackrum">
    <div class="bgrumQ" >
		<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>templates/home/css/move/views-home-hoidap-detail.css" />
      <div class="bgrumQHome"> <a href="<?php echo base_url() ?>" class="home">Home</a> <img src="<?php echo base_url(); ?>templates/shop/style2/images/navigate_icon.gif" alt="" /> </div>
      	<div id="sub_cateory_bgrum">
        	   <a href="<?php echo base_url();  ?>hoidap">
                        Hỏi đáp
                       <img alt="" src="<?php echo base_url(); ?>templates/home/images/navigate_icon.gif"/>
                   </a>
        </div>
    
          <div class="sub_cateory_bgrum"> 
        	<?php echo $raovat_sub; ?>
        </div>
      <?php if(isset($CategorysiteGlobalRoot->cat_id)) { ?>
      <div id="CategorysiteGlobalRoot"> <a href="<?php echo base_url()?>hoidap/<?php echo $CategorysiteGlobalRoot->cat_id; ?>/<?php echo RemoveSign($CategorysiteGlobalRoot->cat_name);?>"><?php echo mb_substr($CategorysiteGlobalRoot->cat_name,0,30,'UTF-8'); ?></a>
        <?php if(isset($CategorysiteRootConten)) { ?>
        <div class="CategorysiterootConten"> <?php echo $CategorysiteRootConten; ?> </div>
        <?php } ?>
        <?php if($CategorysiteRootConten!="") { ?>
        <img alt="" src="<?php echo base_url(); ?>templates/home/images/navigate_icon.gif"/>
        <?php } else {?>
        <img src="<?php echo base_url(); ?>templates/shop/style2/images/navigate_icon.gif" alt="" />
        <?php 
                         }
                         ?>
      </div>
      <?php    } ?>
      <?php if(isset($CategorysiteGlobal->cat_id)) { ?>
      <div id="CategorysiteGlobal"> <a  href="<?php echo base_url()?>hoidap/<?php echo $CategorysiteGlobal->cat_id; ?>/<?php echo RemoveSign($CategorysiteGlobal->cat_name);?>"><?php echo mb_substr($CategorysiteGlobal->cat_name,0,30,'UTF-8'); ?></a>
        <?php if(isset($CategorysiteGlobalConten)) { ?>
        <div class="CategorysiteGlobalConten"> <?php echo $CategorysiteGlobalConten; ?> </div>
        <?php } ?>
        <?php if($CategorysiteGlobalConten!="") { ?>
        <img alt=""  src="<?php echo base_url(); ?>templates/home/images/navigate_icon.gif"/>
        <?php } else {?>
        <img src="<?php echo base_url(); ?>templates/shop/style2/images/navigate_icon.gif" alt="" />
        <?php 
                         }
                         ?>
      </div>
      <?php    } ?>
      <?php if(isset($siteGlobal->cat_id)) { ?>
      <div <?php if($shop_glonal_conten!="")  {  echo "id=\"shop_glonal_conten_ho\""; } ?> style="float:left"> <a  href="<?php echo base_url()?>hoidap/<?php echo $siteGlobal->cat_id; ?>/<?php echo RemoveSign($siteGlobal->cat_name);?>"><?php echo mb_substr($siteGlobal->cat_name,0,30,'UTF-8');  if(strlen($siteGlobal->cat_name)>30) { echo "....";} ?></a>
        <?php if(isset($shop_glonal_conten)) { ?>
        <div class="shop_glonal_conten"> <?php echo $shop_glonal_conten; ?> </div>
        <?php if($shop_glonal_conten!="") { ?>
        <img alt=""  src="<?php echo base_url(); ?>templates/home/images/navigate_icon.gif"/>
        <?php } else {?>
        <img src="<?php echo base_url(); ?>templates/shop/style2/images/navigate_icon.gif" alt="" />
        <?php 
                         }
                         ?>
        <?php } ?>
      </div>
      <?php    } ?>
      <span>
      <?php
				
				 echo mb_substr($hds->hds_title,0,30,'UTF-8');
				 ?>
      </span> </div>
  </div>
  
  
  <div style="display:none;">
<p>
<div xmlns:v="http://rdf.data-vocabulary.org/#" class="breadcrumbs-title">
<span typeof="v:Breadcrumb">
<a rel="v:url" property="v:title"   href="<?php echo base_url() ?>" class="home">Home</a> 
</span>


<span class="separator">»</span>
<span typeof="v:Breadcrumb">
 <a rel="v:url" property="v:title"  href="<?php echo base_url();  ?>hoidap" title="Hỏi đáp"> Hỏi đáp </a></span> <span class="separator">»</span> 
<?php if(isset($CategorysiteGlobalRoot->cat_id)) { ?>
<span typeof="v:Breadcrumb">
<a rel="v:url" property="v:title"  href="<?php echo base_url()?>hoidap/<?php echo $CategorysiteGlobalRoot->cat_id; ?>/<?php echo RemoveSign($CategorysiteGlobalRoot->cat_name);?>" title="<?php echo $CategorysiteGlobalRoot->cat_name; ?>"><?php echo mb_substr($CategorysiteGlobalRoot->cat_name,0,30,'UTF-8'); ?></a> 
</span>
<span class="separator">»</span>
<?php    } ?>
<?php if(isset($CategorysiteGlobal->cat_id)) { ?>
<span typeof="v:Breadcrumb">
<a rel="v:url" property="v:title" href="<?php echo base_url()?>hoidap/<?php echo $CategorysiteGlobal->cat_id; ?>/<?php echo RemoveSign($CategorysiteGlobal->cat_name);?>" title="<?php echo $CategorysiteGlobal->cat_name; ?>"><?php echo mb_substr($CategorysiteGlobal->cat_name,0,30,'UTF-8'); ?></a>
</span>

 <span class="separator">»</span>
<?php    } ?>
<?php if($siteGlobal->cat_id!="") ?>
<?php { ?>
<span typeof="v:Breadcrumb">
 <a  rel="v:url" property="v:title" href="<?php echo base_url()?>hoidap/<?php echo $siteGlobal->cat_id; ?>/<?php echo RemoveSign($siteGlobal->cat_name);?>" title="<?php echo $siteGlobal->cat_name; ?>">
 <?php echo $siteGlobal->cat_name; ?>
 </a>
 </span>
 <span class="separator">»</span>
 <?php  echo $hds->hds_title; ?>
<?php  } ?>
</div>
</p>
</div>


  
  <div class="h1-styleding">
       <h1><?php echo $titleSiteGlobal; ?></h1>
  </div>
             
             

<div class="hoidap_detail" style="margin-top: 10px; margin-right: 10px;">

             
             
    <div class="user">
      <div class="avatar_xx_small"> <a href="<?php echo base_url() ;  ?>user/profile/<?php echo $hds->use_id ;  ?>"><img alt="<?php echo ($hds->hds_title);?>" width="50" height="50" src="<?php if($hds->avatar !=''){echo base_url().'media/images/avatar/'.$hds->avatar;}else{echo  base_url().'media/images/avatar/default.png';}?>" /></a> </div>
    </div>
    <div class="data data_question">
      <div class="arrow"></div>
      <div class="description">
       <!-- <h1 style="font-size:18px; color:#E97D13; margin:0; padding:0; margin-bottom:10px;"><?php echo $hds->hds_title;?></h1>-->
        <div class="hoidap_description">
          <p class="p_first p_last"><?php echo $hds->hds_content;?></p>
        </div>
      </div>
      <div style="clear:both"></div>
      <div style="float: left; font-size:11px;">
        <div> 
        	<span class=""> 
            	<a title="Thích câu này" style="cursor:pointer" onclick="voteuphd('<?php echo base_url(); ?>','<?php echo $user_id;?>','<?php echo $hds->hds_id;?>');" onmousemove="changeok('<?php echo base_url(); ?>','hds_up');" onmouseout="changeoff('<?php echo base_url(); ?>','hds_up');"> 
                	<img id="hds_up" src="<?php echo base_url(); ?>templates/home/images/thumb_up.gif" alt="" />&nbsp;Thích</a> 
                    <span id="vote_up_hd"><b class="vote_up">(<?php echo $hds->hds_like;?>)</b></span> &nbsp; 
                <a title="Không thích câu này" style="cursor:pointer" onclick="votedownhd('<?php echo base_url(); ?>','<?php echo $user_id;?>','<?php echo $hds->hds_id;?>');" onmousemove="changeok('<?php echo base_url(); ?>','hds_down');" onmouseout="changeoff('<?php echo base_url(); ?>','hds_down');"> 
                	<img id="hds_down" src="<?php echo base_url(); ?>templates/home/images/thumb_down.gif" alt="" />&nbsp;Không thích</a> 
                    <span id="vote_down_hd"><b class="vote_down">(<?php echo $hds->hds_unlike;?>)</b></span>
            </span> &nbsp; 
              <span class="sep">|</span>&nbsp; 
               <span onclick="update_theo_doi_hoi_dap('<?php echo base_url() ?>account/','<?php echo $hds->hds_id; ?>','<?php echo $this->session->userdata('sessionUser'); ?>','<?php echo $hds->hds_theo_doi; ?>');"  ><a class='theohoihoidap' >&nbsp;Theo dõi</a></span> &nbsp;
           
            
            <span class="sep">|</span>&nbsp; 
            <span><img src="<?php echo base_url(); ?>templates/home/images/icon_view.png" alt="" />&nbsp;Xem:</span> <b><?php echo $hds->hds_view;?></b> &nbsp; 
            <span class="sep">|</span>&nbsp; 
            <span><img src="<?php echo base_url(); ?>templates/home/images/icon_thumb_reply.gif" alt="" />&nbsp;Trả lời:</span> <b><?php echo $hds->hds_answers;?></b> &nbsp;<span class="sep">|</span>&nbsp;</span>
            <span class="hover hidden"> &nbsp;<span class="sep">|</span>&nbsp;</span> <span>      <a class="menu" onclick="baocaohoidapxau('<?php echo base_url();?>','<?php echo $hds->hds_id; ?>','<?php echo $this->session->userdata('sessionUser'); ?>');"  style="cursor:pointer;">
                                            <img src="<?php echo base_url(); ?>templates/home/images/send_fail.png" border="0" alt="" /> <?php echo $this->lang->line('send_bad_detail'); ?>
                                        </a>  </span></div>
         
        <div class="magin_top"> <span>Ngày gửi:</span> <?php echo $hds->up_date;?> &nbsp;  </div>
      </div>
      <div style="float:right;"> <a class="reply_btn" href="javascript:;" onclick="hoidapAddReply('<?php echo base_url(); ?>','<?php echo $user_id;?>');"><span>Trả lời</span></a> </div>
      <div style="clear:both"></div>
    </div>
    <div style="clear:both; padding-top:10px;"></div>
    <!-- AddThis Button BEGIN -->
<div class="addthis_toolbox addthis_default_style ">
<a class="addthis_button_preferred_1"></a>
<a class="addthis_button_preferred_2"></a>
<a class="addthis_button_preferred_3"></a>
<a class="addthis_button_preferred_4"></a>
<a class="addthis_button_compact"></a>
<a class="addthis_counter addthis_bubble_style"></a>
</div>
<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-4fd98edf3c3558e8"></script>
<!-- AddThis Button END -->
    <?php /*?><div class="addthis" style="padding-left:70px; padding-bottom:20px;" >
              <div class="addThisIcon">
                <div class="addThisShareFace"> <a rel="nofollow" href="http://static.vatgia.com" title="Chia sẻ qua Facebook." > <img src="<?php echo base_url(); ?>templates/home/images/icon_facebook_share.gif" border="0"/> </a> </div>
                <script >
								jQuery(document).ready(function(){									
 var pathname = "http://www.facebook.com/sharer.php?u="+window.location;

									jQuery(".addThisShareFace a").attr('href',pathname);
										
								});
							</script> 
              </div>
              <div class="addThisIcon"> <a class="addthis_button_facebook_like" fb:like:layout="button_count"></a> </div>
              <div class="addThisIcon" style="width:50px;position:relative;"> <a class="addthis_button_google_plusone" g:plusone:size="medium"></a> </div>
              <div class="addThisIcon" style="width:50px; position:relative;"> <a href="https://twitter.com/share" class="twitter-share-button">Tweet</a> 
                <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script> 
              </div>
              <div style="clear:both;">
              </div>
               <div class="addThisIcon" > 
                <script type="text/javascript">
(function() {
var s = document.createElement('SCRIPT'), s1 = document.getElementsByTagName('SCRIPT')[0];
s.type = 'text/javascript';
s.async = true;
s.src = 'http://widgets.digg.com/buttons.js';
s1.parentNode.insertBefore(s, s1);
})();
</script> 
                <a class="DiggThisButton DiggCompact"></a> </div>
              <div class="addThisIcon"> 
                <script src="//platform.linkedin.com/in.js" type="text/javascript"></script> 
                <script type="IN/Share" data-counter="right"></script> 
              </div>
              <div class="addThisIcon"> <a class="ultLH" title="Chia sẻ tin lên LinkHay.com" href="javascript:(function(){var d=document,f='http://linkhay.com/submit',l=d.location,e=encodeURIComponent,p='?url='+e(l.href)+'&title='+e(d.title)+'&utm_source=VOV&utm_medium=embedded&utm_campaign=lh_button';if(!window.open(f+p,'sharer','toolbar=0,status=0,resizable=1,width=800,height=450'))l.href=f+p})();" rel="nofollow"><font color="#FF0000" style="font-weight:bold;"><img src="<?php echo base_url(); ?>templates/home/images/linkhay.png" border="0" alt="" /></font></a> </div>
            </div><?php */?>
        <?php /*?>    <script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-4fa8c3be2248d92e"></script>
            
            </div><?php */?>
            
  </div>
  
  
    <div style="clear:both"></div>
    
  <div id="reply_list" class="hoidap_reply">
    <h2 style="color: #E97D13; font-size: 16px;font-weight: bold;line-height: 22px; margin-bottom: 5px;">Danh sách trả lời <b class="count">(<?php echo $totalRecord;?>)</b></h2>
    <?php if(isset($hds_answers)){ foreach($hds_answers as $item){?>
    <div id="reply_<?php echo $item->answers_id;?>">
      <div class="user">
        <div class="avatar_xx_small"><a href="<?php echo base_url() ;  ?>user/profile/<?php echo $item->use_id ;  ?>"><img alt="<?php echo ($item->hds_title);?>" width="50" height="50" src="<?php if($item->avatar !=''){echo base_url().'media/images/avatar/'.$item->avatar;}else{echo  base_url().'media/images/avatar/default.png';}?>" /></a>         
         </div>
        <div class="loginname"><?php echo $item->use_fullname;?></div>
      </div>
      <div class="data">
        <div class="arrow"></div>
        <div class="description">
          <div class="reply_description" id="answer_content_<?php echo $item->answers_id;?>">
            <?php echo $item->answers_content;?>
          </div>
        </div>
        <div class="information">
          <div> 
              <span class="thumb"> 
              	<?php if($item->answers_user != $user_id){?>
                <a title="Thích câu này" onclick="voteupanswers('<?php echo base_url(); ?>','<?php echo $user_id;?>','<?php echo $item->answers_id;?>');" style="cursor:pointer" onmousemove="changeok('<?php echo base_url(); ?>','hds_up_<?php echo $item->answers_id?>');" onmouseout="changeoff('<?php echo base_url(); ?>','hds_up_<?php echo $item->answers_id?>');">
                    <img id="hds_up_<?php echo $item->answers_id?>" src="<?php echo base_url(); ?>templates/home/images/thumb_up.gif" alt="" />&nbsp;Thích</a> 
                    <span id="vote_up_answer_<?php echo $item->answers_id;?>"><b class="vote_up">(<?php echo $item->answers_like;?>)</b></span> &nbsp; 
                <a title="Không thích câu này" onclick="votedownanswers('<?php echo base_url(); ?>','<?php echo $user_id;?>','<?php echo $item->answers_id;?>');" style="cursor:pointer" onmousemove="changeok('<?php echo base_url(); ?>','hds_down_<?php echo $item->answers_id?>');" onmouseout="changeoff('<?php echo base_url(); ?>','hds_down_<?php echo $item->answers_id?>');">
                    <img id="hds_down_<?php echo $item->answers_id?>" src="<?php echo base_url(); ?>templates/home/images/thumb_down.gif" alt="" />&nbsp;Không thích</a> 
                    <span id="vote_down_answer_<?php echo $item->answers_id;?>"><b class="vote_down">(<?php echo $item->answers_unlike;?>)</b> </span>
                     <a class="menu" onclick="baocaotraloixau('<?php echo base_url();?>','<?php echo $item->answers_id; ?>','<?php echo $this->session->userdata('sessionUser'); ?>');"  style="cursor:pointer;">
                                            <img src="<?php echo base_url(); ?>templates/home/images/send_fail.png" border="0" alt="" /> <?php echo $this->lang->line('send_bad_detail'); ?>
                                        </a> 
                                        
                  <?php }else{?>
                  <a title="sửa" style="cursor:pointer;" onclick="editanswer('<?php echo $item->answers_id;?>');">
                  	<img id="edit_<?php echo $item->answers_id?>" src="<?php echo base_url(); ?>templates/home/images/icon_edit.gif" alt="" />&nbsp;Sửa
                  </a>&nbsp;
                  <a title="xóa" style="cursor:pointer;" onclick="deleteanswer('<?php echo base_url(); ?>','<?php echo $item->answers_id;?>','<?php echo $hds->hds_id;?>');">
                  	<img id="delete_<?php echo $item->answers_id?>" src="<?php echo base_url(); ?>templates/home/images/icon_remove.gif" alt="" />&nbsp;Xóa
                  </a>
                  <?php } ?>
              </span> 
              <span class="hover hidden"> &nbsp;<span class="sep">|</span>&nbsp; </span> 
          </div>
          <div class="magin_top"> <span>Ngày gửi:</span> <?php echo $item->up_date;?><span class="hover hidden"> &nbsp;<span class="sep">|</span>&nbsp; </span> </div>
        </div>
      </div>
      <div style="clear:both"></div>
      <div class="break_content_line"></div>
    </div>
    <?php }}?>
  </div>
  <div style="text-align:center;"><?php echo $linkPage; ?></div>
  <?php if($totalRecord>0){?>
  <div style="float:right; margin-right:10px;"> <a class="reply_btn" href="javascript:;" onclick="hoidapAddReply('<?php echo base_url(); ?>','<?php echo $user_id;?>');"><span>Trả lời</span></a> </div>
  <?php } ?>
  <div style="clear:both"></div>
  <div id="hoidap_reply" style="display:none;">
    <form method="post" id="frmHoidapReply" name="frmHoidapReply">
      <div>
        <h2 style="color: #E97D13; font-size: 16px;font-weight: bold;line-height: 22px; margin-bottom: 5px;">Trả lời của bạn</h2>
      </div>
      <div style="text-align:center">
        <?php $this->load->view('admin/common/tinymce'); ?>
        <table style="width:100%">
          <tr>
            <td align="center"><textarea name="txtContent" id="txtContent"></textarea>
            </td>
          </tr>
        </table>
      </div>
      <div style="text-align:center; margin-top:10px;"> <img src="<?php echo $imageCaptchaPostHdsReply; ?>" width="151" height="30" alt="" /><br />
        <input type="text" name="captcha_hds" id="captcha_hds" value="" maxlength="10" class="inputcaptcha_form" onfocus="ChangeStyle('captcha_hds',1);" onblur="ChangeStyle('captcha_hds',2);" onKeyPress="return submitenter(this,event)" />
        <input type="hidden" id="captcha" name="captcha" value="<?php echo $captcha;?>"/>
        <input type="hidden" id="isPostHdsReply" name="isPostHdsReply" value=""/>
        <input type="hidden" id="isEditHdsReply" name="isEditHdsReply" value=""/>
        <input type="hidden" id="editAnswerId" name="editAnswerId" value=""/>
        <br/>
        <br/>
       

        <input type="button" onclick="CheckInput_PostHdsReply();" name="submit_posthds" value="<?php echo $this->lang->line('button_agree_post'); ?>" class="button_form" />
        <input type="reset" name="reset_posthds" value="<?php echo $this->lang->line('button_reset_post'); ?>" class="button_form" />
      </div>
    </form>
  </div>
  
  <div class="content">
   <h2 style="color: #E97D13; font-size: 16px;font-weight: bold;line-height: 22px; margin-bottom: 5px;">Danh sách câu hỏi liên quan <b class="count">(<?php echo count($relatedQuestion);?>)</b></h2>
    <div class="list_link"><ul>
	<?php if(isset($relatedQuestion)){ foreach($relatedQuestion as $item){?>
    
    <li>
    <a href="<?php echo base_url(); ?>hoidap/<?php echo $item->hds_category; ?>/<?php echo $item->hds_id; ?>/<?php echo RemoveSign($item->hds_title); ?>">
    <?php echo $item->hds_title; ?>
    </a>
    </li>
    
    <?php } } ?>
    </ul>
  </div>
  </div>
  
 
  
  </td>
<!-- END CENTER-->
<?php $this->load->view('home/common/right'); ?>
<?php $this->load->view('home/common/footer'); ?>
