function isURL(str) {
    return /^(?:\w+:)?\/\/([^\s\.]+\.\S{2}|localhost[\:?\d]*)\S*$/.test(str);
}
$(document).ready(function() {
    /***********bookmark*************/
    
    $(document).on('click', '.js_btn-save-bookmark', function (event) {
        event.preventDefault();
        $('.js_frm-add-bookmark .text-danger').hide().text('');
        var title = $('.js_frm-add-bookmark input[name="name"]').val();
        var url = $('.js_frm-add-bookmark input[name="link"]').val();
        if(!title){
            $('.js_frm-add-bookmark .js_name-msg').text('Vui lòng nhập tiêu đề').fadeIn();
            return;
        }
        if(!isURL(url)){
            $('.js_frm-add-bookmark .js_link-msg').text('Liên kết không hợp lệ').fadeIn();
            return;
        }
        $._loading('show');
        $('#addBookmarkLinks').modal('hide');
        $.ajax({
            url: '/bookmarks/create' ,
            type: 'POST',
            dataType: 'json',
            data: $('.js_frm-add-bookmark').serialize(),
            success: function (res) {
                if(res && typeof res !== 'undefined'){
                    if(typeof res.status !== 'undefined' && res.status == 1){
                        showAlert('Thông báo',res.message,'success', '', true);
                        $('.js_frm-add-bookmark .text-danger').fadeOut().text('');
                        $('.js_frm-add-bookmark .js_ten-bst-input').val('');
                    }
                    if(typeof res.status !== 'undefined' && res.status == 0){
                        showAlert('Thông báo',res.message,'danger');
                    }
                    if(typeof res.status === 'undefined'){
                        $.each(res, function (index, value) {
                            $('.js_frm-add-bookmark .js_'+index+'-msg').text(value).fadeIn();
                        });
                        $('#addBookmarkLinks').modal('show');
                    }
                }
            }
        }).always(function() {
            $._loading();
        });
    });
    
    $(document).on('click', '.js_remove-bookmark', function (event) {
        event.preventDefault();
        showConfirm({
            'callbackYes': remove_bookmark,
            'callbackYesAgument': $(this).attr('data-id')
        });
    });

    function remove_bookmark(id)
    {
        $._loading('show');
        $.ajax({
            url: '/bookmarks/'+ id+'/delete' ,
            type: 'POST',
            dataType: 'json',
            success: function (res) {
                if(res && typeof res.status !== 'undefined'){
                    if(res.status === 1){
                        $('.js_bookmark-item.js_bookmark-item-'+id).remove();
                    }
                    if(res.status === 0){
                        showAlert('Thông báo',res.message, 'danger');
                    }
                }
            }
        }).always(function() {
            $._loading();
        });
    }
    /***********bookmark*************/
});