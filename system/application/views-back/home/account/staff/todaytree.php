<?php $this->load->view('home/common/header'); ?>
<?php $this->load->view('home/common/tinymce'); ?>
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
                });
                //-->
            </SCRIPT>
            <!--BEGIN: RIGHT-->
            <div class="col-lg-9 col-md-9 col-sm-8 created-task">
                <?php
                if ($successSendContactAccount == false) {
                    ?>
                    <h4 class="page-header text-uppercase borderleftright">
                        <?php foreach ($tasklist as $key => $getday) {
                            $day = date('d', $getday->created_date);
                            $month = date('m', $getday->created_date);
                            $year = date('Y', $getday->created_date);
                        }
                        $getday = strtolower($this->uri->segment(4));
                        $m = date("m");
                        $y = date("Y");
                        ?>
                        <span>Công việc trong ngày:</span> ( <?php if (empty($getday)) {
                            echo date('d') . '/';
                        } else {
                            echo $getday . '/';
                        }
                        if (isset($month)) {
                            echo $month . '/';
                        } else {
                            echo $m . '/';
                        }
                        echo $y; ?> )
                        <span class="pull-right">
                            <select name="daytask" id="daytask"
                                    onchange="ActionLink('<?php echo $statusUrl; ?>/filter/'+this.value)"
                                    class="text-primary">
                                <?php
                                $list = array();
                                $month = date("m");
                                $year = date("Y");
                                for ($days = 1; $days <= 31; $days++) {
                                    $time = mktime(12, 0, 0, $month, $days, $year);
                                    if (date('m', $time) == $month) {
                                        $list[] = date('d', $time);
                                    }
                                    ?>
                                    <?php if (empty($getday) && $days == date('d')) { ?>
                                        <option selected="selected"
                                                value="<?php echo $days; ?>"><?php echo $days . '/' . $month . '/' . $year ?></option>
                                    <?php } elseif (isset($getday) && $getday == $days) { ?>
                                        <option selected="selected"
                                                value="<?php echo $days; ?>"><?php echo $days . '/' . $month . '/' . $year ?></option>
                                    <?php } else { ?>
                                        <option
                                            value="<?php echo $days; ?>"><?php echo $days . '/' . $month . '/' . $year ?></option>
                                    <?php }
                                } ?>
                            </select>
                        </span>
                    </h4>
                    <form class="vienchung" name="frmTaskComment" id="frmTaskComment" method="post">
                        <?php if (empty($mytask)) { ?>
                            <div class="row " style="text-align:center">
                                <div class="nojob"><span> Không có công việc nào được giao!</span></div>
                            </div>
                        <?php } else { ?>
                            <div class="row">
                                <div class="col-lg-4">Tiêu đề</div>
                                <div class="col-lg-8">
                                    <?php echo $mytask->name; ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4">Chi tiết</div>
                                <div class="col-lg-8">
                                    <?php echo $mytask->detail; ?>
                                </div>
                            </div>
                            <?php if (!empty($comments)) {
                                $cls = 'last-row';
                            } ?>
                            <div class="row">
                                <div class="col-lg-4">Ghi chú</div>
                                <div class="col-lg-8">
                                    <?php echo $mytask->note; ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4">Trạng thái</div>
                                <div class="col-lg-8" id="status_task">
                                    <i class="fa fa-spinner fa-spin fa-fw margin-bottom"></i>
                                    <?php if ($mytask->status == 2) { ?>
                                        <span class="text-success"><i class="fa fa-check" aria-hidden="true"></i> Đã hoàn thành</span>
                                    <?php } elseif ($mytask->status == 1) { ?>
                                     <span class="text-warning"><i class="fa fa-refresh"></i> Cấp trên đang xem...</span>
                                    <?php } else { ?>
                                        <span class="text-danger"><i class="fa fa-times-circle" aria-hidden="true"></i> Chưa làm</span>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="row last-row">
                                <?php if ($mytask->status == 0) { ?>
                                    <div id="last-row">
                                        <div class="col-lg-4"></div>
                                        <div class="col-lg-8">
                                            <a  onclick="CheckInput_TaskComment('<?php echo base_url();?>', <?php echo $mytask->id; ?>);" name="submittask"
                                                    id="submittask" class="btn btn-primary"> Đã làm xong
                                            </a>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                            <br/>
                            <div class="row">
                                <div class="tile_modules tile_modules_blue">
                                    Nhận xét
                                </div>
                            </div>
                            <div class="row hidden">
                                <div class="col-lg-4">Viết nhận xét</div>
                                <div class="col-lg-8">
                                    <textarea name="txtContent" id="txtContent"></textarea>
                                    <button type="button" onclick="CheckInput_TaskComment('<?php echo base_url();?>', <?php echo $mytask->id; ?>);" name="submit_task"
                                            id="submit_task" class="btn btn-primary">Gửi nhận xét
                                    </button>
                                    <p></p>
                                </div>
                            </div>
                            <div class="row hidden">
                                <div class="col-lg-4">Nội dung</div>
                                <div class="col-lg-8">
                                    <ul class="list-comment">
                                        <?php foreach ($comments as $comment) {
                                            if ((int)$this->session->userdata('sessionUser') == $comment->use_id) {
                                                $clas = 'meclass';
                                            } else {
                                                $clas = '';
                                            }
                                            ?>
                                            <li class="comment-item <?php echo $clas; ?>"> <?php echo $comment->use_fullname . ': ' . $comment->comment; ?></li>
                                        <?php } ?>
                                    </ul>
                                </div>
                            </div>
                            <?php
                            if ($mytask->images1) {
                                ?>
                                <div class="col-lg-12">
                                    <div id="myModal" class="modal fade" tabindex="-1" role="dialog"
                                         aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-body">
                                                    <img
                                                        src="<?php echo base_url() . 'media/images/staff/' . $mytask->date_img . '/' . $mytask->images1; ?>"
                                                        class="img-responsive">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4">Hình 1</div>
                                    <div class="col-lg-8">
                                        <img id="images1"
                                             src="<?php echo base_url() . 'media/images/staff/' . $mytask->date_img . '/' . $mytask->images1; ?>"
                                             class="img-responsive magnify"> <!-- class="img-responsive" -->
                                        <!-- target="_blank"<a onclick="zoom_img()" href="<?php echo base_url() . 'media/images/staff/' . $mytask->date_img . '/' . $mytask->images1; ?>"><img id="images11" src="<?php echo base_url() . 'media/images/staff/' . $mytask->date_img . '/' . $mytask->images1; ?>" class="img-responsive magnify"></a> -->
                                        <button type="button" class="btn btn-primary" data-toggle="modal"
                                                data-target="#myModal">Xem Ảnh Lớn
                                        </button>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                            <?php
                            if ($mytask->images2) {
                                ?>
                                <div class="row">
                                <div id="img2" class="modal fade" tabindex="-1" role="dialog"
                                     aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-body">
                                                <img
                                                    src="<?php echo base_url() . 'media/images/staff/' . $mytask->date_img . '/' . $mytask->images2; ?>"
                                                    class="img-responsive">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">Hình 2</div>
                                <div class="col-lg-8">
                                    <img
                                        src="<?php echo base_url() . 'media/images/staff/' . $mytask->date_img . '/' . $mytask->images2; ?>"
                                        class="img-responsive magnify">
                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                            data-target="#img2">Xem Ảnh Lớn
                                    </button>
                                </div>
                                </div>

                            <?php } ?>
                            <?php
                            if ($mytask->images3) {
                                ?>
                                <div id="img3" class="modal fade" tabindex="-1" role="dialog"
                                     aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-body">
                                                <img
                                                    src="<?php echo base_url() . 'media/images/staff/' . $mytask->date_img . '/' . $mytask->images3; ?>"
                                                    class="img-responsive">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4">Hình 3</div>
                                    <div class="col-lg-8">
                                        <img
                                            src="<?php echo base_url() . 'media/images/staff/' . $mytask->date_img . '/' . $mytask->images3; ?>"
                                            class="img-responsive magnify">
                                        <button type="button" class="btn btn-primary" data-toggle="modal"
                                                data-target="#img3">Xem Ảnh Lớn
                                        </button>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php
                            if ($mytask->file1) {
                                ?>
                                <div class="row">
                                    <div class="col-lg-4">File 1 (Word)</div>
                                    <div class="col-lg-8"><a
                                            href="<?php echo base_url() . 'media/images/staff/' . $mytask->date_img . '/' . $mytask->file1; ?>"><?php echo $mytask->file1 ?></a>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php if ($mytask->file2) { ?>
                                <div class="row">
                                    <div class="col-lg-4">File 2 (Pdf)</div>
                                    <div class="col-lg-8"><a
                                            href="<?php echo base_url() . 'media/images/staff/' . $mytask->date_img . '/' . $mytask->file2; ?>"><?php echo $mytask->file2 ?></a>
                                    </div>
                                </div>
                            <?php }
                            if ($mytask->file3) {
                                ?>
                                <div class="row">
                                    <div class="col-lg-4">File 3 (Excel)</div>
                                    <div class="col-lg-8"><a
                                            href="<?php echo base_url() . 'media/images/staff/' . $mytask->date_img . '/' . $mytask->file3; ?>"><?php echo $mytask->file3 ?></a>
                                    </div>
                                </div>
                                <?php
                            }
                        } ?>
                    </form>
                <?php } else { ?>
                    <div class="row">
                        <div class="success_post">
                            <p class="text-center"><a href="<?php echo base_url(); ?>account/treetask">Click vào đây để tiếp tục</a></p>
                            Bạn đã gửi nhận xét thành công!
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <!--END RIGHT-->
<?php $this->load->view('home/common/footer'); ?>