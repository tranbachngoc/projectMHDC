<style type="text/css">
.listfriends-tabs .left .bosuutap-header-tabs-content li{
  padding: 8px 0 0 0;
}
li.list-invite {
  position: relative;
}
span.numcount {
  right: -10px;
  top: 35%;
}
.bosuutap-header-tabs-content li {
  margin-right: 30px;
}
.search .autocompletebox-content-body .item .img img{
  position: unset;
  width: 100%;
}
</style>
<div class="listfriends">
    <div class="listfriends-title">
      Có <?php echo count($listuser['user']);?> kết quả được tìm thấy
    </div>
    <div class="listfriends-tabs">
      <div class="left">
        <div class="bosuutap-header-tabs">
        </div>
      </div>
      <div class="right">
        <div class="search">
          <form class="form-search" method="get" action="<?php echo $info_public['profile_url'].'list-search-user' ?>">
            <input type="text" name="keyword" placeholder="Tìm kiếm bạn bè" value="<?php if(isset($_REQUEST['keyword']) && $_REQUEST['keyword'] != '') echo $_REQUEST['keyword']; ?>" required>
            <img src="/templates/home/styles/images/svg/search.svg" alt="">
          </form>
          <div class="autocompletebox-content">
            <div class="autocompletebox-content-item">
              <div class="autocompletebox-content-body js-dataArticle">
                <h3 class="tit">Tìm bạn bè</h3>
                <div class="box-user"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="listfriends-content">
      <?php $this->load->view('home/personal/elements/friends') ?>
    </div>
</div>
<div class="modal mess-bg" id="actfriend">
  <div class="modal-dialog modal-dialog-center modal-lg modal-mess  ">
    <div class="modal-content">
    
      <!-- Modal Header -->
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
      </div>
      
      <!-- Modal body -->
      <div class="modal-body">
        <ul class="show-more-detail">
          
        </ul>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  $('form.form-search input').on('keyup', function(){
    $('.search .autocompletebox-content').addClass('autocompletebox-content-show');
    var keyword = $(this).val();
    $(this).autocomplete({
      source: function( request, response )
      {
        $.ajax({
          url: siteUrl+'search-user',
          data:{keyword: keyword},
          type: 'post',
          dataType: 'json',
          success: function(results)
          {
            var temp_search = '';
            var result = results.data;
            $(result).each(function(at, item){
              temp_search += '<div class="items">';
                temp_search += '<a class="item" href="'+siteUrl+'profile/'+item.user_id+'" target="_blank">';
                  temp_search += '<div class="img">';
                  temp_search += '<img src="'+item.user_image+'">';
                  temp_search += '</div>';
                  temp_search += '<div class="text">';
                    temp_search += '<h4 class="one-line">'+item.user_fullname+'</h4>';
                    temp_search += '<p class="one-line">'+item.user_address+'</p>';
                  temp_search += '</div>';
                temp_search += '</a>';
              temp_search += '</div>';
            });
            $('.box-user').html(temp_search);
          }
        });
      }
    });
  });

  $(document).ready(function()
  {
    var $win = $(window);
    var $box = $(".listfriends-tabs .right");
    $win.on("click.Bst", function(event){
      if ($box.has(event.target).length == 0 && !$box.is(event.target)){
        $('.search .autocompletebox-content').removeClass('autocompletebox-content-show');
      }
    });
  });
</script>