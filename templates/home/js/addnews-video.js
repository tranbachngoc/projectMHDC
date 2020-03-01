// Reader video
function renderFileVideo(file, type) {
    console.log('type', type);
    video_busy = true;
    var fileReader = new FileReader();
    fileReader.onload = function(e) {
        var not_video = formData.get('not_video');
        var id = GenerateRandomString(10);
        if(not_video == null) {
            var promise = new Promise(function(resolve, reject) {
                var temp = uploadTempVideo(file);
                if(temp){
                    resolve(temp);
                }else{
                    reject(false);
                }
            });
            promise.then(function (res) {
                if(res && typeof res.status !== 'undefined' && res.status == 1){
                    formData.set('not_video', res.data.video);
                    formData.set('not_video_thumb', res.data.thumbnail);
                    formData.set('have_video', 1);
                } else {
                    showError('Xảy ra lỗi trong quá trình upload video vui lòng thử lại.');
                    reject(false);
                }
            }).then(function () {
                var html = '';
                var temp_backgroup = DOMAIN_CLOUDSERVER+'tmp/'+formData.get('not_video_thumb');
                html +='<div class="boxaddimagegallerybox" data-id="'+id+'" style="background-image: url('+temp_backgroup+')">';
                html +='    <div class="backgroundfillter"></div>';
                html +='    <button class="editvideogallary '+ (typeof type !== 'undefined' ? type : '') +'" data-id="'+id+'">';
                html +='        <img src="'+website_url+'/templates/home/styles/images/svg/play_video.svg" />';
                html +='    </button>';
                html +='    <button class="deletevideo" data-id="'+id+'"></button>';
                html +='</div>';
                $(html).insertBefore('#boxaddimagegallery .boxaddmoreimage');
            }).catch(function (error) {
                console.log('error',error);
            }).finally(function () {
                $('#process-file').css('display','none');
                video_busy = false;
            });
        }else {
            showError('<p>Video đã tồn tại, Vui lòng xóa video cũ!</p>');
        }
    };
    fileReader.readAsDataURL(file);
}

function uploadTempVideo(file) {
    $('#process-file').css('display','block');
    var addvideo = new FormData();
    addvideo.set('video', file, file.name);
    return $.ajax({
        url: api_common_video_post,
        processData: false,
        contentType: false,
        data: addvideo,
        type: 'POST',
        dataType : 'json'
    });
}

$(document).on('click', '#boxaddimagegallery .deletevideo', function (e) {
    $(this).closest('div.boxaddimagegallerybox').remove();
    if (formData.get('not_video')) {
        formData.delete('have_video');
        formData.delete('not_video_thumb');
        formData.delete('not_video');
        formData.delete('video_title');
        formData.delete('video_content');
    }
    $('#addNewsFrontEnd #boxwork').html('');
    $('.previewnews .sidebar-left').html('');
});