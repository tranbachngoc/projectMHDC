<?php $this->load->view('home/common/header'); ?>
    <div class="container">
    <div class="row">
<?php $this->load->view('home/common/left'); ?>
<!--BEGIN: RIGHT-->
<div class="col-lg-9 col-md-9 col-sm-8">
    <table class="table table-bordered" width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td>
                <div class="tile_modules tile_modules_blue">
                <div class="fl"></div>
                <div class="fc">
				<?php echo $this->lang->line('title_job_favorite'); ?>
                </div>
                <div class="fr"></div>
                </div>
            </td>
        </tr>
        <?php if(count($favoriteJob) > 0){ ?>
        <form name="frmAccountFavoriteJob" method="post">
        <tr>
            <td class="v_background" height="29">
                <table border="0" width="100%" height="29" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                        <td width="50" class="title_account_0">STT</td>
                        <td width="30" class="title_account_1"><input type="checkbox" name="checkall" id="checkall" value="0" onclick="DoCheck(this.checked,'frmAccountFavoriteJob',0)" /></td>
                        <td class="title_account_2">
                            <?php echo $this->lang->line('title_list'); ?>
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>title/by/asc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>title/by/desc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                        </td>
                        <td width="150" class="title_account_1">
                            <?php echo $this->lang->line('salary_list'); ?>
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>salary/by/asc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>salary/by/desc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                        </td>
                        <td width="110" class="title_account_2">
                            <?php echo $this->lang->line('date_post_list'); ?>
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>postdate/by/asc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>postdate/by/desc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                        </td>
                        <td width="130" class="title_account_1" style="border-right:1px solid #63c6fd;">
                            <?php echo $this->lang->line('date_add_list'); ?>
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>date/by/asc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>date/by/desc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td class="main_list" valign="top" background="<?php echo base_url(); ?>templates/home/images/bg_mainkhung_ac.jpg" >
                <table border="0" width="788" align="center" cellpadding="0" cellspacing="0">
                    <?php $idDiv = 1; ?>
                    <?php foreach($favoriteJob as $favoriteJobArray){ ?>
                    <tr style="background:#<?php if($idDiv % 2 == 0){echo 'f1f9ff';}else{echo 'FFF';} ?>;" id="DivRow_<?php echo $idDiv; ?>" onmouseover="ChangeStyleRow('DivRow_<?php echo $idDiv; ?>',<?php echo $idDiv; ?>,1)" onmouseout="ChangeStyleRow('DivRow_<?php echo $idDiv; ?>',<?php echo $idDiv; ?>,2)">
                        <td width="46" height="32" class="line_account_0"><?php echo $sTT; ?></td>
                        <td width="30" height="32" class="line_account_1">
                            <input type="checkbox" name="checkone[]" id="checkone" value="<?php echo $favoriteJobArray->jof_id; ?>" onclick="DoCheckOne('frmAccountFavoriteJob')" />
                        </td>
                        <td height="32" class="line_account_2">
                            <a class="menu_1" href="<?php echo base_url(); ?>job/field/<?php echo $favoriteJobArray->job_field; ?>/detail/<?php echo $favoriteJobArray->job_id; ?>" alt="<?php echo $this->lang->line('detail_tip'); ?>">
                                <?php echo sub($favoriteJobArray->job_title, 50); ?>
                            </a>
                            <span class="number_view">(<?php echo $favoriteJobArray->job_view; ?>)</span>
                        </td>
                        <td width="140" height="32" class="line_account_3" style="text-align:center;">
                            <?php $salaryView = explode('|', $favoriteJobArray->job_salary); ?>
                           	<font color="#FF0000"><span id="DivCost_<?php echo $idDiv; ?>"></span>&nbsp;<?php echo array_pop($salaryView); ?></font>
                           	<script type="text/javascript">FormatCost('<?php echo $salaryView[0]; ?>', 'DivCost_<?php echo $idDiv; ?>');</script>
                        </td>
                        <td width="110" height="32" class="line_account_4">
                            <?php echo date('d-m-Y', $favoriteJobArray->job_begindate); ?>
                        </td>
                        <td width="125" height="32" class="line_account_1" style="border-right:none;">
                            <?php echo date('d-m-Y', $favoriteJobArray->jof_date); ?>
                        </td>
                    </tr>
                    <?php $idDiv++; ?>
                    <?php $sTT++; ?>
                    <?php } ?>
                </table>
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                        <td width="30%" id="delete_account"><img src="<?php echo base_url(); ?>templates/home/images/icon_deletejob_account.gif" onclick="ActionSubmit('frmAccountFavoriteJob')" style="cursor:pointer;" border="0" /></td>
                        <td align="center" id="boxfilter_account">
                            <input type="text" name="keyword_account" id="keyword_account" value="<?php if(isset($keyword)){echo $keyword;} ?>" maxlength="100" class="inputfilter_account" onKeyUp="BlockChar(this,'AllSpecialChar')" onfocus="ChangeStyle('keyword_account',1)" onblur="ChangeStyle('keyword_account',2)" />
                            <input type="hidden" name="search_account" id="search_account" value="title" />
                            <img src="<?php echo base_url(); ?>templates/home/images/icon_filter.gif" onclick="ActionSearch('<?php echo base_url(); ?>account/job/favorite/', 0)" border="0" style="cursor:pointer;" alt="<?php echo $this->lang->line('search_tip'); ?>" />
                        </td>
                        <td width="30%" class="show_page"><?php echo $linkPage; ?></td>
                    </tr>
                </table>
            </td>
        </tr>
        </form>
        <?php }elseif(count($favoriteJob) == 0 && trim($keyword) != ''){ ?>
        <tr>
            <td background="<?php echo base_url(); ?>templates/home/images/bg_titleaccount.jpg" height="29">
                <table border="0" width="100%" height="29" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                        <td width="50" class="title_account_0">STT</td>
                        <td width="30" class="title_account_1"><input type="checkbox" name="checkall" id="checkall" value="0" onclick="DoCheck(this.checked,'frmAccountFavoriteJob',0)" /></td>
                        <td class="title_account_2">
                            <?php echo $this->lang->line('title_list'); ?>
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" border="0" />
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" border="0" />
                        </td>
                        <td width="150" class="title_account_1">
                            <?php echo $this->lang->line('salary_list'); ?>
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" border="0" />
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" border="0" />
                        </td>
                        <td width="110" class="title_account_2">
                            <?php echo $this->lang->line('date_post_list'); ?>
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" border="0" />
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" border="0" />
                        </td>
                        <td width="130" class="title_account_1" style="border-right:1px solid #63c6fd;">
                            <?php echo $this->lang->line('date_add_list'); ?>
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" border="0" />
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" border="0" />
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td class="main_list" valign="top" class="v_background" >
                <table border="0" width="788" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                        <td class="none_record_search" align="center"><?php echo $this->lang->line('none_record_search_job_favorite'); ?></td>
					</tr>
                </table>
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                        <td width="30%" id="delete_account"><img src="<?php echo base_url(); ?>templates/home/images/icon_deletejob_account.gif" onclick="" style="cursor:pointer;" border="0" /></td>
                        <td align="center" id="boxfilter_account">
                            <input type="text" name="keyword_account" id="keyword_account" value="<?php if(isset($keyword)){echo $keyword;} ?>" maxlength="100" class="inputfilter_account" onKeyUp="BlockChar(this,'AllSpecialChar')" onfocus="ChangeStyle('keyword_account',1)" onblur="ChangeStyle('keyword_account',2)" />
                            <input type="hidden" name="search_account" id="search_account" value="title" />
                            <img src="<?php echo base_url(); ?>templates/home/images/icon_filter.gif" onclick="ActionSearch('<?php echo base_url(); ?>account/job/favorite/', 0)" border="0" style="cursor:pointer;" alt="<?php echo $this->lang->line('search_tip'); ?>" />
                        </td>
                        <td width="30%" class="show_page"></td>
                    </tr>
                </table>
            </td>
        </tr>
        <?php }else{ ?>
        <tr>
        	<td class="none_record" align="center"  ><?php echo $this->lang->line('none_record_job_favorite'); ?></td>
		</tr>
        <?php } ?>
        <tr>
            <td>
            	<div class="border_bottom_blue">
                	<div class="fl"></div>
                    <div class="fr"></div>
                </div>
            </td>
        </tr>
    </table>
    </div>
</div>
    </div>
<!--END RIGHT-->
<?php $this->load->view('home/common/footer'); ?>