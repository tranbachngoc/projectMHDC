<?php $group_id = (int) $this->session->userdata('sessionGroup'); ?>
    <ul class="menu-azinet-top"> 
        <li class="azibaihome">
            <a href="<?php echo getAliasDomain() ?>">
                <i class="azicon icon-azibai"></i>
            </a>
        </li>
        <li>
	    <a href="<?php echo getAliasDomain('shop/products'); ?>" title="Azibai Shop">
                <i class="azicon icon-store"></i>
	    </a>
	</li>
        <li>
	    <a href="<?php echo getAliasDomain('checkout'); ?>" title="Giỏ hàng">
                <i class="azicon icon-cart"></i>
	    </a>
	</li>
        <li class="dropdown">
            <a id="dropdown_1" href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                <i class="azicon icon-newspaper"></i>
            </a>
            <ul class="dropdown-menu" aria-labelledby="dropdown_1" style="width:100%; height: calc(100vh - 44px); overflow: auto;">
                <li>
		    <a href="<?php echo getAliasDomain() . '/tintuc/hot' ?>">
			<i class="azicon icon-coupon"></i> &nbsp; Tin tức hot 
		    </a>
		</li>
                <li> 
		    <a href="<?php echo getAliasDomain() . '/tintuc/promotion' ?>">
			<i class="azicon icon-gift"></i> &nbsp; Tin khuyến mãi 
		    </a> 
		</li>
  		</li>
                <li>
                    <a href="#">
                        <i class="azicon icon-organize"></i> &nbsp; Tin theo ngành nghề
                        <span class="fa fa-angle-down pull-right"></span>
                    </a>
                    <ul class="nav-child">
                        <?php  if($productCategoryRoot) {                     
                            foreach ($productCategoryRoot as $key => $value) {
                                if ($value->cate_type == 2) {
                                    ?>
                                    <li>
                                        <a href="/tintuc/category/<?php echo $value->cat_id . '/' . RemoveSign($value->cat_name) ?>/">
                                            <i class="azicon icon-organize"></i> &nbsp; <?php echo $value->cat_name ?>
                                        </a>
                                    </li>
                                    <?php
                                }
                            }  // end foreach                     
                        } // end if ?>
                    </ul>
                </li>
                <li><a href="<?php echo getAliasDomain() ?>"><img src="/templates/home/icons/black/cubes.png" alt="icon-cubes"/> &nbsp; Tin theo Group </a></li>

            </ul>
        </li> 

        <li class="dropdown"> 
            <a id="dropdown_2" href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                <i class="azicon icon-search"></i> 
            </a>
            <ul class="dropdown-menu" aria-labelledby="dropdown_2" style="width:100%; height: calc(100vh - 44px); overflow: auto;">
                <li>                    
		    <?php if ($this->uri->segment(1) == 'tintuc' || $this->uri->segment(1) == '') { ?>
		    <form id="search_tintuc_2" class="form-horizontal" action="<?php echo base_url() ?>tintuc/search" method="post">                            
			<div style="margin:10px;">
			    <div class="input-group">
				    <input name="keyword" id="keyword" class="form-control" type="text" 
					       value="<?php if ($keyword) { echo $keyword; } ?>" 
					       placeholder="Tìm kiếm tin tức" 
					       onkeypress="return submitenterQ(this,event,'')">
				    <span class="input-group-btn">
					    <button class="btn btn-default1" type="submit">&nbsp;<i class="fa fa-search"></i>&nbsp;</button>
				    </span>
			    </div>
			</div>
		    </form>
		    <?php } else { ?>
		    <form id="search_product_2" name="formsearch_home" class="form-horizontal" action="<?php echo base_url() . 'search-information' ?>" method="post">
			    <div style="margin:10px;">
				    <div class="input-group">
					    <input type="hidden" id="category_quick_search_q" name="category_quick_search_q"
						       value="product">
					    <input name="key" id="singleBirdRemote" class="form-control txt-search ui-autocomplete-input"
						       type="text"
						       placeholder="Tìm kiếm sản phẩm"
						       onkeypress="autoCompleteSearch(document.getElementById('category_quick_search_q').value)"/>
					    <div class="input-group-addon" onclick="Search_home();" style="cursor: pointer;"><i
							    class="fa fa-search"></i></div>
				    </div>
			    </div>
		    </form>
		    <?php } ?>
                </li>
            </ul>
        </li>

        <li class="dropdown"> 
            <a id="dropdown_3" href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                <i class="azicon icon-bars"></i>
            </a>
            <div class="dropdown-menu" style="width:100%; height: calc(100vh - 44px); margin: 0; overflow: auto;">
                <?php $this->load->view('home/menus/defaults'); ?>
            </div>
        </li>
    </ul>


