<?php $this->load->view('home/common/header'); ?>
<style>
  .red_money{text-align: right;}

  .nav-tabs>li.active>a, .nav-tabs>li.active>a:focus, .nav-tabs>li.active>a:hover {
    color: white;
    cursor: default;
    background-color: #767676;
    border: 1px solid #ddd;
    border-bottom-color: transparent;
  }
  table.table-bordered .button_status a{
      color: #ffffff !important;
  }
  table.table-bordered .button_status a.close{
      color: #000 !important;
      opacity: 0.8;
  }

</style>
<div class="container-fluid">
  <div class="row">
    <?php $this->load->view('home/common/left'); ?>
    <!--BEGIN: RIGHT-->
    <div class="col-md-9 col-sm-8 col-xs-12">
            <h4 class="page-header" style="margin-top:10px">
		QUẢNG CÁO CỦA TÔI
	    </h4>

      <div style="background-color: white">
        <div id="history_recharge" class="panel-body">



          <div class="tab-content">
            <div class="tab-pane active" id="_banking">
              <table class="table table-bordered"  width="100%" border="0" cellpadding="0" cellspacing="0">
                <?php if (count($listAd) > 0) { ?>
                  <thead>
                  <tr>
                    <th width="5%" class="title_account_0 hidden-xs">STT</th>
                    <th width="20%" align="center">Tiêu đề</th>
                    <th width="20%" align="center">Hình ảnh / Liên kết</th>
                    <th width="20%" align="center">Tỉnh thành / Danh mục / Vị trí</th>
                    <th width="15%" align="center">Ngày bắt đầu</th>
                    <th width="15%" align="center">Ngày kết thúc</th>
                      <th width="15%" align="center">Thao tác</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php $bank = json_decode(bankpayment); ?>
                  <?php foreach ($listAd as $key => $vals): ?>
                    <tr>
                      <td class="bk_email hidden-xs"><?php echo ++$key; ?></td>
                      <td class="bk_email"><?php echo $vals->adv_title; ?>
                      </td>
                      <td class="bk_email">
                        <img width="200" src="<?php echo base_url(); ?>media/banners/<?php echo $vals->adv_dir; ?>/<?php echo $vals->adv_banner; ?>" />

                        <br>
                        <a href="<?php echo base_url(); ?>media/banners/<?php echo $vals->adv_dir; ?>/<?php echo $vals->adv_banner; ?>" target="_blank">Xem ảnh đầy đủ</a>
                        <br>
                        <a href="<?php echo $vals->adv_link; ?>" target="_blank">Liên kết Banner</a>
                      </td>
                      <td class="bk_email"><?php if($vals->adv_page == "home"){ ?> - <?php echo $vals->pre_name; ?> <br> - <?php echo $vals->cat_name; ?><?php } ?> <br> - <?php echo $vals->adv_title2; ?> <br> - <?php if($vals->adv_page == "home"){ echo "Trang chủ danh mục"; } ?><?php if($vals->adv_page == "product_sub"){ echo "Trang chủ Affiliate"; } ?><br>
                    <?php if($vals->adv_page == "home"){ ?><a target="_blank" href="<?php echo base_url(); ?><?php echo $vals->cat_id; ?>/<?php echo RemoveSign($vals->cat_name); ?>">Xem banner hiển thị</a> <?php } ?>
                    <?php if($vals->adv_page == "product_sub"){ ?><a target="_blank" href="<?php echo base_url(); ?><?php echo $shop[0]->sho_link; ?>">Xem banner hiển thị</a><?php } ?>

                      </td>
                      <td class="bk_email"><?php echo date("d-m-Y", $vals->adv_begindate); ?></td>
                      <td class="bk_email"><?php echo date("d-m-Y", $vals->adv_enddate); ?></td>
                        <td class="bk_email button_status">
                            <?php if($vals->adv_status == 1){?>
                                <a class="btn btn-primary btn_action" href="javascript:void(0)" title="Ngưng kích hoạt" onclick="ActionLink('<?php echo $statusUrl; ?>/status/deactive/id/<?php echo $vals->adv_id; ?>')" ><i class="fa fa-check"></i></a>
                            <?php } else {?>
                                <a class="btn btn-default btn_action close" href="javascript:void(0)" title="Kích hoạt" onclick="ActionLink('<?php echo $statusUrl; ?>/status/active/id/<?php echo $vals->adv_id; ?>')"><i class="fa fa-times"></i></a>
                            <?php }?>
                        </td>
                    </tr>
                  <?php endforeach; ?>
                  </tbody>
                <?php } else { ?>
                  <tr>
                    <td class="text-center">
                      Không có dữ liệu!
                    </td>
                  </tr>
                <?php } ?>
               </table>
              <?php if(isset($linkPage) && $linkPage){ echo $linkPage;} ?>
            </div>
            <div class="tab-pane" id="_nganluong">

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php $this->load->view('home/common/footer'); ?>