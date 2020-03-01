<style>
  .hide-scroll {
    overflow: hidden;
  }
</style>

<link rel="stylesheet" href="/templates/home/styles/plugins/jquery-ui/jquery-ui.css">
<script src="/templates/home/styles/plugins/jquery-ui/jquery-ui.js"></script>

<script>
  $('input[name="search-azibai"]').on('keyup', function (e) {
    $('input[name="search-azibai"]').val($(this).val())
    if (e.which == 13) {
      var keyword = encodeURIComponent(e.currentTarget.value.trim());
      if(keyword !== '') {
        var url = encodeURI('<?=azibai_url()."/search"?>'+'?keyword='+keyword);
        window.location.replace(url);
      }
    } else {
      var keyword = encodeURIComponent(e.currentTarget.value.trim());
      if(keyword == '') {
        $('.js-result-search').removeClass('autocompletebox-content-show');
      }
      var url =  encodeURI('<?=azibai_url()."/search-all-auto"?>'+'?keyword='+keyword);
      $(this).autocomplete({
        source: function( request, response ) {
          $.ajax( {
            url: url,
            async: true,
            type: 'post',
            dataType: 'html',
            data: {keyword: request.term},
            beforeSend: function() {
              clear_result_search();
            },
            success: function( result ) {
              result = JSON.parse(result);
              console.log(result.data);
              if(result.msg == 'success') {
                // data Artical;
                if(result.data.dataArticle.length > 0){
                  response($.map(result.data.dataArticle, function (item) {
                    return {
                      content_title: item.article_title,
                      content_image: item.article_image,
                      content_user_name: item.user_fullname,
                      type: 'dataArticle',
                      url: '<?=azibai_url('/tintuc/detail/')?>' + item.article_id
                    };
                  }));
                } else {
                  var template = $('#dataEmpty').text();
                  $('.js-dataArticle').append(template);
                }

                // data dataCompany;
                if(result.data.dataCompany.length > 0){
                  response($.map(result.data.dataCompany, function (item) {
                    return {
                      shop_image: item.shop_image,
                      shop_cate_name: item.shop_category_name,
                      shop_name: item.shop_name,
                      type: 'dataCompany',
                      url: item.shop_url
                    };
                  }));
                } else {
                  var template = $('#dataEmpty').text();
                  $('.js-dataCompany').append(template);
                }

                // data dataPersonal;
                if(result.data.dataPersonal.length > 0){
                  response($.map(result.data.dataPersonal, function (item) {
                    return {
                      personal_image: item.user_image,
                      personal_name: item.user_fullname,
                      type: 'dataPersonal',
                      url: '<?=azibai_url('/profile/')?>' + item.user_id
                    };
                  }));
                } else {
                  var template = $('#dataEmpty').text();
                  $('.js-dataPersonal').append(template);
                }

                if($('.js-result-search').hasClass('autocompletebox-content-show') == false) {
                  $('.js-result-search').addClass('autocompletebox-content-show');
                }
              }
            }
          });
        },
        delay:500,
        minLength: 1,
      })
      .data("ui-autocomplete")._renderItem = function (ul, item) {
        if(item.type == 'dataArticle') {
          var template = $('#dataArticle').text();
          template = template.replace('{{CONTENT_IMAGE}}',item.content_image)
            .replace('{{CONTENT_TITLE}}',item.content_title)
            .replace('{{CONTENT_CREATE_BY}}',item.content_user_name)
            .replace('{{DATA_REDIRECT}}',item.url);
          return $('.js-dataArticle').append(template);
        }

        if(item.type == 'dataCompany') {
          var template = $('#dataCompany').text();
          template = template.replace('{{SHOP_IMAGE}}',item.shop_image)
            .replace('{{SHOP_NAME}}',item.shop_name)
            .replace('{{SHOP_CATEGORY}}',item.shop_cate_name)
            .replace('{{DATA_REDIRECT}}',item.url);
          return $('.js-dataCompany').append(template);
        }

        if(item.type == 'dataPersonal') {
          var template = $('#dataPersonal').text();
          template = template.replace('{{PERSONAL_IMAGE}}',item.personal_image)
            .replace('{{PERSONAL_NAME}}',item.personal_name)
            .replace('{{DATA_REDIRECT}}',item.url);
          return $('.js-dataPersonal').append(template);
        }
      };
    }
  });

  var clear_result_search = function () {
    $('.js-dataArticle, .js-dataCompany, .js-dataPersonal').find('.item').remove();
    $('body').addClass('hide-scroll');
  }

  $(window).click(function() {
    if($('.js-result-search').hasClass('autocompletebox-content-show')){
      $('.js-result-search').removeClass('autocompletebox-content-show');
      $('body').removeClass('hide-scroll');
    }
  });
</script>

<script id="dataArticle" type="text/template">
  <a class="item" href="{{DATA_REDIRECT}}">
    <div class="img"><img src="{{CONTENT_IMAGE}}" alt="" onerror="error_image(this)"></div>
    <div class="text">
      <h4 class="one-line">{{CONTENT_TITLE}}</h4>
      <p class="one-line">{{CONTENT_CREATE_BY}}</p>
    </div>
  </a>
</script>
<script id="dataCompany" type="text/template">
  <a class="item" href="{{DATA_REDIRECT}}">
    <div class="img"><img src="{{SHOP_IMAGE}}" alt="" onerror="error_image(this)"></div>
    <div class="text">
      <h4 class="one-line">{{SHOP_NAME}}</h4>
      <p class="one-line">{{SHOP_CATEGORY}}</p>
    </div>
  </a>
</script>
<script id="dataPersonal" type="text/template">
  <a class="item" href="{{DATA_REDIRECT}}">
    <div class="img"><img src="{{PERSONAL_IMAGE}}" alt="" onerror="error_image(this)"></div>
    <div class="text">
      <h4 class="one-line">{{PERSONAL_NAME}}</h4>
      <p class="one-line">Điện thoại viễn thông</p>
    </div>
  </a>
</script>
<script id="dataEmpty" type="text/template">
  <a class="item" href="javascript:void(0)">
    <div class="text">
      <h4 class="one-line">Không có kết quả</h4>
    </div>
  </a>
</script>
