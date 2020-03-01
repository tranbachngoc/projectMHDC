<?php $this->load->view('home/common/header'); ?>
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

	    function copylink(id_link) {
		var copyInput = document.querySelector('.js-input_' + id_link);
		copyInput.select();
		try {
		    var successful = document.execCommand('copy');
		    var msg = successful ? 'successful' : 'unsuccessful';
		    console.log('Copying text command was ' + msg);
		} catch (err) {
		    console.log('Oops, unable to copy');
		}
	    }
	</script>
	<script>
	    function myFunction() {
		var input, filter, tbody, tr, td, span, i;
		input = document.getElementById("keySearch");
		filter = input.value.toUpperCase();
		tbody = document.getElementById("listSearch");
		tr = tbody.getElementsByTagName("tr");
		for (i = 0; i < tr.length; i++) {
		    span = tr[i].getElementsByTagName("span")[0];
		    if (span.innerHTML.toUpperCase().indexOf(filter) > -1) {
			tr[i].style.display = "";
		    } else {
			tr[i].style.display = "none";

		    }
		}
	    }
	</script>
	<!--BEGIN: RIGHT-->

	<div class="col-md-9 col-sm-8 col-xs-12">
	    <h4 class="page-header text-uppercase" style="margin-top:10px">
		Danh sách link landing page cần chia sẻ 
	    </h4>
	    <?php if (count($list) > 0) { ?>
	    <div class="row">
		<div class="col-sm-4 form-group">
		    <div class="input-group">
			<input id="keySearch" type="text" class="form-control" placeholder="Tìm kiếm theo tên" aria-describedby="basic-addon1" onkeyup="myFunction();">
			<span class="input-group-addon" id="basic-addon1"><i class="fa fa-search"></i></span>
		    </div>
		</div>		
	    </div>
	    <div class="table-responsive">
		<table  class="table table-bordered"  width="100%" border="0" cellpadding="0" cellspacing="0">
    		<thead>    		    
    		    <tr class="v_height29">
    			<th width="40">STT</th>
    			<th width="200">Tên</th>
    			<th>
    			    Link cần chia sẻ
    			</th>
    			<th width="80" class="text-center">
    			    Xem 
    			</th>
    			<th width="80"class="text-center">
    			    Copy
    			</th>
    			<th width="110">
    			    Ngày tạo
    			</th>
    		    </tr>
    		</thead>
    		<tbody id="listSearch">
		    <?php
		    $idDiv = 0;
		    foreach ($list as $item) {
			$idDiv ++;
			?>
			<tr>
			    <td><?php echo $idDiv; ?></td>
			    <td><span><?php echo $item->name; ?></span></td>
			    <td>
				<input readonly class="form-control js-input_<?php echo $item->id; ?>" type="text" value="<?php echo base_url(); ?>landing_page/id/<?php echo $item->id . '/' . $item->name; ?>?share=<?php echo $parent->af_key; ?>" />
			    </td>
			    <td class="text-center">	
				<a href="<?php echo base_url(); ?>landing_page/id/<?php echo $item->id . '/' . RemoveSign($item->name); ?>?share=<?php echo $parent->af_key; ?>" target="_blank"><button class="btn btn-default"><i class="fa fa-eye"></i></button></a>  
			    </td>
			    <td class="text-center">
				<button name="copylink" onclick="copylink('<?php echo $item->id; ?>')" class="btn btn-primary" type="button"><i class="fa fa-clone"></i></button>
			    </td>
			    <td>
				<?php echo date('d-m-Y', strtotime($item->created_date)); ?>
			    </td>
			</tr>
		    <?php } ?>
		    
    		</tbody>
    	    </table>
	    </div>
		    <?php if (count($linkPage) > 0) { ?>
			<?php echo $linkPage; ?>
		    <?php } ?>
	    <?php } else { ?>
    	    <div class="none_record">
    		<p class="text-center">Chưa có dữ liệu cho mục này</p>
	    </div>
	    <?php } ?>
	    <br/>
	</div>
    </div>
</div>
<!--END RIGHT-->
<?php $this->load->view('home/common/footer'); ?>