<?php $this->load->view('home/common/account/header'); ?>
    <div class="container-fluid">
        <div class="row">
            <?php $this->load->view('home/common/left'); ?>
            <!--BEGIN: RIGHT-->
            <div class="col-md-9 col-sm-8 col-xs-12">
		<h4 class="page-header text-uppercase" style="margin-top:10px">
		    Thưởng thêm theo doanh thu Cộng Tác Viên <b><?php echo $aff_name->use_username; ?></b>
		</h4>
                <!-- Thông báo lỗi nếu có -->
                <?php if (isset($nullCommissionAff) && $nullCommissionAff!='') { ?>
                    <div class="message success">
                        <div class="alert alert-danger">
                            <?php echo $nullCommissionAff; ?>
                            <button type="button" class="close" data-dismiss="alert">×</button>
                        </div>
                    </div>
                <?php } ?>
                <!-- Thông báo lỗi nếu có -->
                
                <?php if (count($list_commiss_sho) > 0) { ?>
                    <div style="overflow: auto; width:100%">
                        <table width="100%" border="1" align="center" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Doanh thu / tháng</th>
                                    <th>Hoa hồng (%)</th>
                                    <th>Sửa</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 0;
                                foreach ($list_commiss_sho as $key => $value) {
                                    $i++; ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td>
                                            Doanh thu từ <b style="color: red"><?php echo number_format($value['min'], 0, ",", "."); ?></b>
                                            VNĐ đến <b style="color: red"><?php echo number_format($value['max'], 0, ",", "."); ?></b>
                                            VNĐ
                                        </td>
                                        <td>                                    
                                            <input disabled="disabled"
                                                   class="form-control text_edit_config text_edit_config_<?php echo $value['id']; ?>"
                                                   id="commission_<?php echo $value['id']; ?>" name="id" type="text"
                                                   value="<?php echo $value['percent']; ?>"/>
                                            <input type="hidden" name="id" type="text" value="<?php echo $value['id']; ?>"/>                                    
                                        </td>
                                        <td class="detail_list" align="center" style="text-align:center">
                                            <button
                                                onclick="Save_Commiss_Aff(<?php echo $value['id'] ?>,'<?php echo base_url() ?>',<?php echo $aff_name->use_id; ?>)"
                                                class="btn btn-default save_commission_config save_commission_config_<?php echo $value['id']; ?>">
                                                Lưu
                                            </button>
                                            <button onclick="Edit_Commiss_Aff(<?php echo $value['id'] ?>)"
                                                    class="btn btn-default edit_commission_config edit_commission_config_<?php echo $value['id']; ?>">
                                                Sửa
                                            </button>
                                        </td>
                                    </tr>
                                <?php } ?>

                            </tbody>
                        </table>
                    </div>

                    <div class="text-center">
                        <?php echo $linkPage; ?>
                    </div>                
               
                <?php } else { ?>
                    <div style="padding: 10px; border:1px solid #eee; text-align: center;">Không có dữ liệu!</div>
                <?php } ?>
                <br/>    
            </div>
        </div>
    </div>
    <!--END RIGHT-->

    <script type="text/javascript">
        $(".save_commission_config").css("display", "none");

        function Edit_Commiss_Aff(id) {
            alert("Đây là thông tin rất quan trọng, bạn hãy cận thận khi chỉnh sửa!");
            jQuery(".text_edit_config_" + id).each(function (index) {
                this.disabled = false;
            });
            jQuery(".save_commission_config_" + id).css("display", "block");
            jQuery(".edit_commission_config_" + id).css("display", "none");
        }

        function Save_Commiss_Aff(id, baseUrl, use_id) {
            var isOk = true;
            jQuery(".text_edit_config_" + id).each(function (index) {
                if (this.value == '' || jQuery.trim(this.value) == '') {
                    alert("Bạn phải nhập dữ liệu đầy đủ trước khi chỉnh sửa!");
                    jQuery('#' + jQuery(this).attr('id')).focus();
                    jQuery('#' + jQuery(this).attr('id')).val('');
                    isOk = false;
                } else {
                    // if(isValueCommissionSolution(this.value)){
                    // }else{
                    //    isOk = false;
                    //    alert("Bạn phải nhập dữ liệu dạng số!");
                    // }
                }
            });
            if (isOk) {
                var commission = jQuery('#commission_' + id).val();
                $.ajax({
                    type: "get",
                    url: baseUrl + "account/affiliate/Update_Commission_Aff_Ajax/" + id + "/" + use_id + "/" + commission,
//                    data: "id=" + id + "&userid=" + use_id + "&commission=" + commission,
//                    dataType: "json",
                    success: function (data) {
//                        console.log(data);
                        if (data == '2' || data == '1') {
                            alert("Cập nhật thành công!");
                        }
                        $(".text_edit_config_" + id).attr('disabled', 'true');
                        $(".save_commission_config").css("display", "none");
                        $(".edit_commission_config").css("display", "block");
                    },
                    error: function (data, exception) {
                        alert("No Data!");
                    }
                });
            }
        }
    </script>
<?php $this->load->view('home/common/footer'); ?>