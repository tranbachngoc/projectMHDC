<?php $this->load->view('home/common/account/header'); ?>
<div class="clearfix"></div>
    <div id="product_content" class="container-fluid">
    <div class="row">
<?php $this->load->view('home/common/left');
$url = $this->uri->segment(3);
if (($url && $url !='' && $url =='service') || ($url && $url !='' && $url =='coupon')){
    $search  = $url.'/';
}else{
    $url1 = '';
}
    $url1 = '/'.$url;
?>

<link type="text/css" href="<?php echo base_url(); ?>templates/home/css/datepicker.css" rel="stylesheet" />
<script type="text/javascript" src="<?php echo base_url(); ?>templates/home/js/datepicker.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>templates/home/js/ajax.js"></script>
<style type="text/css">
    .fa-spinner {
        font-size: 17px;
        display: none;
    }
</style>
<!--BEGIN: RIGHT-->
 <SCRIPT TYPE="text/javascript">
  function SearchRaoVat(baseUrl){
		  product_name='';
          var url = '<?php echo $url1 ?>';
		  if(document.getElementById('keyword_account').value!='')
		  product_name=document.getElementById('keyword_account').value;
		  window.location = baseUrl+'account/product'+url+'/search/name/keyword/'+product_name+'/';
}
<!--
function submitenterQ(myfield,e,baseUrl)
{
var keycode;
if (window.event) keycode = window.event.keyCode;
else if (e) keycode = e.which;
else return true;

if (keycode == 13)
   {
   SearchRaoVat(baseUrl);
   return false;
   }
else
   return true;
};
-->
</SCRIPT>
<div class="col-md-9 col-sm-8 col-xs-12">
    <h4 class="page-header text-uppercase" style="margin-top:10px">
        <?php
        if ($url =='service'){
            echo 'Dịch vụ';
            $pro = 'Dịch vụ';
        }elseif($url == 'coupon'){
            echo 'Phiếu mua hàng điện tử';
            $pro = 'phiếu mua hàng điện tử';
        }else{
            echo 'Sản phẩm đã đăng';
            $pro = 'Sản phẩm đã đăng';
        }
        ?>
    </h4>
    <?php
        if($flash_message){
        ?>
            <div class="message success" >
                <div class="alert alert-warning">
                    <?php echo $flash_message; ?>
                    <button type="button" class="close" data-dismiss="alert">×</button>
                </div>
            </div>
        <?php
        }
    ?>
    <?php
        if($flash_msg_error){
        ?>
            <div class="message success" >
                <div class="alert alert-danger">
                    <?php echo $flash_msg_error; ?>
                    <button type="button" class="close" data-dismiss="alert">×</button>
                </div>
            </div>
        <?php
        }
    ?>
    
    
        <div class="panel panel-default">                    
            <div class="panel-body">
                <form class="searchBox" method="post" action="<?php echo base_url() . 'account/product/' . $this->uri->segment(3); ?>" class="">
                    <div class="row">
                        <div class="col-md-5 col-sm-7">
                            <div class="input-group">
                                <input type="text" placeholder="Nhập tên <?php echo $pro ?> cần tìm" name="keyword_account"  id="keyword_account" value="<?php
                                if (isset($keyword)) {
                                    echo $keyword;
                                } ?>" maxlength="100" class="form-control" onKeyUp="BlockChar(this,'AllSpecialChar')" onfocus="ChangeStyle('keyword_account',1)" onblur="ChangeStyle('keyword_account',2)" onKeyPress="return submitenterQ(this,event,'<?php echo base_url(); ?>')" />
				<span class="input-group-btn">
                                    <button type="submit" name="search" class="btn btn-azibai"> <i class="fa fa-search"></i> </button>
				</span>    
			    </div>
                        </div>                                 
                        <div class="visible-xs" style="height:15px"></div>
                        <div class="col-md-3 col-sm-5">
                            <?php
                            if ($url == 'coupon') {
                                $url_post = 'coupon/add/'.$this->session->userdata('sessionUser');
                            }
                            else {
                                $url_post = 'product/add/'.$this->session->userdata('sessionUser');
                            }
                            ?>
                            <a  href="<?php echo base_url() . $url_post ?>" target="_blank" class="btn btn-success btn-block"><i class="fa fa-plus"></i> Đăng <?php
                                if ($url == 'service') {
                                    echo 'Dịch vụ';
                                } elseif ($url == 'coupon') {
                                    echo 'Coupon';
                                } else {
                                    echo 'Sản phẩm';
                                }
                                ?>
                            </a>

                            <input type="hidden" name="search_account" id="search_account" value="name" />
                        </div>
                    </div>
                </form>                
            </div>
        </div>
    
        <form name="frmAccountPro" id="frmAccountPro" method="post">
        <div style="overflow: auto">
            <table class="table table-bordered" width="100%" border="0" cellpadding="0" cellspacing="0" >
            <?php if($shopid > 0){ ?>
                <?php if(count($product) > 0){ ?>                
                <thead>                
                <tr>
                    <th width="40" class="text-center hidden-xs hidden-sm">STT</th>
                    <th width="40" class="text-center hidden-xs hidden-sm">
                        <input type="checkbox" name="checkall" id="checkall" value="0" onclick="DoCheck(this.checked,'frmAccountPro',0)" />
                    </th>
                    <th width="100" class="text-center">
                       Hình ảnh
                    </th>
                    <th width="200" class="text-center" >
                        <?php echo "Tên sản phẩm"; //$this->lang->line('product_list'); ?>
                        <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>name/by/asc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                        <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>name/by/desc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                    </th>
                    <th width="60" class="text-center hidden-xs hidden-sm">
                        SL
                    </th>
                    <th width="100" class="text-center">
                        Giá
                    </th>
                    <th width="" class="hidden-xs hidden-sm">
                        <?php echo $this->lang->line('category_list'); ?>
                        <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>category/by/asc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                        <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>category/by/desc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                    </th>
                    <th width="" class="hidden-xs hidden-sm">
                        Nhân viên đăng
                    </th>
                    <th width="60" class="hidden-xs hidden-sm">
                        Cho CTV bán
                    </th>
                    <th width="60" class="hidden-xs hidden-sm"><?php echo $this->lang->line('status_list'); ?></th>
                    <th width="60" class="hidden-xs hidden-sm">Thứ tự</th>
                    <th width="60"><span>Chỉnh sửa</span></th>

                </tr>
            </thead>
                <?php $idDiv = 1; ?>
                <?php foreach($product as $k=>$productArray){

                    if($productArray->pro_type == 2){
                        $pro_type = 'coupon';
                    }
                    else{
                        if($productArray->pro_type == 0){
                            $pro_type = 'product';
                        }
                    }
                    ?>

                    <!-- Modal -->
                    <div class="modal fade prod_detail_modal" id="myModal<?php echo $k;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="fa fa-times-circle text-danger"></i></button>
                                    <h4 class="modal-title" id="myModalLabel">Chi tiết sản phẩm</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-lg-3 col-xs-4">Tên sản phẩm:</div>
                                        <div class="col-lg-9 col-xs-8"><?php echo sub($productArray->pro_name, 100); ?></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3 col-xs-4">Số lượng:</div>
                                        <div class="col-lg-9 col-xs-8"> <?php echo $productArray->pro_instock; ?></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3 col-xs-4">Giá sản phẩm:</div>
                                        <div class="col-lg-9 col-xs-8"><span class="product_price"><?php echo number_format($productArray->pro_cost,0,",","."); ?> VNĐ</span>
                                        </div>
                                    </div>
                                     <div class="row">
                                        <div class="col-lg-3 col-xs-4">Giảm giá:</div>
                                        <div class="col-lg-9 col-xs-8">
                                            <?php if($productArray->pro_saleoff_value > 0){ ?><div class="product_discount"> - <?php if($productArray->pro_type_saleoff == 1 && $productArray->pro_saleoff_value > 0){  echo $productArray->pro_saleoff_value." %"; }elseif($productArray->pro_type_saleoff == 2 && $productArray->pro_saleoff_value > 0){ echo number_format($productArray->pro_saleoff_value,0,",",".")." đ";} ?></div><?php } ?>
                                        </div>
                                    </div>
                                     <div class="row">
                                        <div class="col-lg-3 col-xs-4">Danh mục:</div>
                                        <div class="col-lg-9 col-xs-8"><?php echo $productArray->cat_name; ?></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3 col-xs-4">Nhân viên đăng:</div>
                                        <div class="col-lg-9 col-xs-8"><?php echo $productArray->pro_user_up; ?></div>
                                        <?php if($productArray->pro_user_modified != '0'){ ?>
                                        <div class="col-lg-9 col-xs-8">
                                            <p style="font-size:85%">
                                                <i>Ngày sữa: <?php echo $productArray->up_date; ?></i><br/>
                                                <i>Người sữa: <?php echo $productArray->pro_user_modified; ?></i>
                                            </p>
                                        </div>
                                        <?php } ?>
                                    </div>
                                     <div class="row">
                                        <div class="col-lg-3 col-xs-4">Ngày đăng:</div>
                                        <div class="col-lg-9 col-xs-8">  <?php echo date('d-m-Y', $productArray->pro_begindate); ?></div>
                                    </div>
                                     <div class="row">
                                        <div class="col-lg-3 col-xs-4">Cho CTV bán:</div>
                                        <div class="col-lg-9 col-xs-8">
                                            <?php if((int)$productArray->is_product_affiliate == 1){ ?>
                                                <img src="<?php echo base_url(); ?>templates/home/images/public.png"  style="cursor:pointer;" border="0" title="Là sản phẩm Cộng Tác Viên Online" alt="<?php echo $this->lang->line('deactive_tip'); ?>" />
                                            <?php }else{ ?>
                                                <img src="<?php echo base_url(); ?>templates/home/images/unpublic.png" style="cursor:pointer;" border="0" title="Không phải sản phẩm Cộng Tác Viên Online" alt="<?php echo $this->lang->line('active_tip'); ?>" />
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3 col-xs-4">Trạng thái</div>
                                        <div class="col-lg-9 col-xs-8">
                                            <?php if((int)$productArray->pro_status == 1){ ?>
                                                <img src="<?php echo base_url(); ?>templates/home/images/public.png"  style="cursor:pointer;" border="0" title="Là sản phẩm Cộng Tác Viên Online" alt="<?php echo $this->lang->line('deactive_tip'); ?>" />
                                            <?php }else{ ?>
                                                <img src="<?php echo base_url(); ?>templates/home/images/unpublic.png" style="cursor:pointer;" border="0" title="Không phải sản phẩm Cộng Tác Viên Online" alt="<?php echo $this->lang->line('active_tip'); ?>" />
                                            <?php } ?>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <tr>
                        <td height="45" class="text-center hidden-xs hidden-sm"><?php echo $sTT; ?></td>
                        <td class="text-center hidden-xs hidden-sm">
                            <input type="checkbox" name="checkone[]" id="checkone" value="<?php echo $productArray->pro_id; ?>" onclick="DoCheckOne('frmAccountPro')" />
                        </td>
                        <td class="img_prev text-center">
                            <?php
                            $filename = DOMAIN_CLOUDSERVER .'media/images/product/'.$productArray->pro_dir.'/thumbnail_1_'. explode(',', $productArray->pro_image)[0];
                            $imglager = DOMAIN_CLOUDSERVER .'media/images/product/'.$productArray->pro_dir.'/thumbnail_3_'. explode(',', $productArray->pro_image)[0];
                            if($filename != ''){
                            ?>
                            <a rel="tooltip" data-toggle="tooltip" data-html="true" data-placement="auto right" data-original-title="<img src='<?php echo $imglager; ?>' />">
                                <img width="80" src="<?php echo $filename; ?>" />
                            </a>
                                <?php }else{?>
							<a target="_blank" class="menu_1" href="<?php echo $shop.'shop/'.$pro_type; ?>/detail/<?php echo $productArray->pro_id; ?>/<?php echo RemoveSign($productArray->pro_name); ?>" >
                                	
                                <img width="80" src="<?php echo base_url(); ?>media/images/no_photo_icon.png" />
                            </a>
							<?php } ?>
                        </td>
                        <td>
<!--                            onmouseover="ddrivetip('<table border=0 width=300 cellpadding=1 cellspacing=0><tr><td width=\'20\' valign=\'top\' align=\'left\'><img src=\'--><?php //echo base_url(); ?><!--media/images/product/--><?php //echo $productArray->pro_dir; ?><!--/--><?php //echo show_thumbnail($productArray->pro_dir, $productArray->pro_image); ?><!--\' class=\'image_top_tip\'></td><td valign=\'top\' align=\'left\'>--><?php //echo $productArray->pro_descr; ?><!--</td></tr></table>',300,'#F0F8FF');" onmouseout="hideddrivetip();"-->
                            <a  target="_blank" class="menu_1" href="<?php echo $shop.'shop/'.$pro_type; ?>/detail/<?php echo $productArray->pro_id; ?>/<?php echo RemoveSign($productArray->pro_name); ?>" >
                                <?php echo sub($productArray->pro_name, 100); ?>
                            </a>			    
                            <p style="font-size:85%">
				<i>Ngày đăng: <?php echo date('d/m/Y', $productArray->pro_begindate); ?></i><br/>
				<i>Lượt xem: <?php echo $productArray->pro_view; ?></i>
			    </p>
                            <?php if ($group_id == AffiliateStoreUser || $group_id == AffiliateUser): ?>
                                <p><a target="_blank" href="<?php echo base_url().'account/service/products/'.$productArray->pro_id; ?>">Chọn dịch vụ</a></p>
                            <?php endif;?>

                        </td>
                        <td  class="text-center hidden-xs hidden-sm">
                            <?php 
                                echo number_format($productArray->pro_instock);
                            ?>
                        </td>
                        <td class="" style="text-align:right;">
                            <span class="product_price"><?php echo number_format($productArray->pro_cost,0,",","."); ?> đ</span>
                            <?php if($productArray->pro_saleoff_value > 0){ ?><div class="product_discount"> - <?php if($productArray->pro_type_saleoff == 1 && $productArray->pro_saleoff_value > 0){  echo $productArray->pro_saleoff_value." %"; }elseif($productArray->pro_type_saleoff == 2 && $productArray->pro_saleoff_value > 0){ echo number_format($productArray->pro_saleoff_value,0,",",".")." đ";} ?></div><?php } ?>
                        </td>
                        <td class="text-center hidden-xs hidden-sm">
                            <?php echo $productArray->cat_name; ?>
                        </td>
                        <td class="text-center hidden-xs hidden-sm">
                            <?php echo $productArray->pro_user_up; ?>
                            <?php if($productArray->pro_user_modified != '0'){ ?>
                            <p style="font-size:85%">
                                <i>Ngày sữa: <?php echo $productArray->up_date; ?></i><br/>
                                <i>Người sữa: <?php echo $productArray->pro_user_modified; ?></i>
                            </p>
                            <?php } ?>
                        </td>
                        <td class="hidden-xs hidden-sm" style="text-align:center;">
                            <?php if((int)$productArray->is_product_affiliate == 1){ ?>
                                <img src="<?php echo base_url(); ?>templates/home/images/public.png"  style="cursor:pointer;" border="0" title="Là sản phẩm Cộng Tác Viên Online" alt="<?php echo $this->lang->line('deactive_tip'); ?>" />
                            <?php }else{ ?>
                                <img src="<?php echo base_url(); ?>templates/home/images/unpublic.png" style="cursor:pointer;" border="0" title="Không phải sản phẩm Cộng Tác Viên Online" alt="<?php echo $this->lang->line('active_tip'); ?>" />
                            <?php } ?>
                        </td>                        
                        <td class="hidden-xs hidden-sm" style="text-align:center;">
                            <?php if((int)$productArray->pro_status == 1){ ?>
                                <img src="<?php echo base_url(); ?>templates/home/images/public.png" onclick="ActionLink('<?php echo $statusUrl; ?>/status/deactive/id/<?php echo $productArray->pro_id; ?>')" style="cursor:pointer;" border="0" title="<?php echo $this->lang->line('deactive_tip'); ?>" alt="<?php echo $this->lang->line('deactive_tip'); ?>" />
                            <?php }else{ ?>
                                <img src="<?php echo base_url(); ?>templates/home/images/unpublic.png" onclick="ActionLink('<?php echo $statusUrl; ?>/status/active/id/<?php echo $productArray->pro_id; ?>')" style="cursor:pointer;" border="0" title="<?php echo $this->lang->line('active_tip'); ?>" alt="<?php echo $this->lang->line('active_tip'); ?>" />
                            <?php } ?>
                        </td>
                        <td class="text-center  hidden-xs  hidden-sm">
                            <input type="text" value="<?php echo $productArray->pro_order;?>" onchange="Order_product(<?php echo $productArray->pro_id; ?>, this.value);" style="width: 40px"  />
                            <i id="iconload_<?php echo $productArray->pro_id;?>" class="fa fa-spinner fa-spin fa-fw text-success"></i>
                        </td>
                        <td class="text-center">
                            <?php $spshop = $productArray->pro_of_shop;
                                $link_edit = 'product/edit/'. $productArray->pro_id.'/'.RemoveSign($productArray->pro_name);
                                if(isset($spshop) && $spshop != 0){
                                    $link_edit = 'account/product'.$url1.'/editbran/'. $productArray->pro_id;
                                }
                            ?>
                           
                              <a href="<?php echo base_url(). $link_edit; ?>" type="button" class="btn btn-azibai" target="_blank">
                                  <i class="fa fa-pencil-square-o"></i>
                              </a>
                                                        
                            <p class="hidden-md hidden-lg">
                                <button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal<?php echo $k;?>">
                                    <i class="fa fa-newspaper-o"></i>
                                </button>
                            </p>
                        </td>

                    </tr>
                    <?php $idDiv++; ?>
                    <?php $sTT++; ?>
                <?php } ?>
        <?php }elseif(count($product) == 0 && trim($keyword) != ''){ ?>
        <tr>
            <td width="50" class="title_account_0">STT</td>
            <td width="30" class="title_account_1"><input type="checkbox" name="checkall" id="checkall" value="0" onclick="DoCheck(this.checked,'frmAccountPro',0)" /></td>
            <td class="title_account_2">
                <?php echo $this->lang->line('product_list'); ?>
                <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" border="0" />
                <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" border="0" />
            </td>
            <td width="150" class="title_account_1">
                <?php echo $this->lang->line('category_list'); ?>
                <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" border="0" />
                <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" border="0" />
            </td>
            <td width="110" class="title_account_2">
                <?php echo $this->lang->line('date_post_list'); ?>
                <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" border="0" />
                <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" border="0" />
            </td>
            <td width="120" class="title_account_1">
                <?php echo $this->lang->line('enddate_list'); ?>
                <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" border="0" />
                <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" border="0" />
            </td>
            <td width="60" class="title_account_2"><?php echo $this->lang->line('status_list'); ?></td>
            <td width="50" class="title_account_3"><?php echo $this->lang->line('edit_list'); ?></td>
        </tr>
        <tr>
            <td  colspan="10" class="none_record_search" align="center"><?php echo $this->lang->line('none_record_search_product_defaults'); ?></td>
        </tr>
        <tr>
            <td  colspan="10" id="delete_account">
				<img  class="hidden-xs" src="<?php echo base_url(); ?>templates/home/images/icon_deletepro_account.gif" onclick="" style="cursor:pointer;" border="0" />
            </td>
        </tr>
        <?php }else{ ?>
        <tr>
        	<td  colspan="10" class="text-center" >
                <?php
                $url = $this->uri->segment(3);
              if ($url == 'service'){
                    echo 'Không có dịch vụ!';
                }elseif ($url == 'coupon'){
                    echo 'Không có phiếu mua hàng điện tử nào!';
                }else{
                  echo 'Không có sản phẩm!';
              }
                ?>
            </td>
		</tr>
        <?php } ?>
        <?php }else{ ?>
        <tr>
            <td>
            	<div class="text-center"><?php echo $this->lang->line('noshop'); ?> <a href="<?php echo base_url(); ?>account/shop">tại đây</a></div>
            </td>
        </tr>
            <?php } ?>
    </table>
        </div>
        
        <?php if(isset($linkPage)) {?>
            <?php echo $linkPage; ?>
        <?php }?>
    </form>
    </div>
</div>
    </div>
<!--END RIGHT-->
<?php $this->load->view('home/common/footer'); ?>
<script language="javascript">
    function Order_product(pro_id, order){
       $("#iconload_"+pro_id).show();
        $.ajax({
            type: "post",
            url:"<?php echo base_url(); ?>" + 'home/account/order_pro',
            cache: false,
            data:{pro_id: pro_id, order: order},
            dataType:'text',
            success: function(data){
              if(data == '1'){
                  $("#iconload_"+pro_id).hide();
              }else{
                  errorAlert('Có lỗi xảy ra!');
              }
            }
        });
        return false;
    }
</script>
