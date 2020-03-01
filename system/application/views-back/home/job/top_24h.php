<?php if(count($top24hJob) > 0){ ?>
<tr><td style="height:10px"></td></tr>
<tr class="temp_2">
    <td style="width:300px;" class="tieude_trai ">
    <div class="title">
    <div class="fl"></div>
    <div class="fc">
	<?php echo $this->lang->line('title_top_24h_job_right'); ?> 
    </div>
    <div class="fr"></div>
    </div>  
    </td>
</tr>
<tr class="temp_2 k_temp_2">
    <td class="content" align="left" >
        <table  border="0" width="90%" cellpadding="0" cellspacing="0">
        	<tr><td>
            <?php $isDivJob = 1; ?>
            <?php foreach($top24hJob as $top24hJobArray){ ?>
            <div style="width:300px"  id="DivTop24hJob_<?php echo $isDivJob; ?>">
                <div style="float:left; width:20px;padding-top:8px;padding-left:10px;"  ><img src="<?php echo base_url(); ?>templates/home/images/icon02.png" border="0"  alt=""/></div>
                <div style="float:left;width:250px;" class="list_1">
                    <a class="menu" href="<?php echo base_url(); ?>tuyendung/<?php echo $top24hJobArray->job_field; ?>/<?php echo $top24hJobArray->job_id; ?>/<?php echo RemoveSign($top24hJobArray->job_title); ?>"><?php echo $top24hJobArray->job_title; ?></a>
                </div>
            </div>
                <div style="clear:both"></div>            
            <?php $isDivJob++; ?>
            <?php } ?>
            </td></tr>
            
            <tr>
        		<td class="k_view_all" valign="top"  colspan="2"><a class="menu_2" onclick="OpenTabTopJob(<?php echo settingJob24Gio_J_Top; ?>, 1, 'job')" href="#24h">1</a>&nbsp;&nbsp;<a class="menu_2" onclick="OpenTabTopJob(<?php echo settingJob24Gio_J_Top; ?>, 2, 'job')" href="#48h">2</a>&nbsp;&nbsp;<a class="menu_2" onclick="OpenTabTopJob(<?php echo settingJob24Gio_J_Top; ?>, 3, 'job')" href="#72h">3&nbsp;...</a></td>
        	</tr>            
        	<script type="text/javascript"> OpenTabTopJob(<?php echo settingJob24Gio_J_Top; ?>, 1, 'job');</script>
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