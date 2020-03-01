<?php $this->load->view('home/common/header'); ?>
<?php $this->load->view('home/common/tinymce'); ?>
    <div class="container-fluid">
        <div class="row">
            <?php $this->load->view('home/common/left'); ?>
            <SCRIPT TYPE="text/javascript">
                jQuery(document).ready(function () {
                    jQuery('#con_user_recieve').change(function () {
                        if (jQuery(this).val() != 0)jQuery('#position_contact').attr('disabled', 'disabled');
                        else jQuery('#position_contact').removeAttr('disabled');
                    });
                    jQuery('#choose_receiver_0').click(function () {
                        jQuery('#position_contact').attr('disabled', 'disabled');
                        jQuery('#con_user_recieve').attr('disabled', 'disabled');
                    });
                    
                })
            </SCRIPT>
            <!--BEGIN: RIGHT-->
            <div class="col-lg-9 col-md-9 col-sm-8 created-task">
                <?php  if ($successSendContactAccount == false){ ?>
                    <form name="frmTaskComment" id="frmTaskComment" method="post">
                        <div class="row">
                            <h2 class="page-title text-uppercase">
                                <?php
                                    $d = date('d');
                                    $m = date('m');
                                    $y = date('Y');
                                    $getday = strtolower($this->uri->segment(5));
                                    ?>
                                Công việc trong ngày( <?php if(empty($getday)){echo date('d').'/';} else{echo $getday.'/' ;} if(isset($month)){ echo $month. '/';} else{ echo $m. '/';} echo $y;?> )
                                <span class="pull-right">
                                    <select name="daytask" id="daytask" onchange="ActionLink('<?php echo $statusUrl; ?>/filter/'+this.value)" class="text-primary">
                                        <?php
                                        $list = array();
                                        $month = date("m");
                                        $year = date("Y");
                                        for ($days = 1; $days <= 31; $days++) {
                                            $time = mktime(12, 0, 0, $month, $days, $year);
                                            if (date('m', $time) == $month){
                                                $list[] = date('d', $time);
                                            }
                                            ?>
                                            <?php if (empty($getday) && $days == date('d')) { ?>
                                                <option selected="selected" value="<?php echo $days; ?>"><?php echo $days . '/' . $month . '/' . $year ?></option>
                                            <?php } elseif(isset($getday) && $getday == $days){?>
                                                <option selected="selected" value="<?php echo $days; ?>"><?php echo $days . '/' . $month . '/' . $year ?></option>
                                            <?php } else{ ?>
                                                <option value="<?php echo $days; ?>"><?php echo $days . '/' . $month . '/' . $year ?></option>
                                            <?php }
                                        }?>
                                    </select>
                                </span>
                            </h2>
                        </div>
                        <?php if(empty($mytask)){?>
                        <div class="row">
                            <div class="nojob"><span> Không có công việc nào được giao!</span></div>
                        </div>
                        <?php } else{
                            $d = date('d', $mytask->created_date);
                            $m = date('m', $mytask->created_date);
                            $y = date('Y', $mytask->created_date);
                            $getday = strtolower($this->uri->segment(5));
                            ?>
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
                                <?php echo $mytask->note;?>
                            </div>
                        </div>
                        <input type="hidden" value="<?php echo $mytask->id; ?>" name="id_task" id="id_task">
                        <div class="row">
                            <div class="col-lg-4">Trạng thái </div>
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
                                            <a  onclick="TaskStatus('<?php echo base_url();?>', <?php echo $mytask->id; ?>);" name="submittask"
                                                id="submittask" class="btn btn-primary"> Đã làm xong
                                            </a>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                            <br/>
                            
                            <!-- Contenedor Principal -->
                            <div class="comments-container">
                                 <?php if ($comments && count($comments) > 0){ ?>
                                <h1>Nhận xét</h1>
                                <ul id="comments-list" class="comments-list mCustomScrollbar" data-mcs-theme="minimal-dark">

                                    <?php foreach ($comments as $comment) {
                                        if ((int)$this->session->userdata('sessionUser') == $comment->use_id) {
                                            $clas = 'by-author';
                                            $sent = 'fa-share';
                                        }else{
                                            $clas = '';
                                            $sent = 'fa-reply';
                                        }
                                        $fileav = 'media/images/avatar/'.$comment->avatar;
                                        ?>
                                        <li>
                                            <div class="comment-main-level">
                                                <!-- Avatar -->
                                                <div class="comment-avatar"><img src="<?php if (file_exists($fileav) && $comment->avatar != '') {echo base_url().$fileav;}else{ echo base_url().'images/icon/avatar-default.jpg'; }?>" alt=""></div>
                                                <!-- Contenedor del Comentario -->
                                                <div class="comment-box">
                                                    <div class="comment-head">
                                                        <h6 class="comment-name <?php echo $clas;?>"><a href="#"><?php echo $comment->use_fullname ?></a></h6>
                                                        <span>ngày <?php echo date('d/m/Y', $comment->created_date)?></span>
                                                        <i class="fa <?php echo $sent;?>"></i>
                                                    </div>
                                                    <div class="comment-content">
                                                        <?php echo $comment->comment; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    <?php }?>
                                </ul>
                                <?php }?>
                                <hr>
                                <h4>Trả lời</h4>
                                <textarea name="txtContent" id="txtContent"></textarea>
                                <p>
                                    <button type="submit"  name="submit_task"
                                           id="submit_task" class="btn btn-primary">Gửi đi
                                    </button>
                                </p>
                            </div>
                        <?php }?>
                    </form>
                <?php } else { ?>
                    <div class="row">
                        <div class="success_post">
                            <p class="text-center"><a href="<?php echo base_url(); ?>account/staffs/mytask">Click vào đây để tiếp tục</a></p>
                            Bạn đã gửi nhận xét thành công!
                        </div>
                    </div>
                <?php }?>
            </div>
        </div>
    </div>
    <!--END RIGHT-->
<?php $this->load->view('home/common/footer'); ?>