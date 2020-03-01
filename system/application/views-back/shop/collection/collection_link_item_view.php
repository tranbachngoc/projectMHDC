<?php $this->load->view('home/common/header_new'); ?>

<style>
.bosuutap .noi-dung-tuong-tu .tit {
  text-transform: none;
}
.padding-top {
  padding-top: 5px;
}
</style>
    <main class="trangcuatoi">
      <section class="main-content">
        <div class="container bosuutap">
          <div class="bosuutap-header">
            <div class="back-trangcanhan button-back"><a href="<?=$shop_url . 'shop/collection-link/select/'.$node_collection->id?>"><img class="mr10" src="/templates/home/styles/images/svg/prev_bold.svg"
                  alt=""> Bộ sư tập <?=$node_collection->name?> </a></div>

          </div>
          <div class="bosuutap-content">
            <div class="bosuutap-content-detail">
              <div class="modal-show-detail bosuutap-content-detail-modal">
                <div class="container">
                  <div class="modal-body">
                    <div class="row">
                      <div class="col-lg-7 popup-image-sm">
                        <div class="text-center">
                          <div class="big-img">
                            <div class="tag position-tag">
                              <img src="<?=$node_custom_link->image?>" alt="">
                              <!-- <div class="icons-hover">
                                <ul>
                                  <li><a href=""><img src="/templates/home/styles/images/svg/like_white.svg" alt=""></a></li>
                                  <li><a href=""><img src="/templates/home/styles/images/svg/comment_white.svg" alt=""></a></li>
                                  <li><a href=""><img src="/templates/home/styles/images/svg/share_01_white.svg" alt=""></a></li>
                                  <li><a href=""><img src="/templates/home/styles/images/svg/bookmark_white.svg" alt=""></a></li>
                                </ul>
                              </div> -->
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-5">
                        <div class="post">
                          <!-- <div class="post-head">
                            <div class="post-head-name">
                              <div class="avata"><img src="/templates/home/styles/images/product/avata/oppo.png" alt="oppo"></div>
                              <div class="title">
                                Trang của abc<br>
                                <span>28/10/2018</span>
                                <span><img class="mr10 ml20 mt05" src="/templates/home/styles/images/svg/quadiacau.svg"
                                    width="14" alt=""></span>
                                <span style="color: #737373; font-weight: normal; border-left: 1px solid #c4c4c4" class="pl10"><img
                                    class="mt10" src="/templates/home/styles/images/svg/eye_gray.svg" width="16" alt="">
                                  8K</span>
                              </div>
                            </div>
                            <div class="post-head-more">
                              <span><img class="icon-img" src="/templates/home/styles/images/svg/3dot.svg" alt="more"></span>
                              <div class="show-more hidden">
                                <p class="save-post"><img class="icon-img" src="/templates/home/styles/images/svg/savepost.svg"
                                    alt="">Lưu bài viết</p>
                                <ul class="show-more-detail">
                                  <li><a href="#">Chỉnh sửa bài viết</a></li>
                                  <li><a href="#">Thay đổi ngày</a></li>
                                  <li><a href="#">Tắt thông báo cho bài viết này</a></li>
                                  <li><a href="#">Ẩn khỏi dòng thời gian</a></li>
                                  <li><a href="#">Xóa </a></li>
                                  <li><a href="#">Tắt tính năng dịch</a></li>
                                  <li><a href="#">Kiểm duyệt bình luận</a></li>
                                </ul>
                              </div>
                            </div>
                          </div> -->
                          <div>
                            <div class="info-product">
                              <div class="descrip">
                                <a href="<?=$node_custom_link->save_link?>" target="_blank"><p><strong class="f16">
                                    Nguồn: </strong> <?=$node_custom_link->host?>
                                </p></a>
                                <p><strong class="f16">
                                  <a href="<?=$node_custom_link->save_link?>" target="_blank"><?=$node_custom_link->title?></strong></a>
                                  <?=$node_custom_link->description?>
                                </p>
                                <!-- <div class="hagtag">
                                  <a href="">@abc</a>
                                  <a href="">#abc</a>
                                </div> -->
                              </div>
                            </div>
                            <div class="info-user">
                              <div class="name">
                                <div class="img"><img src="/templates/home/styles/images/hinhanh/15.jpg" alt=""></div>
                                <h3 class="two-lines">Trang của tôi</h3>
                              </div>
                              <div class="new-comment">
                                <?=$node_custom_link->detail?>
                              </div>
                            </div>
                          </div>
                          <div class="action">
                            <?php
                            $imgLike = '<img class="icon-img" src="/templates/home/styles/images/svg/like.svg" alt="like" data-like-icon="/templates/home/styles/images/svg/like_pink.svg" data-notlike-icon="/templates/home/styles/images/svg/like.svg">';
                            $this->load->view('home/share/bar-btn-share', array('data_backwhite' => 1, 'data_shr' => 1, 'data_jsclass' => 'js-like-link', 'data_url' => $shop_url . 'shop/collection-link/select/'.$node_collection->id, 'data_title' => htmlspecialchars($node_custom_link->title), 'data_id' => $node_collection->id, 'data_imglike' => $imgLike, 'data_numlike' => 0, 'data_lishare' => 1));
                            ?>
                            <!-- <div class="create-new-comment">
                              <div class="avata-user"><img src="/templates/home/styles/images/product/avata/mi.svg" alt=""></div>
                              <div class="area-comment"><textarea name="" id=""></textarea></div>
                              <p class="icon-sendmess"><img class="icon-img" src="/templates/home/styles/images/svg/sendmess.svg"
                                  alt=""></p>
                              <div class="list-add-icon">
                                <button><img class="icon-img" src="/templates/home/styles/images/svg/takephoto.svg" alt=""></button>
                                <button><img class="icon-img" src="/templates/home/styles/images/svg/sticker.svg" alt=""></button>
                              </div>
                            </div>
                            <div class="show-list-comments">
                              <div class="dropdown">
                                <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Cũ
                                  nhất
                                  <span class="caret"></span></button>
                                <ul class="dropdown-menu">
                                </ul>
                              </div>
                              <p class="xembinhluankhac">Xem các bình luận khác...</p>
                              <div class="comment">
                                <dl>
                                  <dt><img src="/templates/home/styles/images/product/avata/nikon.jpg" alt=""></dt>
                                  <dd>
                                    <span class="name-user">nicknamdg</span>Tai nghe tốt, giá hợp lý. cảm ơn shop.
                                  </dd>
                                </dl>
                                <div class="action-comment">
                                  <p><a href="">Thích</a></p>
                                  <p><a href="">Trả lời</a></p>
                                  <p>1giờ trước</p>
                                </div>
                              </div>
                              <div class="comment">
                                <dl>
                                  <dt><img src="/templates/home/styles/images/product/avata/nikon.jpg" alt=""></dt>
                                  <dd>
                                    <span class="name-user">nicknamdg</span>Tai nghe tốt, giá hợp lý. cảm ơn shop. Tai
                                    nghe tốt, giá hợp lý. cảm ơn shop
                                  </dd>
                                </dl>
                                <div class="action-comment">
                                  <p><a href="">Thích</a></p>
                                  <p><a href="">Trả lời</a></p>
                                  <p>1giờ trước</p>
                                </div>
                              </div>
                            </div> -->
                          </div>
                        </div>
                      </div>
                    </div>
                    <?php if(!empty($arr_more_node_cl)) { ?>
                    <div class="noi-dung-tuong-tu">
                      <div class="text-center">
                        <h3 class="tit"><a href="<?=$shop_url.'shop/collection-link/select/'.$node_custom_link->type_id?>">Liên kết cùng bộ sưu tập</a></h3>
                      </div>
                      <div class="liet-ke-hinh-anh">
                        <div class="grid">
                          <?php foreach ($arr_more_node_cl as $key => $value) {
                            $this->load->view('shop/collection/common/item_link_view', ['item'=>$value]);
                          } ?>
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
      </section>

    </main>
    <footer id="footer">
      <div id="loadding-more" class="text-center hidden">
        <img src="/templates/home/styles/images/loading-dot.gif" alt="loading">
      </div>
    </footer>
  </div>
  <script src="/templates/home/styles/js/common.js"></script>
  <script src="/templates/home/styles/js/slick.js"></script>
  <script src="/templates/home/styles/js/slick-slider.js"></script>
  <script src="/templates/home/styles/js/countdown.js"></script>
  <script src="/templates/home/styles/js/jquery-scrolltofixed.js"></script>
  <script src="/templates/home/styles/js/fixed_sidebar.js"></script>
  <script src="/templates/home/styles/js/popup_dangtin.js"></script>
  
  <script src="/templates/home/styles/plugins/imagesloaded/imagesloaded.pkgd.min.js"></script>
  <script src="/templates/home/styles/plugins/masonry/masonry.pkgd.min.js"></script>

  <script type="text/javascript">
    var masonryOptions = {
      itemSelector: '.item',
      horizontalOrder: true
    }
    var $grid = $('.grid').masonry(masonryOptions);
    $grid.imagesLoaded().progress( function() {
        $grid.masonry('layout');
    });
    
    var isActive = true;
    
    var is_busy = false;
    var page = 1;
    var stopped = false;
    $(window).scroll(function(event) {
        $element = $('.wrapper');
        $loadding = $('#loadding-more');
        if($(window).scrollTop() + $(window).height() >= $element.height() - 200) {
            if (is_busy == true){
                event.stopPropagation();
                return false;
            }
            if (stopped == true){
                event.stopPropagation();
                return false;
            }
            $loadding.removeClass('hidden');
            is_busy = true;
            page++;

            $.ajax({
                type: 'post',
                dataType: 'html',
                url: window.location.href,
                data: {page: page},
                success: function (result) {
                    $loadding.addClass('hidden');
                    if(result == '') {
                        stopped = true;
                    }
                    if(result){
                        var $content = $(result);
                        $grid.append( $content ).masonry('appended', $content);
                        $grid.imagesLoaded().progress( function() {
                            $grid.masonry('layout');
                        });
                    }
                }
            }).always(function() {
                is_busy = false;
            });
            return false;
        }
    });
  </script>
</body>

</html>