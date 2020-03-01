<script type="text/javascript" src='<?php echo base_url()?>templates/editor/tinymce/tinymce.min.js'></script>
<script type="text/javascript"> 
    tinymce.init({
	selector: '.editor',  
	height: 500,
	theme: 'modern',
	skins: 'lightgray',
	plugins: 'advlist autolink link image imagetools lists charmap print preview hr anchor pagebreak spellchecker searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking save table contextmenu directionality emoticons template paste textcolor',
	toolbar1: 'formatselect | bold italic strikethrough forecolor backcolor | link image media | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent | removeformat code',
	image_advtab: true,
	menubar: 'edit insert view format table tools help',
	content_css:['<?php echo base_url()?>templates/editor/tinymce/themes/modern/editor.css'],
	templates: [
		{title: 'Some title 1', description: 'Some desc 1', url: '<?php echo base_url()?>templates/editor/tinymce/templates/development1.html'},
		{title: 'Some title 1', description: 'Some desc 1', url: '<?php echo base_url()?>templates/editor/tinymce/templates/development2.html'},
		{title: 'Some title 2', description: 'Some desc 2', url: '<?php echo base_url()?>templates/editor/tinymce/templates/development3.html'}
	]
});
</script>
