<?php $this->load->view('admin/common/header'); ?>
<?php $this->load->view('admin/common/menu'); ?>
<style>
.badge {
    /*display: inline-block;*/
    /*min-width: 10px;*/
    /*padding: 3px 7px;*/
    /*font-size: 12px;*/
    /*font-weight: bold;*/
    /*line-height: 1;*/
    /*color: #fff;*/
    /*text-align: center;*/
    /*white-space: nowrap;*/
    /*vertical-align: middle;*/
    /*border-radius: 10px;*/
    /*background-color: #ff0000;*/
    /*position: relative;*/
    /*top: -55px;*/
    /*right: 30px;*/
}
a:hover{text-decoration: none !important;color:black !important;}
.text_icon_main{padding: 3px 5px 0px 5px;}
.money{color:red;font-weight: 900;}
.infomain tr{margin: 14px 0;line-height: 20px}
</style>

<tr>
    <td valign="top">
<?php if($this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'wallet_view ')) {?>
        <table width="100%" border="0" align="center" class="main" cellpadding="0" cellspacing="0">
            <tr>
                <td width="2"></td>
                <td width="10" class="left_main" valign="top"></td>
                <td align="center" valign="top">
                    <!--BEGIN: Main-->
                    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td height="10" colspan="2"></td>
                        </tr>
                        <tr style="margin-top:20px;">
                            <td valign="top">
                                <div class="panel panel-default">
                                    <div class="panel-heading"> <h3 class="panel-title"><b>THỐNG KÊ CHUNG</b></h3> </div>
                                    <div class="panel-body">
                                        <div class="col-sm-6">
                                  <ul class="list-group">
                                      <li  onclick="ActionLink('<?php echo base_url().'administ/user';?>')"  class="list-group-item list-group-item-success">
                                          <a class="text-success" href="<?php echo base_url().'administ/user';?>">
                                                Thành viên thường
                                          </a><span class="badge"><?php echo $CountAllNormalUser; ?></span>
                                      </li>
                                      <li onclick="ActionLink('<?php echo base_url().'administ/statistics/affiliates';?>')" class="list-group-item list-group-item-info">
                                          <a class="text-info" href="<?php echo base_url().'administ/statistics/affiliates';?>">
                                              Thành viên Affiliate
                                          </a> <span class="badge"><?php echo $CountAllAffiliateUser; ?></span>
                                      </li>
                                      <li onclick="ActionLink('<?php echo base_url().'administ/statistics/affiliates#store';?>')" class="list-group-item list-group-item-warning">
                                          <a class="text-warning" href="<?php echo base_url().'administ/statistics/affiliates#store';?>">
                                             Thành viên Gian hàng
                                          </a> <span class="badge"><?php echo $CountAllAffiliateStoreUser; ?></span>
                                      </li>
                                      <li onclick="ActionLink('<?php echo base_url().'administ/user/developer2';?>')" class="list-group-item list-group-item-danger">
                                          <a class="text-danger" href="<?php echo base_url().'administ/user/developer2';?>">
                                             Thành viên Developer 2
                                          </a>  <span class="badge"><?php echo $CountAllDeveloper2User; ?></span>
                                      </li>
                                  </ul>
                              </div>
                                        <div class="col-sm-6">
                                    <ul class="list-group">
                                        <li onclick="ActionLink('<?php echo base_url().'administ/user/developer1';?>')" class="list-group-item list-group-item-success">
                                            <a class="text-success" href="<?php echo base_url().'administ/user/developer1';?>">
                                                Thành viên Developer 1
                                            </a><span class="badge"><?php echo $CountAllDeveloper1User; ?></span>
                                        </li>
                                        <li onclick="ActionLink('<?php echo base_url().'administ/user/partner2';?>')" class="list-group-item list-group-item-info">
                                            <a class="text-info" href="<?php echo base_url().'administ/user/partner2';?>">
                                                Thành viên Partner 2
                                            </a>    <span class="badge"><?php echo $CountAllPartner2User; ?></span>
                                        </li>
                                        <li onclick="ActionLink('<?php echo base_url().'administ/user/partner1';?>')" class="list-group-item list-group-item-warning">
                                            <a class="text-warning" href="<?php echo base_url().'administ/user/partner1';?>">
                                                Thành viên Partner 1
                                            </a> <span class="badge"><?php echo $CountAllPartner1User; ?></span>
                                        </li>
                                        <li onclick="ActionLink('<?php echo base_url().'administ/user/coremember';?>')" class="list-group-item list-group-item-danger">
                                            <a class="text-danger" href="<?php echo base_url().'administ/user/coremember';?>">
                                                Thành viên Core Member
                                            </a> <span class="badge"><?php echo $CountAllCoreMemberUser; ?></span>
                                        </li>
                                    </ul>
                                </div>
                                        <div class="col-sm-12">
                                            <ul class="list-group">
                                                <li onclick="ActionLink('<?php echo base_url(); ?>administ/statistics/totalorders')" class="list-group-item">
                                                    <a class="menu" href="<?php echo base_url(); ?>administ/statistics/totalorders">
													Đơn hàng thành công
                                                    </a> <span class="badge"><?php echo $CountGetAllOrderEveryDay; ?></span>
                                                </li>
                                                <li onclick="ActionLink('<?php echo base_url(); ?>administ/product')" class="list-group-item">
                                                    <a class="menu" href="<?php echo base_url(); ?>administ/product">
                                                       <?php echo $this->lang->line('product_main'); ?>
                                                    </a>  <span class="badge"><?php echo $CountGetAllProductEveryDay; ?></span>
                                                </li>
                                                <li onclick="ActionLink('<?php echo base_url(); ?>administ/statistics/services')" class="list-group-item">
                                                    <a class="menu" href="<?php echo base_url(); ?>administ/statistics/services">
                                                        <?php echo $this->lang->line('sum_service'); ?>
                                                    </a><span style="background: #ff0000" class="badge">
														<?php 
															echo number_format($CountSumPackageUser, 0, ".", "."); 
														?> đ
													</span>
                                                </li>
                                                 <li onclick="ActionLink('<?php echo base_url(); ?>administ/statistics/orders')" class="list-group-item">
                                                     <a class="menu" href="<?php echo base_url(); ?>administ/statistics/orders">
                                                         <?php echo $this->lang->line('sum_order'); ?>
                                                     </a> <span style="background: #ff0000" class="badge">
														    <?php 
																echo number_format($CountSumOrder, 0, ".", "."); 
															?> đ
													   </span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                 </div>
                                <?php /*
                                <div onclick="ActionLink('<?php echo base_url().'administ/user';?>')" class="icon_main" id="icon_main_2" onmouseover="ChangeStyleIcon('icon_main_2',1)" onmouseout="ChangeStyleIcon('icon_main_2',2)" style="border: 1px solid rgb(234, 234, 234);">
                                    <a class="menu" href="<?php echo base_url().'administ/user';?>">
                                        <img src="<?php echo base_url(); ?>templates/home/images/icon/contact-icon.png" border="0">
                                        <span class="badge"><?php echo $CountAllNormalUser; ?></span>
                                        <div class="text_icon_main">Thành viên thường</div>
                                    </a>
                                </div>
                                
                                <div onclick="ActionLink('<?php echo base_url().'administ/user/affiliate';?>')" class="icon_main" id="icon_main_19" onmouseover="ChangeStyleIcon('icon_main_19',1)" onmouseout="ChangeStyleIcon('icon_main_19',2)" style="border: 1px solid rgb(234, 234, 234);">
                                    <a class="menu" href="<?php echo base_url().'administ/user/affiliate';?>">
                                        <img src="<?php echo base_url(); ?>templates/home/images/icon/contact-icon.png" border="0">
                                        <span class="badge"><?php echo $CountAllAffiliateUser; ?></span>
                                        <div class="text_icon_main">Thành viên Affiliate</div>
                                    </a>
                                </div>
                                
                                <div onclick="ActionLink('<?php echo base_url().'administ/user/shoppremium';?>')" class="icon_main" id="icon_main_20" onmouseover="ChangeStyleIcon('icon_main_20',1)" onmouseout="ChangeStyleIcon('icon_main_20',2)" style="border: 1px solid rgb(234, 234, 234);">
                                    <a class="menu" href="<?php echo base_url().'administ/user/shoppremium';?>">
                                        <img src="<?php echo base_url(); ?>templates/home/images/icon/contact-icon.png" border="0">
                                        <span class="badge"><?php echo $CountAllAffiliateStoreUser; ?></span>
                                        <div class="text_icon_main">Thành viên Gian hàng</div>
                                    </a>
                                </div>
                                
                                <div onclick="ActionLink('<?php echo base_url().'administ/user/developer2';?>')" class="icon_main" id="icon_main_21" onmouseover="ChangeStyleIcon('icon_main_21',1)" onmouseout="ChangeStyleIcon('icon_main_21',2)" style="border: 1px solid rgb(234, 234, 234);">
                                    <a class="menu" href="<?php echo base_url().'administ/user/developer2';?>">
                                        <img src="<?php echo base_url(); ?>templates/home/images/icon/contact-icon.png" border="0">
                                        <span class="badge"><?php echo $CountAllDeveloper2User; ?></span>
                                        <div class="text_icon_main">Thành viên Developer 2</div>
                                    </a>
                                </div>
                                
                                <div onclick="ActionLink('<?php echo base_url().'administ/user/developer1';?>')" class="icon_main" id="icon_main_22" onmouseover="ChangeStyleIcon('icon_main_22',1)" onmouseout="ChangeStyleIcon('icon_main_22',2)" style="border: 1px solid rgb(234, 234, 234);">
                                    <a class="menu" href="<?php echo base_url().'administ/user/developer1';?>">
                                        <img src="<?php echo base_url(); ?>templates/home/images/icon/contact-icon.png" border="0">
                                        <span class="badge"><?php echo $CountAllDeveloper1User; ?></span>
                                        <div class="text_icon_main">Thành viên Developer 1</div>
                                    </a>
                                </div>
                                
                                
                                
                                <div onclick="ActionLink('<?php echo base_url().'administ/user/partner2';?>')" class="icon_main" id="icon_main_23" onmouseover="ChangeStyleIcon('icon_main_23',1)" onmouseout="ChangeStyleIcon('icon_main_23',2)" style="border: 1px solid rgb(234, 234, 234);">
                                    <a class="menu" href="<?php echo base_url().'administ/user/partner2';?>">
                                        <img src="<?php echo base_url(); ?>templates/home/images/icon/contact-icon.png" border="0">
                                        <span class="badge"><?php echo $CountAllPartner2User; ?></span>
                                        <div class="text_icon_main">Thành viên Partner 2</div>
                                    </a>
                                </div>
                                <div onclick="ActionLink('<?php echo base_url().'administ/user/partner1';?>')" class="icon_main" id="icon_main_24" onmouseover="ChangeStyleIcon('icon_main_24',1)" onmouseout="ChangeStyleIcon('icon_main_24',2)" style="border: 1px solid rgb(234, 234, 234);">
                                    <a class="menu" href="<?php echo base_url().'administ/user/partner1';?>">
                                        <img src="<?php echo base_url(); ?>templates/home/images/icon/contact-icon.png" border="0">
                                        <span class="badge"><?php echo $CountAllPartner1User; ?></span>
                                        <div class="text_icon_main">Thành viên Partner 1</div>
                                    </a>
                                </div>
                                
                                <div onclick="ActionLink('<?php echo base_url().'administ/user/coremember';?>')" class="icon_main" id="icon_main_25" onmouseover="ChangeStyleIcon('icon_main_25',1)" onmouseout="ChangeStyleIcon('icon_main_25',2)" style="border: 1px solid rgb(234, 234, 234);">
                                    <a class="menu" href="<?php echo base_url().'administ/user/coremember';?>">
                                        <img src="<?php echo base_url(); ?>templates/home/images/icon/contact-icon.png" border="0">
                                        <span class="badge"><?php echo $CountAllCoreMemberUser; ?></span>
                                        <div class="text_icon_main">Thành viên Core Member</div>
                                    </a>
                                </div>

                                <div onclick="ActionLink('<?php echo base_url(); ?>administ/statistics/quantityOrder')" class="icon_main" id="icon_main_26" onmouseover="ChangeStyleIcon('icon_main_26',1)" onmouseout="ChangeStyleIcon('icon_main_26',2)">
                                    <a class="menu" href="<?php echo base_url(); ?>administ/statistics/quantityOrder">
                                        <img  src="<?php echo base_url(); ?>templates/home/images/icon/cart-icon.png" border="0">
                                        <span class="badge"><?php echo $CountGetAllOrderEveryDay; ?></span>
                                        <div class="text_icon_main"><?php echo $this->lang->line('customer_main'); ?></div>
                                    </a>
                                </div>
                                <div onclick="ActionLink('<?php echo base_url(); ?>administ/product')" class="icon_main" id="icon_main_27" onmouseover="ChangeStyleIcon('icon_main_27',1)" onmouseout="ChangeStyleIcon('icon_main_27',2)">
                                    <a class="menu" href="<?php echo base_url(); ?>administ/product">
                                        <img src="<?php echo base_url(); ?>templates/home/images/icon/shopping-icon.png" border="0" />
                                        <span class="badge"><?php echo $CountGetAllProductEveryDay; ?></span>
                                        <div class="text_icon_main"><?php echo $this->lang->line('product_main'); ?></div>
                                    </a>
                                </div>



                                <div onclick="ActionLink('<?php echo base_url(); ?>administ/statistics/services')" class="icon_main" id="icon_main_6" onmouseover="ChangeStyleIcon('icon_main_6',1)" onmouseout="ChangeStyleIcon('icon_main_6',2)">
                                    <a class="menu" href="<?php echo base_url(); ?>administ/statistics/services">
                                        <img  src="<?php echo base_url(); ?>templates/home/images/icon/cart-icon.png" border="0">
                                        <div class="text_icon_main">
                                            <span class="money"><?php echo number_format($CountSumPackageUser, 0, ".", "."); ?> đ</span><br/>
                                            <?php echo $this->lang->line('sum_service'); ?>
                                        </div>
                                    </a>
                                </div>
                                <div onclick="ActionLink('<?php echo base_url(); ?>administ/statistics/orders')" class="icon_main" id="icon_main_7" onmouseover="ChangeStyleIcon('icon_main_7',1)" onmouseout="ChangeStyleIcon('icon_main_7',2)">
                                    <a class="menu" href="<?php echo base_url(); ?>administ/statistics/orders">
                                        <img src="<?php echo base_url(); ?>templates/home/images/icon/shopping-icon.png" border="0" />
                                        <div class="text_icon_main">
                                            <span class="money"><?php echo number_format($CountSumOrder, 0, ".", "."); ?> đ</span><br/>
                                            <?php echo $this->lang->line('sum_order'); ?>
                                        </div>
                                    </a>
                                </div>
                                      */?>
                                
                            </td>
                            <td style="vertical-align:top;">
                                <table width="100%" class="infomain" border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td height="25" class="title_infomain" colspan="3">Thống kê hôm nay</td>
                                    </tr>
                                    <tr>
                                        <td width="25" class="img_infomain">
                                            <img src="<?php echo base_url(); ?>templates/home/images/icon/contact-icon.png" width="20" border="0" /></td>
                                        <td width="100" class="list_infomain"><?php echo $this->lang->line('user_info'); ?>:</td>
                                        <td class="content_infomain">
                                            <br/>
                                            -Thường : <?php echo $CountNormalUser; ?>
                                            <br/>
                                            -Affiliate: <?php echo $CountAffiliateUser; ?>
                                            <br/>
                                            -Gian hàng: <?php echo $CountAffiliateStoreUser; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="25" class="img_infomain">
                                            <img src="<?php echo base_url(); ?>templates/home/images/icon/treesystem-icon.png" width="20" border="0" /></td>
                                        <td width="100" class="list_infomain">Cây hệ thống:</td>
                                        <td class="content_infomain">
                                            <br/>
                                            -Developer 2 : <?php echo $CountDeveloper2User; ?>
                                            <br/>
                                            -Developer 1: <?php echo $CountDeveloper1User; ?>
                                            <br/>
                                            -Partner 2: <?php echo $CountPartner2User; ?>
                                            <br/>
                                            -Partner 1: <?php echo $CountPartner1User; ?>
                                            <br/>
                                            -CoreMember: <?php echo $CountCoreMemberUser; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="25" class="img_infomain">
                                            <img src="<?php echo base_url(); ?>templates/home/images/icon/cart-icon.png" width="20" border="0" /></td>
                                        <td width="100" class="list_infomain">Đơn hàng:</td>
                                        <td class="content_infomain">
                                            <?php echo $CountGetOrderEveryDay; ?>
                                        </td>
                                    </tr>
                                    
                                    <tr>
                                        <td width="25" class="img_infomain">
                                            <img src="<?php echo base_url(); ?>templates/home/images/icon/shopping-icon.png" width="20" border="0" /></td>
                                        <td width="100" class="list_infomain">Sản phẩm:</td>
                                        <td class="content_infomain">
                                            <?php echo $CountGetProductEveryDay; ?>
                                        </td>
                                    </tr>
                                    
                                    <tr>
                                        <td width="25" class="img_infomain">
                                            <img src="<?php echo base_url(); ?>templates/home/images/icon/shopping-icon.png" width="20" border="0" /></td>
                                        <td width="100" class="list_infomain">Tổng doanh thu đơn hàng:</td>
                                        <td class="content_infomain">
                                            <?php echo number_format($CountSumOrderEveryday, 0, ".", "."); ?> đ
                                        </td>
                                    </tr>
                                    
                                    <tr>
                                        <td width="25" class="img_infomain">
                                            <img src="<?php echo base_url(); ?>templates/home/images/icon/cart-icon.png" width="20" border="0" /></td>
                                        <td width="100" class="list_infomain">Tổng doanh thu dịch vụ:ABCBBB</td>
                                        <td class="content_infomain">
                                            <?php echo number_format($CountSumPackageUserEveryday, 0, ".", "."); ?> đ
                                        </td>
                                    </tr>
                                </table>
                                
                            </td>
                        </tr>
                        <tr>
                            <td><br/><b>TRUY CẬP NHANH</b></td>
                        </tr>
                        <tr>
                            <td valign="top">
                                <div onclick="ActionLink('<?php echo base_url(); ?>administ/newsletter')" class="icon_main" id="icon_main_8" onmouseover="ChangeStyleIcon('icon_main_8',1)" onmouseout="ChangeStyleIcon('icon_main_8',2)">
                                    <a class="menu" href="<?php echo base_url(); ?>administ/newsletter">
                                        <img src="<?php echo base_url(); ?>templates/home/images/icon/email-download-icon.png" border="0" />
                                        <div class="text_icon_main">Danh sách đăng ký email</div>
                                    </a>
                                </div>
                                <div onclick="ActionLink('<?php echo base_url(); ?>administ/advertise')" class="icon_main" id="icon_main_9" onmouseover="ChangeStyleIcon('icon_main_9',1)" onmouseout="ChangeStyleIcon('icon_main_9',2)">
                                    <a class="menu" href="<?php echo base_url(); ?>administ/advertise">
                                        <img src="<?php echo base_url(); ?>templates/home/images/icon/megaphone-icon.png" border="0" />
                                        <div class="text_icon_main"><?php echo $this->lang->line('advertise_category_menu'); ?></div>
                                    </a>
                                </div>
                                <div onclick="ActionLink('<?php echo base_url(); ?>administ/service')" class="icon_main" id="icon_main_10" onmouseover="ChangeStyleIcon('icon_main_10',1)" onmouseout="ChangeStyleIcon('icon_main_10',2)">
                                    <a class="menu" href="<?php echo base_url(); ?>administ/service">
                                        <img src="<?php echo base_url(); ?>templates/home/images/icon/favourite-heart-icon.png" border="0" />
                                        <div class="text_icon_main">Danh sách dịch vụ</div>
                                    </a>
                                </div>
                                <div onclick="ActionLink('<?php echo base_url(); ?>administ/user/allusertree')" class="icon_main" id="icon_main_11" onmouseover="ChangeStyleIcon('icon_main_11',1)" onmouseout="ChangeStyleIcon('icon_main_11',2)">
                                    <a class="menu" href="<?php echo base_url(); ?>administ/user/allusertree">
                                        <img src="<?php echo base_url(); ?>templates/home/images/icon/treesystem-icon.png" border="0" />
                                        <div class="text_icon_main">Cây hệ thống</div>
                                    </a>
                                </div>
                                <div onclick="ActionLink('<?php echo base_url(); ?>administ/affiliate/shop')" class="icon_main" id="icon_main_12" onmouseover="ChangeStyleIcon('icon_main_12',1)" onmouseout="ChangeStyleIcon('icon_main_12',2)">
                                    <a class="menu" href="<?php echo base_url(); ?>administ/affiliate/shop">
                                        <img src="<?php echo base_url(); ?>templates/home/images/icon/analytics-icon.png" border="0" />
                                        <div class="text_icon_main">Thống kê Affiliate</div>
                                    </a>
                                </div>
                                <div onclick="ActionLink('<?php echo base_url(); ?>administ/contact')" class="icon_main" id="icon_main_13" onmouseover="ChangeStyleIcon('icon_main_13',1)" onmouseout="ChangeStyleIcon('icon_main_13',2)">
                                    <a class="menu" href="<?php echo base_url(); ?>administ/contact">
                                        <img src="<?php echo base_url(); ?>templates/home/images/icon/email-icon.png" border="0" />
                                        <div class="text_icon_main">Thư liên hệ</div>
                                    </a>
                                </div>
                                <div onclick="ActionLink('<?php echo base_url(); ?>administ/notify')" class="icon_main" id="icon_main_14" onmouseover="ChangeStyleIcon('icon_main_14',1)" onmouseout="ChangeStyleIcon('icon_main_14',2)">
                                    <a class="menu" href="<?php echo base_url(); ?>administ/notify">
                                        <img src="<?php echo base_url(); ?>templates/home/images/icon/noi-icon.png" border="0" />
                                        <div class="text_icon_main">Thông báo</div>
                                    </a>
                                </div>
                                <div onclick="ActionLink('<?php echo base_url(); ?>administ/content')" class="icon_main" id="icon_main_15" onmouseover="ChangeStyleIcon('icon_main_15',1)" onmouseout="ChangeStyleIcon('icon_main_15',2)">
                                    <a class="menu" href="<?php echo base_url(); ?>administ/content">
                                        <img src="<?php echo base_url(); ?>templates/home/images/icon/pen-icon.png" border="0" />
                                        <div class="text_icon_main">Bài viết</div>
                                    </a>
                                </div>
                                <div onclick="ActionLink('<?php echo base_url(); ?>administ/tintuc')" class="icon_main" id="icon_main_16" onmouseover="ChangeStyleIcon('icon_main_16',1)" onmouseout="ChangeStyleIcon('icon_main_16',2)">
                                    <a class="menu" href="<?php echo base_url(); ?>administ/tintuc">
                                        <img src="<?php echo base_url(); ?>templates/home/images/icon/new-icon.png" border="0" />
                                        <div class="text_icon_main">Tin tức</div>
                                    </a>
                                </div>
                                <div onclick="ActionLink('<?php echo base_url(); ?>administ/doc')" class="icon_main" id="icon_main_17" onmouseover="ChangeStyleIcon('icon_main_17',1)" onmouseout="ChangeStyleIcon('icon_main_17',2)">
                                    <a class="menu" href="<?php echo base_url(); ?>administ/doc">
                                        <img src="<?php echo base_url(); ?>templates/home/images/icon/folder-icon.png" border="0" />
                                        <div class="text_icon_main">Tài liệu</div>
                                    </a>
                                </div>
                                <div onclick="ActionLink('<?php echo base_url(); ?>administ/share')" class="icon_main" id="icon_main_18" onmouseover="ChangeStyleIcon('icon_main_18',1)" onmouseout="ChangeStyleIcon('icon_main_18',2)">
                                    <a class="menu" href="<?php echo base_url(); ?>administ/share">
                                        <img src="<?php echo base_url(); ?>templates/home/images/icon/share-2-icon.png" border="0" />
                                        <div class="text_icon_main">Chia sẻ link</div>
                                    </a>
                                </div>
                                <?php /*?><div onclick="ActionLink('<?php echo base_url(); ?>administ/ads')" class="icon_main" id="icon_main_8" onmouseover="ChangeStyleIcon('icon_main_8',1)" onmouseout="ChangeStyleIcon('icon_main_8',2)">
                                    <a class="menu" href="#">
                                        <img src="<?php echo base_url(); ?>templates/admin/images/icon_ads_main.png" border="0" />
                                        <div class="text_icon_main"><?php echo $this->lang->line('ads_main'); ?></div>
                                    </a>
                                </div><?php */?>
                                <?php /*?><div onclick="ActionLink('<?php echo base_url(); ?>administ/job')" class="icon_main" id="icon_main_9" onmouseover="ChangeStyleIcon('icon_main_9',1)" onmouseout="ChangeStyleIcon('icon_main_9',2)">
                                    <a class="menu" href="#">
                                        <img src="<?php echo base_url(); ?>templates/admin/images/icon_job_main.png" border="0" />
                                        <div class="text_icon_main"><?php echo $this->lang->line('job_main'); ?></div>
                                    </a>
                                </div><?php */?>
                                <?php /*?><div onclick="ActionLink('<?php echo base_url(); ?>administ/employ')" class="icon_main" id="icon_main_10" onmouseover="ChangeStyleIcon('icon_main_10',1)" onmouseout="ChangeStyleIcon('icon_main_10',2)">
                                    <a class="menu" href="#">
                                        <img src="<?php echo base_url(); ?>templates/admin/images/icon_employ_main.png" border="0" />
                                        <div class="text_icon_main"><?php echo $this->lang->line('employ_main'); ?></div>
                                    </a>
                                </div><?php */?>
                            </td>
                            <td width="395" valign="top">
                                <table width="100%" class="infomain" border="0" cellpadding="0" cellspacing="0" style="display:none;">
                                    <tr>
                                        <td height="25" class="title_infomain" colspan="3"><?php echo $this->lang->line('title_info'); ?></td>
                                    </tr>
                                    <tr>
                                        <td width="25" class="img_infomain">
                                            <img src="<?php echo base_url(); ?>templates/home/images/icon/contact-icon.png" width="20" border="0" /></td>
                                        <td width="100" class="list_infomain"><?php echo $this->lang->line('user_info'); ?>:</td>
                                        <td class="content_infomain">
                                            <?php echo $userDefaults; ?>
                                            <span class="expand_infomain">(<?php echo $this->lang->line('active_action'); ?>: <font color="#FF0000"><?php echo $activeUserDefaults; ?></font>)</span>
                                        </td>
                                    </tr>
                                    <!--<tr>
                                        <td width="20" class="img_infomain"><img src="<?php echo base_url(); ?>templates/admin/images/icon_vip_infomain.gif" border="0" /></td>
                                        <td width="100" class="list_infomain"><?php echo $this->lang->line('vip_info'); ?>:</td>
                                        <td class="content_infomain">
                                            <?php echo $vipDefaults; ?>
                                            <span class="expand_infomain">(<?php echo $this->lang->line('end_action'); ?>: <font color="#FF0000"><?php echo $endVipDefaults; ?></font>)</span>
                                            <span class="expand_infomain">(<?php echo $this->lang->line('active_action'); ?>: <font color="#FF0000"><?php echo $activeVipDefaults; ?></font>)</span>
                                        </td>
                                    </tr>-->
                                    <tr>
                                        <td width="25" class="img_infomain"><img src="<?php echo base_url(); ?>templates/home/images/icon/home-icon.png" width="20"  border="0" /></td>
                                        <td width="100" class="list_infomain"><?php echo $this->lang->line('shop_info'); ?>:</td>
                                        <td class="content_infomain">
                                            <?php echo $shopDefaults; ?>
                                            <span class="expand_infomain">(<?php echo $this->lang->line('end_action'); ?>: <font color="#FF0000"><?php echo $endShopDefaults; ?></font>)</span>
                                            <span class="expand_infomain">(<?php echo $this->lang->line('active_action'); ?>: <font color="#FF0000"><?php echo $activeShopDefaults; ?></font>)</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="25" class="img_infomain"><img src="<?php echo base_url(); ?>templates/home/images/icon/shopping-icon.png" width="20"  border="0" /></td>
                                        <td width="100" class="list_infomain"><?php echo $this->lang->line('product_info'); ?>:</td>
                                        <td class="content_infomain">
                                            <?php echo $productDefaults; ?>
                                            <span class="expand_infomain">(<?php echo $this->lang->line('end_action'); ?>: <font color="#FF0000"><?php echo $endProductDefaults; ?></font>)</span>
                                        </td>
                                    </tr>
                                    <!--<tr>
                                        <td width="20" class="img_infomain"><img src="<?php echo base_url(); ?>templates/admin/images/icon_ads_infomain.gif" border="0" /></td>
                                        <td width="100" class="list_infomain"><?php echo $this->lang->line('ads_info'); ?>:</td>
                                        <td class="content_infomain">
                                            <?php echo $adsDefaults; ?>
                                            <span class="expand_infomain">(<?php echo $this->lang->line('end_action'); ?>: <font color="#FF0000"><?php echo $endAdsDefaults; ?></font>)</span>
                                        </td>
                                    </tr>-->
                                    <!--<tr>
                                        <td width="20" class="img_infomain"><img src="<?php echo base_url(); ?>templates/admin/images/icon_job_infomain.gif" border="0" /></td>
                                        <td width="100" class="list_infomain"><?php echo $this->lang->line('job_info'); ?>:</td>
                                        <td class="content_infomain">
                                            <?php echo $jobDefaults; ?>
                                            <span class="expand_infomain">(<?php echo $this->lang->line('end_action'); ?>: <font color="#FF0000"><?php echo $endJobDefaults; ?></font>)</span>
                                        </td>
                                    </tr>-->
                                    <!--<tr>
                                        <td width="20" class="img_infomain"><img src="<?php echo base_url(); ?>templates/admin/images/icon_employ_infomain.gif" border="0" /></td>
                                        <td width="100" class="list_infomain"><?php echo $this->lang->line('employ_info'); ?>:</td>
                                        <td class="content_infomain">
                                            <?php echo $employDefaults; ?>
                                            <span class="expand_infomain">(<?php echo $this->lang->line('end_action'); ?>: <font color="#FF0000"><?php echo $endEmployDefaults; ?></font>)</span>
                                        </td>
                                    </tr>-->
                                    <tr>
                                        <td width="25" class="img_infomain"><img src="<?php echo base_url(); ?>templates/home/images/icon/megaphone-icon.png" width="20"  border="0" /></td>
                                        <td width="100" class="list_infomain"><?php echo $this->lang->line('advertise_info'); ?>:</td>
                                        <td class="content_infomain">
                                            <?php echo $advertiseDefaults; ?>
                                            <span class="expand_infomain">(<?php echo $this->lang->line('end_action'); ?>: <font color="#FF0000"><?php echo $endAdvertiseDefaults; ?></font>)</span>
                                            <span class="expand_infomain">(<?php echo $this->lang->line('active_action'); ?>: <font color="#FF0000"><?php echo $activeAdvertiseDefaults; ?></font>)</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="25" class="img_infomain"><img src="<?php echo base_url(); ?>templates/home/images/icon/email-icon.png" width="20" border="0" /></td>
                                        <td width="100" class="list_infomain"><?php echo $this->lang->line('contact_info'); ?>:</td>
                                        <td class="content_infomain">
                                            <?php echo $contactDefaults; ?>
                                            <span class="expand_infomain">(<?php echo $this->lang->line('not_view_action'); ?>: <font color="#FF0000"><?php echo $notViewContactDefaults; ?></font>)</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="25" class="img_infomain"><img src="<?php echo base_url(); ?>templates/home/images/icon/cart-remove-icon.png" width="20"" border="0" /></td>
                                        <td width="120" class="list_infomain"><?php echo $this->lang->line('product_bad_info'); ?>:</td>
                                        <td class="content_infomain">
                                            <?php echo $productBadDefaults; ?>
                                        </td>
                                    </tr>
                                    <!--<tr>
                                        <td width="20" class="img_infomain"><img src="<?php echo base_url(); ?>templates/admin/images/icon_badads_infomain.gif" border="0" /></td>
                                        <td width="100" class="list_infomain"><?php echo $this->lang->line('ads_bad_info'); ?>:</td>
                                        <td class="content_infomain">
                                            <?php echo $adsBadDefaults; ?>
                                        </td>
                                    </tr>-->
                                </table>
<!--                                <br/>-->
                                
                                
                            </td>
                        </tr>
                        
                    </table>
                    <!--END Main-->
                </td>
                <td width="10" class="right_main" valign="top"></td>
                <td width="2"></td>
            </tr>
            <tr>
                <td width="2" height="11"></td>
                <td width="10" height="11" class="corner_lb_main" valign="top"></td>
                <td height="11" class="middle_bottom_main"></td>
                <td width="10" height="11" class="corner_rb_main" valign="top"></td>
                <td width="2" height="11"></td>
            </tr>
        </table>
    <?php }?>
    </td>
</tr>
<?php $this->load->view('admin/common/footer'); ?>