<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>


<script>
    /*   
    var mincount = 0;
    var maxcount = 10;
    $(".itempost").slice(mincount,maxcount).fadeIn(1200);
    $(window).scroll(function() {
        if($(window).scrollTop() + $(window).height() >= $(document).height() - 600) {
            $(".itempost").slice(mincount,maxcount).fadeIn(1000);
            mincount = mincount+10;
            maxcount = maxcount+10;
        }
    });*/
    
    function antinnay(id) { 
            $.ajax({
                type: "post",
                url: "/home/tintuc/hidePost",
                cache: false,
                data: {id: id},
                dataType: 'text',
                success: function (data) {
                    if (data == '1') {
                        $('#item' + id).remove();
                        alert('Ẩn tin thành công!');
                    } else {
                        alert('Có lỗi xảy ra, vui lòng thử lại!');
                    }
                }
            });

        return false;
    }
    function xoatinnay(id,user) {
        $.ajax({
            type: "post",
            url: "/home/tintuc/deletePost",
            cache: false,
            data: {id: id, not_user:user},
            dataType: 'text',
            success: function (data) {
                if (data == '1') {
                    $('#item' + id).remove();
                    alert('Xóa tin thành công!');
                } else {
                    alert('Có lỗi xảy ra, vui lòng kiểm tra lại!');
                }
            }
        });      
        return false;
    }
    
    function chontin(id, user) {         
            $.ajax({
                type: "post",
                url: "/home/tintuc/selectPost",
                cache: false,
                data: {not_id: id, not_user: user},
                dataType: 'text',
                success: function (data) {                   
                    if (data == '1') {
                        alert('Chọn tin thành công.');
                        $('li.chontin_'+id).after('<li class="bochontin bochontin_'+id+'"><a href="javascript:void(0)" onclick="bochontin('+id+', '+user+');"><i class="azicon icon-check-square"></i>&nbsp; Bỏ chọn tin</a></li>');
                        $('li.chontin_'+id).remove();
                    } else {
                       alert('Có lỗi xảy ra, vui lòng kiểm tra lại!'); 
                    }
                }
            });
       
        return false;
    }
    function bochontin(id,user) {
            $.ajax({
                type: "post",
                url: "/home/tintuc/unSelectPost",
                cache: false,
                data: {not_id: id},
                dataType: 'text',
                success: function (data) {                   
                    if (data == '1') {                         
                        alert('Bỏ chọn tin thành công.');  
                        $('li.bochontin_'+id).after('<li class="chontin chontin_'+id+'"><a href="javascript:void(0)" onclick="chontin('+id+', '+user+');"><i class="azicon icon-square"></i> &nbsp; Chọn tin</a></li>');
                        $('li.bochontin_'+id).remove();
                    } else {
                        alert('Có lỗi xảy ra, vui lòng kiểm tra lại!');
                    }
                }
            });
       
        return false;
    }
    function bochontin2(id) {
            $.ajax({
                type: "post",
                url: "/home/tintuc/unSelectPost",
                cache: false,
                data: {not_id: id},
                dataType: 'text',
                success: function (data) {                   
                    if (data == '1') {                         
                        alert('Bỏ chọn tin thành công.');  
                        $('li.bochontin_'+id).remove();
                    } else {
                        alert('Có lỗi xảy ra, vui lòng kiểm tra lại!');
                    }
                }
            });
       
        return false;
    }
    
    function ghimtin(id) {        
            $.ajax({
                type: "post",
                url: "/home/tintuc/ghimtin",
                cache: false,
                data: {not_id: id},
                dataType: 'text',
                success: function (ress) {                   
                    if (ress == '1') { 
                        alert('Ghim tin thành công. Tin bạn ghim sẽ được hiển thị đầu tiên tại trang chủ tin tức của bạn.');                       
                    } else {
                        alert('Có lỗi xảy ra, vui lòng kiểm tra lại!');
                    }
                }
            });        
        return false;
    }    
    function setpermission(id,value) {       

        $.ajax({
            type: "post",
            url: "/home/tintuc/setpermission",
            cache: false,
            data: {not_id: id, value: value},
            success: function (data) {
                if (data == '1') {                       
                    alert('Phân quyền tin thành công.'); location.reload();       
                } else {
                    alert('Có lỗi xảy ra, vui lòng thử lại!');
                }
            }
        });

        return false;
    }    
    function yeuthich(id,user){
        $.ajax({
            type:"post",url:"/home/tintuc/favorite",
            cache:false,data:{not_id:id,not_user:user},
            dataType:'text',
            success:function(data){
                if(data=='1'){
                    alert('Đã thêm tin vào yêu thích');
                    $('.favorite_' + id).after('<a class="unfavorite_' + id + '" href="javascript:void(0)" onclick="huythich(' + id + ',' + user + ');"> <span data-toggle="tooltip" data-placement="top" data-original-title="Bỏ thích"> <i class="azicon icon-favorite"></i> <span class="hidden-xs">Hủy thích</span> </span> </a>');
                    $('.favorite_' + id).remove();
                } else{
                    alert('Có lỗi xảy ra, vui lòng kiểm tra lại!');
                }
            }
        });
        return false
    } 
    function huythich(id,user){
        $.ajax({
            type:"post",url:"/home/tintuc/unfavorite",
            cache:false,data:{not_id:id,not_user:user},
            dataType:'text',
            success:function(data){
                if(data=='1'){
                    alert('Đã thêm tin vào yêu thích');
                    $('.unfavorite_' + id).after('<a class="favorite_' + id + '" href="javascript:void(0)" onclick="yeuthich(' + id + ',' + user + ');"> <span data-toggle="tooltip" data-placement="top" data-original-title="Yêu thích"> <i class="azicon icon-favorite"></i> <span class="hidden-xs">Yêu thích</span> </span> </a>');
                    $('.unfavorite_' + id).remove();
                } else{
                    alert('Có lỗi xảy ra, vui lòng kiểm tra lại!');
                }
            }
        });
        return false
    } 
</script>