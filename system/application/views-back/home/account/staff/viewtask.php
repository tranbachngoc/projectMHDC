<?php $this->load->view('home/common/header'); ?>
<style type="text/css">
    .add-task .row .col-lg-2.active{
        background-color: #ff6667;
    }
</style>
    <div class="container-fluid">
        <div class="row">

            <?php $this->load->view('home/common/left'); ?>
            <SCRIPT TYPE="text/javascript">
                <!--
                function submitenter(myfield, e) {
                    var keycode;
                    if (window.event) keycode = window.event.keyCode;
                    else if (e) keycode = e.which;
                    else return true;
                    if (keycode == 13) {
                        CheckInput_ContactAccount();
                        return false;
                    }
                    else
                        return true;
                }
                jQuery(document).ready(function () {
                    jQuery('#con_user_recieve').change(function () {
                        if (jQuery(this).val() != 0)jQuery('#position_contact').attr('disabled', 'disabled');
                        else jQuery('#position_contact').removeAttr('disabled');
                    });
                    jQuery('#choose_receiver_0').click(function () {
                        jQuery('#position_contact').attr('disabled', 'disabled');
                        jQuery('#con_user_recieve').attr('disabled', 'disabled');
                    });
                    jQuery('#choose_receiver_1').click(function () {
                        jQuery('#position_contact').removeAttr('disabled');
                        jQuery('#con_user_recieve').removeAttr('disabled');
                    });
                    jQuery('.disabled').click(function (e) {
                        e.preventDefault();
                        warningAlert('Thông báo','Bạn không được phép chọn ngày nhỏ hơn ngày hiện tại!');
                    })
                });
                //-->
            </SCRIPT>
            <!--BEGIN: RIGHT-->

	    <div class="col-md-9 col-sm-8 col-xs-12 add-task">
	     <h4 class="page-header text-uppercase" style="margin-top:10px">
                    NHẬN VIỆC
                </h4>
                <p>
                    <span> Lịch công việc của: <strong><?php echo $taskuser . ' ( ' . $taskuserfull . ' )'; ?></strong></span>
                    <i class="text-danger"><i>
                    <p class="hidden-lg"></p>
                    (Ngày có nền màu đỏ nhạt là ngày đã được giao việc!)</i></span>
                </p>
                <?php
                //$id_staff = strtolower($this->uri->segment(4));

                $list = array();
                $month = strtolower($this->uri->segment(4));
                $year = date("Y");
                $today = date('d');
                $thismonth = date('m');
                if($thismonth < 10){
                $str = str_replace('0','', $thismonth);
                }else{
                    $str = $thismonth;
                }
                for ($d = 1; $d <= 31; $d++) {
                    $time = mktime(12, 0, 0, $month, $d, $year);
                    if (date('m', $time) == $month)
                        $list[] = date('d', $time);
                } ?>
                <div class="text-uppercase text-center list-group-item active">Chọn ngày</div>
                <div class="row">
                    <?php
                    foreach ($list as $days) {
                        foreach ($taskdetail as $taskitem) {
                            $d = date('d', $taskitem->created_date);
                            $m = date('m', $taskitem->created_date);
                            $y = date('Y', $taskitem->created_date);
                            if ($d == $days && $m == $month && $y == $year) {
                                $class = 'active';
                                break;
                            } else {
                                $class = '';
                            }
                        }
                        ?>
                        <div class="col-lg-2 col-xs-3 <?php echo $class; if(($days < $today && $month <= $str) || ($days >= $today && $month < $str)){ echo  'disabled';} ?>">
                            <?php
                            if ($class == 'active') {
                                ?>
                                <a href="<?php echo base_url(); ?>account/treetask/filter/<?php echo $days; ?>"> <?php echo $days; ?></a>
                            <?php } else { ?>
                                <?php echo $days; ?>
                            <?php } ?>
                        </div>
                    <?php } ?>
                </div>
                <nav>
                    <ul class="list-month pagination">
                        <?php
                        $month_cur = strtolower($this->uri->segment(4));
                        for ($month_page = 1; $month_page <= 12; $month_page++) {
                            if ($month_cur == $month_page) {
                                $class = 'class="active" ';
                            } else {
                                $class = '';
                            }
                            ?>
                            <li <?php echo $class; ?>>                               
                                <a href="<?php echo base_url(); ?>account/viewtasks/month/<?php echo $month_page; ?>"><span>TH <?php echo $month_page; ?></span></a>
                            </li>
                            <?php
                        } ?>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
    <!--END RIGHT-->
<?php $this->load->view('home/common/footer'); ?>