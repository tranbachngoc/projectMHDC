<?php $this->load->view('group/common/header'); ?>
    <style>
        .leftMember {
            width: 100px;
            float: left;
        }

        .rightMember {
            margin-left: 110px; padding-right: 10px;
        }

        
        .stt {
            position: absolute;
            background: rgba(255, 255, 255, 0.67);
            padding: 3px 8px;
            border: 1px solid #ccc;
            top: 6px;
        }
    </style>
<br>
<div id="main" class="container-fluid">
        <div class="row">
            <div class="col-md-3 sidebar">
                <?php $this->load->view('group/common/menu'); ?>
            </div>
            <div class="col-md-9 main">
		<h4 class="page-header text-uppercase" style="margin-top:10px">Phê duyệt thành viên</h4>
                <div class="dashboard">
                    <!-- ========================== Begin Content ============================ -->
                    <div class="group-news">
                       
                        <div class="" style="margin-bottom: 20px">
                            <?php
                            if(count($listGH)>0) {
                                foreach ($listGH as $key => $gh) { ?>
                                    <div class="row" style="margin-bottom: 20px" id="listmember_<?php echo $gh->use_id; ?>">
                                        <div class="col-xs-12 col-sm-12" style="padding: 5px;">
                                            <label>Thành viên thuộc Gian Hàng (Mr/Ms):
                                                <strong>
                                                    <?php
                                                    if($gh->use_fullname != ''){ $title = $gh->use_fullname;}
                                                    else{$title = ' Chưa Cập Nhật'; }
                                                    $title .= ' ('.$gh->use_username.')';
                                                    ?>
                                                    <?php echo $title ?>
                                                </strong>
                                            </label>
                                        </div>
                                        <?php //foreach ($listMember as $k=>$item) { ?>
                                        <?php
                                        if(count($listMember[$gh->use_id]) >0 ){
                                            for ($i = 0; $i < count($listMember[$gh->use_id]); $i++) {
                                            $arrBackuser = explode(',', $backlistUser);
                                            $arrGroupID = explode(',', $listMember[$gh->use_id][$i]['use_group_trade']);
                                                ?>
                                                <div class="col-xs-12 col-sm-6"
                                                     style="padding: 5px; position: relative">
                                                    <div class="stt"><?php echo $i + 1; ?></div>
                                                    <div
                                                        style="display: inline-block; border: 1px solid #ddd; width:100%; background: #fff;">
                                                        <div class="pull-left leftMember" style="margin-right: 10px">
                                                            <img
                                                                src="<?php if ($listMember[$gh->use_id][$i]['avatar'] != '') {
                                                                    echo '/media/images/avatar/' . $listMember[$gh->use_id][$i]['avatar'];
                                                                } else {
                                                                    echo '/images/user-avatar-default.png';
                                                                } ?>"
                                                                style="width:100px; height: 100px "/>
                                                        </div>
                                                        <div class="rightMember">
                                                            <div style="padding:6px 0">
                                                                <strong><?php
                                                                    if ($listMember[$gh->use_id][$i]['use_fullname'] != '') echo $listMember[$gh->use_id][$i]['use_fullname'];
                                                                    else
                                                                        echo 'Chưa cập nhật'; ?>
                                                                </strong>
                                                            </div>
                                                            <div class="small">
                                                                <i class="fa fa-user fa-fw"></i>&nbsp; 
                                                                <?php echo $listMember[$gh->use_id][$i]['use_username']; ?>
                                                                <br/>
                                                                <i class="fa fa-phone fa-fw"></i>&nbsp;
                                                                <?php if ($listMember[$gh->use_id][$i]['use_mobile'] != '') echo $listMember[$gh->use_id][$i]['use_mobile'];
                                                                else
                                                                    echo 'Chưa cập nhật'; ?>
                                                               <br/>
                                                               <i class="fa fa-envelope fa-fw"></i>&nbsp;
                                                                <?php if ($listMember[$gh->use_id][$i]['use_email'] != '') echo $listMember[$gh->use_id][$i]['use_email'];
                                                                else
                                                                    echo 'Chưa cập nhật'; ?>
                                                                    
                                                                
                                                                <br/>
                                                                <span class="text-muted" style="float: right;">Đã tham gia: <?php echo date('Y-m-d', $listMember[$gh->use_id][$i]['use_regisdate']); ?></span>

                                                            </div>
                                                        </div>
                                                        <?php 
                                                        if($gh->use_id != $listMember[$gh->use_id][$i]['use_id'])
                                                        {
                                                        ?>
                                                        <?php
                                                            if ($arr_backu && in_array($listMember[$gh->use_id][$i]['use_id'], $arr_backu)) {
                                                                $icon1 = 'fa-pencil';
                                                                $icon2 = 'fa-pencil-square-o';
                                                                $lenh = 'duyet';
                                                                $txt = 'Phê duyệt';
                                                            }
                                                            else{
                                                                $icon1 = 'fa-check text-success';
                                                                $icon2 = 'fa-fw text-danger';
                                                                $lenh = 'loai';
                                                                $txt = 'Bỏ phê duyệt';
                                                            }
                                                             ?>
                                                            <div class="dropdown"
                                                                 style="position: absolute; top:15px; right:15px">
                                                                <button class="btn btn-default btn-sm dropdown-toggle"
                                                                        type="button"
                                                                        id="dropdownMenu1" data-toggle="dropdown"
                                                                        aria-haspopup="true" aria-expanded="true">
                                                                    <i class="fa <?php echo $icon1 ?><?php //echo in_array((int)$this->session->userdata('sessionGrt'), $arrGroupID)?'fa-check text-success':'fa-cog'?>"></i>
                                                                </button>
                                                                <ul class="dropdown-menu pull-right"
                                                                    aria-labelledby="dropdownMenu1">
                                                                        <li>
                                                                            <a href="listmember/<?php echo $lenh?>/<?php echo $listMember[$gh->use_id][$i]['use_id']; ?>"><i
                                                                                    class="fa fa-times <?php echo $icon2?>"></i> <?php echo $txt;?></a>
                                                                        </li>
                                                                </ul>
                                                            </div>
                                                        <?php 
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                            <?php }
                                        }else{
                                            echo '<div style="background: #fff; padding: 10px;margin-bottom: 20px; overflow: hidden;">Không có thành viên</div>';
                                        }?>
                                    </div>

                                <?php }
                            }
                            else{
                                ?>
                                <div style="background: #fff; padding: 10px;margin-bottom: 20px; text-align: center;">Không có thành viên</div>
                                <?php
                            }?>
                        </div>
                    </div>
                    <!-- ========================== End Content ============================ -->
                </div>
            </div>
        </div>
    </div>
<?php $this->load->view('group/common/footer'); ?>