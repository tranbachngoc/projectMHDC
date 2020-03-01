<?php $this->load->view('group/product/common/header'); ?>
<div id="main" class="container">
    <ol class="breadcrumb">                  
        <li><a href="/grtshop">Cửa hàng</a></li>                      
        <li><a href="/grtshop/<?php echo $this->uri->segment(2)?>"><?php echo $ptype; ?></a></li>                      
        <li class="active"><?php echo $category->cat_name; ?></li>
    </ol>
    <div class="row">
        <?php if(isset($siteGlobal)){ ?>
        <?php
            $guser = '';
            if($_REQUEST['gr_saler'] && $_REQUEST['gr_saler'] != ''){
                $guser = $_REQUEST['gr_saler'];
            }
        ?>
        <div class="col-xs-12 col-sm-12">
            <div class="group-products">                            
                <div class="well">
                    <div class="row">
                        <?php $ar = explode('page/',$_SERVER['REQUEST_URI']);?>
                        <div class="col-xs-12 col-sm-12">
                            <form class="form" id="searchBox" action="<?php echo $ar[0]?>" method="get">
                                <div class="row">    
                                    <?php
                                    $keyword = $price_fo = $price_to = '';
                                    if(isset($parrams)){
                                        $keyword = $parrams['q'];
                                        $price_fo = $parrams['price_fo'];
                                        $price_to = $parrams['price_to'];
                                    }
                                    ?>
                                    <div class="col-sm-4">
                                        <input type="text" value="<?php echo $keyword?>" name="q" id="KeywordSearch" class="form-control keyword" title="Từ khóa tìm kiếm" onkeypress="return submit_enter(event)" placeholder="Từ khóa tìm kiếm">
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="input-group">
                                            <input class="form-control min_price" type="text" value="<?php echo $price_fo?>" name="price_fo" id="price" title="Giá nhỏ nhất" onkeypress="return submit_enter(event)" placeholder="Giá nhỏ nhất">
                                            <span class="input-group-addon" id="basic-addon2">vnđ</span>
                                        </div>
                                        </div>
                                    <div class="col-sm-3">
                                        <div class="input-group">
                                            <input class="form-control max_price" type="text" value="<?php echo $price_to?>" name="price_to" id="price_to" title="Giá lớn nhất" onkeypress="return submit_enter(event)" placeholder="Giá lớn nhất">
                                            <span class="input-group-addon" id="basic-addon2">vnđ</span>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-search"></i> &nbsp; Tìm kiếm</button>
                                    </div>
                                </div>
                            </form>                        
                        </div>   

                    </div>
                </div>
                
                <div class="row">
                    <div class="col-xs-12 col-sm-7">
                        <div class="page-title">                            
                            <h3 style="margin-top: 0;"><i class="fa fa-list-ul" aria-hidden="true"></i> <?php echo ($category->cat_name != "") ?  $category->cat_name : "Tất cả $ptype"; ?></h3>
                        </div>
                    </div>
                    <?php
                    $search_ = '';
                    if($query_str){
                        $search_ = '?' . $query_str;
                    }
                    $pageSort = $pageSort.$search_;
                    ?>
                    <div class="col-xs-12 col-sm-3" style="float:right">
                        <select autocomplete="off" name="select_sort" class="form-control" onchange="ActionSort(this.value)">
                            <option <?php echo ($default_sort == 'id_desc') ? 'selected="selected"' : ''; ?> value="<?php echo $sortUrl; ?>id/by/desc<?php echo $pageSort; ?>"><?php echo $this->lang->line('sort_main'); ?></option>
                            <option <?php echo ($default_sort == 'name_asc') ? 'selected="selected"' : ''; ?> value="<?php echo $sortUrl; ?>name/by/asc<?php echo $pageSort; ?>">Tên sản phẩm A&rarr;Z</option>
                            <option <?php echo ($default_sort == 'name_desc') ? 'selected="selected"' : ''; ?> value="<?php echo $sortUrl; ?>name/by/desc<?php echo $pageSort; ?>">Tên sản phẩm Z&rarr;A</option>
                            <option <?php echo ($default_sort == 'cost_asc') ? 'selected="selected"' : ''; ?> value="<?php echo $sortUrl; ?>cost/by/asc<?php echo $pageSort; ?>">Giá sản phẩm tăng dần</option>
                            <option <?php echo ($default_sort == 'cost_desc') ? 'selected="selected"' : ''; ?> value="<?php echo $sortUrl; ?>cost/by/desc<?php echo $pageSort; ?>">Giá sản phẩm giảm dần</option>
                            <option <?php echo ($default_sort == 'buy_asc') ? 'selected="selected"' : ''; ?> value="<?php echo $sortUrl; ?>buy/by/asc<?php echo $pageSort; ?>"><?php echo $this->lang->line('buy_asc_detail_product'); ?></option>
                            <option <?php echo ($default_sort == 'buy_desc') ? 'selected="selected"' : ''; ?> value="<?php echo $sortUrl; ?>buy/by/desc<?php echo $pageSort; ?>"><?php echo $this->lang->line('buy_desc_detail_product'); ?></option>
                            <option <?php echo ($default_sort == 'view_asc') ? 'selected="selected"' : ''; ?> value="<?php echo $sortUrl; ?>view/by/asc<?php echo $pageSort; ?>"><?php echo $this->lang->line('view_asc_detail_product'); ?></option>
                            <option <?php echo ($default_sort == 'view_desc') ? 'selected="selected"' : ''; ?> value="<?php echo $sortUrl; ?>view/by/desc<?php echo $pageSort; ?>"><?php echo $this->lang->line('view_desc_detail_product'); ?></option>
                            <option <?php echo ($default_sort == 'date_asc') ? 'selected="selected"' : ''; ?> value="<?php echo $sortUrl; ?>date/by/asc<?php echo $pageSort; ?>"><?php echo $this->lang->line('begindate_asc_detail_product'); ?></option>
                            <option <?php echo ($default_sort == 'date_desc') ? 'selected="selected"' : ''; ?> value="<?php echo $sortUrl; ?>date/by/desc<?php echo $pageSort; ?>"><?php echo $this->lang->line('begindate_desc_detail_product'); ?></option>
                        </select>
                    </div>
                   
                </div>
                 <br/>
                 <style>
                </style>
                <div class="row products">                     
                    <?php $this->load->view('group/product/tab_pro', array('products' => $products, 'guser' => $guser)); ?>
                </div>
                <div class="row text-center">
                     <div class="linkPage"><?php echo $linkPage; ?></div>              
                </div>
            </div>
        </div>

        <?php } ?>  
    </div>
</div>
<?php $this->load->view('group/common/footer-group'); ?>