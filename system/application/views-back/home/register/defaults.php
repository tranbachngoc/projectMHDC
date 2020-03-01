<?php $this->load->view('home/common/account/header'); ?>
<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>templates/home/css/jScrollPane.css"/>
<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>templates/home/css/simplemodal.css" media='screen'/>
<script src="<?php echo base_url(); ?>templates/home/js/check_email.js"></script>
<script src="<?php echo base_url(); ?>templates/home/js/simplemodal.js"></script>
<?php
$url1 = $this->uri->segment(1);
$url2 = $this->uri->segment(2);
$url3 = $this->uri->segment(3);
$style = $_REQUEST['style'];
$group_id = (int)$this->session->userdata('sessionGroup');
?>
<style>
    .afstore {
        display: <?php if($url1 == 'register' && $url2 == '' ){ echo 'none'; }else{ echo 'block'; } ?>
    }

    .staff {
        display: <?php if(($url1 == 'account' && $url2 == 'staffs' && $url3 == 'add') || ($url1 == 'account' && $url2 == 'addbranch') || ($url1 == 'account' && $url2 == 'addstaffstore')){ echo 'none';}else{echo 'block';}?>
    }

    .staffon {
        display: <?php if(($url1 == 'account' && $url2 == 'staffs' && $url3 == 'add') || ($url1 == 'account' && $url2 == 'addbranch') || ($url1 == 'account' && $url2 == 'addstaffstore')){ echo 'block !important';}else{echo 'none';}?>
    }

    .none_member {
        display: <?php if(($url1 == 'register' && $url2 == '') || ($url1 == 'register' && $url2 == 'affiliate') || ($url1 == 'register' && $url2 == 'afstore') || ($url1 == 'register' && $url2 == 'estore') || ($url1 == 'account' && $url2 == 'staffs' && $url3 == 'add') || ($url1 == 'account' && $url2 == 'addbranch') || ($url1 == 'account' && $url2 == 'addstaffstore')){ echo 'none';}else{ echo 'block';} ?>
    }

