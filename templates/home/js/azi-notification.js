$('#main-notification .datepicker').datepicker({
	format: 'yyyy/mm/dd',
	// minDate: new Date()
});

$('#main-notification .datetimepicker').datetimepicker({
	format: 'YYYY/MM/DD HH:mm:00',
	// format: 'DD/MM/YYYY hh:mm A',
	// minDate: new Date()
});

$('#main-notification [data-toggle="tooltip"]').tooltip();


// click popop setting notification push
$('#main-notification .js-push-notification').click(function () {
	var push_url = $(this).attr('data-url');
	var push_old = $('#js-action-send').val();
	if (push_url != push_old) 
	{
		$('#settingInformation .js-list-date-notice').empty();
		$('#js-send-one-notification input').val('');
	}
	$('#js-action-send').val(push_url);
	$('#settingInformation').modal('show'); 
});

// push now notification
$('#main-notification .js-send-one').click( function() {
	var content = $('#js-send-one-notification textarea').val();
	if ($.trim(content).length > 0) 
	{
		$('.load-wrapp').modal('show');
		$('.load-wrapp').removeAttr('style');
		var url_send = $('#js-action-send').val();
		var formData = new FormData($('#js-send-one-notification')[0]);
        $.ajax({
            url: url_send,
            type: 'post',
            data: formData,
            dataType: "json",
            contentType: false,
            processData: false,
            success: function (response) {
                if (response != '') 
                {	
                	if (response.data.status == 1) 
                	{
                		alert('Thêm thông báo thành công.');
                		location.reload();
                	}
                }
                else 
                {
                	alert('Thêm thông báo thất bại.');
                }
            }
        }).always(function() {
            $('.load-wrapp').modal('hide');
        });
	}
	else
	{
		alert('Bạn phải nhật đầy đủ thông tin!');
	}
});


// add item push notification push with date
$('#main-notification .js-add-date-notice, #main-notification .js-add-date-notice-azi').click( function() {
	var key_template = $('#main-notification .js-list-date-notice .add-date-notice-detail').length;
	var template_push = $('#js-template-push-noti').html();
	template_push = template_push.replace(/{{KEY}}/g, key_template);
	$('#main-notification .js-list-date-notice').append(template_push);
	$('#main-notification .js-list-date-notice').find('.datetimepicker').datetimepicker({format: 'YYYY-MM-DD HH:mm:00'});
});

// remove item notification push with date
$('#main-notification').on('click', '.js-delete-notice, .js-delete-notice-azi', function() {
	$(this).parents('.add-date-notice-detail').remove();
	var list_notice = $('#main-notification .add-date-notice-detail');
	if (list_notice.length > 0) {
		$.each(list_notice, function( index, value ) {
		  	$(this).find('.js-content').attr('name', 'schedules['+index+'][pushed_at]');
		  	$(this).find('.js-date').attr('name', 'schedules['+index+'][content]');
		});
	}
});

//  push muptiple notification with date
$('#main-notification .js-send-mutip').click(function() {
	var list_notice = $('#main-notification .add-date-notice-detail');
	$('#main-notification .add-date-notice-detail .js-content').removeClass('is-invalid');
	$('#main-notification .add-date-notice-detail .js-date').removeClass('is-invalid');
	if (list_notice.length > 0) {
		var push_error = false;
		$.each(list_notice, function( index, value ) {
		  	var push_content = $(this).find('.js-content').val();
		  	var push_date = $(this).find('.js-date').val();
		  	if ($.trim(push_content) == '') 
		  	{
		  		$(this).find('.js-content').addClass('is-invalid');
		  		push_error = true;
		  	}

		  	var parsedDate = Date.parse(push_date);
		  	if (isNaN(parsedDate)) 
		  	{
			    $(this).find('.js-date').addClass('is-invalid');
			    push_error = true;
			}
		});

		if (push_error == false) 
		{
			$('.load-wrapp').modal('show');
			$('.load-wrapp').removeAttr('style');
			var url_send = $('#js-action-send').val();
			var formData = new FormData($('#js-send-mutip-notification')[0]);
	        $.ajax({
	            url: url_send,
	            type: 'post',
	            data: formData,
	            dataType: "json",
	            contentType: false,
	            processData: false,
	            success: function (response) {
	                if (response != '') 
	                {	
	                	if (response.data.status == 1) 
	                	{
	                		alert('Thêm thông báo thành công.');
	                		location.reload();
	                	}
	                }
	                else 
	                {
	                	alert('Thêm thông báo thất bại.');
	                }
	            }
	        }).always(function() {
	            $('.load-wrapp').modal('hide');
	        });
			
		}

	}
	else
	{
		alert('Bạn chưa thêm ngày thông báo.');
	}
});


