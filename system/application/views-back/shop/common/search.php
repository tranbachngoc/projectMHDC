<?php if(isset($siteGlobal)){ ?>
	<h2><?php echo $this->lang->line('title_search_detail_global'); ?></h2>
	<form name="frmSearchPro" method="post" class="form-inline"> 
	<div class="search_main">
		<div class="form-group">
			<div class="input-group">
				<div class="input-group-addon">$</div>
				<input type="text" name="name_search" id="name_search" placeholder="Tên sản phẩm" value="<?php if(isset($nameKeyword)){echo $nameKeyword;} ?>" maxlength="80" class="input_search form-control" onKeyUp="BlockChar(this,'AllSpecialChar')" onfocus="ChangeStyle('name_search',1)" onblur="ChangeStyle('name_search',2)" />
			</div>
		</div>
		<div class="form-group">
			<label style="width:120px;"><?php echo $this->lang->line('cost_search_detail_global'); ?></label>

			<input type="text" value="<?php if(isset($sCostKeyword)){echo $sCostKeyword;} ?>" name="cost_search1" id="cost_search1" class=" form-control" maxlength="9" class="inputcost_search" onkeyup="FormatCurrency('DivShowCostSearch1','currency_search',this.value); BlockChar(this,'NotNumbers');" onfocus="ChangeStyle('cost_search1',1)" onblur="ChangeStyle('cost_search1',2)"  placeholder="<?php echo $this->lang->line('from_search_detail_global'); ?>" />
			<input type="text" value="<?php if(isset($eCostKeyword)){echo $eCostKeyword;} ?>" name="cost_search2" id="cost_search2" class=" form-control" maxlength="9" class="inputcost_search" onkeyup="FormatCurrency('DivShowCostSearch2','currency_search',this.value); BlockChar(this,'NotNumbers');" onfocus="ChangeStyle('cost_search2',1)" onblur="ChangeStyle('cost_search2',2)" placeholder="<?php echo $this->lang->line('to_search_detail_global'); ?>" />
			<select name="currency_search" id="currency_search" class="selectcurrency_search form-control" onchange="FormatCurrency('DivShowCostSearch1','currency_search',document.getElementById('cost_search1').value); FormatCurrency('DivShowCostSearch2','currency_search',document.getElementById('cost_search2').value);">
				<option value="VND" <?php if(isset($currencyKeyword) && $currencyKeyword == 'VND'){echo 'selected="selected"';}elseif(!isset($currencyKeyword)){echo 'selected="selected"';} ?>><?php echo $this->lang->line('vnd_search_detail_global'); ?></option>
				<option value="USD" <?php if(isset($currencyKeyword) && $currencyKeyword == 'USD'){echo 'selected="selected"';} ?>><?php echo $this->lang->line('usd_search_detail_global'); ?></option>
			</select>
			<img src="<?php echo $URLRoot; ?>templates/home/images/help_post.gif"  onmouseout="hideddrivetip();" class="img_helppost" />
			<span class="div_helppost" style="padding-right:40px;">(<?php echo $this->lang->line('only_input_number_help'); ?>)</span>
			<span id="DivShowCostSearch1" style="padding-right:30px;"></span><span id="DivShowCostSearch2"></span>
		</div>
		<div class="form-group saleoff">
				<input type="checkbox" name="saleoff_search" id="saleoff_search" value="1" <?php if(isset($saleoffKeyword) && $saleoffKeyword == '1'){echo 'checked="checked"';} ?> />
				<?php echo $this->lang->line('saleoff_search_detail_global'); ?>
		</div><br/>
		<div class="form-group">
			<label style="width:120px;"><?php echo $this->lang->line('province_search_detail_global'); ?>:</label>
			<select name="province_search" id="province_search" class="selectprovince_search form-control">
				<option value="0" selected="selected"><?php echo $this->lang->line('select_province_search_detail_global'); ?></option>
				<?php foreach($province as $provinceArray){ ?>
				<?php if(isset($placeKeyword) && $placeKeyword == $provinceArray->pre_id){ ?>
				<option value="<?php echo $provinceArray->pre_id; ?>" selected="selected"><?php echo $provinceArray->pre_name; ?></option>
				<?php }else{ ?>
				<option value="<?php echo $provinceArray->pre_id; ?>"><?php echo $provinceArray->pre_name; ?></option>
				<?php } ?>
				<?php } ?>
			</select>
		</div>
		<div class="form-group">
			<label style="width:120px;"><?php echo $this->lang->line('begindate_search_detail_global'); ?>:</label>
			<select name="beginday_search1" id="beginday_search1" class="selectdate_search form-control">
				<option value="0"><?php echo $this->lang->line('day_search_detail_global'); ?></option>
				<?php for($beginday = 1; $beginday <= 31; $beginday++){ ?>
				<?php if(isset($sDayKeyword) && (int)$sDayKeyword == $beginday){ ?>
				<option value="<?php echo $beginday; ?>" selected="selected"><?php echo $beginday; ?></option>
				<?php }else{ ?>
				<option value="<?php echo $beginday; ?>"><?php echo $beginday; ?></option>
				<?php } ?>
				<?php } ?>
			</select>
			<b>-</b>
			<select name="beginmonth_search1" id="beginmonth_search1" class="selectdate_search form-control">
				<option value="0"><?php echo $this->lang->line('month_search_detail_global'); ?></option>
				<?php for($beginmonth = 1; $beginmonth <= 12; $beginmonth++){ ?>
				<?php if(isset($sMonthKeyword) && (int)$sMonthKeyword == $beginmonth){ ?>
				<option value="<?php echo $beginmonth; ?>" selected="selected"><?php echo $beginmonth; ?></option>
				<?php }else{ ?>
				<option value="<?php echo $beginmonth; ?>"><?php echo $beginmonth; ?></option>
				<?php } ?>
				<?php } ?>
			</select>
			<b>-</b>
			<select name="beginyear_search1" id="beginyear_search1" class="selectdate_search form-control">
				<option value="0"><?php echo $this->lang->line('year_search_detail_global'); ?></option>
				<?php for($beginyear = (int)date('Y')-1; $beginyear <= (int)date('Y'); $beginyear++){ ?>
				<?php if(isset($sYearKeyword) && (int)$sYearKeyword == $beginyear){ ?>
				<option value="<?php echo $beginyear; ?>" selected="selected"><?php echo $beginyear; ?></option>
				<?php }else{ ?>
				<option value="<?php echo $beginyear; ?>"><?php echo $beginyear; ?></option>
				<?php } ?>
				<?php } ?>
			</select>
			<font color="#666666"><b><?php echo $this->lang->line('to_search_detail_global'); ?></b></font>
			<select name="beginday_search2" id="beginday_search2" class="selectdate_search form-control">
				<option value="0"><?php echo $this->lang->line('day_search_detail_global'); ?></option>
				<?php for($beginday = 1; $beginday <= 31; $beginday++){ ?>
				<?php if(isset($eDayKeyword) && (int)$eDayKeyword == $beginday){ ?>
				<option value="<?php echo $beginday; ?>" selected="selected"><?php echo $beginday; ?></option>
				<?php }else{ ?>
				<option value="<?php echo $beginday; ?>"><?php echo $beginday; ?></option>
				<?php } ?>
				<?php } ?>
			</select>
			<b>-</b>
			<select name="beginmonth_search2" id="beginmonth_search2" class="selectdate_search form-control">
				<option value="0"><?php echo $this->lang->line('month_search_detail_global'); ?></option>
				<?php for($beginmonth = 1; $beginmonth <= 12; $beginmonth++){ ?>
				<?php if(isset($eMonthKeyword) && (int)$eMonthKeyword == $beginmonth){ ?>
				<option value="<?php echo $beginmonth; ?>" selected="selected"><?php echo $beginmonth; ?></option>
				<?php }else{ ?>
				<option value="<?php echo $beginmonth; ?>"><?php echo $beginmonth; ?></option>
				<?php } ?>
				<?php } ?>
			</select>
			<b>-</b>
			<select name="beginyear_search2" id="beginyear_search2" class="selectdate_search form-control">
				<option value="0"><?php echo $this->lang->line('year_search_detail_global'); ?></option>
				<?php for($beginyear = (int)date('Y')-1; $beginyear <= (int)date('Y'); $beginyear++){ ?>
				<?php if(isset($eYearKeyword) && (int)$eYearKeyword == $beginyear){ ?>
				<option value="<?php echo $beginyear; ?>" selected="selected"><?php echo $beginyear; ?></option>
				<?php }else{ ?>
				<option value="<?php echo $beginyear; ?>"><?php echo $beginyear; ?></option>
				<?php } ?>
				<?php } ?>
			</select>
			<img src="<?php echo $URLRoot; ?>templates/home/images/help_post.gif" onmouseout="hideddrivetip();" class="img_helppost" />
		</div>
		<div class="form-group">
				<label></label>
				<input type="button" onclick="CheckInput_SearchPro('<?php echo $URLRoot; ?>search/')" name="submit_searchpro" value="<?php echo $this->lang->line('button_search_search_detail_global'); ?>" class="button_search  btn btn-primary" />
				<input type="reset" name="reset_searchpro" value="<?php echo $this->lang->line('button_reset_search_detail_global'); ?>" class="button_search btn btn-danger" />
		</div>
	</div>
	</form>
<?php } ?>