</style>
<!--BEGIN: LEFT-->
<div id="main"
     class="<?php if (($this->uri->segment(2) == 'staffs' && $this->uri->segment(3) == 'add') || ($this->uri->segment(2) == 'tree' && $this->uri->segment(3) == 'request') || ($this->uri->segment(2) == 'addbranch') || ($this->uri->segment(2) == 'addstaffstore') || ($this->uri->segment(2) == 'addsubadmin')
     ) { ?>
  container-fluid
   <?php } else { ?>container-fluid <?php } ?> register">
    <div class="row">
		
	<?php if ($this->uri->segment(2) == 'affiliate' && $this->uri->segment(3) == 'pid') { ?>
    	
	<?php } else { ?>		
	    <?php if ($userId > 0) { ?>
		<?php $this->load->view('home/common/left'); ?>
	    <?php } ?>
	<?php } ?>        

        <div class="col-xs-12 <?php if (($this->uri->segment(2) == 'staffs' && $this->uri->segment(3) == 'add')
            || ($this->uri->segment(2) == 'tree' && $this->uri->segment(3) == 'request') || ($this->uri->segment(2) == 'addbranch') || ($this->uri->segment(2) == 'addstaffstore') || ($this->uri->segment(2) == 'addsubadmin')
        ) { ?>col-lg-9<?php } else { ?>col-lg-12 <?php } ?>">
            <?php if (($this->uri->segment(2) == 'staffs' && $this->uri->segment(3) == 'add')
                || ($this->uri->segment(2) == 'tree' && $this->uri->segment(3) == 'request') || ($this->uri->segment(2) == 'addbranch') || ($this->uri->segment(2) == 'addstaffstore') || ($this->uri->segment(2) == 'addsubadmin')
            ) { ?>
            <?php } else { ?>

            <?php } ?>
            <?php if (($this->uri->segment(2) == 'staffs' && $this->uri->segment(3) == 'add')
                || ($this->uri->segment(2) == 'tree' && $this->uri->segment(3) == 'request') || ($this->uri->segment(2) == 'addbranch') || ($this->uri->segment(2) == 'addstaffstore') || ($this->uri->segment(2) == 'addsubadmin')
            ) { ?>
            <?php } else { ?>
                <div class="breadcrumbs hidden-xs">
                    <a href="<?php echo base_url(); ?>">Trang chủ</a><i class="fa fa-angle-right"></i>
                    <span>

      <?php
      if ($this->uri->segment(2) == 'staffs') {
          echo "Thêm Nhân viên";
      } elseif ($this->uri->segment(2) == 'addstaffstore') {
          echo "Thêm Nhân Viên Gian Hàng";
      } elseif ($this->uri->segment(2) == 'addsubadmin') {
          echo "Thêm nhân viên hành chính";
      } elseif ($this->uri->segment(2) == 'addbranch') {
          echo "Thêm Chi Nhánh";
      } elseif ($this->uri->segment(2) == 'estore' || $this->uri->segment(2) == 'afstore') {
          echo "Đăng ký Gian hàng miễn phí";
      } elseif ($this->uri->segment(2) == 'affiliate') {
          echo "Đăng ký Cộng tác viên online miễn phí";
      } else {
          switch ($userGroup) {
              case Developer1User:
                  echo "Yêu cầu tạo Thành viên Cấp dưới: Developer 2";
                  break;
              case Partner2User:
                  echo "Yêu cầu tạo Thành viên Cấp dưới: Developer 1, Developer 2";
                  break;
              case Partner1User:
                  echo "Yêu cầu tạo Thành viên Cấp dưới: Partner2, Developer 1, Developer 2";
                  break;
              case CoreMemberUser:
                  echo "Yêu cầu tạo Thành viên Cấp dưới: Partner 1, Partner2, Developer 1, Developer 2";
                  break;
              case CoreAdminUser:
                  echo "Yêu cầu tạo Thành viên Cấp dưới: Core Member, Partner 1, Partner2, Developer 1, Developer 2";
                  break;
              default:
                  echo "Đăng ký thành viên";
                  break;
          }
      }
      ?>
    </span>
                </div>
            <?php }
            if ($this->uri->segment(2) == 'afstore' || $this->uri->segment(2) == 'estore') { ?>

                <div class="tile_Register row">
                    <h3>những lợi ích mà azibai mang đến cho doanh nghiệp</h3>
                    <hr>
                </div>
                <div id="box-db" class="row">
                    <div class="col-md-6"><img class="fa_border"
                                               src="<?php echo base_url() ?>templates/home/images/register/icon-1.png"
                                               alt="">
                        <a href="#Modal1" data-toggle="modal" title="">Mở trên cơ sở chi nhánh kinh doanh trực tuyến</a>
                    </div>
                    <div id="Modal1" class="modal fade">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×
                                    </button>
                                    <h4 class="modal-title">Mở trên cơ sở chi nhánh kinh doanh trực tuyến</h4>
                                </div>
                                <div class="modal-body">
                                    <iframe width="100%" height="315"
                                            src="https://www.youtube.com/embed/ky1aQoQN0yE?list=PLaUbMsdTLfdwI7Wa7OmhQlvcNp6mD8KHA"
                                            frameborder="0" allowfullscreen></iframe>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6"><img class="fa_border"
                                               src="<?php echo base_url() ?>templates/home/images/register/icon-2.png"
                                               alt="">
                        <a href="#Modal2" data-toggle="modal" title="">Tăng doanh thu bình quân của hệ thống cộng tác
                            viên online</a></div>
                    <div id="Modal2" class="modal fade">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×
                                    </button>
                                    <h4 class="modal-title">Tăng doanh thu bình quân của hệ thống cộng tác viên
                                        online</h4>
                                </div>
                                <div class="modal-body">
                                    <iframe width="100%" height="315"
                                            src="https://www.youtube.com/embed/qRuYAWtTUzk?list=PLaUbMsdTLfdwI7Wa7OmhQlvcNp6mD8KHA"
                                            frameborder="0" allowfullscreen></iframe>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6"><img class="fa_border"
                                               src="<?php echo base_url() ?>templates/home/images/register/icon-3.png"
                                               alt="">
                        <a href="#Modal3" data-toggle="modal" title="">Xây dựng đội ngũ nhân viên kinh doanh không trả
                            lương</a></div>

                    <div id="Modal3" class="modal fade">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×
                                    </button>
                                    <h4 class="modal-title">Xây dựng đội ngũ nhân viên kinh doanh không trả lương</h4>
                                </div>
                                <div class="modal-body">
                                    <iframe width="100%" height="315"
                                            src="https://www.youtube.com/embed/Q4dSrvd9bxU?list=PLaUbMsdTLfdwI7Wa7OmhQlvcNp6mD8KHA"
                                            frameborder="0" allowfullscreen></iframe>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6"><img class="fa_border"
                                               src="<?php echo base_url() ?>templates/home/images/register/icon-4.png"
                                               alt="">
                        <a href="#Modal4" data-toggle="modal" title="">Tăng doanh thu bình quân của nhân viên kinh doanh
                            hiện có</a></div>
                    <div id="Modal4" class="modal fade">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×
                                    </button>
                                    <h4 class="modal-title">Tăng doanh thu bình quân của nhân viên kinh doanh hiện
                                        có</h4>
                                </div>
                                <div class="modal-body">
                                    <iframe width="100%" height="315"
                                            src="https://www.youtube.com/embed/bMriCQJrPUU?list=PLaUbMsdTLfdwI7Wa7OmhQlvcNp6mD8KHA"
                                            frameborder="0" allowfullscreen></iframe>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6"><img class="fa_border"
                                               src="<?php echo base_url() ?>templates/home/images/register/icon-5.png"
                                               alt="">
                        <a href="#Modal5" data-toggle="modal" title="">Tạo ra thêm được kênh kinh doanh mới</a></div>
                    <div id="Modal5" class="modal fade">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×
                                    </button>
                                    <h4 class="modal-title">Tạo ra thêm được kênh kinh doanh mới</h4>
                                </div>
                                <div class="modal-body">
                                    <iframe width="100%" height="315"
                                            src="https://www.youtube.com/embed/3qTw7rNYtug?list=PLaUbMsdTLfdwI7Wa7OmhQlvcNp6mD8KHA"
                                            frameborder="0" allowfullscreen></iframe>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6"><img class="fa_border"
                                               src="<?php echo base_url() ?>templates/home/images/register/icon-6.png"
                                               alt="">
                        <a href="#Modal6" data-toggle="modal" title="">Giữ khách hàng cũ. Nâng cao chất lượng chăm sóc
                            khách hàng</a></div>
                    <div id="Modal6" class="modal fade">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×
                                    </button>
                                    <h4 class="modal-title">Giữ khách hàng cũ. Nâng cao chất lượng chăm sóc khách
                                        hàng</h4>
                                </div>
                                <div class="modal-body">
                                    <iframe width="100%" height="315"
                                            src="https://www.youtube.com/embed/wcuRxC9e1BA?list=PLaUbMsdTLfdwI7Wa7OmhQlvcNp6mD8KHA"
                                            frameborder="0" allowfullscreen></iframe>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6"><img class="fa_border"
                                               src="<?php echo base_url() ?>templates/home/images/register/icon-7.png"
                                               alt="">
                        <a href="#Modal7" data-toggle="modal" title="">Đa dạng hóa sản phẩm. Tiếp cận gần hơn đến người
                            tiêu dùng</a></div>

                    <div id="Modal7" class="modal fade">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×
                                    </button>
                                    <h4 class="modal-title">Đa dạng hóa sản phẩm. Tiếp cận gần hơn đến người tiêu
                                        dùng</h4>
                                </div>
                                <div class="modal-body">
                                    <iframe width="100%" height="315"
                                            src="https://www.youtube.com/embed/00pZdj7KCfU?list=PLaUbMsdTLfdwI7Wa7OmhQlvcNp6mD8KHA"
                                            frameborder="0" allowfullscreen></iframe>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6"><img class="fa_border"
                                               src="<?php echo base_url() ?>templates/home/images/register/icon-8.png"
                                               alt="">
                        <a href="#Modal8" data-toggle="modal" title="">Tính khả thi cao</a></div>
                    <div id="Modal8" class="modal fade">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×
                                    </button>
                                    <h4 class="modal-title">Đa dạng hóa sản phẩm. Tiếp cận gần hơn đến người tiêu
                                        dùng</h4>
                                </div>
                                <div class="modal-body">
                                    <iframe width="100%" height="315"
                                            src="https://www.youtube.com/embed/yt8M8nyV428?list=PLaUbMsdTLfdx90ihpfyFkKrnv1N32c9DA"
                                            frameborder="0" allowfullscreen></iframe>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            <?php } ?>
            <?php if ($stopRegister == false) { ?>
                <?php if ($successRegister == false) { ?>
                    <form name="frmRegister" id="frmRegister" method="post" enctype="multipart/form-data" style="margin-top: 20px;">
                        <?php if ($userGroup > 0) { ?>

                        <?php } ?>
                        <?php
                        if ($this->uri->segment(2) == 'staffs') {
                            echo "<div class='tile_Register row'> <h3>Thêm Nhân viên</h3><hr></div>";
                        } elseif ($this->uri->segment(2) == 'addstaffstore') {
                            echo "<div class='tile_Register row'> <h3>Thêm Nhân Viên Gian Hàng</h3><hr></div>";
                        } elseif ($this->uri->segment(2) == 'addsubadmin') {
                            echo "<div class='tile_Register row'> <h3>Thêm nhân viên hành chính</h3><hr></div>";
                        } elseif ($this->uri->segment(2) == 'addbranch') {
                            echo "<div class='tile_Register row'> <h3>Thêm Chi Nhánh</h3><hr></div>";
                        } elseif ($this->uri->segment(2) == 'estore' || $this->uri->segment(2) == 'afstore') {
                            echo "<div class='tile_Register row'> <h3>Đăng ký Gian hàng miễn phí</h3><hr></div>";
                        } elseif ($this->uri->segment(2) == 'affiliate') {
                            echo "<div class='tile_Register row'> <h3>Đăng ký Cộng tác viên online miễn phí</h3><hr></div>";
                        } else {
                            if ($this->uri->segment(2) == 'tree' && $this->uri->segment(3) == 'request' && $this->uri->segment(4) == 'member') {
                                echo "Yêu cầu tạo Thành viên Cấp dưới: ";
//                                echo '<div class="form-group buyer none_member staffon">';
                                $checkedCR = $checkedP1 = $checkedP2 = $checkedD1 = $checkedD2 = '';
                                $displayP1 = $displayP2 = $displayD1 = $displayD2 = '';
                                $displayCR = 'display:none';
                                switch ($userGroup) {
                                    case Developer1User:
//                                        echo "Yêu cầu tạo Thành viên Cấp dưới: Developer 2</div>";
                                        $checkedD2 = 'checked="true"';
                                        $displayP1 = $displayP2 = $displayD1 = 'display:none';
                                        break;
                                    case Partner2User:
//                                    echo "Yêu cầu tạo Thành viên Cấp dưới: Developer 1, Developer 2</div>";
                                        $checkedD1 = 'checked="true"';
                                        $displayP1 = $displayP2 = 'display:none';
                                        break;
                                    case Partner1User:
                                        $checkedP2 = 'checked="true"';
                                        $displayP1 = 'display:none';
                                        break;
                                    case CoreMemberUser:
//                                    echo "Yêu cầu tạo Thành viên Cấp dưới: Partner 1, Partner 2, Developer 1, Developer 2</div>";
                                        $checkedP1 = 'checked="true"';
                                        break;
                                    case CoreAdminUser:
//                                    echo "Yêu cầu tạo Thành viên Cấp dưới: Core Member, Partner 1, Partner2, Developer 1, Developer 2</div>";
                                        $checkedCR = 'checked="true"';
                                        $displayCR = 'display:block';
                                        echo '<br/>';
                                        break;
                                    default:
                                        $displayCR = $displayP1 = $displayP2 = $displayD1 = $displayD2 = 'display:none';
                                        echo " <div class='tile_Register row'> <h3>Đăng ký thành viên</h3><hr></div>";
                                        break;
                                }
//                            echo '</div>';
                                $CoreMember = '<input type="radio" value="' . CoreMemberUser . '" name="treegroup" id="" ' . $checkedCR . ' style="margin-left: 10px; ' . $displayCR . '"/> <label for="group" style="' . $displayCR . '">Core member</label>';
                                $P1 = '<input type="radio" value="' . Partner1User . '" name="treegroup" id="" ' . $checkedP1 . ' style="margin-left: 10px; ' . $displayP1 . '"/> <label for="group" style="' . $displayP1 . '">Partner 1</label>';
                                $P2 = '<input type="radio" value="' . Partner2User . '" name="treegroup" id="" ' . $checkedP2 . ' style="margin-left: 10px; ' . $displayP2 . '"/> <label for="group" style="' . $displayP2 . '">Partner 2</label>';
                                $D1 = '<input type="radio" value="' . Developer1User . '" name="treegroup" id="" ' . $checkedD1 . ' style="margin-left: 10px; ' . $displayD1 . '"/> <label for="group" style="' . $displayD1 . '">Developer 1</label>';
                                $D2 = '<input type="radio" value="' . Developer2User . '" name="treegroup" id="" ' . $checkedD2 . ' style="margin-left: 10px; ' . $displayD2 . '"/> <label for="group" style="' . $displayD2 . '">Developer 2</label>';
                                echo $CoreMember . $P1 . $P2 . $D1 . $D2;
                            }
                        } ?>

                        <?php if ($stopRegister == false) { ?>
                            <?php if ($successRegister == false) {
                            $is_account = $this->uri->segment(1);
                            if ($is_account == "account") {
                                $clas = "col-md-6 col-sm-12 col-xs-12 col-md-offset-3";
                            } elseif ($url2 == 'affiliate') {
                                $clas = "col-md-6 col-sm-12 col-xs-12 col-md-offset-3";
                            } else {
                                $clas = "col-md-6 col-sm-12 col-xs-12 col-md-offset-3";
                            }
                            ?>
                            <!-- Begin Show error if have -->
                            <?php
                        if ($this->session->flashdata('flash_message_success') || $this->session->flashdata('flash_message_error')) {
                            ?>
                            <div class="message success">
                                <div
                                    class="alert <?php echo($this->session->flashdata('flash_message_error') ? 'alert-danger' : 'alert-success') ?>">
                                    <?php echo($this->session->flashdata('flash_message_error') ? $this->session->flashdata('flash_message_error') : $this->session->flashdata('flash_message_success')); ?>
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                </div>
                            </div>
                        <?php } ?>
                            <!-- End Show error if have -->
                        <?php
                        if($shopactive && $shopactive == 1){
                        ?>
                            <div class="message success">
                                <div class="alert" style="background-color: #fbf69b; border-color: #fbf69b;">
                                    Link đăng ký cộng tác viên này không còn hoạt động, 
                                    bạn có thể đăng ký tài khoản gian hàng để kinh doanh và làm cộng tác viên cho gian hàng khác tăng thu nhập <b><a href="/register/verifycode">tại đây</a></b>
                                </div>
                            </div>
                        <?php
                        }else{
                        ?>
                            <div class="row wrap_regis">
                                <div id="box_regis_1" class="<?php echo $clas; ?>">
                                    <?php /*if ($userId > 0 && ($this->uri->segment(2) != 'staffs') && ($this->uri->segment(2) != 'addbranch') && ($this->uri->segment(2) != 'addstaffstore')) { ?>
                                            <div class="form-group">                                               
                                                
                                                    <select name="group_regis" id="group_regis" class="form-control">
                                                        
                                                        <option value="">Chọn nhóm</option>
                                                        <?php if ($userGroup == Developer1User) { ?>
                                                            <option value="6">Developer 2</option>
                                                        <?php } ?>
                                                        <?php if ($userGroup == Partner2User) { ?>
                                                            <option value="6">Developer 2</option>
                                                            <option value="7">Developer 1</option>
                                                        <?php } ?>
                                                        <?php if ($userGroup == Partner1User) { ?>
                                                            <option value="6">Developer 2</option>
                                                            <option value="7">Developer 1</option>
                                                            <option value="8">Partner 2</option>
                                                        <?php } ?>
                                                        <?php if ($userGroup == CoreMemberUser) { ?>
                                                            <option value="6">Developer 2</option>
                                                            <option value="7">Developer 1</option>
                                                            <option value="8">Partner 2</option>
                                                            <option value="9">Partner 1</option>
                                                        <?php } ?>

                                                        <?php if ($userGroup == CoreAdminUser) { ?>
                                                            <option value="6">Developer 2</option>
                                                            <option value="7">Developer 1</option>
                                                            <option value="8">Partner 2</option>
                                                            <option value="9">Partner 1</option>
                                                            <option value="10">Core Member</option>
                                                        <?php } ?>
                                                    </select>
                                               
                                            </div>
                                        <?php } */ ?>
                                    <input id="style_id" name="style_id" value="<?php echo $style; ?>"
                                           type="hidden">
                                    <?php if ($this->uri->segment(3) == 'request' && $this->uri->segment(4) == 'member') { ?>
                                        <div class="form-group buyer none_member staffon" style="display: none">
                                            <input type="radio" value="1" name="options_name" id="options_name_1"
                                                   checked=""/> <label for="options_name_1">Cá nhân</label>
                                            <input type="radio"
                                                   value="2" <?php if (isset($options_name) && $options_name == 2) {
                                                echo 'checked="checked"';
                                            } ?> name="options_name" id="options_name_2"/>
                                            <label for="options_name_2">Công ty</label>
                                        </div>
                                    <?php } ?>

                                    <?php if ($this->uri->segment('3') == 'add' && $group_id == AffiliateStoreUser) { ?>
                                        <div class="form-group">
                                            <label>
                                                <input type="checkbox" name="checkopenCN"/>
                                                Nhân viên mở chi nhánh
                                            </label>
                                        </div>
                                    <?php } ?>

                                    <div class="form-group buyer none_member staffon">
                                        <div class="input-group">
					    <span class="input-group-addon"><i class="fa fa-user"></i></span>
					    <input type="text" value="<?php if (isset($fullname_regis)) {
						echo $fullname_regis;
					    } ?>" name="fullname_regis" id="fullname_regis"
						   placeholder="<?php echo $this->lang->line('fullname_defaults'); ?> hoặc Tên công ty viết tắt"
						   maxlength="80" class="form-control"
						   onkeyup="BlockChar(this,'SpecialChar'); CapitalizeNames('frmRegister','fullname_regis');"
						   onfocus="ChangeStyle('fullname_regis',1)"
						   onblur="ChangeStyle('fullname_regis',2)"/>
					</div>
                                        <?php echo form_error('fullname_regis'); ?>
                                    </div>

                                    <div id="group_company" style="display:none;">
                                        <div class="form-group buyer none_member staffon">
					    <div class="input-group">
						<span class="input-group-addon"><i class="fa fa-user"></i></span>
						<input type="text" value="<?php if (isset($company_name)) {
						    echo $company_name;
						} ?>" name="company_name" class="form-control"
						       placeholder="Tên công ty đầy đủ"/>
					    </div>
                                        </div>
                                        <div class="form-group buyer none_member staffon">
                                            <div class="input-group">
						<span class="input-group-addon"><i class="fa fa-user"></i></span>
						<input type="text" value="<?php if (isset($company_agent)) {
						    echo $company_agent;
						} ?>" name="company_agent" class="form-control"
						       placeholder="Người đại diện"/>
					    </div>
                                        </div>
                                        <div class="form-group buyer none_member staffon">
                                            <div class="input-group">
						<span class="input-group-addon"><i class="fa fa-user"></i></span>
						<input type="text" value="<?php if (isset($company_position)) {
						    echo $company_position;
						} ?>" name="company_position" class="form-control"
						       placeholder="Chức vụ"/>
					    </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group">
					    <span class="input-group-addon"><i class="fa fa-user fa-fw"></i></span>
					    <input type="text" value="<?php if (isset($username_regis)) {
						echo $username_regis;
					    } ?>" class="form-control" name="username_regis" id="username_regis"
						   onblur="
						       checkUsername(this.value,'<?php echo base_url(); ?>')"
						   placeholder="Tên đăng nhập"
						   onkeyup="Notspace(this.value,'username_regis')" required/>
					</div>
					<?php echo form_error('username_regis'); ?>
                                    </div>
                                    <div class="form-group" style="display:none">
                                        <label for="inputEmail3"
                                               class="col-sm-2 control-label"><?php echo $this->lang->line('member_type'); ?>
                                            :</label>

                                        <div class="col-sm-3">
                                            <label>
                                                <input checked="checked" class="member_type" type="radio"
                                                       name="member_type" value="0" id="member_type_0"/>
                                                Miễn phí</label>
                                            <label>
                                                <input class="member_type" type="radio" name="member_type" value="1"
                                                       id="member_type_3"/>
                                                Đã thu phí</label>
                                            <input name="type_value" id="type_value" type="hidden" value=""/>
                                        </div>
                                    </div>

                                    <div class="form-group" style="display:none;">
                                        <input type="text" value="<?php if (isset($username_regis)) {
                                            echo $username_regis;
                                        } ?>" name="active_code" id="active_code" class="form-control"
                                               placeholder="<?php echo $this->lang->line('active_code'); ?>"
                                               onchange="checkActiveCode(this.value,'<?php echo base_url(); ?>')"/>
                                        <img src="<?php echo base_url(); ?>templates/home/images/help_post.gif"
                                             onmouseover="ddrivetip('<?php echo $this->lang->line('active_code_help') ?>',275,'#F0F8FF');"
                                             onmouseout="hideddrivetip();" class="img_helppost"/> <span
                                            class="div_helppost">(<?php echo $this->lang->line('active_code_text'); ?>
                                            )</span>
                                    </div>
                                    <!-- ltngan -->

                                    <div id="register" class="form-group">
                                        <div class="input-group">
                                                <span class="input-group-addon">
                                                        <i class="fa fa-unlock-alt fa-fw"></i>
                                                </span>
                                                <input type="password" value="" name="password_regis" id="password_regis"
                                                   placeholder="<?php echo $this->lang->line('password_defaults'); ?>"
                                                   class="form-control"/>
                                        </div>    
                                        <span id="result"></span>
                                    </div>
                                    <?php if ($url2 != 'addsubadmin'){//$this->uri->segment(3) != 'request' && $this->uri->segment(4) != 'member') { ?>
                                    <div class="form-group">
                                        <div class="input-group">
					    <span class="input-group-addon"><i class="fa fa-unlock-alt fa-fw"></i></span>
					    <input type="password" value="" name="repassword_regis"
						   id="repassword_regis" class="form-control"
						   placeholder="<?php echo $this->lang->line('repassword_defaults'); ?>"
						   onfocus="ChangeStyle('repassword_regis',1)"
						   onblur="ChangeStyle('repassword_regis',2)"/>
					</div>
                                        <?php echo form_error('repassword_regis'); ?>
                                    </div>
                                    <?php  } ?>
                                    <div class="form-group">
                                        <div class="input-group">
					    <span class="input-group-addon"><i class="fa fa-envelope fa-fw"></i></span>
					    <input type="text" value="<?php if (isset($email_regis)) {
						echo $email_regis;
					    } elseif ($this->session->userdata('sessionEmailnewsletter') != "") {
						echo $this->session->userdata('sessionEmailnewsletter');
					    } ?>" name="email_regis" id="email_regis"
						   placeholder="<?php echo $this->lang->line('email_defaults'); ?>"
						   class="form-control" onkeyup="BlockChar(this,'SpecialChar')"
						   onblur="checkEmailexit(this.value, '<?php echo base_url(); ?>')"/>
					</div>
                                        <?php echo form_error('email_regis'); ?>
                                    </div>
                                    <?php if ($this->uri->segment(3) != 'request' && $this->uri->segment(4) != 'member' && $url2 != 'addsubadmin') { ?>
                                        <div class="form-group <?php if ($url2 != 'affiliate') { ?> none_member <?php } ?>">
                                            <div class="input-group">
												<span class="input-group-addon"><i class="fa fa-envelope fa-fw"></i></span>
												<input type="text" value="<?php if (isset($reemail_regis)) {
													echo $reemail_regis; } ?>" 
													name="reemail_regis" id="reemail_regis"
													   placeholder="<?php echo $this->lang->line('reemail_defaults'); ?>"
													   class="form-control" onkeyup="BlockChar(this,'SpecialChar')"
													   onfocus="ChangeStyle('reemail_regis',1)"
													   onblur="ChangeStyle('reemail_regis',2) ; lowerCase(this.value,'reemail_regis');"/>
												
											</div>
											<?php echo form_error('reemail_regis'); ?>
                                        </div>
                                    <?php } ?>
                                    <div class="form-group">
                                        <div class="input-group">
					    <span class="input-group-addon"><i class="fa fa-phone"></i></span>
					    <input type="text"
						   value="<?php echo $users->use_mobile; ?><?php if (isset($mobile_regis)) {
						       echo $mobile_regis;
						   } ?>" name="mobile_regis" id="mobile_regis" maxlength="20"
						   class="form-control" placeholder="Điện thoại di động"
						   onblur="checkUserMobile(this.value, '<?php echo base_url(); ?>','<?php echo $url2 ?>')"
					    />
					</div>
                                    </div>

                                    <?php if ($this->uri->segment(3) != 'add' && $url2 != 'addsubadmin') { ?>
                                        <div class="form-group none_member" id="company_phone">
                                            <div class="input-group">
						<span class="input-group-addon"><i class="fa fa-phone"></i></span>
                                            <input type="text" value="<?php if (isset($phone_regis)) {
                                                echo $phone_regis;
                                            } ?>" name="phone_regis" id="phone_regis" placeholder="Điện thoại bàn"
                                                   maxlength="20" class="form-control "
                                                   onfocus="ChangeStyle('phone_regis',1)"
                                                   onblur="ChangeStyle('phone_regis',2)"/>
					    </div>
                                            <?php echo form_error('mobile_regis'); ?>
                                        </div>
                                    <?php } ?>
                                    <div class="form-group buyer none_member staffon">
					<div class="input-group">
					     <span class="input-group-addon">
						 <i class="fa fa-map-marker fa-fw"></i>
					     </span>
					    <input type="text" value="<?php if (isset($address_regis)) {
                                            echo $address_regis;
						} ?>" name="address_regis" id="address_regis"
                                               placeholder="<?php echo $this->lang->line('address_defaults'); ?>"
                                               maxlength="80" class="form-control"
                                               onfocus="ChangeStyle('address_regis',1)"
                                               onblur="ChangeStyle('address_regis',2)"/>
					</div>
					<?php echo form_error('address_regis'); ?>
                                    </div>
                                    <?php // if (in_array($this->uri->segment(2),array("afstore","true","affiliate","staffs"))) { ?>
                                    <div class="form-group">
                                        <div class="input-group">
					    <span class="input-group-addon"><i class="fa fa-shield fa-rotate-270"></i></span>

					    <select name="province_regis" id="user_province_get" class="form-control">
						<option value="">Chọn Tỉnh/Thành</option>
						<?php foreach ($province as $vals): ?>
						    <?php if (($this->input->post('province_regis') == $vals->pre_id) || ($users->use_province == $vals->pre_id)): ?>
							<?php $selected = 'selected="selected"'; ?>
						    <?php else: ?>
							<?php $selected = ''; ?>
						    <?php endif; ?>
						    <option
							value="<?php echo $vals->pre_id; ?>" <?php echo $selected; ?>><?php echo $vals->pre_name; ?></option>
						<?php endforeach; ?>
					    </select>
					</div>
                                        <?php echo form_error('province_regis'); ?>
                                    </div>
                                    <?php // } ?>
                                    <?php // if (in_array($this->uri->segment(2),array("afstore","true","affiliate","staffs"))) { ?>
                                    <div class="form-group">
                                        <div class="input-group">
					    <span class="input-group-addon"><i class="fa fa-shield fa-rotate-270"></i></span>
					    <select name="district_regis" id="user_district_get" class="form-control">
						<option value="">Chọn Quận/Huyện</option>
						<?php if (isset($district_list)): ?>
						    <?php foreach ($district_list as $vals): ?>
							<?php if ($this->input->post('district_regis') == $vals['DistrictCode']): ?>
							    <?php $selected = 'selected="selected"'; ?>
							<?php else: ?>
							    <?php $selected = ''; ?>
							<?php endif; ?>
							<option
							    value="<?php echo $vals['DistrictCode']; ?>" <?php echo $selected; ?>><?php echo $vals['DistrictName']; ?></option>
						    <?php endforeach; ?>
						<?php else: ?>
						    <option
							<?php if (isset($district_regis) && $district_regis == $district[0]->DistrictCode) {
							    echo 'selected = "selected"';
							} ?>value="<?php echo $district[0]->DistrictCode; ?>"><?php echo $district[0]->DistrictName; ?></option>
						<?php endif; ?>
					    </select>
					</div>
                                        <?php echo form_error('district_regis'); ?>
                                    </div>
                                    <?php // } ?>

                                    <?php if ($url2 == 'afstore' || $url2 == 'affiliate' || $url2 == 'estore') { ?>
                                        <?php if ($this->uri->segment(3) != 'pid' && $url2 != 'affiliate') { ?>
                                            <?php if (!isset($users)) { ?>
                                                <div class="form-group">
                                                    <i class="fa fa-hand-pointer-o"></i>
                                                    <input type="text" value="" name="sponsor" id="sponsor"
                                                           class="form-control" placeholder="ID kích hoạt gian hàng"
                                                           onfocus=""
                                                           onblur="checkSponsor(this.value,'<?php echo base_url(); ?>')"/>
                                                    <img
                                                        src="<?php echo base_url(); ?>templates/home/images/help_post.gif"
                                                        onmouseover="ddrivetip('<?php echo $this->lang->line('password_tip_help') ?>',275,'#F0F8FF');"
                                                        onmouseout="hideddrivetip();" class="img_helppost"/>
                                                    <span class="div_helppost"><i>(Mời bạn liên lạc với tư vấn viên để lấy địa chỉ email hoặc số ID để kích hoạt gian hàng)</i></span>
                                                </div>
                                            <?php }
                                        } ?>
                                    <?php } ?>
                                    <?php if ($url2 != 'affiliate' && $url2 != 'addsubadmin') { ?>
                                        <div class="form-group afstore" id="afstore_card">
                                            <div class="input-group">
						<span class="input-group-addon">
						    <i class="fa fa-credit-card fa-fw"></i>
						</span>
						<input type="text"
                                                   value="<?php echo $users->id_card; ?><?php if (isset($idcard_regis)) {
                                                       echo $idcard_regis;
                                                   } ?>" name="idcard_regis" id="idcard_regis" maxlength="20"
                                                   placeholder="Số chứng minh nhân dân"
                                                   onblur="checkUserIdcard_reg(this.value, '<?php echo base_url(); ?>', '<?php echo $url2 ?>')"
                                                   class="form-control"/>
					    </div>
                                            <?php echo form_error('idcard_regis'); ?>
                                        </div>
                                        <?php if ($url1 == 'register' && $url2 == 'affiliate') { ?>
                                            <div id="taxcode_regis_row" class="form-group afstore">
                                                <div class="input-group">
						    <span class="input-group-addon">
							<i class="fa fa-database fa-fw"></i>
						    </span>
						    <input type="text"
                                                       value="<?php echo $users->tax_code; ?><?php if (isset($taxcode_regis)) {
                                                           echo $taxcode_regis;
                                                       } ?>" name="taxcode_regis" id="taxcode_regis"
                                                       onblur="checkUserTaxcode_reg(this.value, '<?php echo base_url(); ?>','<?php echo $url2 ?>')"
                                                       placeholder="Mã số thuế cá nhân"
                                                       maxlength="20" class="form-control "/>
						</div>
                                                <p><input type="checkbox" id="check_notaxcode" name="check_notaxcode"/>
                                                    Tôi chưa có Mã số thuế</p>
                                                <p class="text-warning">
                                                    <i>(Nếu chưa có MST cá nhân, bạn vẫn có thể tham gia kinh doanh trên
                                                        Azibai. Tuy nhiên, theo quy định của pháp luật, bạn sẽ bị khấu
                                                        trừ 20% thuế thu nhập thay vì 10% như khi đã có MST)</i></p>
                                                <?php echo form_error('taxcode_regis'); ?>
                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group afstore">
                                                <label><input type="checkbox" name="taxtype_regis"
                                                              id="tax_code_personal" class="tax_type"
                                                              checked="checked" value="0"/>&nbsp;Mã số thuế cá
                                                    nhân</label>&nbsp;&nbsp;&nbsp;
                                                <label><input type="checkbox" name="taxtype_regis" id="tax_code_company"
                                                              class="tax_type"
                                                              value="1"/>&nbsp;Mã số thuế doanh nghiệp</label>
                                            </div>
                                            <div class="form-group afstore">
						<div class="input-group">
						    <span class="input-group-addon">
							<i class="fa fa-database"></i>
						    </span>	
						    <input type="text"
                                                       value="<?php echo $users->tax_code; ?><?php if (isset($taxcode_regis)) {
                                                           echo $taxcode_regis;
                                                       } ?>" name="taxcode_regis"
                                                       id="taxcode_regis" <?php if (isset($taxtype_regis) && $taxtype_regis == 1) {
                                                    echo ' checked="checked"';
                                                } ?>
                                                       onblur="checkUserTaxcode_reg(this.value, '<?php echo base_url(); ?>','<?php echo $url2 ?>')"
                                                       placeholder="Mã số thuế"
                                                       maxlength="20" class="form-control "/>
						</div>
                                                <?php echo form_error('taxcode_regis'); ?>
                                            </div>

                                            <div class="form-group afstore">
						<div class="input-group">
						    <span class="input-group-addon">
							<i class="fa fa-comment"></i>
						    </span>                                               
						    <input type="text"
                                                       value="<?php echo $users->use_message; ?><?php if (isset($message_regis)) {
                                                           echo $message_regis;
                                                       } ?>" name="message_regis"
                                                       id="messages_regis" <?php if (isset($taxtype_regis) && $taxtype_regis == 1) {
							    echo ' checked="checked"';
							} ?>
                                                       onblur="checkUserTaxcode_reg(this.value, '<?php echo base_url(); ?>','<?php echo $url2 ?>')"
                                                       placeholder="https://www.facebook.com/messages/t/726068167537746"
                                                       maxlength="255" class="form-control "/>
						</div>
                                                <?php echo form_error('message_regis'); ?>
                                            </div>


                                        <?php }
                                    } ?>
                                    <?php if ($this->uri->segment(2) != '' && $url2 != 'affiliate' && $url2 != 'addsubadmin') { ?>
                                        <div class="form-group afstore <?php echo $url1 == 'register' ? '' : 'staff'; ?> ">
                                            <div class="input-group">
						<span class="input-group-addon">
						    <i class="fa fa-university"></i>
						</span>
						<input type="text"
                                                   value="<?php echo $users->bank_name; ?><?php if (isset($namebank_regis)) {
                                                       echo $namebank_regis;
                                                   } ?>" name="namebank_regis" id="namebank_regis"
                                                   placeholder="Tên ngân hàng" class="form-control"/>
					    </div>
                                            <?php echo form_error('namebank_regis'); ?>
                                        </div>
                                        <div  class="form-group afstore <?php echo $url1 == 'register' ? '' : 'staff'; ?> ">
					    <div class="input-group">
						<span class="input-group-addon">
						    <i class="fa fa-globe"></i>
						</span>
						<input type="text"
                                                   value="<?php echo $users->bank_add; ?><?php if (isset($addbank_regis)) {
                                                       echo $addbank_regis;
                                                   } ?>" name="addbank_regis" id="addbank_regis"
                                                   placeholder="Thuộc chi nhánh nào?" class="form-control "/>
					    </div>
                                            <?php echo form_error('addbank_regis'); ?>
                                        </div>
                                        <div class="form-group afstore <?php echo $url1 == 'register' ? '' : 'staff'; ?> ">
                                            <div class="input-group">
						<span class="input-group-addon">
						    <i class="fa fa-graduation-cap"></i>
						</span>
						<input type="text"
                                                   value="<?php echo $users->account_name; ?><?php if (isset($accountname_regis)) {
                                                       echo $accountname_regis;
                                                   } ?>" name="accountname_regis" id="accountname_regis"
                                                   placeholder="Họ và tên chủ tài khoản" class="form-control "/>
					    </div>
                                            <?php echo form_error('accountname_regis'); ?>
                                        </div>
                                        <div class="form-group afstore <?php echo $url1 == 'register' ? '' : 'staff'; ?> ">
                                            <div class="input-group">
						<span class="input-group-addon">
						    <i class="fa fa-hashtag"></i>
						</span>
						<input type="text"
                                                   value="<?php echo $users->num_account; ?><?php if (isset($accountnum_regis)) {
                                                       echo $accountnum_regis;
                                                   } ?>" name="accountnum_regis" id="accountnum_regis"
                                                   placeholder="Số tài khoản" class="form-control "/>
					    </div>
					    <?php echo form_error('accountnum_regis'); ?>
                                        </div>

                                        <!-- <div class="form-group none_member">
                                                <i class="fa fa-yahoo"></i>
                                                <input type="text" value="<?php if (isset($yahoo_regis)) {
                                            echo $yahoo_regis;
                                        } ?>" name="yahoo_regis" id="yahoo_regis"
                                                       placeholder="<?php echo $this->lang->line('yahoo_defaults'); ?>"
                                                       maxlength="50" class="form-control"
                                                       onkeyup="BlockChar(this,'SpecialChar')"
                                                       onfocus="ChangeStyle('yahoo_regis',1)"
                                                       onblur="ChangeStyle('yahoo_regis',2)"/>
                                                <?php echo form_error('yahoo_regis'); ?>
                                            </div> 
                                           <div class="form-group none_member">
                                                <i class="fa fa-skype"></i>
                                                <input type="text" value="<?php if (isset($skype_regis)) {
                                            echo $skype_regis;
                                        } ?>" name="skype_regis" id="skype_regis"
                                                       placeholder="<?php echo $this->lang->line('skype_defaults'); ?>"
                                                       maxlength="50" class="form-control"
                                                       onkeyup="BlockChar(this,'SpecialChar')"
                                                       onfocus="ChangeStyle('skype_regis',1)"
                                                       onblur="ChangeStyle('skype_regis',2)"/>
                                                <?php echo form_error('skype_regis'); ?>
                                            </div> -->

                                    <?php } ?>
                                    <?php if ($userId <= 0) { ?>
                                        <div class="form-group none_member">
                                            <label for="avatar"
                                                   class="col-sm-2 control-label"><?php echo $this->lang->line('avatar_defaults'); ?>
                                                :</label>
                                            <input type="file" size="25" name="avatar" id="avatar"
                                                   class="form-control"/>
                                            <span
                                                class="div_helppost">(<?php echo $this->lang->line('image_help'); ?>
                                                )</span>
                                        </div>
                                    <?php } ?>
                                    <div class="row">
                                        <div class="form-group none_member">
                                            <label for="day_regis"
                                                   class="col-sm-4 control-label"><?php echo $this->lang->line('birthday_defaults'); ?>
                                                :</label>

                                            <div class="col-sm-8">
                                                <div>
                                                    <select name="day_regis" id="day_regis" class="form-control2">
                                                        <?php for ($day = 1; $day <= 31; $day++) { ?>
                                                            <?php if (isset($day_regis) && $day_regis == $day) { ?>
                                                                <option value="<?php echo $day; ?>"
                                                                        selected="selected"><?php echo $day; ?></option>
                                                            <?php } else { ?>
                                                                <option
                                                                    value="<?php echo $day; ?>"><?php echo $day; ?></option>
                                                            <?php } ?>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <p class="hidden-lg hidden-md"></p>

                                                <div>
                                                    <select name="month_regis" id="month_regis"
                                                            class="form-control2">
                                                        <?php for ($month = 1; $month <= 12; $month++) { ?>
                                                            <?php if (isset($month_regis) && $month_regis == $month) { ?>
                                                                <option value="<?php echo $month; ?>"
                                                                        selected="selected"><?php echo $month; ?></option>
                                                            <?php } elseif ($month == (int)date('m') && $month_regis == '') { ?>
                                                                <option value="<?php echo $month; ?>"
                                                                        selected="selected"><?php echo $month; ?></option>
                                                            <?php } else { ?>
                                                                <option
                                                                    value="<?php echo $month; ?>"><?php echo $month; ?></option>
                                                            <?php } ?>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <p class="hidden-lg hidden-md"></p>
                                                <div>
                                                    <select name="year_regis" id="year_regis" class="form-control2">
                                                        <?php for ($year = (int)date('Y') - 70; $year <= (int)date('Y') - 10; $year++) { ?>
                                                            <?php if (isset($year_regis) && $year_regis == $year) { ?>
                                                                <option value="<?php echo $year; ?>"
                                                                        selected="selected"><?php echo $year; ?></option>
                                                            <?php } elseif ($year == (int)date('Y') - 18 && $year_regis == '') { ?>
                                                                <option value="<?php echo $year; ?>"
                                                                        selected="selected"><?php echo $year; ?></option>
                                                            <?php } else { ?>
                                                                <option
                                                                    value="<?php echo $year; ?>"><?php echo $year; ?></option>
                                                            <?php } ?>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group buyer none_member">
                                            <label for="sex_regis"
                                                   class="col-sm-4 control-label"><?php echo $this->lang->line('sex_defaults'); ?>
                                                :</label>

                                            <div class="col-sm-8">
                                                <select name="sex_regis" id="sex_regis" class="form-control">
                                                    <option
                                                        value="1" <?php if (isset($sex_regis) && $sex_regis == '1') {
                                                        echo 'selected="selected"';
                                                    } elseif (!isset($sex_regis)) {
                                                        echo 'selected="selected"';
                                                    } ?>><?php echo $this->lang->line('male_defaults'); ?></option>
                                                    <option
                                                        value="0" <?php if (isset($sex_regis) && $sex_regis == '0') {
                                                        echo 'selected="selected"';
                                                    } ?>><?php echo $this->lang->line('female_defaults'); ?></option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="DivGuideRegisterVip"
                                         style="display:none; line-height:18px; text-align:justify; font-size:12px;"><?php echo $this->lang->line('guide_regis_vip_defaults'); ?></div>
                                    <div id="DivGuideRegisterShop"
                                         style="display:none; line-height:18px; text-align:justify; font-size:12px;"><?php echo $this->lang->line('guide_regis_shop_defaults'); ?></div>
                                    <script type='text/javascript'>
                                        function guideRegister(div, divContent) {
                                            if (document.getElementById(div).checked == true) {
                                                jQuery("#" + divContent).modal({
                                                    onOpen: function (dialog) {
                                                        dialog.overlay.fadeIn('fast', function () {
                                                            dialog.data.hide();
                                                            dialog.container.fadeIn('fast', function () {
                                                                dialog.data.slideDown('fast');
                                                            });
                                                        });
                                                    }
                                                });
                                            }
                                        }
                                    </script>
                                    <div id="vip_regis_wapper" style="display:none">
                                        <input type="checkbox" <?php if ($stopRegisterVip == true) {
                                            echo 'disabled="disabled"';
                                        } ?> name="vip_regis" id="vip_regis" value="0" <?php if (isset($vip_regis) && $vip_regis == '1' && $url2 != 'addsubadmin') {
                                            echo 'checked="checked"';
                                        } ?> onclick="ChangeCheckBox('shop_regis'); ChangeLawRegister(this.checked,1); guideRegister('vip_regis', 'DivGuideRegisterVip');"/>
                                        <?php echo $this->lang->line('regis_vip_defaults'); ?> </div>
                                    <div
                                        id="store_register" <?php if ($userId > 0 || $register_estore == 0) { ?> style="display:none" <?php } ?>>
                                        <div id="shop_regis_wapper">
                                            <div class="register_free_package">
                                                <input type="checkbox" <?php if ($stopRegisterShop == true) { echo 'disabled="disabled"'; } ?> name="shop_regis" id="shop_regis" value="1" <?php if (isset($shop_regis) && $shop_regis == '1' && $url2 != 'addsubadmin') { echo 'checked="checked"';
                                                } ?> onclick="ChangeCheckBox('vip_regis'); ChangeLawRegister(this.checked,2); "/>
                                                &nbsp;Cập nhật thông tin cho gian hàng miễn phí
                                            </div>
                                            <div class="register_later">( có thể cập nhật sau )</div>
                                        </div>
                                        <div class="note_register"> Lưu ý: Để đăng ký gian hàng đảm bảo ( có tính phí ), sau khi đăng ký tài khoản thành công, bạn đăng nhập vào phần quản lý Dịch vụ Azibai để yêu cầu các gói gian hàng đảm bảo.
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <!--END box_regis_1-->
                                <?php if ($url2 != 'affiliate') { ?>
                                    <div id="box_regis" class="col-lg-6 col-md-6 col-sm-12 col-xs-12 col-md-offset-3">
                                        <?php if ($userId <= 0) { ?>
                                        <div class="form-group">
                                            <div id="DivNormalRegister" class="panel panel-default">
                                                <div class="panel-heading">
                                                    <h3 class="panel-title"><?php echo $this->lang->line('title_role_normal_defaults'); ?></h3>
                                                </div>
                                                <div class="panel-body">
                                                    <?php
                                                    if ($this->uri->segment(2) == '') {
                                                        $contentFooter = Counter_model::getArticle(noi_quy_dang_ky_thanh_vien);
                                                    }

                                                    if ($this->uri->segment(2) == 'affiliate') {
                                                        $contentFooter = Counter_model::getArticle(noi_quy_af);
                                                    }

                                                    if ($this->uri->segment(2) == 'afstore' || $this->uri->segment(2) == 'estore') {
                                                        $contentFooter = Counter_model::getArticle(noi_quy_dang_ky_thanh_vien);
                                                    }
                                                    echo html_entity_decode($contentFooter->not_detail);
                                                    ?>
                                                </div>
                                            </div>

                                            <div id="DivVipRegister" class="panel panel-default">
                                                <div class="panel-heading"><h3 class="panel-title"><?php echo $this->lang->line('title_role_vip_defaults'); ?></h3>
                                                </div>
                                                <div class="panel-body "> <?php echo $this->lang->line('role_vip_defaults'); ?> </div>
                                            </div>
                                            
					    <div id="DivShopRegister">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading"><h3 class="panel-title"><?php echo $this->lang->line('title_role_saler_defaults'); ?></h3>
                                                    </div>
                                                    <div class="panel-body"> <?php $contentFooter = Counter_model::getArticle(noi_quy_af);
                                                        echo html_entity_decode($contentFooter->not_detail); ?> </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="hd_select_0" class="col-sm-2 control-label">Danh mục
                                                        gian hàng :</label>

                                                    <div class="col-sm-5">
                                                        <select id="hd_select_0" class="form_control_hoidap_select"
                                                                onclick="check_edit_gian_hang_cate_dang_ky(this.value,0,'<?php echo base_url(); ?>');"
                                                                size="14">
                                                            <?php
                                                            if (isset($catlevel0)) {
                                                                foreach ($catlevel0 as $item) {
                                                                    ?>
                                                                    <?php if ($cat_getcategory0 != "") { ?>
                                                                        <?php if ($category_pro == $item->cat_id) { ?>
                                                                            <option value="<?php echo $item->cat_id; ?>"
                                                                                    selected="selected"><?php echo $item->cat_name; ?></option>
                                                                            <?php if ($item->child_count > 0) {
                                                                                echo ' >';
                                                                            } ?>
                                                                        <?php } else { ?>
                                                                            <option
                                                                                value="<?php echo $item->cat_id; ?>"><?php echo $item->cat_name; ?></option>
                                                                            <?php
                                                                        } ?>
                                                                        <?php
                                                                    } else { ?>
                                                                        <?php if ($cat_parent_parent_0->parent_id == $item->cat_id) { ?>
                                                                            <option value="<?php echo $item->cat_id; ?>"
                                                                                    selected="selected"><?php echo $item->cat_name; ?></option
                                                                            >
                                                                        <?php } else { ?>
                                                                            <option
                                                                                value="<?php echo $item->cat_id; ?>"><?php echo $item->cat_name; ?>
                                                                                <?php if ($item->child_count > 0) {
                                                                                    echo ' >';
                                                                                } ?>
                                                                            </option>
                                                                        <?php }
                                                                    }
                                                                }
                                                            } ?>
                                                        </select>
                                                        <input type="hidden" id="hd_category_id" name="hd_category_id"
                                                               value="<?php echo $category_pro; ?>"/>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="name_shop" class="col-sm-2 control-label">Tên công
                                                        ty:</label>

                                                    <div class="col-sm-5">
                                                        <input type="text" name="name_shop" id="name_shop" value=""
                                                               maxlength="80" class="form-control"
                                                               onkeyup="BlockChar(this,'SpecialChar'); CapitalizeNames('frmEditShop','name_shop');"
                                                               onfocus="ChangeStyle('name_shop',1)"
                                                               onblur="ChangeStyle('name_shop',2)"/>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="address_shop" class="col-sm-2 control-label">Địa chỉ công ty :</label>

                                                    <div class="col-sm-5">
                                                        <input type="text" name="address_shop" id="address_shop" value="" maxlength="80" class="form-control" onkeyup="BlockChar(this,'SpecialChar'); CapitalizeNames('frmEditShop','address_shop');" onfocus="ChangeStyle('address_shop',1)" onblur="ChangeStyle('address_shop',2)"/>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="inputPassword3" class="col-sm-2 control-label">Tỉnh /
                                                        Thành Phố:</label>
                                                    <div class="col-sm-3">
                                                        <select name="province_shop" id="province_shop"
                                                                class="form-control">
                                                            <?php foreach ($province as $provinceArray) { ?>
                                                                <?php if (isset($province_shop) && $province_shop == $provinceArray->pre_id) { ?>
                                                                    <option value="<?php echo $provinceArray->pre_id; ?>" selected="selected"><?php echo $provinceArray->pre_name; ?></option>
                                                                <?php } else { ?>
                                                                    <option value="<?php echo $provinceArray->pre_id; ?>"><?php echo $provinceArray->pre_name; ?></option>
                                                                <?php } ?>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="mobile_shop" class="col-sm-2 control-label">Điện
                                                        thoại: </label>

                                                    <div class="col-sm-5">
                                                        <img src="<?php echo base_url(); ?>templates/home/images/mobile_1.gif" border="0"/>
                                                        <input type="text" name="mobile_shop" id="mobile_shop" value="" maxlength="20" class="inputphone_formpost" onfocus="ChangeStyle('mobile_shop',1)" onblur="ChangeStyle('mobile_shop',2)"/>
                                                        <b>-</b> <img src="<?php echo base_url(); ?>templates/home/images/phone_1.gif" border="0"/>
                                                        <input type="text" name="phone_shop" id="phone_shop" value="" maxlength="20" class="inputphone_formpost" onfocus="ChangeStyle('phone_shop',1)" onblur="ChangeStyle('phone_shop',2)"/>
                                                        <img src="<?php echo base_url(); ?>templates/home/images/help_post.gif"  onmouseover="ddrivetip('<?php echo $this->lang->line('phone_tip_help'); ?>',225,'#F0F8FF');"
                                                            onmouseout="hideddrivetip();" class="img_helppost"/> <span
                                                            class="div_helppost">(<?php echo $this->lang->line('phone_help'); ?>
                                                            )</span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="fax_shop" class="col-sm-2 control-label"> Fax: </label>

                                                    <div class="col-sm-5">
                                                        <input type="text" name="fax_shop" id="fax_shop" value=""
                                                               maxlength="50" class="form-control"
                                                               onkeyup="BlockChar(this,'SpecialChar')"
                                                               onfocus="ChangeStyle('email_shop',1)"
                                                               onblur="ChangeStyle('email_shop',2)"/>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="website_shop"
                                                           class="col-sm-2 control-label">Website: </label>

                                                    <div class="col-sm-5">
                                                        <input type="text" name="website_shop" id="website_shop"
                                                               maxlength="100" value="<?php if (isset($website_shop)) {
                                                            echo $website_shop;
                                                        } ?>" class="form-control"
                                                               onkeyup="BlockChar(this,'SpecialChar')"
                                                               onfocus="ChangeStyle('website_shop',1)"
                                                               onblur="ChangeStyle('website_shop',2)"/>
                                                    </div>
                                                </div>
                                                <div class="panel panel-default">
                                                    <div class="panel-heading"><h3
                                                            class="panel-title"><?php echo $this->lang->line('title_role_normal_defaults'); ?></h3>
                                                    </div>
                                                    <div class="panel-body "
                                                         >  <?php $contentFooter = Counter_model::getArticle(noi_quy_af);
                                                        echo html_entity_decode($contentFooter->not_detail); ?> </div>
                                                </div>
                                            </div>
                                            
					    <div class="">
                                                <label>
                                                    <input type="checkbox" name="checkDongY" checked="checked"/>
                                                    Tôi đã đọc và đồng ý với những quy định trên <a href="azibai.com">www.azibai.com</a>
                                                </label>
                                            </div>

                                            <?php } ?>
                                        </div>  <!-- END box_regis_2-->
                                    </div>  <!-- END box_regis_2-->
                                <?php } ?>
                                <div class="clearfix"></div>
                                <?php if (isset($imageCaptchaRegister)) { ?>
                                    <div class="form-inline text-center">
                                        <div class="">

                                            <label for="captcha_regis"
                                                   class="control-label"><?php echo $this->lang->line('captcha_main'); ?>
                                                :</label>

                                            <img src="<?php echo $imageCaptchaRegister; ?>"
                                                 height="31" style=""/>
                                            <input style="text-indent: 5px; padding: 5px 0"
                                                   onkeypress="return submitenter(this,event)" type="text"
                                                   name="captcha_regis" id="captcha_regis" value=""
                                                   maxlength="10" class="form-control"/>
                                            <?php echo form_error('captcha_regis'); ?>

                                        </div>
                                    </div>
                                <?php } ?>

                                <div class="checkdongy form-group  text-center">
                                    <?php if ($url2 == 'affiliate') { ?>
                                        <div class="col-sm-12">
                                            <label>
                                                <input type="checkbox" name="checkDongY" checked="checked"/>
                                                Tôi đã đọc và đồng ý với <a href="http://azibai.com/content/391"
                                                                            target="_blank"><strong>Quy chế Cộng tác
                                                        viên online
                                                        <?php if ($idAf == '') {
                                                            echo 'của azibai';
                                                        } ?></strong> </a>
                                            </label>
                                        </div>

                                        <div class="clearfix">&nbsp;</div>
                                    <?php } ?>
                                </div>
                                <?php
                                $limitctv = '';
                                $segment = $this->user_model->get("use_group", "use_id = " . (int)$this->uri->segment(4));
                                if ($segment->use_group == 14) {
                                    $sho_limit_ctv = $this->shop_model->get("sho_limit_ctv", "sho_user = " . (int)$this->uri->segment(4));
                                    if ($sho_limit_ctv->sho_limit_ctv > 0) {
                                        $limitctv = 'true';
                                        $chinhanh = (int)$this->uri->segment(4);
                                    }
                                } else {
                                    $user = $this->user_model->get("parent_id", "use_id = " . (int)$this->uri->segment(4));
                                    if (!empty($user)) {
                                        $parent = $this->user_model->get("use_group", "use_id = " . (int)$user->parent_id);
                                        if ($parent->use_group == 14) {
                                            $sho_limit_ctv = $this->shop_model->get("sho_limit_ctv", "sho_user = " . (int)$user->parent_id);
                                            if ($sho_limit_ctv->sho_limit_ctv > 0) {
                                                $limitctv = 'true';
                                                $chinhanh = $user->parent_id;
                                            }
                                        }
                                    }
                                }

                                if ($limitctv == 'true') { ?>
                                    <div class="col-sm-12 checkup" style="text-align: center">
                                        <input type="button" onclick="RegisterCTV_Bran(<?php echo $chinhanh ?>);"
                                               name="submit_register"
                                               value="&nbsp; <?php echo $this->lang->line('button_register_defaults'); ?> &nbsp;"
                                               class="btn btn-azibai" id="registerctv_bran"/>
                                        <input type="reset" name="reset_register"
                                               value="&nbsp; <?php echo $this->lang->line('button_reset_defaults'); ?> &nbsp;"
                                               class="btn btn-default"/>
                                    </div>
                                    <div class="backfixed"></div>
                                    <div class="loadding">
                                        <img src="<?php echo base_url() ?>images/loading.gif" alt="">
                                    </div>
                                    <style>
                                        .backfixed {
                                            background: rgba(21, 20, 20, 0.59);
                                            position: fixed;
                                            left: 0;
                                            right: 0;
                                            top: 0;
                                            bottom: 0;
                                            display: none;
                                        }

                                        .loadding {
                                            position: fixed;
                                            text-align: center;
                                            display: table;
                                            top: 45%;
                                            bottom: 25%;
                                            right: 45%;
                                            left: 50%;
                                            display: none;
                                        }

                                        .loadding img {
                                            max-width: 100px;
                                        }
                                    </style>
                                <?php } else { ?>
                                    <div class="col-sm-12 checkup" style="text-align: center">
                                        <input type="button" onclick="CheckInput_Register();" name="submit_register"
                                               value="&nbsp; <?php echo $this->lang->line('button_register_defaults'); ?> &nbsp;"
                                               class="btn btn-azibai"/>
                                        <input type="reset" name="reset_register"
                                               value="&nbsp; <?php echo $this->lang->line('button_reset_defaults'); ?> &nbsp;"
                                               class="btn btn-default"/>
                                    </div>
                                <?php } ?>
                            </div>
                            <!--END wrap_regis-->
                        <?php
                        }
                        ?>
                    <?php if ($url2 != 'addsubadmin') { ?>
                                
                        <?php if (isset($vip_regis) && $vip_regis == '1'){ ?>
                            <script>ChangeCheckBox('shop_regis');
                                ChangeLawRegister(true, 1);</script>
                        <?php }elseif (isset($shop_regis) && $shop_regis == '1'){ ?>
                            <script>ChangeCheckBox('vip_regis');
                                ChangeLawRegister(true, 2);</script>
                        <?php }else{ ?>
                            <script>ChangeLawRegister('false', 0);</script>
                        <?php } ?>
                    <?php } ?>
                            <script>
                                function checkekdieuKienThanhCong() {
                                    var checked = jQuery('#checkDongY').is(':checked');
                                    if (checked == true) {
                                        jQuery('.checkdongy').css('display', 'block');
                                    }
                                    else {
                                        jQuery('.checkdongy').css('display', 'block');
                                    }
                                }
                            </script>
                        <?php }else{ ?>
                            <div class="row">
                                <meta http-equiv=refresh
                                      content="10; url=<?php if ($this->uri->segment(1) == 'account') {
                                          echo base_url();
                                          echo "account/tree/request/member";
                                      } else {
                                          echo base_url() . "login";
                                      } ?>">
                                <?php
                                if ($group_id == Developer2User
                                    || $group_id == Developer1User
                                    || $group_id == Partner2User
                                    || $group_id == Partner1User
                                    || $group_id == CoreMemberUser
                                    || $group_id == CoreAdminUser
                                ) { ?>

                                    <?php echo "Xin chào ";
                                    echo "<b style=\"color:#FF0000\">" . $_SESSION['usernameRegister'] . "</b>"; ?><?php echo $this->lang->line('success_register_defaults_request_member'); ?>
                                    <br/>
                                <?php } else { ?>
                                    <?php echo "Xin chào ";
                                    echo "<b style=\"color:#FF0000\">" . $_SESSION['usernameRegister'] . "</b>"; ?><?php echo $this->lang->line('success_register_defaults'); ?>
                                    <br/>
                                <?php } ?>
                                <?php if ($isActivation == true) { ?>
                                    <?php if ($successSendActivation == true) { ?>
                                        <?php echo $this->lang->line('success_register_success_send_activation_defaults'); ?>
                                    <?php } else { ?>
                                        <?php $group_id = (int)$this->session->userdata('sessionGroup');
                                        if ($group_id == Developer2User
                                            || $group_id == Developer1User
                                            || $group_id == Partner2User
                                            || $group_id == Partner1User
                                            || $group_id == CoreMemberUser
                                            || $group_id == CoreAdminUser
                                        ) { ?>
                                            <?php echo $this->lang->line('success_register_not_send_activation_defaults_request_member'); ?>
                                        <?php } else { ?>
                                            <?php echo $this->lang->line('success_register_not_send_activation_defaults'); ?>
                                        <?php } ?>
                                    <?php } ?>
                                <?php } else { ?>
                                    <?php echo $this->lang->line('success_normal_defaults'); ?>
                                <?php } ?>
                            </div>
                        <?php } ?>
                        <?php }else{ ?>
                            <div class="row">
                                <meta http-equiv=refresh
                                      content="10; url=<?php if ($this->uri->segment(1) == 'account') {
                                          echo base_url();
                                          echo "account/tree/request/member";
                                      } else {
                                          echo base_url() . "login";
                                      } ?>">
                                <?php echo $this->lang->line('stop_regis_defaults'); ?>
                            </div>
                        <?php } ?>

                    </form>
                <?php } else { ?>
                    <?php if ($this->uri->segment(2) == 'affiliate') { ?>
                        <div class="alert alert-success" role="alert">
                            Chúc mừng bạn đã trở thành Cộng tác viên online miễn phí của <a
                                href="<?php echo base_url() ?>">Azibai.com</a>!
                            <p>Ngay bây giờ, bạn có thể sử dụng tài khoản vừa đăng ký để tham gia bán hàng trên
                                azibai.com</p><br/>
                            <p>
                                Bạn có muốn trang bị thêm các kỹ năng chuyên nghiệp giúp bán được hàng ngay không?
                                <br/> Hãy tham gia Diễn đàn chia sẻ các kỹ năng bán hàng chuyên nghiệp dành cho Cộng tác
                                viên online của Azibai.
                                <br/> <a href="https://www.facebook.com/groups/300797756941319/" target="_blank">Click
                                    vào đây để tham gia Miễn phí....</a>
                            </p>
                        </div>
                        <!--<div class="alert alert-warning" role="alert">
                            <p>
                                <?php //echo $this->lang->line('success_register_success_send_activation_defaults'); ?>
                            </p>
                        </div>-->
                    <?php } elseif ($this->uri->segment(2) == 'afstore' || $this->uri->segment(2) == 'estore') { ?>
                        <div class="alert alert-success" role="alert">
                            Chúc mừng bạn đã mở Gian hàng miễn phí thành công trên <a href="<?php echo base_url() ?>">Azibai.com</a>!
                            <p>
                                <strong>Bạn đang muốn tăng doanh thu nhanh, tăng lợi nhuận?</strong>
                                <br/><strong>Bạn có muốn tuyển được ngay đội ngũ Cộng tác viên bán hàng chuyên
                                    nghiệp?</strong>
                                <br/> Hãy tham gia Cộng Đồng Doanh Nghiệp Kinh Doanh Online Azibai để cùng chia sẻ các
                                kinh nghiệm bán hàng online hiệu quả.
                                <br/> <a href="https://www.facebook.com/groups/1233843429961548/" target="_blank">Click
                                    vào đây để tham gia Miễn phí....</a>
                            </p>
                        </div>
                        <div class="alert alert-warning" role="alert">
                            <p>
                                <?php echo $this->lang->line('success_register_success_send_activation_defaults'); ?>
                            </p>
                        </div>
                    <?php } elseif ($this->uri->segment(2) == 'tree') { ?>
                        <div class="alert alert-success" role="alert">
                            Chúc mừng bạn đã yêu cầu tạo tài khoản Thành viên cấp dưới thành công, sau khi
                            chúng tôi xác nhận Thành viên này sẽ được truy cập vào hệ thống <a
                                href="<?php echo base_url() ?>">Azibai.com</a>!
                        </div>
                    <?php } elseif ($this->uri->segment(2) == 'staffs') { ?>
                        <div class="alert alert-success" role="alert">
                            Chúc mừng bạn đã tạo nhân viên thành công, bây giờ nhân viên của bạn có thể truy cập vào <a
                                href="<?php echo base_url() ?>">Azibai.com</a> để nhận công việc được giao!
                        </div>
                        <div class="alert alert-warning" role="alert">
                            <p>
                                <?php echo $this->lang->line('success_register_success_send_activation_defaults'); ?>
                            </p>
                        </div>
                    <?php } elseif ($this->uri->segment(2) == '' && $_REQUEST == '') { ?>
                        <div class="alert alert-success" role="alert">
                            <?php echo $this->lang->line('success_register_defaults'); ?>
                        </div>
                        <div class="alert alert-warning" role="alert">
                            <p>
                                <?php echo $this->lang->line('success_register_success_send_activation_defaults'); ?>
                            </p>
                        </div>
                    <?php } elseif ($_REQUEST != '') {
                        ?>
                        <div class="alert alert-success" role="alert">
                            <p class="text-center"><a href="<?php echo base_url() . 'login'; ?>">Click vào đây để tiếp tục</a></p>
                            Chúc mừng bạn đã đăng ký thành công! hãy đăng nhập để tiếp tục mua hàng. Nếu hệ thống không
                            tự động chuyển bạn vui lòng <a href="<?php echo base_url() . "login"; ?>">click vào đây</a>!
                        </div>
                        <div class="alert alert-warning" role="alert">
                            <p>
                                <?php echo $this->lang->line('success_register_success_send_activation_defaults'); ?>
                            </p>
                        </div>
                    <?php } ?>
                    <meta http-equiv=refresh content="120; url=<?php if ($this->uri->segment(1) == 'account') {
                        echo base_url();
                        echo "account/tree/request/member";
                    } else {
                        echo base_url() . "login";
                    } ?>">
                <?php } ?>

            <?php } else { ?>
                <div class="row">
                    <meta http-equiv=refresh content="120; url=<?php if ($this->uri->segment(1) == 'account') {
                        echo base_url();
                        echo "account/tree/request/member";
                    } else {
                        echo base_url() . "login";
                    } ?>">
                    <?php echo $this->lang->line('stop_regis_defaults'); ?>

                </div>
            <?php } ?>

        </div>
    </div>
