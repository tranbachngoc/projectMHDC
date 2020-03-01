<?php $this->load->view('home/common/header'); ?>
<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>templates/home/css/daterangepicker.css" />
<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>templates/home/js/daterangepicker.js"></script>
<style>
    <?php
    if($this->uri->segment(4) == 2){
        ?>
        #h_province,#h_category{ display: none; }
    <?php
    }
    ?>
</style>
<script type="text/javascript">
    function setTextField(ddl) {
        document.getElementById('make_text').value = ddl.options[ddl.selectedIndex].text;
    }


    $(function() {

        $('input[name="daterange"]').daterangepicker({
            "minDate": "<?php echo date('m/d/Y');?>",
            autoUpdateInput: false,
            locale: {
                cancelLabel: 'Hủy',
                applyLabel: 'Xác nhận'
            },
            cancelClass:'btn-danger',
            alwaysShowCalendars:true,
            autoApply:false

        });
        $('input[name="daterange"]').on('apply.daterangepicker', function(ev, picker) {
            var row = $(this).parents('tr');
            $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
            row.find('input[name="date_range"]').val(picker.startDate.format('DD-MM-YYYY')+'_'+picker.endDate.format('DD-MM-YYYY'));
            getPrice(row);

        });

        $('input[name="daterange"]').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });
        $('input[name="daterange"]').val('');
    });


</script>

    <script type="text/javascript">
        $(document).ready(function(){
            $('#cat_id').on('change',function(){
                var catID = $(this).val();
                var url = '<?php echo $this->uri->segment(4);?>';
                if(catID){
                    $.ajax({
                        type:'POST',
                        url:'<?php echo base_url()?>home/account/get_position_advs',
                        data:{catid: catID, url: url},
                        success:function(html){
                            $('#position_adv').html(html);
                        }
                    });
                }else{
                    $('#position_adv').html('<option value="">Chọn vị trí</option>');
                }
            });

            <?php
            if($this->uri->segment(4) == 2){
            ?>
            var catID1 = 1;
            var url1 = '<?php echo $this->uri->segment(4);?>';
            if(catID1){
                $.ajax({
                    type:'POST',
                    url:'<?php echo base_url()?>home/account/get_position_advs',
                    data:{catid: catID1, url: url1},
                    success:function(html){
                        $('#position_adv').html(html);
                    }
                });
            }else{
                $('#position_adv').html('<option value="">Chọn vị trí</option>');
            }
            <?php
            }
            ?>
        });
    </script>

