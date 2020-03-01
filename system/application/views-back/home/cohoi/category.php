<?php
global $idHome; 
$idHome=1;
?>
<?php $this->load->view('home/common/header'); ?>
<div class="container">
    <div id="main">
        <div class="col-lg-3">
            <?php $this->load->view('home/common/left_tintuc'); ?>
        </div>
        <div class="col-lg-9">
            <h1><?php echo $title_category->cat_name ?></h1>
            <ul class="doc">
                <?php foreach($detail_content as $item){ ?>
                <li>
                    <div>
                        <a href="<?php echo base_url() ?>tintuc/detail/<?php echo $item->not_id; ?>/<?php echo RemoveSign($item->not_title);?>">
                            <img  src="<?php echo base_url(); ?>media/images/tintuc/<?php echo $item->not_dir_image; ?>/<?php echo $item->not_image; ?>" />
                        </a>
                        <h2 class="title"><a href="<?php echo base_url() ?>tintuc/detail/<?php echo $item->not_id; ?>/<?php echo RemoveSign($item->not_title);?>"><?php echo $item->not_title; ?></a></h2>
                        <p><?php $vovel=array("&curren;"); echo strip_tags(cut_string_unicodeutf8(html_entity_decode(str_replace($vovel,"#",$item->not_detail)),300)) ; ?></p>
                        <p>Ngày đăng: <?php echo date('d/m//Y',$item->not_begindate); ?> || <a href="<?php echo base_url() ?>tintuc/detail/<?php echo $item->not_id; ?>/<?php echo RemoveSign($item->not_title);?>">Xem chi tiết</a></p>
                    </div>
                </li>
                <?php } ?>
            </ul>
            <div class="clearfix"></div>
            <?php echo $linkPage ?>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
<?php $this->load->view('home/common/footer'); ?>