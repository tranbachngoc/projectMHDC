function openpopup ( element ) {
    $(element).addClass('is-open');
    $('.wrapper').addClass('drawer-open');
}

function closepopup ( element ) {
    $(element).removeClass('is-open');
    $('.wrapper').removeClass('drawer-open');
}

function nl2br (str, is_xhtml) {
    if (typeof str === 'undefined' || str === null) {
        return '';
    }
    var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br/>' : '<br>';
    return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
}

function br2nl (str, is_xhtml) {
    if (typeof str === 'undefined' || str === null) {
        return '';
    }
    var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '\n' : '\n';
    return (str + '').replace(/(<\/br>|<br>|<br\/>)/g, breakTag);
}

function closeworking(sString) {

    var allwork = {
        boxadd              : '#boxaddfunction',
        boxaddnewsexample   : '#boxaddnewsexample',
        boxwork             : '#boxwork',
        boxaddnew           : '.boxaddnew',
        boxaddfunction      : '.boxaddfunctionfooter',
        morefooter          : '.morefooter.list-checkbox',
        linkmain            : '#tabdescontentlinkmain'
    }

    if(sString != '') {
        $(allwork[sString]).css('display','block');
        $(allwork[sString]).attr('data-satus','opened');
        delete allwork[sString];
        $.each(allwork, function( index, value ) {
            $(value).css('display','none');
            $(value).attr('data-satus','closed');
        });
        $('.sidebar-left').html('');
    }
}

function addImageDes(title, content) {
    if(typeof title != 'undefined') {
        var title = title;
    }else {
        var title = '';
    }

    if(typeof content != 'undefined') {
        var content = content;
    }else {
        var content = '';
    }
    var sDesImage = '';
    sDesImage += '<input maxlength="60" value="'+title+'" name="tabdestitle" id="tabdestitle" placeholder="Nhập tiêu để mô tả"/>';
    sDesImage += '<textarea maxlength="500" name="tabdescontent" id="tabdescontent" rows="5" placeholder="Nhập mô tả">'+content+'</textarea>';
    if($('.tabdescontent').find('input#tabdestitle').length == 0) {
        $('.tabdescontent').prepend(sDesImage);
    }
}

function addTextInImage(element,num,value) {
    var htmlText = '';
    htmlText +='<div class="text-image-item" data-text-item="'+num+'">';
        htmlText +='<input type="text" data-id="'+num+'" value="'+value+'" id="text_'+num+'" maxlength="60">';
        htmlText +='<button type="button" class="close remove-text-item">×</button>';
    htmlText +='</div>';
    $(element).append(htmlText);
}

function addIconHtml(element, id, type, icon, icon_type) {

    var htmlIcon = '';
    htmlIcon += '<div class="icon-item-featured '+icon.position+'">';
        htmlIcon += '<div class="image">';
            if(icon_type == 'json') {
                htmlIcon += '<div class="image-json" id="json_'+id+'"></div>';
            }else {
                htmlIcon += '<img src="'+icon.icon_url+'">';
            }
            
            htmlIcon += '<button type="button" class="close remove-icon-item" data-icon="'+id+'">×</button>';
        htmlIcon += '</div>';
        htmlIcon += '<div class="infomation">';
            htmlIcon += '<div class="title">'+icon.title+'</div>';
            htmlIcon += '<div class="des">'+icon.desc+'</div>';
        htmlIcon += '</div>';
    htmlIcon += '</div>';
    htmlIcon += '<div class="clear"></div>';

    $(element).append(htmlIcon);

    var idelement = 'icon_featured';
    if(type != undefined) {
        idelement = idelement+type+id;
    }else {
        idelement = idelement+id;
    }
    var htmlIconPre = '';
    htmlIconPre += '<div id="'+idelement+'" class="icon-item-featured '+icon.position+'">';
        htmlIconPre += '<div class="image">';
            if(icon_type == 'json') {
                htmlIconPre += '<div class="image-json" id="json_preview_'+id+'"></div>';
            }else {
                htmlIconPre += '<img src="'+icon.icon_url+'">';
            }
        htmlIconPre += '</div>';
        htmlIconPre += '<div class="infomation">';
            htmlIconPre += '<div class="title">'+icon.title+'</div>';
            htmlIconPre += '<div class="des">'+icon.desc+'</div>';
        htmlIconPre += '</div>';
    htmlIconPre += '</div>';
    htmlIconPre += '<div class="clear"></div>';
    
    switch(type) {
        case 'addimage':
            $('#'+id).append(htmlIconPre);
            break;
        default:
            $('#pretitlecontent').append(htmlIconPre);
    }
    if(icon_type == 'json') {
        bodymovin.loadAnimation({
          container: document.getElementById('json_'+id),
          renderer: 'svg',
          loop: true,
          autoplay: true,
          path: icon.icon_url
        });

        bodymovin.loadAnimation({
          container: document.getElementById('json_preview_'+id),
          renderer: 'svg',
          loop: true,
          autoplay: true,
          path: icon.icon_url
        });
    }
}

