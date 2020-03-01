<?php
$this->load->view('home/common/header_new');
$group_id = (int) $this->session->userdata('sessionGroup');
$user_id = (int) $this->session->userdata('sessionUser');
?>
<link href="/templates/engine1/style.css" type="text/css" rel="stylesheet" />
<script src="/templates/home/js/home_news.js"></script>
<link href="/templates/home/owlcarousel/owl.carousel.min.css" rel="stylesheet" type="text/css" />
<script src="/templates/home/owlcarousel/owl.carousel.js"></script>
<script src="/templates/home/darkroomjs/js/fabric.js"></script>
<link href="/templates/home/darkroomjs/css/darkroom.css" type="text/css" rel="stylesheet" />
<script src="/templates/home/darkroomjs/js/darkroom.js"></script>
<script src="/templates/home/js/jquery.countdown.min.js"></script>
<script type="text/javascript" src="/templates/engine1/wowslider.js"></script>
<script type="text/javascript" src="/templates/engine1/script.js"></script>
<link href="/templates/home/css/addnews.css" type="text/css" rel="stylesheet" />
<script src="/templates/home/js/addnews-preview.js"></script>

<link href="/templates/home/css/addnews-v2.css" type="text/css" rel="stylesheet" />
<script src="/templates/home/js/addnews-preview-v2.js"></script>

<main>   
  <section class="main-content previewnews">
    <div class="container clearfix">
      <div class="sidebar md">
        <div class="sidebar-left"></div>
        <div class="sidebar-right">
          <div id="preview_content">
            <div class="title-preview">
              <h3>XEM TRƯỚC KẾT QUẢ</h3>
            </div>
            <div id="prevideo"></div>
            <div id="preslider"></div>
            <div id="pretitlecontent">
                <div class="r-title"><h2></h2></div>
                <div class="r-text"></div>
            </div>
            <div id="prelistimagegallery"></div>
            <div id="preads"></div>
            <div id="prerelative"></div>
            <div class="preview-content-footer">
                <button type="button" class="cancel">Xóa</button>
                <button type="button" id="buttonaddnews" class="save">Lưu</button>
            </div>
          </div>
        </div>
      </div>
      <div class="content">
        <div class="blockdangtin">
            <?php
                $group_id = (int) $this->session->userdata('sessionGroup');
                $user_id = (int) $this->session->userdata('sessionUser');
                if (isset($currentuser) && $currentuser) {
                    $avatar = site_url('media/images/avatar/default-avatar.png');
                    if ($currentuser->avatar) {
                        $avatar = $this->config->item('avatar_user_config')['cloud_server_show_path'] . '/' . $currentuser->use_id . '/' .  $currentuser->avatar;
                    }
                }

            ?>
            <?php if (isset($currentuser) && $currentuser) { ?>
              <div id="addNewsFrontEnd">
                <div class="blockdangtin-buttontaobaiviet">
                    <p class="taobaiviet is-active">Tạo bài viết</p>
                    <p class="hr-ver"></p>
                    <p>Tạo album</p>
                </div>
                <div class="blockdangtin-nhaptin">
                    <img class="img-circle" src="<?php echo $avatar; ?>" alt="account" style="width:48px; height:48px">
                    <textarea class="bandangnghigi" name="" id="addtitlecontent" placeholder="Bạn đăng tin gì hôm nay?"></textarea>
                </div>
                <div id="boxaddimagegallery" data-num="0">
                    <div class="boxaddmoreimage">
                        <input accept="video/*,  video/x-m4v, video/webm, video/x-ms-wmv, video/x-msvideo, video/3gpp, video/flv, video/x-flv, video/mp4, video/quicktime, video/mpeg, video/ogv, .ts, .mkv, image/*" multiple="true" name="composer_photo" title="Chọn file để tải lên" display="inline-block" type="file" class="buttonAddImage" id="add-more-images">
                    </div>
                    
                </div>
                <div class="blockdangtin-dangtinby">
                    <button class="addvideonews">
                        <img src="/templates/home/styles/images/svg/camera.svg" alt="Video">Ảnh/Video
                        <input type="file" class="buttonAddImage" name="video" accept="video/*,  video/x-m4v, video/webm, video/x-ms-wmv, video/x-msvideo, video/3gpp, video/flv, video/x-flv, video/mp4, video/quicktime, video/mpeg, video/ogv, .ts, .mkv,image/*" multiple="true">
                    </button>
                    <button  data-toggle="modal" data-target="#typeDisplayNewsdetail">
                        <img src="/templates/home/styles/images/svg/typenewdetail.svg" alt="Hiển thị chi tiết tin">Hiển thị chi tiết tin
                    </button>
                    <button class="more" id="buttonaddfunction">
                        <img src="/templates/home/styles/images/svg/3dot_doc.svg" alt="">
                    </button>
                </div>
                <div class="boxaddfunctionfooter">
                    <div class="list-function">
                        <button class="addfeaturednews">
                            <img src="<?=base_url()?>templates/home/styles/images/svg/relatedicon.svg" alt="Tin nổi bật">
                            Tin nổi bật
                        </button>
                        <button class="adddesnews">
                            <img src="<?=base_url()?>templates/home/images/svg/shortdes.svg" alt="Mô tả ngắn">
                            Mô tả ngắn
                        </button>
                        <button class="addstaticnews">
                            <img src="<?=base_url()?>templates/home/styles/images/svg/static.svg" alt="Thống kê">
                            Thống kê
                        </button>
                        <button class="addkeywordnews">
                            <img src="<?=base_url()?>templates/home/styles/images/svg/keyword.svg" alt="Từ khóa">
                            Từ khóa
                        </button>
                        <button class="addlinkextendnews">
                            <img src="<?=base_url()?>templates/home/styles/images/svg/link.svg" alt="Link Youtube">
                            Link Youtube
                        </button>
                        <button class="addeffectnews">
                            <img src="<?=base_url()?>templates/home/styles/images/svg/slider.svg" alt="Tạo trình chiếu">
                            Tạo trình chiếu
                        </button>
                        <button class="addadsnews">
                            <img src="<?=base_url()?>templates/home/styles/images/svg/ads.svg" alt="Quảng cáo">
                            Quảng cáo
                        </button>
                        <button class="addrelatednews">
                            <img src="<?=base_url()?>templates/home/styles/images/svg/relatedcutomer.svg" alt="Liên quan">
                            Liên quan
                        </button>
                        <button class="addcategoriesnews">
                            <img src="<?=base_url()?>templates/home/styles/images/svg/newscategory.svg" alt="Chuyên mục tin">
                            Chuyên mục tin
                        </button>
                        <div class="clear"></div>
                    </div>
                </div>
                <div class="boxaddnew" data-satus="closed">
                    <input type="text" name="not_title" required placeholder="Tiêu đề tin (bắt buộc)">
                    <textarea name="not_detail" required placeholder="Nội dung tin (bắt buộc)" rows="5"></textarea>
                </div>
                <div id="tabdescontentlinkmain" class="tabdescontentlink"></div>
                <div id="boxaddfunction"></div>
                <div id="boxaddnewsexample"></div>
                <div class="morefooter list-checkbox">
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
                <div id="boxwork"></div>
              </div>
            <?php } ?>
        </div>        
      </div>
    </div>
  </section>
