<?php $this->load->view('home/common/header'); ?>
    <div class="container">
        <div class="row">
            <?php $this->load->view('home/common/left'); ?>
            <!--BEGIN: RIGHT-->
            <SCRIPT TYPE="text/javascript">
                function SearchContact(baseUrl) {
                    Contact_title = '';
                    if (document.getElementById('keyword_account').value != '')
                        Contact_title = document.getElementById('keyword_account').value;
                    window.location = baseUrl + 'account/contact/search/title/keyword/' + Contact_title + '/';
                }
                function submitenterContact(myfield,e,baseUrl)
                {
                    var keycode;
                    if (window.event) keycode = window.event.keyCode;
                    else if (e) keycode = e.which;
                    else return true;

                    if (keycode == 13)
                    {
                        SearchContact(baseUrl);
                        return false;
                    }
                    else
                        return true;
                }
            </SCRIPT>
            <div class="col-lg-9 col-md-9 col-sm-8 col-xs-12 db_table">
                <h2>Thư đã nhận</h2>
                <form name="frmAccountSendContact" method="post">
                <table class="table table-bordered" width="100%" border="0" cellpadding="0" cellspacing="0">
                    <?php if (count($contact) > 0) { ?>
                    <thead>
                    <tr>
                        <th colspan="6">
                            <div class="col-lg-6">
                                <div class="input-group" style="cursor: pointer">
                                    <input type="text" name="keyword_account" id="keyword_account"  placeholder="Tìm kiếm thư đã nhận"
                                           value="<?php if (isset($keyword)) {
                                               echo $keyword;
                                           } ?>" maxlength="100" class="form-control"
                                           onKeyUp="BlockChar(this,'AllSpecialChar')"
                                           onfocus="ChangeStyle('keyword_account',1)"
                                           onblur="ChangeStyle('keyword_account',2)"
                                           onKeyPress="return submitenterContact(this,event,'<?php echo base_url(); ?>')"/>
                                    <input type="hidden" name="search_account" id="search_account" value="title"/>
                                    <div onclick="ActionSearch('<?php echo base_url(); ?>account/contact/', 0)" class="input-group-addon"><i class="fa fa-search"></i></div>
                                </div>
                            </div>
                            <p class="hidden-lg"></p>
                           <div class="col-lg-6">
                               <a class="pull-right btn btn-success" href="<?php echo base_url(); ?>account/contact/send"
                                                     title="<?php echo $this->lang->line('send_contact_account_defaults'); ?>">
                                   <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Soạn thư
                               </a>
                           </div>
                        </th>
                    </tr>
                    <tr>
                        <th width="5%" class="hidden-xs">STT</th>
                        <th width="5%"><input type="checkbox" name="checkall" id="checkall" value="0"
                                              onclick="DoCheck(this.checked,'frmAccountSendContact',0)"/></th>
                        <th width="40%" align="center">
                            Tiêu đề thư
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif"
                                 onclick="ActionSort('<?php echo $sortUrl; ?>title/by/asc<?php echo $pageSort; ?>')"
                                 border="0" style="cursor:pointer;" alt=""/>
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif"
                                 onclick="ActionSort('<?php echo $sortUrl; ?>title/by/desc<?php echo $pageSort; ?>')"
                                 border="0" style="cursor:pointer;" alt=""/>
                        </th>
                        <th width="20%">
                           Người gửi
                        </th>
                        <th width="15%">
                            <?php echo $this->lang->line('reply_list'); ?>
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif"
                                 onclick="ActionSort('<?php echo $sortUrl; ?>reply/by/asc<?php echo $pageSort; ?>')"
                                 border="0" style="cursor:pointer;" alt=""/>
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif"
                                 onclick="ActionSort('<?php echo $sortUrl; ?>reply/by/desc<?php echo $pageSort; ?>')"
                                 border="0" style="cursor:pointer;" alt=""/>
                        </th>
                        <th width="15%" class="hidden-xs">
                            <?php echo $this->lang->line('date_send_list'); ?>
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif"
                                 onclick="ActionSort('<?php echo $sortUrl; ?>date/by/asc<?php echo $pageSort; ?>')"
                                 border="0" style="cursor:pointer;" alt=""/>
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif"
                                 onclick="ActionSort('<?php echo $sortUrl; ?>date/by/desc<?php echo $pageSort; ?>')"
                                 border="0" style="cursor:pointer;" alt=""/>
                        </th>
                    </tr>
                    </thead>

                            <?php $idDiv = 1; ?>
                            <?php foreach ($contact as $contactArray) { ?>
                            <tbody>

                                <tr onmouseover="ChangeStyleRow('DivRow_<?php echo $idDiv; ?>',<?php echo $idDiv; ?>,1)"
                                    onmouseout="ChangeStyleRow('DivRow_<?php echo $idDiv; ?>',<?php echo $idDiv; ?>,2)">
                                    <td width="5%" height="32" class="hidden-xs"><?php echo $sTT; ?></td>
                                    <td width="5%" height="32" class="line_account_1">
                                        <input type="checkbox" name="checkone[]" id="checkone"
                                               value="<?php echo $contactArray->con_id; ?>"
                                               onclick="DoCheckOne('frmAccountSendContact')"/>
                                    </td>
                                    <td width="40%" height="32" class="line_account_2">
                                       
                                        <?php if( ($contactArray->con_user == (int)$this->session->userdata('sessionUser') && $contactArray->con_in_usend > 0) || ($contactArray->con_user_recieve == (int)$this->session->userdata('sessionUser') && $contactArray->con_in_urecei > 0) ){?>
                                          <span class="badge" style="background:red"><?php if($contactArray->con_user == (int)$this->session->userdata('sessionUser') && $contactArray->con_in_usend > 0) {echo $contactArray->con_in_usend; }else{ echo $contactArray->con_in_urecei; } ?></span>
                                          <a class="menu_1"
                                             href="<?php echo base_url(); ?>account/contact/detail/<?php echo $contactArray->con_id; ?>"
                                             alt="<?php echo $this->lang->line('view_tip'); ?>">
                                              <b><i class="fa fa-envelope" aria-hidden="true"></i> <?php echo $contactArray->con_title; ?></b>
                                          </a>
                                        <?php } else { ?>
                                          <a class="menu_1"
                                           href="<?php echo base_url(); ?>account/contact/detail/<?php echo $contactArray->con_id; ?>"
                                           alt="<?php echo $this->lang->line('view_tip'); ?>">
                                            <i class="fa fa-envelope-o" aria-hidden="true"></i> <?php echo $contactArray->con_title; ?>
                                          </a>
                                        <?php } ?>

                                    </td>
                                    <td width="20%" height="32" class="line_account_3">
                                        <span class="text-success"> <b>
                                            <?php if ((int)$contactArray->con_user == 0) {
                                                echo "Ban quản trị";
                                            } else {
                                                echo $contactArray->use_username;
                                            } ?> </b></span>
                                    </td>
                                    <td width="15%" height="32" class="line_account_1"
                                        style="border-left: none; text-align:center;">
                                        <?php if ((int)$contactArray->con_reply == 1) { ?>
                                        <span class="text-success"><i class="fa fa-check-circle" aria-hidden="true"></i></span>
                                        <?php } else { ?>
                                           <span class="text-danger"><i class="fa fa-times-circle" aria-hidden="true"></i></span>
                                        <?php } ?>
                                    </td>
                                    <td width="15%" height="32"  class="hidden-xs">
                                        <?php echo date('d-m-Y', $contactArray->con_date_contact); ?>
                                    </td>
                                </tr>
                                <?php $idDiv++; ?>
                                <?php $sTT++; ?>
                            <?php } ?>

                            <?php if (isset($linkPage) && !empty($linkPage)) { ?>
                                <tr>
                                    <td class="text-center"><?php echo $linkPage; ?></td>
                                </tr>
                            <?php } ?>
                            </tbody>
                    <?php } elseif (count($contact) == 0 && trim($keyword) != '') { ?>
                        <thead>
                        <tr>
                            <th colspan="6">
                                <div class="col-lg-6">
                                    <div class="input-group" style="cursor: pointer">
                                        <input type="text" name="keyword_account" id="keyword_account" placeholder="Tìm kiếm thư đã nhận"
                                               value="<?php if (isset($keyword)) {
                                                   echo $keyword;
                                               } ?>" maxlength="100" class="form-control"
                                               onKeyUp="BlockChar(this,'AllSpecialChar')"
                                               onfocus="ChangeStyle('keyword_account',1)"
                                               onblur="ChangeStyle('keyword_account',2)"
                                               onKeyPress="return submitenterContact(this,event,'<?php echo base_url(); ?>')"/>
                                        <input type="hidden" name="search_account" id="search_account" value="title"/>
                                        <div onclick="ActionSearch('<?php echo base_url(); ?>account/contact/outbox', 0)" class="input-group-addon"><i class="fa fa-search"></i></div>
                                    </div>
                                </div>
                                <p class="hidden-lg"></p>
                                <div class="col-lg-6">
                                    <a class="pull-right btn btn-success" href="<?php echo base_url(); ?>account/contact/send"
                                       title="<?php echo $this->lang->line('send_contact_account_defaults'); ?>">
                                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Soạn thư
                                    </a>
                                </div>
                            </th>
                        </tr>
                        <tr>
                            <td width="5%" >STT</td>
                            <td width="5%" ><input type="checkbox" name="checkall" id="checkall"
                                                                          value="0"
                                                                          onclick="DoCheck(this.checked,'frmAccountSendContact',0)"/>
                            </td>
                            <td width="40%">
                                Tiêu đề
                                <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" border="0"/>
                                <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" border="0"/>
                            </td>
                            <td width="20%">
                                Người gửi
                                <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" border="0"/>
                                <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" border="0"/>
                            </td>
                            <td width="15%">
                                Trả lời
                                <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" border="0"/>
                                <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" border="0"/>
                            </td>
                            <td width="15%">
                                Ngày gửi
                                <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" border="0"/>
                                <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" border="0"/>
                            </td>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td colspan="6" class="none_record_search"  align="center"><?php echo $this->lang->line('none_record_search_contact_defaults'); ?></td>
                        </tr>
                    <?php } else { ?>
                        <tr>
                            <td colspan="6" class="none_record" align="center"
                                style="">Không có thư đến</td>
                        </tr>
                    <?php } ?>
                        </tbody>
                </table>
                </form>
            </div>
        </div>
    </div>
    <!--END RIGHT-->
<?php $this->load->view('home/common/footer'); ?>