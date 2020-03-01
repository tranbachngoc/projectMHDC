<?php 
	$query = $this->db->query("SELECT * FROM tbtt_group");
	foreach ($query->result() as $row)
	{        
?>
	<option value="<?php echo $row->gro_id; ?>" >
		<?php  echo $row->gro_name; ?>		
	</option>
<?php 
	}
?>