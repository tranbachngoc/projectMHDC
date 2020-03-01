function tabview_aux(TabViewId, id)
{	
	var TabView = document.getElementById(TabViewId);
	
	// ----- Tabs -----
	
	var Tabs = jQuery(TabViewId+" div:first-child");
	Tabs.find("A").each(function(index) {
		alert(index);
		jQuery(this).attr("href", "javascript:tabview_switch('"+TabViewId+"', "+index+");");
		jQuery(this).attr("class",(index == id) ? "Active" : "");
		jQuery(this).blur();
	});
	
	var Pages = jQuery(TabViewId+":first-child");
	Pages.each(function(index) {
		
		if(jQuery(this).attr("class")=='Page'){
			jQuery(this).css("overflow", "auto");
			jQuery(this).css("display",(index == id) ? 'block' : 'none');

		}
	});


	
	
}

// ----- Functions -------------------------------------------------------------

function tabview_switch(TabViewId, id) { tabview_aux(TabViewId, id); }

function tabview_initialize(TabViewId) { tabview_aux(TabViewId,  1); }