<?php for($year = 2000; $year <= 2050; $year++){ ?>
<?php if($year == (int)date('Y')){ ?>
<option value="<?php echo $year; ?>" selected="selected"><?php echo $year; ?></option>
<?php }else{ ?>
<option value="<?php echo $year; ?>"><?php echo $year; ?></option>
<?php } ?>
<?php } ?>