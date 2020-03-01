<?php print_r('aaaaaa'); die();?>
	
	var content=<?php echo $_SESSION['kach']?>;
	
	var widthScreen=jQuery(window).width();
	if(widthScreen<=1024){
		var width1024=480;
		
	}
	else
	{
		var width1024=560;
	}
		
	var mygallery2=new simpleGallery({	
	wrapperid: "simplegallery2", //ID of main gallery container,	
	dimensions: [width1024, 230], //width/height of gallery in pixels. Should reflect dimensions of the images exactly	
	imagearray: [<?php echo $_SESSION['kach']?>],
	autoplay: [true, 1, 1000], //[auto_play_boolean, delay_btw_slide_millisec, cycles_before_stopping_int]
	persist: true,
	fadeduration: 3000, //transition duration (milliseconds)
	oninit:function(){ //event that fires when gallery has initialized/ ready to run
	},
	onslide:function(curslide, i){ //event that fires after each slide is shown
		//curslide: returns DOM reference to current slide's DIV (ie: try alert(curslide.innerHTML)
		//i: integer reflecting current image within collection being shown (0=1st image, 1=2nd etc)
	}




