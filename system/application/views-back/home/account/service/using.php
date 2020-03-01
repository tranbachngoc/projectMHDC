<?php $this->load->view('home/common/account/header'); ?>
<div class="container-fluid">
    <div class="row">
        <?php $this->load->view('home/common/left'); ?>
        <div class="col-md-9 col-sm-8 col-xs-12">
            <h4 class="page-header text-uppercase" style="margin-top:10px">Dịch vụ đang sử dụng</h4>    
            <?php
            if ($this->session->flashdata('flash_message_success') || $this->session->flashdata('flash_message_error')){ ?>
                <div class="message success" >
                    <div class="alert <?php echo ($this->session->flashdata('flash_message_error')?'alert-danger':'alert-success')?>">
                        <?php echo ($this->session->flashdata('flash_message_error')?$this->session->flashdata('flash_message_error'):$this->session->flashdata('flash_message_success')); ?>
                        <button type="button" class="close" data-dismiss="alert">×</button>
                    </div>
                </div>
            <?php } ?>
	    
            <?php if ($shopid > 0) { ?>
                <?php if (count($data) > 0) { ?>
                <div class="table-responsive"> 
                    <table class="table table-bordered sTable" width="100%" border="0" cellpadding="0" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Gói</th>                  
                                <th>Thời gian</th>
                                <th>Số tiền</th>
                                <th class="hidden-xs">Trạng thái</th>
                                <th class="hidden-xs"></th>
                                <th>Chi tiết</th>
                            </tr>
                        </thead>

                        <?php foreach ($data as $k=> $item):
                            if($item['content_info'] != ''){
                                $contend_data = explode('#', $item['content_info']);
                                $item['content_info'] = array();
                                foreach($contend_data as $tmp){
                                    $row = array();
                                    $tmp1 = explode(';', $tmp);
                                    if(count($tmp1) == 4){
                                        $row['pro_dir'] = $tmp1[0];
                                        $row['pro_category'] = $tmp1[1];
                                        $row['pro_id'] = $tmp1[2];
                                        $row['pro_name'] = $tmp1[3];
                                    }else{
                                        $row['id_category'] = $tmp1[0];
                                        $row['not_id'] = $tmp1[1];
                                        $row['not_title'] = $tmp1[2];
                                    }
                                    array_push($item['content_info'], $row);
                                }
                            }

                            ?>
                            <!-- Modal -->
                            <div class="modal fade prod_detail_modal" id="myModal<?php echo $k;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="fa fa-times-circle text-danger"></i></button>
                                            <h4 class="modal-title" id="myModalLabel">Chi tiết dịch vụ</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-lg-3 col-xs-4">Gói:</div>
                                                <div class="col-lg-9 col-xs-8"><?php echo $item['package']; ?></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-3 col-xs-4">Thời gian:</div>
                                                <div class="col-lg-9 col-xs-8"><?php echo $item['period'] == -1 ? 'Không giới hạn' : $item['period'].' '.$item['unit_type']; ?></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-3 col-xs-4">Số tiền:</div>
                                                <div class="col-lg-9 col-xs-8">
                                                    <span class="product_price"><?php echo $item['amount'] > 0 ? number_format($item['amount'], 0, ',', '.'). ' đ': 'Miễn phí'; ?> </span>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-3 col-xs-4">Trạng thái:</div>
                                                <div class="col-lg-9 col-xs-8">
                                                    <?php
                                                    $showDetail = false;
                                                    if ($item['status'] == 0 && $item['payment_status'] == 0) {
                                                        echo 'Đang yêu cầu';
                                                    } elseif ($item['status'] == 0 && $item['payment_status'] == 1) {
                                                        echo 'Đã thanh toán';
                                                        $showDetail = true;
                                                    } elseif ($item['status'] == 1 && $item['payment_status'] == 1) {
                                                        if ($item['ended_date'] > date('Y-m-d H:i:s') || (int)$item['ended_date'] == 0) {
                                                            echo 'Đang sử dụng';
                                                            $showDetail = true;
                                                        } else {
                                                            echo 'Đã hết hạn';
                                                        }
                                                    } elseif ($item['status'] == 9) {
                                                        echo 'Đã bị hủy';
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-3 col-xs-4">Ngày đăng ký:</div>
                                                <div class="col-lg-9 col-xs-8"><?php echo $item['created_date']; ?></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-3 col-xs-4">Ngày bắt đầu:</div>
                                                <div class="col-lg-9 col-xs-8"> <?php echo $item['begined_date'] != '' ? date('d-m-Y', strtotime($item['begined_date'])) : '';?></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-3 col-xs-4">Ngày bắt đầu:</div>
                                                <div class="col-lg-9 col-xs-8"> <?php echo $item['modified_date'] != '' ? date('d-m-Y', strtotime($item['modified_date'])) : 'chưa cập nhật';?></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-3 col-xs-4">Ngày kết thúc:</div>
                                                <div class="col-lg-9 col-xs-8">
                                                    <?php echo $item['ended_date'] != '' && $item['ended_date'] != '0000-00-00 00:00:00' ? date('d-m-Y', strtotime($item['ended_date'])) : '';?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <tr id="row_<?php echo $item['id']; ?>">
                            	<td><a href="#"><b><?php echo $item['package']; ?></b></a>
                                <?php if($item['info_id'] == 16){
                                        echo '<br/><i>(Số lượng: '.$item['limited'].' chi nhánh )</i>';
                                    }
                                    if($item['info_id'] == 17){
                                        echo '<br/><i>(Số lượng: '.$item['limited'].' CTV online )</i>';
                                    }
                                 ?>
                                </td>
                                                 
                                <td>
                                    <b><?php echo $item['period'] == -1 ? 'Không giới hạn' : $item['period'].' '.$item['unit_type']; ?></b>
                                </td>

                                <td>
                                    <span class="product_price">
                                        <?php if($item['info_id'] == 16){
                                            echo $item['real_amount'] > 0 ? number_format($item['real_amount'], 0, ',', '.'). ' đ': 'Miễn phí';
                                        }else{
                                            echo $item['amount'] > 0 ? number_format($item['amount'], 0, ',', '.'). ' đ': 'Miễn phí';
                                        } ?> 
                                    </span>
                                </td>

                                <td class="hidden-xs">
                                    <?php
                                    $showDetail = false;
                                    if ($item['status'] == 0 && $item['payment_status'] == 0) {
                                        echo 'Đang yêu cầu';
                                    } elseif ($item['status'] == 0 && $item['payment_status'] == 1) {
                                        echo 'Đã hủy';
                                        $showDetail = true;
                                    } elseif ($item['status'] == 1 && $item['payment_status'] == 1) {
                                        if ($item['ended_date'] > date('Y-m-d H:i:s') || (int)$item['ended_date'] == 0) {
                                            echo 'Đang sử dụng';
                                            $showDetail = true;
                                        } else {
                                            echo 'Đã hết hạn';
                                        }
                                    } elseif ($item['status'] == 9) {
                                        echo 'Đã bị hủy';
                                    }
                                    ?>
                                </td>

                                <td class="hidden-xs">
                                    <p>Ngày đăng ký: <b><?php echo date('d-m-Y H:i:s',strtotime($item['created_date'])); ?></b></p>
                                    <?php
                                    echo "<p> Ngày bắt đầu: <b>". ($item['begined_date'] != '' ? date('d-m-Y', strtotime($item['begined_date'])) : '')."</b></p>";
                                    echo "<p> Ngày cập nhật: <b>". ($item['modified_date'] != '' ? date('d-m-Y H:i:s',strtotime($item['modified_date'])) : 'chưa cập nhật')."</b></p>";
                                    
                                    if($item['ended_date']){
                                        echo "<p> Ngày kết thúc: <b>".($item['ended_date'] != '' && $item['ended_date'] != '0000-00-00 00:00:00' ? date('d-m-Y', strtotime($item['ended_date'])) : '')."</b></p>";
                                    }                           
                                    
                                    //print_r($item['content_info']);
                                    if(isset($item['content_info'][0]['not_id'])){
                                        echo '<span style="font-weight:bold">Đã chọn</span>: <a target="_blank" href="'.base_url().'tintuc/detail/'.$item['content_info'][0]['not_id'].'/'. RemoveSign($item['content_info'][0]['not_title']).'">'.$item['content_info'][0]['not_title'].'</a>';
                                    }
                                    
                                    if (isset($item['content_info'][0]['pro_id'])){
                                        echo '<span style="font-weight:bold">Đã chọn</span>: <a target="_blank" href="'.base_url().$item['content_info'][0]['pro_category'].'/'.$item['content_info'][0]['pro_id'].'/' .RemoveSign($item['content_info'][0]['pro_name']).'">'.$item['content_info'][0]['pro_name'].'</a>';
                                    }
                                    
                                    if (isset($item['content_num']) && $item['content_num'] && $item['info_id'] == "09"){
                                        echo 'Số kệ:'.$item['content_num'];
                                    }
                                    ?>
                                </td>

                                <td>
                                    <?php if($showDetail == true):?>
                                        <?php if($item['pack_type'] == 'package'):?>
                                                <?php if($item['info_id'] >= 2 && $item['info_id'] <= 7):?>
                                                    <a href="<?php echo base_url() . 'account/service/detail'.'/'.$item['id'];?>">Chi tiết</a>
                                                <?php else:?>
                                                    &nbsp;&nbsp;
                                                <?php endif;?>
                                        <?php else:?>
                                            <?php $rq = "?info_id=".$item['info_id']; ?>
                                            <a href="<?php echo base_url() . 'account/service/detail_daily'.'/'.$item['id'].$rq ;?>">Chi tiết</a>
                                        <?php endif;?>
                                    <?php else:?>
                                            &nbsp;&nbsp;
                                    <?php endif;?>
                                    <p class="hidden-md hidden-lg">
                                        <button type="button" class="btn btn-default1" data-toggle="modal" data-target="#myModal<?php echo $k;?>">
                                            <i class="fa fa-newspaper-o"></i>
                                        </button>
                                    </p>
                                </td>
                            </tr>

                        <?php endforeach; ?>
                        <tr>
                            <td colspan="10">
                                <div class="pagination">
                                    <?php echo $pager; ?>
                                </div>
                            </td>
                        </tr>                        
                    </table>                            
                </div>
                <?php } else { ?>
                    <div style="border:1px solid #eee; padding: 15px; text-align: center;">Không có dịch vụ nào!</div>
                <?php } ?>       	
			<?php } else { ?>         		
                <div class="noshop">
					<?php echo $this->lang->line('noshop'); ?>
                    <a href="<?php echo base_url(); ?>account/shop">tại đây</a>
                </div>
            <?php } ?>
        </div>

        <!--BEGIN: RIGHT-->
    </div>
</div>
<!--END RIGHT-->
<?php $this->load->view('home/common/footer'); ?>
