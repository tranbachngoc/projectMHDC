<?php $this->load->view('home/common/account/header'); ?>
<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>templates/home/css/bootstrap-combined.min.css" />
<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
<script src="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>templates/home/js/bootstrap-tree.js"></script>

<div class="container">
  <div class="row">
    <?php $this->load->view('home/common/left'); ?>
    <div class="col-lg-9 col-md-9 col-sm-8">
          <div class="tile_modules tile_modules_blue">
           <?php if($this->uri->segment(3) > 0){
					echo 'Cây hệ thống của '.$rootUser->use_username;
				 }else{
					echo 'Cây hệ thống của '.$rootUser->use_username;
				 } ?>
           </div>
           <div class="tool_more"><a href="<?php echo base_url(); ?>account/treelist<?php if($this->uri->segment(3) > 0){ echo "/".$this->uri->segment(3);} ?>"><i class="fa fa-list"></i> Xem dạng danh sách</a></div>
            <div id="treesystem">
              <div class="row-fluid">
                <section id="demonstration" role="main" class="span12">
                  <div class="tree well">
                  <?php
					//showTree();

					if($htmlTree == ''){
						echo 'Không có thành viên nào!';
					}else{
						echo $htmlTree;
					}
					?>




                  <?php				  
				   function showTree($userid){
				  	$tree = '';
				  	$tree .=
                    '<ul>';
					$tree .= '
                      <li> <span><i class="icon-folder-open"></i> Parent</span> <a href="">Goes somewhere</a>
                        <ul>
                          <li> <span><i class="icon-minus-sign"></i> Child</span> <a href="">Goes somewhere</a>
                            <ul>
                              <li> <span><i class="icon-leaf"></i> Grand Child</span> <a href="">Goes somewhere</a> </li>
                            </ul>
                          </li>
                          <li> <span><i class="icon-minus-sign"></i> Child</span> <a href="">Goes somewhere</a>
                            <ul>
                              <li> <span><i class="icon-leaf"></i> Grand Child</span> <a href="">Goes somewhere</a> </li>
                              <li> <span><i class="icon-minus-sign"></i> Grand Child</span> <a href="">Goes somewhere</a>
                                <ul>
                                  <li> <span><i class="icon-minus-sign"></i> Great Grand Child</span> <a href="">Goes somewhere</a>
                                    <ul>
                                      <li> <span><i class="icon-leaf"></i> Great great Grand Child</span> <a href="">Goes somewhere</a> </li>
                                      <li> <span><i class="icon-leaf"></i> Great great Grand Child</span> <a href="">Goes somewhere</a> </li>
                                    </ul>
                                  </li>
                                  <li> <span><i class="icon-leaf"></i> Great Grand Child</span> <a href="">Goes somewhere</a> </li>
                                  <li> <span><i class="icon-leaf"></i> Great Grand Child</span> <a href="">Goes somewhere</a> </li>
                                </ul>
                              </li>
                              <li> <span><i class="icon-leaf"></i> Grand Child</span> <a href="">Goes somewhere</a> </li>
                            </ul>
                          </li>
                        </ul>
                      </li>
                      <li> <span><i class="icon-folder-open"></i> Parent2</span> <a href="">Goes somewhere</a>
                        <ul>
                          <li> <span><i class="icon-leaf"></i> Child</span> <a href="">Goes somewhere</a> </li>
                        </ul>
                      </li>';
					$tree .= '</ul>';
					echo $tree;
					} ?>


                  </div>
                </section>
              </div>
            </div>

    </div>
    <!--BEGIN: RIGHT-->
  </div>
</div>
<!--END RIGHT-->
<?php $this->load->view('home/common/footer'); ?>
