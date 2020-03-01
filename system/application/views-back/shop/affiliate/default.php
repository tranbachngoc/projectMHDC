<?php $this->load->view('shop/affiliate/header'); ?>
<?php $segment = $this->uri->segment(2); ?>
<style>
    .pagination li span { background: #eee;}
	.nodata { border: 1px solid #ccc; border-top: none; padding: 10px;}
</style>
<div class="container">  
    <div class="row">
        <ol class="breadcrumb" style="margin-top: 20px; border: 1px solid #ccc;">
            <li><a href="/affiliate/news">Trang chủ</a></li>
            <?php if ($this->uri->segment(3) != 'cat') { ?>
                <li><a href="/affiliate/product"><?php echo 'Sản phẩm'; ?></a></li>
                <li><a href="/affiliate/coupon"><?php echo 'Coupon'; ?></a></li>
            <?php } else { ?>
                <li><a href="/affiliate/<?php echo $segment ?>"><?php echo $segment == 'product' ? 'Sản phẩm' : 'Coupon'; ?></a></li>
            <?php } ?>
            <li><?php echo $category->cat_name; ?></li>
        </ol>
    </div>
    
    <div class="row">             
        <div class="col-md-9 col-sm-9 col-xs-12  pull-right">
            <br/>
            <ul class="nav nav-tabs">
                <li class="<?php echo ($segment=='product')?'active':''?>"><a href="/affiliate/product"><strong>Sản phẩm</strong></a></li>
                <li class="<?php echo ($segment=='coupon')?'active':''?>"><a href="/affiliate/coupon"><strong>Phiếu mua hàng</strong></a></li>
            </ul>
            <div class="nodata">
                <div class="row">
                    <form name="formsort">                    
                        <div class="col-xs-6 text-left" style="padding-top: 6px;">
                            <strong class="text-primary"><?php echo $countsr ?></strong>
                        </div> 
                        <div class="col-xs-6 text-right form-inline">
                            <span for="sort">Sắp xếp theo</span>
                            <?php
                            switch($_SERVER['REQUEST_URI']):
                                case "/affiliate/".$urlSort."/sort/id/by/desc":
                                    $selected1 = 'selected';
                                    break;
                                case "/affiliate/".$urlSort."/sort/id/by/asc":
                                    $selected2= 'selected';
                                    break;
                                case "/affiliate/".$urlSort."/sort/price/by/asc":
                                    $selected3 = 'selected';
                                    break;
                                case "/affiliate/".$urlSort."/sort/price/by/desc":
                                    $selected4 = 'selected';
                                    break;
                                default: $selected = ''; 
                                    break;
                            endswitch;
                            ?>
                            <select name="sort" class="form-control" onchange="ActionSort(this.value)">
                                <option value="/affiliate/<?php echo $urlSort ?>"> --Chọn sắp xếp-- </option>
                                <option <?php echo $selected1;?> value="/affiliate/<?php echo $urlSort ?>/sort/id/by/desc">Mới nhất</option>
                                <option <?php echo $selected2;?> value="/affiliate/<?php echo $urlSort ?>/sort/id/by/asc">Cũ nhất</option>
                                <option <?php echo $selected3;?> value="/affiliate/<?php echo $urlSort ?>/sort/price/by/asc">Giá tăng</option>
                                <option <?php echo $selected4;?> value="/affiliate/<?php echo $urlSort ?>/sort/price/by/desc">Giá giảm</option>
                            </select>
                        </div>                    
                    </form>
                </div>
                <br/>
                <?php if($search != ''){ ?>     
                    <div class="filtervia small">
                        Lọc theo: <?php echo $search ?> 
                        <a href="<?php echo '/affiliate/'. $pagecur; ?>">Hủy tìm kiếm</a>
                    </div>
                    <br/>
                <?php } ?>
                <?php if(count($products) > 0){ ?>
                    <div class="row">
                        <?php foreach($products as $key => $item) { 
                            $list_style = $this->detail_product_model->get('id', 'dp_pro_id = '. $item->pro_id);
                        ?>
                            <div class="col-md-3 col-sm-4 col-xs-6">
                                <?php $this->load->view('shop/affiliate/item', array('item' => $item, 'dp' => $list_style, 'shop' => $shop)); ?> 
                            </div>
                        <?php } ?>						
                    </div>

                    <?php if(isset($linkPage)) {  echo $linkPage; } ?>

                <?php } else { ?>
                    Không có dữ liệu
                <?php } ?>
            </div>
        </div>

        <div class="col-md-3 col-sm-3 col-xs-12 pull-left">
           <?php $this->load->view('shop/affiliate/left'); ?> 
        </div>
    </div>
</div>

<script>
    function ActionSort(isAddress,b) {
        window.location.href = isAddress;
    }   

    function addCart(pro_id) {
        showLoading(); 
        $.ajax({
            type: "POST",
            dataType: "json",
            url: '/affiliate/showcart/add',
            data: $('#bt_'+pro_id+' :input').serialize(),
            success: function(result) {
                console.log(result);
                if (result.pro_type != 0 && result.error == false) {                    
                    location.href = '/affiliate/orderv2/' + result.pro_user + '/' + result.pro_type;
                }

                if (result.error == false) {
                    $('.cartNum').text(result.num);
                }

                if (result.message != '') {
                    var type = result.error == true ? 'alert-danger' : 'alert-success';
                    showMessage(result.message, type);
                } else {
                    hideLoading();
                }
            },
            error: function() {}
        });
    }

    function wishlist(proid = 0) {

    }

    function showLoading() {
        $('.loading').show();
        $('#aziload').show();
    }

    function hideLoading() {
        $('#aziload').hide();
    }

    function showMessage(message, type) {
        $('.loading').hide();
        $('#myModal').modal('show');
        $('#myModal .modal-content').html('<div class="alert ' + type + ' alert-dismissible fade in" role="alert"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>' + message + '</div>'); 
    }
</script>

<?php $this->load->view('shop/affiliate/footer'); ?>
