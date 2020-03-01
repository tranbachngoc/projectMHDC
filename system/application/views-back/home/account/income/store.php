<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2/1/2016
 * Time: 5:28 AM
 */
$group_id = (int)$this->session->userdata('sessionGroup');
?>
<?php $this->load->view('home/common/account/header'); ?>
    <div class="container-fluid">
        <div class="row">
            <?php $this->load->view('home/common/left'); ?>
            <!--BEGIN: RIGHT-->
            <div class="col-md-9 col-sm-8 col-xs-12">
            <h4 class="page-header text-uppercase" style="margin-top:10px">
                    Thu nhập Từ Gian hàng
                </h4>
                <div style="width:100%; overflow-y: auto;">
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
                                        url: '<?php echo base_url();?>' + "ajax/update-payment",
                                        dataType: 'json',
                                        data: {id: id, status: 3},
                                        success: function (res) {
                                            $(item).removeClass('processing');
                                            if (res.error == false) {
                                                $('#row_'+id).find('.rowAction').html('Ðã cập nhật.');
                                                $('#row_'+id).find('.rowStatus').html('Khiếu nại.');

                                                //$('#row_'+id).remove();
                                                alert('Đã tạo khiếu nại');
                                            }else{
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
                                        url: '<?php echo base_url();?>' + "ajax/update-payment",
                                        dataType: 'json',
                                        data: {id: id, status: 4},
                                        success: function (res) {
                                            $(item).removeClass('processing');
                                            if (res.error == false) {
                                                $('#row_'+id).find('.rowAction').html('Ðã cập nhật.');
                                                $('#row_'+id).find('.rowStatus').html('Hoàn tất chuyển khoản.');

                                                //$('#row_'+id).remove();
                                                alert('Đã cập nhật');
                                            }else{
                                                alert(res.message);
                                            }

                                        }
                                    });
                                } else {
                                    $(item).removeClass('processing');
                                }



                            }
                        </script>
                        <table class="table table-bordered afBox">

                            <thead>
                            <tr>
                                <td colspan="7" class="form-inline">
                                    <form name="frmAccountPro" action="<?php echo base_url().'account/income/store'; ?>" method="post" >
                                        <?php if($filter['status'] == 0):?>
                                            <select name="ctype" class="form-control3" autocomplete="off">
                                                <option value="">-Tất cả-</option>
                                                <?php foreach($ctypes as $key=>$val):?>
                                                    <option value="<?php echo $val['id'];?>" <?php if ($filter['ctype'] == $val['id']){ echo 'selected="selected"';}?>><?php echo $val['text'];?></option>
                                                <?php endforeach;?>
                                            </select>
                                        <?php endif;?>
                                        <select name="status" autocomplete="off" class="form-control3">
                                            <?php foreach($status as $key=>$val):?>
                                                <option value="<?php echo $key;?>" <?php if ($filter['status'] == $key){ echo 'selected="selected"';}?>><?php echo $val;?></option>
                                            <?php endforeach;?>
                                        </select>
                                    Tháng
                                    <select class="form-control3" name="month" autocomplete="off">
                                        <?php for($i = 1; $i <= 12; $i++):
                                        if($i < 10){ $i = '0'.$i;}
                                        ?>
                                        <option <?php echo $filter['month'] == $i ? 'selected="selected"': '';?> value="<?php echo $i;?>"><?php echo $i;?></option>
                                        <?php endfor;?>
                                    </select>

                                    Năm
                                    <select class="form-control3" name="year" autocomplete="off">
                                        <?php for($i = 2015; $i <= 2025; $i++):
                                            if($i < 10){ $i = '0'.$i;}
                                            ?>
                                            <option <?php echo $filter['year'] == $i ? 'selected="selected"': '';?> value="<?php echo $i;?>"><?php echo $i;?></option>
                                        <?php endfor;?>
                                    </select>


                                    <button type="submit" class="btn btn-primary padding-button">Tìm kiếm</button>
                                    <!--<button type="submit" class="sButton"></button>-->
                                    <input type="hidden" name="dir" value="<?php echo $filter['dir']; ?>"/>
                                    <input type="hidden" name="sort" value="<?php echo $filter['sort']; ?>"/>
                                    <br />
                                        Số dư tài khoản: <b><?php echo number_format($user['havingAmount']).' VND';?></b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        Đang yêu cầu thanh toán: <b><?php echo number_format(abs($user['bankingAmount'])).' VND';?></b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    </form>
                                </td>
                            </tr>

                            <?php if(count($accounts) > 0) {?>
                            <tr>
                                <th width="5%" class="aligncenter hidden-xs">STT</th>
                                <?php if($filter['status'] == 0):?>
                                <th class="text-center">Loại hoa hồng
                                </th>
                                <?php endif;?>

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
                                <th class="text-center ">
                                   
                                </th>

                            </tr>
                            </thead>

                            <tbody>
                            <?php foreach ($accounts as $k => $item):?>

                                <!-- Modal -->

                                <tr id="row_<?php echo $item['id'];?>">
                                    <td class="hidden-xs"><?php echo $num + $k + 1;?></td>
                                    <?php if($filter['status'] == 0):?>
                                    <td align="left" >
                                        <?php foreach($ctypes as $val){
                                            if($val['id'] == $item['type']){
                                                echo $val['text'];
                                                break;
                                            }
                                        }

                                        ?>
                                    </td>
                                    <?php endif;?>
                                    <td>
                                        <span
                                            class="product_price"><?php echo number_format(abs($item['amount']), 0, ",", ".") . ' VND';?></span>
                                    </td>
                                    <td >
                                        <?php echo $item['created_date'];?>
                                    </td>
                                    <td class="rowStatus"><?php foreach($status as $key=>$val){
                                            if($key == $item['status']){
                                                echo $val;
                                                break;
                                            }
                                        }?>
                                    </td>

                                    <td class="rowAction">
                                        <?php if($filter['status'] == 2):  ?>
                                        <button onclick="makeCaution(<?php echo $item['id'];?>, this)" title="Khiếu nại" type="button" class="btn btn-warning" data-toggle="modal" >
                                            <i class="fa fa-support"></i>
                                        </button>
                                            <button onclick="makeComplete(<?php echo $item['id'];?>, this)" title="Hoàn tất chuyển khoản" type="button" class="btn btn-success" data-toggle="modal" >
                                                <i class="fa fa-cubes"></i>
                                            </button>
                                        <?php endif;?>
                                    </td>

                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                            <?php }else{ ?>
                                <tr>
                                    <td colspan="7" align="center">
                                        <div class="nojob">Không có dữ liệu!</div>
                                    </td>
                                </tr>
                            <?php } ?>
                        </table>


                    <?php echo $pager; ?>

                </div>
            </div>
        </div>
    </div>
<?php $this->load->view('home/common/footer'); ?>