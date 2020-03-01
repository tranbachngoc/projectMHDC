<?php if(count($top24hEmploy) > 0){ ?>
<tr><td style="height:10px"></td></tr>
<tr class="temp_2">    
    <td style="width:300px;" class="tieude_trai ">
    <div class="title">
    <div class="fl"></div>
    <div class="fc">
	<?php echo $this->lang->line('title_top_24h_employ_right'); ?> 
    </div>
    <div class="fr"></div>
    </div>  
    </td>
</tr>
<tr class="temp_2 k_temp_2">
    <td class="content" align="left" >
        <table border="0" width="90%" cellpadding="0" cellspacing="0">
        <tr><td>
            <?php $isDivEmploy = 1; ?>
            <?php foreach($top24hEmploy as $top24hEmployArray){ ?>
            <div style="width:300px" id="DivTop24hEmploy_<?php echo $isDivEmploy; ?>">
                <div style="float:left; width:20px;padding-top:8px;padding-left:10px;"><img src="<?php echo base_url(); ?>templates/home/images/icon02.png" border="0" alt=""/></div>
                <div style="float:left;width:250px;" class="list_1">
                    <a class="menu_1" href="<?php echo base_url(); ?>timviec/<?php echo $top24hEmployArray->emp_field; ?>/<?php echo $top24hEmployArray->emp_id; ?>/<?php echo RemoveSign($top24hEmployArray->emp_title); ?>" ><?php echo $top24hEmployArray->emp_title; ?></a>
                </div>
            </div>
                <div style="clear:both"></div> 
            <?php $isDivEmploy++; ?>
            <?php } ?>
            </td></tr>
            <tr>
        		<td class="k_view_all" valign="top"  colspan="2"><a class="menu_2" onclick="OpenTabTopJob(<?php echo settingJob24Gio_E_Top; ?>, 1, 'employ')" href="#24h">1</a>&nbsp;&nbsp;<a class="menu_2" onclick="OpenTabTopJob(<?php echo settingJob24Gio_E_Top; ?>, 2, 'employ')" href="#48h">2</a>&nbsp;&nbsp;<a class="menu_2" onclick="OpenTabTopJob(<?php echo settingJob24Gio_E_Top; ?>, 3, 'employ')" href="#72h">3&nbsp;...</a></td>
        	</tr>
            
        	<script type="text/javascript"> OpenTabTopJob(<?php echo settingJob24Gio_E_Top; ?>, 1, 'employ');</script>
        </table>
    </td>
</tr>
<tr class="temp_2">
    <td >
        <div class="bottom">
            <div class="fl"></div>
            <div class="fr"></div>            
        </div>
    </td>
</tr>
<?php } ?>