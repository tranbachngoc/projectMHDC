<?php $this->load->view('home/common/header_iframe'); ?>
  <?
  if($error==1){
	 echo "Tài khoản của bạn không đủ để uptin này, vui lòng <a href='".base_url()."/account/naptien'>nạp tiền để thực hiện tác vụ này" ;
  }else{
	 echo "Uptin thành công"  ;
	  
  }
  ?>
      
      <?php $this->load->view('home/common/footer_iframe'); ?>