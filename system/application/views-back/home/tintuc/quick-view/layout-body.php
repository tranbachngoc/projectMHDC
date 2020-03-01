<?php
$this->load->view('home/common/header_new');
?>
<style>
.bosuutap .noi-dung-tuong-tu .tit {
  text-transform: none;
}
</style>

<?php
if(!empty($arr_links)){
  $this->load->view('home/tintuc/quick-view/element_link');
}

if(!empty($arr_products)){
  $this->load->view('home/tintuc/quick-view/element_product');
}

// switch ($view_detect) {
//   case CUSTOMLINK_LINK :
//     $this->load->view('home/tintuc/quick-view/element_link');
//     break;
//   case CUSTOMLINK_PRODUCT :
//     $this->load->view('home/tintuc/quick-view/element_product');
//     break;
// }
?>
