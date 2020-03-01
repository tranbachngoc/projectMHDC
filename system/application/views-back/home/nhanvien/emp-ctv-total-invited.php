<?php $this->load->view('home/common/account/header'); ?>
<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>templates/home/css/jScrollPane.css"/>
<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>templates/home/css/simplemodal.css" media='screen'/>
<script language="javascript" src="<?php echo base_url(); ?>templates/home/js/check_email.js"></script>
<script language="javascript" src="<?php echo base_url(); ?>templates/home/js/simplemodal.js"></script>
<!--BEGIN: LEFT-->
<div id="main" class="container-fluid">
    <div class="row">        
        <!--BEGIN: Left menu-->
        <?php if ($this->session->userdata('sessionUser') > 0 && $this->session->userdata('sessionGroup') == StaffStoreUser) {
            $this->load->view('home/common/left');
        } ?>
        <!--END-->
        <div class="col-md-9 col-sm-8 col-xs-12">
            <h4 class="page-header text-uppercase" style="margin-top:10px;">DANH SÁCH CỘNG TÁC VIÊN ĐÃ GIỚI THIỆU</h4>
            <?php if ($totalRecord > 0) { ?>
            <p style="text-align: right; font-weight: bold;">Tổng danh sách CTV:
            <span style="color:#f00;">
                <?php echo $totalRecord ?>
            </span>
            </p>

            <div>
                <table class="table table-bordered" width="100%" border="0" cellpadding="0" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="40" class="title_account_0">STT</th>
                            <th width="120" class="title_account_2" align="center">Tài khoản</th>
                            <th width="120" class="text-center">Email - Điện thoại</th>
                            <th width="40" class="text-center" align="center">Link</th>
                            <th width="40" class="text-center">Nhắn tin</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($dataCTVs as $key => $obj) { ?>
                        <tr>
                            <td class="line_account_0 text-center">
                                <?php echo $obj->stt ;?>
                            </td>
                            <td class="line_account_2">
                                <a target="_blank" href="#"><?php echo $obj->use_username;?></a>
                            </td>
                            <td class="text-center">
                                <i class="fa fa-envelope-o fa-fw"></i> <a href="mailto:<?php echo $obj->use_email;?>"><?php echo $obj->use_email;?></a><br>
                                <i class="fa fa-phone fa-fw"></i> <a href="tel:<?php echo $obj->use_mobile;?>"><?php echo $obj->use_mobile;?></a>
                            </td>
                            <td class="text-center">
                                <a class="btn btn-default" href="<?php echo $obj->sho_link;?>" target="_blank" title="Đến trang tin">
                                    <i class="azicon icon-newspaper"></i>
                                </a>
                                <a class="btn btn-default" href="<?php echo $obj->sho_link . '/shop';?>" target="_blank" title="Đến trang cửa hàng">
                                    <i class="azicon icon-store"></i>
                                </a>
                            </td>
                            <td class="text-center">
                                <a class="btn btn-info btn-sm" title="Gửi tin nhắn SMS" href="sms:<?php echo $obj->use_mobile;?>">
                                    <i class="fa fa-comment fa-fw"></i>
                                </a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <div class="text-center">
                <?php echo $linkPage; ?>
            </div>
        <?php 
    } else { ?>
            <div style="text-align: center; padding: 10px; border:1px solid #eee;">Chưa có dữ liệu cho mục này.</div>
        <?php 
    } ?>
    </div>
</div>

<?php $this->load->view('home/common/footer'); ?>
