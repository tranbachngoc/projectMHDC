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
                    <h3 class="tit"><a href="<?=azibai_url().'/tintuc/detail/'.$content->not_id.'/'.$content->not_title . ($af_id ? '?af_id='.$af_id : '')?>">Sản phẩm chứa trong tin</a></h3>
                  </div>
                  <div class="liet-ke-hinh-anh">
                    <div class="grid">
                      <?php foreach ($arr_products as $key => $value) { ?>
                        <div class="item">
                          <div class="detail">
                            <a href="<?=azibai_url().'/'.$value->pro_category.'/'.$value->pro_id.'/'.$value->pro_name . ($af_id ? '?af_id='.$af_id : '')?>" target="_blank">
                              <img src="<?=DOMAIN_CLOUDSERVER . 'media/images/product/' . $value->pro_dir . '/thumbnail_1_' . show_image($value->pro_image)?>" alt="">
                            </a>
                            <div class="text">
                              <h3>
                                <a href="<?=azibai_url().'/'.$value->pro_category.'/'.$value->pro_id.'/'.$value->pro_name . ($af_id ? '?af_id='.$af_id : '')?>" target="_blank"><?=$value->pro_name?></a>
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