</div>
<?php //if( $this->uri->segment(2) == 'addbranch') { ?>
<!-- <script type="text/javascript">
   $("#user_province_get").change(function () {
    if ($("#user_province_get").val()) {
        $.ajax({
            url: siteUrl + 'home/register/checkAziBranch',
            type: "POST",
            data: {user_province_put: $("#user_province_get").val()},
            cache: true,
            beforeSend: function () {
                document.getElementById("user_province_get").disabled = true;
            },
            dataType: 'text',
            success: function (receive) {
                document.getElementById("user_province_get").disabled = false;
                if (receive == '1') {
                  document.getElementById("user_province_get").value = "";
                  document.getElementById("user_district_get").value = "";
                  alert('Gói DV của bạn chỉ được tạo Chi Nhánh trong tỉnh!!');
                }
            },
            error: function () {
                alert("Lỗi! Vui lòng thử lại");
            }
        });
    }
  });
</script> -->
<?php //} ?>

<script type="text/javascript">
    $("#user_province_get").change(function () {
        if ($("#user_province_get").val()) {
            $.ajax({
                url: siteUrl + 'home/showcart/getDistrict',
                type: "POST",
                data: {user_province_put: $("#user_province_get").val()},
                cache: true,
                beforeSend: function () {
                    document.getElementById("user_province_get").disabled = true;
                },
                success: function (response) {
                    document.getElementById("user_province_get").disabled = false;
                    if (response) {
                        var json = JSON.parse(response);
                        emptySelectBoxById('user_district_get', json);
                        delete json;
                    } else {
                        alert("Lỗi! Vui lòng thử lại");
                    }
                },
                error: function () {
                    alert("Không thành công! Vui lòng thử lại");
                }
            });
        }
    });

    function emptySelectBoxById(eid, value) {
        if (value) {
            var text = "";
            $.each(value, function (k, v) {
                //display the key and value pair
                if (k != "") {
                    text += "<option value='" + k + "'>" + v + "</option>";
                }
            });
            document.getElementById(eid).innerHTML = text;
            delete text;
        }
    }

    $("input[name='options_name']").change(function () {
        if ($(this).val() == 2) {
            document.getElementById('group_company').style.display = 'block';
        } else {
            document.getElementById('group_company').style.display = 'none';
        }
    });

    function RegisterCTV_Bran(chinhanh) {
        var none_check = $('.none_member').css('display');
        var afstore = $('.afstore').css('display');
        if (none_check == 'block') {
            if (CheckBlank(document.getElementById("fullname_regis").value)) {
                alert("Bạn chưa nhập họ tên!");
                document.getElementById("fullname_regis").focus();
                return false;
            }
        }
        var staff = $('.staff ').css('display');
        if (staff == 'block') {
            if (CheckBlank(document.getElementById("username_regis").value)) {
                alert("Bạn chưa nhập tài khoản!");
                document.getElementById("username_regis").focus();
                return false
            }

            if (!CheckCharacter(document.getElementById("username_regis").value)) {
                alert("Tài khoản bạn nhập không hợp lệ!\nChỉ chấp nhận các ký số 0-9\nChấp nhận các ký tự a-z\nChấp nhận các ký tự - _");
                document.getElementById("username_regis").focus();
                return false
            }
            if ($("#namebank_regis").length > 0) {
                if (CheckBlank(document.getElementById("namebank_regis").value)) {
                    alert("Bạn chưa nhập tên ngân hàng!");
                    document.getElementById("namebank_regis").focus();
                    return false
                }
                if (CheckBlank(document.getElementById("addbank_regis").value)) {
                    alert("Bạn chưa nhập tên chi nhánh ngân hàng!");
                    document.getElementById("addbank_regis").focus();
                    return false
                }
                if (CheckBlank(document.getElementById("accountname_regis").value)) {
                    alert("Bạn chưa nhập tên chủ tài khoản!");
                    document.getElementById("accountname_regis").focus();
                    return false
                }
                if (CheckBlank(document.getElementById("accountnum_regis").value)) {
                    alert("Bạn chưa nhập số tài khoản!");
                    document.getElementById("accountnum_regis").focus();
                    return false
                }
            }
        }
        var n = document.getElementById("username_regis").value;
        if (n.length < 6) {
            alert("Tài khoản phải có ít nhất 6 ký tự!");
            document.getElementById("username_regis").focus();
            return false
        }
        if (CheckBlank(document.getElementById("password_regis").value)) {
            alert("Bạn chưa nhập mật khẩu!");
            document.getElementById("password_regis").focus();
            return false
        }
        var r = document.getElementById("password_regis").value;
        if (r.length < 6) {
            alert("Mật khẩu phải có ít nhất 6 ký tự!");
            document.getElementById("password_regis").focus();
            return false
        }
        if (CheckBlank(document.getElementById("email_regis").value)) {
            alert("Bạn chưa nhập email!");
            document.getElementById("email_regis").focus();
            return false
        }
        if (!CheckEmail(document.getElementById("email_regis").value)) {
            alert("Email bạn nhập không hợp lê!");
            document.getElementById("email_regis").focus();
            return false
        }
        if (none_check == 'block') {
            if (CheckBlank(document.getElementById("address_regis").value)) {
                alert("Bạn chưa nhập địa chỉ!");
                document.getElementById("address_regis").focus();
                return false
            }
        }

        if (document.getElementById("shop_regis").checked == true) {
            if (CheckBlank(document.getElementById("name_shop").value)) {
                alert("Bạn chưa nhập tên công ty !");
                document.getElementById("name_shop").focus();
                return false
            }
            if (CheckBlank(document.getElementById("address_shop").value)) {
                alert("Bạn chưa nhập địa chỉ gian hàng !");
                document.getElementById("address_shop").focus();
                return false
            }
            if (CheckBlank(document.getElementById("mobile_shop").value)) {
                alert("Bạn chưa nhập điện thoại di động gian hàng !");
                document.getElementById("mobile_shop").focus();
                return false
            }
        }
        //var e = document.getElementById("phone_regis").value;
        //if (document.getElementById("phone_regis").value != "") {
        //    if (e[0] != "0") {
        //        alert("Số điện thoại bạn nhập không hợp lệ!");
        //        document.getElementById("phone_regis").focus();
        //        return false
        //    }
        //}

        if (CheckBlank(document.getElementById("mobile_regis").value)) {
            alert("Bạn chưa nhập số điện thoại!");
            document.getElementById("mobile_regis").focus();
            return false
        }

        if (CheckBlank(document.getElementById("user_province_get").value)) {
            $.jAlert({
                'title': 'Yêu cầu nhập',
                'content': 'Bạn chưa nhập Tỉnh thành!',
                'theme': 'default',
                'btns': {
                    'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                        e.preventDefault();
                        document.getElementById("user_province_get").focus();
                        return false;
                    }
                }
            });
            return false;
        }

        if (CheckBlank(document.getElementById("user_district_get").value)) {
            $.jAlert({
                'title': 'Yêu cầu nhập',
                'content': 'Bạn chưa nhập Tỉnh thành!',
                'theme': 'default',
                'btns': {
                    'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                        e.preventDefault();
                        document.getElementById("user_district_get").focus();
                        return false;
                    }
                }
            });
            return false;
        }
        if (afstore == "block") {
            if (CheckBlank(document.getElementById("idcard_regis").value)) {
                alert("Bạn chưa nhập số chứng minh nhân dân !");
                document.getElementById("idcard_regis").focus();
                return false
            }
            else {
                if (!IsNumber(document.getElementById("idcard_regis").value)) {
                    alert("Số chứng minh nhân dân chỉ được phép nhập số !");
                    document.getElementById("idcard_regis").focus();
                    return false;
                }
            }
            if (CheckBlank(document.getElementById("taxcode_regis").value)) {
                alert("Bạn chưa nhập mã số thuế !");
                document.getElementById("idcard_regis").focus();
                return false
            }
            else {
                if (!IsNumber(document.getElementById("taxcode_regis").value)) {
                    alert("Mã số thuế chỉ được phép nhập số !");
                    document.getElementById("taxcode_regis").focus();
                    return false;
                }
            }
        }
        if(document.getElementById("captcha_regis") && CheckBlank(document.getElementById("captcha_regis").value) ){
              alert("Bạn chưa nhập mã xác nhận!");
              document.getElementById("captcha_regis").focus();
              return false
        }
        if ($('#result').hasClass('short') || $('#result').hasClass('weak')) {
            $.jAlert({
                'title': 'Thông báo',
                'content': 'Mật khẩu của bạn không bảo mật! Vui lòng chọn mật khẩu bảo mật hơn.',
                'theme': 'default',
                'btns': {
                    'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                        e.preventDefault();
                        document.getElementById("password_regis").focus();
                        return false;
                    }
                }
            });
            return false
        }

        $.ajax({
            type: "POST",
            dataType: "json",
            url: "<?php echo base_url(); ?>home/register/limitCTV",
            data: {notification: 'tb', chinhanh: chinhanh},
            beforeSend: function (data) {
                $('.wrap_regis').css('position', 'relative');
                $('.loadding').css('display', 'block');
                $('.backfixed').css('display', 'block');
                $('body').css('overflow', 'hidden');
            },
            success: function (rs) {
                if (rs.notification != '') {
                    alert(rs.notification);
                }
                else {
                    document.frmRegister.submit();
                }
                $('.wrap_regis').attr('style', '');
                $('.loadding').css('display', 'none');
                $('.backfixed').css('display', 'none');
                $('body').attr('style', '');
            },
            error: function () {
                alert('Có lỗi xảy ra.');
            }
        });

        /**/
    }

</script>

<?php if ($this->uri->segment(3) == 'request' && $this->uri->segment(4) == 'member') { ?>
    <script type="text/javascript">
        document.getElementById('company_phone').style.display = 'none';
        $("input[name='options_name']").change(function () {
            if ($(this).val() == 2) {
                document.getElementById('company_phone').style.display = 'block';
                document.getElementById('afstore_card').style.display = 'none';
            } else {
                document.getElementById('company_phone').style.display = 'none';
                document.getElementById('afstore_card').style.display = 'block';
            }
        });
    </script>
<?php } ?>
<?php $this->load->view('home/common/footer'); ?>
