<?php
global $idHome;
$idHome = 1;
?>
<?php $this->load->view('home/common/header'); ?>
<script>
  $(document).ready(function(){
        $('#Province').change(function(){
            $.ajax({
                url     : siteUrl  +'save-province',
                type    : 'post',
                data    : {province: $("#Province").val()}
            }).done(function(response) {
                if(response == "1"){
                    $(".nameProvince").html($("#Province option:selected").text());
                    window.location.reload();
                } else {
                    alert("Lỗi trình duyệt! Vui lòng xóa cache");return false;
                }
            });
        });
  });

  function Search_home() {
      //var url = '<?php echo base_url();?>search/product/name/';
      var url = '<?php echo base_url();?>search-information';
      var data = $('#singleBirdRemote').val();
      $('#formsearch_home').attr('action');
      document.formsearch_home.submit();
  }
</script>

  <div class="container con_index">
    <div class="row">    
        <div class="col-lg-3 col-xs-12 sieuthiazibai">
            <select name="Province" id="Province" style="width:150px" class="form_control_select">
            <option value=""> -- Siêu thị azibai -- </option>
            <?php $nameProvince = "";?>
            <?php foreach($province as $provinceArray){            
                if($provinceArray->pre_id == $this->session->userdata['s_province'] && $nameProvince == ""){  $nameProvince = $provinceArray->pre_name; }
            ?>
                    <option value="<?php echo $provinceArray->pre_id;?>" <?php echo  ($provinceArray->pre_id == $this->session->userdata['s_province'])?"selected='selected'":""; ?>><?php echo $provinceArray->pre_name;?></option>
            <?php } ?>
            </select>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 col-xs-11 text-center">  
	        <p style="min-height:10px" class="visible-xs visible-sm"></p>	
        </div>
    </div>
    <p></p>

    <div class="row">
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
          <!-- Nav tabs -->
          <div class="tabbable custom-tabs">
              <ul class="nav nav-tabs" role="tablist">
                  <li role="presentation" class="active">
                      <a href="#product" aria-controls="product" role="tab" data-toggle="tab"><i class="fa fa-shopping-cart fa-fw"></i> Sản phẩm</a>
                  </li>
                  <?php if (serviceConfig == 1){ ?>
                  <li role="presentation">
                      <a href="#service" aria-controls="service" role="tab" data-toggle="tab"><i class="fa fa-cog fa-fw"></i> Dịch vụ</a>
                  </li>
                  <?php } ?>
                  <li role="presentation">
                      <a href="#coupon" aria-controls="coupon" role="tab" data-toggle="tab"><i class="fa fa-tags fa-fw"></i> Coupon</a>
                  </li>
              </ul>
              <div class="tab-content">
                  <div role="tabpanel" class="tab-pane fade in active" id="product">
                      <?php foreach ($azitab['categories'] as $k=>$category) : ?>
                              <div class="col-sm-4 db_hover_sp">
                                  <a href="<?php echo base_url(). $category->cat_id."/".RemoveSign($category->cat_name); ?>">
                                      <img src="<?php echo base_url().'images/icon/icon'.$category->cat_id.'.png'?>"/>
                                      <?php echo $category->cat_name; ?>
                                  </a>
                              </div>
                      <?php endforeach; ?>
                  </div>
                  <?php if (serviceConfig == 1){ ?>
                  <div role="tabpanel" class=" tab-pane fade" id="service">
                      <?php foreach ($azitab['cat_service'] as $k=>$category) : ?>
                              <div class="col-sm-4 db_hover_sp">
                                  <a href="<?php echo base_url(). $category->cat_id."/".RemoveSign($category->cat_name); ?>">
                                      <!--  <img height="55" src="<?php /*echo base_url().'images/icon/icon'.$category->cat_id.'.png'*/?>"/>-->
                                      <img src="<?php echo base_url().'images/icon/icon-service.png'?>"/>
                                      <?php echo $category->cat_name; ?>
                                  </a>
                              </div>
                      <?php endforeach; ?>
                  </div>
                  <?php } ?>
                  <div role="tabpanel" class=" tab-pane fade" id="coupon">
                      <?php foreach ($azitab['cat_coupon'] as $k=>$category) : ?>
                              <div class="col-sm-4 db_hover_sp">
                                  <a href="<?php echo base_url(). $category->cat_id."/".RemoveSign($category->cat_name); ?>">
                                      <!--  <img height="55" src="<?php /*echo base_url().'images/icon/icon'.$category->cat_id.'.png'*/?>"/>-->
                                      <img src="<?php echo base_url().'images/icon/icon-service.png'?>"/>
                                      <?php echo $category->cat_name; ?>
                                  </a>
                              </div>
                      <?php endforeach; ?>
                  </div>
              </div>
          </div>          
	</div>
    </div>    
    <hr/>
    <div class="row">
        <div class="discover col-sm-8 col-xs-12">
	<div style="padding:5px 0; margin-top: 35px">
		<form class="form-horizontal" id="form_discovery" action="#" style="margin: 0">
                   <div class="input-group" style="padding: 10px 0;">
                       <input name="email" id="email" class="form-control input-lg" placeholder="your-email@domain.com" type="email">
                       <div name="submitemail" class="input-group-addon" onclick="addEmailNewsletter('<?php echo base_url(); ?>')">Khám phá!</div>
                   </div>
               </form>               
	    </div>
	</div>    
        <div class="discover col-sm-8 col-xs-12">        
	    <div class="socialbtns">
		Kết nối azibai trên:
	       <ul>
		   <li><a href="<?php echo socialFacebook; ?>" class="fa fa-2x fa-facebook"></a></li>
		   <li><a href="<?php echo socialTwitter; ?>" class="fa fa-2x fa-twitter"></a></li>
		   <li><a href="<?php echo socialGooglePlus; ?>" class="fa fa-2x fa-google-plus"></a></li>
		   <li><a href="<?php echo socialYoutube; ?>" class="fa fa-2x fa-youtube"></a></li>
		   <li><a href="<?php echo socialLinkedin; ?>" class="fa fa-2x fa-linkedin"></a></li>
		   <li><a href="<?php echo socialIntergram; ?>" class="fa fa-2x fa-instagram"></a></li>
	       </ul>
	    </div>
	</div>
	
    </div>
</div>
<?php $this->load->view('home/common/footer'); ?>
