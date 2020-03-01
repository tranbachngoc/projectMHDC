<?php 

	$query = $this->db->query("SELECT * FROM  tbtt_package_info WHERE published = 1");
	foreach ($query->result() as $row)
{ ?>
		<option value="<?php echo $row->id; ?>" >
			<?php echo $row->name; ?>			
		</option>

<?php } ?>
