<?php $this->load->view('home/common/account/header'); ?>
<div class="container-fluid">
    <div class="row">
        <?php $this->load->view('home/common/left'); ?>
        <!--BEGIN: RIGHT-->
        <div id="af_products" class="col-lg-9 col-md-9 col-sm-8 col-xs-12">
            <h4 class="page-header text-uppercase" style="margin-top:10px">SẢN PHẨM KÝ GỬI QUA CÔNG TÁC VIÊN</h4>
            
            <?php if ($shopid > 0) { ?>
                <?php if (count($products) > 0){ ?>
                <div style="width:100%; overflow-y: auto;">
                    <form name="frmAccountPro" id="frmAccountPro" action="<?php echo $link; ?>" method="post">
                        <div class="panel panel-default panel-custom">
                            <div class="panel-body">
                                <div class="form-inline">
                                    <div class="form-group">
                                        <input class="inputfilter_account form-control padding-button" type="text"
                                               name="q" value="<?php echo $filter['q']; ?>" placeholder="Từ khóa ...">
                                    </div>
                                    <div class="form-group">
                                        <?php $priceType = array('1' => 'Giá tiền', '2' => 'Hoa hồng (số tiền)', '3' => 'Hoa hồng(%'); ?>
                                        <select name="price_type" class="form-control">
                                            <?php foreach ($priceType as $k => $val): ?>
                                                <option <?php echo $filter['price_type'] == $k ? 'selected="selected"' : ''; ?>
                                                    value="<?php echo $k; ?>"><?php echo $val; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <input placeholder="Từ" class="form-control padding-button" type="text"
                                               name="pf" value="<?php echo $filter['pf']; ?>"/>                                    
                                    </div>
                                    <div class="form-group">
                                        <input placeholder="Đến" class="form-control padding-button" type="text"
                                               name="pt" value="<?php echo $filter['pt']; ?>"/>
                                    </div>
                                    <div class="form-group">    
                                        <button type="submit" class="btn btn-primary padding-button">Tìm kiếm</button>                                        
                                        <input type="hidden" name="dir" value="<?php echo $filter['dir']; ?>"/>
                                        <input type="hidden" name="sort" value="<?php echo $filter['sort']; ?>"/>
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
                        
                        <table class="table table-bordered afBox">
                            
                            <thead>
                            <tr>
                                <th width="3%" class="aligncenter hidden-xs">
                                    STT
                                </th>
                                <th width="5%" class="aligncenter hidden-xs">Hình ảnh</th>
                                <th width="22%" class="text-center">Tên sản phẩm <br/>
                                    <a href="<?php echo $sort['name']['asc']; ?>">
                                        <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif"
                                             border="0"
                                             style="cursor:pointer;" alt=""/>
                                    </a>
                                    <a href="<?php echo $sort['name']['desc']; ?>">
                                        <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif"
                                             border="0"
                                             style="cursor:pointer;" alt=""/>
                                    </a>
                                </th>
                                <th class="text-center" width="12%">Giá<br/>
                                    <a href="<?php echo $sort['price']['asc']; ?>">
                                        <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif"
                                             border="0"
                                             style="cursor:pointer;" alt=""/>
                                    </a>
                                    <a href="<?php echo $sort['price']['desc']; ?>">
                                        <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif"
                                             border="0"
                                             style="cursor:pointer;" alt=""/>
                                    </a>
                                </th>
                                <th class="text-center">Hoa hồng(đ)<br/>
                                    <a href="<?php echo $sort['af_amt']['asc']; ?>">
                                        <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif"
                                             border="0"
                                             style="cursor:pointer;" alt=""/>
                                    </a>
                                    <a href="<?php echo $sort['af_amt']['desc']; ?>">
                                        <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif"
                                             border="0"
                                             style="cursor:pointer;" alt=""/>
                                    </a>
                                </th>
                                <th class="text-center">Hoa hồng %<br/>
                                    <a href="<?php echo $sort['af_rate']['asc']; ?>">
                                        <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif"
                                             border="0"
                                             style="cursor:pointer;" alt=""/>
                                    </a>
                                    <a href="<?php echo $sort['af_rate']['desc']; ?>">
                                        <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif"
                                             border="0"
                                             style="cursor:pointer;" alt=""/>
                                    </a>
                                </th>
                                <th class="text-center hidden-xs">Danh mục<br/>
                                    <a href="<?php echo $sort['cat']['asc']; ?>">
                                        <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif"
                                             border="0"
                                             style="cursor:pointer;" alt=""/>
                                    </a>
                                    <a href="<?php echo $sort['cat']['desc']; ?>">
                                        <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif"
                                             border="0"
                                             style="cursor:pointer;" alt=""/>
                                    </a>
                                </th>
                                <th class="text-center  hidden-xs">Gian hàng<br/>
                                    <a href="<?php echo $sort['shop']['asc']; ?>">
                                        <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif"
                                             border="0"
                                             style="cursor:pointer;" alt=""/>
                                    </a>
                                    <a href="<?php echo $sort['shop']['desc']; ?>">
                                        <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif"
                                             border="0"
                                             style="cursor:pointer;" alt=""/>
                                    </a>
                                </th>
                                <?php if ($this->uri->segment(3) == 'pressproducts') : ?>
                                    <th class="text-center hidden-xs">Link Affiliate</th>
                                <?php endif; ?>
                                    
                                <th class="text-center">Ngày hết hạn</th>
                            </tr>
                            </thead>
                            
                            <tbody> 
                            <?php foreach ($products as $k => $product): ?>
                                <!-- Modal -->
                                <div class="modal fade prod_detail_modal" id="myModal<?php echo $k; ?>" tabindex="-1"
                                     role="dialog" aria-labelledby="myModalLabel">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close"><i
                                                        class="fa fa-times-circle text-danger"></i></button>
                                                <h4 class="modal-title" id="myModalLabel">Chi tiết sản phẩm</h4>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-lg-3 col-xs-4">Tên SP:</div>
                                                    <div
                                                        class="col-lg-9 col-xs-8"><?php echo $product['pro_name']; ?></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-3 col-xs-4">Giá SP:</div>
                                                    <div class="col-lg-9 col-xs-8"><span
                                                            class="product_price"><?php echo number_format($product['pro_cost'], 0, ",", ".") . ' VND'; ?></span>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-3 col-xs-4">Hoa hồng(VND):</div>
                                                    <div class="col-lg-9 col-xs-8">
                                                <span class="product_price_green">
                                                    <?php
                                                    if ($product['af_amt'] > 0) {
                                                        echo number_format($product['af_amt'], 0, ',', '.') . " VND ";
                                                    }; ?>
                                                </span>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-3 col-xs-4">Hoa hồng(%):</div>
                                                    <div class="col-lg-9 col-xs-8">
                                                <span class="product_price_green">
                                                    <?php
                                                    if ($product['af_rate'] > 0) {
                                                        echo $product['af_rate'] . '%';
                                                    }; ?>
                                                </span>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-3 col-xs-4">Danh mục:</div>
                                                    <div
                                                        class="col-lg-9 col-xs-8"><?php echo $product['cName']; ?></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-3 col-xs-4">Gian hàng:</div>
                                                    <div
                                                        class="col-lg-9 col-xs-8"> <?php echo $product['nameshop']; ?></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-3 col-xs-4">Chọn bán:</div>
                                                    <div class="col-lg-9 col-xs-8">
                                                        <?php if ($product['isselect'] == true): ?>
                                                            <img
                                                                src="<?php echo base_url(); ?>templates/home/images/public.png"
                                                                style="cursor:pointer;" border="0"
                                                                alt="Hủy chọn bán"/>

                                                        <?php else: ?>
                                                            <img
                                                                src="<?php echo base_url(); ?>templates/home/images/unpublic.png"
                                                                style="cursor:pointer;" border="0"
                                                                alt="Chọn bán"/>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <tr id="af_row_<?php echo $product['pro_id']; ?>">
                                    <td class="aligncenter hidden-xs">
                                        <?php echo $k + 1 ?>
                                    </td>
                                    <td class="img_prev">
                                        <?php
                                        $proimg = explode(',', $product['pro_image']);
                                        $filename = $imglager = 'media/images/product/' . $product['pro_dir'] . '/thumbnail_3_' . $proimg[0];
                                        if ($proimg[0] != '') { //file_exists($filename) && 
                                            ?>
                                            <a rel="tooltip" data-toggle="tooltip" data-placement="auto right"
                                               data-html="true"
                                               data-original-title="<img src='<?php echo DOMAIN_CLOUDSERVER . $imglager; ?>' />">
                                                <img width="60"
                                                     src="<?php echo DOMAIN_CLOUDSERVER . $filename ?>" alt="">
                                            </a>
                                        <?php } else {
                                            ?>
                                            <img width="60"
                                                 src="<?php echo base_url(); ?>media/images/noimage.png" alt="">
                                        <?php } ?>
                                    </td>
                                    <td><a target="_blank"
                                           href="<?php echo base_url(); ?><?php echo $product['pro_category']; ?>/<?php echo $product['pro_id']; ?>/<?php echo RemoveSign($product['pro_name']); ?>"><?php echo $product['pro_name']; ?></a>
                                    </td>
                                    <td align="right"><span
                                            class="product_price"><?php echo number_format($product['pro_cost'], 0, ",", ".") . ' đ'; ?></span>
                                    </td>
                                    <td align="right"><span class="product_price_green">
                                            <?php
                                            if ($product['af_amt'] > 0) {
                                                echo number_format($product['af_amt'], 0, ',', '.') . " đ";
                                            }; ?>
                                        </span>
                                    </td>
                                    <td><span class="product_price_green">
                                        <?php
                                        if ($product['af_rate'] > 0) {
                                            echo $product['af_rate'] . '%';
                                        }; ?>
                                         </span>
                                    </td>
                                    <td class="  hidden-xs">
                                        <a target="_blank"
                                           href="<?php echo base_url(); ?><?php echo $product['pro_category']; ?>/<?php echo RemoveSign($product['cName']); ?>"><?php echo $product['cName']; ?></a>
                                    </td>
                                    <td class="hidden-xs">
                                        <a href="<?php echo base_url(); ?><?php echo $product['linkshop']; ?>"><?php echo $product['nameshop']; ?></a>
                                    </td>
                                    <?php if ($this->uri->segment(3) == 'pressproducts') { ?>
                                        <td class="hidden-xs"><a href="javascript:void(0);"
                                                                 onclick="copylink('<?php echo $product['link']; ?>');">Copy
                                            Link</a></td><?php } ?>
                                    <td>
                                        <?php
                                        if ($product['begin_date'] >= date('Y-m-d')) {
                                            echo date('d-m-Y', strtotime($product['begin_date']));
                                        } else {
                                            echo '<span class="text-danger"><b> Hết hạn</b></span>';
                                        } ?>
                                        <p class="hidden-md hidden-lg">
                                            <button type="button" class="btn btn-default1" data-toggle="modal"
                                                    data-target="#myModal<?php echo $k; ?>">
                                                <i class="fa fa-newspaper-o"></i>
                                            </button>
                                        </p>
                                        <p class="hidden-md hidden-lg">
                                            <a href="javascript:void(0);"
                                               onclick="copylink('<?php echo $product['link']; ?>');">Copy Link</a>
                                        </p>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                            
                            
                            
                        </table>
                    </form>
                    <?php echo $pager; ?>
                    
                <?php } else { ?>
                    <div style="border:1px solid #eee; padding: 15px; text-align: center;">Không có sản phẩm nào!</div>                                           
                <?php } ?>                    
                </div>
            <?php } else { ?>
                <div class="noshop">
                    Bạn chưa cài đặt Gian hàng, vui lòng <a href="<?php echo base_url(); ?>account/shop"> cài đặt gian hàng</a> để sử dụng tính năng này.
                </div>
            <?php } ?>
        </div>
    </div>
</div>
<?php $this->load->view('home/common/footer'); ?>
