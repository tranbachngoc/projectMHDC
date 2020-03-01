<?php $this->load->view('home/common/header'); ?>


<td valign="top"><div class="navigate">
    <div class="L"></div>
    <div class="C"> <a href="<?php echo base_url() ?>" class="home">Home</a> <img src="<?php echo base_url(); ?>templates/shop/style2/images/navigate_icon.gif" alt="" /><span style="font-size:13px;">Hỏi đáp</span> </div>
    <div class="R"></div>
  </div>
  <div style="display:none;">
    <p>
    <div xmlns:v="http://rdf.data-vocabulary.org/#" class="breadcrumbs-title"> <span typeof="v:Breadcrumb"> <a rel="v:url" property="v:title"   href="<?php echo base_url() ?>" class="home">Home</a> </span> <span class="separator">»</span> Hỏi đáp </div>
    </p>
  </div>
  <?php if(count($topNews) >0){?>
  <div class="temp_3">
    <div class="title" style="margin-right:10px; margin-bottom:5px;">
      <div class="fl">
        <h2><a href="<?php echo base_url(); ?>hoidap/moinhat"><?php echo $this->lang->line('title_new_category'); ?></a></h2>
      </div>
    </div>
    <div class="content">
      <?php $idDiv=0;?>
      <?php foreach($topNews as $item){ ?>
      <div style="height: auto; margin-bottom:5px;">
        <div class="avatar_xx_small">
          <form class="k_hidden_form" action="" method="post">
            <input type="hidden" id="name-<?php echo $item->use_id.'_new'.$idDiv;?>" class="name-<?php echo $item->use_id;?>" value="<?php echo $item->use_fullname;?>"/>
            <input type="hidden" id="image-<?php echo $item->use_id.'_new'.$idDiv;?>" class="image-<?php echo $item->use_id;?>" value="<?php if($item->avatar !=''){echo base_url().'media/images/avatar/'.$item->avatar;}else{echo  base_url().'media/images/avatar/default.png';}?>"/>
            <input type="hidden" id="user-<?php echo $item->use_id.'_new'.$idDiv;?>" class="user-<?php echo $item->use_id;?>" value="<?php echo $item->use_username;?>"/>
            <input type="hidden" id="ngaythamgia-<?php echo $item->use_id.'_new'.$idDiv;?>" class="email-<?php echo $item->use_id;?>" value="<?php echo date('d/m/Y',Counter_model::getUSerIdNameNgayThamGia($item->use_id)); ?>"/>
            <input type="hidden" id="sanpham-<?php echo $item->use_id.'_new'.$idDiv;?>" class="email-<?php echo $item->use_id;?>" value="<?php echo Counter_model::countUserBussinesAll($item->use_id,"tbtt_product","pro_user"); ?>"/>
            <input type="hidden" id="raovat-<?php echo $item->use_id.'_new'.$idDiv;?>" class="email-<?php echo $item->use_id;?>" value="<?php echo Counter_model::countUserBussinesAll($item->use_id,"tbtt_ads","ads_user"); ?>"/>
            <input type="hidden" id="hoidap-<?php echo $item->use_id.'_new'.$idDiv;?>" class="email-<?php echo $item->use_id;?>" value="<?php echo Counter_model::countUserBussinesAll($item->use_id,"tbtt_hds","hds_user"); ?>"/>
            <input type="hidden" id="traloi-<?php echo $item->use_id.'_new'.$idDiv;?>" class="email-<?php echo $item->use_id;?>" value="<?php echo Counter_model::countUserBussinesAll($item->use_id,"tbtt_answers","answers_user"); ?>"/>
          </form>
          <a href="<?php echo base_url(); ?>user/profile/<?php echo $item->hds_user;  ?>"><img alt="<?php echo ($item->hds_title);?>" width="50" height="50" src="<?php if($item->avatar !=''){echo base_url().'media/images/avatar/'.$item->avatar;}else{echo  base_url().'media/images/avatar/default.png';}?>" onmouseover="tooltipPictureUser(this,'<?php echo $item->use_id.'_new'.$idDiv;?>')" /></a> </div>
        <div class="data">
          <div class="name">
            <form class="k_hidden_form" action="" method="post">
              <input type="hidden" id="title-<?php echo $item->hds_id.'_topNews'.$idDiv;?>" value="<?php echo $item->hds_title;?>"/>
              <input type="hidden" id="thongtinrutgon-<?php echo $item->hds_id.'_topNews'.$idDiv;?>" value="<?php echo cut_string_unicodeutf8($item->hds_content,160); ?>" />
            </form>
            <a href="<?php echo base_url(); ?>user/profile/<?php echo $item->hds_user;  ?>" class="text_link_bold"><?php echo $item->hds_username;?></a> <a href="<?php echo base_url(); ?>hoidap/<?php echo $item->hds_category; ?>/<?php echo $item->hds_id; ?>/<?php echo RemoveSign($item->hds_title); ?>" class="vtip" title="<b ><font color='#E47911'><?php echo $item->hds_title; ?></font></b>&nbsp;&nbsp;<?php   $vovel=array("&curren;","<p>","</p>"); echo cut_string_unicodeutf8(strip_tags(html_entity_decode(str_replace($vovel," ",$item->hds_content))),260); if(strlen($item->hds_content)>260) { echo "....";} ?> "  > <?php echo $item->hds_title;?></a> <span> (<span class="view" title="Lượt xem: <?php echo $item->hds_view;?>"><?php echo $item->hds_view;?></span>&nbsp; <span class="reply" title="Trả lời: <?php echo $item->hds_answers;?>"><?php echo $item->hds_answers;?></span>&nbsp; <span class="thumb_up" title="Câu hỏi hữu ích: <?php echo $item->hds_like;?> người chọn"><?php echo $item->hds_like;?></span> <span class="thumb_down" title="Không thích câu này: <?php echo $item->hds_unlike;?>"><?php echo $item->hds_unlike;?></span>) </span> 
            <!--<pre class="hidden">


          <div class="teaser"></div>


</pre>--> 
          </div>
          <div class="update"><?php echo show_time($item->up_date);?> <span> trong </span><a class="text_link_pale" href="<?php echo base_url(); ?>hoidap/<?php echo $item->hds_category; ?>/<?php echo RemoveSign($item->cat_name);?>"><?php echo $item->cat_name;?></a></div>
        </div>
        <div style="clear:both"></div>
        <div class="break_module_line"></div>
      </div>
      <?php $idDiv++; } ?>
    </div>
  </div>
  <?php } ?>
  <div style="clear:both; padding-top:10px;"> </div>
  <a href="<?php echo base_url(); ?>hoidap/post"> <img src="<?php echo base_url(); ?>/templates/home/images/danghoidap.png"  /> </a>
  <?php if(count($topNotAnswers) >0){?>
  <div class="temp_3">
    <div class="title" style="margin-right:10px; margin-bottom:5px;">
      <div class="fl">
        <h2><a href="<?php echo base_url(); ?>hoidap/chuatraloi"><?php echo $this->lang->line('title_not_answers'); ?></a></h2>
      </div>
    </div>
    <div class="content">
      <?php $idDiv=0;?>
      <?php foreach($topNotAnswers as $item){ ?>
      <div style="height: auto; margin-bottom:5px;">
        <form class="k_hidden_form" action="" method="post">
          <input type="hidden" id="name-<?php echo $item->use_id.'_topNotAnswers'.$idDiv;?>" class="name-<?php echo $item->use_id;?>" value="<?php echo $item->use_fullname;?>"/>
          <input type="hidden" id="image-<?php echo $item->use_id.'_topNotAnswers'.$idDiv;?>" class="image-<?php echo $item->use_id;?>" value="<?php if($item->avatar !=''){echo base_url().'media/images/avatar/'.$item->avatar;}else{echo  base_url().'media/images/avatar/default.png';}?>"/>
          <input type="hidden" id="user-<?php echo $item->use_id.'_topNotAnswers'.$idDiv;?>" class="user-<?php echo $item->use_id;?>" value="<?php echo $item->use_username;?>"/>
          <input type="hidden" id="ngaythamgia-<?php echo $item->use_id.'_topNotAnswers'.$idDiv;?>" class="email-<?php echo $item->use_id;?>" value="<?php echo date('d/m/Y',Counter_model::getUSerIdNameNgayThamGia($item->use_id)); ?>"/>
          <input type="hidden" id="sanpham-<?php echo $item->use_id.'_topNotAnswers'.$idDiv;?>" class="email-<?php echo $item->use_id;?>" value="<?php echo Counter_model::countUserBussinesAll($item->use_id,"tbtt_product","pro_user"); ?>"/>
          <input type="hidden" id="raovat-<?php echo $item->use_id.'_topNotAnswers'.$idDiv;?>" class="email-<?php echo $item->use_id;?>" value="<?php echo Counter_model::countUserBussinesAll($item->use_id,"tbtt_ads","ads_user"); ?>"/>
          <input type="hidden" id="hoidap-<?php echo $item->use_id.'_topNotAnswers'.$idDiv;?>" class="email-<?php echo $item->use_id;?>" value="<?php echo Counter_model::countUserBussinesAll($item->use_id,"tbtt_hds","hds_user"); ?>"/>
          <input type="hidden" id="traloi-<?php echo $item->use_id.'_topNotAnswers'.$idDiv;?>" class="email-<?php echo $item->use_id;?>" value="<?php echo Counter_model::countUserBussinesAll($item->use_id,"tbtt_answers","answers_user"); ?>"/>
        </form>
        <div class="avatar_xx_small"> <a href="<?php echo base_url(); ?>user/profile/<?php echo $item->hds_user;  ?>"><img alt="<?php echo ($item->hds_title);?>" width="50" height="50" src="<?php if($item->avatar !=''){echo base_url().'media/images/avatar/'.$item->avatar;}else{echo  base_url().'media/images/avatar/default.png';}?>" onmouseover="tooltipPictureUser(this,'<?php echo $item->use_id.'_topNotAnswers'.$idDiv;?>')" /></a> </div>
        <div class="data">
          <div class="name">
            <form class="k_hidden_form" action="" method="post">
              <input type="hidden" id="title-<?php echo $item->hds_id.'_topNotAnswers'.$idDiv;?>" value="<?php echo $item->hds_title;?>"/>
              <input type="hidden" id="thongtinrutgon-<?php echo $item->hds_id.'_topNotAnswers'.$idDiv;?>" value="<?php echo cut_string_unicodeutf8($item->hds_content,160); ?>" />
            </form>
            <a href="<?php echo base_url(); ?>user/profile/<?php echo $item->hds_user;  ?>" class="text_link_bold"><?php echo $item->hds_username;?></a> <a href="<?php echo base_url(); ?>hoidap/<?php echo $item->hds_category; ?>/<?php echo $item->hds_id; ?>/<?php echo RemoveSign($item->hds_title); ?>" class="vtip" title="<b ><font color='#E47911'><?php echo $item->hds_title; ?></font></b>&nbsp;&nbsp;<?php   $vovel=array("&curren;","<p>","</p>"); echo cut_string_unicodeutf8(strip_tags(html_entity_decode(str_replace($vovel," ",$item->hds_content))),270); if(strlen($item->hds_content)>270) { echo "....";} ?> "  ><?php echo $item->hds_title;?></a> <span> (<span class="view" title="Lượt xem: <?php echo $item->hds_view;?>"><?php echo $item->hds_view;?></span>&nbsp; <span class="reply" title="Trả lời: <?php echo $item->hds_answers;?>"><?php echo $item->hds_answers;?></span>&nbsp; <span class="thumb_up" title="Câu hỏi hữu ích: <?php echo $item->hds_like;?> người chọn"><?php echo $item->hds_like;?></span> <span class="thumb_down" title="Không thích câu này: <?php echo $item->hds_unlike;?>"><?php echo $item->hds_unlike;?></span>) </span> 
            <!--<pre class="hidden">


          <div class="teaser"></div>


</pre>--> 
          </div>
          <div class="update"><?php echo show_time($item->up_date);?> <span> trong </span><a class="text_link_pale" href="<?php echo base_url(); ?>hoidap/<?php echo $item->hds_category; ?>/<?php echo RemoveSign($item->cat_name);?>"><?php echo $item->cat_name;?></a></div>
        </div>
        <div style="clear:both"></div>
        <div class="break_module_line"></div>
      </div>
      <?php $idDiv++; }//END foreach ?>
    </div>
  </div>
  <?php } ?>
  <div style="clear:both; padding-top:10px;"> </div>
  <?php if(count($topNotAnswers) >0){?>
  <a href="<?php echo base_url(); ?>hoidap/post"> <img src="<?php echo base_url(); ?>/templates/home/images/danghoidap.png"  /> </a>
  <?php } ?>
  <?php if(count($topAnswers) >0){?>
  <div class="temp_3">
    <div class="title" style="margin-right:10px; margin-bottom:5px;">
      <div class="fl">
        <h2><a href="<?php echo base_url(); ?>hoidap/traloinhieunhat"><?php echo $this->lang->line('title_top_answers'); ?></a></h2>
      </div>
    </div>
    <div class="content">
      <?php $idDiv=0;?>
      <?php foreach($topAnswers as $item){ ?>
      <div style="height: auto; margin-bottom:5px;">
        <form class="k_hidden_form" action="" method="post">
          <input type="hidden" id="name-<?php echo $item->use_id.'_topAnswers'.$idDiv;?>" class="name-<?php echo $item->use_id;?>" value="<?php echo $item->use_fullname;?>"/>
          <input type="hidden" id="image-<?php echo $item->use_id.'_topAnswers'.$idDiv;?>" class="image-<?php echo $item->use_id;?>" value="<?php if($item->avatar !=''){echo base_url().'media/images/avatar/'.$item->avatar;}else{echo  base_url().'media/images/avatar/default.png';}?>"/>
          <input type="hidden" id="user-<?php echo $item->use_id.'_topAnswers'.$idDiv;?>" class="user-<?php echo $item->use_id;?>" value="<?php echo $item->use_username;?>"/>
          <input type="hidden" id="ngaythamgia-<?php echo $item->use_id.'_topAnswers'.$idDiv;?>" class="email-<?php echo $item->use_id;?>" value="<?php echo date('d/m/Y',Counter_model::getUSerIdNameNgayThamGia($item->use_id)); ?>"/>
          <input type="hidden" id="sanpham-<?php echo $item->use_id.'_topAnswers'.$idDiv;?>" class="email-<?php echo $item->use_id;?>" value="<?php echo Counter_model::countUserBussinesAll($item->use_id,"tbtt_product","pro_user"); ?>"/>
          <input type="hidden" id="raovat-<?php echo $item->use_id.'_topAnswers'.$idDiv;?>" class="email-<?php echo $item->use_id;?>" value="<?php echo Counter_model::countUserBussinesAll($item->use_id,"tbtt_ads","ads_user"); ?>"/>
          <input type="hidden" id="hoidap-<?php echo $item->use_id.'_topAnswers'.$idDiv;?>" class="email-<?php echo $item->use_id;?>" value="<?php echo Counter_model::countUserBussinesAll($item->use_id,"tbtt_hds","hds_user"); ?>"/>
          <input type="hidden" id="traloi-<?php echo $item->use_id.'_topAnswers'.$idDiv;?>" class="email-<?php echo $item->use_id;?>" value="<?php echo Counter_model::countUserBussinesAll($item->use_id,"tbtt_answers","answers_user"); ?>"/>
        </form>
        <div class="avatar_xx_small"> <a href="<?php echo base_url(); ?>user/profile/<?php echo $item->hds_user;  ?>"><img alt="<?php echo ($item->hds_title);?>" width="50" height="50" src="<?php if($item->avatar !=''){echo base_url().'media/images/avatar/'.$item->avatar;}else{echo  base_url().'media/images/avatar/default.png';}?>"  onmouseover="tooltipPictureUser(this,'<?php echo $item->use_id.'_topAnswers'.$idDiv;?>')"  /></a> </div>
        <div class="data">
          <div class="name">
            <form class="k_hidden_form" action="" method="post">
              <input type="hidden" id="title-<?php echo $item->hds_id.'_topAnswers'.$idDiv;?>" value="<?php echo $item->hds_title;?>"/>
              <input type="hidden" id="thongtinrutgon-<?php echo $item->hds_id.'_topAnswers'.$idDiv;?>" value="<?php echo cut_string_unicodeutf8($item->hds_content,160); ?>" />
            </form>
            <a href="<?php echo base_url(); ?>user/profile/<?php echo $item->hds_user;  ?>" class="text_link_bold"><?php echo $item->hds_username;?></a> <a href="<?php echo base_url(); ?>hoidap/<?php echo $item->hds_category; ?>/<?php echo $item->hds_id; ?>/<?php echo RemoveSign($item->hds_title); ?>"class="vtip" title="<b ><font color='#E47911'><?php echo $item->hds_title; ?></font></b>&nbsp;&nbsp;<?php   $vovel=array("&curren;","<p>","</p>"); echo cut_string_unicodeutf8(strip_tags(html_entity_decode(str_replace($vovel," ",$item->hds_content))),270); if(strlen($item->hds_content)>270) { echo "....";} ?> "  ><?php echo $item->hds_title;?></a> <span> (<span class="view" title="Lượt xem: <?php echo $item->hds_view;?>"><?php echo $item->hds_view;?></span>&nbsp; <span class="reply" title="Trả lời: <?php echo $item->hds_answers;?>"><?php echo $item->hds_answers;?></span>&nbsp; <span class="thumb_up" title="Câu hỏi hữu ích: <?php echo $item->hds_like;?> người chọn"><?php echo $item->hds_like;?></span> <span class="thumb_down" title="Không thích câu này: <?php echo $item->hds_unlike;?>"><?php echo $item->hds_unlike;?></span>) </span> 
            <!--<pre class="hidden">


          <div class="teaser"></div>


</pre>--> 
          </div>
          <div class="update"><?php echo show_time($item->up_date);?><span> trong </span><a class="text_link_pale" href="<?php echo base_url(); ?>hoidap/<?php echo $item->hds_category; ?>/<?php echo RemoveSign($item->cat_name);?>"><?php echo $item->cat_name;?></a></div>
        </div>
        <div style="clear:both"></div>
        <div class="break_module_line"></div>
      </div>
      <?php $idDiv++; } ?>
    </div>
  </div>
  <?php } ?>
  <div style="clear:both; padding-top:10px;"> </div>
  <a href="<?php echo base_url(); ?>hoidap/post"> <img src="<?php echo base_url(); ?>/templates/home/images/danghoidap.png"  /> </a>
  <?php if(count($topViews) >0){?>
  <div class="temp_3">
    <div class="title" style="margin-right:10px; margin-bottom:5px;">
      <div class="fl">
        <h2><a href="<?php echo base_url(); ?>hoidap/xemnhieunhat"><?php echo $this->lang->line('title_top_view'); ?></a></h2>
      </div>
    </div>
    <div class="content">
      <?php $idDiv=0;?>
      <?php foreach($topViews as $item){ ?>
      <div style="height: auto; margin-bottom:5px;">
        <div class="avatar_xx_small">
          <form class="k_hidden_form" action="" method="post">
            <input type="hidden" id="name-<?php echo $item->use_id.'_topViews'.$idDiv;?>" class="name-<?php echo $item->use_id;?>" value="<?php echo $item->use_fullname;?>"/>
            <input type="hidden" id="image-<?php echo $item->use_id.'_topViews'.$idDiv;?>" class="image-<?php echo $item->use_id;?>" value="<?php if($item->avatar !=''){echo base_url().'media/images/avatar/'.$item->avatar;}else{echo  base_url().'media/images/avatar/default.png';}?>"/>
            <input type="hidden" id="user-<?php echo $item->use_id.'_topViews'.$idDiv;?>" class="user-<?php echo $item->use_id;?>" value="<?php echo $item->use_username;?>"/>
            <input type="hidden" id="ngaythamgia-<?php echo $item->use_id.'_topViews'.$idDiv;?>" class="email-<?php echo $item->use_id;?>" value="<?php echo date('d/m/Y',Counter_model::getUSerIdNameNgayThamGia($item->use_id)); ?>"/>
            <input type="hidden" id="sanpham-<?php echo $item->use_id.'_topViews'.$idDiv;?>" class="email-<?php echo $item->use_id;?>" value="<?php echo Counter_model::countUserBussinesAll($item->use_id,"tbtt_product","pro_user"); ?>"/>
            <input type="hidden" id="raovat-<?php echo $item->use_id.'_topViews'.$idDiv;?>" class="email-<?php echo $item->use_id;?>" value="<?php echo Counter_model::countUserBussinesAll($item->use_id,"tbtt_ads","ads_user"); ?>"/>
            <input type="hidden" id="hoidap-<?php echo $item->use_id.'_topViews'.$idDiv;?>" class="email-<?php echo $item->use_id;?>" value="<?php echo Counter_model::countUserBussinesAll($item->use_id,"tbtt_hds","hds_user"); ?>"/>
            <input type="hidden" id="traloi-<?php echo $item->use_id.'_topViews'.$idDiv;?>" class="email-<?php echo $item->use_id;?>" value="<?php echo Counter_model::countUserBussinesAll($item->use_id,"tbtt_answers","answers_user"); ?>"/>
          </form>
          <a href="<?php echo base_url(); ?>user/profile/<?php echo $item->hds_user;  ?>"><img alt="<?php echo ($item->hds_title);?>" width="50" height="50" src="<?php if($item->avatar !=''){echo base_url().'media/images/avatar/'.$item->avatar;}else{echo  base_url().'media/images/avatar/default.png';}?>" onmouseover="tooltipPictureUser(this,'<?php echo $item->use_id.'_topViews'.$idDiv;?>')"  /></a> </div>
        <div class="data">
          <div class="name">
            <form class="k_hidden_form" action="" method="post">
              <input type="hidden" id="title-<?php echo $item->hds_id.'_topViews'.$idDiv;?>" value="<?php echo $item->hds_title;?>"/>
              <input type="hidden" id="thongtinrutgon-<?php echo $item->hds_id.'_topViews'.$idDiv;?>" value="<?php echo cut_string_unicodeutf8($item->hds_content,160); ?>" />
            </form>
            <a href="<?php echo base_url(); ?>user/profile/<?php echo $item->hds_user;  ?>" class="text_link_bold"><?php echo $item->hds_username;?></a> <a href="<?php echo base_url(); ?>hoidap/<?php echo $item->hds_category; ?>/<?php echo $item->hds_id; ?>/<?php echo RemoveSign($item->hds_title); ?>" class="vtip" title="<b ><font color='#E47911'><?php echo $item->hds_title; ?></font></b>&nbsp;&nbsp;<?php   $vovel=array("&curren;","<p>","</p>"); echo cut_string_unicodeutf8(strip_tags(html_entity_decode(str_replace($vovel," ",$item->hds_content))),270); if(strlen($item->hds_content)>270) { echo "....";} ?> " 
                        ><?php echo $item->hds_title;?></a> <span> (<span class="view" title="Lượt xem: <?php echo $item->hds_view;?>"><?php echo $item->hds_view;?></span>&nbsp; <span class="reply" title="Trả lời: <?php echo $item->hds_answers;?>"><?php echo $item->hds_answers;?></span>&nbsp; <span class="thumb_up" title="Câu hỏi hữu ích: <?php echo $item->hds_like;?> người chọn"><?php echo $item->hds_like;?></span> <span class="thumb_down" title="Không thích câu này: <?php echo $item->hds_unlike;?>"><?php echo $item->hds_unlike;?></span>) </span> 
            <!--<pre class="hidden">


          <div class="teaser"></div>


</pre>--> 
          </div>
          <div class="update"><?php echo show_time($item->up_date);?> <span> trong </span><a class="text_link_pale" href="<?php echo base_url(); ?>hoidap/<?php echo $item->hds_category; ?>/<?php echo RemoveSign($item->cat_name);?>"><?php echo $item->cat_name;?></a></div>
        </div>
        <div style="clear:both"></div>
        <div class="break_module_line"></div>
      </div>
      <?php $idDiv++; } ?>
    </div>
  </div>
  <?php } ?>
  <div style="clear:both; padding-top:10px;"> </div>
  <a href="<?php echo base_url(); ?>hoidap/post"> <img src="<?php echo base_url(); ?>/templates/home/images/danghoidap.png"  /> </a>
  <?php if(count($topLikes) >0){?>
  <div class="temp_3">
    <div class="title" style="margin-right:10px; margin-bottom:5px;">
      <div class="fl">
        <h2><a href="<?php echo base_url(); ?>hoidap/coichnhat"><?php echo $this->lang->line('title_top_good'); ?></a></h2>
      </div>
    </div>
    <div class="content">
      <?php $idDiv=0;?>
      <?php foreach($topLikes as $item){ ?>
      <div style="height: auto; margin-bottom:5px;">
        <div class="avatar_xx_small">
          <form class="k_hidden_form" action="" method="post">
            <input type="hidden" id="name-<?php echo $item->use_id.'_topLikes'.$idDiv;?>" class="name-<?php echo $item->use_id;?>" value="<?php echo $item->use_fullname;?>"/>
            <input type="hidden" id="image-<?php echo $item->use_id.'_topLikes'.$idDiv;?>" class="image-<?php echo $item->use_id;?>" value="<?php if($item->avatar !=''){echo base_url().'media/images/avatar/'.$item->avatar;}else{echo  base_url().'media/images/avatar/default.png';}?>"/>
            <input type="hidden" id="user-<?php echo $item->use_id.'_topLikes'.$idDiv;?>" class="user-<?php echo $item->use_id;?>" value="<?php echo $item->use_username;?>"/>
            <input type="hidden" id="ngaythamgia-<?php echo $item->use_id.'_topLikes'.$idDiv;?>" class="email-<?php echo $item->use_id;?>" value="<?php echo date('d/m/Y',Counter_model::getUSerIdNameNgayThamGia($item->use_id)); ?>"/>
            <input type="hidden" id="sanpham-<?php echo $item->use_id.'_topLikes'.$idDiv;?>" class="email-<?php echo $item->use_id;?>" value="<?php echo Counter_model::countUserBussinesAll($item->use_id,"tbtt_product","pro_user"); ?>"/>
            <input type="hidden" id="raovat-<?php echo $item->use_id.'_topLikes'.$idDiv;?>" class="email-<?php echo $item->use_id;?>" value="<?php echo Counter_model::countUserBussinesAll($item->use_id,"tbtt_ads","ads_user"); ?>"/>
            <input type="hidden" id="hoidap-<?php echo $item->use_id.'_topLikes'.$idDiv;?>" class="email-<?php echo $item->use_id;?>" value="<?php echo Counter_model::countUserBussinesAll($item->use_id,"tbtt_hds","hds_user"); ?>"/>
            <input type="hidden" id="traloi-<?php echo $item->use_id.'_topLikes'.$idDiv;?>" class="email-<?php echo $item->use_id;?>" value="<?php echo Counter_model::countUserBussinesAll($item->use_id,"tbtt_answers","answers_user"); ?>"/>
          </form>
          <a href="<?php echo base_url(); ?>user/profile/<?php echo $item->hds_user;  ?>"><img alt="<?php echo ($item->hds_title);?>" width="50" height="50" src="<?php if($item->avatar !=''){echo base_url().'media/images/avatar/'.$item->avatar;}else{echo  base_url().'media/images/avatar/default.png';}?>" onmouseover="tooltipPictureUser(this,'<?php echo $item->use_id.'_topLikes'.$idDiv;?>')" /></a> </div>
        <div class="data">
          <div class="name">
            <form class="k_hidden_form" action="" method="post">
              <input type="hidden" id="title-<?php echo $item->hds_id.'_topLikes'.$idDiv;?>" value="<?php echo $item->hds_title;?>"/>
              <input type="hidden" id="thongtinrutgon-<?php echo $item->hds_id.'_topLikes'.$idDiv;?>" value="<?php cut_string_unicodeutf8($item->hds_content,160); ?>" />
            </form>
            <a href="<?php echo base_url(); ?>user/profile/<?php echo $item->hds_user;  ?>" class="text_link_bold"><?php echo $item->hds_username;?></a> <a href="<?php echo base_url(); ?>hoidap/<?php echo $item->hds_category; ?>/<?php echo $item->hds_id; ?>/<?php echo RemoveSign($item->hds_title); ?>" class="vtip" title="<b ><font color='#E47911'><?php echo $item->hds_title; ?></font></b>&nbsp;&nbsp;<?php   $vovel=array("&curren;","<p>","</p>"); echo cut_string_unicodeutf8(strip_tags(html_entity_decode(str_replace($vovel," ",$item->hds_content))),270); if(strlen($item->hds_content)>270) { echo "....";} ?> "  ><?php echo $item->hds_title;?></a> <span> (<span class="view" title="Lượt xem: <?php echo $item->hds_view;?>"><?php echo $item->hds_view;?></span>&nbsp; <span class="reply" title="Trả lời: <?php echo $item->hds_answers;?>"><?php echo $item->hds_answers;?></span>&nbsp; <span class="thumb_up" title="Câu hỏi hữu ích: <?php echo $item->hds_like;?> người chọn"><?php echo $item->hds_like;?></span> <span class="thumb_down" title="Không thích câu này: <?php echo $item->hds_unlike;?>"><?php echo $item->hds_unlike;?></span>) </span> 
            <!--<pre class="hidden">


          <div class="teaser"></div>


</pre>--> 
          </div>
          <div class="update"><?php echo show_time($item->up_date);?> <span> trong </span><a class="text_link_pale" href="<?php echo base_url(); ?>hoidap/<?php echo $item->hds_category; ?>/<?php echo RemoveSign($item->cat_name);?>"><?php echo $item->cat_name;?></a></div>
        </div>
        <div style="clear:both"></div>
        <div class="break_module_line"></div>
      </div>
      <?php $idDiv++; } ?>
    </div>
  </div>
  <?php } ?>
  <div style="clear:both; padding-top:10px;"> </div>
  <a href="<?php echo base_url(); ?>hoidap/post"> <img src="<?php echo base_url(); ?>/templates/home/images/danghoidap.png"  /> </a></td>
<!-- END CENTER-->
<?php $this->load->view('home/common/right'); ?>
<?php $this->load->view('home/common/footer'); ?>