function alignVertical(data_align) {
    switch(data_align) {
        case 'top':
            $('.boxaddtextimagecontent').find('.slider-text-item').css('top','0px');
            break;
        case 'middle':
            $('.boxaddtextimagecontent').find('.slider-text-item').css('top','calc( 50% - 50px )');
            break;
        case 'bottom':
            $('.boxaddtextimagecontent').find('.slider-text-item').css({'top':'auto','bottom':'0px'});
            break;
        default:
            $('.boxaddtextimagecontent').find('.slider-text-item').css({'left':'0px','top':'0px'});
    }
}

// Đóng popup

jQuery(document).on('click','.drawer-overlay, .js-back', function() {
    var element = $(this).attr('data-popup');
    $(element).removeClass('opened');
    $('.model-content').removeClass('is-open');
    $('.wrapper').removeClass('drawer-open');
    return false;
});

// Tạo id của hình
function GenerateRandomString(len){
    var d = new Date();
    var text = d.getTime();

    return text;
}

function Base64ToImage(base64img) {
    var byteString;
    if (base64img.split(',')[0].indexOf('base64') >= 0){
        byteString = atob(base64img.split(',')[1]);
    }else {
        byteString = unescape(base64img.split(',')[1]);
    }

    var mimeString = base64img.split(',')[0].split(':')[1].split(';')[0];

    // write the bytes of the string to a typed array
    var ia = new Uint8Array(byteString.length);
    for (var i = 0; i < byteString.length; i++) {
        ia[i] = byteString.charCodeAt(i);
    }

    return new Blob([ia], {type:mimeString});
}

if (!window.requestAnimationFrame) {
    window.requestAnimationFrame = window.mozRequestAnimationFrame ||
      window.webkitRequestAnimationFrame ||
      window.msRequestAnimationFrame ||
      window.oRequestAnimationFrame ||
      function (cb) { setTimeout(cb, 1000/60); };
}

function computeTimePositions($h, $m, $s) {
    var now = new Date(),
            h = now.getHours(),
            m = now.getMinutes(),
            s = now.getSeconds(),
            ms = now.getMilliseconds(),
            degS, degM, degH;

    degS = (s * 6) + (6 / 1000 * ms);
    degM = (m * 6) + (6 / 60 * s) + (6 / (60 * 1000) * ms);
    degH = (h * 30) + (30 / 60 * m);
    $s.css({ "transform": "rotate(" + degS + "deg)" });
    $m.css({ "transform": "rotate(" + degM + "deg)" });
    $h.css({ "transform": "rotate(" + degH + "deg)" });

    requestAnimationFrame(function () {
      computeTimePositions($h, $m, $s);
    });
}

function setUpFace() {
    for (var x = 1; x <= 60; x += 1) {
      addTick(x); 
    }

    function addTick(n) {
      var tickClass = "smallTick",
              tickBox = $("<div class=\"faceBox\"></div>"),
              tick = $("<div></div>"),
              tickNum = "";

      if (n % 5 === 0) {
            tickClass = (n % 15 === 0) ? "largeTick" : "mediumTick";
            tickNum = $("<div class=\"tickNum\"></div>").text(n / 5).css({ "transform": "rotate(-" + (n * 6) + "deg)" });
            if (n >= 50) {
              tickNum.css({"left":"-0.5em"});
            }
      }


      tickBox.append(tick.addClass(tickClass)).css({ "transform": "rotate(" + (n * 6) + "deg)" });
      tickBox.append(tickNum);

      $(".clock").append(tickBox);
    }
}

function setSize(element) {
    var b = $(this), //html, body
            w = b.width(),
            x = Math.floor(w / 30) - 1,
            px = (x > 25 ? 26 : x) + "px";

    $(".clock").css({"font-size": px });

    if (b.width() !== 400) {
      setTimeout(function() { $("._drag").hide(); }, 500);
    }
}

function select_icon_cate(iCateId) {
    var iCateId = iCateId;
    var element = $('#category_icon_'+iCateId);
    $('.list-icon-category').find('.active').removeClass('active');
    element.addClass('active');
    $.ajax({
        url: main_url+'tintuc/geticons',
        //processData: false,
        //contentType: false,
        type: 'POST',
        dataType : 'json',
        data: {category_id : iCateId},
        success:function(data){
            console.log(data);
            $('#myIconModal .list-icon').html(data.data);
        }
    });

}