</main>
 <script type="text/javascript">
    <?php  if($not_title !='') { ?>
        formData.set('not_title','<?=$not_title?>');
        $('#addNewsFrontEnd .boxaddnew input[name="not_title"]').val('<?=$not_title?>');
        $('#pretitlecontent .r-title h2').html('<?=$not_title?>');
    <?php } ?>
    <?php  if($not_detail !='') { ?>
        formData.set('not_detail','<?=$not_detail?>');
        $('#addNewsFrontEnd .boxaddnew textarea[name="not_detail"]').val('<?=$not_detail?>');
        $('#pretitlecontent .r-text').html('<?=$not_detail?>');
    <?php } ?>
    <?php if($images != '') { ?>

        var list_images = <?=$images?>;
        if(list_images.length > 0) {
            $.each(list_images, function( index, item ) {
                item = JSON.parse(item);
                var html = '';
                html +='<div class="boxaddimagegallerybox" data-id="'+item.image_id+'" style="background-image: url('+item.image_url+')" data-image='+JSON.stringify(item)+'>';
                    html +='<div class="backgroundfillter"></div>';
                        html +='<button class="addTagImgGallary" data-id="'+item.image_id+'" data-url="'+item.image_url+'"></button>';
                    html +='<button class="setbackground" data-id="'+item.image_id+'"></button>';
                    html +='<button class="editimagegallary" data-id="'+item.image_id+'" data-url="'+item.image_url+'"></button>';
                    html +='<button class="deleteimagegallary" data-id="'+item.image_id+'"></button>';
                html +='</div>';
                $(html).insertBefore('#boxaddimagegallery .boxaddmoreimage');
                // Preview
                $('#prelistimagegallery').append('<div id="'+item.image_id+'" class="icon-item-featured-wappar">'+html+'</div>');
                formData.append('images', JSON.stringify(item));
            });
            $('#boxaddimagegallery').css('display','block');
        }
        
    <?php } ?>
</script>
<!-- popup -->
    <?php $this->load->view('home/tintuc/popup-tag', array()); ?>
<!-- end popup -->

<!-- Popup Icon -->
<?php
    $this->load->helper('directory');
    $icons = directory_map('./images/icons');
?> 
<div class="drawer-overlay drawer-toggle" data-popup=""></div>
<div id="myIconModal" class="model-content">
    <div class="wrapp-model">
        <div class="content-model">
            <div class="contents">
                <div class="btn-back js-back"><a href="#"><img
                                src="<?= base_url() ?>templates/home/images/svg/close.svg"></a></div>
                <div class="row list-icon" style="height:450px; overflow: auto">
                    <?php
                    if (isset($icons)) {
                        foreach ($icons as $image) {
                            $imglink = base_url() . 'images/icons/' . $image;
                            ?>
                            <div class="icon-item chooseimage" style="cursor:pointer;" data-image-url="<?= $imglink ?>"
                                 data-image="<?= $image ?>" title="<?= $image ?>">
                                <?php echo '<img class="aicon img-responsive" src="' . base_url() . 'images/icons/' . $image . '"/>'; ?>

                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>
                <div class="footer-popup">
                    <button type="button" class="btn btn-primary insertimage">Chọn icon</button>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Popup Icon option -->
<div id="myIconOption" class="model-content">
  <div class="wrapp-model">
        <div class="content-model">
            <div class="contents">
                <div class="btn-back js-back"><a href="#"><img src="<?=base_url()?>templates/home/images/svg/close.svg"></a></div>
                <div class="content-icon-option">
                    
                </div>
                <div class="footer-popup">
                  <button type="button" class="btn btn-primary inserticon">Chèn icon</button>
                </div>
            </div>
        </div>
      </div>
</div>

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