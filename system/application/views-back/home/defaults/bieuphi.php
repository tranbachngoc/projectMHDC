<?php
global $idHome;
$idHome = 1; ?>
    <script>
        function submitSearch() {
            var keyword = document.getElementById('keyword').value;
            var sl_cat = '/'+document.getElementById('sl_cat').value;
            var url = '<?php echo base_url(); ?>bieuphisanpham/search'+sl_cat+'/keyword/' + keyword;
            window.location = url;
            return true;
        }
        function submitenterQ(myfield, e, baseUrl) {
            var keycode;
            if (window.event) keycode = window.event.keyCode;
            else if (e) keycode = e.which;
            else return true;

            if (keycode == 13) {
                submitSearch();
                return false;
            }
            else
                return true;
        }
        jQuery(document).ready(function($) {
            $('#btn_search').click(function () {
                alert('dfsahjkd');
                submitSearch();
                return false;
            });
        });

    </script>
<style>
    #search .col-sm-6{
        position: relative;
    }
    #search .col-sm-6 .fa{
        display: inline-block;
        position: absolute;
        top: 10px;
        right: 30px;
    }
</style>
<?php $this->load->view('home/common/header'); ?>
    <!--START main-->
    <div id="main" class="container-fluid">
        <div class="row">
            <div class="col-lg-2 hidden-md hidden-sm hidden-xs"
                 style="background:#fff; position:fixed; top:0; bottom:0; z-index:998;">
                <?php $this->load->view('home/common/left_tintuc'); ?>
            </div>
            <div class="col-lg-10 col-lg-offset-2 ">
                <div class="breadcrumbs hidden-xs">
                    <a href="<?php echo base_url(); ?>">Trang chủ</a><i class="fa fa-angle-right"></i>
                    <span> Biểu phí sản phẩm</span>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <form id="search" class="form-horizontal" action="<?php echo base_url() ?>bieuphisanpham/search" method="post">
                            <div class="col-xs-10 col-sm-12">
                                <div class="form-group">
                                    <div class="col-sm-3">
                                        <label for="sl_cat"></label>
                                        <select name="sl_cat" id="sl_cat" class="form-control">
                                        <option <?php echo ($slrt == 'all') ? 'selected = "selected"' : ''; ?> value="all">--Tìm theo danh mục--</option>
                                        <option <?php echo ($slrt == 'product') ? 'selected = "selected"' : ''; ?> value="product">Danh mục sản phẩm</option>
                                        <?php if (serviceConfig == 1){?>
                                        <option <?php echo ($slrt == 'service') ? 'selected = "selected"' : ''; ?> value="service">Danh mục dịch vụ</option>
                                        <?php } ?>
                                        <option <?php echo ($slrt == 'coupon') ? 'selected = "selected"' : ''; ?> value="coupon">Danh mục coupon</option>
                                    </select>
                                        </div>
                                    <div class="col-sm-6">
                                            <input name="keyword" id="keyword" class="form-control col-sm-6" type="text" value="<?php echo $keyword;?>"
                                                   placeholder="Nhập từ khóa tìm kiếm"
                                                   onKeyPress="return submitenterQ(this,event,'<?php echo base_url(); ?>')"/>
                                                 <span class="fa fa-search " aria-hidden="true"></span>
                                    </div>
                                </div> 
								<div class="form-group" style="padding:15px; ">
										<a class="btn btn-success" href="javascript:void(0);"
                                       onclick="$('#search').find('input[name=excel]').val(1); $('#search').submit();$('#search').find('input[name=excel]').val(0);">
                                        <i class="fa fa-download" aria-hidden="true"></i> Tải về máy tính</a>
										<input type="hidden" name="excel" id="excel" autocomplete="off" value="0"/>
                                </div>                               
                            </div> 				
                            <div class="clearfix"></div>
                        </form>
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th style="text-align:center;">STT</th>
                                <th>Tên danh mục</th>
                                <th>Mức Phí (%)</th>
                                <!--<th>B2C (Ngoài)</th>
                                <th>B2B (Trong)</th>
                                <th>B2B (Ngoài)</th>-->
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (isset($bieuphi) && count($bieuphi) > 0) {?>
                            <?php foreach ($bieuphi as $k=>$item) {?>
                            <tr>
                                <td style="text-align:center;"><?php echo $k+1;?></td>
                                <td><?php echo $item->cat_name;?></td>
                                <td><?php echo $item->b2c_af_fee;?></td>
                                <!--<td><?php echo $item->b2c_fee;?></td>
                                <td><?php echo $item->b2b_em_fee;?></td>
                                <td><?php echo $item->b2b_fee;?></td>-->
                            </tr>
                            <?php }?>
                            <?php }else{?>
                                <tr>
                                    <td colspan="3" align="center">Không có dữ liệu...</td>
                                </tr>
                            <?php }?>
                            <?php if ($linkPage){?>
                            <tr>
                                <td colspan="3" style="text-align:center;"><?php echo $linkPage;?></td>
                            </tr>
                            <?php }?>
                            </tbody>
                        </table>
				<div style="padding: 0 3px;"><i class="fa fa-hand-o-right"></i> <strong>Ghi chú:</strong> Biểu phí trên đã bao gồm toàn bộ phí thu hộ COD và phí thanh toán qua cổng thanh toán điện tử (từ 1% đến 3,5% tùy thuộc nhà cung cấp dịch vụ)</div>				                           
                 <div style="padding: 10px 0;"><a href="http://azibai.com/media/azibai-doc/package.png" target="_blank"><i class="fa fa fa-download fa-fw"></i>Click vào đây để tải biểu giá dịch vụ azibai</a></div>
           	   </div>
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <!--END main-->
<?php $this->load->view('home/common/footer'); ?>