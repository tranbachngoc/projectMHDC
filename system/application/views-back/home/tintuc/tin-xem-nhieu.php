<script src="https://cdnjs.cloudflare.com/ajax/libs/masonry/3.3.2/masonry.pkgd.min.js"></script>
<style type="text/css">
    .grid-item > div {
        border: 1px solid #dedede;
        padding: 0 15px 15px;
        margin: 15px 0
    }

    span.item-title {
        display: block;
        padding: 5px;
        height: 50px;
        font-weight: bold;
        overflow: hidden;
    }

    .panel-body {
        padding: 10px 25px !important;
    }

    .panel-body [class*="col-"] {
        padding: 10px;
    }
</style>
<script>
    jQuery(function ($) {
        $('.tintuc').masonry({
            itemSelector: '[class*="col-"]',
        });
    });

    function submitSearchTintuc() {
        var keyword = document.getElementById('keyword').value;
        var url = '<?php echo base_url(); ?>tintuc/search/keyword/' + keyword;
        window.location = url;
        return true;
    }
    function submitenterQ(myfield, e, baseUrl) {
        var keycode;
        if (window.event) keycode = window.event.keyCode;
        else if (e) keycode = e.which;
        else return true;

        if (keycode == 13) {
            submitSearchTintuc();
            return false;
        }
        else
            return true;
    }
    ;

</script>
<?php
global $idHome;
$idHome = 1;
?>
<?php $this->load->view('home/common/header'); ?>

<div id="main" class="container-fluid">
    <div class="row tintuc">
        <div class="col-lg-2 hidden-md hidden-sm hidden-xs"
             style="background:#fff; position:fixed; top:0; bottom:0; z-index:100">
            <?php $this->load->view('home/common/left_tintuc'); ?>
        </div>
        <div class="col-lg-10 col-lg-offset-2 ">

            <div class="breadcrumbs hidden-xs">
                <a href="<?php echo base_url(); ?>">Trang chủ</a><i class="fa fa-angle-right"></i>
                <span>Tin tức azinet</span>
            </div>
            <div class="row">
                <div class="col-sm-4">

                    <form class="form-inline" accept-charset="utf-8" name="form-search"
                          action="<?php echo base_url() ?>tintuc/search">
                        <div class="input-group">
                            <input name="keyword" id="keyword" class="form-control" type="text"
                                   placeholder="Nhập từ khóa tìm kiếm"
                                   onKeyPress="return submitenterQ(this,event,'<?php echo base_url(); ?>')"/>
                            <div class="input-group-addon" onclick="return submitSearchTintuc();"
                                 class="btn btn-primary"
                                 value="">&nbsp;<i class="fa fa-search"></i>&nbsp;</div>
                        </div>
                    </form>
                </div>
                <div class="col-sm-8 visible-xs">

                    <ul class="sub-menu-tintuc">
                        <li>
                            <a class="btn btn-default" href="<?php echo base_url() . 'tintuc/'; ?>"
                               data-toggle="tooltip" data-placement="top" title="Tin tức mới">
                                <i class="fa fa-file-text-o fa-fw"></i><span class="hidden-xs">Tin tức mới</span>
                            </a>
                        </li>
                        <li>
                            <a class="btn btn-default" href="<?php echo base_url() . 'tintuc/khuyen-mai/'; ?>"
                               data-toggle="tooltip" data-placement="top" title="Tin khuyến mãi">
                                <i class="fa fa-tag fa-fw"></i><span class="hidden-xs">Tin khuyến mãi</span>
                            </a>
                        </li>
                        <li>
                            <a class="btn btn-default" href="<?php echo base_url() . 'tintuc/tin-hot/'; ?>"
                               data-toggle="tooltip" data-placement="top" title="Tin tức HOT">
                                <i class="fa fa-star fa-fw"></i><span class="hidden-xs">Tin tức HOT</span>
                            </a>
                        </li>
                        <li class="active">
                            <a class="btn btn-default1" href="#"
                               data-toggle="tooltip" data-placement="top" title="Tin xem nhiều">
                                <i class="fa fa-eye fa-fw"></i><span class="hidden-xs">Tin xem nhiều</span>
                            </a>
                        </li>
                        <li class="pull-right">
                            <a class="btn btn-primary" role="button" data-toggle="collapse" href="#collapseMenu"
                               aria-expanded="false" aria-controls="collapseMenu">
                                <i class="fa fa-bars"></i>
                            </a>
                        </li>
                    </ul>

                </div>

                <div class="clear col-sm-12 visible-xs">
                    <div class=" collapse" id="collapseMenu">
                        <ul class="row nav">
                            <?php foreach ($productCategoryRoot as $k => $category) {
                                if ($k == 0) continue; ?>
                                <?php $cat_id = strtolower($this->uri->segment(2)); ?>
                                <li class="col-md-4 col-sm-6">
                                    <a href="<?php echo base_url() . 'tintuc/' . $category->cat_id . "/" . RemoveSign($category->cat_name); ?>">
                                        <img
                                            src="<?php echo base_url() . 'images/icon/icon' . $category->cat_id . '.png' ?>"
                                            style="height:20px;"/>
                                        <?php echo $category->cat_name ?>
                                    </a>
                                </li>
                            <?php } //endforeach ?>

                        </ul>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-newspaper-o fa-fw"></i>&nbsp; Tin tức xem nhiều</h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <?php foreach ($list_news as $k => $item) { ?>
                            <?php if ($k > 0 && $k % 4 == 0) echo '</div><div class="row">'; ?>
                            <div class="col-lg-3 col-md-3 col-sm-3">
                                <div class="thumbox">
                                <a href="<?php echo base_url() ?>tintuc/detail/<?php echo $item->not_id; ?>/<?php echo RemoveSign($item->not_title); ?>">
                                    <?php $filename = 'media/images/tintuc/'.$item->not_dir_image.'/'.show_thumbnail($item->not_dir_image,$item->not_image,3,'tintuc');
                                    if(file_exists($filename) && $item->not_image !=''){
                                        ?>
                                        <img src="<?php echo base_url().$filename; ?>"  class="img-responsive"/>
                                    <?php } else{?>
                                        <img width="300" height="200"  class="img-responsive" src="<?php echo base_url(); ?>media/images/no_photo_icon.png" />
                                    <?php }?>
                                    <span class="item-title"><?php echo $item->not_title ?></span>
                                </a>
                                    </div>
                                <p class="text">
                                    <?php $vovel = array("&curren;");
                                    echo strip_tags(cut_string_unicodeutf8(html_entity_decode(str_replace($vovel, "#", $item->not_detail)), 100)); ?>
                                </p>
                                <p class="text-center small">
                                    <i class="fa fa-calendar fa-fw"></i> <?php echo date('d/m/Y', $item->not_begindate); ?>
                                    <i class="fa fa-eye fa-fw"></i> <?php echo $item->not_view; ?>
                                    <!--<i class="fa fa-user fa-fw"></i> <?php echo $item->use_username; ?>-->
                                </p>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="panel-footer text-center">
                    <?php echo $linkPage ?>
                </div>
            </div>

        </div>
    </div>
</div>
<?php //$this->load->view('home/common/right_tintuc'); ?>
<?php $this->load->view('home/common/footer'); ?>
