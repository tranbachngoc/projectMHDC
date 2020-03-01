<?php  $this->load->view('home/common/account/header'); ?>
<script>
    function Showhomepage(siteUrl, ishome, id){
        console.log(data);
        jQuery.ajax({
            type: "POST",
            url: siteUrl+"account/affiliate/myproducts",
            dataType: 'json',
            data: {ishome: ishome, proid:id},
            success: function (data) {
                if(data == '1'){
                    location.reload();
                }else{
                    alert('Có lỗi xảy ra!');
                }
            }
        });
    }
</script>
<style>
    .alert-danger {
        overflow: hidden;
        color: #d08701 !important;
        background-color: rgba(226, 213, 55, 0.45) !important;
        border-color: rgba(204, 204, 93, 0.6) !important;

    }
    .box_CHHoahong {
        overflow: hidden;
        width: 100%;
        border: 1px solid #d8d89a;
        padding: 10px;
        background: #f7f7b7;
        margin-bottom: 15px;
        border-radius: 8px;
        padding-left: 20px;
    }
</style>
<div class="container-fluid">
    <div class="row">
        <?php $this->load->view('home/common/left'); ?>
        <!--BEGIN: RIGHT-->
        <div class="col-md-9 col-sm-8 col-xs-12">
            <h4 class="page-header text-uppercase" style="margin-top:10px">
                TÌM & CHỌN SẢN PHẨM BÁN
            </h4>

            <div style="width:100%; overflow-y: auto;">
                <form name="frmAccountPro" id="frmAccountPro" action="<?php echo $link; ?>" method="post">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">                                    
                                    <?php if ($this->uri->segment(3) != 'myproducts') { ?>
                                        <div class="select_div" id="category_pro_0">
                                            <select id="cat_pro_0"  onchange="check_postCategoryProduct(this.value,0,'<?php echo base_url(); ?>');" name="cat_pro_0" class="form-control form_control_cat_select">
                                                <option class="text-primary" value="">--Chọn danh mục tìm kiếm--</option>
                                                <?php if (isset($childcat)) {
                                                    foreach ($childcat as $item) {
                                                        ?>
                                                        <option <?php echo (isset($filter['cat_pro_0']) && $item->cat_id == $filter['cat_pro_0']) ? 'selected="selected"' : ''; ?> value="<?php echo $item->cat_id; ?>" <?php echo (isset($arra_cat[0]) && $arra_cat[0] == $item->cat_id) ? 'selected="selected"' : '';?> ><?php echo $item->cat_name; ?><?php if ($item->child_count > 0) {
                                                                echo ' >';
                                                            } ?></option>
                                                    <?php }
                                                } ?>
                                            </select>
                                        </div>
                                        <div class="select_div" id="category_pro_1"></div>
                                        <div class="select_div" id="category_pro_2"></div>
                                        <div class="select_div" id="category_pro_3"></div>
                                        <div class="select_div" id="category_pro_4"></div>                                        
                                    <?php } ?>
                                    </div>                                    
                                </div>                                    
                                <div class="col-sm-4">
                                    <div class="form-group">   
                                        <select name="product_type" id="product_type" class="form-control" style="width: 100%">
                                            <option <?php echo (isset($filter['product_type']) && $filter['product_type'] == 0) ? 'selected = "selected"' : ''; ?> value="0">Sản phẩm</option>
                                            <?php if ( serviceConfig == 1){ ?>
                                                <option <?php echo (isset($filter['product_type']) && $filter['product_type'] == 1) ? 'selected = "selected"' : ''; ?> value="1">Dịch vụ</option>
                                            <?php } ?>
                                            <option <?php echo (isset($filter['product_type']) && $filter['product_type'] == 2) ? 'selected = "selected"' : ''; ?> value="2">Coupon</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <input class="inputfilter_account form-control" type="text" name="q" value="<?php echo $filter['q']; ?>" placeholder="Từ khóa ...">
                                    </div>
                                </div>
                                <?php if ($this->uri->segment(3) != 'myproducts') { ?>
                                    <div  style="display: none" class="checkbox">
                                        <label>
                                            <input type="checkbox" <?php if($numberMyProduct <= 0){ ?><?php } ?> name="no_store" id="no_store" value="1" <?php if( isset($filter['no_store']) && $filter['no_store'] == 1){echo 'checked="checked"';}?> /> Danh mục miễn phí
                                        </label>
                                    </div>
                                <?php } ?>                        
                            </div>
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <?php $priceType =array('1'=>'Giá', '2'=>'Hoa hồng (số tiền)', '3'=>'Hoa hồng(%');?>
                                        <select name="price_type" class="form-control">
                                            <?php foreach($priceType as $k => $val):?>
                                                <option <?php echo (isset($filter['price_type']) && $filter['price_type'] == $k) ? 'selected="selected"': '';?> value="<?php echo $k;?>"><?php echo $val;?></option>
                                            <?php endforeach;?>
                                        </select>
                                    </div>    
                                </div>    
                                <div class="col-sm-2">    
                                    <div class="form-group">
                                        <input placeholder="Từ" class="form-control" type="text" name="pf" value="<?php echo $filter['pf']; ?>"/>
                                    </div>    
                                </div>    
                                <div class="col-sm-2"> 
                                    <div class="form-group">
                                        <input placeholder="Đến" class="form-control" type="text" name="pt" value="<?php echo $filter['pt']; ?>"/>
                                    </div>    
                                </div>    
                                <div class="col-sm-3">    
                                    <div class="form-group">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="garantee" id="garantee" value="1" <?php if(isset($filter['garantee']) && $filter['garantee'] == 1){echo 'checked="checked"';}?> /> Gian hàng bảo đảm
                                            </label>
                                        </div>
                                    </div>
                                </div>    
                                <div class="col-sm-2">    
                                    
                                        <button type="submit" class="btn btn-primary btn-block">Tìm kiếm</button>
                                        <input type="hidden" name="dir" value="<?php echo (isset($filter['dir']) ? $filter['dir'] : ''); ?>"/>
                                        <input type="hidden" name="sort" value="<?php echo (isset($filter['sort']) ? $filter['sort'] : ''); ?>"/>
                                  
                                </div> 
                            </div>
                        </div>
                    </div>
                    
                    <div class="panel panel-default">
                        <div class="panel-body">                              
                            <div class="box_CHHoahong">
                                <?php if (isset($nullCommissionAff)) { ?>
                                    <div class="message success">
                                        <div class="alert alert-danger">
                                            <?php echo 'Hiện chưa có cấu hình chung các mức thưởng thêm cho Cộng tác viên online.'; ?>
                                            <button type="button" class="close" data-dismiss="alert">×</button>
                                        </div>
                                    </div>
                                <?php } else{?>
                                <div class="muchoahong">
                                    <p><strong style="text-transform: uppercase">Hoa hồng thưởng thêm theo doanh thu</strong></p>
                                    <?php $i = 0;
                                    foreach ($list_commiss_sho as $key => $value) {
                                    $i++; ?>
                                    <div class="col1">Doanh thu từ <b
                                            style="color: red"><?php echo number_format($value['min'], 0, ",", "."); ?></b>
                                        VNĐ đến <b style="color: red"><?php echo number_format($value['max'], 0, ",", "."); ?></b>
                                        VNĐ được thưởng <b style="color: red"><?php echo $value['percent'].'%'; ?></b></div>
                                    <?php }?>
                                </div>
                                <?php }?>
                            </div>
                            <?php if($show_btn == 1){ ?>
                                <div>
                                    <button id="pro_store" class="btn <?php if(isset($filter['no_store']) && $filter['no_store'] == 1){echo 'btn-default';} else{ echo  'btn-default1';}?>" type="submit">Sản phẩm từ Gian hàng công ty bạn</button>
                                    <button id="pro_nostore" class="btn <?php if(isset($filter['no_store']) && $filter['no_store'] == 1){echo 'btn-default1';} else{ echo  'btn-default';}?>" type="submit">Sản phẩm từ danh mục miễn phí và có phí</button>
                                </div>                                    
                            <?php }?>
                        </div>
                    </div>
                    <?php if($this->uri->segment(3)=='products') {$col = 9;} else { $col = 6; } ?>
                    <table class="table table-bordered afBox">                        
                        <?php if(count($products) > 0){ ?>
                        <thead>
                            <tr>
                                <th width="3%" class="aligncenter hidden-xs">
                                    <input type="checkbox" onclick="DoCheck(this.checked,'frmAccountPro',0)"
                                           value="0" id="checkall" name="checkall"></th>
                                <th width="15%" class="aligncenter hidden-xs">Sản phẩm</th>

                                <th class="text-center  hidden-xs" width="18%">Giá bán 
                                    <a href="<?php echo $sort['price']['asc']; ?>">
                                        <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" border="0"
                                             style="cursor:pointer;" alt=""/>
                                    </a>
                                    <a href="<?php echo $sort['price']['desc']; ?>">
                                        <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" border="0"
                                             style="cursor:pointer;" alt=""/>
                                    </a>
                                </th>
                                <th class="text-center  hidden-xs">Sản phẩm của Gian hàng 
                                    <a href="<?php echo $sort['shop']['asc']; ?>">
                                        <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" border="0"
                                             style="cursor:pointer;" alt=""/>
                                    </a>
                                    <a href="<?php echo $sort['shop']['desc']; ?>">
                                        <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" border="0"
                                             style="cursor:pointer;" alt=""/>
                                    </a>
                                </th>
                                <?php if ($this->uri->segment(3) == 'myproducts') : ?>
                                    <td class="text-center hidden-xs">Link Affiliate</td>
                                <?php endif; ?>
                                <?php if ($this->uri->segment(3) == 'myproducts') : ?>
                                    <td class="text-center hidden-xs">Chọn bán</td>
                                <?php endif; ?>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            $stt = 0;
                        foreach ($products as $k => $product):
                            $stt++; ?>
                            <?php
                            $group_id = (int)$this->session->userdata('sessionGroup');
                            $protocol = "http://"; //(!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
                            $domainName = $_SERVER['HTTP_HOST'];
                            $link_shop = $protocol.$product['linkshop'].'.'.$domainName;
                            if($product['domain'] != ''){
                                $link_shop = $protocol.$product['domain'];
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
                                                <div class="col-lg-3 col-xs-4">Tên SP:</div>
                                                <div class="col-lg-9 col-xs-8"><?php echo $product['pro_name']; ?></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-3 col-xs-4">Giá SP:</div>
                                                <div class="col-lg-9 col-xs-8"><span  class="product_price"><?php echo number_format($product['pro_cost'], 0, ",", ".") . ' VND';?></span>
                                                </div>
                                            </div>                                            
                                            <div class="row">
                                                <div class="col-lg-3 col-xs-4">Hoa hồng</div>
                                                <div class="col-lg-9 col-xs-8">
                                                <span class="product_price_green">
                                                    <?php
                                                    if ($product['af_rate'] > 0) {
                                                        echo  $product['af_rate'] . '%';
                                                    }elseif ($product['af_amt'] > 0) {
                                                        echo number_format($product['af_amt'], 0, ',', '.');
                                                    } else {
                                                        echo "";
                                                    }
                                                    ?>
                                                </span>
                                                </div>
                                            </div>                                            
                                            <div class="row">
                                                <div class="col-lg-3 col-xs-4">Gian hàng:</div>
                                                <div class="col-lg-9 col-xs-8"> <?php echo $product['nameshop'];?></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-3 col-xs-4">Chọn bán:</div>
                                                <div class="col-lg-9 col-xs-8">
                                                    <?php if($product['isselect'] == true):?>
                                                        <a class="chooseItem selected" href="javascript:void(0);"
                                                           title="Hủy chọn bán"><img
                                                                src="<?php echo base_url(); ?>templates/home/images/public.png"
                                                                style="cursor:pointer;" border="0"
                                                                alt="Hủy chọn bán"/></a>
                                                    <?php else:?>.
                                                        <a class="chooseItem" href="javascript:void(0);"
                                                           title="Chọn bán"><img
                                                                src="<?php echo base_url(); ?>templates/home/images/unpublic.png"
                                                                style="cursor:pointer;" border="0"
                                                                alt="Chọn bán"/></a>
                                                    <?php endif;?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <tr  id="af_row_<?php echo $product['pro_id'];?>">
                                <td class="aligncenter hidden-xs" >
                                    <?php echo $stt + $num; ?>
                                    <input type="checkbox" onclick="DoCheckOne('frmAccountPro')"
                                           value="<?php echo $product['pro_id'];?>"
                                           id="checkone" name="checkone[]">
                                </td>
                                <td class="img_prev text-center" style="padding:10px;">
                                    <?php
                                    $proimg = explode(',', $product['pro_image']);
                                    $filename = 'media/images/product/'.$product['pro_dir'].'/thumbnail_1_'.$proimg[0];
                                    $imglager = 'media/images/product/'.$product['pro_dir'].'/thumbnail_3_'.$proimg[0];
                                    if($proimg[0] != ''){ // file_exists($filename) && ?>
                                        <a rel="tooltip" data-placement="auto right" data-toggle="tooltip" data-html="true" data-original-title="<img src='<?php echo DOMAIN_CLOUDSERVER.$imglager; ?>' />">
                                            <img width="225" src = "<?php echo DOMAIN_CLOUDSERVER . $filename ?>" alt = "" class="img-responsive" style="margin: 0 auto;">
                                        </a>
                                    <?php }else{?>
                                        <img width="225" src="<?php echo base_url() ;?>media/images/noimage.png" alt = "" class="img-responsive" style="margin: 0 auto;">
                                    <?php }  ?>
                                    <p><a target="_blank" href="<?php echo $link_shop; ?>/shop/product/detail/<?php echo $product['pro_id']; ?>/<?php echo RemoveSign($product['pro_name']); ?>"><?php echo $product['pro_name'];?></a></p>
                                    <span class="product_price visible-xs"><?php echo number_format($product['pro_cost'], 0, ",", ".") . ' đ';?></span>
                                    <p class="visible-xs">Hoa hồng: <span class="product_price_green">
								<?php
                                if ($product['af_amt'] > 0) {
                                    echo number_format($product['af_amt'], 0, ',', '.').' đ';
                                } elseif ($product['af_rate'] > 0) {
                                    echo $product['af_rate'] . '%';
                                }
                                ?>
									</span>
                                    </p>
                                    <div class="visible-xs">
                                        <?php if($product['isselect'] == true): ?>
                                            <a id="catid_<?php echo $product['pro_category'];?>" class="chooseItem selected" href="javascript:void(0);"
                                               title="Hủy chọn bán"><img
                                                    src="<?php echo base_url(); ?>templates/home/images/public.png"
                                                    style="cursor:pointer;" border="0"
                                                    alt="Hủy chọn bán"/></a>
                                        <?php else: ?>
                                            <a id="catid_<?php echo $product['pro_category'];?>" class="chooseItem" href="javascript:void(0);"
                                               title="Chọn bán">
                                                <span class="selected  btn btn-primary"><i class="fa fa-check"></i> Chọn bán</span>
                                            </a>
                                        <?php endif; ?>
                                        
                                            <button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal<?php echo $k;?>">
                                                <i class="fa fa-newspaper-o"></i> Chi tiết
                                            </button>
                                        
                                    </div>
                                </td>
                                <td align="left" class="hidden-xs">
                                    <span class="product_price"><?php echo number_format($product['pro_cost'], 0, ",", ".") . ' đ';?></span>
                                    <p>Hoa hồng: <span class="product_price_green">
								<?php
                                if ($product['af_amt'] > 0) {
                                    echo number_format($product['af_amt'], 0, ',', '.').' đ';
                                } elseif ($product['af_rate'] > 0) {
                                    echo $product['af_rate'] . '%';
                                }
                                ?>
									</span>
                                    </p>
                                </td>                                
                                <td class="hidden-xs">
                                    <a target="_blank" href="<?php echo $link_shop; ?>/shop"><?php echo $product['nameshop'];?></a>
                                </td>
                                <?php if ($this->uri->segment(3) == 'myproducts') { ?>
                                    <td class="hidden-xs"><a href="javascript:void(0);" onclick="copylink('<?php echo $product['link']; ?>');">Copy Link</a></td><?php } ?>
                                <td class="hidden-xs">
                                    <?php if($product['isselect'] == true):?>
                                        <a id="catid_<?php echo $product['pro_category'];?>" class="chooseItem selected" href="javascript:void(0);"
                                           title="Hủy chọn bán"><img
                                                src="<?php echo base_url(); ?>templates/home/images/public.png"
                                                style="cursor:pointer;" border="0"
                                                alt="Hủy chọn bán"/></a>
                                    <?php else: ?>
                                        <a id="catid_<?php echo $product['pro_category'];?>" class="chooseItem" href="javascript:void(0);"
                                           title="Chọn bán">
                                            <?php if(isset($_REQUEST['no_store']) && $_REQUEST['no_store'] == 1){ ?>
                                            <!-- <span class="selected  btn btn-primary">Chọn bán</span> -->
                                            <span class="btn btn-primary">Chọn bán</span>
                                            <?php } ?>
                                    <?php endif; ?>
                                    <p class="hidden-md hidden-lg" >
                                        <button type="button" class="btn btn-default1" data-toggle="modal" data-target="#myModal<?php echo $k;?>">
                                            <i class="fa fa-newspaper-o"></i>
                                        </button>
                                    </p>
                                    <p class="hidden-md hidden-lg">
                                        <a href="javascript:void(0);" onclick="copylink('<?php echo $product['link']; ?>');">Copy Link</a>
                                    </p>
                                </td>
                                <?php if ($this->uri->segment(3) == '___myproducts') :
                                 ?>
                                    <td>
                                        <?php if($product['homepage'] == 0){ ?>
                                            <span onclick="Showhomepage('<?php echo base_url();?>', 1,<?php echo  $product['pro_id']; ?>);" class="notishome btn btn-primary"><i class="fa fa-plus"></i></span>
                                        <?php }else{ ?>
                                            <span onclick="Showhomepage('<?php echo base_url();?>', 0,<?php echo  $product['pro_id']; ?>);" class="ishome btn btn-primary"><i class="fa fa-check"></i></span>
                                        <?php } ?>
                                    </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; ?>
                        <tr>
                            <td colspan="<?php echo $col;?>">
                                <span class="selected btn btn-azibai  hidden-xs">Chọn bán</span>
                                <span class="unchoose btn btn-default  hidden-xs" >Hủy bán</span>
                            </td>
                        </tr>
                        <?php }else{ ?>
                            <tr>
                                <td colspan="<?php echo $col;?>" align="center">
                                    <?php if ($this->uri->segment(3) == 'products') { ?>
                                        <?php if(isset($filter['no_store']) && $filter['no_store'] == 1){ ?>
                                            <div class="nojob alert alert-info">Không có sản phẩm nào!

                                            </div>
                                        <?php  }else{  ?>
                                            <div class="nojob alert alert-info">Không còn sản phẩm nào từ Gian hàng công ty bạn!
                                                <br> Bạn có thể chọn thêm sản phẩm từ 1 Danh mục miễn phí Azibai tặng bằng cách click vào <b>"Sản phẩm từ danh mục miễn phí và có phí"</b> ở phí trên.
                                                <br/>Hoặc bạn có thể mua thêm dịch vụ Kệ hàng trong phần <a href="<?php echo base_url(); ?>account/service">Dịch vụ Azibai</a> để có thể gắp thêm sản phẩm từ nhiều Danh mục khác.
                                            </div>
                                        <?php } ?>
                                    <?php } ?>
                                    <?php if ($this->uri->segment(3) == 'myproducts') { ?>
                                        <div class="nojob alert alert-info">Không có sản phẩm nào!

                                        </div>
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>

                </form>
                <?php echo $pager; ?>
            </div>           
            <div class="noshop" style="display:none;">
                Bạn chưa cài đặt Gian hàng, vui lòng cài đặt <a href="<?php echo base_url(); ?>account/shop">tại đây</a> để sử dụng tính năng này.
            </div>            
        </div>
    </div>
</div>
<?php $this->load->view('home/common/footer'); ?>
<?php if ($this->uri->segment(3) == 'products') { ?>
    <script>
        jQuery(document).ready(function(jQuery) {
            $("#pro_nostore").click(function(ev){
                $("#pro_store").removeClass('btn-default1');
                $(this).addClass('btn-default1');
                var ischeck = $('#no_store').attr('disabled');
                $('#no_store').prop('checked', true);
            });
            $("#pro_store").click(function(){
                $("#pro_nostore").removeClass('btn-default1');
                $(this).addClass('btn-default1');
                $('#no_store').prop('checked',false);
            });
            var dem_pro = 0;
            $('.chooseItem').click(function(){
                dem_pro ++;
                if(dem_pro == 1){
                    $('#no_store').removeAttr('disabled');
                    if( $('#no_store').attr('disable') == false) {
                        $.jAlert({
                            'title': 'Thông báo!',
                            'content': 'Azibai tặng bạn thêm 1 Danh mục, bạn có thể gắp thêm 8 sản phẩm trong đó!',
                            'theme': 'default',
                            'btns': {
                                'text': 'Đóng', 'theme': 'blue', 'onClick': function (e, btn) {
                                    e.preventDefault();
                                    $('#no_store').focus();
                                    dem_pro = 0;
                                    return false;
                                }
                            }
                        });
                    }
                }
            });
        });
    </script>
<?php }?>
