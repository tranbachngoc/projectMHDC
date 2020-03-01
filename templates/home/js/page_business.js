$('.load-wrapp').css('z-index','9999');

$('.control-board-icon').on('click', function() {
	$(this).toggleClass('active');
	if ($(this).hasClass('active')) 
	{
	  $('.control-board-item').addClass('is-open');
	} 
	else 
	{
	  $('.control-board-item').removeClass('is-open');
	}
});