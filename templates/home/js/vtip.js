/**
Vertigo Tip by www.vertigo-project.com
Requires jQuery
*/

this.vtip = function() {    
    this.xOffset = -10; // x distance from mouse
    this.yOffset = 10; // y distance from mouse       
    
    jQuery(".vtip").unbind().hover(    
        function(e) {
            this.t = this.title;
            this.title = ''; 
            this.top = (e.pageY + yOffset); this.left = (e.pageX + xOffset);
            jQuery('#hidden-vtip').css('display','block');
            jQuery('#hidden-vtip').append( '<p id="vtip"><img id="vtipArrow" />' + this.t + '</p>' );
                        
            jQuery('p#vtip #vtipArrow').attr("src", 'images/vtip_arrow.png');
            jQuery('p#vtip').css("top", this.top+"px").css("left", this.left+"px").fadeIn("fast");
            
        },
        function() {
            this.title = this.t;
            jQuery("p#vtip").fadeOut("fast").remove();
        }
    ).mousemove(
        function(e) {
            this.top = (e.pageY + yOffset);
            this.left = (e.pageX + xOffset);
            
            jQuery("p#vtip").css("top", this.top+"px").css("left", this.left+"px");
        }
    );            
    
};



jQuery(document).ready(function($){
	vtip();
	jQuery(".vtip").click(function() {
	 	jQuery('#hidden-vtip').css('display','none');
	});
		
	});