// get list push notification one news
$('#main-notification .js-notification-info').click(function() {
	$('.load-wrapp').modal('show');
	$('.load-wrapp').removeAttr('style');
	var url_send = $(this).attr('data-url');
	var url_delete = $(this).attr('data-delete');
    $.ajax({
        url: url_send,
        type: 'get',
        dataType: "json",
        contentType: false,
        processData: false,
        success: function (response) {
            if (typeof response.status !== "undefined" && response.status == 1) 
            {
            	$('#displayInformation .displayInformation-show').empty();

            	if (typeof response.data !== "undefined" && response.data.length > 0) 
            	{
            		var str = '';
            		$(response.data).each(function( index ) {
					   	var d = new Date(this.pushed_at);
					   	var getHours = d.getHours();
					   	var getMinutes = d.getMinutes();
					   	var getDate = d.getDate();
						var getMonth = d.getMonth()+1; //January is 0!
						var getFullYear = d.getFullYear();
						if(getDate < 10)
						{
						    getDate = '0'+ getDate;
						}
						if(getMonth < 10)
						{
						    getMonth = '0' + getMonth;
						}
						var date = getDate+'/'+getMonth+'/'+getFullYear;
						str += '<li>';
						// date
						if (this.finished == 1) 
						{
							 str += 'Đã báo ngày: ' + getHours + ':' + getMinutes + ' ngày ' + date;
						}
						else
						{
							 str += 'Chờ báo ngày: ' + getHours + ':' + getMinutes + ' ngày ' + date;
							 str += '<a class="btn-delete js-delete-notification" data-url="' + url_delete + this.id + '"><img src="/templates/home/styles/images/svg/admin_close.svg" width="15" alt="">Xóa</a>';
						}
						str += '</br>';
						// content
						str += 'Nội dung: “' + this.content + '”';
						str += '</li>';
					});
            	} 
            	else 
            	{
            		var str = 'Hiện không có thông báo nào.';
            	}
            	$('#displayInformation .displayInformation-show').append(str);
            	$('#displayInformation').modal('show');
            } 
            else 
            {
            	alert('Kết nối thất bại!');
            }

        }
    }).always(function() {
        $('.load-wrapp').modal('hide');
    });
});

// delete push notification
$('#main-notification').on('click', '.js-delete-notification', function() {
	$('.load-wrapp').modal('show');
	$('.load-wrapp').removeAttr('style');
	var _this = $(this);
	var url_send = $(this).attr('data-url');
    $.ajax({
        url: url_send,
        type: 'get',
        dataType: "json",
        contentType: false,
        processData: false,
        success: function (response) {
            if (typeof response.status !== "undefined" && response.status == 1) 
            {
            	$(_this).parents('li').remove();
            	alert('Xóa thông báo thành công!');
            } 
            else 
            {
            	alert('Kết nối thất bại!');
            }
        }
    }).always(function() {
        $('.load-wrapp').modal('hide');
    });
});

$("#cate_link").change(function () {
    if ($("#cate_link").val() != '') {
        $.ajax({
            url: siteUrl + 'azi-admin/notifications/get_catchild_link',
            type: "POST",
            data: {cat_id: $("#cate_link").val()},
            cache: true,
            success: function (response) {
            	var option_childcat = '';
                if (response) {
                    var json = JSON.parse(response);

	            	if(json.length > 0){
	            		$('.js-cate-child-link').removeClass('hidden');
	                    $(json).each(function(at, item){
	                    	option_childcat += '<option value="'+item.id+'">'+item.name+'</option>';
	                    });
	                    $('#cate_child_link').html(option_childcat);
	                    delete json;
	                }else{
	                	$('#cate_child_link').html('');
	            		$('.js-cate-child-link').addClass('hidden');
	                }
                } else {
                    alert("Lỗi! Vui lòng thử lại");
                }
            },
            error: function () {
                alert("Lỗi! Vui lòng thử lại");
            }
        });
    }else{
    	$('#cate_child_link').html('');
    	$('.js-cate-child-link').addClass('hidden');
    }
});

