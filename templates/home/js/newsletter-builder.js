jQuery(function() { 
// Resize	
function resize(){
	jQuery('.resize-height').height(window.innerHeight - 50);
	jQuery('.resize-width').width(window.innerWidth - 250);
	//if(window.innerWidth<=1150){jQuery('.resize-width').css('overflow','auto');}
	
	}
jQuery( window ).resize(function() {resize();});
resize();

	
	
 
//Add Sections
jQuery("#newsletter-builder-area-center-frame-buttons-add").hover(
  function() {
    jQuery("#newsletter-builder-area-center-frame-buttons-dropdown").fadeIn(200);
  }, function() {
    jQuery("#newsletter-builder-area-center-frame-buttons-dropdown").fadeOut(200);
  }
);

jQuery("#newsletter-builder-area-center-frame-buttons-dropdown").hover(
  function() {
    jQuery(".newsletter-builder-area-center-frame-buttons-content").fadeIn(200);
  }, function() {
    jQuery(".newsletter-builder-area-center-frame-buttons-content").fadeOut(200);
  }
);


jQuery("#add-header").hover(function() {
    jQuery(".newsletter-builder-area-center-frame-buttons-content-tab[data-type='header']").show()
	jQuery(".newsletter-builder-area-center-frame-buttons-content-tab[data-type='content']").hide()
	jQuery(".newsletter-builder-area-center-frame-buttons-content-tab[data-type='footer']").hide()
  });
  
jQuery("#add-content").hover(function() {
    jQuery(".newsletter-builder-area-center-frame-buttons-content-tab[data-type='header']").hide()
	jQuery(".newsletter-builder-area-center-frame-buttons-content-tab[data-type='content']").show()
	jQuery(".newsletter-builder-area-center-frame-buttons-content-tab[data-type='footer']").hide()
  });
  
jQuery("#add-footer").hover(function() {
    jQuery(".newsletter-builder-area-center-frame-buttons-content-tab[data-type='header']").hide()
	jQuery(".newsletter-builder-area-center-frame-buttons-content-tab[data-type='content']").hide()
	jQuery(".newsletter-builder-area-center-frame-buttons-content-tab[data-type='footer']").show()
  });   
  
  
  
 jQuery(".newsletter-builder-area-center-frame-buttons-content-tab").hover(
  function() {
    jQuery(this).append('<div class="newsletter-builder-area-center-frame-buttons-content-tab-add"><i class="fa fa-plus"></i>&nbsp;Insert</div>');
	jQuery('.newsletter-builder-area-center-frame-buttons-content-tab-add').click(function() {

	jQuery("#newsletter-builder-area-center-frame-content").prepend(jQuery("#newsletter-preloaded-rows .sim-row[data-id='"+jQuery(this).parent().attr("data-id")+"']").clone());
	hover_edit();
	perform_delete();
	jQuery("#newsletter-builder-area-center-frame-buttons-dropdown").fadeOut(200);
		})
  }, function() {
    jQuery(this).children(".newsletter-builder-area-center-frame-buttons-content-tab-add").remove();
  }
); 
  
  
//Edit
function hover_edit(){


jQuery(".sim-row-edit").hover(
  function() {
    jQuery(this).append('<div class="sim-row-edit-hover"><i class="fa fa-pencil" style="line-height:30px;"></i></div>');
	jQuery(".sim-row-edit-hover").click(function(e) {e.preventDefault()})
	jQuery(".sim-row-edit-hover i").click(function(e) {
	e.preventDefault();
	big_parent = jQuery(this).parent().parent();
	
	//edit image
	if(big_parent.attr("data-type")=='image'){
	
	
	jQuery("#sim-edit-image .image").val(big_parent.children('img').attr("src"));
	jQuery("#sim-edit-image").fadeIn(500);
	jQuery("#sim-edit-image .sim-edit-box").slideDown(500);
	
	jQuery("#sim-edit-image .sim-edit-box-buttons-save").click(function() {
	  jQuery(this).parent().parent().parent().fadeOut(500)
	  jQuery(this).parent().parent().slideUp(500)
	  
	  big_parent.children('img').attr("src",jQuery("#sim-edit-image .image").val());

	   });

	}
	
	//edit link
	if(big_parent.attr("data-type")=='link'){
	
	jQuery("#sim-edit-link .title").val(big_parent.text());
	jQuery("#sim-edit-link .url").val(big_parent.attr("href"));
	jQuery("#sim-edit-link").fadeIn(500);
	jQuery("#sim-edit-link .sim-edit-box").slideDown(500);
	
	jQuery("#sim-edit-link .sim-edit-box-buttons-save").click(function() {
	  jQuery(this).parent().parent().parent().fadeOut(500)
	  jQuery(this).parent().parent().slideUp(500)
	   
	    big_parent.text(jQuery("#sim-edit-link .title").val());
		big_parent.attr("href",jQuery("#sim-edit-link .url").val());

		});

	}
	
	//edit title
	
	if(big_parent.attr("data-type")=='title'){
	
	jQuery("#sim-edit-title .title").val(big_parent.text());
	jQuery("#sim-edit-title").fadeIn(500);
	jQuery("#sim-edit-title .sim-edit-box").slideDown(500);
	
	jQuery("#sim-edit-title .sim-edit-box-buttons-save").click(function() {
	  jQuery(this).parent().parent().parent().fadeOut(500)
	  jQuery(this).parent().parent().slideUp(500)
	   
	    big_parent.text(jQuery("#sim-edit-title .title").val());

		});

	}
	
	//edit text
	if(big_parent.attr("data-type")=='text'){
	
	jQuery("#sim-edit-text .text").val(big_parent.text());
	jQuery("#sim-edit-text").fadeIn(500);
	jQuery("#sim-edit-text .sim-edit-box").slideDown(500);
	
	jQuery("#sim-edit-text .sim-edit-box-buttons-save").click(function() {
	  jQuery(this).parent().parent().parent().fadeOut(500)
	  jQuery(this).parent().parent().slideUp(500)
	   
	    big_parent.text(jQuery("#sim-edit-text .text").val());
		
		
	   
		});

	}
	
	//edit icon
	if(big_parent.attr("data-type")=='icon'){
	
	
	jQuery("#sim-edit-icon").fadeIn(500);
	jQuery("#sim-edit-icon .sim-edit-box").slideDown(500);
	
	jQuery("#sim-edit-icon i").click(function() {
	  jQuery(this).parent().parent().parent().parent().fadeOut(500)
	  jQuery(this).parent().parent().parent().slideUp(500)
	   
	    big_parent.children('i').attr('class',jQuery(this).attr('class'));

		});

	}//
	
	});
  }, function() {
    jQuery(this).children(".sim-row-edit-hover").remove();
  }
);
}
hover_edit();


//close edit
jQuery(".sim-edit-box-buttons-cancel").click(function() {
  jQuery(this).parent().parent().parent().fadeOut(500)
   jQuery(this).parent().parent().slideUp(500)
});
   


//Drag & Drop
jQuery("#newsletter-builder-area-center-frame-content").sortable({
  revert: true
});
	

jQuery(".sim-row").draggable({
      connectToSortable: "#newsletter-builder-area-center-frame-content",
      //helper: "clone",
      revert: "invalid",
	  handle: ".sim-row-move"
});



//Delete
function add_delete(){
	jQuery(".sim-row").append('<div class="sim-row-delete"><i class="fa fa-times" ></i></div>');
	
	}
add_delete();


function perform_delete(){
jQuery(".sim-row-delete").click(function() {
  jQuery(this).parent().remove();
});
}
perform_delete();




//Download
 jQuery("#newsletter-builder-sidebar-buttons-abutton").click(function(){
	 
	jQuery("#newsletter-preloaded-export").html(jQuery("#newsletter-builder-area-center-frame-content").html());
	jQuery("#newsletter-preloaded-export .sim-row-delete").remove();
	jQuery("#newsletter-preloaded-export .sim-row").removeClass("ui-draggable");
	jQuery("#newsletter-preloaded-export .sim-row-edit").removeAttr("data-type");
	jQuery("#newsletter-preloaded-export .sim-row-edit").removeClass("sim-row-edit");
	
	export_content = jQuery("#newsletter-preloaded-export").html();
	
	jQuery("#export-textarea").val(export_content)
	jQuery( "#export-form" ).submit();
	jQuery("#export-textarea").val(' ');
	 
});
	 
	 
//Export 
jQuery("#newsletter-builder-sidebar-buttons-bbutton").click(function(){
	
	jQuery("#sim-edit-export").fadeIn(500);
	jQuery("#sim-edit-export .sim-edit-box").slideDown(500);
	
	jQuery("#newsletter-preloaded-export").html(jQuery("#newsletter-builder-area-center-frame-content").html());
	jQuery("#newsletter-preloaded-export .sim-row-delete").remove();
	jQuery("#newsletter-preloaded-export .sim-row").removeClass("ui-draggable");
	jQuery("#newsletter-preloaded-export .sim-row-edit").removeAttr("data-type");
	jQuery("#newsletter-preloaded-export .sim-row-edit").removeClass("sim-row-edit");
	
	preload_export_html = jQuery("#newsletter-preloaded-export").html();
	jQuery.ajax({
	  url: "_css/newsletter.css"
	}).done(function(data) {

	
export_content = '<style>'+data+'</style><link href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:200,300,400,600,700,900,200italic,300italic,400italic,600italic,700italic,900italic" rel="stylesheet" type="text/css"><link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css"><div id="sim-wrapper"><div id="sim-wrapper-newsletter">'+preload_export_html+'</div></div>';
	
	jQuery("#sim-edit-export .text").val(export_content);
	
	
	});
	
	
	
	jQuery("#newsletter-preloaded-export").html(' ');
	
	});




});