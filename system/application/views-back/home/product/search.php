<?php $this->load->view('home/common/header'); ?>
<!--BEGIN: CENTER-->
<script src="/templates/home/js/home_news.js"></script>
<style type="text/css">
    .product-item img[data-src] {
        opacity: 0;
    }
</style>
<script type="text/javascript">
    jQuery(function ($) {
        var catid = '<?php echo (int)$this->uri->segment(1); ?>';
        if (catid <= 40) {
            var link = '<?php echo base_url() . 'tintuc' . $this->uri->uri_string(); ?>';
            $('.tintuc_azinet').attr('href', link);
        }
    });
</script>

<div id="main" class="container-fluid">
    <div id="search_product" class="row">        
        <div class="col-lg-2 visible-lg">
            <?php $this->load->view('home/common/left_tintuc'); ?>
        </div>
        <div class="col-lg-10">
            <div class="row">
                <div class="col-xs-12">            
                    <ol id="breadcrumb" class="breadcrumb" style="white-space: nowrap; overflow: auto;">
                        <li><a href="<?php echo base_url(); ?>">Trang chủ</a></li>
                        <li><span>Tìm kiếm</span></li>
                    </ol>
                </div>    
            </div>    
            <?php
            $readyonly      =   "";
            $selected       =   "";
            $sale_off_selected = "";
            $readonly_sale_off = "";
            $keyword        =   $this->input->post('key');
            $district       =   $this->input->post('district');
            if($district != "product" && $district != ""){
                $readyonly  = 'readonly="true"';
                $readonly_sale_off = "disabled";
            }
            $keyword        = isset($keyword) && $keyword != '' ? $this->input->post('key') : $this->uri->segment(3);
            
            if($this->input->post('province')){
                $prov_id = $this->input->post('province');    
            } else {
                $prov_id = $this->session->userdata['s_province'];
            }
            
            if($this->input->post('sale_off')){
                $sale_off_selected = 'checked';
            }
            
            ?>
            <div class="row">
                <div class="col-xs-12">
                    <form id="formsearch" method="POST" action="<?php echo base_url(); ?>search-information" class="form-inline" style="z-index:2">
                    <div class="form-group">
                        <select id="province" name="province" class="form-control">
                            <option value="">Chọn Tỉnh/Thành</option>
                            <?php foreach($province as $provinceArray){ ?>
                            <?php
                                if($provinceArray->pre_id == $prov_id){
                                    $nameProvince = $provinceArray->pre_name;
                                }
                            ?>
                              <option value="<?php echo $provinceArray->pre_id;?>" <?php echo ($provinceArray->pre_id == $prov_id)?"selected='selected'":""; ?>><?php echo $provinceArray->pre_name;?></option>
                            <?php }?>
                        </select>
                    </div>
                    <div class="form-group">
                        <select id="district" name="district" class="form-control">
                            <?php if($district == 'product'){ $select = 'selected = "selected"';}else{ $select = '';}?>
                            <option <?php echo $select;?> value="product">Sản phẩm</option>
                            <?php if($district == 'service'){ $select1 = 'selected = "selected"';}else{ $select1 = '';}?>
                            <?php if (serviceConfig == 1){?>
                            <option <?php echo $select1;?> value="service">Dịch vụ</option>
                            <?php } ?>
                            <?php if($district == 'coupon'){ $select1 = 'selected = "selected"';}else{ $select1 = '';}?>
                            <option <?php echo $select1;?> value="coupon">Coupon</option>
                            <?php if($district == 'store'){ $select1 = 'selected = "selected"';}else{ $select1 = '';}?>
                            <option <?php echo $select1;?> value="store">Gian hàng</option>
                            <?php if($district == 'agency'){ $select2 = 'selected = "selected"';}else{ $select2 = '';}?>
                            <option <?php echo $select2;?> value="agency">Cộng tác viên online</option>
                            <?php if($district == 'saler'){ $select3 = 'selected = "selected"';}else{ $select3 = '';}?>
                            <option <?php echo $select3;?> value="saler">Gian hàng sỉ</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <input class="form-control" name="key" size="20" placeholder="Nhập từ khóa" type="text" value="<?php echo $keyword;?>">
                    </div>
                    <div class="form-group">
                        <input class="form-control" id="low_price_fake" size="15" placeholder="Giá từ" type="text" value="<?php echo ($this->input->post('low_price'))?$this->input->post('low_price'):''; ?>" <?php echo $readyonly; ?> >
                        <input type="hidden" value="<?php echo ($this->input->post('low_price'))?$this->input->post('low_price'):''; ?>" id="low_price" name="low_price"/>
                    </div>
                    <div class="form-group">
                        <input class="form-control" id="high_price_fake" size="15" placeholder="Giá đến" type="text" value="<?php echo ($this->input->post('high_price'))?$this->input->post('high_price'):''; ?>" <?php echo $readyonly; ?> >
                        <input type="hidden" value="<?php echo ($this->input->post('high_price'))?$this->input->post('high_price'):''; ?>" id="high_price" name="high_price"/>
                    </div>
                    <div class="form-group">
                        <input class="form-control db_input1" id="sale_off" type="checkbox" name="sale_off" <?php echo $sale_off_selected; ?> <?php echo $readonly_sale_off; ?>><label style="vertical-align: sub; margin-top: 10px; " for="sale_off">&nbsp;Khuyến mãi&nbsp;&nbsp;</label>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-azibai">Tìm kiếm</button>
                    </div>
                </form>
                </div>
            </div>
            
            <div class="row">
            <?php if(count($pro_ducts) > 0){?>
                <?php foreach ($pro_ducts as $k => $product) :
                        // by le van son
                        // Calculation discount amount
                        $afSelect = false;
                        $discount = lkvUtil::buildPrice($product, $this->session->userdata('sessionGroup'), $afSelect);
                        ?>
                    <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
                        <?php $this->load->view('home/product/single_product', array('product'=>$product, 'discount'=>$discount)); ?>
                    </div>
                <?php 
                    endforeach;
                } else {
            ?>
            <!-- Tìm theo Cộng tác viên , gian hàng và bán sỹ-->
            <?php
                if($saler != ''){  $list = $saler;  }
                elseif($agency !=''){  $list = $agency;}
                elseif($store != ''){ $list = $store; }
            ?>
            
            <?php if (isset($list) && $list): ?>
                <table class="shop_table table table-bordered" cellpadding="0" cellspacing="0">

                    <tbody><tr class="tr text_title">
                            <td class="col_1 hidden-xs">Stt.</td>
                            <td class="col_2">Logo</td>
                            <td class="col_3">Thông tin gian hàng</td>
                            <td class="col_5 hidden-xs"></td>
                            <td class="col_5 hidden-sm hidden-md hidden-lg">Chi tiết</td>                            
                            <td class="col_4 hidden-xs">Liên hệ, hỗ trợ</td>
                        </tr>
                        
                            <?php foreach ($list as $k => $sho) : ?>
                            <?php $province_name      =   $this->province_model->get('pre_name','pre_id = '.$sho->sho_province); ?>
                        
                            <?php
                            $star = 0;
                                switch($this->shop_model->getShopPackage($sho->sho_user)){
                                    case 3:
                                        $star = 1;
                                        break;
                                    case 4:
                                        $star = 2;
                                        break;
                                    case 5:
                                        $star = 3;
                                        break;
                                    case 6:
                                        $star = 4;
                                        break;
                                    case 7:
                                        $star = 5;
                                        break;
                                }
                            ?>
                            <!--start modal-->
                            <div class="modal fade prod_detail_modal" id="myModal<?php echo $sho->sho_id;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="fa fa-times-circle text-danger"></i></button>
                                    <h4 class="modal-title" id="myModalLabel">Chi tiết gian hàng</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-lg-3 col-xs-4">LOGO</div>
                                        <div class="col-lg-9 col-xs-8">
                                            <a class="picture_x_small" href="<?php echo base_url(). $sho->sho_link; ?>" target="_blank" rel="nofollow">
                                        <?php if($sho->sho_logo): ?>
                                            <img width="80" maxwidth="80" maxheight="80" src="<?php echo base_url().'media/shop/logos/'.$sho->sho_dir_logo.'/'.$sho->sho_logo; ?>" height="60">
                                        <?php else:?>
                                            <img width="80" maxwidth="80" maxheight="80" src="<?php echo base_url().'media/shop/logos/no_photo_x_small.gif';?>" height="60">
                                        <?php endif; ?>
                                    </a>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3 col-xs-4">Tên gian hàng:</div>
                                        <div class="col-lg-9 col-xs-8"><?php echo $sho->sho_name;  ?></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3 col-xs-4">Địa chỉ:</div>
                                        <div class="col-lg-9 col-xs-8"> <?php echo $sho->sho_address; ?></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3 col-xs-4">Điện thoại</div>
                                        <div class="col-lg-9 col-xs-8"><span class="product_price"><?php echo $sho->sho_mobile; ?></span>
                                        </div>
                                    </div>
                                     <div class="row">
                                        <div class="col-lg-3 col-xs-4">Sản phẩm:</div>
                                        <div class="col-lg-9 col-xs-8"><span class="product_price"><b class="count">~<?php echo $sho->sho_quantity_product;?> </b> </span>
                                        </div>
                                    </div>
                                     <div class="row">
                                        <div class="col-lg-3 col-xs-4">Logo gian hàng:</div>
                                        <div class="col-lg-9 col-xs-8" title="Gian hàng được đảm bảo" class="_verified hidden-xs">
                                        <?php if($this->shop_model->getShopPackage($sho->sho_user) == 2){ ?>
                                            <img src="<?php echo base_url(); ?>templates/home/images/icon_chuyennghiep.png" alt="gian hàng chuyên nghiệp" />
                                        <?php } ?>
                                        <?php if($star > 0): ?>
                                            <img src="<?php echo base_url(); ?>templates/home/images/icon_estore_verified.png" alt="gian hàng đảm bảo" /><br/>
                                            <?php
                                            //$star = 6;
                                                $k = 0;
                                                while($k < $star){
                                                    echo '<i class="fa fa-star icon-star-a"></i>';
                                                    $k++;
                                                }
                                            ?>
                                        <?php endif; ?></div>
                                    </div>
                                    

                                </div>
                            </div>
                        </div>
                    </div>
                            <!--end modal-->
                            <tr class="tr">
                                <td class="col_1 hidden-xs"><div class="No"><?php echo ++$k; ?></div></td>
                                <td class="col_2">
                                    <a class="picture_x_small" href="<?php echo base_url(). $sho->sho_link; ?>" target="_blank" rel="nofollow">
                                        <?php if($sho->sho_logo): ?>
                                            <img width="80" maxwidth="80" maxheight="80" src="<?php echo base_url().'media/shop/logos/'.$sho->sho_dir_logo.'/'.$sho->sho_logo; ?>" height="60">
                                        <?php else:?>
                                            <img width="80" maxwidth="80" maxheight="80" src="<?php echo base_url().'media/shop/logos/no_photo_x_small.gif';?>" height="60">
                                        <?php endif; ?>
                                    </a>
                                </td>
                                <td class="col_3">
                                    
                                    
                                    <div class="company_name">
                                        <a class="text_link" href="<?php echo base_url(). $sho->sho_link; ?>" target="_blank" rel="nofollow">
                                            <?php echo $sho->sho_name; ?>
                                        </a>
                                    </div>
                                    <div class="address"><?php echo $sho->sho_address; ?><b>&nbsp;(<?php echo $province_name->pre_name;?>)</b></div>
                                    <div class="count_product">Có <b class="count">~<?php echo $sho->sho_quantity_product;?></b> sản phẩm trong <b>Gian hàng</b></div>
                                    <div class="clear"></div>
                                </td>
                                <td class="col_5">
                                    <div class="hidden-sm hidden-md hidden-lg">
                                        <button type="button" class="btn btn-default1" data-toggle="modal" data-target="#myModal<?php echo $sho->sho_id?>">
                                    <i class="fa fa-newspaper-o"></i>
                                </button>
                                    </div>
                                    <div title="Gian hàng được đảm bảo" class="_verified hidden-xs">
                                        <?php if($this->shop_model->getShopPackage($sho->sho_user) == 2){ ?>
                                            <img src="<?php echo base_url(); ?>templates/home/images/icon_chuyennghiep.png" alt="gian hàng chuyên nghiệp" />
                                        <?php } ?>
                                        <?php if($star > 0): ?>
                                            <img src="<?php echo base_url(); ?>templates/home/images/icon_estore_verified.png" alt="gian hàng đảm bảo" /><br/>
                                            <?php
                                            //$star = 6;
                                                $k = 0;
                                                while($k < $star){
                                                    echo '<i class="fa fa-star icon-star-a"></i>';
                                                    $k++;
                                                }
                                            ?>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td class="col_4 hidden-xs">
                                    <div class="phone">Điện thoại : <?php echo $sho->sho_mobile; ?></div>
                                    <div class="website">
                                        <a class="text_link_2" href="<?php if (strpos($sho->sho_website,'http://')){ echo $sho->sho_website; }else{ echo 'http://'.$sho->sho_website;} ?>" target="_blank" rel="nofollow"><?php echo $sho->sho_website; ?></a></div></td>
                                </tr>
                            <?php endforeach; ?>
                    <style>
                        ._verified{
                         text-align: center;   
                        }
                    </style>
                    </tbody>
                </table>
            <?php else:?>
                <div style="border:1px solid #ccc;border-radius: 1px;text-align:center;padding: 10px 0;font-weight: bold;margin: 1px 15px;">Không có dữ liệu.</div>
            <?php endif;?>
                <?php }?>
            
            <div class="row" style="min-height:420px;">
                <div class="col-lg-12 text-center db_page">
                    <?php if((count($list) == 0 && count($pro_ducts) == 0) || ( count($list) == 0 && count($pro_ducts) != 0) ||( count($list) != 0 && count($pro_ducts) == 0)){
                     //   echo '<span class="text-center text-primary">Không có dữ liệu...</span>';
                    }?>
                    <?php echo $linkPage;?>
                </div>
            </div>
        </div>
    </div>
    </div>
    <style>
    .form-inline .form-control{border-color: #66afe9;}
    input[type="file"]:focus, input[type="radio"]:focus, input[type="checkbox"]:focus{outline: medium none;}
    </style>
    <script src="<?php echo base_url().'templates/home/js/autoNumeric.js';?>"></script> 
    <script type="text/javascript">
    $(document).ready(function($) {
        $('.pagination a').click(function () {
            var link = $(this).get(0).href;
            var form = $('#formsearch');
            form.attr('action', link);
            form.submit();
            return false;
        });
        $('#low_price_fake').autoNumeric('init',{aSign:'',mDec:0, pSign:'s' });
        $("#low_price_fake").blur(function() {
            document.getElementById("low_price").value = UnFormatNumber($('#low_price_fake').val());
        });

        $('#high_price_fake').autoNumeric('init',{aSign:'',mDec:0, pSign:'s' });
        $("#high_price_fake").blur(function() {
            document.getElementById("high_price").value = UnFormatNumber($('#high_price_fake').val());
        });

        $('#district').change(function(){
            var dis  = $("#district").val();
            if(dis == "product" || dis == 'service' || dis == 'coupon'){
                $("#low_price_fake").removeAttr('readonly');
                $("#high_price_fake").removeAttr('readonly');
                document.getElementById("sale_off").disabled = false;
            } else {
                $("#low_price_fake").attr('readonly','true');
                $("#high_price_fake").attr('readonly','true');
                document.getElementById("sale_off").disabled = true;
            }
        });
        $('#province').change(function(){
            $.ajax({
                url     : siteUrl  +'save-province',
                type    : 'post',
                data    : {province: $("#province").val()}
            }).done(function(response) {
                if(response == "1"){

                } else {
                    alert("Lỗi trình duyệt! Vui lòng xóa cache");return false;
                }
            });
        });
    });

    function UnFormatNumber(x) {
        if (typeof x === "undefined") {
            return '';
        } else {
        return x.toString().replace(/,|VNĐ|\s/g, "");
        }
    };
    $('.lazy').lazy();
    </script>
</div>
<!-- END CENTER-->
<?php //$this->load->view('home/common/right'); ?>
<?php $this->load->view('home/common/footer'); ?>