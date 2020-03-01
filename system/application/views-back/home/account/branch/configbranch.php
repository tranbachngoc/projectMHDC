<?php $this->load->view('home/common/account/header'); ?>
<div class="container-fluid">
    <div class="row">
        <?php $this->load->view('home/common/left'); ?>

        <!--BEGIN: RIGHT-->
        <div id="af_products" class="col-md-9 col-sm-8 col-xs-12">
            <h4 class="page-header" style="margin-top:10px">CẤU HÌNH CHI NHÁNH</h4>
            <div style="width:100%; overflow-y: auto;">
                <form name="frmEditBranRule" id="frmEditBranRule" method="post">                  
                    <?php if ($shopid > 0) { ?>
                        <?php if (isset($master_rule)) { ?>
                            <?php foreach ($master_rule as $key => $item) { ?>
                                <div class="form-group">
                                    <input type="checkbox" <?php if (isset($shop_rule) && in_array($item->id, $shop_rule)) { echo 'checked="checked"';
                                    } ?> value="<?php echo $item->id; ?>" name="shop_rule[]" id="shop_rule_<?php echo $item->id; ?>"> &nbsp;
                                    <label><?php echo $item->content; ?></label>
                                </div>
                            <?php } ?>
                            <div id="kho">
                                <div class="rows col-lg-12">
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                        <font color="#FF0000">*</font> Địa chỉ kho:
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                        <input type="text" name="address_kho_shop" id="address_kho_shop"
                                               class="selectprovince_formpost form-control" <?php echo $khaibaoKho ?>
                                               value="<?php if ($address_kho_shop != '') echo $address_kho_shop; ?>">
                                    </div>
                                </div>
                                <div class="rows col-lg-12">
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                        <font
                                            color="#FF0000">*</font> <?php echo $this->lang->line('province_shop_account'); ?>
                                        Kho:
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                        <select name="province_kho_shop" id="province_kho_shop"
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
                                <div class="rows col-lg-12">
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                        <font
                                            color="#FF0000">*</font> <?php echo $this->lang->line('district_account_label_edit_account'); ?>
                                        Kho:
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                        <select name="district_kho_shop" id="district_kho_shop"
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
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <input type="button" onclick="Submit_Form();" name="submit_editshoprule"
                                           value="Thực thi"
                                           class="btn btn-azibai"/>
                                    <input type="button" name="cancle_editshop"
                                           value="Hủy bỏ"
                                           onclick="ActionLink('<?php echo base_url(); ?>account/listbranch')"
                                           class="btn btn-default"/></td>
                                </div>
                            </div>

                            <input type="hidden" name="isEditBranRule" id="isEditBranRule" value=""/>
                            <input type="hidden" name="current_captcha" id="current_captcha"
                                   value="<?php echo $captcha; ?>"/>

                        <?php } else { ?>

                            <tr>
                                <td class="success_post" style="padding-top: 10px;">
                                    <p><?php echo $this->lang->line('success_edit_shop_account'); ?></p>
                                    <p class="text-center">
                                        <a href="<?php echo base_url(); ?>account/listbranch">Click vào đây để tiếp tục</a>
                                    </p>
                                </td>
                            </tr>

                        <?php } ?>
                    <?php } else { ?>
                        <tr>
                            <td>
                                <div class="noshop"><?php echo $this->lang->line('noshop'); ?> <a
                                        href="<?php echo base_url(); ?>account/shop">tại đây</a></div>
                            </td>
                        </tr>
                    <?php } ?>
                </form>
            </div>

        </div>
        <!--END: RIGHT-->
    </div>
</div>
<style>
.rows.col-lg-12 {
    margin-bottom: 10px;
}
</style>
<?php $this->load->view('home/common/footer'); ?>
<script type="text/javascript">
    $(document).ready(function () {
        if ($('input#shop_rule_51').is(':checked')) {
            $('#kho').fadeOut(0);
            $('#address_kho_shop').removeAttr('required');
            $('select').removeAttr('required');
        } else {
            $('#kho').fadeIn(400);
            $('#address_kho_shop').attr('required','required');
            $('select').attr('required','required');
        }
        $('input#shop_rule_51').change(function () {
            if ($(this).is(':checked')) {
                $('#kho').fadeOut(400);
                $('#address_kho_shop').removeAttr('required');
                $('select').removeAttr('required');
            }else{
                $('#kho').fadeIn(400);
                $('#address_kho_shop').attr('required','required');
                $('select').attr('required','required');
            }
        });
    });
    
    $("#province_kho_shop").change(function () {
        if ($("#province_kho_shop").val()) {
            $.ajax({
                url: '<?php echo base_url() ?>home/showcart/getDistrict',
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
        jQuery("#isEditBranRule").val(1);
        $('.btn-azibai').attr('type','submit');
    }
</script>
