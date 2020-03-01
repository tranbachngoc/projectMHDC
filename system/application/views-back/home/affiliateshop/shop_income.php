<?php // $this->load->view('home/common/account/header'); ?>
<!-- <div class="container-fluid">
    <div class="row">
	<?php // $this->load->view('home/common/left'); ?>
	<div class="col-md-9 col-sm-8 col-xs-12">
		<h4 class="page-header text-uppercase" style="margin-top:10px">
			Thu nhập thực
		</h4>
		<div class="none_record">
		   <p class="text-center">Đang cập nhật dữ liệu</p>
		</div>
	</div>
</div> -->
<?php // $this->load->view('home/common/footer'); ?>







<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2/1/2016
 * Time: 5:28 AM
 */
$group_id = (int) $this->session->userdata('sessionGroup');
?>
<?php $this->load->view('home/common/account/header'); ?>
<div class="container-fluid">
    <div class="row">
        <?php $this->load->view('home/common/left'); ?>
        <!--BEGIN: RIGHT-->
        <div class="col-md-9 col-sm-8 col-xs-12">
            <h4 class="page-header text-uppercase" style="margin-top:10px">                
				Thu nhập thực
            </h4>

            <script type="text/javascript">
                function makeCaution(id, item) {
                    if ($(item).hasClass('processing')) {
                        return;
                    }
                    var r = confirm("Bạn chưa nhận được tiền chuyển khoản và muốn Admin hỗ trợ?");
                    if (r == true) {
                        $(item).addClass('processing');
                        jQuery.ajax({
                            type: "POST",
                            url: '<?php echo base_url(); ?>' + "ajax/update-payment",
                            dataType: 'json',
                            data: {id: id, status: 3},
                            success: function (res) {
                                $(item).removeClass('processing');
                                if (res.error == false) {
                                    $('#row_' + id).find('.rowAction').html('Ðã cập nhật.');
                                    $('#row_' + id).find('.rowStatus').html('Khiếu nại.');

                                    //$('#row_'+id).remove();
                                    alert('Đã tạo khiếu nại');
                                } else {
                                    alert(res.message);
                                }

                            }
                        });
                    } else {
                        $(item).removeClass('processing');
                    }



                }
                function makeComplete(id, item) {

                    if ($(item).hasClass('processing')) {
                        return;
                    }
                    var r = confirm("Bạn đã nhận được tiền chuyển khoản?");
                    if (r == true) {
                        $(item).addClass('processing');
                        jQuery.ajax({
                            type: "POST",
                            url: '<?php echo base_url(); ?>' + "ajax/update-payment",
                            dataType: 'json',
                            data: {id: id, status: 4},
                            success: function (res) {
                                $(item).removeClass('processing');
                                if (res.error == false) {
                                    $('#row_' + id).find('.rowAction').html('Ðã cập nhật.');
                                    $('#row_' + id).find('.rowStatus').html('Hoàn tất chuyển khoản.');

                                    //$('#row_'+id).remove();
                                    alert('Đã cập nhật');
                                } else {
                                    alert(res.message);
                                }

                            }
                        });
                    } else {
                        $(item).removeClass('processing');
                    }
                }
            </script>




            <div class="panel panel-default panel-custom">
                <div class="panel-body">
                    <form name="frmAccountPro" action="<?php echo base_url() . 'account/affiliate/shop_income'; ?>" method="post" >
                        <div class="row">
                            
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Tình trạng:</label>
                                    <select name="status" autocomplete="off" class="form-control">
                                        <?php foreach ($status as $key => $val): ?>
                                            <option value="<?php echo $key; ?>" <?php
                                            if ($filter['status'] == $key) {
                                                echo 'selected="selected"';
                                            }
                                            ?>><?php echo $val; ?></option>
                                                <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-2 col-xs-6">
                                <div class="form-group">
                                    <label>Tháng:</label>
                                    <select class="form-control" name="month" autocomplete="off">
                                        <?php
                                        for ($i = 1; $i <= 12; $i++):
                                            if ($i < 10) {
                                                $i = '0' . $i;
                                            }
                                            ?>
                                            <option <?php echo $filter['month'] == $i ? 'selected="selected"' : ''; ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-2 col-xs-6">    
                                <div class="form-group">
                                    <label>Năm:</label>
                                    <select class="form-control" name="year" autocomplete="off">
                                        <?php
                                        for ($i = 2016; $i <= 2025; $i++):
                                            if ($i < 10) {
                                                $i = '0' . $i;
                                            }
                                            ?>
                                            <option <?php echo $filter['year'] == $i ? 'selected="selected"' : ''; ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                        <?php endfor; ?>
                                    </select>                        
                                </div>
                            </div>
                            <div class="col-sm-2 col-xs-12">
                                <div class="form-group">
                                    <label class="hidden-xs">&nbsp;</label>
                                    <button type="submit" class="btn btn-azibai btn-block">Tìm kiếm</button>
                                </div>
                            </div>
                        </div>
                        <!--<button type="submit" class="sButton"></button>-->
                        <input type="hidden" name="dir" value="<?php echo $filter['dir']; ?>"/>
                        <input type="hidden" name="sort" value="<?php echo $filter['sort']; ?>"/>
                    </form>
                </div>
            </div>

            <p>Số dư tài khoản: <b class="red_money"><?php echo number_format($user['havingAmount'], 0, ",", ".") . ' đ'; ?></b></p>
            <p>Azibai đang lên lịch chuyển: <b class="red_money"><?php echo number_format(abs($user['bankingAmount']), 0, ",", ".") . ' đ'; ?></b></p>
             

            <?php if (count($accounts) > 0) { ?>
            <div class="table-responsive">   
                <table class="table table-bordered afBox" style="min-width:600px">
                    <tr>
                        <th width="40" class="aligncenter hidden-xs">STT</th>
                        
                        <?php if ($filter['status'] == 0): ?>
                            <th class="text-center">Loại hoa hồng</th>
                        <?php endif; ?>

                        <th class="text-center">Số tiền<br />
                            <a href="<?php echo $sort['amount']['asc']; ?>">
                                <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" border="0"
                                     style="cursor:pointer;" alt=""/>
                            </a>
                            <a href="<?php echo $sort['amount']['desc']; ?>">
                                <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" border="0"
                                     style="cursor:pointer;" alt=""/>
                            </a>
                        </th>
                        <th class="text-center">Ngày tạo<br />
                            <a href="<?php echo $sort['created_date']['asc']; ?>">
                                <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" border="0"
                                     style="cursor:pointer;" alt=""/>
                            </a>
                            <a href="<?php echo $sort['created_date']['desc']; ?>">
                                <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" border="0"
                                     style="cursor:pointer;" alt=""/>
                        </th>
                        <th class="text-center ">Trạng thái
                        </th>
                        <?php if ($filter['status'] == 2): ?>
                            <th class="text-center ">

                            </th>
                        <?php endif; ?>
                        <th class="text-center ">
                            Chi tiết
                        </th>

                    </tr>

                    <?php foreach ($accounts as $k => $item): ?>                    
                        <!-- Modal -->
                        <tr id="row_<?php echo $item['id']; ?>">
                            <td class="hidden-xs"><?php echo $num + $k + 1; ?></td>
                            <?php if ($filter['status'] == 0): ?>
                                <td align="left" >
                                    <?php echo $item['description']; ?>
                                    <?php
                                    /* foreach($ctypes as $val){
                                      if($val['id'] == $item['type']){
                                      echo $val['text'];
                                      break;
                                      }
                                      } */
                                    ?>
                                </td>
                            <?php endif; ?>
                            <td>
                                <span
                                    class="product_price"><?php echo number_format(abs($item['amount']), 0, ",", ".") . ' đ'; ?></span>
                            </td>
                            <td >
                                <?php echo $item['created_date']; ?>
                            </td>
                            <td class="rowStatus"><?php
                                foreach ($status as $key => $val) {
                                    if ($key == $item['status']) {
                                        echo $val;
                                        break;
                                    }
                                }
                                ?>
                            </td>
                            <?php if ($filter['status'] == 2): ?>
                                <td class="rowAction">

                                    <button onclick="makeCaution(<?php echo $item['id']; ?>, this)" title="Khiếu nại" type="button" class="btn btn-warning" data-toggle="modal" >
                                        <i class="fa fa-support"></i>
                                    </button>
                                    <button onclick="makeComplete(<?php echo $item['id']; ?>, this)" title="Hoàn tất chuyển khoản" type="button" class="btn btn-success" data-toggle="modal" >
                                        <i class="fa fa-cubes"></i>
                                    </button>

                                </td>
                            <?php endif; ?>
                            <td>
                                <?php
                                $type = '';
                                if ($item['description'] == 'Hoa hồng bán Giải pháp cá nhân' || $item['description'] == 'Tiền Hoa hồng bán Giải pháp cá nhân') {
                                    $type = '?personal=1';
                                } else {
                                    $type = '';
                                }

                                if ($item['type'] != '06' && $item['type'] != '07') {

                                    if ($commissionList[$item['id']]->empty_position > 0) {
                                        ?>
                                        <a href="<?php echo base_url(); ?>account/detail/commission-position-empty/<?php echo $commissionList[$item['id']]->id; ?>">
                                            <button type="button" class="btn btn-default1" data-toggle="modal" >
                                                <i class="fa fa-newspaper-o"></i>
                                            </button>
                                        </a>
                                    <?php } else { ?>
                                        <?php if ($item['type'] == '05') { ?>
                                            <?php
                                            $type = '';
                                            if ($commissionList[$item['id']]->description == 'Hoa hồng Bán lẻ cá nhân') {
                                                $type = '?personal=1';
                                            } else {
                                                $type = '';
                                            }
                                            ?>
                                            <a href="<?php echo base_url(); ?>account/detail/commission/retail/<?php echo $commissionList[$item['id']]->id . $type; ?>">
                                                <button type="button" class="btn btn-default1" data-toggle="modal" >
                                                    <i class="fa fa-newspaper-o"></i>
                                                </button>
                                            </a>
                                            <?php
                                        } elseif ($item['type'] == '04') {
                                            $type = '';
                                            if ($commissionList[$item['id']]->description == 'Hoa hồng Mua lẻ cá nhân') {
                                                $type = '?personal=1';
                                            } else {
                                                $type = '';
                                            }
                                            ?>
                                            <a href="<?php echo base_url(); ?>account/detail/commission/buyer/<?php echo $commissionList[$item['id']]->id . $type; ?>">
                                                <button type="button" class="btn btn-default1" data-toggle="modal" >
                                                    <i class="fa fa-newspaper-o"></i>
                                                </button>
                                            </a>
                                            <?php
                                        } elseif ($item['type'] == '02') {
                                            $type = '';
                                            if ($commissionList[$item['id']]->description == 'Hoa hồng bán sỉ') {
                                                $type = '?personal=1';
                                            } else {
                                                $type = '';
                                            }
                                            ?>
                                            <a href="<?php echo base_url(); ?>account/detail/commission/wholesale/<?php echo $commissionList[$item['id']]->id . $type; ?>">
                                                <button type="button" class="btn btn-default1" data-toggle="modal" >
                                                    <i class="fa fa-newspaper-o"></i>
                                                </button>
                                            </a>
                                            <?php
                                        } elseif ($item['type'] == '01') {
                                            $type = '';
                                            if ($commissionList[$item['id']]->description == 'Hoa hồng mua sỉ') {
                                                $type = '?personal=1';
                                            } else {
                                                $type = '';
                                            }
                                            ?>

                                            <a href="<?php echo base_url(); ?>account/detail/commission/aggre/<?php echo $commissionList[$item['id']]->id . $type; ?>">
                                                <button type="button" class="btn btn-default1" data-toggle="modal" >
                                                    <i class="fa fa-newspaper-o"></i>
                                                </button>
                                            </a>
                                        <?php } else { ?>
                                            <?php if ($commissionList[$item['id']]->id . $type != '') { ?>
                                                <a href="<?php echo base_url(); ?>account/detail/commission/<?php echo $commissionList[$item['id']]->id . $type; ?>">
                                                    <button type="button" class="btn btn-default1" data-toggle="modal" >
                                                        <i class="fa fa-newspaper-o"></i>
                                                    </button>
                                                </a>
                                            <?php } ?>
                                        <?php } ?>
                                    <?php } ?>
                                <?php } else { ?>
                                    <a href="<?php echo base_url(); ?>account/income/detail/<?php echo $item['id']; ?>">Chi tiết</a>
                                <?php } ?>
                            </td>

                        </tr>
                    <?php endforeach; ?>
                </table>        
                
                <div class="text-center">
                    <?php echo $pager; ?>
                </div>
            </div>
            <?php } else { ?>
                <div class="none_record">
                   <p>Chưa có dữ liệu cho mục này.</p>
                </div>  
            <?php } ?>
            <br>            
        </div>
    </div>
</div>
<?php $this->load->view('home/common/footer'); ?>