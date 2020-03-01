<?php $this->load->view('home/common/account/header'); ?>
<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>templates/home/css/bootstrap-combined.min.css" />
<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
<script src="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>templates/home/js/bootstrap-tree.js"></script>
<div class="container">
  <div class="row">
    <?php $this->load->view('home/common/left'); ?>
    <div class="col-lg-9 col-md-9 col-sm-8">
      <table class="table table-bordered"  width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td><div class="tile_modules tile_modules_blue"> Cây hệ thống </div>
            <div id="treesystem">
              <div class="row-fluid">
                <section id="demonstration" role="main" class="span12">
                  <div class="tree well">
                    <ul>
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
                      </li>
                    </ul>
                  </div>
                </section>
              </div>
            </div></td>
        </tr>
      </table>
    </div>
    <!--BEGIN: RIGHT--> 
  </div>
</div>
<!--END RIGHT-->
<?php $this->load->view('home/common/footer'); ?>
