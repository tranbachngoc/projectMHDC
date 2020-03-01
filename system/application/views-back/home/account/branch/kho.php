<?php $group_id = (int)$this->session->userdata('sessionGroup'); ?>
<?php $this->load->view('home/common/account/header'); ?>
    <style>
        #CHKho .rows {
            margin-bottom: 10px;
            overflow: hidden;
        }
    </style>
    <div class="container-fluid">
        <div class="row">
            <?php $this->load->view('home/common/left'); ?>
            <!--BEGIN: RIGHT-->
	    <div class="col-md-9 col-sm-8 col-xs-12  account_edit db_table">
            <h4 class="page-header" style="margin-top:10px">GIAN HÀNG TỰ KHAI BÁO KHO</h4>
            
                <table class="table table-bordered">
                    <tr>
                        <td>
                            <?php if ($successEditBank == false) { ?>
                                <form name="frmEditKho" id="frmEditKho" method="post" class="form-horizontal col-lg-10">
                                    <div class="" id="CHKho">
                                        <div class="title" style=""></div>
                                        <div class="box_checkkho">
                                            <div class="rows">
                                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                    <font color="#FF0000">*</font> Địa chỉ kho:
                                                </div>
                                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                    <input type="text" name="address_kho_shop" id="address_kho_shop"
                                                           class="selectprovince_formpost form-control" <?php echo $khaibaoKho ?>
                                                           value="<?php if ($address_kho_shop != '') echo $address_kho_shop; ?>" required>
                                                </div>
                                            </div>
                                            <div class="rows">
                                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                    <font
                                                        color="#FF0000">*</font> <?php echo $this->lang->line('province_shop_account'); ?>
                                                    Kho:
                                                </div>
                                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                    <select name="province_kho_shop" id="province_kho_shop" required
                                                            class="selectprovince_formpost form-control" <?php echo $khaibaoKho ?> >
                                                        <option value="">Chọn Tỉnh/Thành Kho</option>
                                                        <?php foreach ($province as $provinceArray) { ?>
                                                            <?php if (isset($province_kho_shop) && $province_kho_shop == $provinceArray->pre_id) { ?>
                                                                <option
                                                                    value="<?php echo $provinceArray->pre_id; ?>"
                                                                    selected="selected"><?php echo $provinceArray->pre_name; ?></option>
                                                            <?php } else { ?>
                                                                <option
                                                                    value="<?php echo $provinceArray->pre_id; ?>"><?php echo $provinceArray->pre_name; ?></option>
                                                            <?php } ?>
                                                        <?php } ?>
                                                    </select>
                                                    <?php echo form_error('province_shop'); ?>
                                                </div>
                                            </div>
                                            <div class="rows">
                                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                    <font
                                                        color="#FF0000">*</font> <?php echo $this->lang->line('district_account_label_edit_account'); ?>
                                                    Kho:
                                                </div>
                                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                    <select name="district_kho_shop" id="district_kho_shop" required
                                                            class="selectprovince_formpost form-control" <?php echo $khaibaoKho ?>>
                                                        <option value="">Chọn Quận/Huyện</option>
                                                        <?php foreach ($kho_district as $districtArray) { ?>
                                                            <?php if (isset($district_kho_shop) && $district_kho_shop == $districtArray->DistrictCode) { ?>
                                                                <option
                                                                    value="<?php echo $districtArray->DistrictCode; ?>"
                                                                    selected="selected"><?php echo $districtArray->DistrictName; ?></option>
                                                            <?php } else { ?>
                                                                <option
                                                                    value="<?php echo $districtArray->DistrictCode; ?>"><?php echo $districtArray->DistrictName; ?></option>
                                                            <?php } ?>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="rows" style="text-align: center;">
                                                <div class="form-group">
                                                    <input type="button" onclick="Submit_Form();"
                                                           name="submit_editshoprule"
                                                           value="<?php echo $this->lang->line('button_update_shop_account'); ?>"
                                                           class="btn btn-azibai" <?php echo $act ?>/>
                                                    <input type="button" name="cancle_editshop"
                                                           value="<?php echo $this->lang->line('button_cancle_shop_account'); ?>"
                                                           onclick="ActionLink('<?php echo base_url(); ?>account/listbranch')"
                                                           class="btn btn-danger"/>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" name="isEditKho" id="isEditKho" value=""/>
                                </form>
                            <?php } else { ?>
                                <div class="text-center">
                                    <p class="text-center"><a href="<?php echo base_url(); ?>account/listbranch">Click vào đây để
                                            tiếp tục</a></p>
                                    Cập nhật thông tin kho của chi nhánh thành công!
                                </div>
                            <?php } ?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <script>

        $("#province_kho_shop").change(function () {
            if ($("#province_kho_shop").val()) {
                $.ajax({
                    url: siteUrl + 'home/showcart/getDistrict',
                    type: "POST",
                    data: {user_province_put: $("#province_kho_shop").val()},
                    cache: true,
                    success: function (response) {
                        if (response) {
                            var json = JSON.parse(response);
                            emptySelectBoxById('district_kho_shop', json, "");
                            delete json;
                        } else {
                            alert("Lỗi! Vui lòng thử lại");
                        }
                    },
                    error: function () {
                        alert("Lỗi! Vui lòng thử lại");
                    }
                });
            }
        });

        function Submit_Form() {
            jQuery("#isEditKho").val(1);
            $('.btn-azibai').attr('type','submit');
            //document.frmEditKho.submit();
        }

    </script>
    <!--END RIGHT-->
<?php $this->load->view('home/common/footer'); ?>