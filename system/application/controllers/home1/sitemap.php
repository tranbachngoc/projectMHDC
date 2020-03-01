<?php
#****************************************#
# * @Author: lehieu008                   #
# * @Email: lehieu008@gmail.com          #
# * @Website: http://www.iscvietnam.net  #
# * @Copyright: 2008 - 2009              #
#****************************************#

class Sitemap extends CI_Controller
{
    function Sitemap()
    {
       parent::__construct();
    }
    
    function index()
    {
        $this->load->model('product_model');
		$this->load->model('ads_model');
		$this->load->model('hds_model');
		$this->load->model('employ_model');
		$this->load->model('job_model');
		$this->load->model('shop_model');
		
		/*$test= "Nội thất phòng ngủ";
		$test = str_replace('ộ','o',$test);
		echo RemoveSign($test);
		for($i=0;$i<strlen($test);$i++){
			echo $test[$i]."==";
		}*/
		
        $this->load->library('sitemaps');
		$currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
		
		//Sitemap Level 1
		$item = array(
                "loc" => base_url(),
                // ISO 8601 format - date("c") requires PHP5
                "lastmod" => date("Y-m-d H:i:s",time()),
                "changefreq" => "always",
                "priority" => "1.0"
            );
            
        $this->sitemaps->add_item($item);
		
		$item = array(
                "loc" => base_url()."raovat",
                // ISO 8601 format - date("c") requires PHP5
                "lastmod" => date("Y-m-d H:i:s",time()),
                "changefreq" => "always",
                "priority" => "1.0"
            );
            
        $this->sitemaps->add_item($item);
		
		$item = array(
                "loc" => base_url()."hoidap",
                // ISO 8601 format - date("c") requires PHP5
                "lastmod" => date("Y-m-d H:i:s",time()),
                "changefreq" => "always",
                "priority" => "1.0"
            );
            
        $this->sitemaps->add_item($item);
		
		$item = array(
                "loc" => base_url()."gianhang",
                // ISO 8601 format - date("c") requires PHP5
                "lastmod" => date("Y-m-d H:i:s",time()),
                "changefreq" => "always",
                "priority" => "1.0"
            );
            
        $this->sitemaps->add_item($item);
		
		$item = array(
                "loc" => base_url()."timviec",
                // ISO 8601 format - date("c") requires PHP5
                "lastmod" => date("Y-m-d H:i:s",time()),
                "changefreq" => "always",
                "priority" => "1.0"
            );
            
        $this->sitemaps->add_item($item);
		
		$item = array(
                "loc" => base_url()."tuyendung",
                // ISO 8601 format - date("c") requires PHP5
                "lastmod" => date("Y-m-d H:i:s",time()),
                "changefreq" => "always",
                "priority" => "1.0"
            );
            
        $this->sitemaps->add_item($item);
		
		$item = array(
                "loc" => base_url()."giamgia",
                // ISO 8601 format - date("c") requires PHP5
                "lastmod" => date("Y-m-d H:i:s",time()),
                "changefreq" => "always",
                "priority" => "1.0"
            );
            
        $this->sitemaps->add_item($item);
		
		$item = array(
                "loc" => base_url()."thongbao/tatca",
                // ISO 8601 format - date("c") requires PHP5
                "lastmod" => date("Y-m-d H:i:s",time()),
                "changefreq" => "always",
                "priority" => "1.0"
            );
            
        $this->sitemaps->add_item($item);
		
		//Sitemap level 2
		$this->load->model('category_model');
		$productcats = $this->category_model->fetch("*","cat_status = 1", "cat_order","DESC");
     	$test= 'Sách, báo, tạp chí';
		echo RemoveSign($test); 
        foreach($productcats AS $productcat)
        {
            $item = array(
                "loc" => base_url().$productcat->cat_id."/".RemoveSign($productcat->cat_name),
                // ISO 8601 format - date("c") requires PHP5
                "lastmod" => date("Y-m-d H:i:s",time()),
                "changefreq" => "always",
                "priority" => "1.0"
            );
			
			echo RemoveSign($productcat->cat_id.$productcat->cat_name);
            
            $this->sitemaps->add_item($item);
        }
		
		die();
		//raovat
		$this->load->model('ads_category_model');
		$raovatcats = $this->ads_category_model->fetch("*","cat_status = 1", "cat_order","DESC");
      
        foreach($raovatcats AS $raovatcat)
        {
            $item = array(
                "loc" => base_url()."raovat/".$raovatcat->cat_id."/".RemoveSign($raovatcat->cat_name),
                // ISO 8601 format - date("c") requires PHP5
                "lastmod" => date("Y-m-d H:i:s",time()),
                "changefreq" => "always",
                "priority" => "1.0"
            );
            
            $this->sitemaps->add_item($item);
        }
		//hoidap
		$this->load->model('hd_category_model');
		$hoidapcats = $this->hd_category_model->fetch("*","cat_status = 1", "cat_order","DESC");
      
        foreach($hoidapcats AS $hoidapcat)
        {
            $item = array(
                "loc" => base_url()."hoidap/".$hoidapcat->cat_id."/".RemoveSign($hoidapcat->cat_name),
                // ISO 8601 format - date("c") requires PHP5
                "lastmod" => date("Y-m-d H:i:s",time()),
                "changefreq" => "always",
                "priority" => "1.0"
            );
            
            $this->sitemaps->add_item($item);
        }
		
		//gianhang
		$this->load->model('shop_category_model');
		$gianhangcats = $this->shop_category_model->fetch("*","cat_status = 1", "cat_order","DESC");
      
        foreach($gianhangcats AS $gianhangcat)
        {
            $item = array(
                "loc" => base_url()."gianhang/".$gianhangcat->cat_id."/".RemoveSign($gianhangcat->cat_name),
                // ISO 8601 format - date("c") requires PHP5
                "lastmod" => date("Y-m-d H:i:s",time()),
                "changefreq" => "always",
                "priority" => "1.0"
            );
            
            $this->sitemaps->add_item($item);
        }
		
		//timviec
		$this->load->model('field_model');
		$timvieccats = $this->field_model->fetch("*","fie_status  = 1", "fie_order","DESC");
      
        foreach($timvieccats AS $timvieccat)
        {
            $item = array(
                "loc" => base_url()."timviec/".$timvieccat->fie_id."/".RemoveSign($timvieccat->fie_name),
                // ISO 8601 format - date("c") requires PHP5
                "lastmod" => date("Y-m-d H:i:s",time()),
                "changefreq" => "always",
                "priority" => "1.0"
            );
            
            $this->sitemaps->add_item($item);
        }
		
		
		//tuyendung
		$this->load->model('field_model');
		$tuyendungcats = $this->field_model->fetch("*","fie_status  = 1", "fie_order","DESC");
      
        foreach($tuyendungcats AS $tuyendungcat)
        {
            $item = array(
                "loc" => base_url()."tuyendung/".$tuyendungcat->fie_id."/".RemoveSign($tuyendungcat->fie_name),
                // ISO 8601 format - date("c") requires PHP5
                "lastmod" => date("Y-m-d H:i:s",time()),
                "changefreq" => "always",
                "priority" => "1.0"
            );
            
            $this->sitemaps->add_item($item);
        }
		
		//thongbao		
		$this->load->model('notify_model');
		$thongbaos = $this->notify_model->fetch("*","not_status = 1", "not_id","DESC");
        foreach($thongbaos AS $thongbao)
        {
            $item = array(
                "loc" => base_url()."thongbao/".$thongbao->not_id."/".RemoveSign($thongbao->not_title),
                // ISO 8601 format - date("c") requires PHP5
                "lastmod" => date("Y-m-d H:i:s",$thongbao->not_begindate),
                "changefreq" => "always",
                "priority" => "0.5"
            );
            
            $this->sitemaps->add_item($item);
        }
		
		
		//Sitemap Level 3        
        $products = $this->product_model->fetch_join("*","INNER","tbtt_shop","tbtt_product.pro_user = tbtt_shop.sho_user", "", "", "", "", "", "", "pro_status = 1 AND sho_status = 1", "up_date","DESC");
      
        foreach($products AS $product)
        {
            $item = array(
                "loc" => base_url().$product->pro_category."/".$product->pro_id."/".RemoveSign($product->pro_name),
                // ISO 8601 format - date("c") requires PHP5
                "lastmod" => $product->up_date,
                "changefreq" => "always",
                "priority" => "0.8"
            );
            
            $this->sitemaps->add_item($item);
        }
		
		$raovats = $this->ads_model->fetch("*", "ads_status = 1 AND ads_enddate >= $currentDate", "ads_id", "DESC");
      
        foreach($raovats AS $raovat)
        {
            $item = array(
                "loc" => base_url()."raovat/".$raovat->ads_category."/".$raovat->ads_id."/".RemoveSign($raovat->ads_title),
                // ISO 8601 format - date("c") requires PHP5
                "lastmod" => $raovat->up_date,
                "changefreq" => "always",
                "priority" => "0.8"
            );
            
            $this->sitemaps->add_item($item);
        }
		
		$hoidaps = $this->hds_model->fetch("*", "hds_status = 1", "hds_id", "DESC");
      
        foreach($hoidaps AS $hoidap)
        {
            $item = array(
                "loc" => base_url()."hoidap/".$hoidap->hds_category."/".$hoidap->hds_id."/".RemoveSign($hoidap->hds_title),
                // ISO 8601 format - date("c") requires PHP5
                "lastmod" => $hoidap->up_date,
                "changefreq" => "always",
                "priority" => "0.8"
            );
            
            $this->sitemaps->add_item($item);
        }
		
		$timviecs = $this->employ_model->fetch("*", "emp_status = 1 AND emp_enddate >= $currentDate", "emp_id", "DESC");
      
        foreach($timviecs AS $timviec)
        {
            $item = array(
                "loc" => base_url()."timviec/".$timviec->emp_field."/".$timviec->emp_id."/".RemoveSign($timviec->emp_title),
                // ISO 8601 format - date("c") requires PHP5
                "lastmod" => date("Y-m-d H:i",$timviec->emp_begindate),
                "changefreq" => "always",
                "priority" => "0.8"
            );
            
            $this->sitemaps->add_item($item);
        }
		
		$tuyendungs = $this->job_model->fetch("*", "job_status = 1 AND job_enddate >= $currentDate", "job_id", "DESC");
      
        foreach($tuyendungs AS $tuyendung)
        {
            $item = array(
                "loc" => base_url()."timviec/".$tuyendung->job_field."/".$tuyendung->job_id."/".RemoveSign($tuyendung->job_title),
                // ISO 8601 format - date("c") requires PHP5
                "lastmod" => date("Y-m-d H:i",$tuyendung->job_begindate),
                "changefreq" => "always",
                "priority" => "0.8"
            );
            
            $this->sitemaps->add_item($item);
        }
		
		$gianhangs = $this->shop_model->fetch("*", "sho_status = 1 AND sho_enddate >= $currentDate", "sho_id", "DESC");
      
        foreach($gianhangs AS $gianhang)
        {
            $item = array(
                "loc" => base_url()."gianhang/".$gianhang->sho_link,
                // ISO 8601 format - date("c") requires PHP5
                "lastmod" => date("Y-m-d H:i",$gianhang->sho_begindate),
                "changefreq" => "never",
                "priority" => "0.8"
            );
            
            $this->sitemaps->add_item($item);
        }
        
        
        // file name may change due to compression
        $file_name = $this->sitemaps->build("sitemap.xml");

        $reponses = $this->sitemaps->ping(base_url().$file_name);
        
        // Debug by printing out the requests and status code responses
        // print_r($reponses);

        redirect(base_url().$file_name);
    }
}