// noti azi
$('.js-notification-confirm').on('click', function(){
	$('#modal_mess').modal('show');
	$('#modal_mess .modal-body p').text('Bạn có chắc muốn xóa');
	$('#modal_mess .modal-footer .btn-ok').text('Xác nhận');
	$('#modal_mess .modal-footer .btn-ok').addClass('js-delete-notification');
	$('#modal_mess .modal-footer .btn-ok').attr('data-url', $(this).attr('data-delete')+'delete/'+$(this).attr('data-id'));
	$('#modal_mess .modal-footer .btn-ok').removeClass('hidden');
});

$('body').on('click', '.btn-ok.js-delete-notification', function(){
	$('#modal_mess').modal('hide');
});

$('#modal_mess').on('hide.bs.modal', function(){
	$('#modal_mess .modal-footer .btn-ok').text('');
	$('#modal_mess .modal-footer .btn-ok').addClass('hidden');
	$('#modal_mess .modal-footer .btn-ok').removeClass('js-delete-notification');
	$('#modal_mess .modal-footer .btn-ok').removeAttr('data-url');
});

$('#main-notification .js-add-date-notice-azi').click( function() {
	$('#main-notification .add-date-action-azi').removeClass('hidden');
});

$('#main-notification .js-send-mutip-azi').click(function() {
	var list_notice = $('#main-notification .add-date-notice-detail');
	$('#main-notification .add-date-notice-detail .js-link').removeClass('is-invalid');
	$('#main-notification .add-date-notice-detail .js-content').removeClass('is-invalid');
	$('#main-notification .add-date-notice-detail .js-date').removeClass('is-invalid');
	if (list_notice.length > 0) {
		var push_error = false;
		$.each(list_notice, function( index, value ) {
		  	var push_link = $(this).find('.js-link').val();
		  	var push_content = $(this).find('.js-content').val();
		  	var push_date = $(this).find('.js-date').val();
		  	if ($.trim(push_content) == '' || $.trim(push_link) == '') 
		  	{
		  		$(this).find('.js-content').addClass('is-invalid');
		  		$(this).find('.js-link').addClass('is-invalid');
		  		push_error = true;
		  	}

		  	var parsedDate = Date.parse(push_date);
		  	if (isNaN(parsedDate)) 
		  	{
			    $(this).find('.js-date').addClass('is-invalid');
			    push_error = true;
			}
		});

		if (push_error == false) 
		{
			$('.load-wrapp').modal('show');
			$('.load-wrapp').removeAttr('style');
			var url_send = $('#js-action-send').val();
			var formData = new FormData($('#js-send-mutip-notification-azi')[0]);
	        $.ajax({
	            url: url_send,
	            type: 'post',
	            data: formData,
	            dataType: "json",
	            contentType: false,
	            processData: false,
	            success: function (response) {
	                if (response != '') 
	                {	
	                	if (response.data.status == 1) 
	                	{
	                		alert('Thêm thông báo thành công.');
	                		location.reload();
	                	}
	                }
	                else 
	                {
	                	alert('Thêm thông báo thất bại.');
	                }
	            }
	        }).always(function() {
	            $('.load-wrapp').modal('hide');
	        });
			
		}

	}
	else
	{
		alert('Bạn chưa thêm ngày thông báo.');
	}
});

$('#main-notification').on('click', '.js-delete-notice-azi', function() {
	var list_notice = $('#main-notification .add-date-notice-detail');
	if (list_notice.length == 0) {
		$('#main-notification .add-date-action-azi').addClass('hidden');
	}
});

var use_id = 0;
var use_name = '';

