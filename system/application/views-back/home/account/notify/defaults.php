<?php $this->load->view('home/common/account/header'); ?>
<div class="container-fluid">
    <div class="row">
	<?php $this->load->view('home/common/left'); ?>

	<script>
	    function submitenterQ(myfield, e, baseUrl)
	    {
		var keycode;
		if (window.event)
		    keycode = window.event.keyCode;
		else if (e)
		    keycode = e.which;
		else
		    return true;
		if (keycode == 13) {
		    ActionSearch(baseUrl, 0);
		    return false;
		} else
		    return true;
	    }
	</script>
	<!--BEGIN: RIGHT-->

	<div class="col-md-9 col-sm-8 col-xs-12">
	    <h4 class="page-header text-uppercase" style="margin-top:10px">
		<?php echo $this->lang->line('title_notify_defaults'); ?>
	    </h4>
	    <table class="table table-bordered"  width="100%" border="0" cellpadding="0" cellspacing="0">
		<?php if (count($notify) > 0) { ?>
    		<thead>
    		    <tr>
    			<td colspan="5" id="boxfilter_account" class="form-inline">
    			    <div class="input-group">
    				<input type="text" name="keyword_account" id="keyword_account" value="<?php
				    if (isset($keyword)) {
					echo $keyword;
				    }
				    ?>" maxlength="100" placeholder="Từ khóa" class="form-control" onKeyUp="BlockChar(this, 'AllSpecialChar')" onfocus="ChangeStyle('keyword_account', 1)" onblur="ChangeStyle('keyword_account', 2)" onKeyPress="return submitenterQ(this, event, '<?php echo base_url(); ?>account/notify/')" />
    				<div class="input-group-addon"  onclick="ActionSearch('<?php echo base_url(); ?>account/notify/', 0)" border="0" style="cursor:pointer;" alt="<?php echo $this->lang->line('search_tip'); ?>"><i class="fa fa-search"></i></div>
    			    </div>
    			    <input type="hidden" name="search_account" id="search_account" value="title" />
    			</td>
    		    </tr>
    		    <tr class="v_height29">
    			<th width="5%" class="hidden-xs">STT</th>
    			<th width="35%" >
				<?php echo $this->lang->line('title_list'); ?><br />
    			    <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>title/by/asc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
    			    <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>title/by/desc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
    			</th>
    			<th width="25%">
				<?php echo $this->lang->line('degree_list'); ?><br />
    			    <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>degree/by/asc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
    			    <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>degree/by/desc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
    			</th>
    			<th width="20%">
				<?php echo $this->lang->line('date_notify_list'); ?><br />
    			    <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>date/by/asc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
    			    <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>date/by/desc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
    			</th>
    			<th width="15%" >
				<?php echo $this->lang->line('view_list'); ?><br />
    			    <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>view/by/asc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
    			    <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>view/by/desc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
    			</th>
    		    </tr>
    		</thead>
    		<tbody>
			<?php
			$idDiv = 1;
			$share = strtolower($this->uri->segment(2));
			if (isset($share) && $share == 'sharelist') {
			    $shareurl = '/sharelist';
			} else {
			    $shareurl = '/notify';
			}
			?>
			<?php foreach ($notify as $notifyArray) { ?>
			    <tr>
				<td height="32" class="hidden-xs" ><?php echo $sTT; ?></td>
				<td height="32" class="line_account_2">
				    <a class="menu_1" href="<?php echo base_url() . 'account' . $shareurl . '/detail/' . $notifyArray->not_id; ?>" alt="<?php echo $this->lang->line('view_tip'); ?>">
					<?php echo $notifyArray->not_title; ?>
				    </a>
				</td>
				<td height="32" class="text-center">
				    <?php if ((int) $notifyArray->not_degree == 1) { ?>
	    			    <span style="color:#009900; font-weight:normal;"><?php echo $this->lang->line('normal_degree_notify_defaults'); ?></span>
				    <?php } elseif ((int) $notifyArray->not_degree == 2) { ?>
	    			    <span style="color:#06F; font-weight:bold;"><?php echo $this->lang->line('important_degree_notify_defaults'); ?></span>
				    <?php } else { ?>
	    			    <span style="color:#FF0000; font-weight:bold;"><?php echo $this->lang->line('rushed_degree_notify_defaults'); ?></span>
				    <?php } ?>
				</td>
				<td  height="32">
				    <?php echo date('d-m-Y', $notifyArray->not_begindate); ?>
				</td>
				<td height="32" >
				    <?php if (trim($notifyArray->not_view) != '' && stristr($notifyArray->not_view, "[$userID]")) { ?>
	    			    <img src="<?php echo base_url(); ?>templates/home/images/public.png" border="0" alt="<?php echo $this->lang->line('viewed_tip'); ?>" title="<?php echo $this->lang->line('viewed_tip'); ?>" />
				    <?php } else { ?>
	    			    <img src="<?php echo base_url(); ?>templates/home/images/unpublic.png" border="0" alt="<?php echo $this->lang->line('not_viewed_tip'); ?>" title="<?php echo $this->lang->line('not_viewed_tip'); ?>"/>
				    <?php } ?>
				</td>
			    </tr>
			    <?php $idDiv++; ?>
			    <?php $sTT++; ?>
			<?php } ?>
			<?php if (!empty($linkPage)) { ?>
			    <tr>
				<td>
				    <?php echo $linkPage; ?>
				</td>
			    </tr>
			<?php } ?>
    		</tbody>
		<?php } elseif (count($notify) == 0 && trim($keyword) != '') { ?>
    		<thead>
    		    <tr class="v_height29">
    			<th width="5%" class="title_account_0">STT</th>
    			<th width="45%" class="title_account_1">
				<?php echo $this->lang->line('title_list'); ?>
    			    <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>title/by/asc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
    			    <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>title/by/desc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
    			</th>
    			<th width="20%" class="title_account_2">
				<?php echo $this->lang->line('degree_list'); ?>
    			    <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>degree/by/asc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
    			    <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>degree/by/desc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
    			</th>
    			<th width="20%" class="title_account_1">
				<?php echo $this->lang->line('date_notify_list'); ?>
    			    <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>date/by/asc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
    			    <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>date/by/desc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
    			</th>
    			<th width="10%" class="title_account_2">
				<?php echo $this->lang->line('view_list'); ?>
    			    <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>view/by/asc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
    			    <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>view/by/desc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
    			</th>   
    		    </tr>
    		</thead>
    		<tbody>
			<?php $idDiv = 1; ?>
			<?php foreach ($notify as $notifyArray) { ?>
			    <tr>
				<td height="32" ><?php echo $sTT; ?></td>
				<td height="32" >
				    <a class="menu_1" href="<?php echo base_url(); ?>account/notify/detail/<?php echo $notifyArray->not_id; ?>" alt="<?php echo $this->lang->line('view_tip'); ?>">
					<?php echo $notifyArray->not_title; ?>
				    </a>
				</td>
				<td height="32">
				    <?php if ((int) $notifyArray->not_degree == 1) { ?>
	    			    <span style="color:#009900; font-weight:normal;"><?php echo $this->lang->line('normal_degree_notify_defaults'); ?></span>
				    <?php } elseif ((int) $notifyArray->not_degree == 2) { ?>
	    			    <span style="color:#06F; font-weight:bold;"><?php echo $this->lang->line('important_degree_notify_defaults'); ?></span>
				    <?php } else { ?>
	    			    <span style="color:#FF0000; font-weight:bold;"><?php echo $this->lang->line('rushed_degree_notify_defaults'); ?></span>
				    <?php } ?>
				</td>
				<td height="32">
				    <?php echo date('d-m-Y', $notifyArray->not_begindate); ?>
				</td>
				<td height="32">
				    <?php if (trim($notifyArray->not_view) != '' && stristr($notifyArray->not_view, "[$userID]")) { ?>
	    			    <img src="<?php echo base_url(); ?>templates/home/images/public.png" border="0" alt="<?php echo $this->lang->line('viewed_tip'); ?>" />
				    <?php } else { ?>
	    			    <img src="<?php echo base_url(); ?>templates/home/images/unpublic.png" border="0" alt="<?php echo $this->lang->line('not_viewed_tip'); ?>" />
				    <?php } ?>
				</td>
			    </tr>
			    <?php $idDiv++; ?>
			    <?php $sTT++; ?>
			<?php } ?>
    		    <tr>
    			<td>
    			    <input type="text" name="keyword_account" id="keyword_account" value="<?php
				if (isset($keyword)) {
				    echo $keyword;
				}
				?>" maxlength="100" class="inputfilter_account" onKeyUp="BlockChar(this, 'AllSpecialChar')" onfocus="ChangeStyle('keyword_account', 1)" onblur="ChangeStyle('keyword_account', 2)" onKeyPress="return submitenterQ(this, event, '<?php echo base_url(); ?>account/notify/')" />
    			    <input type="hidden" name="search_account" id="search_account" value="title" />
    			    <img src="<?php echo base_url(); ?>templates/home/images/icon_filter.gif" onclick="ActionSearch('<?php echo base_url(); ?>account/notify/', 0)" border="0" style="cursor:pointer;" alt="<?php echo $this->lang->line('search_tip'); ?>" />
    			</td>
    			<td width="50%" class="show_page"><?php echo $linkPage; ?></td>
    		    </tr>
		<?php } elseif (count($notify) == 0 && trim($keyword) != '') { ?>
    		    <tr height="29">
    			<td>STT</td>
    			<td>
				<?php echo $this->lang->line('title_list'); ?>
    			    <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" border="0" />
    			    <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" border="0" />
    			</td>
    			<td>
				<?php echo $this->lang->line('degree_list'); ?>
    			    <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" border="0" />
    			    <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" border="0" />
    			</td>
    			<td>
				<?php echo $this->lang->line('date_notify_list'); ?>
    			    <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" border="0" />
    			    <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" border="0" />
    			</td>
    			<td>
				<?php echo $this->lang->line('view_list'); ?>
    			    <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" border="0" />
    			    <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" border="0" />
    			</td>
    		    </tr>
    		    <tr>
    			<td align="center"><?php echo $this->lang->line('none_record_search_notify_defaults'); ?></td>
    		    </tr>
		    <?php } else { ?>
    		    <tr>
    			<td align="center"><?php echo $this->lang->line('none_record_notify_defaults'); ?></td>
    		    </tr>
		    <?php } ?>
                </tbody>
            </table>       
        </div>
    </div>
</div>
<!--END RIGHT-->
<?php $this->load->view('home/common/footer'); ?>