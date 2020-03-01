<?php
global $idHome; 
$idHome=1;
?>
<?php $this->load->view('home/common/account/header'); ?>

<td colspan="2"><div id="spt-banner">
  <div id="main_container">
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
      <tbody>
        <tr>
          <td colspan="2"><div id="spt-banner">
              <div  class="spt-banner-tintuc">
                <div class="spt_tintuc_top_left">
                  <div class="spt_tintuc_top_left_img"> <a href="<?php echo base_url() ?>tintuc/detail/<?php echo $tin_tuc_top[0]->not_id; ?>/<?php echo RemoveSign($tin_tuc_top[0]->not_title);?>"> <img src="<?php echo base_url(); ?>media/images/tintuc/<?php echo $tin_tuc_top[0]->not_dir_image; ?>/<?php echo $tin_tuc_top[0]->not_image; ?>" width="420"/> </a> </div>
                  <h3 class="spt_tintuc_top_left_title" > <a href="<?php echo base_url() ?>tintuc/detail/<?php echo $tin_tuc_top[0]->not_id; ?>/<?php echo RemoveSign($tin_tuc_top[0]->not_title);?>"> <?php echo cut_string_unicodeutf8($tin_tuc_top[0]->not_title,110); ?> </a> </h3>
                  <div class="spt_tintuc_top_left_detail">
                    <?php $vovel=array("&curren;"); echo strip_tags(cut_string_unicodeutf8(html_entity_decode(str_replace($vovel,"#",$tin_tuc_top[0]->not_detail)),120)) ; ?>
                  </div>
                </div>
                <div  class="spt_tintuc_top_right" >
                  <div class="spt_tintuc_top_right_detail">
                    <div class="spt_tintuc_top_right_detail_img"> <a href="<?php echo base_url() ?>tintuc/detail/<?php echo $tin_tuc_top[1]->not_id; ?>/<?php echo RemoveSign($tin_tuc_top[1]->not_title);?>"> <img src="<?php echo base_url(); ?>media/images/tintuc/<?php echo $tin_tuc_top[1]->not_dir_image; ?>/<?php echo $tin_tuc_top[1]->not_image; ?>" /> </a> </div>
                    <h3 class="spt_tintuc_top_right_detail_title"> <a href="<?php echo base_url() ?>tintuc/detail/<?php echo $tin_tuc_top[1]->not_id; ?>/<?php echo RemoveSign($tin_tuc_top[1]->not_title);?>"> <?php echo cut_string_unicodeutf8($tin_tuc_top[1]->not_title,110); ?> </a> </h3>
                  </div>
                  <div class="spt_tintuc_top_right_detail">
                    <div class="spt_tintuc_top_right_detail_img"> <a href="<?php echo base_url() ?>tintuc/detail/<?php echo $tin_tuc_top[2]->not_id; ?>/<?php echo RemoveSign($tin_tuc_top[2]->not_title);?>"> <img src="<?php echo base_url(); ?>media/images/tintuc/<?php echo $tin_tuc_top[2]->not_dir_image; ?>/<?php echo $tin_tuc_top[2]->not_image; ?>" /> </a> </div>
                    <h3 class="spt_tintuc_top_right_detail_title"> <a href="<?php echo base_url() ?>tintuc/detail/<?php echo $tin_tuc_top[2]->not_id; ?>/<?php echo RemoveSign($tin_tuc_top[2]->not_title);?>"> <?php echo cut_string_unicodeutf8($tin_tuc_top[2]->not_title,110); ?> </a> </h3>
                  </div>
                  <div class="spt_tintuc_top_right_detail">
                    <div class="spt_tintuc_top_right_detail_img"> <a href="<?php echo base_url() ?>tintuc/detail/<?php echo $tin_tuc_top[3]->not_id; ?>/<?php echo RemoveSign($tin_tuc_top[3]->not_title);?>"> <img src="<?php echo base_url(); ?>media/images/tintuc/<?php echo $tin_tuc_top[3]->not_dir_image; ?>/<?php echo $tin_tuc_top[3]->not_image; ?>"  /> </a> </div>
                    <h3 class="spt_tintuc_top_right_detail_title"> <a href="<?php echo base_url() ?>tintuc/detail/<?php echo $tin_tuc_top[3]->not_id; ?>/<?php echo RemoveSign($tin_tuc_top[3]->not_title);?>"> <?php echo cut_string_unicodeutf8($tin_tuc_top[3]->not_title,110); ?> </a> </h3>
                  </div>
                </div>
              </div>
              <div  class="bannerTintuc">
                <?php $this->load->view('home/advertise/phaitintuc'); ?>
              </div>
            </div>
            <div class="clear"></div></td>
        </tr>
        <tr>
          <td width="710" valign="top" align="center"><div id="container_content_center">
              <div class="tintuc_content">
                <div class="tintuc_content_menu"> <a href="<?php echo base_url() ?>tintuc/danhmuc/11" style="margin-left:30px; text-decoration:underline; color: #5E5D5D;"> Thể thao</a> </div>
                <div class="tintuc_content_top_view">
                  <div class="tintuc_content_top_view_img"> <a href="<?php echo base_url() ?>tintuc/detail/<?php echo $tin_khuyen_mai[0]->not_id; ?>/<?php echo RemoveSign($tin_khuyen_mai[3]->not_title);?>"> <img src="<?php echo base_url(); ?>media/images/tintuc/<?php echo $tin_khuyen_mai[0]->not_dir_image; ?>/<?php echo $tin_khuyen_mai[0]->not_image; ?>" width="270"/> </a> </div>
                  <div class="tintuc_content_top_view_content" >
                    <h3 class="tintuc_content_top_view_content_title" > <a href="<?php echo base_url() ?>tintuc/detail/<?php echo $tin_khuyen_mai[0]->not_id; ?>/<?php echo RemoveSign($tin_khuyen_mai[3]->not_title);?>"> <?php echo cut_string_unicodeutf8($tin_khuyen_mai[0]->not_title,110); ?> </a> </h3>
                    <div class="tintuc_content_top_view_detail" >
                      <?php $vovel=array("&curren;"); echo strip_tags(cut_string_unicodeutf8(html_entity_decode(str_replace($vovel,"#",$tin_khuyen_mai[0]->not_detail)),200)) ; ?>
                    </div>
                  </div>
                </div>
                <div class="tintuc_content_view_next">
                  <ul>
                    <?php $i=0; foreach($tin_khuyen_mai as $item) {?>
                    <?php if($i>0) { ?>
                    <li> <a href="<?php echo base_url() ?>tintuc/detail/<?php echo $item->not_id; ?>/<?php echo RemoveSign($item->not_title);?>"> <?php echo cut_string_unicodeutf8($item->not_title,110); ?> </a> </li>
                    <?php } ?>
                    <?php $i++; }?>
                  </ul>
                </div>
              </div>
            </div>
            <div class="tintucclearboth"> </div>
            <div id="container_content_center">
              <div class="tintuc_content">
                <div class="tintuc_content_menu">
                  <ul >
                    <li > <a href="<?php echo base_url() ?>tintuc/danhmuc/8" style="margin-left:30px; text-decoration:underline; color: #5E5D5D;">Sản phẩm công nghệ </a> </li>
                    <?php $i=0; foreach($retArraySanPhamCongNghe as $item) { ?>
                    <?php if($i==4) { ?>
                    <li><a href="<?php echo base_url() ?>tintuc/danhmuc/<?php echo $item->cat_id; ?>"> <?php echo $item->cat_name; ?></a> </li>
                    <?php break;  } else { ?>
                    <li><a href="<?php echo base_url() ?>tintuc/danhmuc/<?php echo $item->cat_id; ?>"> <?php echo $item->cat_name; ?></a> | </li>
                    <?php } ?>
                    <?php $i++; } ?>
                  </ul>
                </div>
                <div class="tintuc_content_top_view">
                  <div class="tintuc_content_top_view_img"> <a href="<?php echo base_url() ?>tintuc/detail/<?php echo $tin_congnghe[0]->not_id; ?>/<?php echo RemoveSign($tin_congnghe[0]->not_title);?>"> <img src="<?php echo base_url(); ?>media/images/tintuc/<?php echo $tin_congnghe[0]->not_dir_image; ?>/<?php echo $tin_congnghe[0]->not_image; ?>" width="270"/> </a> </div>
                  <div class="tintuc_content_top_view_content" >
                    <h3 class="tintuc_content_top_view_content_title" > <a href="<?php echo base_url() ?>tintuc/detail/<?php echo $tin_congnghe[0]->not_id; ?>/<?php echo RemoveSign($tin_congnghe[0]->not_title);?>"> <?php echo cut_string_unicodeutf8($tin_congnghe[0]->not_title,110); ?> </a> </h3>
                    <div class="tintuc_content_top_view_detail" >
                      <?php $vovel=array("&curren;"); echo strip_tags(cut_string_unicodeutf8(html_entity_decode(str_replace($vovel,"#",$tin_congnghe[0]->not_detail)),200)) ; ?>
                    </div>
                  </div>
                </div>
                <div class="tintuc_content_view_next">
                  <ul>
                    <?php  $i=0; foreach($tin_congnghe as $item) {?>
                    <?php if($i>0) { ?>
                    <li> <a href="<?php echo base_url() ?>tintuc/detail/<?php echo $item->not_id; ?>/<?php echo RemoveSign($item->not_title);?>"> <?php echo cut_string_unicodeutf8($item->not_title,110); ?> </a> </li>
                    <?php } ?>
                    <?php $i++; }?>
                  </ul>
                </div>
              </div>
            </div>
            <div class="tintucclearboth"> </div>
            <div id="container_content_center">
              <div class="tintuc_content">
                <div class="tintuc_content_menu">
                  <ul >
                    <li > <a href="<?php echo base_url() ?>tintuc/danhmuc/13" style="margin-left:30px; text-decoration:underline; color: #5E5D5D;">Xã hội </a> </li>
                    <?php $i=0; foreach($retArrayCateTuVan as $item) { ?>
                    <?php if($i==4 || count($retArrayCateTuVan)-1==$i) { ?>
                    <li><a href="<?php echo base_url() ?>tintuc/danhmuc/<?php echo $item->cat_id; ?>"> <?php echo $item->cat_name; ?></a> </li>
                    <?php break;  } else { ?>
                    <li><a href="<?php echo base_url() ?>tintuc/danhmuc/<?php echo $item->cat_id; ?>"> <?php echo $item->cat_name; ?></a> | </li>
                    <?php } ?>
                    <?php $i++; } ?>
                  </ul>
                </div>
                <div class="tintuc_content_top_view">
                  <div class="tintuc_content_top_view_img"> <a href="<?php echo base_url() ?>tintuc/detail/<?php echo $tin_tuvan[0]->not_id; ?>/<?php echo RemoveSign($tin_tuvan[0]->not_title);?>"> <img src="<?php echo base_url(); ?>media/images/tintuc/<?php echo $tin_tuvan[0]->not_dir_image; ?>/<?php echo $tin_tuvan[0]->not_image; ?>" width="270"/> </a> </div>
                  <div class="tintuc_content_top_view_content" >
                    <h3 class="tintuc_content_top_view_content_title" > <a href="<?php echo base_url() ?>tintuc/detail/<?php echo $tin_tuvan[0]->not_id; ?>/<?php echo RemoveSign($tin_tuvan[0]->not_title);?>"> <?php echo cut_string_unicodeutf8($tin_tuvan[0]->not_title,110); ?> </a> </h3>
                    <div class="tintuc_content_top_view_detail" >
                      <?php $vovel=array("&curren;"); echo strip_tags(cut_string_unicodeutf8(html_entity_decode(str_replace($vovel,"#",$tin_tuvan[0]->not_detail)),200)) ; ?>
                    </div>
                  </div>
                </div>
                <div class="tintuc_content_view_next">
                  <ul>
                    <?php $i=0; foreach($tin_tuvan as $item) {?>
                    <?php if($i>0) { ?>
                    <li> <a href="<?php echo base_url() ?>tintuc/detail/<?php echo $item->not_id; ?>/<?php echo RemoveSign($item->not_title);?>"> <?php echo cut_string_unicodeutf8($item->not_title,110); ?> </a> </li>
                    <?php } ?>
                    <?php $i++; }?>
                  </ul>
                </div>
              </div>
            </div>
            <div class="tintucclearboth"> </div>
            <div id="container_content_center">
              <div class="tintuc_content">
                <div class="tintuc_content_menu">
                  <ul >
                    <li > <a href="<?php echo base_url() ?>tintuc/danhmuc/12" style="margin-left:30px; text-decoration:underline; color: #5E5D5D;">Văn hóa </a> </li>
                    <?php $i=0; foreach($tin_vanhoa1 as $item) { ?>
                    <?php if($i==4 || count($tin_vanhoa)-1==$i) { ?>
                    <li><a href="<?php echo base_url() ?>tintuc/danhmuc/<?php echo $item->cat_id; ?>"> <?php echo $item->cat_name; ?></a> </li>
                    <?php break;  } else { ?>
                    <li><a href="<?php echo base_url() ?>tintuc/danhmuc/<?php echo $item->cat_id; ?>"> <?php echo $item->cat_name; ?></a> | </li>
                    <?php } ?>
                    <?php $i++; } ?>
                  </ul>
                </div>
                <div class="tintuc_content_top_view">
                  <div class="tintuc_content_top_view_img"> <a href="<?php echo base_url() ?>tintuc/detail/<?php echo $tin_vanhoa[0]->not_id; ?>/<?php echo RemoveSign($tin_vanhoa[0]->not_title);?>"> <img src="<?php echo base_url(); ?>media/images/tintuc/<?php echo $tin_vanhoa[0]->not_dir_image; ?>/<?php echo $tin_vanhoa[0]->not_image; ?>" width="270"/> </a> </div>
                  <div class="tintuc_content_top_view_content" >
                    <h3 class="tintuc_content_top_view_content_title" > <a href="<?php echo base_url() ?>tintuc/detail/<?php echo $tin_vanhoa[0]->not_id; ?>/<?php echo RemoveSign($tin_vanhoa[0]->not_title);?>"> <?php echo cut_string_unicodeutf8($tin_vanhoa[0]->not_title,110); ?> </a> </h3>
                    <div class="tintuc_content_top_view_detail" >
                      <?php $vovel=array("&curren;"); echo strip_tags(strip_tags(cut_string_unicodeutf8(html_entity_decode(str_replace($vovel,"#",$tin_vanhoa[0]->not_detail)),200))) ; ?>
                    </div>
                  </div>
                </div>
                <div class="tintuc_content_view_next">
                  <ul>
                    <?php $i=0; foreach($tin_vanhoa as $item) {?>
                    <?php if($i>0) { ?>
                    <li> <a href="<?php echo base_url() ?>tintuc/detail/<?php echo $item->not_id; ?>/<?php echo RemoveSign($item->not_title);?>"> <?php echo cut_string_unicodeutf8($item->not_title,110); ?> </a> </li>
                    <?php } ?>
                    <?php $i++; }?>
                  </ul>
                </div>
              </div>
            </div></td>
          <?php $this->load->view('home/common/right_tintuc'); ?>
          
          <!--END RIGHT--> </tr>
      </tbody>
    </table>
  </div></td>
<?php $this->load->view('home/common/footer'); ?>
