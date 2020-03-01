<main class="trangcuatoi">
  <section class="main-content">
    <div class="container bosuutap">
      <div class="sidebarsm">
        <div class="gioithieu">
          <?php $this->load->view('shop/news/elements/menu_left_items') ?>
        </div>
      </div>
      <div class="bosuutap-content">
        <div class="bosuutap-content-detail">
          <div class="modal-show-detail bosuutap-content-detail-modal">
            <div class="container">
              <div class="modal-body">

                <?php
                switch ($type_view) {
                  case CUSTOMLINK_CONTENT:
                    $this->load->view('shop/media/elements/layout-viewnode-item/node-link');
                    if(!empty($list_node_views)){ //show more
                      $this->load->view('shop/media/elements/layout-viewnode-item/node-link-showmore');
                    }
                    break;
                }
                ?>

              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </section>
</main>