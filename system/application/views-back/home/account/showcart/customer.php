<?php $this->load->view('home/common/account/header'); ?>
<div class="container-fluid">
    <div class="row">
        <?php $this->load->view('home/common/left'); ?>
        <!--BEGIN: RIGHT-->
        <div class="col-md-9 col-sm-8 col-xs-12">
            <h4 class="page-header text-uppercase" style="margin-top:10px">
                Danh sách khách hàng
            </h4>
            
            <form name="frmAccountShowcart" method="post" class="form">   
                
                <div class="panel panel-default">
                    <div class="panel-body" style="padding-bottom:0px;>
                        <form action="<?php // echo $link;     ?>" method="post" class="searchBox">                                  
                            <div class="row">
                                <div class="form-group col-md-4 col-sm-6 col-xs-12">
                                    <input type="text" name="use_username" value="<?php echo $params['use_username']; ?>" placeholder="Tìm tài khoản ..." class="form-control">
                                </div>
                                <div class="form-group col-md-3 col-sm-6 col-xs-12">
                                    <input type="text" name="use_fullname" value="<?php echo $params['use_fullname']; ?>" placeholder="Tên khách hàng ..." class="form-control">
                                </div>
                                <div class="form-group col-md-3 col-sm-6 col-xs-12">
                                    <input type="text" name="mobile"  value="<?php echo $params['mobile']; ?>" placeholder="Mobile ..." class="form-control">
                                </div>
                                <div class="form-group col-md-2 col-sm-6 col-xs-12">
                                    <button type="submit" class="btn btn-azibai btn-block"><i class="fa fa-search fa-fw"></i> Tìm kiếm</button>
                                </div>
                            </div>
                        </form> 
                    </div>
                </div>
 
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <?php if (count($customers) > 0) { ?>        
                            <tr style="background: #eee">
                                <td with="5%" class="title_account_0">STT</td>
                                <td with="25%" class="title_account_2">
                                    Tài khoản
                                    <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>user_id/by/asc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                                    <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>user_id/by/desc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                                </td>
                                <td with="20%" class="title_account_2 ">
                                    Tên
                                    <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>fullname/by/asc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                                    <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>fullname/by/desc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                                </td>
                                <td width="10%" class="title_account_1">
                                    Điện thoại
                                </td>
                                <td width="25%" class="title_account_1">
                                    Địa chỉ
                                </td>
                                <td width="15%" class="title_account_1">
                                    Đơn hàng
                                    <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>counter/by/asc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                                    <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>counter/by/desc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                                </td>
                            </tr>
                            <?php $idDiv = 1; ?>
                            <?php foreach ($customers as $customer) { ?>
                                <tr id="DivRow_<?php echo $idDiv; ?>">
                                    <td class="text-center"><?php echo $sTT; ?></td>
                                    <td>
<!--                                        <a class="menu_1" href="--><?php //echo base_url(); ?><!--user/profile/--><?php //echo $customer->use_id; ?><!--" >-->
                                            <?php echo $customer->use_username; ?>
<!--                                        </a>-->
                                    </td>
                                    <td>
<!--                                        <a href="--><?php //echo base_url() . 'user/profile/' . $customer->use_id ?><!--">   -->
                                            <?php echo $customer->use_fullname; ?>
<!--                                        </a>-->
                                    </td>

                                    <td>
                                        <?php echo $customer->use_mobile ?>
                                    </td>
                                    <td>
                                        <?php echo $customer->use_address ?>

                                    </td>
                                    <td >
                                        <a href="<?php echo base_url() . 'account/customer/list_orders/' . $customer->use_id ?>">
                                            <?php echo $arrCount[$customer->order_user];// echo $customer->count_order ?> đơn hàng
                                        </a>
                                    </td>
                                </tr>
                                <?php $idDiv++; ?>
                                <?php $sTT++; ?>
                            <?php } ?>

                        <?php } elseif (count($showcart) == 0 && trim($keyword) != '') {
                            ?>
                            <tr>
                                <td width="50" class="title_account_0">STT</td>
                                <td width="30" class="title_account_1"><input type="checkbox" name="checkall" id="checkall" value="0" onclick="DoCheck(this.checked, 'frmAccountShowcart', 0)" /></td>
                                <td class="title_account_2">
                                    <?php echo $this->lang->line('product_list'); ?>
                                    <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" border="0" />
                                    <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" border="0" />
                                </td>
                                <td width="125" class="title_account_1">
                                    <?php echo $this->lang->line('cost_list'); ?>
                                    <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" border="0" />
                                    <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" border="0" />
                                </td>
                                <td width="95" class="title_account_2">
                                    <?php echo $this->lang->line('quantity_list'); ?>
                                    <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" border="0" />
                                    <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" border="0" />
                                </td>
                                <td width="130" class="title_account_1">
                                    <?php echo $this->lang->line('saler_list'); ?>
                                    <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" border="0" />
                                    <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" border="0" />
                                </td>
                                <td width="110" class="title_account_2">
                                    <?php echo $this->lang->line('date_buy_list'); ?>
                                    <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" border="0" />
                                    <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" border="0" />
                                </td>
                                <td width="50" class="title_account_3"><?php echo $this->lang->line('process_list'); ?></td>
                            </tr>
                            <tr>
                                <td class="none_record_search" align="center"><?php echo $this->lang->line('none_record_search_showcart_defaults'); ?></td>
                            </tr>
                            <tr>
                                <td  id="delete_account"><img src="<?php echo base_url(); ?>templates/home/images/icon_deleteshowcart_account.gif" onclick="" style="cursor:pointer;" border="0" />
                                    <input type="text" name="keyword_account" id="keyword_account" value="<?php
                                    if (isset($keyword)) {
                                        echo $keyword;
                                    }
                                    ?>" maxlength="100" class="inputfilter_account" onKeyUp="BlockChar(this, 'AllSpecialChar')" onfocus="ChangeStyle('keyword_account', 1)" onblur="ChangeStyle('keyword_account', 2)" />
                                    <input type="hidden" name="search_account" id="search_account" value="name" />
                                    <img src="<?php echo base_url(); ?>templates/home/images/icon_filter.gif" onclick="ActionSearch('<?php echo base_url(); ?>account/showcart/', 0)" border="0" style="cursor:pointer;" alt="<?php echo $this->lang->line('search_tip'); ?>" />
                                </td>
                            </tr>
                        <?php } else {
                            ?>
                            <tr>
                                <td class="none_record" align="center"  >Không có khách hàng nào</td>
                            </tr>
                        <?php } ?>
                    </table>
                </div>    
                <?php if (!empty($linkPage)) { ?>
                    <div class="show_page" ><?php echo $linkPage; ?></div>
                <?php } ?>
            </form>
        </div>
    </div>
</div>
<input id="baseUrl" type="hidden" value="<?php echo base_url() ?>"  />
<!--END RIGHT-->
<?php $this->load->view('home/common/footer'); ?>
<?php if (isset($successAddShowcart) && trim($successAddShowcart) != '') { ?>
    <script>alert('<?php echo $successAddShowcart; ?>');</script>
<?php } ?>