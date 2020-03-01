<script src="<?php echo base_url() ?>templates/editor/ckeditor/ckeditor.js" type="text/javascript"></script>
<script type="text/javascript">
    jQuery(function($){
        CKEDITOR.replace('txtContent', {
            height: 500,
            filebrowserBrowseUrl : '<?php echo base_url()?>templates/editor/ckfinder/ckfinder.html',
            filebrowserImageBrowseUrl : '<?php echo base_url()?>templates/editor/ckfinder/ckfinder.html?Type=Images',
            filebrowserFlashBrowseUrl : '<?php echo base_url()?>templates/editor/ckfinder/ckfinder.html?Type=Flash',
            filebrowserUploadUrl : '<?php echo base_url()?>templates/editor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
            filebrowserImageUploadUrl : '<?php echo base_url()?>templates/editor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
            filebrowserFlashUploadUrl : '<?php echo base_url()?>templates/editor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
        });
    });
</script>