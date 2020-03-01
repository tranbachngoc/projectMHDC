<script>
  $('#modalFilter input').on('click', function(event) {
    var text = $(this).next().text();
    var parent = $(this).closest('.filter-cates-item');
    $(parent).find('.show-cate-child').text(text);
    $(parent).find('.cate-parent').trigger('click');
  })
  function error_image(image) {
    default_image_error_path = '/templates/home/styles/images/svg/azibai-default-image.svg';
    $(image).attr('src', default_image_error_path);
  }
</script>

<?php if($this->uri->segment(1) == 'search-image') { ?>
<script type="text/javascript">
  var masonryOptions = {
    itemSelector: '.grid-item',
    // horizontalOrder: true,
    // percentPosition: true
  }
  // var $grid = $('.grid').masonry( masonryOptions );
  var $grid = $('.grid');
  $grid.imagesLoaded().progress( function() {
    $grid.masonry( masonryOptions );
    $grid.masonry('layout');
  });
</script>
<?php } ?>


<?php if($this->uri->segment(1) != 'search') { ?>
<script>
  $( document ).ready(function() {
    var is_busy = false;
    var page = 1;
    var stopped = false;
    $(window).scroll(function (event) {
      $element = $('#detail');
      if($(window).scrollTop() + $(window).height() >= $element.height() - 400) {
        if (is_busy == true){
          return false;
        }
        if (stopped == true){
          return false;
        }
        is_busy = true;
        page++;

        $.ajax({
          type: 'post',
          dataType: 'html',
          async: true,
          url: window.location.href,
          data: { page: page },
          beforeSend: function() {
            $('.js-loading').show();
          },
          success: function (result) {
            if(result == '') {
              $('.js-loading').hide();
              $('.js-end').show();
              stopped = true;
            } else {
              if($element.hasClass('grid')){
                var $content = $(result);
                $grid.append( $content ).masonry('appended', $content);
                $grid.imagesLoaded().progress( function() {
                  $grid.masonry('layout');
                });
              } else {
                $element.append(result);
              }
              $('.js-loading').hide();
            }
          }
        })
        .always(function() {
          is_busy = false;
        });
        return false;
      }
    });
  });
</script>
<?php } ?>