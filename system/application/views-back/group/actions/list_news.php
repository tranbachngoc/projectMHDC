<?php $this->load->view('group/common/header'); ?>
<br>
<div id="main" class="container-fluid">
    <div class="row">          
        <div class="col-md-3 sidebar">
            <?php $this->load->view('group/common/menu'); ?>
        </div>   
        <div class="col-md-9 main"> 
	    <h4 class="page-header text-uppercase" style="margin-top:10px">Danh sách tin tức</h4>
            <div class="dashboard">
                <!-- ========================== Begin Content ============================ -->
                
                <form name="frmGroupListNews" id="frmGroupListNews" method="post" action="/grouptrade/<?php echo $segmentGrt ?>/duyetGroupNews">
                    <table class="table table-striped">
                    <?php if (count($listnews) > 0) { ?>
                    <thead style="background: #c5c5c5;">
                        <tr>
                            <th>STT</th>
                            <th>Tên tin tức</th>
                            <th>Người đăng</th>
                            <th>Lên group</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    $demGroup = 0;
                    $tongTin = count($listnews);
                    foreach ($listnews as $k => $item) {
                        if ($item->grt_id > 0) {
                            $demGroup++;
                        }
                        ?>
                        <tr>
                            <th scope="row" class="text-center"><?php echo $stt+$k; ?></th>
                            <td>
                                <div class="pull-left hidden-xs" style="width:50px; height:50px; margin-right: 10px">
                                    <div class="fix1by1">
                                        <div class="c">
                                            <?php
                                            $filename = DOMAIN_CLOUDSERVER . 'media/images/content/' . $item->not_dir_image . '/' . $item->not_image;                 
                                            if ($item->not_image != '') { // file_exists($filename) && $filename != ''
                                                ?>
                                                <a target="_blank"
                                                   href="<?php echo $info[$k]['link_sp'] ?>/news/detail/<?php echo $item->not_id; ?>/<?php echo RemoveSign($item->not_title); ?>">
                                                    <img class="img-responsive" src="<?php echo $filename; ?>"/>
                                                </a>
                                            <?php } else {
                                                ?>
                                                <img width="80"
                                                     src="<?php echo base_url(); ?>media/images/no_photo_icon.png"/>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>

                                <a target="_blank"
                                   href="<?php echo $info[$k]['link_sp'] ?>/news/detail/<?php echo $item->not_id; ?>/<?php echo RemoveSign($item->not_title); ?>">
                                    <?php
                                    $vovel = array("&curren;");
                                    echo strip_tags(cut_string_unicodeutf8(html_entity_decode(str_replace($vovel, "#", $item->not_title)), 50));
                                    ?>
                                </a>
                                <br/>
                                <em class="small"><i class="fa fa-calendar fa-fw"></i>  <?php echo date('d/m/Y', $item->not_begindate); ?></em>
                            </td>
                            <td>
                                <a class="text-primary" href="<?php echo $info[$k]['link_gh'] ?>/shop" target="_blank"><?php echo $item->use_username ?></a><br>
                                <em class="small"><?php echo $item->use_fullname ?></em>
                            </td>
                            <td class="text-center">
                                <input type="checkbox" name="duyet_Newsgroup[]" <?php if(!in_array($item->not_id,$newsNoGroup)){echo 'checked';} ?>
                                       id="duyet_newsgroup" title="Duyệt tin lên group" value="<?php echo $item->not_id ?>"
                                       onchange="duyet_newsGroup(<?php echo $item->not_id ?>);"/>
<!--                                <input type="radio" name="status<?php//$item->not_id ?>" id="status1" value="1"> Hiện-->
<!--                                <br/>-->
<!--                                <input type="radio" name="status<?php // $item->not_id ?>" id="status2" value="0"> Ẩn-->
                            </td>
                        </tr>
                        <?php $sTT++; ?>
                    <?php }
                    $demNoGroup = $tongTin - $demGroup;
                    ?>
<!--                    <tr style="background: #d6d6d6">-->
<!--                        <td colspan="3">-->
<!--                            <label for="" style="float: right">Duyệt tất cả: </label>-->
<!--                            <!--                                        <button type="button" name="duyetall" id="duyetall" style="float: right" onclick="submit_duyetNews();"/></button>-->
<!--                        </td>-->
<!--                        <td colspan="1" style="text-align: center">-->
<!--                            <input type="checkbox" name="checkall" id="checkall_news" --><?php //if ($demGroup == $tongTin ) { echo 'checked';} ?><!-->
<!--                        </td>-->
<!--                    </tr>-->
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

        function duyet_newsGroup(newsID) {            
            $.ajax({
                type: "POST",
                url: siteUrl + "home/grouptrade/duyetNews",
                data: {grt_id: <?php echo $this->uri->segment(2) ?>, content_id: newsID},
                success: function (response) {
                },
                error: function () {
                    alert("Lỗi! Vui lòng thử lại");
                }
            });
        }
        $("#checkall_news").change(function () {
            $("input:checkbox").prop('checked', $(this).prop("checked"));
            document.frmGroupListNews.submit();
        });
        function submit_duyetNews() {
        }
    </script>
<?php $this->load->view('group/common/footer'); ?>