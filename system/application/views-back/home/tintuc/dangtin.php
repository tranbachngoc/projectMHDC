<?php
$group_id = (int) $this->session->userdata('sessionGroup');
$user_id  = (int) $this->session->userdata('sessionUser');
$avatar = site_url('media/images/avatar/default-avatar.png');
if($shop_current->sho_dir_logo && $shop_current->sho_logo){
    $avatar = $this->config->item('logo_shop_config')['cloud_server_show_path'] . '/' . $shop_current->sho_dir_logo . '/' . $shop_current->sho_logo;
}

?>
<?php if (isset($currentuser) && $currentuser) { ?>
<div id="addNewsFrontEnd">
    <div class="blockdangtin-buttontaobaiviet">
        <p class="taobaiviet is-active">Tạo bài viết</p>
        <p>Tạo album</p>
    </div>
    <div class="blockdangtin-nhaptin">
        <!-- <a href="<?=azibai_url("/profile/$user_id")?>"><img class="img-circle" src="<?php echo $avatar; ?>" alt="account" style="width:48px; height:48px"></a> -->
        <a href="<?=$shop_url?>"><img class="img-circle" src="<?php echo $avatar; ?>" alt="account" style="width:48px; height:48px"></a>
        <textarea class="bandangnghigi" name="" id="contentNewsFrontEnd" placeholder="Bạn đăng tin gì hôm nay?"></textarea>
    </div>
    <div id="boxaddimagegallery" data-num="0">
        <div class="boxaddmoreimage">
            <input accept="video/*,  video/x-m4v, video/webm, video/x-ms-wmv, video/x-msvideo, video/3gpp, video/flv, video/x-flv, video/mp4, video/quicktime, video/mpeg, video/ogv, .ts, .mkv, image/*" multiple="true" name="composer_photo" title="Chọn file để tải lên" display="inline-block" type="file" class="buttonAddImage" id="add-more-images">
        </div>
    </div>
    <div class="blockdangtin-dangtinby">
        <button class="addvideonews">
            <img src="/templates/home/styles/images/svg/camera.svg" alt="Video">Ảnh/Video
            <input type="hidden" value="<?php echo base_url() ?>" name="domain_post">
            <input type="hidden" value="<?php echo isset($page_personal) ? true : false ?>" name="personal">
            <input type="file" class="buttonAddImage" data-type="<?php echo isset($page_personal) ? 'personal' : 'company' ?>" name="video" accept="video/*,  video/x-m4v, video/webm, video/x-ms-wmv, video/x-msvideo, video/3gpp, video/flv, video/x-flv, video/mp4, video/quicktime, video/mpeg, video/ogv, .ts, .mkv,image/*" multiple="true">
        </button>
        <button  data-toggle="modal" data-target="#typeDisplayNewsdetail">
            <img src="/templates/home/styles/images/svg/typenewdetail.svg" alt="Hiển thị chi tiết tin">Hiển thị chi tiết tin
        </button>
        <?php if (!empty($list_branches) && !empty($user_login)){ ?>
            <div class="post-by">
                <p data-toggle="dropdown" class="post-by-title">Đăng với tư cách <i class="fa fa-caret-down" aria-hidden="true"></i></p>
                <div class="dropdown-menu post-by-list">
                    <p class="dropdown-item active " data-post-by="<?php echo $user_login['my_shop']['sho_id'] ?>">
                        <img onerror="image_error(this)" src="<?php echo $user_login['my_shop']['logo'] ?>" alt="<?php echo ($branch_name = htmlspecialchars($user_login['my_shop']['sho_name'])); ?>">
                        <span class="one-line"><?php echo $branch_name ?></span>
                    </p>
                    <?php foreach ($list_branches as $branch) { ?>
                        <p class="dropdown-item" data-post-by="<?php echo $branch['sho_id'] ?>">
                            <img onerror="image_error(this)" src="<?php echo $branch['logo_shop'] ?>" alt="<?php echo ($branch_name = htmlspecialchars($branch['sho_name'])); ?>">
                            <span class="one-line"><?php echo $branch_name ?></span>
                        </p>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
        <button class="more" id="buttonaddfunction">
            <img src="/templates/home/styles/images/svg/3dot_doc.svg" alt="">
        </button>
    </div>
    <div class="boxaddfunctionfooter home">
        <div class="list-function">
            <button class="addfeaturednews rediectpreview">
                <img src="<?=base_url()?>templates/home/images/svg/relatedicon.svg" alt="Tin nổi bật">
                Tin nổi bật
            </button>
            <button class="adddesnews rediectpreview">
                <img src="<?=base_url()?>templates/home/images/svg/shortdes.svg" alt="Mô tả ngắn">
                Mô tả ngắn
            </button>
            <button class="addstaticnews rediectpreview">
                <img src="<?=base_url()?>templates/home/images/svg/static.svg" alt="Thống kê">
                Thống kê
            </button>
            <button class="addkeywordnews rediectpreview">
                <img src="<?=base_url()?>templates/home/images/svg/keyword.svg" alt="Từ khóa">
                Từ khóa
            </button>
            <button class="addeffectnews rediectpreview">
                <img src="<?=base_url()?>templates/home/images/svg/slider.svg" alt="Tạo trình chiếu">
                Tạo trình chiếu
            </button>
            <button class="addadsnews rediectpreview">
                <img src="<?=base_url()?>templates/home/images/svg/ads.svg" alt="Quảng cáo">
                Quảng cáo
            </button>
            <button class="addrelatednews rediectpreview">
                <img src="<?=base_url()?>templates/home/images/svg/relatedcutomer.svg" alt="Liên quan">
                Liên quan
            </button>
            <button class="addcategoriesnews rediectpreview">
                <img src="<?=base_url()?>templates/home/images/svg/newscategory.svg" alt="Chuyên mục tin">
                Chuyên mục tin
            </button>
            <div class="clear"></div>
        </div>
    </div>
    <div class="boxaddnew" style="padding-left: 15px;padding-right: 15px;">
        <input maxlength="130" type="text" name="not_title" required placeholder="Tiêu đề tin (bắt buộc)">
        <textarea name="not_detail" required placeholder="Nội dung tin (bắt buộc)" rows="5"></textarea>
        <div id="tabdescontentlinkmain" class="tabdescontentlink">
            <div class="addlinkthem addlinkthem-detail no-slider-for version01" id="addlinkthem">
                <ul class="edit-news slider addlinkthem-slider"></ul>
            </div>
        </div>
    </div>
    <div class="morefooter home list-checkbox">
        <div class="morefooter-row">
            <div class="morefooter-left checkbox-style">
                <label>
                    <input type="checkbox" name="category" value="1"><span class="checkbox"></span>
                </label>
                <img class="img-circle" src="<?php echo $avatar; ?>" alt="account" style="width:32px; height:32px">
                <span>Bảng tin</span>
            </div>
            <div class="morefooter-right">
                <button class="public-type">Công khai</button>
            </div>
            <div class="clear"></div>
        </div>
        <div class="morefooter-row">
            <div class="morefooter-left checkbox-style">
                <label>
                    <input type="checkbox" name="category" value="2"><span class="checkbox"></span>
                </label>
                <img class="img-circle" src="<?php echo $avatar; ?>" alt="account" style="width:32px; height:32px">
                <span>Tin của bạn</span>
            </div>
            <div class="morefooter-right">
                <button class="public-type">Bạn bè</button>
            </div>
            <div class="clear"></div>
        </div>
        <div class="morefooter-row">     
            <button class="readmoreboxnew">Xem thêm</button>
            <button id="submitnews">Đăng tin</button>
            <div class="clear"></div>
        </div>
    </div>
</div>
<div class="drawer-overlay drawer-toggle" data-popup=""></div>
<!-- Popup error -->
<div id="myError" class="model-content">
  <div class="wrapp-model">
        <div class="content-model">
            <div class="contents">
                <div class="btn-back js-back"><a href="#"><img src="<?=base_url()?>templates/home/images/svg/close.svg"></a></div>
                <div class="content-icon-option">
                    
                </div>
            </div>
        </div>
      </div>
</div>
<div id="process-file">
    <p class="alert-mess-copy bg-pink">Video của bạn đang được tải lên</p>
</div>
<?php } ?>
<?php $this->load->view('home/tintuc/popup/pop-style-show-content'); ?>
