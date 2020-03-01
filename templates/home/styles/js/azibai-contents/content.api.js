// delete content by id
function delete_content_by_id(content_id) {
    var url = window.location.protocol + "//" + window.location.hostname + "/home/api_content/delete_content/"+content_id;
    $.ajax({
        type: "POST",
        url: url,
        dataType: "json",
        beforeSend: function () {
            $('.load-wrapp').show();
        },
        success: function (response) {
            if(response.err == false) {
                $('.modal').modal('hide');
                $('.js-content-item_'+content_id).remove();
            } else {
                alert("Lỗi kết nối!!!");
            }
        },
        error: function () {
            alert("Lỗi kết nối!!!");
        }
    }).always(function () {
        $('.load-wrapp').hide();
    });
}

// remove suggest friend in homepage
function remove_suggest_friend(element, is_slider, event) {
    var nid = $(element).attr('data-id');
    var url = window.location.protocol + "//" + window.location.hostname + "/home/api_content/remove_suggest_user/"+nid;
    $.ajax({
        type: "POST",
        url: url,
        dataType: "json",
        beforeSend: function () {
            if(is_slider == true) {
                var $slickElement = $(element).closest('.js-slider-suggest');
                var index = $(element).closest('.js-item').attr('data-slick-index');
                $slickElement.slick('slickRemove', index);
                var i = 0;
                $slickElement.find(".js-item.slick-slide").each(function(){
                    $(this).attr("data-slick-index",i);
                    i++;
                });
            } else {
                $(element).closest('.js-item').remove();
            }
        },
        success: function (response) {
            console.log(response.mgs);
        },
        error: function () {
            alert("Lỗi kết nối!!!");
        }
    });
}

// remove suggest shop in homepage
function remove_suggest_shop(element, is_slider, event) {
    var nid = $(element).attr('data-id');
    var url = window.location.protocol + "//" + window.location.hostname + "/home/api_content/remove_suggest_shop/"+nid;
    $.ajax({
        type: "POST",
        url: url,
        dataType: "json",
        beforeSend: function () {
            if(is_slider == true) {
                var $slickElement = $(element).closest('.js-slider-suggest');
                var index = $(element).closest('.js-item').attr('data-slick-index');
                $slickElement.slick('slickRemove', index);
                var i = 0;
                $slickElement.find(".js-item.slick-slide").each(function(){
                    $(this).attr("data-slick-index",i);
                    i++;
                });
            } else {
                $(element).closest('.js-item').remove();
            }
        },
        success: function (response) {
            console.log(response.mgs);
        },
        error: function () {
            alert("Lỗi kết nối!!!");
        }
    });
}

// myFunction
function loadSuggestData(key) {
    var url = window.location.protocol + "//" + window.location.hostname + "/home/api_content/load_suggest_data";
    if($.inArray( key, ["shop_follow","shop_follow_better"]) > -1 ) {
        if($('.popupSuggetFollow_').length > 1 ) {
            $.each($('.popupSuggetFollow_'), function (i, e) {
                if(i > 0) {
                    $(e).remove();
                }
            });
        }
        if($('.popupSuggetFollow_:first .popupSuggetFollow-content .js-item').length > 0 ) {
            return false;
        }
    }
    $.ajax({
        type: "POST",
        url: url,
        data: {key: key},
        dataType: "html",
        beforeSend: function () {
            $('.load-wrapp').show();
        },
        success: function (html) {
            if($.inArray( key, ["friends","many_friends","mutual_friends"]) > -1 ) {
                $('#popupSuggetAddfriend_'+key+' .popup-sugget-addfriend').html(html);
            }
            if($.inArray( key, ["shop_follow","shop_follow_better"]) > -1 ) {
                $('#popupSuggetFollow_ .popupSuggetFollow-content').html(html);
            }
        },
        error: function () {
            alert("Lỗi kết nối!!!");
        }
    }).always(function () {
        $('.load-wrapp').hide();
    });
}

function send_request_friend(element, event) {
    var nid = $(element).attr('data-id');
    var is_sending = $(element).attr('data-is_send');
    var url = window.location.protocol + "//" + window.location.hostname + "/home/api_content/send_request_friend/"+nid;
    var name_js = $(element).attr('data-name_js');
    $.ajax({
        type: "POST",
        url: url,
        data: {is_sending: is_sending},
        dataType: "json",
        beforeSend: function () {
            $(name_js).prop("disabled", true);
            if(is_sending == 0) {
                if(!$(name_js).hasClass("btn-cancle")) {
                    $(name_js).addClass("btn-cancle")
                }
                $(name_js).find(".js-img").attr("src",$(name_js).attr('data-img_cancel'));
                $(name_js).find(".js-text").text("Hủy kết bạn");
                $(name_js).attr('data-is_send',1)
            } else {
                if($(name_js).hasClass("btn-cancle")) {
                    $(name_js).removeClass("btn-cancle")
                }
                $(name_js).find(".js-img").attr("src",$(name_js).attr('data-img_accept'));
                $(name_js).find(".js-text").text("Kết bạn");
                $(name_js).attr('data-is_send',0)
            }
        },
        success: function (response) {
            console.log(response.mgs);
        },
        error: function () {
            alert("Lỗi kết nối!!!");
        }
    }).always(function () {
        $(name_js).prop("disabled", false);
    });
}

function send_request_shop(element, event) {
    var nid = $(element).attr('data-id');
    var is_sending = $(element).attr('data-is_send');
    var url = window.location.protocol + "//" + window.location.hostname + "/home/api_content/send_request_follow_shop/"+nid;
    var name_js = $(element).attr('data-name_js');
    $.ajax({
        type: "POST",
        url: url,
        data: {is_sending: is_sending},
        dataType: "json",
        beforeSend: function () {
            $(name_js).prop("disabled", true);
            if(is_sending == 0) {
                if(!$(name_js).hasClass("btn-following")) {
                    $(name_js).addClass("btn-following")
                }
                $(name_js).find(".js-img").attr("src",$(name_js).attr('data-img_cancel'));
                $(name_js).find(".js-text").text("Bỏ theo dõi");
                $(name_js).attr('data-is_send',1)
            } else {
                if($(name_js).hasClass("btn-following")) {
                    $(name_js).removeClass("btn-following")
                }
                $(name_js).find(".js-img").attr("src",$(name_js).attr('data-img_accept'));
                $(name_js).find(".js-text").text("Theo dõi");
                $(name_js).attr('data-is_send',0)
            }
        },
        success: function (response) {
            console.log(response.mgs);
        },
        error: function () {
            alert("Lỗi kết nối!!!");
        }
    }).always(function () {
        $(name_js).prop("disabled", false);
    });
}