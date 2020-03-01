<?php $this->load->view('home/common/account/header'); ?>
<div class="container-fluid">
    <div class="row rowmain">
        <?php $this->load->view('home/common/left'); ?>
        <!--BEGIN: RIGHT-->
        <div class="col-md-9 col-sm-8 col-xs-12">
            <h4 class="page-header text-uppercase" style="margin-top:10px">Danh sách nhóm tham gia</h4>
            				
                    <div class="row">
                        <?php 
                        if(count($grt_thamgia) > 0){
                            foreach ($grt_thamgia as $key => $items) {
                                $roinhom = '';
                                if($items->grt_admin != $this->session->userdata('sessionUser')){ 
                                    $roinhom = '<li><a href="/account/groups/leavegroup/'.$items->grt_id.'">Rời khỏi nhóm</a></li>';
                                }
                                ?>
                            <div class="col-sm-6">
                                <div style="border: 1px solid #eee; padding: 10px; margin-bottom:20px;">
                                    <div class="pull-left" style="width:60px">
                                        <div class="fix1by1 img-circle">
                                            <?php
                                            if(file_exists('media/group/logos/'.$items->grt_dir_logo.'/'.$items->grt_logo) && $items->grt_logo != ''){
                                                $logo = '/media/group/logos/'.$items->grt_dir_logo.'/'.$items->grt_logo;
                                            }else{
                                                $logo = '/images/community_join.png';
                                            } ?>
                                            <a href="#" class="c" style="background:url('<?php echo $logo ?>') no-repeat center / auto 100%;"></a>
                                        </div>
                                    </div>
                                    <div style="padding: 18px 0 18px 70px;">
                                        <div class="btn-group pull-right">
                                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fa fa-cog"></i>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a href="/account/groups/approvemember/<?php echo $items->grt_id ?>" target="_blank">Duyệt thành viên</a></li>
                                                <li><a href="/account/groups/approvenews/<?php echo $items->grt_id ?>" target="_blank">Duyệt tin tức</a></li>
                                                <li><a href="/account/groups/approveproduct/<?php echo $items->grt_id ?>" target="_blank">Duyệt sản phẩm</a></li>
                                                <?php if($items->grt_type > 1){ ?>
                                                <li><a href="/account/groups/configcommiss/<?php echo $items->grt_id ?>" target="_blank">Cấu hình hoa hồng</a></li>
                                                <?php } 
                                                echo $roinhom; ?>
                                            </ul>
                                        </div>
                                        <div class="title-ellipsis">
                                            <a href="#"><?php echo $items->grt_name ?></a>
                                        </div>
                                    </div>
                                </div> 
                            </div>
                        <?php } 
                        } else { ?>
                            <div class="col-sm-12">
                                Bạn chưa tham gia nhóm nào.
                            </div>
                        <?php }
                        ?>
                    </div>
                
        </div>
        <!--END RIGHT-->
    </div>
</div>
<?php $this->load->view('home/common/footer'); ?>