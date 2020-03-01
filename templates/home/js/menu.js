jQuery(document).ready(function() {
	jQuery(".login_link").hover(
	  function () {
		jQuery('.hidden-login').css('display','block');
	  },
	  function () {
		jQuery('.hidden-login').css('display','none');
	  }
	);
	
	jQuery(".hidden-login").hover(
	  function () {
		jQuery('.hidden-login').css('display','block');
	  },
	  function () {
		jQuery('.hidden-login').css('display','none');
	  }
	);
	

	jQuery(".register").hover(
	  function () {
		jQuery('.hidden-signin').css('display','block');
	  },
	  function () {
		jQuery('.hidden-signin').css('display','none');
	  }
	);
	
	jQuery(".hidden-signin").hover(
	  function () {
		jQuery('.hidden-signin').css('display','block');
	  },
	  function () {
		jQuery('.hidden-signin').css('display','none');
	  }
	);
	
	
	//dang tin 
	jQuery(".post_link").hover(
	  function () {
		jQuery('.simple_tip_content').css('display','block');
	  },
	  function () {
		jQuery('.simple_tip_content').css('display','none');
	  }
	);
	
	//dang tin 
	jQuery(".simple_tip_content").hover(
	  function () {
		jQuery('.simple_tip_content').css('display','block');
	  },
	  function () {
		jQuery('.simple_tip_content').css('display','none');
	  }
	);
	
	//phone
	jQuery(".support_online").hover(
	  function () {
		jQuery('.hidden-support').css('display','block');
	  },
	  function () {
		jQuery('.hidden-support').css('display','none');
	  }
	);
	
	jQuery(".hidden-support").hover(
	  function () {
		jQuery('.hidden-support').css('display','block');
	  },
	  function () {
		jQuery('.hidden-support').css('display','none');
	  }
	);
	
	
	
});

