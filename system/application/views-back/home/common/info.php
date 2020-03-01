<!--BEGIN: RIGHT-->
<?php $vovel=array("&curren;");?>
<?php $contentThongTinRightTopDangNhap = Counter_model::getArticle(thongtinRightTopDangNhap);?>
<?php $contentThongTinRightTopDangNhap = html_entity_decode(str_replace($vovel,"#",$contentThongTinRightTopDangNhap->not_detail));?>
<?php if((trim(strtolower($this->uri->segment(1))) == 'product' || trim(strtolower($this->uri->segment(1))) == 'raovat' || trim(strtolower($this->uri->segment(1))) == 'job' || trim(strtolower($this->uri->segment(1))) == 'employ') && trim(strtolower($this->uri->segment(2))) == 'post'){ ?>
    <?php echo $contentThongTinRightTopDangNhap; ?>
<?php }elseif(trim(strtolower($this->uri->segment(1))) == 'login' || trim(strtolower($this->uri->segment(1))) == 'logout' || trim(strtolower($this->uri->segment(1))) == 'forgot'){ ?>
    <?php echo $contentThongTinRightTopDangNhap; ?>
<?php }else{ ?>
    <?php echo $contentThongTinRightTopDangNhap; ?>
<?php } ?>
<!--END RIGHT-->