$('body').on('change', '.date', function(){
	if($(this).val() == ''){
		$('.date_from').attr('name', '').addClass('hidden');
		$('.date_to').attr('name', '').addClass('hidden');
		$('.txt').addClass('hidden');
	}else{
		$('.txt').removeClass('hidden');
		if($(this).val() == 1){
			$('.date_from').attr('name', 'register_date_from').attr('placeholder', 'Ngày đăng ký').removeClass('hidden');
			$('.date_to').attr('name', 'register_date_to').attr('placeholder', 'Ngày đăng ký').removeClass('hidden');
		}

		if($(this).val() == 2){
			$('.date_from').attr('name', 'lasted_login_date_from').attr('placeholder', 'Ngày đăng nhập').removeClass('hidden');
			$('.date_to').attr('name', 'lasted_login_date_to').attr('placeholder', 'Ngày đăng nhập').removeClass('hidden');
		}
	}
});

$('body').on('click', '.js-popup-user', function(){
	var this_p = $(this).parents('tr');
	var temp_popup_user = $('#temp_popup_user').html();
	var id = $(this_p).find('.id').text();
	use_name = $(this_p).find('.text').text();
	$('#modal-popup-user .modal-header p.title b').html('Thành viên: '+$(this_p).find('.text').text());
	$('#modal-popup-user .modal-body').html(temp_popup_user);
	$('#modal-popup-user .modal-body .page-profile a').attr('href', $(this).data('page_prf'));
	if($(this).data('page_shop') != ''){
		$('#modal-popup-user .modal-body .page-shop').removeAttr('style');
		$('#modal-popup-user .modal-body .page-shop').html('<a href="'+$(this).data('page_shop')+'" target="_blank">Xem trang doanh nghiệp</a>');
	}
	
	$('.js-pop-user').attr('data-id', id);
	if($('.no-status-'+id).length > 0){
		$('.change-status').text('Bật kích hoạt');
	}

	if($('.is-block-'+id).length > 0){
		$('.block-news').text('Bỏ chặn bài viết');
	}
});

$('body').on('click', '.change-status, .block-news', function(){
	
	$('#modal-popup-user').modal('hide');
	var this_p = $(this).parents('ul');
	var username = use_name;
	if($(this).find('img.js-active-user').length > 0){
		this_p = $(this);
		username = $(this).parents('tr').find('.text').text();
	}
	var id = $(this_p).data('id');
	var text = class_ = '';
	use_id = $(this_p).data('id');

	if($(this).hasClass('change-status') == true){
		text = 'Bạn muốn tắt kích hoạt';
		class_ = 'btn-change-status';

		if($('.no-status-'+id).length > 0){
			text = 'Bạn muốn bật kích hoạt';
		}
	}

	if($(this).hasClass('block-news') == true){
		text = 'Bạn có chắc muốn chặn hiển thị bài viết của ';
		class_ = 'btn-block-news';

		if($('.is-block-'+id).length > 0){
			text = 'Bạn có chắc muốn bỏ chặn hiển thị bài viết của ';
		}
	}

	$('#modal_mess').modal('show');
	$('#modal_mess .modal-body p').html(text+' tài khoản <b>'+username+'</b>');
	$('#modal_mess .modal-footer .btn-ok').removeClass('hidden').addClass(class_).text('Xác nhận');
});

$('body').on('click', '.btn-change-status.btn-ok, .btn-block-news.btn-ok', function(){
	var text = class_ = '';
	var id = use_id;

	if($(this).hasClass('btn-change-status') == true){
		url = siteUrl + 'azi-admin/notifications/change-status-user';
		if($('.no-status-'+id).length > 0){
			text = 'Bật kích hoạt';
		}else{
			text = 'Tắt kích hoạt';
		}
	}

	if($(this).hasClass('btn-block-news') == true){
		url = siteUrl + 'azi-admin/notifications/block-news';
		if($('.is-block-'+id).length > 0){
			text = 'Bỏ chặn';
		}else{
			text = 'Chặn';
		}
	}

	if($('.js-pop-user').attr('data-id') > 0){
		id = $('.js-pop-user').attr('data-id');
	}

	$('#modal_mess').modal('hide');
	$('.load-wrapp').modal('show');
	$('.load-wrapp').removeAttr('style');

	$.ajax({
		url: url,
        type: 'post',
        data: {ids: id},
        dataType: "json",
        success: function(response) {
        	if (response.data.status == 1) 
        	{
        		alert(text+' thành công.');
        		location.reload();
        	}
            else
            {
            	alert(text+' thất bại.');
            }
            $('.load-wrapp').modal('hide');
        }
	});
});