<?php $this->load->view('home/common/account/header'); ?>
<div class="container-fluid">
    <div class="row">
        <?php $this->load->view('home/common/left');           
            $periods = array(3, 6, 12);
            //By Bảo Trần sửa lại, bỏ gói 3 tháng giá 0vnđ        
            $listPeriods =  $periods;        
            //$period_new = array(6,12);
            $period_new = array(12);
            $listPeriods_new = $period_new;
            $dcs = $discountShop == 0 ? 1 : (1 - $discountShop / 100);
        ?>
        <div class="col-md-9 col-sm-8 col-xs-12">
            <h4 class="page-header text-uppercase" style="margin-top:10px">Dịch vụ Azibai</h4>
            
            <?php if ($shopid > 0 && $user_group != 2) { ?>


                    <!-- <div style="overflow: auto;">
                        <table class="table-bordered tb-service" width="100%" cellpadding="0" cellspacing="0">
                            <thead>
                            <tr>
                                <th width="15%">Tên&nbsp;</th>
                                <th width="20%">Giới hạn</th>
                                <?php foreach ($package as $pack): ?>
                                <th width="13%" class="p_<?php echo $pack['id']; ?>"><?php echo $pack['name']; ?></th>
                                <?php endforeach; ?>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($services as $service): ?>
                                <tr class="text-left">
                                    <td <?php echo (count($service['service']) > 1) ? 'rowspan="' . count($service['service']) . '"' : ''; ?> >
                                        <?php if ($service['content_id'] > 0): ?>
                                            <a href="<?php echo base_url() . 'content/' . $service['content_id'] ?>">
                                                <b><?php echo $service['name']; ?></b>
                                            </a>
                                        <?php else: ?>
                                            <b><?php echo $service['name']; ?></b>
                                        <?php endif; ?>

                                    </td>
                                    <?php $firstRow = array_shift($service['service']);
                                    ?>
                                    <td><?php $text = $firstRow['limit'] == -1 ? 'Không giới hạn' : $firstRow['limit'];
                                        echo $text . ' ' . $firstRow['unit'];
                                        ?>
                                    </td>
                                    <?php foreach ($package as $pack): ?>
                                    <td class="text-center">
                                        <?php echo (in_array($pack['id'], $firstRow['packageList'])) ? '<i class="fa fa-check text-success"></i>' : ''; ?>
                                    </td>
                                    <?php endforeach; ?>
                                </tr>
                                <?php foreach ($service['service'] as $sItem): ?>
                                <tr>
                                    <td><?php $text = $sItem['limit'] == -1 ? 'Không giới hạn' : $sItem['limit']. ' ' . $sItem['unit'];
                                            echo $text ;
                                            ?>
                                    </td>
                                    <?php foreach ($package as $pack): ?>
                                        <td class="text-center">
                                            <?php echo (in_array($pack['id'], $sItem['packageList'])) ? '<i class="fa fa-check text-success"></i>' : ''; ?>
                                        </td>
                                    <?php endforeach; ?>
                                </tr>
                                <?php endforeach; ?>
                            <?php endforeach; ?>
                            <!-- Bang gia -->
                            <!-- <tr>
                                <td rowspan="4"><b>Bảng giá</b></td>
                                <?php
                                //by BaoTran, get % to discount for SHOP 
                                $firstPeriod = array_shift($periods);
                                ?>
                                <td ><?php echo $firstPeriod . ' tháng' ?></td>
                                <?php foreach ($package as $pack): ?>
                                    <td id="<?php echo $pack['id'].'_'.$firstPeriod;?>" align="right" style="padding-right:3px;">
                                    <?php if($pack['id'] != 1): ?>
                                        <span class="product_price">
                                        <?php foreach ($prices as $pkPrice) {
                                            if ($pkPrice['period'] == $firstPeriod && $pack['id'] == $pkPrice['info_id']) {
                                                $discountRate = $pkPrice['discount_rate'] > 0 ? (1 - $pkPrice['discount_rate'] / 100) : 1;     
                                                echo number_format($pkPrice['month_price'] * $pkPrice['period'] * $discountRate * $dcs, 0, ',', '.');
                                            }
                                        } ?>

                                        </span>
                                    <?php endif; ?>
                                    </td>
                                <?php endforeach; ?>
                            </tr>
                            <?php foreach ($periods as $period): ?>
                                <tr >
                                    <td><?php echo $period . ' tháng' ?></td>
                                    <?php foreach ($package as $pack): ?>
                                        <td align="right" id="<?php echo $pack['id'].'_'.$period;?>" style="padding-right:3px;">

                                        <?php if($pack['id'] != 1): ?>
                                            <span class="product_price">
                                            <?php foreach ($prices as $pkPrice) {
                                                if ($pkPrice['period'] == $period && $pack['id'] == $pkPrice['info_id']) {
                                                    $discountRate = $pkPrice['discount_rate'] > 0 ? (1 - $pkPrice['discount_rate'] / 100) : 1;
                                                    echo number_format($pkPrice['month_price'] * $pkPrice['period'] * $discountRate * $dcs, 0, ',', '.');
                                                }
                                            } ?>
                                                đ
                                            </span>
                                        </td>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </tr>
                            <?php endforeach; ?>
                            <!-- Ket thuc bang gia -->
                            <!-- Dang ky -->
                            <!-- <tr>
                                <td>&nbsp;</td>
                                <!-- <td>&nbsp;</td> -->
                                <!-- <?php foreach ($package as $pack): ?>
                                    <td>
                                        <?php if ($pack['id'] > 1 || ($free_exist == 0 && $pack['id'] == 2)): ?>
                                            <input id="package_<?php echo $pack['id']; ?>" class="btn btn-primary"
                                                   value="Đăng ký" type="button" onclick="pwdModal(<?php echo $pack['id']; ?>,'package_server')"/>

                                        <?php endif; ?>
                                    </td>
                                <?php endforeach; ?>
                            </tr>
                            </tbody>
                            <!-- Ket thuc dang ky -->
                        <!-- </table>
                        </div>
                        -->                

                    <!-- View Service Grid -->
                    <div class="row pricebox">
                    <?php foreach ($package as $key => $pack) { if($key > 0 & $key % 2 == 0) echo '</div><div class="row pricebox">';?> 
                        <div class="col-xs-12 col-sm-6 col-md-6" style="margin-bottom: 30px">    
                            <div class="panel panel-azibai" style="height:100%">
                            <div class="panel-heading">
                                <h3 class="text-center p_<?php echo $pack['id']; ?>"><?php echo $pack['name']; ?></h3>
                            </div>
                            <div class="panel-body" style="padding-bottom:55px">
                                <div class="pricearea text-center">
                                    <?php if($pack['id'] == 1) { ?>
                                    <span class="pricevalue" style="font-size: 36px; color: red"><?php echo 'Miễn Phí'; ?></span>                               
                                    <span class="priceunit"></span>
                                    <?php } else { ?>
                                    <span class="pricevalue " id="price_on_month_<?php echo $pack['id']; ?>" style="font-size: 36px; color: red"></span>
                                    <span class="priceunit">VNĐ/THÁNG</span>
                                    <?php } ?>
                                </div>
                                <?php 
                                    $list_pack = array();
                                    switch ($pack['id']) {
                                        case 1:
                                            $list_pack = $ser_list_1;
                                            break;
                                        case 2:
                                            $list_pack = $ser_list_2;
                                            break;
                                        case 3:
                                            $list_pack = $ser_list_3;
                                            break;
                                        case 4:
                                            $list_pack = $ser_list_4;
                                            break;
                                        default:
                                            $list_pack = $ser_list_7;
                                            break;
                                    }
                                 ?>
                                <?php foreach ($list_pack as $klp => $lpitem) { ?> 
                                <div class="row" style="border-bottom:1px solid #eee;">            
                                    <div class="col-xs-8">
                                        <p><?php echo $lpitem['name']; ?></p>
                                    </div>
                                    <div class="col-xs-4 text-right text-primary"> 
                                        <p>
                                            <?php foreach ($ser_pack as $ksp => $spitem) { 
                                                $text = $spitem['limit'] == -1 ? 'Không giới hạn' : $spitem['limit'];
                                                $text = $spitem['limit'] == -2 ? '' : $text;
                                                if($spitem['id'] == $lpitem['service_id']){
                                                    echo $text .' '. $spitem['unit'] ;
                                                }
                                            } ?>
                                        </p> 
                                    </div>               
                                </div>
                                <?php } ?>
                                <div class="gia-chiec-khau ">
                                    <ul class="">
                                        <?php if( $pack['id'] != 1) { ?>   
                                        <?php foreach ($period_new as $period) { ?>
                                            <li><p><?php echo $period.' tháng - '; ?>
                                            <span class="product_price" id="<?php echo $pack['id'].'_'.$period; ?>">
                                            <?php foreach ($prices as $pkPrice) {
                                                if ($pkPrice['period'] == $period && $pack['id'] == $pkPrice['info_id']) {
                                                    $discountRate = $pkPrice['discount_rate'] > 0 ? (1 - $pkPrice['discount_rate'] / 100) : 1;
                                                    echo number_format($pkPrice['month_price'] * $pkPrice['period'] * $discountRate * $dcs, 0, ',', '.') . ' VNĐ';
                                                    echo '<input type="hidden" id="price_'.$pack["id"].'_'.$period.'" value="'.$pkPrice["month_price"] * $pkPrice["period"] * $discountRate * $dcs.'" />';
                                                }
                                            } ?>
                                            </span></p></li>
                                        <?php } ?>
                                        <?php } else { ?>
                                            <li><p><span> Miễn phí 3 tháng</span></p></li>
                                        <?php } ?>                                      
                                    </ul>
                                </div>
                            </div>
                            <div class="panel-footer text-center" style="position: absolute; bottom:1px; left: 16px; right: 16px;">
                                <input id="package_<?php echo $pack['id'] ?>" class="btn btn-lg btn-azibai" value="Đặt mua" onclick="pwdModal(<?php echo $pack['id']; ?>,'package_server');" type="button" style="padding-left: 60px; padding-right: 60px;">                           
                            </div>
                        </div>
                        </div>
                    <?php } ?>
                    </div>            
                    <!-- End :: View service grid -->

                    <!-- Thông báo được giản giá -->
                    <?php if($discountShop > 0){ ?>
                    <div class="message success">
                        <div class="alert alert-success">
                            <i class="fa fa-info-circle" aria-hidden="true"></i> Gian hàng của bạn được ưu đãi đặc biệt <b><?php echo $discountShop; ?>%</b> từ tất cả các gói dịch vụ của Azibai. (Đã chiết khấu vào bảng giá trên)                   
                            <!-- <button type="button" class="close" data-dismiss="alert">×</button> -->
                        </div>
                    </div>
                    <?php } ?>
                    <!-- Kết thúc thông báo được giản giá -->

                    <!--Dịch vụ đăng kí 1 lần-->
                    <?php if (!empty($simplePackage)): ?>
                        <div>
                            <h3>Dịch vụ khác</h3>
                            <div class="table-responsive">
                            <table class="table table-bordered tb-service" width="100%" cellpadding="0" cellspacing="0">
                                <thead>
                                    <tr>
                                        <td>STT</td>
                                        <td>Dịch vụ</td>
                                        <td>Số lượng (đơn vị)</td>
                                        <td>Đơn giá</td>
                                        <td>Thời hạn (tháng)</td>
                                        <td>Đăng ký</td>                                
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach($simplePackage as $k => $sp): ?>
                                    <tr>
                                        <td><?php echo $k+1;?></td>
                                        <td>
                                            <?php if ($sp['content_id'] > 0): ?>
                                                <a href="<?php echo base_url() . 'content/' . $sp['content_id']; ?>">
                                                    <b class="name_<?php echo $sp['info_id']; ?>"><?php echo $sp['name']; ?></b>
                                                </a>
                                            <?php else: ?>
                                                <b class="name_<?php echo $sp['info_id']; ?>"><?php echo $sp['name']; ?></b>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo $sp['limits']." (".$sp['units'].")"; ?></td>
                                        <td>
                                        <span class="product_price"><?php       
                                        echo number_format($sp['month_price'] * $dcs, 0, ',', '.');?> đ</span>
                                        </td>
                                        <td><?php echo $sp['ordering'] == 0 ? 'Không giới hạn' : $sp['ordering']; ?>
                                        </td>
                                        <td><input id="package_<?php echo $sp['info_id']; ?>" class="btn btn-primary" value="Đăng ký" onclick="pwdModal('<?php echo $sp['info_id']; ?>','one_day');" type="button"/></td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                            </div>
                        </div>
                    <?php endif; ?>
                    <!-- END:: Dịch vụ đăng kí 1 lần-->

                    <?php if(!empty($package_daily)):?>
                        <div>
                            <h3>Dịch vụ đăng sản phẩm</h3>
                            <div class="table-responsive">
                            <table class="table table-bordered tb-service" width="100%" cellpadding="0" cellspacing="0">
                                <thead>   
                                <tr>
                                    <td>STT</td>
                                    <td>Dịch vụ</td>
                                    <td>Khu vực</td>
                                    <td>Chọn ngày</td>
                                </tr>
                                </thead> 
                                <tbody>
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
                                </tbody>
                            </table>
                            </div>
                            <div class="note">
                                 <h3>Ghi chú</h3>
                                <div><em class="text-primary">Toàn quốc:</em> áp dụng toàn quốc <br />
                                <em class="text-primary">Khu vực 1:</em> áp dụng cho Hà Nội, Tp Hồ Chí Minh, Khánh Hòa, Phan Thiết, Phú Quốc, Đà Lạt, Hạ Long<br />
                                <em class="text-primary">Khu vực 2:</em> các tỉnh còn lại</div>
                            </div><br />
                        </div>
                    <?php endif; ?>

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
                                        <?php foreach ($listPeriods_new as $lper):
                                            if($lper == 1) continue; ?>
                                            <option value="<?php echo $lper; ?>"><?php echo $lper . ' tháng'; ?></option>
                                        <?php endforeach; ?>
                                    </select>

                                    <p>Ngày bắt đầu:</p>
                                    <input type="text" class="form-control" disabled="disabled" value="<?php echo $avai_date['begin_date'];?>" name="active_date" id="p_active_date" />
                                    <p>Ngày kết thúc:</p>
                                    <input type="text" class="form-control" disabled="disabled" value="<?php echo $avai_date['month_1'];?>" name="end_date" id="p_end_date" />
                                    <p>Số tiền:<span id="p_amount"></span></p>
                                    <?php if($avai_date['is_new'] == 0):?>
                                    <label><input type="checkbox" name="goline" style="hidden" onchange="updatePackagePrice();" value="1" autocomplete="off">Ngày bắt đầu từ hôm nay</label>

                                    <?php endif; ?>
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

                    <!-- MODAL FOR SERVICE OPEN BRANCH -->
                    <div class="modal fade" id="packageBran" tabindex="-1" role="dialog" aria-labelledby="basicModal"
                         aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="myModalLabel">Đăng ký gói <b>name</b></h4>
                                </div>
                                <div class="modal-body">
                                    <div class="alert lkvMessage">     
                                    </div>                                
                                    <p>Số chi nhánh cần mở:</p>
                                    <input type="text" class="form-control" name="numbran" id="numbran" onchange="updatePrice()" value="" placeholder="" /> 
                                    <p>Tổng tiền:<span style="color: red">
                                        <input width="auto" id="bran_amount" name="bran_amount" readonly="readonly" value="" style="border: none;" />​
                                    </span></p>
                                    <input name="package" id="package" value="" type="hidden"/>
                                    <input name="price" id="price" value="" type="hidden"/>
                                    <input name="periods" value="" type="hidden"/>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                                    <button type="button" class="btn btn-primary packageBt"
                                            onclick="registerPackageBran(this);">Đăng ký
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- MODAL FOR SERVICE OPEN BRANCH -->

                    <!-- BEGIN:: MODAL FOR SERVICE OPEN CTV -->
                    <div class="modal fade" id="packageCTV" tabindex="-1" role="dialog" aria-labelledby="basicModal"
                         aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="myModalLabel">Đăng ký gói <b>name</b></h4>
                                </div>
                                <div class="modal-body">
                                    <div class="alert lkvMessage">     
                                    </div>                                
                                    <p>Số gói CTV Online cần mở: <i style="color:red;">(Lưu ý: 1 Gói tương đương 500 CTV)</i></p>
                                    <input type="text" class="form-control" name="num_ctv" id="num_ctv" onchange="updatePriceCTV()" value="" placeholder="" /> 
                                    <p>Tổng tiền:<span style="color: red">
                                        <input width="auto" id="ctv_amount" name="ctv_amount" readonly="readonly" value="" style="border: none;" />​
                                    </span></p>
                                    <input name="package" id="package" value="" type="hidden"/>
                                    <input name="price" id="price_ctv" value="" type="hidden"/>
                                    <input name="periods" value="" type="hidden"/>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                                    <button type="button" class="btn btn-primary packageBt"
                                            onclick="registerPackageCTV(this);">Đăng ký
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END:: MODAL FOR SERVICE OPEN CTV -->

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
                                    html += '</td>';

                                    html += '</tr>';
                                }

                                html += '</table></div>';
                                showMessageBox(html);

                            }
                        });
                    }

                    function pwdModal(id,action){
                        //DV dành cho GH, đang dùng Gói Proffessional
                        if(id == 16 || id == 17){
                            jQuery.ajax({
                                type    : "POST",
                                url     : siteUrl + "home/account/CheckCurrentMyServices",
                                data    : { pack_id : id},
                                success: function (data_res2) {                                 
                                    if(data_res2 == '1'){
                                        $("#pwd-modal").modal();
                                        document.getElementById("package_pwd").value = "";
                                        document.getElementById("package_pwd").value = id;
                                        document.getElementById("action_pwd").value = "";
                                        document.getElementById("action_pwd").value = action;
                                    }else{
                                        if(id == 16){
                                            alert('Gói dịch vụ này chỉ dành cho Gian hàng đã sử dụng gói Business hoặc Proffessional.'); 
                                        }

                                        if(id == 17){
                                            alert('Gói dịch vụ này chỉ dành cho Gian hàng đã sử dụng gói Proffessional.'); 
                                        }                                    

                                        return false;
                                    }
                                }
                            });
                        } else {
                            $("#pwd-modal").modal();
                            document.getElementById("package_pwd").value = "";
                            document.getElementById("package_pwd").value = id;

                            document.getElementById("action_pwd").value = "";
                            document.getElementById("action_pwd").value = action;
                        }

                        if(action == "regisBox"){
                            $("#regisBox").hide();
                        }   
                    }               

                    function updatePrice(){                   
                        var no = $("#numbran").val();
                        var price = $("#price").val();
                        if(no > 0){                        
                            var money = no*price;
                            money = money.toLocaleString();
                            $('#bran_amount').val(money+' đ');
                        }else{                       
                            var frModal = $('#packageBran');
                            var pack = frModal.find('input[name="package"]').val();
                            jQuery.ajax({
                                type    : "POST",
                                url     : siteUrl + "ajax/action/getpricebran",
                                data    : { package: pack },
                                success: function (data_res) {
                                    var response = JSON.parse(data_res);
                                    if(response['price'] > 0){
                                        frModal.find('input[name="price"]').val(response['price']);
                                    }else{                                
                                        alert('Có lỗi xảy ra!'); 
                                        return false;
                                    }
                                }
                            });                             
                        }
                    }

                    function updatePriceCTV(){                   
                        var no = $("#num_ctv").val();
                        var price = $("#price_ctv").val();
                        if(no > 0){                        
                            var money = no*price;                        
                            money = money.toLocaleString();                        
                            $('#ctv_amount').val(money+' đ');
                        }else{                       
                            var frModal = $('#packageCTV');
                            var pack = frModal.find('input[name="package"]').val();
                            jQuery.ajax({
                                type    : "POST",
                                url     : siteUrl + "ajax/action/getpricectv",
                                data    : { package: pack },
                                success: function (data_res1) {
                                    var response = JSON.parse(data_res1);
                                    if(response['price'] > 0){
                                        frModal.find('input[name="price"]').val(response['price']);
                                    }else{                                
                                        alert('Có lỗi xảy ra!'); 
                                        return false;
                                    }
                                }
                            });                             
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
                                    }else{
                                    // = 0
                                        alert(response['msg']); 
                                        return false;
                                    }
                                }
                            });
                        });

                        $('#packageBran').on('show.bs.modal', function (){
                            updatePrice();
                        });

                        $('#packageCTV').on('show.bs.modal', function (){
                            updatePriceCTV();
                        });                     

                        for(var i = 1; i <= 7; i++){                        
                            var get_price = $('#price_' + i + '_12').val();
                            if(get_price){
                                var price_month = (get_price / 12).toLocaleString();
                                $('#price_on_month_'+ i).text(price_month);
                            }                        
                        }                   

                    });
                </script>
                <style>
                    .price_collum .form-control{ display: inline-block; width: auto;}
                </style>
            <?php } elseif ($shopid > 0 && $user_group == 2) { ?>
                <?php /*
                 <script type="text/javascript">
                    function updatePackPrice(id){
                        var packinfo = <?php echo json_encode($package_time); ?>;
                        var box = $('#box_'+id);
                        var p_time = box.find('select[name="p_time"]').val();
                        var p_shelf = box.find('select[name="p_shelf"]').val();

                        for(var i = 0; i < packinfo.length; i++){
                            if(packinfo[i].id == p_time){
                                var total = parseInt(packinfo[i].month_price, 10) * parseInt(packinfo[i].period, 10) * parseInt(p_shelf, 10);
                                if(packinfo[i].discount_rate > 0){
                                    total = (100 - parseInt(packinfo[i].discount_rate, 10)) * total /100;
                                }
                                box.find('.product_price').text(total);
                            }
                        }
                    }
                    $(document).ready(function(){
                        updatePackPrice(10);
                    });
                </script> 
            <div class="col-lg-9 col-md-9 col-sm-8">
                <div>
                    <h3>Dịch vụ</h3>
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
                        <?php endforeach; ?>
                    </table>
                </div>
            </div> --> */?>
                <div><p>Hiện không có dịch vụ nào dành cho CTV online!</p></div>
            <?php } else { ?>
                <div class="noshop">
                    <?php echo $this->lang->line('noshop'); ?> <a href="<?php echo base_url(); ?>account/shop">tại đây</a>
                </div>
            <?php } ?>
        </div>
        <!--BEGIN: RIGHT-->
    </div>
</div>
<!--END RIGHT-->
<?php $this->load->view('home/common/footer'); ?>
