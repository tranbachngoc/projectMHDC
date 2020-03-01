<!--BEGIN: RIGHT-->

<div class="col-lg-3 col-md-3 col-sm-3">
    <table style="width: 300px;" border="0" cellpadding="0" cellspacing="0">
    
    <?php if($this->uri->segment(1)=="product") { ?>
        <tr>        
            <td>
            <div style="clear:both; padding-top:10px;">
            </div>
            <?php $this->load->view('home/advertise/category_sanphamphai'); ?>
            </td>
        </tr>
        <?php
		}		
		?>
		<?php if($this->uri->segment(1)=="shop") { ?>
        <tr>        
            <td>
            <div style="clear:both; padding-top:10px;">
            </div>
            <?php $this->load->view('home/advertise/gianhangphai'); ?>
            </td>
        </tr>
        <?php
		}
		else 
		{
		?>        
        <?php if(($this->uri->segment(1)!="hoidap") && ($this->uri->segment(1)!="raovat") ) { ?>
        <?php $this->load->view('home/notify/thongbao'); ?>
        <?php } ?>        
        <?php
		}
		?>        
        <?php if(trim($module) != '' && stristr($module, 'top_saleoff_product')){ ?>
        <?php $this->load->view('home/product/top_saleoff'); ?>
        <?php } ?>        
        <tr>
            <td>
              <?php $this->load->view('home/advertise/right'); ?>
            </td>
        </tr>
        <tr>
            <td>
               <?php //$this->load->view('home/common/rss'); ?>
            </td>
        </tr>
        <?php if(trim($module) != '' && stristr($module, 'top_lastest_product')){ ?>
        <?php $this->load->view('home/product/top_lastest'); ?>
        <?php } ?>
        <?php if(trim($module) != '' && stristr($module, 'top_buyest_product')){ ?>
        <?php $this->load->view('home/product/top_buyest'); ?>
        <?php } ?>
        <?php if(trim($module) != '' && stristr($module, 'top_shop_ads')){ ?>
        <?php $this->load->view('home/raovat/top_shop'); ?>
        <?php } ?>
        <?php if(trim($module) != '' && stristr($module, 'top_lastest_ads')){ ?>
        <?php $this->load->view('home/raovat/top_lastest'); ?>
        <?php } ?>
        <?php if(trim($module) != '' && stristr($module, 'top_view_ads')){ ?>
        <?php $this->load->view('home/raovat/top_view'); ?>
        <?php } ?>
        <?php if(trim($module) != '' && stristr($module, 'top_24h_job')){ ?>
        <?php $this->load->view('home/job/top_24h'); ?>
        <?php } ?>
        <?php if(trim($module) != '' && stristr($module, 'top_24h_employ')){ ?>
        <?php $this->load->view('home/employ/top_24h'); ?>
        <?php } ?>
        <?php if(trim($module) != '' && stristr($module, 'top_saleoff_shop')){ ?>
        <?php $this->load->view('home/shop/top_saleoff'); ?>
        <?php } ?>
        <?php if(trim($module) != '' && stristr($module, 'top_lastest_shop')){ ?>
        <?php $this->load->view('home/shop/top_lastest'); ?>
        <?php } ?>
        <?php if(trim($module) != '' && stristr($module, 'top_productest_shop')){ ?>
        <?php $this->load->view('home/shop/top_productest'); ?>
        <?php } ?>
        
    </table>
</div>
<!--END RIGHT-->