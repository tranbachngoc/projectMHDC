<?php
global $idHome;
$idHome = 1;
?>
<?php $this->load->view('home/common/account/header'); ?>
    <script>
        function del_Tin(id) {
            if (confirm("Bạn chắc chắn xóa tin này?")) {
                $.ajax({
                    type: "post",
                    url: "<?php echo base_url(); ?>" + 'home/account/del_tin',
                    cache: false,
                    data: {id: id},
                    success: function (data) {
                        if (data == '0') {
                            alert('Xóa không thành công !');
                        } else {
                            $('.item_' + id).css('display', 'none');
                        }
                    }
                });
            }
            return false;
        }
    </script>
    <style>
        .boxnew {
            background: #fff;
            padding-bottom: 20px;
        }
    </style>
    <div class="container-fluid">
        <div class="row">
            <?php $this->load->view('home/common/left'); ?>

            <div class="col-md-9 col-sm-8 col-xs-12 account_edit">
                <h4 class="page-header" style="margin-top:10px">
                    DANH SÁCH TIN ĐĂNG
                </h4>

                <div class="listpost">
                    <?php
                    if (count($listnews) > 0) {
                        $linkShop = $shop->sho_link;
                        ?>
                        <div class="btn-group pull-right" role="group">
                            <p>
                                <a class="btn btn-default" href="<?php echo base_url(); ?>tintuc" target="_blank">
                                    <i class="fa fa-newspaper-o fa-fw"></i> Xem trang tin
                                </a>
                                <a class="btn btn-success" href="#"
                                   onclick="ActionLink('<?php echo base_url(); ?>account/news/add')">
                                    <i class="fa fa-plus fa-fw"></i> Thêm mới
                                </a>
                            </p>
                        </div>
                        <div class="clearfix"></div>
                        <?php
                        foreach ($listnews as $item) {                            
                            ?>
                            <div class="row boxnew">
                                <div class="col-xs-12">
                                    <div class="pull-left" style="margin-right: 10px;">
                                        <a target="_blank"
                                           href="<?php echo base_url(); ?>tintuc/detail/<?php echo $item->not_id; ?>/<?php echo RemoveSign($item->not_title); ?>">
                                            <?php 
                                            if(strlen($item->not_image) > 10) { 
                                                $filename = DOMAIN_CLOUDSERVER .'media/images/content/' . $item->not_dir_image . '/thumbnail_1_' . $item->not_image;
                                            } else {
                                                $filename = '/media/images/noimage.png';
                                            } ?>
                                                
                                            <img class="img-responsive" style="width:150px" src="<?php echo $filename; ?>"/>
                                        </a>
                                    </div>
                                    <div class="pull-right" style="width: 44px;">
                                        <?php if ($item->not_publish == 1) { ?>
                                            <a title="Đã xuất bản" class="btn btn-primary btn_action"
                                               href="javascript:void(0)"><i class="fa fa-unlock fa-fw"
                                                                            aria-hidden="true"></i></a>
                                        <?php } else { ?>
                                            <a title="Chưa được phép xuất bản" href="javascript:void(0)"
                                               class="btn btn-danger btn_action"><i class="fa fa-lock fa-fw"
                                                                                    aria-hidden="true"></i></a>
                                        <?php } ?>
                                        <?php if ($group_id == AffiliateStoreUser || isset($PermissionStoreUser)) { ?>
                                            <?php if ($item->not_status == 1) { ?>
                                                <a class="btn btn-primary btn_action" href="javascript:void(0)"
                                                   title="Ngưng kích hoạt"
                                                   onclick="ActionLink('<?php echo $statusUrl; ?>/status/deactive/id/<?php echo $item->not_id; ?>')"
                                                   style="margin: 5px 0"><i class="fa fa-check fa-fw"></i></a>
                                            <?php } else { ?>
                                                <a class="btn btn-default btn_action" href="javascript:void(0)"
                                                   title="Kích hoạt"
                                                   onclick="ActionLink('<?php echo $statusUrl; ?>/status/active/id/<?php echo $item->not_id; ?>')"
                                                   style="margin: 5px 0"><i class="fa fa-times fa-fw"></i></a>
                                            <?php } ?>
                                        <?php } ?>
                                        <button type="button" class="btn btn-primary btn_action"
                                                onclick="ActionLink('<?php echo base_url(); ?>account/news/edit/<?php echo $item->not_id; ?>')"
                                                alt="Sửa" title="Sửa">
                                            <i class="fa fa-pencil-square-o  fa-fw"></i>
                                        </button>
                                    </div>

                                    <div class="pull-none" style="margin-left: 180px">
                                        <h4 class="media-heading">
                                            <a target="_blank"
                                               href="<?php echo base_url(); ?>tintuc/detail/<?php echo $item->not_id; ?>/<?php echo RemoveSign($item->not_title); ?>">
                                                <?php
                                                $vovel = array("&curren;");
                                                echo strip_tags(cut_string_unicodeutf8(html_entity_decode(str_replace($vovel, "#", $item->not_title)), 50));
                                                ?>
                                            </a>
                                        </h4>
                                        <p class="hidden-xs">
                                            <?php echo strip_tags(cut_string_unicodeutf8(html_entity_decode(str_replace($vovel, "#", $item->not_description)), 200));?>
                                        </p>
                                        <p>
                                            <i class="fa fa-calendar fa-fw"></i> <?php echo date('d/m/Y', $item->not_begindate); ?>
                                            | <a class="readmore" target="_blank"
                                                  href="<?php echo base_url(); ?>tintuc/detail/<?php echo $item->not_id; ?>/<?php echo RemoveSign($item->not_title); ?>"><i
                                                    class="fa fa-file-text-o fa-fw"></i> Xem chi tiết</a>
                                        <?php if ($group_id == AffiliateStoreUser || $group_id == AffiliateUser || isset($PermissionStoreUser)): ?>                                            
                                            | <a href="<?php echo base_url() . 'account/service/news/' . $item->not_id; ?>"><i class="fa fa-check-square-o fa-fw"></i> Chọn
                                                    dịch vụ</a>
                                        <?php endif; ?>
                                            </p>
                                    </div>
                                </div>
                            </div>

                        <?php } ?>
                        <?php echo $linkPage ?>

                    <?php } else { ?>

                        <p class="text-center">Bạn chưa cập nhật tin tức, vui lòng đăng tin tức <a
                                href="<?php echo base_url(); ?>account/news/add">tại đây</a></p>

                    <?php } ?>
                </div>


            </div>
        </div>
    </div>
<?php $this->load->view('home/common/footer'); ?>