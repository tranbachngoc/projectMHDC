<?php $this->load->view('group/common/header'); ?>
<br>
<div id="main" class="container-fluid">
        <div class="row rowmain">
            <div class="col-md-3 sidebar">
                <?php $this->load->view('group/common/menu'); ?>
            </div>
            <div class="col-md-9 col-xs-12">
		<h4 class="page-header text-uppercase" style="margin-top:10px">Danh sách sản phẩm</h4>
                <div class="dashboard">
                    <!-- ========================== Begin Content ============================ -->
                    <form name="frmGroupPro" id="frmGroupPro" method="post" action="/grouptrade/<?php echo $segmentGrt ?>/duyetGroupPro">
                        <table class="table table-striped">
                            <?php if (count($product) > 0) { ?>
                            <thead style="background: #c5c5c5;">
                            <tr>
                                <th>STT</th>
                                <th>Thông tin sản phẩm</th>
                                <th>Người đăng</th>
                                <th>Lên group</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $demGroup = 0;
                            $tongTin = count($product);
                            foreach ($product as $k => $item) {
                                if ($item->grt_id > 0) {
                                    $demGroup++;
                                }

                                if ($item->pro_type == 2) {
                                    $pro_type = 'coupon';
                                } else {
                                    if ($item->pro_type == 0) {
                                        $pro_type = 'product';
                                    }
                                }
                                ?>
                                <tr>
                                    <th scope="row" class="text-center"><?php echo $stt+$k; ?></th>
                                    <td>
                                        <div class="pull-left hidden-xs" style="width:50px; height:50px; margin-right: 10px">
                                            <div class="fix1by1">
                                                <div class="c">
                                                    <?php
                                                    $filename = 'media/images/product/' . $item->pro_dir . '/thumbnail_1_'. explode(',', $item->pro_image)[0];
                                                    //                                            $imglager = 'media/images/product/' . $productArray->pro_dir . '/' . show_thumbnail($productArray->pro_dir, $productArray->pro_image, 3);
                                                    if ($item->pro_image != '') { //file_exists($filename) && 
                                                        ?>
                                                        <a target="_blank"
                                                           href="<?php echo $info[$k]['link_sp'] . '/shop/' . $pro_type; ?>/detail/<?php echo $item->pro_id; ?>/<?php echo RemoveSign($item->pro_name); ?>">
                                                            <img class="img-responsive" src="<?php echo DOMAIN_CLOUDSERVER . $filename; ?>"/>
                                                        </a>
                                                    <?php } else {
                                                        ?>
                                                        <img width="80"
                                                             src="<?php echo base_url(); ?>media/images/no_photo_icon.png"/>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                        <a target="_blank" class="menu_1"
                                           href="<?php echo $info[$k]['link_sp'] . '/shop/' . $pro_type; ?>/detail/<?php echo $item->pro_id; ?>/<?php echo RemoveSign($item->pro_name); ?>">
                                            <?php echo sub($item->pro_name, 100); ?>
                                        </a>
                                        <br/>
                                        <em class="small"><i class="fa fa-calendar fa-fw"></i>  <?php echo date('d/m/Y', $item->pro_begindate); ?></em>
                                    </td>
                                    <td>
                                        <a class="text-primary" href="<?php echo $info[$k]['link_gh'] ?>/shop" target="_blank"><?php echo $info[$k]['username'] ?></a><br>
                                        <em class="small"><?php echo $info[$k]['fullname'] ?></em>
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" name="duyet_Progroup[]" <?php if(!in_array($item->pro_id,$proNoGroup)){echo 'checked';} ?>
                                               id="duyetgroup" title="Duyệt sản phẩm lên group" value="<?php echo $item->pro_id ?>"
                                               onchange="duyetspGroup(<?php echo $item->pro_id ?>);"/>
                                        <!--                                <input type="radio" name="status<?php//$item->not_id ?>" id="status1" value="1"> Hiện-->
                                        <!--                                <br/>-->
                                        <!--                                <input type="radio" name="status<?php // $item->not_id ?>" id="status2" value="0"> Ẩn-->
                                    </td>
                                </tr>
                                <?php $sTT++; ?>
                            <?php }
                            $demNoGroup = $tongTin - $demGroup;
                            ?>
<!--                            <tr style="background: #d6d6d6">-->
<!--                                <td colspan="3">-->
<!--                                    <label for="" style="float: right">Duyệt tất cả: </label>-->
<!--                                    <!--                                        <button type="button" name="duyetall" id="duyetall" style="float: right" onclick="submit_duyetNews();"/></button>-->
<!--                                </td>-->
<!--                                <td colspan="1" style="text-align: center">-->
<!--                                    <input type="checkbox" name="checkall" id="checkall_pro" --><?php //if ($demGroup == $tongTin ) { echo 'checked';} //if ($demGroup == $tongTin ) { echo 'checked';} ?><!-->
<!--                                </td>-->
<!--                            </tr>-->
                            <?php }
                            else { ?>
                                <tr>
                                    <td colspan="10" class="text-center">Không có tin đăng</td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                        <div class="text-center">
                            <nav> <?php echo $linkPage ?></nav>
                        </div>
                    </form>
                    <!-- ========================== End Content ============================ -->
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        function duyetspGroup(proID) {
            $.ajax({
                type: "POST",
                url: siteUrl + "home/grouptrade/duyetsp",
                data: {grt_id: <?php echo $this->uri->segment(2) ?>, pro_id: proID},
                success: function (response) {
                },
                error: function () {
                    alert("Lỗi! Vui lòng thử lại");
                }
            });
        }
        $("#checkall_pro").change(function () {
            $("input:checkbox").prop('checked', $(this).prop("checked"));
            document.frmGroupPro.submit();
        });
    </script>
<?php $this->load->view('group/common/footer'); ?>