<?php $this->load->view('home/common/account/header'); ?>
<div class="clearfix"></div>
<div id="product_content" class="container-fluid">
    <div class="row rowmain">
        <?php $this->load->view('home/common/left'); ?>        
        <style type="text/css">
            .fa-spinner {
                font-size: 17px;
                display: none;
            }
        </style>
        <!--BEGIN: RIGHT-->
        <div class="col-md-9 col-xs-12">            
			<h4 class="page-header text-uppercase" style="margin-top:10px">Danh sách tin tức</h4>
            <form name="frmGroupNews" id="frmGroupNews" method="post" action="/account/grouptrade/duyetNews">
                <div style="overflow: auto">
                    <table class="table table-bordered" width="100%" border="0" cellpadding="0" cellspacing="0">

                            <?php if (count($listnews) > 0) { ?>

                                <thead>
                                <tr>

                                    <th width="1%" class="aligncenter hidden-xs hidden-sm">STT</th>
                                    <th width="10%" class="text-center">
                                        Hình ảnh
                                    </th>
                                    <th width="20%" class="aligncenter">
                                        <?php echo "Tên tin"; //$this->lang->line('product_list'); ?>
                                        <!-- <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif"
                                             onclick="ActionSort('<?php echo $sortUrl; ?>name/by/asc<?php echo $pageSort; ?>')"
                                             border="0" style="cursor:pointer;" alt=""/>
                                        <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif"
                                             onclick="ActionSort('<?php echo $sortUrl; ?>name/by/desc<?php echo $pageSort; ?>')"
                                             border="0" style="cursor:pointer;" alt=""/> -->
                                    </th>
                                    <th width="25%" class="aligncenter hidden-xs hidden-sm">
                                        Tóm tắt
                                    </th>
                                    <th width="25%" class="aligncenter hidden-xs hidden-sm">
                                        Gian hàng
                                    </th>
                                    <th width="5%" class="aligncenter hidden-xs hidden-sm">
                                        Ngày đăng
                                    </th>
                                    <th width="5%"><span>Lên group</span></th>

                                </tr>
                                </thead>
                                <?php $idDiv = 1; ?>
                                <?php
                                $demGroup = 0;
                                $tongTin = count($listnews);
                                foreach ($listnews as $k => $item) {
                                    if ($item->grt_id > 0) {
                                        $demGroup++;
                                    }
                                    ?>

                                    <!-- Modal -->
                                    <tr>
                                        <td height="45" class="aligncenter hidden-xs hidden-sm"><?php echo $sTT+k; ?></td>
                                        <td class="img_prev aligncenter">
                                            <?php
                                            $filename = DOMAIN_CLOUDSERVER.'media/images/content/' . $item->not_dir_image . '/' . show_thumbnail($item->not_dir_image, $item->not_image, 2, 'content');
                           
                                            if ($filename != '') {
                                                ?>
                                                <a target="_blank"
                                                   href="<?php echo $filename; ?>">
                                                       <img class="img-responsive" src="<?php echo $filename; ?>"/>
                                                </a>
                                            <?php } else {
                                                ?>
                                                <img width="80"
                                                     src="<?php echo base_url(); ?>media/images/no_photo_icon.png"/>
                                            <?php } ?>
                                        </td>
                                        <td>
                                            
                                            <a target="_blank"
                                               href="<?php echo $info[$k]['link_sp'] ?>/news/detail/<?php echo $item->not_id; ?>/<?php echo RemoveSign($item->not_title); ?>">
                                                <?php
                                                $vovel = array("&curren;");
                                                echo strip_tags(cut_string_unicodeutf8(html_entity_decode(str_replace($vovel, "#", $item->not_title)), 50));
                                                ?>
                                            </a>
                                        </td>
                                        <td class="hidden-xs hidden-sm">

                                            <em style="font-size: 12px"><?php
                                                $vovel = array("&curren;");
                                                echo strip_tags(cut_string_unicodeutf8(html_entity_decode(str_replace($vovel, "#", $item->not_detail)), 100));
                                                ?></em>
                                        </td>
                                        <td class="aligncenter hidden-xs hidden-sm">
                                            <a target="_blank"
                                               href="<?php echo $info[$k]['link_gh'] ?>/news">
                                                <?php echo $item->use_username; ?>
                                                </a>
                                        </td>
                                        <td class="aligncenter hidden-xs hidden-sm">
                                            <?php echo date('d/m/Y', $item->not_begindate); ?>
                                        </td>
                                        <td class="aligncenter">
                                            <input type="checkbox" name="duyet_Newsgroup[]" <?php if(!in_array($item->not_id,$newsNoGroup)){echo 'checked';} ?>
                                                   id="duyet_newsgroup" title="Duyệt tin lên group" value="<?php echo $item->not_id ?>"
                                                   onchange="duyet_newsGroup(<?php echo $this->uri->segment(4).','.$item->not_id ?>);"
                                            />
                                        </td>                                       
                                    </tr>
                                    <?php $idDiv++; ?>
                                    <?php $sTT++; ?>
                                <?php }
                                $demNoGroup = $tongTin - $demGroup;
                                ?>

                            <?php }
                            else { ?>
                                <tr>
                                    <td colspan="10" class="text-center">Không có tin đăng</td>
                                </tr>
                            <?php } ?>
                    </table>
                </div>
                <?php if (isset($linkPage)) { ?>
                    <?php echo $linkPage; ?>
                <?php } ?>
            </form>
        </div>
    </div>
</div>
<style>
    td.img_prev.aligncenter img {
        max-width: 70px;
        max-height: 70px;
    }
</style>
<script type="text/javascript">

    function duyet_newsGroup(grt_id,newsID) {
        $.ajax({
            type: "get",
            url: "home/grouptrade/duyetNews/" + newsID,
            data: {pro_id: newsID},
            success: function (response) {
                window.location.href = "/account/grouptrade/duyetNews?grt_id="+grt_id+"&news_id=" + newsID;
            }
        });
    }
    $("#checkall_news").change(function () {
            $("input:checkbox").prop('checked', $(this).prop("checked"));
        document.frmGroupNews.submit();
    });
        function submit_duyetNews() {
    }
</script>
<!--END RIGHT-->
<?php $this->load->view('home/common/footer'); ?>
