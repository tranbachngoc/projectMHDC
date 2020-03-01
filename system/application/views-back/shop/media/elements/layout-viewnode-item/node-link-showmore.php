<style>
.bosuutap .noi-dung-tuong-tu .tit {
  text-transform: none;
}
.padding-top {
  padding-top: 5px;
}
</style>
<?php if (!empty($list_node_views)){ ?><div class="noi-dung-tuong-tu">
  <div class="text-center">
        <h3 class="tit"><a class="tit mb-0" href="<?php echo $shopdomain . '/news/detail/' . $node_view->not_id . '/' . RemoveSign($node_view->not_title) ?>">Liên kết cùng tin</a></h3>
      </div>
      <div class="liet-ke-hinh-anh">
        <div class="grid">

            <?php foreach ($list_node_views as $key => $value) { ?>
              <div class="item">
                <div class="detail">
                  <a href="<?=base_url().'library/view/node/'.CUSTOMLINK_CONTENT.'/'.$value->id?>">
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
<?php } ?>