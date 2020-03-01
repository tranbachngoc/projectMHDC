<?php $this->load->view('home/common/account/header'); ?>
<div class="container-fluid">
    <div class="row">
        <?php $this->load->view('home/common/left'); ?>
        <!--BEGIN: RIGHT-->
        <div class="col-md-9 col-sm-8 col-xs-12">
            <h4 class="page-header text-uppercase" style="margin-top:10px">
                Cấu hình các mức thưởng thêm doanh thu Cộng tác viên: <b><?php echo $ctv_data->use_fullname;?></b>
            </h4>
            <!-- Thông báo lỗi nếu có -->
            <?php if ($this->session->flashdata('flash_message_success') || $this->session->flashdata('flash_message_error')) { ?>
                <div class="message success">
                    <div class="alert <?php echo ($this->session->flashdata('flash_message_error') ? 'alert-danger' : 'alert-success') ?>">
                        <?php echo ($this->session->flashdata('flash_message_error') ? $this->session->flashdata('flash_message_error') : $this->session->flashdata('flash_message_success')); ?>
                        <button type="button" class="close" data-dismiss="alert">×</button>
                    </div>
                </div>
            <?php } ?>
            <!-- Thông báo lỗi nếu có -->
            <div class="table-responsive">                      
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="title_list">STT</th>              
                            <th class="">Doanh thu / tháng
                                <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>/min/by/asc')" border="0" style="cursor:pointer;" alt="">
                                <img src="/templates/home/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>/min/by/desc')" border="0" style="cursor:pointer;" alt="">
                            </th>
                            <th class="title_list">Hoa hồng (%)
                                <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>/percent/by/asc')" border="0" style="cursor:pointer;" alt="">
                                <img src="/templates/home/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>/percent/by/desc')" border="0" style="cursor:pointer;" alt="">
                            </th>
                            <th class="title_list">Xóa</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 0;
                        foreach ($list_doanhthu as $key => $value) {
                            $i++;
                            ?> 
                            <tr>
                                <td class="title_list"><?php echo $key + 1; ?></td>
                                <td class="title_list doanhthu_thang">
                                    Doanh thu từ <b style="color: red"><?php echo number_format($value->min, 0, ",", "."); ?></b> VNĐ đến <b style="color: red"><?php echo number_format($value->max, 0, ",", "."); ?></b> VNĐ
                                </td>

                                <td class="title_list"><?php echo $value->percent; ?>
                                </td>
                                <td class="title_list edit" align="">
                                    <!-- <a href="<?php echo base_url() . 'account/affiliate/addcommissonaffiliate/' . $ctv_data->af_id . '/' . $value->id; ?>" class="btn btn-default" style="color: black !important"><i class="fa fa-pencil-square-o "></i></a> -  -->
                                    <a href="<?php echo base_url() . 'account/affiliate/deletecommissionaff/' . $ctv_data->af_id . '/' . $value->id; ?>" class="btn btn-default" style="color: black !important"><i class="fa fa-trash-o text-danger"></i></a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <div class="row">
                <div class="col-sm-6 col-xs-12 text-left">
                    <?php echo $linkPage; ?>
                </div>
                <div class="col-sm-6 col-xs-12 text-right">
                    <a class="btn btn-azibai" href="<?php echo base_url() . "account/affiliate/addcommissonaffiliate/"  . $ctv_data->af_id ;?>"> +Thêm mới</a>
                </div> 
            </div>
            <br>
            <!-- add edit -->
        </div>
    </div>
</div>
<!--END RIGHT-->
<?php $this->load->view('home/common/footer'); ?>