<div class="container-fluid">
    <div class="row">
        <?php $this->load->view('home/common/left'); ?>
        <div class="col-md-9 col-sm-8 col-xs-12">
            <h4 class="page-header" style="margin-top:10px">ĐẶT MUA QUẢNG CÁO</h4>
            <div id="panel_user_order" class="panel panel-default">
                
                <div class="panel-body">
                    <?php if($successAdd == false){ ?>
                    <form class="form-horizontal" name="frmAddAdvertise" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="title_adv" class="col-sm-2 control-label"><span style="color: #FF0000; "><b>*</b></span><?php echo $this->lang->line('title_title_add'); ?></label>
                            <div class="col-sm-10">
                                <input type="text" name="title_adv" id="title_adv" value="<?php echo $title_adv; ?>" maxlength="80" class="form-control" />
                                <?php echo form_error('title_adv'); ?>
                            </div>
                        </div>
                        <div class="form-group" id="h_province">
                            <label for="cat_id" class="col-sm-2 control-label">
                                <span  style="color: #FF0000; "><b>*</b></span> Tỉnh thành:</label>
                            <div class="col-sm-10">
                                <select name="province_shop" id="province_shop"
                                        class="selectprovince_formpost form-control">
                                    <option value="">Chọn Tỉnh/Thành</option>
                                    <?php foreach ($province as $provinceArray) { ?>
                                            <option  value="<?php echo $provinceArray->pre_id; ?>"><?php echo $provinceArray->pre_name; ?></option>
                                    <?php } ?>
                                </select>
                                <?php echo form_error('province_shop'); ?>
                             </div>
                        </div>
                        <div class="form-group" id="h_category">
                            <label for="cat_id" class="col-sm-2 control-label">
                                <span  style="color: #FF0000; "><b>*</b></span> Danh mục:</label>
                            <div class="col-sm-10">
                                <select name="cat_id" id="cat_id" class="form-control" >
                                    <option value="">--Chọn danh mục--</option>
                                    <?php //'.$item['cat_id'].''.$item['cat_name'].'
                                    foreach ($category as $item) {
                                        if($item->cate_type==0)
                                        $prefix = "Sản phẩm";
                                        if($item->cate_type==1)
                                            $prefix = "Dịch vụ";
                                        if($item->cate_type==2)
                                            $prefix = "Coupon";
                                        echo '<option value="'.$item->cat_id.'">'.$item->cat_name.' ('.$prefix.')</option>';
                                    }
                                    ?>
                                </select>
                                <?php echo form_error('cat_id'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="position_adv" class="col-sm-2 control-label"><span style="color: #FF0000; "><b>*</b></span> <?php echo $this->lang->line('position_add'); ?></label>
                            <div class="col-sm-10">
                                <select name="position_adv" id="position_adv" class="form-control" onchange="thong_bao_kich_thuoc_banner(this.value); setTextField(this)"  >
                                    <option value="">--Chọn danh mục trước--</option>
                                </select>
                                <?php echo form_error('position_adv'); ?>
                                <input id="make_text" type = "hidden" name = "make_text" value = "<?php echo $make_text; ?>" />
                                <div id="quydinhichtuocbanner" class="form_asterisk" style="font-weight:bold; color: #00a65a;  padding-top:10px; padding-bottom:10px; width:100%;"> </div>
                            </div>
                        </div>
                         <div class="form-group">
                            <label for="banner_adv" class="col-sm-2 control-label">
                                <span style="color: #FF0000; "><b>*</b></span> <?php echo $this->lang->line('banner_add'); ?>:</label>
                            <div class="col-sm-10">
                                <input type="file" name="banner_adv" id="banner_adv" value="" size="24" />
                                <?php echo form_error('banner_adv'); ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="link_adv" class="col-sm-2 control-label">
                                <span  style="color: #FF0000; "><b>*</b></span> <?php echo $this->lang->line('link_add'); ?>:</label>
                            <div class="col-sm-10">
                                <input type="text" name="link_adv" id="link_adv" maxlength="100" value="<?php echo $link_adv; ?>" class="form-control" onkeyup="BlockChar(this,'SpecialChar')" />
                                <?php echo form_error('link_adv'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name_adv" class="col-sm-2 control-label">
                               <span style="color: #FF0000; "><b>*</b></span> <?php echo $this->lang->line('advertiser_add'); ?>:</label>
                            <div class="col-sm-10">
                                <input type="text" name="name_adv" id="name_adv" <?php if (isset($shop->sho_name) && $shop->sho_name != '') {
                                    echo 'readonly =" readonly"';
                                } else {
                                    echo '';
                                } ?> value="<?php echo $shop->sho_name; ?>" maxlength="80" class="form-control" />
                                <?php echo form_error('name_adv'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="address_adv" class="col-sm-2 control-label">
                            <span style="color: #FF0000; "><b>*</b></span> <?php echo $this->lang->line('address_add'); ?>:
                            </label>
                            <div class="col-sm-10">
                                <input type="text" name="address_adv" <?php if (isset($shop->sho_address) && $shop->sho_address != '')  {
                                    echo 'readonly =" readonly"';
                                } else {
                                    echo '';
                                } ?> id="address_adv" value="<?php echo $shop->sho_address.', '.$district->DistrictName.', '.$district->ProvinceName; ?>" maxlength="80" class="form-control" onkeyup="BlockChar(this,'SpecialChar'); CapitalizeNames('frmAddAdvertise','address_adv');" onfocus="ChangeStyle('address_adv',1)" onblur="ChangeStyle('address_adv',2)" />
                                <?php echo form_error('address_adv'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="mobile_adv" class="col-sm-2 control-label">
                                 <span  style="color: #FF0000; "><b>*</b></span> Di động:
                            </label>
                            <div class="col-sm-4">
                                <input type="text" name="mobile_adv" id="mobile_adv" <?php if (isset($shop->sho_mobile) && $shop->sho_mobile != '') {
                                    echo 'readonly =" readonly"';
                                } else {
                                    echo '';
                                } ?> value="<?php echo $shop->sho_mobile; ?>" maxlength="20" class="form-control" />
                                <?php echo form_error('mobile_adv'); ?>
                            </div>
                            <label for="phone_adv" class="col-sm-2 control-label">
                             <?php echo $this->lang->line('phone_add'); ?>:
                            </label>
                            <div class="col-sm-4">
                                <input type="text" name="phone_adv" id="phone_adv" <?php if (isset($shop->sho_phone) && $shop->sho_phone != '') {
                                    echo 'readonly =" readonly"';
                                } else {
                                    echo '';
                                } ?> value="<?php echo $shop->sho_phone; ?>" maxlength="20" class="form-control" />
                                <?php echo form_error('phone_adv'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email_adv" class="col-sm-2 control-label">
                                <span style="color: #FF0000; "><b>*</b></span> <?php echo $this->lang->line('email_add'); ?>:
                            </label>
                            <div class="col-sm-10">
                                <input type="text" name="email_adv" id="email_adv" <?php echo (isset($userData->use_email )&& $userData->use_email != '') ? 'readonly =" readonly"' :'';  ?> value="<?php echo $userData->use_email; ?>" maxlength="50" class="form-control" onkeyup="BlockChar(this,'SpecialChar')" />
                                <?php echo form_error('email_adv'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="endday_adv" class="col-sm-2 control-label">
                                <font color="#FF0000"><b>*</b></font> Ngày bắt đầu:</label>
                            <div class="col-sm-2">
                                <select name="startday_adv" id="startday_adv" class="form-control">
                                    <?php for($endday = 1; $endday <= 31; $endday++){ ?>
                                        <?php if($endday_adv == $endday){ ?>
                                            <option value="<?php echo $endday; ?>" selected="selected"><?php echo $endday; ?></option>
                                        <?php }else{ ?>
                                            <option value="<?php echo $endday; ?>"><?php echo $endday; ?></option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <label for="startmonth_adv"></label><select name="startmonth_adv" id="startmonth_adv" class="form-control">
                                    <?php for($endmonth = 1; $endmonth <= 12; $endmonth++){ ?>
                                        <?php if($endmonth_adv == $endmonth){ ?>
                                            <option value="<?php echo $endmonth; ?>" selected="selected"><?php echo $endmonth; ?></option>
                                        <?php }elseif($endmonth == $nextMonth && $endmonth_adv == ''){ ?>
                                            <option value="<?php echo $endmonth; ?>" selected="selected"><?php echo $endmonth; ?></option>
                                        <?php }else{ ?>
                                            <option value="<?php echo $endmonth; ?>"><?php echo $endmonth; ?></option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <label for="startyear_adv"></label><select name="startyear_adv" id="startyear_adv" class="form-control">
                                    <?php for($endyear = (int)date('Y'); $endyear < (int)date('Y')+10; $endyear++){ ?>
                                        <?php if($endyear_adv == $endyear){ ?>
                                            <option value="<?php echo $endyear; ?>" selected="selected"><?php echo $endyear; ?></option>
                                        <?php }elseif($endyear == $nextYear && $endyear_adv == ''){ ?>
                                            <option value="<?php echo $endyear; ?>" selected="selected"><?php echo $endyear; ?></option>
                                        <?php }else{ ?>
                                            <option value="<?php echo $endyear; ?>"><?php echo $endyear; ?></option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                            </div>
                            <p class="text-warning"><i class="fa fa-info"></i> Ngày bắt đầu nhỏ hơn ngày kết thúc</p>
                        </div>
                        <div class="form-group">
                            <label for="endday_adv" class="col-sm-2 control-label">
                                <font color="#FF0000"><b>*</b></font> Ngày kết thúc:</label>
                            <div class="col-sm-2">
                                <select name="endday_adv" id="endday_adv" class="form-control">
                                    <?php for($endday = 1; $endday <= 31; $endday++){ ?>
                                        <?php if($endday_adv == $endday){ ?>
                                            <option value="<?php echo $endday; ?>" selected="selected"><?php echo $endday; ?></option>
                                        <?php }else{ ?>
                                            <option value="<?php echo $endday; ?>"><?php echo $endday; ?></option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-sm-2">
                                 <label for="endmonth_adv"></label><select name="endmonth_adv" id="endmonth_adv" class="form-control">
                                     <?php for($endmonth = 1; $endmonth <= 12; $endmonth++){ ?>
                                         <?php if($endmonth_adv == $endmonth){ ?>
                                             <option value="<?php echo $endmonth; ?>" selected="selected"><?php echo $endmonth; ?></option>
                                         <?php }elseif($endmonth == $nextMonth && $endmonth_adv == ''){ ?>
                                             <option value="<?php echo $endmonth; ?>" selected="selected"><?php echo $endmonth; ?></option>
                                         <?php }else{ ?>
                                             <option value="<?php echo $endmonth; ?>"><?php echo $endmonth; ?></option>
                                         <?php } ?>
                                     <?php } ?>
                                 </select>
                            </div>
                            <div class="col-sm-2">
                                 <label for="endyear_adv"></label><select name="endyear_adv" id="endyear_adv" class="form-control">
                                     <?php for($endyear = (int)date('Y'); $endyear < (int)date('Y')+10; $endyear++){ ?>
                                         <?php if($endyear_adv == $endyear){ ?>
                                             <option value="<?php echo $endyear; ?>" selected="selected"><?php echo $endyear; ?></option>
                                         <?php }elseif($endyear == $nextYear && $endyear_adv == ''){ ?>
                                             <option value="<?php echo $endyear; ?>" selected="selected"><?php echo $endyear; ?></option>
                                         <?php }else{ ?>
                                             <option value="<?php echo $endyear; ?>"><?php echo $endyear; ?></option>
                                         <?php } ?>
                                     <?php } ?>
                                 </select>
                            </div>

                            <p class="text-warning"><i class="fa fa-info"></i> Ngày phải lớn hơn ngày hiện tại</p>
                        </div>
                        <div class="form-group">
                            <label for="email_adv" class="col-sm-2 control-label">
                                <span style="color: #FF0000; "><b>*</b></span> Ngày bắt đầu <br>- Ngày kết thúc:
                            </label>
                            <div class="col-sm-10">
                                <input autocomplete="off" class="form-control input-sm" type="text" name="daterange" value="" placeholder="Chọn ngày..." readonly />&nbsp;<i class="fa fa-calendar"></i>

                                <input type="hidden" name="pack" value="<?php echo $sp['id'];?>" />
                                <input autocomplete="off" type="hidden" name="date_range" value="" />
                                <input autocomplete="off" type="hidden" name="price" value="" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="active_adv" class="col-sm-2 control-label">
                               Kích hoạt:
                            </label>
                            <div class="col-sm-10">
                                <div class="checkbox">
                                    <label>
                                        <input name="active_adv" id="active_adv" value="1"  <?php if($active_adv == '1'){echo 'checked="checked"';} ?> checked type="checkbox"> Kích hoạt
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-azibai">Xác nhận</button>
                            </div>
                        </div>
                    </form>
                    <?php }else{ ?>
                        <p class="text-center"> <?php echo $this->lang->line('success_add'); ?></p>
                        <p class="text-center"><a href="<?php echo base_url().'account/advs' ?>">Click vào đây để tiếp tục</a></p>

                    <?php } ?>
                </div>
            </div>
    </div>
    </div>
</div>
<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>templates/home/css/daterangepicker.css" />
<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>templates/home/js/moment.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>templates/home/js/moment-with-locales.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>templates/home/js/daterangepicker.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>templates/home/js/vi.js"></script>
<script type="text/javascript">
//    $(function() {
//        $('input[name="daterange"]').daterangepicker({
//            autoUpdateInput: false,
//            locale: {
//                cancelLabel: 'Hủy',
//                applyLabel: 'Xác nhận'
//            },
//            cancelClass:'btn-danger',
//            alwaysShowCalendars:true,
//            timePicker: true,
//            timePickerIncrement: 30,
//            showDropdowns: true,
//            autoApply:false
//        });
//
//        $('input[name="daterange"]').on('cancel.daterangepicker', function(ev, picker) {
//            $(this).val('');
//        });
//
//    });
</script>

<?php $this->load->view('admin/common/footer'); ?>
