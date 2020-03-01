<?php $this->load->view('home/common/header'); ?>
<?php $this->load->view('home/common/left'); ?>
<script language="javascript" type="text/javascript">
	jQuery(document).ready(function(){
		jQuery('.data').width(jQuery('.content').width() - 100);
	});
</script>
<!--BEGIN: CENTER-->
<td valign="top">
<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>templates/home/css/move/views-home-hoidap-category.css" />
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
  
      <span>
 Hỏi đáp trả lời nhiều nhất
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
   Hỏi đáp trả lời nhiều nhất
</div>
</p>
</div>
  
<div class="temp_3">
	<div class="title" style="margin-right:10px; margin-bottom:5px;">
    	<div class="fl">
            <h2><?php echo $this->lang->line('title_top_answers'); ?></h2>
        </div>
        <div class="fr" style="margin-top:10px;">
            <ul>
              <li><a title="" href="<?php echo base_url() ?>hoidap/latest"><?php echo $this->lang->line('title_top_news'); ?></a></li>
              <li><a title="" href="<?php echo base_url() ?>hoidap/notanswers"><?php echo $this->lang->line('title_top_not_answers'); ?></a></li>
              <li><a title="" href="<?php echo base_url() ?>hoidap/topviews"><?php echo $this->lang->line('title_top_views'); ?></a></li>
              <li><a title="" href="<?php echo base_url() ?>hoidap/toplikes"><?php echo $this->lang->line('title_top_likes'); ?></a></li>
            </ul>
        </div>
    </div>
    <div class="content">
    	<?php foreach($topAnswer as $item){ ?>
        	<div style="height: auto; margin-bottom:5px;">
                <div class="avatar_xx_small">
                        <input type="hidden" id="name-<?php echo $item->use_id;?>" class="name-<?php echo $item->use_id;?>" value="<?php echo $item->use_fullname;?>"/>
                  <input type="hidden" id="image-<?php echo $item->use_id;?>" class="image-<?php echo $item->use_id;?>" value="<?php if($item->avatar !=''){echo base_url().'media/images/avatar/'.$item->avatar;}else{echo  base_url().'media/images/avatar/default.png';}?>"/>
                  <input type="hidden" id="user-<?php echo $item->use_id;?>" class="user-<?php echo $item->use_id;?>" value="<?php echo $item->use_username;?>"/>
                  <input type="hidden" id="ngaythamgia-<?php echo $item->use_id;?>" class="email-<?php echo $item->use_id;?>" value="<?php echo date('d/m/Y',Counter_model::getUSerIdNameNgayThamGia($item->use_id)); ?>"/>
                  <input type="hidden" id="sanpham-<?php echo $item->use_id;?>" class="email-<?php echo $item->use_id;?>" value="<?php echo Counter_model::countUserBussinesAll($item->use_id,"tbtt_product","pro_user"); ?>"/>
               	  <input type="hidden" id="raovat-<?php echo $item->use_id;?>" class="email-<?php echo $item->use_id;?>" value="<?php echo Counter_model::countUserBussinesAll($item->use_id,"tbtt_ads","ads_user"); ?>"/>
                   	  <input type="hidden" id="hoidap-<?php echo $item->use_id;?>" class="email-<?php echo $item->use_id;?>" value="<?php echo Counter_model::countUserBussinesAll($item->use_id,"tbtt_hds","hds_user"); ?>"/>
                      	  <input type="hidden" id="traloi-<?php echo $item->use_id;?>" class="email-<?php echo $item->use_id;?>" value="<?php echo Counter_model::countUserBussinesAll($item->use_id,"tbtt_answers","answers_user"); ?>"/>
                          
                <a href="<?php echo base_url(); ?>user/profile/<?php echo $item->hds_user;  ?>"><img alt="<?php echo ($item->hds_title);?>" width="50" height="50" src="<?php if($item->avatar ==''){echo base_url().'media/images/avatar/default.png';}else{echo  base_url().'media/images/avatar/'.$item->avatar;}?>" onmouseover="tooltipPictureUser(this,'<?php echo $item->use_id;?>')" ></a></div>
                <div class="data">
                	<div class="name">
                      <input type="hidden" id="title-<?php echo $item->hds_id;?>" value="<?php echo $item->hds_title;?>"/>
                         <input type="hidden" id="thongtinrutgon-<?php echo $item->hds_id;?>" value=" <?php $vovel=array("&curren;"); ?> <?php echo sub(html_entity_decode(str_replace($vovel,"#",$item->hds_content)),160); ?>" />


                		<a href="<?php echo base_url(); ?>user/profile/<?php echo $item->hds_user;  ?>" class="text_link_bold"><?php echo $item->hds_username;?></a> 
                        <a href="<?php echo base_url(); ?>hoidap/<?php echo $item->hds_category; ?>/<?php echo $item->hds_id; ?>/<?php echo RemoveSign($item->hds_title); ?>" class="vtip" title="<b ><font color='#E47911'><?php echo $item->hds_title; ?></font></b>&nbsp;&nbsp;<?php   $vovel=array("&curren;","<p>","</p>"); echo mb_substr(strip_tags(html_entity_decode(str_replace($vovel," ",$item->hds_content))),0,270,'UTF-8'); if(strlen($item->hds_content)>270) { echo "....";} ?> "   ><?php echo $item->hds_title;?></a>
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
</div>
<div style="float:right; margin-right:10px;"><?php echo $linkPage; ?></div>
</td>
<!-- END CENTER-->
<?php $this->load->view('home/common/right'); ?>
<?php $this->load->view('home/common/footer'); ?>