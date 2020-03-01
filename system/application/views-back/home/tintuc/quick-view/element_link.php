<?php
$protocol = get_server_protocol();
// $linkshop = $shop->domain ? $protocol . $shop->domain : $protocol . $shop->sho_link .'.'. domain_site;
if(!empty($shop->domain)){
  $linkshop = 'http://' . $shop->domain;
}else if (!empty($myshop->sho_link)){
  $linkshop =  $protocol . $myshop->sho_link . '.' . domain_site ;
}
?>
<main class="trangcuatoi">
  <section class="main-content">
    <div class="container bosuutap">
      <div class="bosuutap-content">
        <div class="bosuutap-content-detail">
          <div class="modal-show-detail bosuutap-content-detail-modal">
            <div class="container">
              <div class="modal-body">
                <div class="noi-dung-tuong-tu">
                  <div class="text-center">
                    <h3 class="tit"><a href="<?=azibai_url().'/'.'tintuc/detail/'.$content->not_id.'/'.$content->not_title . ($af_id ? '?af_id='.$af_id : '')?>">Liên kết chứa trong tin</a></h3>
                  </div>
                  <div class="liet-ke-hinh-anh">
                    <div class="grid">
                      <?php foreach ($arr_links as $key => $value) { ?>
                        <div class="item">
                          <div class="detail">
                            <a href="<?=$linkshop.'/library/view/node/'.CUSTOMLINK_CONTENT.'/'.$value->id?>" target="_blank">
                              <img src="<?=$value->image?>" alt="">
                            </a>
                            <div class="text">
                              <h3>
                                <a href="<?=$value->save_link?>" target="_blank"><?=$value->title?></a>
                              </h3>
                            </div>
                          </div>
                        </div>
                      <?php } ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </section>

</main>