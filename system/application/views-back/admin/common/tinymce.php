<script type="text/javascript" src='<?php echo base_url()?>templates/editor/tinymce/tinymce.min.js'></script>
<script type="text/javascript"> 
    tinymce.init({
	selector: '.editor',  
	height: 500,
	theme: 'modern',
	skins: 'lightgray',
	plugins: 'advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking save table contextmenu directionality emoticons template paste textcolor responsivefilemanager',
	toolbar1: 'formatselect | bold italic strikethrough forecolor backcolor | link image media | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | removeformat code',
	image_advtab: true,
	menubar: 'edit insert view format table tools help',
	external_filemanager_path:"<?php echo base_url()?>uploads/filemanager/",
	filemanager_title:"Responsive Filemanager" ,
	external_plugins: { "filemanager" : "<?php echo base_url()?>uploads/filemanager/plugin.min.js"}
    });
</script>




