<?php $this->load->view('home/common/account/header'); ?>
<div class="container">
    <div class="row">
        <?php $this->load->view('home/common/left');
        ?>
        <?php if ($shopid > 0 && $user_group != 2) { ?>
            <div class="col-md-9 col-sm-8 col-xs-12">
		<h4 class="page-header text-uppercase" style="margin-top:10px">
		    Dịch vụ
		</h4>


                <?php if(!empty($package_daily)):?>

                    <div>
                        <h3>Dịch vụ</h3>
                        <table class="table-bordered tb-service" width="100%" cellpadding="0" cellspacing="0">
                            <tr>
                                <td>STT</td>
                                <td>Dịch vụ</td>
                                <td>Khu vực</td>

                                <td>Chọn ngày</td>

                            </tr>
                            <?php foreach($package_daily as $k=>$sp):?>
                                <tr id="box_<?php echo $sp['id'];?>">
                                    <td><?php echo $k+1;?></td>
                                    <td>
                                        <?php echo $sp['p_name'];?>
                                    </td>
                                    <td>

                                        <?php switch($sp['p_type']){
                                            case '01':
                                            case '02':
                                                echo '<select name="position">';
                                                foreach($news_type as $key=>$val){
                                                    echo '<option value="'.$key.'">'.$val.'</option>';
                                                }
                                                echo '</select>';
                                                break;
                                            case '08':
                                            case '03':
                                                echo '<input type="hidden" name="position" value="000" />';
                                                break;

                                            default:
                                                echo '<select name="position">';
                                                foreach($position as $key=>$val){
                                                    echo '<option value="'.$key.'">'.$val.'</option>';
                                                }
                                                echo '</select>';
                                        }?>

                                    </td>
                                    <td class="price_collum" >

                                        <input autocomplete="off" class="form-control input-sm" type="text" name="daterange" value="" placeholder="Chọn ngày..." readonly />&nbsp;<i class="fa fa-calendar"></i>

                                        <input type="hidden" name="pack" value="<?php echo $sp['id'];?>" />
                                        <input autocomplete="off" type="hidden" name="date_range" value="" />
                                        <input autocomplete="off" type="hidden" name="price" value="" />
                                    </td>

                                </tr>
                            <?php endforeach;?>
                        </table>
                        <div>
                            Ghi chú: <br />
                            Toàn quốc: áp dụng toàn quốc <br />
                            Khu vực 1: áp dụng cho Hà Nội, Tp Hồ Chí Minh, Khánh Hòa, Phan Thiết, Phú Quốc, Đà Lạt, Hạ Long<br />
                            Khu vực 2: các tỉnh còn lại
                        </div>
                    </div>
                <?php endif;?>
                <!-- Modal -->
                <div class="modal fade" id="packageBox" tabindex="-1" role="dialog" aria-labelledby="basicModal"
                     aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myModalLabel">Đăng ký gói <b>name</b></h4>
                            </div>
                            <div class="modal-body">
                                <div class="alert lkvMessage">
                                    <strong>Success!</strong> Indicates a successful or positive action.
                                </div>
                                <p>Thời gian:</p>
                                <select onchange="updatePackagePrice();" name="periods" class="form-control" autocomplete="off">
                                    <?php foreach ($listPeriods as $period):
                                        if($period == 1) continue; ?>
                                        <option value="<?php echo $period ?>"><?php echo $period . ' tháng' ?></option>
                                    <?php endforeach; ?>
                                </select>

                                <p>Ngày bắt đầu:</p>
                                <input type="text" class="form-control" disabled="disabled" value="<?php echo $avai_date['begin_date'];?>" name="active_date" id="p_active_date" />
                                <p>Ngày kết thúc:</p>
                                <input type="text" class="form-control" disabled="disabled" value="<?php echo $avai_date['month_1'];?>" name="end_date" id="p_end_date" />
                                <p>Số tiền:<span id="p_amount"></span></p>
                                <?php if($avai_date['is_new'] == 0):?>
                                <label><input type="checkbox" name="goline" onchange="updatePackagePrice();" value="1" autocomplete="off">Ngày bắt đầu từ hôm nay</label>


                                <?php endif;?>
                                <input name="package" value="" type="hidden"/>
                                <input name="price" value="" type="hidden"/>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                                <button type="button" class="btn btn-primary packageBt"
                                        onclick="registerPackage(this);">Đăng ký
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="freeBox" tabindex="-1" role="dialog" aria-labelledby="basicModal"
                     aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myModalLabel">Thông báo</h4>
                            </div>
                            <div class="modal-body">
                                <div class="alert lkvMessage">

                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

<!-- Creates the bootstrap modal which password modal will appear -->
<div class="modal fade" id="pwd-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="z-index:999999">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Vui lòng nhập lại mật khẩu</h4>
      </div>
      <div class="modal-body" style="text-align: center;">
          <input class="form-control" type="password" name="pwd" id="pwd" value="" placeholder="Nhập lại mật khẩu" required="required" />
          <input type="hidden" value="" id="package_pwd" name="package_pwd" />
          <input type="hidden" value="" id="action_pwd" name="action_pwd" />
      </div>
      <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal" id="pwdcontinue">Tiếp tục</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
                function getPrice(row){
                    showLoading();
                    jQuery.ajax({
                        type: "POST",
                        url: siteUrl + "ajax/action/checkprice",
                        dataType: 'json',
                        data: row.find(':input').serialize(),
                        success: function (res) {

                            //hideLoading();
                            var html = '<div id="regisBox"><table class="table table-hover">';
                            var numday = 0;
                            html += '<thead>';
                            html += '<tr>';
                            html += '<th>';
                            html += 'Ngày';
                            html += '</th>';
                            html += '<th>';
                            html += 'Giá tiền';
                            html += '</th>';
                            html += '</tr>';
                            html += '</thead>';
                            for(var i = 0, len = res.dates.length; i< len; i++){
                                html += '<tr>';
                                html += '<td>';
                                html += res.dates[i].date;
                                html += '</td>';
                                html += '<td><span class="product_price">';
                                if( res.dates[i].error == false){
                                    html += res.dates[i].price_text;
                                    numday ++;
                                }else{
                                    html += res.dates[i].message;
                                }

                                html += '<input type="hidden" name=date['+i+'] value="'+res.dates[i].d+'" />';
                                html += '<input type="hidden" name=price['+i+'] value="'+res.dates[i].price+'" />';
                                html += '</span></td>';
                                html += '</tr>';
                            }
                            if(res.total > 0){
                                html += '<tr>';
                                html += '<td >';
                                html += 'Thời gian: '+numday+' ngày';
                                html += '</td>';
                                html += '<td ><span class="product_price">';
                                html += 'Số tiền: '+res.total_text;
                                html += '</span></td>';
                                html += '</tr>';

                                html += '<tr>';
                                html += '<td colspan="2" align="center">';
                                html += '<input type="button" onclick="pwdModal(\'\',\'regisBox\');" value="Đăng ký" class="btn btn-primary" id="package_1">';
                                html += '<input type="hidden"  value="'+res.pack_id+'" name="pack">';
                                html += '<input type="hidden"  value="'+res.total+'" name="total">';
                                html += '<input type="hidden"  value="'+res.position+'" name="position">';
                                html += '<input type="hidden"  value="<?php echo $pid;?>" name="pid">';
                                html += '</td>';

                                html += '</tr>';
                            }

                            html += '</table></div>';
                            console.log(html);
                            showMessageBox(html);
                            console.log('===================');

                        }
                    });
                }

                function pwdModal(id,action){
                    $("#pwd-modal").modal();
                    document.getElementById("package_pwd").value = "";
                    document.getElementById("package_pwd").value = id;

                    document.getElementById("action_pwd").value = "";
                    document.getElementById("action_pwd").value = action;

                    if(action == "regisBox"){
                        $("#regisBox").hide();
                    }

                }


                $(function() {
                    $('select[name="position"]').change(function(){
                        var row = $(this).parents('tr');
                        if(row.find('input[name="date_range"]').val() != ''){
                            getPrice(row);
                        }
                    })
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
                    //$('input[name="daterange"]').on('apply.daterangepicker', function(ev, picker) {
                        //$(this).val(picker.startDate.format('DD/MM/YYYY'));
                       /* var row = $(this).parents('tr');
                        showLoading();
                        jQuery.ajax({
                            type: "POST",
                            url: siteUrl + "ajax/action/checkprice",
                            dataType: 'json',
                            data: row.find(':input').serialize(),
                            success: function (res) {
                                hideLoading();
                                if(res.error == true){
                                    showMessage(res.message);
                                }else{
                                    row.find('input[name="price"]').val(res.price);
                                    row.find('input[name="price_text"]').val(res.price_text);

                                }

                            }
                        });*/

                        //console.log(picker.startDate.format('MM/DD/YYYY'));
                    //});
                    $('input[name="daterange"]').val('');

                    $("#pwdcontinue").on('click',function(){
                        var package_pwd     = $("#package_pwd").val();
                        var action_pwd      = $("#action_pwd").val();
                        jQuery.ajax({
                            type    : "POST",
                            url     : siteUrl + "ajax/action/checkpwd",
                            data    : { pwd: $("#pwd").val() },
                            success: function (data) {
                                var response = JSON.parse(data);
                                if(response['error'] == 1){
                                    if(action_pwd == "package_server"){
                                        package(package_pwd);
                                    }

                                    if(action_pwd == "one_day"){
                                        simplePackage(package_pwd);
                                    }

                                    if(action_pwd == "regisBox"){
                                        regisPack("regisBox");
                                    }

                                } else {
                                // = 0
                                    alert(response['msg']);return false;
                                }
                            }
                        })
                    });
                });
            </script>
            <style>
                .price_collum .form-control{ display: inline-block; width: auto;}
            </style>
        <?php } elseif($shopid > 0 && $user_group == 2) { ?>

        <div class="col-md-9 col-sm-8 col-xs-12">
		<h4 class="page-header text-uppercase" style="margin-top:10px">
		    Dịch vụ
		</h4>
            <div>

                <table class="table-bordered tb-service" width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>STT</td>
                        <td>Dịch vụ</td>

                        <td>Số kệ</td>
                        <td>Thời gian</td>
                        <td>Số tiền</td>
                        <td></td>
                    </tr>
                    <?php foreach($package_daily as $k=>$sp):?>
                        <tr id="box_<?php echo $sp['id'];?>">
                            <td><?php echo $k+1;?></td>
                            <td>
                                <?php echo $sp['p_name'];?>
                            </td>

                            <td>
                                <select name="p_shelf" class="form-control" onchange="updatePackPrice(<?php echo $sp['id'];?>);">
                                    <?php for($i = 1; $i<=15; $i++):?>
                                        <option value="<?php echo $i;?>"><?php echo $i;?></option>
                                    <?php endfor;?>
                                </select>
                            </td>
                            <td>
                                <select name="p_time" class="form-control" onchange="updatePackPrice(<?php echo $sp['id'];?>);">
                                    <?php foreach($package_time as $item):?>
                                        <option value="<?php echo $item['id'];?>"><?php echo $item['period'];?> <?php echo $item['unit_type'];?></option>
                                    <?php endforeach;?>
                                </select>
                            </td>
                            <td>

                                <span class="product_price"><?php echo lkvUtil::formatPrice($sp['price_min'], 'đ'); ?>
                            </td>
                            <td class="price_collum" >


                                <input type="hidden" name="pack" value="<?php echo $sp['id'];?>" />
                                <input autocomplete="off" type="hidden" name="price" value="" />

                                <input id="package_<?php echo $sp['info_id']; ?>" class="btn btn-primary"
                                       value="Đăng ký"
                                       onclick="regisPackShelf('<?php echo $sp['id']; ?>');" type="button"/>
                            </td>

                        </tr>
                    <?php endforeach;?>
                </table>
            </div>
        </div>
        <?php }else{?>
            <div class="noshop">
                <?php echo $this->lang->line('noshop'); ?> <a
                    href="<?php echo base_url(); ?>account/shop">tại đây</a></div>
        <?php } ?>
        <!--BEGIN: RIGHT-->
    </div>
</div>
<!--END RIGHT-->
<?php $this->load->view('home/common/footer'); ?>
