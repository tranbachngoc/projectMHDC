<?php
class Statistics extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        #BEGIN: CHECK LOGIN
        if(!$this->check->is_logined($this->session->userdata('sessionUserAdmin'), $this->session->userdata('sessionGroupAdmin')))
        {
            redirect(base_url().'administ', 'location');
            die();
        }
        #END CHECK LOGIN
        #Load language
        $this->lang->load('admin/common');
        $this->lang->load('admin/menu');
        
        $this->load->library('utilSlv');
        $this->util = new utilSlv();
        
        $this->load->model('statistics_model');
    }
    
    public function index(){
        redirect(base_url().'administ', 'location');
    }
    
    public function services(){ 
        //tổng doanh thu dịch vụ
        #BEGIN: CHECK PERMISSION
        if (!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'services_view')) {
            show_error($this->lang->line('unallowed_use_permission'));
            die();
        }
            $q = isset($_REQUEST['q']) ? trim($_REQUEST['q']) : '';
        #END CHECK PERMISSION
        $data['page'] = array(
            'title' => 'Thống kê tổng doanh thu dịch vụ'
        );
        
        if($this->input->post('search')){
            $date_range         = explode("_", $this->input->post('date_range'));
            $begin_date         = $date_range[0];
            $end_date           = $date_range[1];
            $data['daterange'] = $this->input->post('daterange');
        } else {
            //mặc định cách 1 tuần
            $begin_date     = date("Y-m-d",strtotime("-1 week"));
            $end_date       = date("Y-m-d");
        }
        //day
        $getSumPackageUserStatistics                = $this->statistics_model->getSumPackageUserStatistics($begin_date.' 00:00:00',$end_date.' 23:59:59');
        $getSumPackageDailyUserStatistics           = $this->statistics_model->getSumPackageDailyUserStatistics($begin_date.' 00:00:00',$end_date.' 23:59:59');
        //month
        $getSumPackageUserStatisticsMonth           = $this->statistics_model->getSumPackageUserStatistics(NULL,NULL,'month');
        $getSumPackageDailyUserStatisticsMonth      = $this->statistics_model->getSumPackageDailyUserStatistics(NULL,NULL,'month');
        //year
        $getSumPackageUserStatisticsYear            = $this->statistics_model->getSumPackageUserStatistics(NULL,NULL,'year');
        $getSumPackageDailyUserStatisticsYear       = $this->statistics_model->getSumPackageDailyUserStatistics(NULL,NULL,'year');
        
        $services_day = array();
        //day
        foreach($this->util->getDatesFromRange($begin_date,$end_date) as $vals){
            if($getSumPackageUserStatistics[$vals]){
                $pkUser = $getSumPackageUserStatistics[$vals];
            } else {
                $pkUser = 0;
            }
            
            if($getSumPackageDailyUserStatistics[$vals]){
                $pkDailyUser = $getSumPackageDailyUserStatistics[$vals];
            } else {
                $pkDailyUser = 0;
            }
            
            $amount = $pkUser + $pkDailyUser;
            $services_day['dayx'] .= '["'.date("d-m-Y",strtotime($vals)).'", '.$amount.', "color: #ff9800"],';
        }
        //month -2016
		$months = array(7,8,9,10,11,12);
        foreach($months as $valsM){
            if($getSumPackageUserStatisticsMonth[$valsM]){
                $pkUserM = $getSumPackageUserStatisticsMonth[$valsM];
            } else {
                $pkUserM = 0;
            }
           
            if($getSumPackageDailyUserStatisticsMonth[$valsM]){
                $pkDailyUserM = $getSumPackageDailyUserStatisticsMonth[$valsM];
            } else {
                $pkDailyUserM = 0;
            }
            
            $amountM = $pkUserM + $pkDailyUserM;
			$amountM_Azibai = ($pkUserM-($pkUserM*30/100)) + ($pkDailyUserM - $pkDailyUserM*30/100);
            $services_day['monthx16'] .= '["Tháng '.$valsM.' 2016", '.$amountM.', "color: #0098c6"],';
			$services_day['monthx16Azibai'] .= '["Tháng '.$valsM.' 2016", '.$amountM_Azibai.', "color: #0098c6"],';
        }
		
		// - month 2017
		$current_month = date("m",time());
		$total_A =0;
		for($i=1;$i<=$current_month;$i++){
			
			if($getSumPackageUserStatisticsMonth[$i]){
                $pkUserM = $getSumPackageUserStatisticsMonth[$i];
            } else {
                $pkUserM = 0;
            }
            
            if($getSumPackageDailyUserStatisticsMonth[$i]){
                $pkDailyUserM = $getSumPackageDailyUserStatisticsMonth[$i];
            } else {
                $pkDailyUserM = 0;
            }
            
            $amountM = $pkUserM + $pkDailyUserM;
			$amountM_Azibai = ($pkUserM-($pkUserM*30/100)) + ($pkDailyUserM - $pkDailyUserM*30/100);
            $services_day['monthx'] .= '["Tháng '.$i.' 2017", '.$amountM.', "color: #ff5d00"],';
			$services_day['monthxAzibai'] .= '["Tháng '.$i.' 2017", '.$amountM_Azibai.', "color: #ff5d00"],';
			
		}	
		
        //year
        foreach($this->util->getYearFromRange(date("Y",time())) as $valsY){
            if($getSumPackageUserStatisticsYear[$valsY]){
                $pkUserY = $getSumPackageUserStatisticsMonth[$valsY];
            } else {
                $pkUserY = 0;
            }
            
            if($getSumPackageDailyUserStatisticsYear[$valsY]){
                $pkDailyUserY = $getSumPackageDailyUserStatisticsYear[$valsY];
            } else {
                $pkDailyUserY = 0;
            }
            
            $amountY = $pkUserY + $pkDailyUserY;
            $services_day['yearx'] .= '["'.$valsY.'", '.$amountY.', "color: gray"],';
        }
        
        $data['service_charts']         =   $this->load->view('admin/statistics/service_charts', $services_day, true);  
        $this->load->view('admin/statistics/services', $data);
    }
    
	public function affiliates(){
		
		 $data['page'] = array(
            'title' => 'Thống kê tổng số thành viên'
        );
		  
		 $getSumAffiliateUserStatistics           = 	$this->statistics_model->getSumAffiliateStatistics(strtotime("01-01-2016"),strtotime("01-01-2017"),2);
		 $getSumAffiliateUserStatisticsN           = 	$this->statistics_model->getSumAffiliateStatistics(strtotime("01-01-2017"),strtotime("31-12-2017"),2);
		 $getSumStoreUserStatistics           	= 	$this->statistics_model->getSumAffiliateStatistics(strtotime("01-01-2016"),strtotime("01-01-2017"),3);
		 $getSumStoreUserStatisticsN           	= 	$this->statistics_model->getSumAffiliateStatistics(strtotime("31-12-2016"),strtotime("31-12-2017"),3); 
		
	    for($i=7;$i<=12;$i++){
			
			if($getSumAffiliateUserStatistics[$i]){
                $Total_Aff = $getSumAffiliateUserStatistics[$i];
            } else {
                $Total_Aff = 0;
            }
            
            if($getSumStoreUserStatistics[$i]){
                $Total_Store = $getSumStoreUserStatistics[$i];
            } else {
                $Total_Store = 0;
            }
            $services_day['monthaff16'] .= '["Tháng '.$i.' 2016", '.$Total_Aff.', "color: #ff5c00"],';
			$services_day['monthstore16'] .= '["Tháng '.$i.' 2016", '.$Total_Store.', "color: #ff5c00;"],';   	    
		}	
		
		$current_month = date("m",time());
		
		for($i=1;$i<=$current_month;$i++){
			
			if($getSumAffiliateUserStatisticsN[$i]){
                $Total_Aff = $getSumAffiliateUserStatisticsN[$i];
            } else {
                $Total_Aff = 0;
            }
            
            if($getSumStoreUserStatisticsN[$i]){
                $Total_Store = $getSumStoreUserStatisticsN[$i];
            } else {
                $Total_Store = 0;
            }
            $services_day['monthaff17'] .= '["Tháng '.$i.' 2017", '.$Total_Aff.', "color: gray"],';
			$services_day['monthstore17'] .= '["Tháng '.$i.' 2017", '.$Total_Store.', "color: gray"],';   	    
		}	
		
		$data['service_charts']         =   $this->load->view('admin/statistics/affiliates', $services_day, true);  
        $this->load->view('admin/statistics/services', $data);
		
	}	
    public function totalorders(){
        //tổng số lượng đơn hàng
        #BEGIN: CHECK PERMISSION
        if (!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'order_view')) {
            show_error($this->lang->line('unallowed_use_permission'));
            die();
        }
            $q = isset($_REQUEST['q']) ? trim($_REQUEST['q']) : '';
        #END CHECK PERMISSION
        $data['page'] = array(
            'title' => 'Thống kê tổng số lượng đơn hàng'
        );
        $services_day = array();
        if($this->input->post('search')){
            $date_range         = explode("_", $this->input->post('date_range'));
            $begin_date         = $date_range[0];
            $end_date           = $date_range[1];
            $data['daterange'] = $this->input->post('daterange');
        } else {
            //mặc định cách 1 tuần
            $begin_date     = date("Y-m-d",strtotime("-1 week"));
            $end_date       = date("Y-m-d");
        }

        $monthx             =   $this->statistics_model->getQuantityOrderStatisticsMonth(strtotime('01-07-2016'),strtotime('31-12-2016'),'month',0);
		$monthxN             =   $this->statistics_model->getQuantityOrderStatisticsMonth(strtotime('01-01-2017'),strtotime('31-12-2017'),'month',0);
		$monthxCoupon             =   $this->statistics_model->getQuantityOrderStatisticsMonth(strtotime('01-07-2016'),strtotime('31-12-2016'),'month',2);
		$monthxNCoupon            =   $this->statistics_model->getQuantityOrderStatisticsMonth(strtotime('01-01-2017'),strtotime('31-12-2017'),'month',2);
         
        foreach($this->util->getDatesFromRange($begin_date,$end_date) as $vals){
            if($dayx[$vals]){
                $amountD = $dayx[$vals];
            } else {
                $amountD = 0;
            }
            $services_day['dayx'] .= '["'.date("d-m-Y",strtotime($vals)).'", '.$amountD.', "color: gray"],';
        }
        //month 2016
		$months = array(7,8,9,10,11,12);
        foreach($months as $valsM){
            if($monthx[$valsM]){
                $amountM = $monthx[$valsM];
            } else {
                $amountM = 0;
            }
            if($monthxCoupon[$valsM]){
                $amountMCoupon = $monthxCoupon[$valsM];
            } else {
                $amountMCoupon = 0;
            }
            $services_day['monthx16'] .= '["Tháng '.$valsM.' 2016", '.$amountM.', "color: #0098c6"],';
			$services_day['monthx16Coupon'] .= '["Tháng '.$valsM.' 2016", '.$amountMCoupon.', "color: #0098c6"],';
        }
		
		$current_month = date("m",time());
		
		for($i=1;$i<=$current_month;$i++){
			
			if($monthxN[$i]){
                $amountM = $monthxN[$i];
            } else {
                $amountM = 0;
            }
            if($monthxNCoupon[$i]){
                $amountMCoupon = $monthxNCoupon[$i];
            } else {
                $amountMCoupon = 0;
            }
            $services_day['monthx17'] .= '["Tháng '.$i.' 2017", '.$amountM.', "color: #ff5d00"],';
			$services_day['monthx17Coupon'] .= '["Tháng '.$i.' 2017", '.$amountMCoupon.', "color: #ff5d00"],';
        }
        //year
        foreach($this->util->getYearFromRange(date("Y",time())) as $valsY){
            if($yearx[$valsY]){
                $amountY = $yearx[$valsY];
            } else {
                $amountY = 0;
            }
            
            $services_day['yearx'] .= '["'.$valsY.'", '.$amountY.', "color: gray"],';
        }
        
        $data['service_charts']     =   $this->load->view('admin/statistics/quantityOrder_charts', $services_day, true);  
        $this->load->view('admin/statistics/services', $data);
    }
    
    public function orders(){
        //tổng doanh thu đơn hàng
        #BEGIN: CHECK PERMISSION
        if (!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'quantityOrder_view')) {
            show_error($this->lang->line('unallowed_use_permission'));
            die();
        }
            $q = isset($_REQUEST['q']) ? trim($_REQUEST['q']) : '';
        #END CHECK PERMISSION
        $data['page'] = array(
            'title' => 'Thống kê tổng doanh thu đơn hàng'
        );
       /* 
        if($this->input->post('search')){
            $date_range         = explode("_", $this->input->post('date_range'));
            $begin_date         = $date_range[0];
            $end_date           = $date_range[1];
            $data['daterange']  = $this->input->post('daterange');
        } else {
            //mặc định cách 1 tuần
            $begin_date     = date("Y-m-d",strtotime("-1 week"));
            $end_date       = date("Y-m-d");
        }
        */
        $monthx           =   $this->statistics_model->getOrdersStatisticsMonth(strtotime('01-07-2016'),strtotime('31-12-2016'),'month',0);
        $monthxN           =   $this->statistics_model->getOrdersStatisticsMonth(strtotime('01-01-2017'),strtotime('31-12-2017'),'month',0);
        $monthxCoupon     =   $this->statistics_model->getOrdersStatisticsMonth(strtotime('01-07-2016'),strtotime('31-12-2016'),'month',2);
        $monthxNCoupon     =   $this->statistics_model->getOrdersStatisticsMonth(strtotime('01-01-2017'),strtotime('31-12-2017'),'month',2);
		
        foreach($this->util->getDatesFromRange($begin_date,$end_date) as $vals){
            if($dayx[$vals]){
                $amountD = $dayx[$vals];
            } else {
                $amountD = 0;
            }
            $services_day['dayx'] .= '["'.date("d-m-Y",strtotime($vals)).'", '.$amountD.', "color: gray"],';
        }
        $months = array(7,8,9,10,11,12);
        foreach($months as $valsM){
            if($monthx[$valsM]){
                $amountM = $monthx[$valsM];
            } else {
                $amountM = 0;
            }
            if($monthxCoupon[$valsM]){
                $amountMCoupon = $monthxCoupon[$valsM];
            } else {
                $amountMCoupon = 0;
            }
            $services_day['monthx16'] .= '["Tháng '.$valsM.' 2016", '.$amountM.', "color: #0098c6"],';
			$services_day['monthx16Coupon'] .= '["Tháng '.$valsM.' 2016", '.$amountMCoupon.', "color: #0098c6"],';
        }
		
		$current_month = date("m",time());
		
		for($i=1;$i<=$current_month;$i++){
			
			if($monthxN[$i]){
                $amountM = $monthxN[$i];
            } else {
                $amountM = 0;
            }
            if($monthxNCoupon[$i]){
                $amountMCoupon = $monthxNCoupon[$i];
            } else {
                $amountMCoupon = 0;
            }
            $services_day['monthx17'] .= '["Tháng '.$i.' 2017", '.$amountM.', "color: #ff5d00"],';
			$services_day['monthx17Coupon'] .= '["Tháng '.$i.' 2017", '.$amountMCoupon.', "color: #ff5d00"],';
        }
        //year
        foreach($this->util->getYearFromRange(date("Y",time())) as $valsY){
            if($yearx[$valsY]){
                $amountY = $yearx[$valsY];
            } else {
                $amountY = 0;
            }
            
            $services_day['yearx'] .= '["'.$valsY.'", '.$amountY.', "color: gray"],';
        }

        $data['service_charts']     =   $this->load->view('admin/statistics/order_charts', $services_day, true);  
        $this->load->view('admin/statistics/services', $data);
    }
}