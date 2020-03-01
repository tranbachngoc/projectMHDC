<div class="row">
  <div class="col-lg-7 popup-image-sm">
    <div class="text-center">
      <div class="big-img">
        <div class="tag position-tag">
          <img src="<?=$node_view->image?>" alt="">
          <!-- <div class="icons-hover">
            <ul>
              <li>
                <a href="">
                  <img src="/templates/home/styles/images/svg/like_white.svg" alt="">
                </a>
              </li>
              <li>
                <a href="">
                  <img src="/templates/home/styles/images/svg/comment_white.svg" alt="">
                </a>
              </li>
              <li>
                <a href="">
                  <img src="/templates/home/styles/images/svg/share_01_white.svg" alt="">
                </a>
              </li>
              <li>
                <a href="">
                  <img src="/templates/home/styles/images/svg/bookmark_white.svg" alt="">
                </a>
              </li>
            </ul>
          </div> -->
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-5">
    <div class="post">
      <div>
        <div class="info-product">
          <div class="descrip">
            <a href="<?=$node_view->save_link?>" target="_blank">
              <p>
                <strong class="f16">
                  Nguồn: </strong>
                <?=$node_view->host?>
              </p>
            </a>
            <p>
              <strong class="f16">
                <a href="<?=$node_view->save_link?>" target="_blank">
                  <?=$node_view->title?>
              </strong>
              </a>
              <?=$node_view->description?>
            </p>
            <!-- <div class="hagtag">
              <a href="">@abc</a>
              <a href="">#abc</a>
            </div> -->
          </div>
        </div>
        <p class="padding-top">
          <?=$node_view->detail?>
        </p>
      </div>
      <div class="action">
        <?php 
          $this->load->view('home/share/bar-btn-share-js', array('show_md_7' => 0, 'show_md_5' => 1, 'show_sm' => 0));
        ?>
        <!-- <div class="create-new-comment">
          <div class="avata-user">
            <img src="/templates/home/styles/images/product/avata/mi.svg" alt="">
          </div>
          <div class="area-comment">
            <textarea name="" id=""></textarea>
          </div>
          <p class="icon-sendmess">
            <img class="icon-img" src="/templates/home/styles/images/svg/sendmess.svg" alt="">
          </p>
          <div class="list-add-icon">
            <button>
              <img class="icon-img" src="/templates/home/styles/images/svg/takephoto.svg" alt="">
            </button>
            <button>
              <img class="icon-img" src="/templates/home/styles/images/svg/sticker.svg" alt="">
            </button>
          </div>
        </div>
        <div class="show-list-comments">
          <div class="dropdown">
            <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Cũ nhất
              <span class="caret"></span>
            </button>
            <ul class="dropdown-menu">
            </ul>
          </div>
          <p class="xembinhluankhac">Xem các bình luận khác...</p>
          <div class="comment">
            <dl>
              <dt>
                <img src="/templates/home/styles/images/product/avata/nikon.jpg" alt="">
              </dt>
              <dd>
                <span class="name-user">nicknamdg</span>Tai nghe tốt, giá hợp lý. cảm ơn shop.
              </dd>
            </dl>
            <div class="action-comment">
              <p>
                <a href="">Thích</a>
              </p>
              <p>
                <a href="">Trả lời</a>
              </p>
              <p>1giờ trước</p>
            </div>
          </div>
          <div class="comment">
            <dl>
              <dt>
                <img src="/templates/home/styles/images/product/avata/nikon.jpg" alt="">
              </dt>
              <dd>
                <span class="name-user">nicknamdg</span>Tai nghe tốt, giá hợp lý. cảm ơn shop. Tai nghe tốt, giá hợp lý. cảm ơn shop
              </dd>
            </dl>
            <div class="action-comment">
              <p>
                <a href="">Thích</a>
              </p>
              <p>
                <a href="">Trả lời</a>
              </p>
              <p>1giờ trước</p>
            </div>
          </div>
        </div> -->
      </div>
    </div>
  </div>
</div>