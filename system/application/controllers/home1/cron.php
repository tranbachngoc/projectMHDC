<?php
/*error_reporting(E_ALL);
ini_set('display_errors', 1);
*/
class Cron extends MY_Controller {

    public $month_year = '';

    function __construct()
    {
        parent::__construct();
        //$this->month_year = date("m-Y",strtotime("-1 months"));
        $this->month_year = date("m-Y",strtotime("-1 months"));       
        // this controller can only be called from the command line
        //if (!$this->input->is_cli_request()) show_error('Direct access is not allowed');
    }

    public function message($to = 'World')
    {
        echo "Hello {$to}!".PHP_EOL;                
    }

    /**
     ***************************************************************************
     * Created: 2018/08/14
     * Backup Database to local
     ***************************************************************************
     * @author: Duc<nguyenvietduckt82@gmail.com>
     * @return: Write file .sql to folder backup
     *  
     ***************************************************************************
    */

    public function backupDatabase($key = '')
    {
        //cronjobbackup
        // Check key
        $public_key = '$2a$08$TjMTkcQpbrG6GrYs8ce6S.XA.9lP3C7kwZJaDYS8RZsanwvet/8ie';
        $this->load->library('bcrypt');
        if(! $this->bcrypt->check_password($key, $public_key)){
            echo 'Access is denied'; exit();
        }

        // Create FTP
        $this->load->library('ftp');
        $config['hostname'] = IP_CLOUDSERVER;
        $config['username'] = USER_CLOUDSERVER;
        $config['password'] = PASS_CLOUDSERVER;
        $config['port']     = PORT_CLOUDSERVER;                
        $config['debug']    = FALSE;
        $this->ftp->connect($config);
        $path = '/public_html/';
        $ldir = $this->ftp->list_files($path);

        // Create folder if not exist
        $month = date('m');
        $dir = 'db_backup/'.$month.'/';
        if(! in_array($dir,$ldir)){
            $this->ftp->mkdir($path.$dir, 0775);
        }

        // Remove backup if greater than 2 months
        $current_day = new DateTime();
        $current_day->modify('-2 month');        

        $sOldMonthServer = $current_day->format('m');

        $ldirold = $this->ftp->list_files('/public_html/db_backup/');
        if(in_array($sOldMonthServer,$ldirold)){
            foreach ($this->ftp->list_files('/public_html/db_backup/'.$sOldMonthServer) as $item) {
                $this->ftp->delete_file('/public_html/db_backup/'.$sOldMonthServer.'/'.$item);
            }
            $this->ftp->delete_dir('/public_html/db_backup/'.$sOldMonthServer);
        }

        $this->load->helper('url');
        $this->load->helper('file');
        $this->load->helper('download');
        $this->load->library('zip');
        $this->load->dbutil();
        $db_format=array('format'=>'zip','filename'=>'my_db_backup.sql');
        $backup=& $this->dbutil->backup($db_format);
        $dbname= 'backup-on-'.date('Y-m-d').'.zip';
        $save= 'db_backup/'.$dbname;
        // Save to local

        write_file($save,$backup);

        // Upload to server
        $this->ftp->upload($save,$path.$dir.$dbname,0755);
        unlink($save);
        echo "Complete!";
        exit();
    }

    /**
    ** *************************************************************************
    * Created: 2018/08/20
    * Update Domain New From Database To File
    ***************************************************************************
    * @author: Bao Tran <tranbaothe@gmail.com>
    * @return: Write file domains.conf to mapping domain own with shop link
    *  
    ***************************************************************************
    **/

    public function updateDomainMapToFile()
    {
        $this->load->model('domains_model');

        $domainNewList = $this->domains_model->fetch('*', 'status = 0');         

        if (count($domainNewList) > 0) {

            $dmList = $this->domains_model->fetch('*', '', 'id', 'ACS');
            
            $_str = '';
            foreach ($dmList as $kdm => $vdm) {
                $_str .= $vdm->domain ." ". $vdm->shoplink .";"."\r\n";
            }

            // Create file domains.conf if don't exist
            $fp = fopen($_SERVER['DOCUMENT_ROOT'] .'/domains.conf','w+') or die("Không thể mở tập tin.");
            
            fwrite($fp, $_str); // Write file

            fclose($fp); // Close file
            /*
            $return = system('nginx -t >/dev/null 2>&1');
            if ($return !== FALSE)) {
                exec('cp '. $_SERVER['DOCUMENT_ROOT'] .'/domains.conf /etc/nginx/domain_maps/');
                exec('service nginx reload');
                $this->domains_model->update(array('status' => 0, 'note' => 'Đã xử lý'), 'status = 0');
            } 
            */
        }
        echo 'success...'; 
        exit();
    }

    function test()
    {
        //$this->recalculate_commission_by_empty_position();
        //echo $this->get_config_solution_commission(12);
        echo date("d m Y H i s",1475254800); die();
        // Bao them test cron
        // $this->load->model('user_model');
        // $this->user_model->update(array('use_email' => 'hoaitrungp@gmail.com123456'), 'use_id = 1336');              
    }

    function commission()
    {
        // make sure we have enough time and memory.
        ini_set('memory_limit', -1);
        ini_set('max_execution_time', 0);
        set_time_limit(0);

        echo "Caculating...";

        // solution revenue
        $this->solution_revenue_dev2();
        $this->solution_revenue_dev1();
        $this->solution_revenue_partner2();
        $this->solution_revenue_partner1();
        $this->solution_revenue_coremember();
        $this->solution_revenue_coreadmin();

        // revenue by category of stores

        $this->revenue_shop_category_type_01();
        $this->revenue_shop_category_type_02();
        $this->revenue_shop_category_type_02_no_member();

        $this->revenue_shop_category_type_04();
        $this->revenue_shop_category_type_05();
        $this->revenue_shop_category_type_05_affiliate();

        // product wholesale sell revenue
        $this->wholesale_sell_product_revenue_dev2();
        $this->wholesale_sell_product_revenue_dev1();
        $this->wholesale_sell_product_revenue_partner2();
        $this->wholesale_sell_product_revenue_partner1();
        $this->wholesale_sell_product_revenue_coremember();
        $this->wholesale_sell_product_revenue_coreadmin();

        // product wholesale buy revenue
        $this->wholesale_buy_product_revenue_dev2();
        $this->wholesale_buy_product_revenue_dev1();
        $this->wholesale_buy_product_revenue_partner2();
        $this->wholesale_buy_product_revenue_partner1();
        $this->wholesale_buy_product_revenue_coremember();
        $this->wholesale_buy_product_revenue_coreadmin();

        // product retail sell revenue
        $this->retail_sell_product_revenue_dev2();
        $this->retail_sell_product_revenue_dev1();
        $this->retail_sell_product_revenue_partner2();
        $this->retail_sell_product_revenue_partner1();
        $this->retail_sell_product_revenue_coremember();
        $this->retail_sell_product_revenue_coreadmin();

        // product retail buy revenue
        $this->retail_buy_product_revenue_dev2();
        $this->retail_buy_product_revenue_dev1();
        $this->retail_buy_product_revenue_partner2();
        $this->retail_buy_product_revenue_partner1();
        $this->retail_buy_product_revenue_coremember();
        $this->retail_buy_product_revenue_coreadmin();

        //$this->retail_buy_product_revenue_store_from_affiliate();        
        // solution commission
        $this->solution_commission_dev2();
        $this->solution_commission_dev1();
        $this->solution_commission_partner2();
        $this->solution_commission_partner1();
        $this->solution_commission_coremember();
        $this->solution_commission_coreadmin();

        // product wholesale sell commission
        $this->wholesale_sell_product_commission_dev2();
        $this->wholesale_sell_product_commission_dev1();
        $this->wholesale_sell_product_commission_partner2();
        $this->wholesale_sell_product_commission_partner1();
        $this->wholesale_sell_product_commission_coremember();
        $this->wholesale_sell_product_commission_coreadmin();

        // product wholesale buy commission
        $this->wholesale_buy_product_commission_dev2();
        $this->wholesale_buy_product_commission_dev1();
        $this->wholesale_buy_product_commission_partner2();
        $this->wholesale_buy_product_commission_partner1();
        $this->wholesale_buy_product_commission_coremember();
        $this->wholesale_buy_product_commission_coreadmin();

        // product retail sell commission
        $this->retail_sell_product_commission_dev2();
        $this->retail_sell_product_commission_dev1();
        $this->retail_sell_product_commission_partner2();
        $this->retail_sell_product_commission_partner1();
        $this->retail_sell_product_commission_coremember();
        $this->retail_sell_product_commission_coreadmin();

        // product retail buy commission
        $this->retail_buy_product_commission_dev2();
        $this->retail_buy_product_commission_dev1();
        $this->retail_buy_product_commission_partner2();
        $this->retail_buy_product_commission_partner1();
        $this->retail_buy_product_commission_coremember();
        $this->retail_buy_product_commission_coreadmin();

        // product retail buy commission for store
        // $this->retail_buy_product_commission_store_from_affiliate();

        // recalculate for empty position
        $this->recalculate_commission_by_empty_position();
        $this->calculate_money_affiliate();

        // calculate commission bonus affiliate
        $this->calculate_commission_bonus_affiliate();

        echo "Complete!";
        exit();
    }

    function money(){
        // ngay 15 hang thang tinh tien cho thanh vien, tru Gian hang, Gian hang thanh toan hang tuan vao thu 4
        $this->load->model('account_model');
        $this->account_model->request_banking();
    }

    function calculate_money_affiliate(){
        if(!$this->checkExistMoneyAffiliate()){
            $this->load->model('showcart_model');
            $arr_start_end_date = $this->get_start_end_date();
            $startMonth = $arr_start_end_date[0];
            $endMonth = $arr_start_end_date[1];
            $q = "SELECT SUM(a.discount) AS amount, af_id, tbtt_user.use_id as user_id, tbtt_user.use_group as group_id, tbtt_user.parent_id FROM (SELECT af_id, CASE WHEN af_amt > 0 THEN af_amt * `shc_quantity` ELSE shc_total * CAST(af_rate AS DECIMAL (10, 5)) / 100 END AS discount FROM `tbtt_showcart` WHERE af_id > 0 AND shc_status = '98' AND shc_change_status_date >= $startMonth AND shc_change_status_date <= $endMonth) AS a INNER JOIN tbtt_user ON tbtt_user.use_id = a.af_id GROUP BY a.af_id";
            $query = $this->db->query($q);
            foreach ($query->result() as $user)
            {
                if($user->amount > 0){
                    $dataMoney = array(
                        'user_id' => $user->user_id,
                        'group_id' => $user->group_id,
                        'parent_id' => $user->parent_id,
                        'amount' => $user->amount,
                        'type' => '06',
                        'description' => 'Tiền hoa hồng Cộng tác viên online',
                        'created_date' => date("Y-m-d H:i:s"),
                        'month_year' => $this->month_year,
                        'status' => 0
                    );
                    $this->persional_money_by_type($dataMoney);
                }

            }
        }
    }

    //tinh hoa hong theo tuan
    function calculate_money_store(){
        $this->calulate_money_store_by_week();
        if(!$this->checkExistMoneyStore()){
            $this->load->model('showcart_model');
            //$arr_start_end_date = $this->get_start_end_date();
            $end = strtotime("now");
            $start = strtotime("-1 week");
            $q = "SELECT SUM(a.total) AS amount, shc_saler, tbtt_user.use_id as user_id, tbtt_user.use_group as group_id, tbtt_user.parent_id FROM (SELECT shc_saler, CASE WHEN af_amt > 0 THEN shc_total - (af_amt * `shc_quantity`) ELSE shc_total - (shc_total * CAST(af_rate AS DECIMAL (10, 5)) / 100 ) END AS total FROM `tbtt_showcart` WHERE shc_status = '98' AND shc_change_status_date >= $start AND shc_change_status_date <= $end) AS a INNER JOIN tbtt_user ON tbtt_user.use_id = a.shc_saler GROUP BY a.shc_saler";            
            $query = $this->db->query($q);
            foreach ($query->result() as $user)
            {
                $p = "SELECT sum(rsc_profit) as total FROM `tbtt_revenue_store_category_weekly` where rsc_created_date_str = '".date("d-m-Y")."' AND rsc_shop_id = ".$user->user_id . " AND rsc_type IN('02','05')";
                $queryp = $this->db->query($p);
                $v_result = $queryp->result();
                $amount =  $user->amount - (int)($v_result[0]->total);
                $dataMoney = array(
                    'user_id' => $user->user_id,
                    'group_id' => $user->group_id,
                    'parent_id' => $user->parent_id,
                    'amount' => $amount,
                    'type' => '07',
                    'description' => 'Tiền Gian hàng bán hàng',
                    'created_date' => date("Y-m-d H:i:s"),
                    'month_year' => date('m-Y'),
                    'status' => 0,
                    'fee_azibai' =>(int)($v_result[0]->total)
                );

                $this->persional_money_by_type($dataMoney);
                log_message("debug","Tiền Gian hàng bán hàng - UserID:".$user->user_id.",Số tiền:".$amount.",Phí trả Azibai:".$v_result[0]->total.",Loại:07,Tháng:".date('m-Y'));
                if($amount > (MinAmountStore)){
                    $data = array();
                    $data['user_id'] = $user->user_id;
                    $data['group_id'] = $user->group_id;
                    $data['parent_id'] = $user->parent_id;
                    $data['amount'] =  0 - $amount;
                    $data['type'] = '00';
                    $data['description'] = 'YCCK';
                    $data['created_date'] = date('Y-m-d H:i:s');
                    $data['month_year'] = date('m-Y');
                    $data['status'] = '1';
                    $data['pay_weekly'] = 1;
                    $this->db->insert('tbtt_money', $data);
                }

            }
            $this->load->model('account_model');
        }
    }

    function isWed($date){
        $isWed = date('D',$date);
        if($isWed == 'Wed'){
            return $date;
        }
        else
        {
            return "";
        }
    }

    function calculate_money_store_custom_weekly(){
        $custom = custome_money_store;
        if($custom){
            $end = strtotime(custome_money_store_end_date);
            $start = strtotime(custome_money_store_start_date);
            $temp = $start;
            for($i = $start; $i <= $end ; $i += 86400){            
                if($this->isWed($i)) {
                    $this->calculate_money_store_custom($temp,$i);
                    $temp = $i;
                }            
            }
        }        
    }

    function calculate_money_store_custom($c_start = "", $c_end = ""){
        $end = strtotime("now");
        $start = strtotime("-1 week");            
        if($c_start != "" && $c_end != ""){
            $end = $c_end;
            $start = $c_start;
        }

        $this->calulate_money_store_by_week_custom($c_start,$c_end);
            $this->load->model('showcart_model');
            //$arr_start_end_date = $this->get_start_end_date();            

            $q = "SELECT SUM(a.total) AS amount, shc_saler, tbtt_user.use_id as user_id, tbtt_user.use_group as group_id, tbtt_user.parent_id FROM (SELECT shc_saler, CASE WHEN af_amt > 0 THEN shc_total - (af_amt * `shc_quantity`) ELSE shc_total - (shc_total * CAST(af_rate AS DECIMAL (10, 5)) / 100 ) END AS total FROM `tbtt_showcart` WHERE shc_status = '98' AND shc_change_status_date >= $start AND shc_change_status_date <= $end) AS a INNER JOIN tbtt_user ON tbtt_user.use_id = a.shc_saler GROUP BY a.shc_saler";
            $query = $this->db->query($q);
            foreach ($query->result() as $user)
            {
                $p = "SELECT sum(rsc_profit) as total FROM `tbtt_revenue_store_category_weekly` where rsc_created_date_str = '".date("d-m-Y",$end)."' AND rsc_shop_id = ".$user->user_id . " AND rsc_type IN('02','05')";
                $queryp = $this->db->query($p);
                $v_result = $queryp->result();
                $amount =  $user->amount - (int)($v_result[0]->total);

                $dataMoney = array(
                    'user_id' => $user->user_id,
                    'group_id' => $user->group_id,
                    'parent_id' => $user->parent_id,
                    'amount' => $amount,
                    'type' => '07',
                    'description' => 'Tiền Gian hàng bán hàng',
                    'created_date' => date("Y-m-d H:i:s",$end),
                    'month_year' => date('m-Y',$end),
                    'status' => 0,
                    'fee_azibai' =>(int)($v_result[0]->total)
                );
                $this->persional_money_by_type($dataMoney);
                log_message("debug","Tiền Gian hàng bán hàng chạy thủ công - UserID:".$user->user_id.",Số tiền:".$amount.",Phí trả Azibai:".$v_result[0]->total.",Loại:07,Tháng:".date('m-Y'));
                if($amount > (MinAmountStore)){
                    $data = array();
                    $data['user_id'] = $user->user_id;
                    $data['group_id'] = $user->group_id;
                    $data['parent_id'] = $user->parent_id;
                    $data['amount'] =  0 - $amount;
                    $data['type'] = '00';
                    $data['description'] = 'YCCK';
                    $data['created_date'] = date('Y-m-d H:i:s',$end);
                    $data['month_year'] = date('m-Y',$end);
                    $data['status'] = '1';
                    $data['pay_weekly'] = 1;
                    $this->db->insert('tbtt_money', $data);
                }

            }
            $this->load->model('account_model');   
    }

    function persional_money_by_type($dataMoney){
        $this->load->model('account_model');
        $money = $this->account_model->add($dataMoney);
        $id = $this->db->insert_id();
        $data = array(
            'money_id'=>$id,
            'status'=>0,
            'created_date'=> date('Y-m-d H:i:s'),
            'note'=>'Thêm tiền'
        );
        $this->db->insert('tbtt_money_logs', $data);
    }

    function revenue_shop_category_type_01(){
        if(!$this->checkExistRevenueStoreByType('01')){
            $this->load->model('revenue_store_category_model');
            $listShopper = $this->get_all_shopper();
            $listCat = array();
            foreach($listShopper as $shopper){
                if(isset($listCat)){
                    reset($listCat);
                }
                $listCat = $this->get_list_category_shopper($shopper->use_id,'01');
                if(count($listCat) > 0){
                    foreach($listCat as $cat){
                        $revenue = $this->revenue_shop_by_category($shopper->use_id, $cat->pro_category,'01');
                        if($revenue > 0){
                            $dataAdd = array(
                                'rsc_shop_id' => $shopper->use_id,
                                'rsc_parent_id' => $shopper->parent_id,
                                'rsc_category_id' => $cat->pro_category,
                                'rsc_revenue' => $revenue,
                                'rsc_percent' => $cat->b2b_em_fee,
                                'rsc_profit' => $revenue * ($cat->b2b_em_fee/100),
                                'rsc_type' => '01',
                                'rsc_description' => 'Hoa hồng mua sỉ',
                                'rsc_created_date' => time(),
                                'rsc_created_date_str' => date("d-m-Y",time()),
                                'rsc_created_month_year' =>  $this->month_year
                            );
                            $revenueCategory = $this->revenue_store_category_model->add($dataAdd);
                        }
                        log_message("debug","Doanh thu Danh mục Mua sỉ - UserID:".$shopper->use_id.",Danh mục:".$cat->pro_category.",Doanh thu:".$revenue.",Phần trăm:".$cat->b2b_em_fee.",Phí Azibai:".$revenue * ($cat->b2b_em_fee/100).",Loại:01,Tháng:".$this->month_year);
                    }
                }

            }
        }
    }

    function revenue_shop_category_type_02(){
        if(!$this->checkExistRevenueStoreByType('02')){
            $this->load->model('revenue_store_category_model');            
            $listShopper = $this->get_all_shopper(); 

            $listCat = array();
            foreach($listShopper as $shopper){
                if(isset($listCat)){
                    reset($listCat);
                }
                //Get percent discount for Shop
                $this->load->model('shop_model');
                $get_percent_discount = $this->shop_model->get("sho_discount_rate","sho_user =". $shopper->use_id);
                if($get_percent_discount != null){
                    $dcs = $get_percent_discount->sho_discount_rate > 0 ? ($get_percent_discount->sho_discount_rate / 100) : 0;
                }else{
                    $dcs = 0;
                }

                $listCat = $this->get_list_category_shopper($shopper->use_id,'02');
                if(count($listCat)>0){
                    foreach($listCat as $cat){
                        $revenue = $this->revenue_shop_by_category($shopper->use_id, $cat->pro_category,'02');
                        if($revenue > 0){
                            $dataAdd = array(
                                'rsc_shop_id' => $shopper->use_id,
                                'rsc_parent_id' => $shopper->parent_id,
                                'rsc_category_id' => $cat->pro_category,
                                'rsc_revenue' => $revenue,
                                'rsc_percent' => $cat->b2b_em_fee,
                                'rsc_profit' => ($revenue * ($cat->b2b_em_fee/100)) - (($revenue * ($cat->b2b_em_fee/100)) * $dcs),
                                'rsc_type' => '02',
                                'rsc_type2' => 1,
                                'rsc_description' => 'Hoa hồng bán sỉ thông qua thành viên gian hàng Azibai',
                                'rsc_created_date' => time(),
                                'rsc_created_date_str' => date("d-m-Y",time()),
                                'rsc_created_month_year' =>  $this->month_year
                            );
                            $revenueCategory = $this->revenue_store_category_model->add($dataAdd);
                        }
                        log_message("debug","Doanh thu Danh mục Bán sỉ - UserID:".$shopper->use_id.",Danh mục:".$cat->pro_category.",Doanh thu:".$revenue.",Phần trăm:".$cat->b2b_em_fee.",Phí Azibai:".$revenue * ($cat->b2b_em_fee/100).",Loại:02,Tháng:".$this->month_year);
                    }
                }
            }
        }
    }

    function revenue_shop_category_type_02_no_member(){
        if(!$this->checkExistRevenueStoreByType('02')){
            $this->load->model('revenue_store_category_model');
            $listShopper = $this->get_all_shopper();
            $listCat = array();
            foreach($listShopper as $shopper){
                if(isset($listCat)){
                    reset($listCat);
                }
                //Get percent discount for Shop
                $this->load->model('shop_model');
                $get_percent_discount = $this->shop_model->get("sho_discount_rate","sho_user =". $shopper->use_id);
                if($get_percent_discount != null){
                    $dcs = $get_percent_discount->sho_discount_rate > 0 ? ($get_percent_discount->sho_discount_rate / 100) : 0;
                }else{
                    $dcs = 0;
                }

                $listCat = $this->get_list_category_shopper($shopper->use_id,'02_no_member');
                if(count($listCat)>0){
                    foreach($listCat as $cat){
                        $revenue = $this->revenue_shop_by_category($shopper->use_id, $cat->pro_category,'02_no_member');
                        if($revenue > 0){
                            $dataAdd = array(
                                'rsc_shop_id' => $shopper->use_id,
                                'rsc_parent_id' => $shopper->parent_id,
                                'rsc_category_id' => $cat->pro_category,
                                'rsc_revenue' => $revenue,
                                'rsc_percent' => $cat->b2b_fee,
                                'rsc_profit' => ($revenue * ($cat->b2b_fee/100)) - (($revenue * ($cat->b2b_fee/100)) * $dcs),
                                'rsc_type' => '02',
                                'rsc_type2' => 0,
                                'rsc_description' => 'Hoa hồng bán sỉ không qua thành viên gian hàng Azibai',
                                'rsc_created_date' => time(),
                                'rsc_created_date_str' => date("d-m-Y",time()),
                                'rsc_created_month_year' =>  $this->month_year
                            );
                            $revenueCategory = $this->revenue_store_category_model->add($dataAdd);
                        }

                        log_message("debug","Doanh thu Danh mục Bán sỉ ngoài - UserID:".$shopper->use_id.",Danh mục:".$cat->pro_category.",Doanh thu:".$revenue.",Phần trăm:".$cat->b2b_fee.",Phí Azibai:".$revenue * ($cat->b2b_fee/100).",Loại:02_no_member,Tháng:".$this->month_year);
                    }
                }
            }
        }
    }

    function revenue_shop_category_type_04(){
        if(!$this->checkExistRevenueStoreByType('04')){
            $this->load->model('revenue_store_category_model');
            // danh sach affiliate
            $listShopper = $this->get_all_affiliate();
            $listCat = array();
            foreach($listShopper as $shopper){
                if(isset($listCat)){
                    reset($listCat);
                }
                $listCat = $this->get_list_category_shopper($shopper->use_id,'04');
                if(count($listCat)>0){
                    foreach($listCat as $cat){
                        $revenue = $this->revenue_shop_by_category($shopper->use_id, $cat->pro_category,'04');
                        if($revenue > 0){
                            $dataAdd = array(
                                'rsc_shop_id' => $shopper->use_id,
                                'rsc_parent_id' => $shopper->parent_id,
                                'rsc_category_id' => $cat->pro_category,
                                'rsc_revenue' => $revenue,
                                'rsc_percent' => $cat->b2c_fee,
                                'rsc_profit' => $revenue * ($cat->b2c_fee/100),
                                'rsc_type' => '04',
                                'rsc_description' => 'Hoa hồng mua lẻ thông qua Cộng tác viên online',
                                'rsc_created_date' => time(),
                                'rsc_created_date_str' => date("d-m-Y",time()),
                                'rsc_created_month_year' =>  $this->month_year
                            );
                            $revenueCategory = $this->revenue_store_category_model->add($dataAdd);
                        }
                        log_message("debug","Doanh thu Danh mục Mua lẻ - UserID:".$shopper->use_id.",Danh mục:".$cat->pro_category.",Doanh thu:".$revenue.",Phần trăm:".$cat->b2c_fee.",Phí Azibai:".$revenue * ($cat->b2c_fee/100).",Loại:04,Tháng:".$this->month_year);
                    }
                }
            }
        }
    }

    function revenue_shop_category_type_05(){
        if(!$this->checkExistRevenueStoreByType('05')){
            $this->load->model('revenue_store_category_model');
            $listShopper = $this->get_all_shopper();
            $listCat = array();
            foreach($listShopper as $shopper){
                if(isset($listCat)){
                    reset($listCat);
                }
                //Get percent discount for Shop
                $this->load->model('shop_model');
                $get_percent_discount = $this->shop_model->get("sho_discount_rate","sho_user =". $shopper->use_id);
                if($get_percent_discount != null){
                    $dcs = $get_percent_discount->sho_discount_rate > 0 ? ($get_percent_discount->sho_discount_rate / 100) : 0;
                }else{
                    $dcs = 0;
                }

                $listCat = $this->get_list_category_shopper($shopper->use_id,'05');
                if(count($listCat)>0){
                    foreach($listCat as $cat){
                        $revenue = $this->revenue_shop_by_category($shopper->use_id, $cat->pro_category,'05');
                        if($revenue > 0){
                            $dataAdd = array(
                                'rsc_shop_id' => $shopper->use_id,
                                'rsc_parent_id' => $shopper->parent_id,
                                'rsc_category_id' => $cat->pro_category,
                                'rsc_revenue' => $revenue,
                                'rsc_percent' => $cat->b2c_fee,
                                'rsc_profit' => ($revenue * ($cat->b2c_fee/100)) - (($revenue * ($cat->b2c_fee/100)) * $dcs),
                                'rsc_type' => '05',
                                'rsc_type2' => 0,
                                'rsc_description' => 'Hoa hồng bán lẻ không có Cộng tác viên online',
                                'rsc_created_date' => time(),
                                'rsc_created_date_str' => date("d-m-Y",time()),
                                'rsc_created_month_year' =>  $this->month_year
                            );
                            $revenueCategory = $this->revenue_store_category_model->add($dataAdd);
                        }
                        log_message("debug","Doanh thu Danh mục Bán lẻ - UserID:".$shopper->use_id.",Danh mục:".$cat->pro_category.",Doanh thu:".$revenue.",Phần trăm:".$cat->b2c_fee.",Phí Azibai:".$revenue * ($cat->b2c_fee/100).",Loại:05,Tháng:".$this->month_year);
                    }
                }
            }
        }
    }

    function revenue_shop_category_type_05_affiliate(){
        if(!$this->checkExistRevenueStoreByType('05',1)){
            $this->load->model('revenue_store_category_model');
            $listShopper = $this->get_all_shopper();
            $listCat = array();
            foreach($listShopper as $shopper){
                if(isset($listCat)){
                    reset($listCat);
                }
                //Get percent discount for Shop
                $this->load->model('shop_model');
                $get_percent_discount = $this->shop_model->get("sho_discount_rate","sho_user =". $shopper->use_id);
                if($get_percent_discount != null){
                    $dcs = $get_percent_discount->sho_discount_rate > 0 ? ($get_percent_discount->sho_discount_rate / 100) : 0;
                }else{
                    $dcs = 0;
                }

                $listCat = $this->get_list_category_shopper($shopper->use_id,'05_affiliate');
                if(count($listCat)>0){
                    foreach($listCat as $cat){
                        $revenue = $this->revenue_shop_by_category($shopper->use_id, $cat->pro_category,'05_affiliate');
                        if($revenue > 0){
                            $dataAdd = array(
                                'rsc_shop_id' => $shopper->use_id,
                                'rsc_parent_id' => $shopper->parent_id,
                                'rsc_category_id' => $cat->pro_category,
                                'rsc_revenue' => $revenue,
                                'rsc_percent' => $cat->b2c_af_fee,
                                'rsc_profit' => ($revenue * ($cat->b2c_af_fee/100)) - (($revenue * ($cat->b2c_af_fee/100)) * $dcs),
                                'rsc_type' => '05',
                                'rsc_type2' => 1,
                                'rsc_description' => 'Hoa hồng bán lẻ có Cộng tác viên online',
                                'rsc_created_date' => time(),
                                'rsc_created_date_str' => date("d-m-Y",time()),
                                'rsc_created_month_year' =>  $this->month_year
                            );
                            $revenueCategory = $this->revenue_store_category_model->add($dataAdd);
                        }
                        log_message("debug","Doanh thu Danh mục Bán lẻ có AF - UserID:".$shopper->use_id.",Danh mục:".$cat->pro_category.",Doanh thu:".$revenue.",Phần trăm:".$cat->b2c_af_fee.",Phí Azibai:".$revenue * ($cat->b2c_af_fee/100).",Loại:05_affiliate,Tháng:".$this->month_year);
                    }
                }
            }
        }
    }

    function checkExistRevenueStoreByType($type, $type2 = 0){
        $c_month_year = $this->month_year;
        //type2 la loai si trong hay si ngoai
        if($type2 == 1){
            $str_type2 = "rsc_type2 = 1 AND ";
        }else{
            $str_type2 = '';
        }
        $this->load->model('revenue_store_category_model');
        $revenueToday = $this->revenue_store_category_model->fetch($select = "*", $where = $str_type2."rsc_type = '".$type."'  AND rsc_created_month_year = '".$c_month_year."'", $order = "rsc_id", $by = "DESC", $start = 0, $limit = 1);

        if(count($revenueToday) == 1){
            return true;
        }
        return false;
    }

    function checkExistMoneyAffiliate(){
        $c_month = $this->month_year;
        $this->load->model('account_model');
        $moneyToday = $this->account_model->fetch($select = "*", $where = "month_year ='".$c_month."' AND type = '06'", $order = "id", $by = "DESC", $start = 0, $limit = 1);

        if(count($moneyToday) == 1){
            return true;
        }
        return false;
    }

    function checkExistMoneyStore(){
        $end = date("Y-m-d H:i:s",strtotime("now"));
        $start = date("Y-m-d H:i:s",strtotime("-1 week"));
        $this->load->model('account_model');
        $moneyToday = $this->account_model->fetch($select = "*", $where = "created_date >='".$start."' AND created_date <= '".$end."' AND type = '07'", $order = "id", $by = "DESC", $start = 0, $limit = 1);
       
        if(count($moneyToday) == 1){
            return true;
        }
        return false;
    }

    function get_start_end_date(){
        $r_month = (int)date("m");
        $r_year = (int)date("Y");
        if($r_month == 1){
            $calculation_month = 12;
            $calculation_year = $r_year - 1;
        }else{
            $calculation_month = $r_month - 1;
            $calculation_year = $r_year;
        }
        $test = testMode;
        if($test == 1){
            $calculation_month = testModeMonth;
            $calculation_year = testModeYear;
        }
        $numberDayOnMonth = cal_days_in_month(CAL_GREGORIAN, $calculation_month, $calculation_year);
        $startMonth = mktime(0, 0, 0, $calculation_month, 1, $calculation_year);
        $endMonth = mktime(23, 59, 59, $calculation_month, $numberDayOnMonth, $calculation_year);
        $arrStartEnd = array();
        $arrStartEnd[0] = $startMonth;
        $arrStartEnd[1] = $endMonth;

        return $arrStartEnd;
    }

    function get_all_shopper(){
        $this->load->model('user_model');
        $listUser = $this->user_model->fetch("*","use_group = 3 AND use_status = 1");

        return $listUser;
    }

    function get_all_affiliate(){
        $this->load->model('user_model');
        $listUser = $this->user_model->fetch("*","use_group = 2 AND use_status = 1");
        return $listUser;
    }

    function get_all_category(){
        $this->load->model('category_model');
        $listCat = $this->category_model->fetch("*","cat_status = 1", "cat_id", "ASC");
        return $listCat;
    }

    function recalculate_commission_by_empty_position(){
        $r_month_year = $this->month_year;
        $this->load->model('commission_empty_position_model');
        $this->load->model('revenue_model');
        $this->load->model('commission_model');
        $this->load->model('user_model');
        $this->db->order_by("id", "ASC");
        $listUser = $this->commission_empty_position_model->fetch("*","created_month_year = '".$r_month_year."'");
        foreach($listUser as $user){
            $percent = 0;
            $commission = 0;
            $totalRevenue = $user->user_child_profit;
            //$this->get_revenue_by_user($user->user_child_id,$user->type);
            $percent = $user->dev1_percent + $user->partner2_percent + $user->partner1_percent + $user->coremember_percent;
            $commission = $totalRevenue * ($percent/100);
            $user_child_id_object = $this->user_model->get("*", "use_id = $user->user_child_id");

            if($user->type == '01'){
                $type =  'mua sỉ';
            }
            if($user->type == '02'){
                $type = 'bán sỉ';
            }
            if($user->type == '03'){
                $type = 'Bán giải pháp';
            }
            if($user->type == '04'){
                $type = 'mua lẻ';
            }
            if($user->type == '05'){
                $type = 'bán lẻ';
            }
            if($commission > 0){
                $dataAdd = array(
                    'user_id' => $user->user_id,
                    'group_id' => $user->group_id,
                    'parent_id' => $user->parent_id,
                    'commission' => $commission,
                    'percent' => $percent,
                    'type' => $user->type,
                    'profit' => $totalRevenue,
                    'empty_position' => $user_child_id_object->use_id,
                    'description' => "Hoa hồng ".$type." vị trí trống từ ". $user_child_id_object->use_username,
                    'commission_month' => $this->month_year,
                    'created_date' => time(),
                    'created_date_str' => date("d-m-Y",time()),
                    'payment_date' => time(),
                    'payment_status' => 0,
                    'status' => 0
                );
                $commissionAdd = $this->commission_model->add($dataAdd);
                $dataMoney = array(
                    'user_id' => $user->user_id,
                    'group_id' => $user->group_id,
                    'parent_id' => $user->parent_id,
                    'amount' => $commission,
                    'type' => $user->type,
                    'description' => "Tiền hoa hồng ".$type." vị trí trống từ ". $user_child_id_object->use_username,
                    'created_date' => date("Y-m-d H:i:s"),
                    'month_year' => $this->month_year,
                    'status' => 0
                );

                $this->persional_money_by_type($dataMoney);
                log_message("debug","Hoa hồng vị trí trống - Cha:".$user->user_id.",Con:".$user->user_child_id.",ID:".$user->id.",Doanh thu tính:".$totalRevenue.",Phần trăm:".$percent.",Hoa hồng:".$commission.",Chi tiết:Hoa hồng ".$type." vị trí trống từ ". $user_child_id_object->use_username.",Tháng:".$this->month_year);
            }


        }
    }

    function get_commission_config($group_id, $type){
        $this->load->model('commission_config_model');
        if($group_id > 0){
            $configObject = $this->commission_config_model->get("*","group_id = $group_id AND type = '".$type."'");
            if($configObject->commission_rate > 0){
                return $configObject->commission_rate;
            }else{
                return 0;
            }
        }
        return 0;
    }
    
    // retail sell product commission
    function get_commission_config_retail_sell($group_id, $type){
        $this->load->model('commission_config_model');
        if($group_id > 0){
            $configObject = $this->commission_config_model->get("*","group_id = $group_id AND type = '".$type."'");
            if($configObject->commission_rate > 0){
                return $configObject->commission_rate;
            }else{
                return 0;
            }
        }
        return 0;
    }
    // retail sell product commission
    function retail_sell_product_commission_dev2(){
        if(!$this->checkExistCommissionTodayByGroup(6,'05')){
            $this->load->model('commission_model');
            $this->load->model('revenue_model');
            $percent = $this->get_commission_config(6,'05');
            $listUser = $this->get_all_dev2();
            foreach($listUser as $user){
                $revenue = 0;
                $comission = 0;
                $revenue = $this->get_revenue_by_user($user->user_id,'05');

                $comission = $revenue * ($percent/100);
                if($comission > 0){
                    $dataAdd = array(
                        'user_id' => $user->user_id,
                        'group_id' => $user->group_id,
                        'parent_id' => $user->parent,
                        'commission' => $comission,
                        'percent' => $percent,
                        'profit' => $revenue,
                        'type' => '05',
                        'description' => 'Hoa hồng Bán lẻ',
                        'commission_month' => $this->month_year,
                        'created_date' => time(),
                        'created_date_str' => date("d-m-Y",time()),
                        'payment_date' => time(),
                        'payment_status' => 0,
                        'status' => 0
                    );
                    $commissionAdd = $this->commission_model->add($dataAdd);
                    $dataMoney = array(
                        'user_id' => $user->user_id,
                        'group_id' => $user->group_id,
                        'parent_id' => $user->parent,
                        'amount' => $comission,
                        'type' => '05',
                        'description' => 'Tiền hoa hồng Bán lẻ',
                        'created_date' => date("Y-m-d H:i:s"),
                        'month_year' => $this->month_year,
                        'status' => 0
                    );

                    $this->persional_money_by_type($dataMoney);
                }
                log_message("debug","Hoa hồng Bán lẻ Dev2 - UserID:".$user->user_id.",Doanh thu:".$revenue.",Phần trăm:".$percent.",Hoa hồng:".$comission.",Loại:05,Tháng:".$this->month_year);

            }
        }
    }

    function retail_sell_product_commission_dev1(){
        if(!$this->checkExistCommissionTodayByGroup(7,'05')){
            $this->load->model('commission_model');
            $this->load->model('revenue_model');
            $percent = $this->get_commission_config(7,'05');
            $listUser = $this->get_all_dev1();
            foreach($listUser as $user){
                $revenue = 0;
                $comission = 0;
                // doanh so cay he thong
                $listChild = $this->get_list_child_tree($user->user_id);
                foreach($listChild as $child){
                    $totalChild = $this->get_revenue_by_user($child->user_id,'05');
                    $revenue = $revenue + $totalChild;
                }
                // doanh so ca nhan
                $revenuePrivate =  $this->get_personal_revenue_by_user($user->user_id,'05');
                if($revenuePrivate > 0){
                    $this->caculate_personal_commission($user,$revenuePrivate,'05','Hoa hồng Bán lẻ cá nhân');
                }

                $comission = $revenue * ($percent/100);
                if($comission > 0){
                    $dataAdd = array(
                        'user_id' => $user->user_id,
                        'group_id' => $user->group_id,
                        'parent_id' => $user->parent,
                        'commission' => $comission,
                        'percent' => $percent,
                        'profit' => $revenue,
                        'type' => '05',
                        'description' => 'Hoa hồng Bán lẻ',
                        'commission_month' => $this->month_year,
                        'created_date' => time(),
                        'created_date_str' => date("d-m-Y",time()),
                        'payment_date' => time(),
                        'payment_status' => 0,
                        'status' => 0
                    );
                    $commissionAdd = $this->commission_model->add($dataAdd);
                    $dataMoney = array(
                        'user_id' => $user->user_id,
                        'group_id' => $user->group_id,
                        'parent_id' => $user->parent,
                        'amount' => $comission,
                        'type' => '05',
                        'description' => 'Tiền hoa hồng Bán lẻ',
                        'created_date' => date("Y-m-d H:i:s"),
                        'month_year' => $this->month_year,
                        'status' => 0
                    );

                    $this->persional_money_by_type($dataMoney);
                }
                log_message("debug","Hoa hồng Bán lẻ Dev1 - UserID:".$user->user_id.",Doanh thu:".$revenue.",Phần trăm:".$percent.",Hoa hồng:".$comission.",Loại:05,Tháng:".$this->month_year);

            }
        }
    }

    function retail_sell_product_commission_partner2(){
        if(!$this->checkExistCommissionTodayByGroup(8,'05')){
            $this->load->model('commission_model');
            $this->load->model('revenue_model');
            $percent = $this->get_commission_config(8,'05');
            $listUser = $this->get_all_partner2();
            foreach($listUser as $user){
                $revenue = 0;
                $comission = 0;
                // doanh so cay he thong
                $listChild = $this->get_list_child_tree($user->user_id);
                foreach($listChild as $child){
                    $totalChild = $this->get_revenue_by_user($child->user_id,'05');
                    $revenue = $revenue + $totalChild;
                }
                // doanh so ca nhan
                $revenuePrivate =  $this->get_personal_revenue_by_user($user->user_id,'05');
                if($revenuePrivate > 0){
                    $this->caculate_personal_commission($user,$revenuePrivate,'05','Hoa hồng Bán lẻ cá nhân');
                }

                $comission = $revenue * ($percent/100);
                if($comission > 0){
                    $dataAdd = array(
                        'user_id' => $user->user_id,
                        'group_id' => $user->group_id,
                        'parent_id' => $user->parent,
                        'commission' => $comission,
                        'percent' => $percent,
                        'profit' => $revenue,
                        'type' => '05',
                        'description' => 'Hoa hồng Bán lẻ',
                        'commission_month' => $this->month_year,
                        'created_date' => time(),
                        'created_date_str' => date("d-m-Y",time()),
                        'payment_date' => time(),
                        'payment_status' => 0,
                        'status' => 0
                    );
                    $commissionAdd = $this->commission_model->add($dataAdd);
                    $dataMoney = array(
                        'user_id' => $user->user_id,
                        'group_id' => $user->group_id,
                        'parent_id' => $user->parent,
                        'amount' => $comission,
                        'type' => '05',
                        'description' => 'Tiền hoa hồng Bán lẻ',
                        'created_date' => date("Y-m-d H:i:s"),
                        'month_year' => $this->month_year,
                        'status' => 0
                    );

                    $this->persional_money_by_type($dataMoney);
                }
                log_message("debug","Hoa hồng Bán lẻ Partner2 - UserID:".$user->user_id.",Doanh thu:".$revenue.",Phần trăm:".$percent.",Hoa hồng:".$comission.",Loại:05,Tháng:".$this->month_year);

            }
        }
    }

    function retail_sell_product_commission_partner1(){
        if(!$this->checkExistCommissionTodayByGroup(9,'05')){
            $this->load->model('commission_model');
            $this->load->model('revenue_model');
            $percent = $this->get_commission_config(9,'05');
            $listUser = $this->get_all_partner1();
            foreach($listUser as $user){
                $revenue = 0;
                $comission = 0;
                // doanh so cay he thong
                $listChild = $this->get_list_child_tree($user->user_id);
                foreach($listChild as $child){
                    $totalChild = $this->get_revenue_by_user($child->user_id,'05');
                    $revenue = $revenue + $totalChild;
                }
                // doanh so ca nhan
                $revenuePrivate =  $this->get_personal_revenue_by_user($user->user_id,'05');
                if($revenuePrivate > 0){
                    $this->caculate_personal_commission($user,$revenuePrivate,'05','Hoa hồng Bán lẻ cá nhân');
                }

                $comission = $revenue * ($percent/100);
                if($comission > 0){
                    $dataAdd = array(
                        'user_id' => $user->user_id,
                        'group_id' => $user->group_id,
                        'parent_id' => $user->parent,
                        'commission' => $comission,
                        'percent' => $percent,
                        'profit' => $revenue,
                        'type' => '05',
                        'description' => 'Hoa hồng Bán lẻ',
                        'commission_month' => $this->month_year,
                        'created_date' => time(),
                        'created_date_str' => date("d-m-Y",time()),
                        'payment_date' => time(),
                        'payment_status' => 0,
                        'status' => 0
                    );
                    $commissionAdd = $this->commission_model->add($dataAdd);
                    $dataMoney = array(
                        'user_id' => $user->user_id,
                        'group_id' => $user->group_id,
                        'parent_id' => $user->parent,
                        'amount' => $comission,
                        'type' => '05',
                        'description' => 'Tiền hoa hồng Bán lẻ',
                        'created_date' => date("Y-m-d H:i:s"),
                        'month_year' => $this->month_year,
                        'status' => 0
                    );

                    $this->persional_money_by_type($dataMoney);
                }
                log_message("debug","Hoa hồng Bán lẻ Partner1 - UserID:".$user->user_id.",Doanh thu:".$revenue.",Phần trăm:".$percent.",Hoa hồng:".$comission.",Loại:05,Tháng:".$this->month_year);

            }
        }
    }

    function retail_sell_product_commission_coremember(){
        if(!$this->checkExistCommissionTodayByGroup(10,'05')){
            $this->load->model('commission_model');
            $this->load->model('revenue_model');
            $percent = $this->get_commission_config(10,'05');
            $listUser = $this->get_all_coremember();
            foreach($listUser as $user){
                $revenue = 0;
                $comission = 0;
                // doanh so cay he thong
                $listChild = $this->get_list_child_tree($user->user_id);
                foreach($listChild as $child){
                    $totalChild = $this->get_revenue_by_user($child->user_id,'05');
                    $revenue = $revenue + $totalChild;
                }
                // doanh so ca nhan
                $revenuePrivate =  $this->get_personal_revenue_by_user($user->user_id,'05');
                if($revenuePrivate > 0){
                    $this->caculate_personal_commission($user,$revenuePrivate,'05','Hoa hồng Bán lẻ cá nhân');
                }

                $comission = $revenue * ($percent/100);
                if($comission > 0){
                    $dataAdd = array(
                        'user_id' => $user->user_id,
                        'group_id' => $user->group_id,
                        'parent_id' => $user->parent,
                        'commission' => $comission,
                        'percent' => $percent,
                        'profit' => $revenue,
                        'type' => '05',
                        'description' => 'Hoa hồng Bán lẻ',
                        'commission_month' => $this->month_year,
                        'created_date' => time(),
                        'created_date_str' => date("d-m-Y",time()),
                        'payment_date' => time(),
                        'payment_status' => 0,
                        'status' => 0
                    );
                    $commissionAdd = $this->commission_model->add($dataAdd);
                    $dataMoney = array(
                        'user_id' => $user->user_id,
                        'group_id' => $user->group_id,
                        'parent_id' => $user->parent,
                        'amount' => $comission,
                        'type' => '05',
                        'description' => 'Tiền hoa hồng Bán lẻ',
                        'created_date' => date("Y-m-d H:i:s"),
                        'month_year' => $this->month_year,
                        'status' => 0
                    );

                    $this->persional_money_by_type($dataMoney);
                }
                log_message("debug","Hoa hồng Bán lẻ CoreMember - UserID:".$user->user_id.",Doanh thu:".$revenue.",Phần trăm:".$percent.",Hoa hồng:".$comission.",Loại:05,Tháng:".$this->month_year);
            }
        }
    }

    function retail_sell_product_commission_coreadmin(){
        if(!$this->checkExistCommissionTodayByGroup(12,'05')){
            $this->load->model('commission_model');
            $this->load->model('revenue_model');
            $percent = $this->get_commission_config(12,'05');
            $listUser = $this->get_all_coreadmin();
            foreach($listUser as $user){
                $revenue = 0;
                $comission = 0;
                // doanh so cay he thong
                $listChild = $this->get_list_child_tree($user->user_id);
                foreach($listChild as $child){
                    $totalChild = $this->get_revenue_by_user($child->user_id,'05');
                    $revenue = $revenue + $totalChild;
                }
                // doanh so ca nhan
                $revenuePrivate =  $this->get_personal_revenue_by_user($user->user_id,'05');
                if($revenuePrivate > 0){
                    $this->caculate_personal_commission($user,$revenuePrivate,'05','Hoa hồng Bán lẻ cá nhân');
                }

                $comission = $revenue * ($percent/100);
                if($comission > 0){
                    $dataAdd = array(
                        'user_id' => $user->user_id,
                        'group_id' => $user->group_id,
                        'parent_id' => $user->parent,
                        'commission' => $comission,
                        'percent' => $percent,
                        'profit' => $revenue,
                        'type' => '05',
                        'description' => 'Hoa hồng Bán lẻ',
                        'commission_month' => $this->month_year,
                        'created_date' => time(),
                        'created_date_str' => date("d-m-Y",time()),
                        'payment_date' => time(),
                        'payment_status' => 0,
                        'status' => 0
                    );
                    $commissionAdd = $this->commission_model->add($dataAdd);
                    $dataMoney = array(
                        'user_id' => $user->user_id,
                        'group_id' => $user->group_id,
                        'parent_id' => $user->parent,
                        'amount' => $comission,
                        'type' => '05',
                        'description' => 'Tiền hoa hồng Bán lẻ',
                        'created_date' => date("Y-m-d H:i:s"),
                        'month_year' => $this->month_year,
                        'status' => 0
                    );

                    $this->persional_money_by_type($dataMoney);
                }
                log_message("debug","Hoa hồng Bán lẻ CoreAdmin - UserID:".$user->user_id.",Doanh thu:".$revenue.",Phần trăm:".$percent.",Hoa hồng:".$comission.",Loại:05,Tháng:".$this->month_year);
            }
        }
    }

    // retail buy product commission
    function get_commission_config_retail_buy($group_id,$type){
        $this->load->model('commission_config_model');
        if($group_id > 0){
            $configObject = $this->commission_config_model->get("*","group_id = $group_id AND type = '".$type."'");
            if($configObject->commission_rate > 0){
                return $configObject->commission_rate;
            }else{
                return 0;
            }
        }
        return 0;
    }

    // retail buy product commission store from affiliate
    function retail_buy_product_commission_store_from_affiliate(){
        if(!$this->checkExistCommissionTodayByGroup(3,'08')){
            $this->load->model('commission_model');
            $this->load->model('revenue_model');
            $percent = $this->get_commission_config(3,'08');
            $listUser = $this->get_all_shopper();

            foreach($listUser as $user){
                $revenue = 0;
                $comission = 0;
                $revenue = $this->get_revenue_by_user($user->use_id,'08');

                $comission = $revenue * ($percent/100);
                if($comission > 0){
                    $dataAdd = array(
                        'user_id' => $user->use_id,
                        'group_id' => $user->use_group,
                        'parent_id' => $user->parent_id,
                        'commission' => $comission,
                        'percent' => $percent,
                        'profit' => $revenue,
                        'type' => '08',
                        'description' => 'Hoa hồng Mua lẻ Gian hàng từ Cộng tác viên online',
                        'commission_month' => $this->month_year,
                        'created_date' => time(),
                        'created_date_str' => date("d-m-Y",time()),
                        'payment_date' => time(),
                        'payment_status' => 0,
                        'status' => 0
                    );
                    $commissionAdd = $this->commission_model->add($dataAdd);
                    $dataMoney = array(
                        'user_id' => $user->use_id,
                        'group_id' => $user->use_group,
                        'parent_id' => $user->parent_id,
                        'amount' => $comission,
                        'type' => '08',
                        'description' => 'Tiền hoa hồng mua lẻ Gian hàng từ Cộng tác viên online',
                        'created_date' => date("Y-m-d H:i:s"),
                        'month_year' => $this->month_year,
                        'status' => 0
                    );

                    $this->persional_money_by_type($dataMoney);

                }
            }
        }
    }
    // retail buy product commission
    function retail_buy_product_commission_dev2(){
        if(!$this->checkExistCommissionTodayByGroup(6,'04')){
            $this->load->model('commission_model');
            $this->load->model('revenue_model');
            $percent = $this->get_commission_config(6,'04');
            $listUser = $this->get_all_dev2();
            foreach($listUser as $user){
                $revenue = 0;
                $comission = 0;
                $revenue = $this->get_revenue_by_user($user->user_id,'04');

                $comission = $revenue * ($percent/100);
                if($comission > 0){
                    $dataAdd = array(
                        'user_id' => $user->user_id,
                        'group_id' => $user->group_id,
                        'parent_id' => $user->parent,
                        'commission' => $comission,
                        'percent' => $percent,
                        'profit' => $revenue,
                        'type' => '04',
                        'description' => 'Hoa hồng Mua lẻ',
                        'commission_month' => $this->month_year,
                        'created_date' => time(),
                        'created_date_str' => date("d-m-Y",time()),
                        'payment_date' => time(),
                        'payment_status' => 0,
                        'status' => 0
                    );
                    $commissionAdd = $this->commission_model->add($dataAdd);
                    $dataMoney = array(
                        'user_id' => $user->user_id,
                        'group_id' => $user->group_id,
                        'parent_id' => $user->parent,
                        'amount' => $comission,
                        'type' => '04',
                        'description' => 'Tiền hoa hồng Mua lẻ',
                        'created_date' => date("Y-m-d H:i:s"),
                        'month_year' => $this->month_year,
                        'status' => 0
                    );

                    $this->persional_money_by_type($dataMoney);

                }
                log_message("debug","Hoa hồng Mua lẻ Dev2 - UserID:".$user->user_id.",Doanh thu:".$revenue.",Phần trăm:".$percent.",Hoa hồng:".$comission.",Loại:04,Tháng:".$this->month_year);
            }
        }
    }

    function retail_buy_product_commission_dev1(){
        if(!$this->checkExistCommissionTodayByGroup(7,'04')){
            $this->load->model('commission_model');
            $this->load->model('revenue_model');
            $percent = $this->get_commission_config(7,'04');
            $listUser = $this->get_all_dev1();
            foreach($listUser as $user){
                $revenue = 0;
                $comission = 0;
                // doanh so cay he thong
                $listChild = $this->get_list_child_tree($user->user_id);
                foreach($listChild as $child){
                    $totalChild = $this->get_revenue_by_user($child->user_id,'04');
                    $revenue = $revenue + $totalChild;
                }
                // doanh so ca nhan
                $revenuePrivate =  $this->get_personal_revenue_by_user($user->user_id,'04');
                if($revenuePrivate > 0){
                    $this->caculate_personal_commission($user,$revenuePrivate,'04','Hoa hồng Mua lẻ cá nhân');
                }

                $comission = $revenue * ($percent/100);
                if($comission > 0){
                    $dataAdd = array(
                        'user_id' => $user->user_id,
                        'group_id' => $user->group_id,
                        'parent_id' => $user->parent,
                        'commission' => $comission,
                        'percent' => $percent,
                        'profit' => $revenue,
                        'type' => '04',
                        'description' => 'Hoa hồng Mua lẻ',
                        'commission_month' => $this->month_year,
                        'created_date' => time(),
                        'created_date_str' => date("d-m-Y",time()),
                        'payment_date' => time(),
                        'payment_status' => 0,
                        'status' => 0
                    );
                    $commissionAdd = $this->commission_model->add($dataAdd);
                    $dataMoney = array(
                        'user_id' => $user->user_id,
                        'group_id' => $user->group_id,
                        'parent_id' => $user->parent,
                        'amount' => $comission,
                        'type' => '04',
                        'description' => 'Tiền hoa hồng Mua lẻ',
                        'created_date' => date("Y-m-d H:i:s"),
                        'month_year' => $this->month_year,
                        'status' => 0
                    );

                    $this->persional_money_by_type($dataMoney);
                }
                log_message("debug","Hoa hồng Mua lẻ Dev1 - UserID:".$user->user_id.",Doanh thu:".$revenue.",Phần trăm:".$percent.",Hoa hồng:".$comission.",Loại:04,Tháng:".$this->month_year);

            }
        }
    }

    function retail_buy_product_commission_partner2(){
        if(!$this->checkExistCommissionTodayByGroup(8,'04')){
            $this->load->model('commission_model');
            $this->load->model('revenue_model');
            $percent = $this->get_commission_config(8,'04');
            $listUser = $this->get_all_partner2();
            foreach($listUser as $user){
                $revenue = 0;
                $comission = 0;
                // doanh so cay he thong
                $listChild = $this->get_list_child_tree($user->user_id);
                foreach($listChild as $child){
                    $totalChild = $this->get_revenue_by_user($child->user_id,'04');
                    $revenue = $revenue + $totalChild;
                }
                // doanh so ca nhan
                $revenuePrivate =  $this->get_personal_revenue_by_user($user->user_id,'04');
                if($revenuePrivate > 0){
                    $this->caculate_personal_commission($user,$revenuePrivate,'04','Hoa hồng Mua lẻ cá nhân');
                }

                $comission = $revenue * ($percent/100);
                if($comission > 0){
                    $dataAdd = array(
                        'user_id' => $user->user_id,
                        'group_id' => $user->group_id,
                        'parent_id' => $user->parent,
                        'commission' => $comission,
                        'percent' => $percent,
                        'profit' => $revenue,
                        'type' => '04',
                        'description' => 'Hoa hồng Mua lẻ',
                        'commission_month' => $this->month_year,
                        'created_date' => time(),
                        'created_date_str' => date("d-m-Y",time()),
                        'payment_date' => time(),
                        'payment_status' => 0,
                        'status' => 0
                    );
                    $commissionAdd = $this->commission_model->add($dataAdd);
                    $dataMoney = array(
                        'user_id' => $user->user_id,
                        'group_id' => $user->group_id,
                        'parent_id' => $user->parent,
                        'amount' => $comission,
                        'type' => '04',
                        'description' => 'Tiền hoa hồng Mua lẻ',
                        'created_date' => date("Y-m-d H:i:s"),
                        'month_year' => $this->month_year,
                        'status' => 0
                    );

                    $this->persional_money_by_type($dataMoney);
                }
                log_message("debug","Hoa hồng Mua lẻ Partner2 - UserID:".$user->user_id.",Doanh thu:".$revenue.",Phần trăm:".$percent.",Hoa hồng:".$comission.",Loại:04,Tháng:".$this->month_year);

            }
        }
    }

    function retail_buy_product_commission_partner1(){
        if(!$this->checkExistCommissionTodayByGroup(9,'04')){
            $this->load->model('commission_model');
            $this->load->model('revenue_model');
            $percent = $this->get_commission_config(9,'04');
            $listUser = $this->get_all_partner1();
            foreach($listUser as $user){
                $revenue = 0;
                $comission = 0;
                // doanh so cay he thong
                $listChild = $this->get_list_child_tree($user->user_id);
                foreach($listChild as $child){
                    $totalChild = $this->get_revenue_by_user($child->user_id,'04');
                    $revenue = $revenue + $totalChild;
                }
                // doanh so ca nhan
                $revenuePrivate =  $this->get_personal_revenue_by_user($user->user_id,'04');
                if($revenuePrivate > 0){
                    $this->caculate_personal_commission($user,$revenuePrivate,'04','Hoa hồng Mua lẻ cá nhân');
                }

                $comission = $revenue * ($percent/100);
                if($comission > 0){
                    $dataAdd = array(
                        'user_id' => $user->user_id,
                        'group_id' => $user->group_id,
                        'parent_id' => $user->parent,
                        'commission' => $comission,
                        'percent' => $percent,
                        'profit' => $revenue,
                        'type' => '04',
                        'description' => 'Hoa hồng Mua lẻ',
                        'commission_month' => $this->month_year,
                        'created_date' => time(),
                        'created_date_str' => date("d-m-Y",time()),
                        'payment_date' => time(),
                        'payment_status' => 0,
                        'status' => 0
                    );
                    $commissionAdd = $this->commission_model->add($dataAdd);
                    $dataMoney = array(
                        'user_id' => $user->user_id,
                        'group_id' => $user->group_id,
                        'parent_id' => $user->parent,
                        'amount' => $comission,
                        'type' => '04',
                        'description' => 'Tiền hoa hồng Mua lẻ',
                        'created_date' => date("Y-m-d H:i:s"),
                        'month_year' => $this->month_year,
                        'status' => 0
                    );

                    $this->persional_money_by_type($dataMoney);
                }
                log_message("debug","Hoa hồng Mua lẻ Partner1 - UserID:".$user->user_id.",Doanh thu:".$revenue.",Phần trăm:".$percent.",Hoa hồng:".$comission.",Loại:04,Tháng:".$this->month_year);
            }
        }
    }

    function retail_buy_product_commission_coremember(){
        if(!$this->checkExistCommissionTodayByGroup(10,'04')){
            $this->load->model('commission_model');
            $this->load->model('revenue_model');
            $percent = $this->get_commission_config(10,'04');
            $listUser = $this->get_all_coremember();
            foreach($listUser as $user){
                $revenue = 0;
                $comission = 0;
                // doanh so cay he thong
                $listChild = $this->get_list_child_tree($user->user_id);
                foreach($listChild as $child){
                    $totalChild = $this->get_revenue_by_user($child->user_id,'04');
                    $revenue = $revenue + $totalChild;
                }
                // doanh so ca nhan
                $revenuePrivate =  $this->get_personal_revenue_by_user($user->user_id,'04');
                if($revenuePrivate > 0){
                    $this->caculate_personal_commission($user,$revenuePrivate,'04','Hoa hồng Mua lẻ cá nhân');
                }

                $comission = $revenue * ($percent/100);
                if($comission > 0){
                    $dataAdd = array(
                        'user_id' => $user->user_id,
                        'group_id' => $user->group_id,
                        'parent_id' => $user->parent,
                        'commission' => $comission,
                        'percent' => $percent,
                        'profit' => $revenue,
                        'type' => '04',
                        'description' => 'Hoa hồng Mua lẻ',
                        'commission_month' => $this->month_year,
                        'created_date' => time(),
                        'created_date_str' => date("d-m-Y",time()),
                        'payment_date' => time(),
                        'payment_status' => 0,
                        'status' => 0
                    );
                    $commissionAdd = $this->commission_model->add($dataAdd);
                    $dataMoney = array(
                        'user_id' => $user->user_id,
                        'group_id' => $user->group_id,
                        'parent_id' => $user->parent,
                        'amount' => $comission,
                        'type' => '04',
                        'description' => 'Tiền hoa hồng Mua lẻ',
                        'created_date' => date("Y-m-d H:i:s"),
                        'month_year' => $this->month_year,
                        'status' => 0
                    );

                    $this->persional_money_by_type($dataMoney);
                }
                log_message("debug","Hoa hồng Mua lẻ CoreMember - UserID:".$user->user_id.",Doanh thu:".$revenue.",Phần trăm:".$percent.",Hoa hồng:".$comission.",Loại:04,Tháng:".$this->month_year);

            }
        }
    }

    function retail_buy_product_commission_coreadmin(){
        if(!$this->checkExistCommissionTodayByGroup(12,'04')){
            $this->load->model('commission_model');
            $this->load->model('revenue_model');
            $percent = $this->get_commission_config(12,'04');
            $listUser = $this->get_all_coreadmin();
            foreach($listUser as $user){
                $revenue = 0;
                $comission = 0;
                // doanh so cay he thong
                $listChild = $this->get_list_child_tree($user->user_id);
                foreach($listChild as $child){
                    $totalChild = $this->get_revenue_by_user($child->user_id,'04');
                    $revenue = $revenue + $totalChild;
                }
                // doanh so ca nhan
                $revenuePrivate =  $this->get_personal_revenue_by_user($user->user_id,'04');
                if($revenuePrivate > 0){
                    $this->caculate_personal_commission($user,$revenuePrivate,'04','Hoa hồng Mua lẻ cá nhân');
                }

                $comission = $revenue * ($percent/100);
                if($comission > 0){
                    $dataAdd = array(
                        'user_id' => $user->user_id,
                        'group_id' => $user->group_id,
                        'parent_id' => $user->parent,
                        'commission' => $comission,
                        'percent' => $percent,
                        'profit' => $revenue,
                        'type' => '04',
                        'description' => 'Hoa hồng Mua lẻ',
                        'commission_month' => $this->month_year,
                        'created_date' => time(),
                        'created_date_str' => date("d-m-Y",time()),
                        'payment_date' => time(),
                        'payment_status' => 0,
                        'status' => 0
                    );
                    $commissionAdd = $this->commission_model->add($dataAdd);
                    $dataMoney = array(
                        'user_id' => $user->user_id,
                        'group_id' => $user->group_id,
                        'parent_id' => $user->parent,
                        'amount' => $comission,
                        'type' => '04',
                        'description' => 'Tiền hoa hồng Mua lẻ',
                        'created_date' => date("Y-m-d H:i:s"),
                        'month_year' => $this->month_year,
                        'status' => 0
                    );

                    $this->persional_money_by_type($dataMoney);
                }
                log_message("debug","Hoa hồng Mua lẻ CoreAdmin - UserID:".$user->user_id.",Doanh thu:".$revenue.",Phần trăm:".$percent.",Hoa hồng:".$comission.",Loại:04,Tháng:".$this->month_year);
            }
        }
    }

    // wholesale buy product commission
    function get_commission_config_wholesale_buy($group_id,$type){
        $this->load->model('commission_config_model');
        if($group_id > 0){
            $configObject = $this->commission_config_model->get("*","group_id = $group_id AND type = '".$type."'");
            if($configObject->commission_rate > 0){
                return $configObject->commission_rate;
            }else{
                return 0;
            }
        }
        return 0;
    }
    // wholesale buy product commission
    function wholesale_buy_product_commission_dev2(){
        if(!$this->checkExistCommissionTodayByGroup(6,'01')){
            $this->load->model('commission_model');
            $this->load->model('revenue_model');
            $percent = $this->get_commission_config(6,'01');
            $listUser = $this->get_all_dev2();
            foreach($listUser as $user){
                $revenue = 0;
                $comission = 0;
                $revenue = $this->get_revenue_by_user($user->user_id,'01');

                $comission = $revenue * ($percent/100);
                if($comission > 0){
                    $dataAdd = array(
                        'user_id' => $user->user_id,
                        'group_id' => $user->group_id,
                        'parent_id' => $user->parent,
                        'commission' => $comission,
                        'percent' => $percent,
                        'profit' => $revenue,
                        'type' => '01',
                        'description' => 'Hoa hồng Mua sỉ',
                        'commission_month' => $this->month_year,
                        'created_date' => time(),
                        'created_date_str' => date("d-m-Y",time()),
                        'payment_date' => time(),
                        'payment_status' => 0,
                        'status' => 0
                    );
                    $commissionAdd = $this->commission_model->add($dataAdd);
                    $dataMoney = array(
                        'user_id' => $user->user_id,
                        'group_id' => $user->group_id,
                        'parent_id' => $user->parent,
                        'amount' => $comission,
                        'type' => '01',
                        'description' => 'Tiền hoa hồng Mua sỉ',
                        'created_date' => date("Y-m-d H:i:s"),
                        'month_year' => $this->month_year,
                        'status' => 0
                    );

                    $this->persional_money_by_type($dataMoney);
                }
                log_message("debug","Hoa hồng Mua sỉ Dev2 - UserID:".$user->user_id.",Doanh thu:".$revenue.",Phần trăm:".$percent.",Hoa hồng:".$comission.",Loại:01,Tháng:".$this->month_year);

            }
        }
    }

    function wholesale_buy_product_commission_dev1(){
        if(!$this->checkExistCommissionTodayByGroup(7,'01')){
            $this->load->model('commission_model');
            $this->load->model('revenue_model');
            $percent = $this->get_commission_config(7,'01');
            $listUser = $this->get_all_dev1();
            foreach($listUser as $user){
                $revenue = 0;
                $comission = 0;
                // doanh so cay he thong
                $listChild = $this->get_list_child_tree($user->user_id);
                foreach($listChild as $child){
                    $totalChild = $this->get_revenue_by_user($child->user_id,'01');
                    $revenue = $revenue + $totalChild;
                }
                // doanh so ca nhan
                $revenuePrivate =  $this->get_personal_revenue_by_user($user->user_id,'01');
                if($revenuePrivate > 0){
                    // tinh hoa hong ca nhan o day
                    $this->caculate_personal_commission($user,$revenuePrivate,'01','Hoa hồng Mua sỉ cá nhân');
                }

                $comission = $revenue * ($percent/100);
                if($comission > 0){
                    $dataAdd = array(
                        'user_id' => $user->user_id,
                        'group_id' => $user->group_id,
                        'parent_id' => $user->parent,
                        'commission' => $comission,
                        'percent' => $percent,
                        'profit' => $revenue,
                        'type' => '01',
                        'description' => 'Hoa hồng Mua sỉ',
                        'commission_month' => $this->month_year,
                        'created_date' => time(),
                        'created_date_str' => date("d-m-Y",time()),
                        'payment_date' => time(),
                        'payment_status' => 0,
                        'status' => 0
                    );
                    $commissionAdd = $this->commission_model->add($dataAdd);
                    $dataMoney = array(
                        'user_id' => $user->user_id,
                        'group_id' => $user->group_id,
                        'parent_id' => $user->parent,
                        'amount' => $comission,
                        'type' => '01',
                        'description' => 'Tiền hoa hồng Mua sỉ',
                        'created_date' => date("Y-m-d H:i:s"),
                        'month_year' => $this->month_year,
                        'status' => 0
                    );

                    $this->persional_money_by_type($dataMoney);
                }
                log_message("debug","Hoa hồng Mua sỉ Dev1 - UserID:".$user->user_id.",Doanh thu:".$revenue.",Phần trăm:".$percent.",Hoa hồng:".$comission.",Loại:01,Tháng:".$this->month_year);

            }
        }
    }

    function wholesale_buy_product_commission_partner2(){
        if(!$this->checkExistCommissionTodayByGroup(8,'01')){
            $this->load->model('commission_model');
            $this->load->model('revenue_model');
            $percent = $this->get_commission_config(8,'01');
            $listUser = $this->get_all_partner2();
            foreach($listUser as $user){
                $revenue = 0;
                $comission = 0;
                // doanh so cay he thong
                $listChild = $this->get_list_child_tree($user->user_id);
                foreach($listChild as $child){
                    $totalChild = $this->get_revenue_by_user($child->user_id,'01');
                    $revenue = $revenue + $totalChild;
                }
                // doanh so ca nhan
                $revenuePrivate =  $this->get_personal_revenue_by_user($user->user_id,'01');
                if($revenuePrivate > 0){
                    // tinh hoa hong ca nhan o day
                    $this->caculate_personal_commission($user,$revenuePrivate,'01','Hoa hồng Mua sỉ cá nhân');
                }

                $comission = $revenue * ($percent/100);
                if($comission > 0){
                    $dataAdd = array(
                        'user_id' => $user->user_id,
                        'group_id' => $user->group_id,
                        'parent_id' => $user->parent,
                        'commission' => $comission,
                        'percent' => $percent,
                        'profit' => $revenue,
                        'type' => '01',
                        'description' => 'Hoa hồng Mua sỉ',
                        'commission_month' => $this->month_year,
                        'created_date' => time(),
                        'created_date_str' => date("d-m-Y",time()),
                        'payment_date' => time(),
                        'payment_status' => 0,
                        'status' => 0
                    );
                    $commissionAdd = $this->commission_model->add($dataAdd);
                    $dataMoney = array(
                        'user_id' => $user->user_id,
                        'group_id' => $user->group_id,
                        'parent_id' => $user->parent,
                        'amount' => $comission,
                        'type' => '01',
                        'description' => 'Tiền hoa hồng Mua sỉ',
                        'created_date' => date("Y-m-d H:i:s"),
                        'month_year' => $this->month_year,
                        'status' => 0
                    );

                    $this->persional_money_by_type($dataMoney);
                }
                log_message("debug","Hoa hồng Mua sỉ Partner2 - UserID:".$user->user_id.",Doanh thu:".$revenue.",Phần trăm:".$percent.",Hoa hồng:".$comission.",Loại:01,Tháng:".$this->month_year);
            }
        }
    }

    function wholesale_buy_product_commission_partner1(){
        if(!$this->checkExistCommissionTodayByGroup(9,'01')){
            $this->load->model('commission_model');
            $this->load->model('revenue_model');
            $percent = $this->get_commission_config(9,'01');
            $listUser = $this->get_all_partner1();
            foreach($listUser as $user){
                $revenue = 0;
                $comission = 0;
                // doanh so cay he thong
                $listChild = $this->get_list_child_tree($user->user_id);
                foreach($listChild as $child){
                    $totalChild = $this->get_revenue_by_user($child->user_id,'01');
                    $revenue = $revenue + $totalChild;
                }
                // doanh so ca nhan
                $revenuePrivate =  $this->get_personal_revenue_by_user($user->user_id,'01');
                if($revenuePrivate > 0){
                    // tinh hoa hong ca nhan o day
                    $this->caculate_personal_commission($user,$revenuePrivate,'01','Hoa hồng Mua sỉ cá nhân');
                }

                $comission = $revenue * ($percent/100);
                if($comission > 0){
                    $dataAdd = array(
                        'user_id' => $user->user_id,
                        'group_id' => $user->group_id,
                        'parent_id' => $user->parent,
                        'commission' => $comission,
                        'percent' => $percent,
                        'profit' => $revenue,
                        'type' => '01',
                        'description' => 'Hoa hồng Mua sỉ',
                        'commission_month' => $this->month_year,
                        'created_date' => time(),
                        'created_date_str' => date("d-m-Y",time()),
                        'payment_date' => time(),
                        'payment_status' => 0,
                        'status' => 0
                    );
                    $commissionAdd = $this->commission_model->add($dataAdd);
                    $dataMoney = array(
                        'user_id' => $user->user_id,
                        'group_id' => $user->group_id,
                        'parent_id' => $user->parent,
                        'amount' => $comission,
                        'type' => '01',
                        'description' => 'Tiền hoa hồng Mua sỉ',
                        'created_date' => date("Y-m-d H:i:s"),
                        'month_year' => $this->month_year,
                        'status' => 0
                    );

                    $this->persional_money_by_type($dataMoney);
                }
                log_message("debug","Hoa hồng Mua sỉ Partner1 - UserID:".$user->user_id.",Doanh thu:".$revenue.",Phần trăm:".$percent.",Hoa hồng:".$comission.",Loại:01,Tháng:".$this->month_year);
            }
        }
    }

    function wholesale_buy_product_commission_coremember(){
        if(!$this->checkExistCommissionTodayByGroup(10,'01')){
            $this->load->model('commission_model');
            $this->load->model('revenue_model');
            $percent = $this->get_commission_config(10,'01');
            $listUser = $this->get_all_coremember();
            foreach($listUser as $user){
                $revenue = 0;
                $comission = 0;
                // doanh so cay he thong
                $listChild = $this->get_list_child_tree($user->user_id);
                foreach($listChild as $child){
                    $totalChild = $this->get_revenue_by_user($child->user_id,'01');
                    $revenue = $revenue + $totalChild;
                }
                // doanh so ca nhan
                $revenuePrivate =  $this->get_personal_revenue_by_user($user->user_id,'01');
                if($revenuePrivate > 0){
                    // tinh hoa hong ca nhan o day
                    $this->caculate_personal_commission($user,$revenuePrivate,'01','Hoa hồng Mua sỉ cá nhân');
                }

                $comission = $revenue * ($percent/100);
                if($comission > 0){
                    $dataAdd = array(
                        'user_id' => $user->user_id,
                        'group_id' => $user->group_id,
                        'parent_id' => $user->parent,
                        'commission' => $comission,
                        'percent' => $percent,
                        'profit' => $revenue,
                        'type' => '01',
                        'description' => 'Hoa hồng Mua sỉ',
                        'commission_month' => $this->month_year,
                        'created_date' => time(),
                        'created_date_str' => date("d-m-Y",time()),
                        'payment_date' => time(),
                        'payment_status' => 0,
                        'status' => 0
                    );
                    $commissionAdd = $this->commission_model->add($dataAdd);
                    $dataMoney = array(
                        'user_id' => $user->user_id,
                        'group_id' => $user->group_id,
                        'parent_id' => $user->parent,
                        'amount' => $comission,
                        'type' => '01',
                        'description' => 'Tiền hoa hồng Mua sỉ',
                        'created_date' => date("Y-m-d H:i:s"),
                        'month_year' => $this->month_year,
                        'status' => 0
                    );

                    $this->persional_money_by_type($dataMoney);
                }
                log_message("debug","Hoa hồng Mua sỉ CoreMember - UserID:".$user->user_id.",Doanh thu:".$revenue.",Phần trăm:".$percent.",Hoa hồng:".$comission.",Loại:01,Tháng:".$this->month_year);
            }
        }
    }

    function wholesale_buy_product_commission_coreadmin(){
        if(!$this->checkExistCommissionTodayByGroup(12,'01')){
            $this->load->model('commission_model');
            $this->load->model('revenue_model');
            $percent = $this->get_commission_config(12,'01');
            $listUser = $this->get_all_coreadmin();
            foreach($listUser as $user){
                $revenue = 0;
                $comission = 0;
                // doanh so cay he thong
                $listChild = $this->get_list_child_tree($user->user_id);
                foreach($listChild as $child){
                    $totalChild = $this->get_revenue_by_user($child->user_id,'01');
                    $revenue = $revenue + $totalChild;
                }
                // doanh so ca nhan
                $revenuePrivate =  $this->get_personal_revenue_by_user($user->user_id,'01');
                if($revenuePrivate > 0){
                    // tinh hoa hong ca nhan o day
                    $this->caculate_personal_commission($user,$revenuePrivate,'01','Hoa hồng Mua sỉ cá nhân');
                }

                $comission = $revenue * ($percent/100);
                if($comission > 0){
                    $dataAdd = array(
                        'user_id' => $user->user_id,
                        'group_id' => $user->group_id,
                        'parent_id' => $user->parent,
                        'commission' => $comission,
                        'percent' => $percent,
                        'profit' => $revenue,
                        'type' => '01',
                        'description' => 'Hoa hồng Mua sỉ',
                        'commission_month' => $this->month_year,
                        'created_date' => time(),
                        'created_date_str' => date("d-m-Y",time()),
                        'payment_date' => time(),
                        'payment_status' => 0,
                        'status' => 0
                    );
                    $commissionAdd = $this->commission_model->add($dataAdd);
                    $dataMoney = array(
                        'user_id' => $user->user_id,
                        'group_id' => $user->group_id,
                        'parent_id' => $user->parent,
                        'amount' => $comission,
                        'type' => '01',
                        'description' => 'Tiền hoa hồng Mua sỉ',
                        'created_date' => date("Y-m-d H:i:s"),
                        'month_year' => $this->month_year,
                        'status' => 0
                    );

                    $this->persional_money_by_type($dataMoney);
                }
                log_message("debug","Hoa hồng Mua sỉ CoreAdmin - UserID:".$user->user_id.",Doanh thu:".$revenue.",Phần trăm:".$percent.",Hoa hồng:".$comission.",Loại:01,Tháng:".$this->month_year);
            }
        }
    }

    // wholesale sell commission config
    function get_commission_config_wholesale_sell($id){
        $this->load->model('commission_config_model');
        if($id > 0){
            $configObject = $this->commission_config_model->get("*","id = $id");
            if($configObject->commission_rate > 0){
                return $configObject->commission_rate;
            }else{
                return 0;
            }
        }
        return 0;
    }

    function caculate_personal_commission($user,$revenue,$type,$description){
        $percent = $this->get_commission_config(6,$type);
        $comission = $revenue * ($percent/100);
        $dataAdd = array(
            'user_id' => $user->user_id,
            'group_id' => $user->group_id,
            'parent_id' => $user->parent,
            'commission' => $comission,
            'percent' => $percent,
            'profit' => $revenue,
            'type' => $type,
            'description' => $description,
            'commission_month' => $this->month_year,
            'created_date' => time(),
            'created_date_str' => date("d-m-Y",time()),
            'payment_date' => time(),
            'payment_status' => 0,
            'status' => 0
        );
        $commissionAdd = $this->commission_model->add($dataAdd);
        log_message("debug",$description." - UserID:".$user->user_id.",Doanh thu:".$revenue.",Phần trăm:".$percent.",Hoa hồng:".$comission.",Loại:".$type.",Tháng:".$this->month_year);

        $dataMoney = array(
            'user_id' => $user->user_id,
            'group_id' => $user->group_id,
            'parent_id' => $user->parent,
            'amount' => $comission,
            'type' => $type,
            'description' => 'Tiền '.$description,
            'created_date' => date("Y-m-d H:i:s"),
            'month_year' => $this->month_year,
            'status' => 0
        );

        $this->persional_money_by_type($dataMoney);
    }

    // wholesale sell product commission
    function wholesale_sell_product_commission_dev2(){
        if(!$this->checkExistCommissionTodayByGroup(6,'02')){
            $this->load->model('commission_model');
            $this->load->model('revenue_model');
            $percent = $this->get_commission_config(6,'02');
            $listUser = $this->get_all_dev2();
            foreach($listUser as $user){
                $revenue = 0;
                $comission = 0;
                $revenue = $this->get_revenue_by_user($user->user_id,'02');

                $comission = $revenue * ($percent/100);
                if($comission > 0){
                    $dataAdd = array(
                        'user_id' => $user->user_id,
                        'group_id' => $user->group_id,
                        'parent_id' => $user->parent,
                        'commission' => $comission,
                        'percent' => $percent,
                        'profit' => $revenue,
                        'type' => '02',
                        'description' => 'Hoa hồng Bán sỉ',
                        'commission_month' => $this->month_year,
                        'created_date' => time(),
                        'created_date_str' => date("d-m-Y",time()),
                        'payment_date' => time(),
                        'payment_status' => 0,
                        'status' => 0
                    );
                    $commissionAdd = $this->commission_model->add($dataAdd);
                    $dataMoney = array(
                        'user_id' => $user->user_id,
                        'group_id' => $user->group_id,
                        'parent_id' => $user->parent,
                        'amount' => $comission,
                        'type' => '02',
                        'description' => 'Tiền hoa hồng Bán sỉ',
                        'created_date' => date("Y-m-d H:i:s"),
                        'month_year' => $this->month_year,
                        'status' => 0
                    );

                    $this->persional_money_by_type($dataMoney);
                }
                log_message("debug","Hoa hồng Bán sỉ Dev2 - UserID:".$user->user_id.",Doanh thu:".$revenue.",Phần trăm:".$percent.",Hoa hồng:".$comission.",Loại:02,Tháng:".$this->month_year);
            }
        }
    }

    function wholesale_sell_product_commission_dev1(){
        if(!$this->checkExistCommissionTodayByGroup(7,'02')){
            $this->load->model('commission_model');
            $this->load->model('revenue_model');
            $percent = $this->get_commission_config(7,'02');
            $listUser = $this->get_all_dev1();
            foreach($listUser as $user){
                $revenue = 0;
                $comission = 0;
                // doanh so cay he thong
                $listChild = $this->get_list_child_tree($user->user_id);
                foreach($listChild as $child){
                    $totalChild = $this->get_revenue_by_user($child->user_id,'02');
                    $revenue = $revenue + $totalChild;
                }
                // doanh so ca nhan
                $revenuePrivate =  $this->get_personal_revenue_by_user($user->user_id,'02');
                if($revenuePrivate > 0){
                    // tinh hoa hong ca nhan o day
                    $this->caculate_personal_commission($user,$revenuePrivate,'02','Hoa hồng Bán sỉ cá nhân');
                }

                $comission = $revenue * ($percent/100);
                if($comission > 0){
                    $dataAdd = array(
                        'user_id' => $user->user_id,
                        'group_id' => $user->group_id,
                        'parent_id' => $user->parent,
                        'commission' => $comission,
                        'percent' => $percent,
                        'profit' => $revenue,
                        'type' => '02',
                        'description' => 'Hoa hồng Bán sỉ',
                        'commission_month' => $this->month_year,
                        'created_date' => time(),
                        'created_date_str' => date("d-m-Y",time()),
                        'payment_date' => time(),
                        'payment_status' => 0,
                        'status' => 0
                    );
                    $commissionAdd = $this->commission_model->add($dataAdd);
                    $dataMoney = array(
                        'user_id' => $user->user_id,
                        'group_id' => $user->group_id,
                        'parent_id' => $user->parent,
                        'amount' => $comission,
                        'type' => '02',
                        'description' => 'Tiền hoa hồng Bán sỉ',
                        'created_date' => date("Y-m-d H:i:s"),
                        'month_year' => $this->month_year,
                        'status' => 0
                    );

                    $this->persional_money_by_type($dataMoney);
                }
                log_message("debug","Hoa hồng Bán sỉ Dev1 - UserID:".$user->user_id.",Doanh thu:".$revenue.",Phần trăm:".$percent.",Hoa hồng:".$comission.",Loại:02,Tháng:".$this->month_year);
            }
        }
    }

    function wholesale_sell_product_commission_partner2(){
        if(!$this->checkExistCommissionTodayByGroup(8,'02')){
            $this->load->model('commission_model');
            $this->load->model('revenue_model');
            $this->load->model('commission_empty_position_model');
            $percent = $this->get_commission_config(8,'02');
            $listUser = $this->get_all_partner2();
            foreach($listUser as $user){
                $revenue = 0;
                $comission = 0;
                // doanh so cay he thong
                $listChild = $this->get_list_child_tree($user->user_id);
                foreach($listChild as $child){
                    $totalChild = $this->get_revenue_by_user($child->user_id,'02');
                    $revenue = $revenue + $totalChild;
                    if($child->group_id == Developer2User){

                        // 01
                        $dev1_percent_01 = 0;

                        if($child->group_id == Developer2User){
                            $dev1_percent_01 = $this->get_commission_config(Developer1User,'01');
                        }

                        $revenueChild = 0;
                        $revenueChild = $this->get_revenue_by_user($child->user_id,'01');
                        $dataPositionCommission_01 = array(
                            'user_id' => $user->user_id,
                            'group_id' => $user->group_id,
                            'parent_id' => $user->parent,
                            'user_child_id' => $child->user_id,
                            'user_child_profit' => $revenueChild,
                            'dev1_percent' => $dev1_percent_01,
                            'partner2_percent' => 0,
                            'partner1_percent' => 0,
                            'coremember_percent' => 0,
                            'type' => '01',
                            'created_date_str' => date("d-m-Y"),
                            'created_date' => time(),
                            'created_month_year' => $this->month_year
                        );
                        if(!$this->checkExistEmptyByType($user->user_id,$child->user_id,'01') && $revenueChild > 0){
                            $dataPositionCommissionAdd_01 = $this->commission_empty_position_model->add($dataPositionCommission_01);
                            log_message("debug","Vị trí trống Partner2 - UserID:".$user->user_id.",Con:".$child->user_id.",Doanh thu con:".$revenueChild.",Loại:01,Tháng:".$this->month_year);
                        }

                        // 02
                        $dev1_percent_02 = 0;

                        if($child->group_id == Developer2User){
                            $dev1_percent_02 = $this->get_commission_config(Developer1User,'02');

                        }

                        $revenueChild = 0;
                        $revenueChild = $this->get_revenue_by_user($child->user_id,'02');
                        $dataPositionCommission_02 = array(
                            'user_id' => $user->user_id,
                            'group_id' => $user->group_id,
                            'parent_id' => $user->parent,
                            'user_child_id' => $child->user_id,
                            'user_child_profit' => $revenueChild,
                            'dev1_percent' => $dev1_percent_02,
                            'partner2_percent' => 0,
                            'partner1_percent' => 0,
                            'coremember_percent' => 0,
                            'type' => '02',
                            'created_date_str' => date("d-m-Y"),
                            'created_date' => time(),
                            'created_month_year' => $this->month_year
                        );
                        if(!$this->checkExistEmptyByType($user->user_id,$child->user_id,'02') && $revenueChild > 0) {
                            $dataPositionCommissionAdd_02 = $this->commission_empty_position_model->add($dataPositionCommission_02);
                            log_message("debug","Vị trí trống Partner2 - UserID:".$user->user_id.",Con:".$child->user_id.",Doanh thu con:".$revenueChild.",Loại:02,Tháng:".$this->month_year);
                        }

                        // 03
                        $dev1_percent_03 = 0;

                        if($child->group_id == Developer2User){
                            $dev1_percent_03 = $this->get_config_solution_commission(Developer1User);
                        }

                        $revenueChild = 0;
                        $revenueChild = $this->get_revenue_by_user($child->user_id,'03');

                        $dataPositionCommission_03 = array(
                            'user_id' => $user->user_id,
                            'group_id' => $user->group_id,
                            'parent_id' => $user->parent,
                            'user_child_id' => $child->user_id,
                            'user_child_profit' => $revenueChild,
                            'dev1_percent' => $dev1_percent_03,
                            'partner2_percent' => 0,
                            'partner1_percent' => 0,
                            'coremember_percent' => 0,
                            'type' => '03',
                            'created_date_str' => date("d-m-Y"),
                            'created_date' => time(),
                            'created_month_year' => $this->month_year
                        );
                        if(!$this->checkExistEmptyByType($user->user_id,$child->user_id,'03') && $revenueChild > 0) {
                            $dataPositionCommissionAdd_03 = $this->commission_empty_position_model->add($dataPositionCommission_03);
                            log_message("debug","Vị trí trống Partner2 - UserID:".$user->user_id.",Con:".$child->user_id.",Doanh thu con:".$revenueChild.",Loại:03,Tháng:".$this->month_year);
                        }

                        // 04
                        $dev1_percent_04 = 0;

                        if($child->group_id == Developer2User){
                            $dev1_percent_04 = $this->get_commission_config(Developer1User,'04');
                        }

                        $revenueChild = 0;
                        $revenueChild = $this->get_revenue_by_user($child->user_id,'04');

                        $dataPositionCommission_04 = array(
                            'user_id' => $user->user_id,
                            'group_id' => $user->group_id,
                            'parent_id' => $user->parent,
                            'user_child_id' => $child->user_id,
                            'user_child_profit' => $revenueChild,
                            'dev1_percent' => $dev1_percent_04,
                            'partner2_percent' => 0,
                            'partner1_percent' => 0,
                            'coremember_percent' => 0,
                            'type' => '04',
                            'created_date_str' => date("d-m-Y"),
                            'created_date' => time(),
                            'created_month_year' => $this->month_year
                        );
                        if(!$this->checkExistEmptyByType($user->user_id,$child->user_id,'04') && $revenueChild > 0) {
                            $dataPositionCommissionAdd_04 = $this->commission_empty_position_model->add($dataPositionCommission_04);
                            log_message("debug","Vị trí trống Partner2 - UserID:".$user->user_id.",Con:".$child->user_id.",Doanh thu con:".$revenueChild.",Loại:04,Tháng:".$this->month_year);
                        }

                        // 05
                        $dev1_percent_05 = 0;

                        if($child->group_id == Developer2User){
                            $dev1_percent_05 = $this->get_commission_config(Developer1User,'05');
                        }

                        $revenueChild = 0;
                        $revenueChild = $this->get_revenue_by_user($child->user_id,'05');

                        $dataPositionCommission_05 = array(
                            'user_id' => $user->user_id,
                            'group_id' => $user->group_id,
                            'parent_id' => $user->parent,
                            'user_child_id' => $child->user_id,
                            'user_child_profit' => $revenueChild,
                            'dev1_percent' => $dev1_percent_05,
                            'partner2_percent' => 0,
                            'partner1_percent' => 0,
                            'coremember_percent' => 0,
                            'type' => '05',
                            'created_date_str' => date("d-m-Y"),
                            'created_date' => time(),
                            'created_month_year' => $this->month_year
                        );
                        if(!$this->checkExistEmptyByType($user->user_id,$child->user_id,'05') && $revenueChild > 0) {
                            $dataPositionCommissionAdd_05 = $this->commission_empty_position_model->add($dataPositionCommission_05);
                            log_message("debug","Vị trí trống Partner2 - UserID:".$user->user_id.",Con:".$child->user_id.",Doanh thu con:".$revenueChild.",Loại:05,Tháng:".$this->month_year);
                        }
                    }
                }
                // doanh so ca nhan
                $revenuePrivate =  $this->get_personal_revenue_by_user($user->user_id,'02');
                if($revenuePrivate > 0){
                    // tinh hoa hong ca nhan o day
                    $this->caculate_personal_commission($user,$revenuePrivate,'02','Hoa hồng Bán sỉ cá nhân');
                }

                $comission = $revenue * ($percent/100);
                if($comission > 0){
                    $dataAdd = array(
                        'user_id' => $user->user_id,
                        'group_id' => $user->group_id,
                        'parent_id' => $user->parent,
                        'commission' => $comission,
                        'percent' => $percent,
                        'profit' => $revenue,
                        'type' => '02',
                        'description' => 'Hoa hồng Bán sỉ',
                        'commission_month' => $this->month_year,
                        'created_date' => time(),
                        'created_date_str' => date("d-m-Y",time()),
                        'payment_date' => time(),
                        'payment_status' => 0,
                        'status' => 0
                    );
                    $commissionAdd = $this->commission_model->add($dataAdd);
                    $dataMoney = array(
                        'user_id' => $user->user_id,
                        'group_id' => $user->group_id,
                        'parent_id' => $user->parent,
                        'amount' => $comission,
                        'type' => '02',
                        'description' => 'Tiền hoa hồng Bán sỉ',
                        'created_date' => date("Y-m-d H:i:s"),
                        'month_year' => $this->month_year,
                        'status' => 0
                    );

                    $this->persional_money_by_type($dataMoney);
                }
                log_message("debug","Hoa hồng Bán sỉ Partner2 - UserID:".$user->user_id.",Doanh thu:".$revenue.",Phần trăm:".$percent.",Hoa hồng:".$comission.",Loại:02,Tháng:".$this->month_year);

            }
        }
    }

    function wholesale_sell_product_commission_partner1(){
        if(!$this->checkExistCommissionTodayByGroup(9,'02')){
            $this->load->model('commission_model');
            $this->load->model('revenue_model');
            $this->load->model('commission_empty_position_model');
            $percent = $this->get_commission_config(9,'02');
            $listUser = $this->get_all_partner1();
            foreach($listUser as $user){
                $revenue = 0;
                $comission = 0;
                // doanh so cay he thong
                $listChild = $this->get_list_child_tree($user->user_id);
                foreach($listChild as $child){
                    $totalChild = $this->get_revenue_by_user($child->user_id,'02');
                    $revenue = $revenue + $totalChild;
                    if($child->group_id == Developer2User || $child->group_id == Developer1User){
                        // 01
                        $dev1_percent_01 = 0;
                        $partner2_percent_01 = 0;
                        if($child->group_id == Developer2User){
                            $dev1_percent_01 = $this->get_commission_config(Developer1User,'01');
                            $partner2_percent_01 = $this->get_commission_config(Partner2User,'01');
                        }

                        if($child->group_id == Developer1User){
                            $partner2_percent_01 = $this->get_commission_config(Partner2User,'01');
                        }
                        $revenueChild = 0;
                        $revenueChild = $this->get_revenue_by_user($child->user_id,'01');
                        $dataPositionCommission_01 = array(
                            'user_id' => $user->user_id,
                            'group_id' => $user->group_id,
                            'parent_id' => $user->parent,
                            'user_child_id' => $child->user_id,
                            'user_child_profit' => $revenueChild,
                            'dev1_percent' => $dev1_percent_01,
                            'partner2_percent' => $partner2_percent_01,
                            'partner1_percent' => 0,
                            'coremember_percent' => 0,
                            'type' => '01',
                            'created_date_str' => date("d-m-Y"),
                            'created_date' => time(),
                            'created_month_year' => $this->month_year
                        );
                        if(!$this->checkExistEmptyByType($user->user_id,$child->user_id,'01') && $revenueChild > 0) {
                            $dataPositionCommissionAdd_01 = $this->commission_empty_position_model->add($dataPositionCommission_01);
                            log_message("debug","Vị trí trống Partner1 - UserID:".$user->user_id.",Con:".$child->user_id.",Doanh thu con:".$revenueChild.",Loại:01,Tháng:".$this->month_year);
                        }

                        // 02
                        $dev1_percent_02 = 0;
                        $partner2_percent_02 = 0;
                        if($child->group_id == Developer2User){
                            $dev1_percent_02 = $this->get_commission_config(Developer1User,'02');
                            $partner2_percent_02 = $this->get_commission_config(Partner2User,'02');
                        }

                        if($child->group_id == Developer1User){
                            $partner2_percent_02 = $this->get_commission_config(Partner2User,'02');
                        }
                        $revenueChild = 0;
                        $revenueChild = $this->get_revenue_by_user($child->user_id,'02');
                        $dataPositionCommission_02 = array(
                            'user_id' => $user->user_id,
                            'group_id' => $user->group_id,
                            'parent_id' => $user->parent,
                            'user_child_id' => $child->user_id,
                            'user_child_profit' => $revenueChild,
                            'dev1_percent' => $dev1_percent_02,
                            'partner2_percent' => $partner2_percent_02,
                            'partner1_percent' => 0,
                            'coremember_percent' => 0,
                            'type' => '02',
                            'created_date_str' => date("d-m-Y"),
                            'created_date' => time(),
                            'created_month_year' => $this->month_year
                        );
                        if(!$this->checkExistEmptyByType($user->user_id,$child->user_id,'02') && $revenueChild > 0) {
                            $dataPositionCommissionAdd_02 = $this->commission_empty_position_model->add($dataPositionCommission_02);
                            log_message("debug","Vị trí trống Partner1 - UserID:".$user->user_id.",Con:".$child->user_id.",Doanh thu con:".$revenueChild.",Loại:02,Tháng:".$this->month_year);
                        }

                        // 03
                        $dev1_percent_03 = 0;
                        $partner2_percent_03 = 0;
                        if($child->group_id == Developer2User){
                            $dev1_percent_03 = $this->get_config_solution_commission(Developer1User);
                            $partner2_percent_03 = $this->get_config_solution_commission(Partner2User);
                        }

                        if($child->group_id == Developer1User){
                            $partner2_percent_03 = $this->get_config_solution_commission(Partner2User);
                        }
                        $revenueChild = 0;
                        $revenueChild = $this->get_revenue_by_user($child->user_id,'03');

                        $dataPositionCommission_03 = array(
                            'user_id' => $user->user_id,
                            'group_id' => $user->group_id,
                            'parent_id' => $user->parent,
                            'user_child_id' => $child->user_id,
                            'user_child_profit' => $revenueChild,
                            'dev1_percent' => $dev1_percent_03,
                            'partner2_percent' => $partner2_percent_03,
                            'partner1_percent' => 0,
                            'coremember_percent' => 0,
                            'type' => '03',
                            'created_date_str' => date("d-m-Y"),
                            'created_date' => time(),
                            'created_month_year' => $this->month_year
                        );
                        if(!$this->checkExistEmptyByType($user->user_id,$child->user_id,'03') && $revenueChild > 0) {
                            $dataPositionCommissionAdd_03 = $this->commission_empty_position_model->add($dataPositionCommission_03);
                            log_message("debug","Vị trí trống Partner1 - UserID:".$user->user_id.",Con:".$child->user_id.",Doanh thu con:".$revenueChild.",Loại:03,Tháng:".$this->month_year);
                        }

                        // 04
                        $dev1_percent_04 = 0;
                        $partner2_percent_04 = 0;
                        if($child->group_id == Developer2User){
                            $dev1_percent_04 = $this->get_commission_config(Developer1User,'04');
                            $partner2_percent_04 = $this->get_commission_config(Partner2User,'04');
                        }

                        if($child->group_id == Developer1User){
                            $partner2_percent_04 = $this->get_commission_config(Partner2User,'04');
                        }
                        $revenueChild = 0;
                        $revenueChild = $this->get_revenue_by_user($child->user_id,'04');

                        $dataPositionCommission_04 = array(
                            'user_id' => $user->user_id,
                            'group_id' => $user->group_id,
                            'parent_id' => $user->parent,
                            'user_child_id' => $child->user_id,
                            'user_child_profit' => $revenueChild,
                            'dev1_percent' => $dev1_percent_04,
                            'partner2_percent' => $partner2_percent_04,
                            'partner1_percent' => 0,
                            'coremember_percent' => 0,
                            'type' => '04',
                            'created_date_str' => date("d-m-Y"),
                            'created_date' => time(),
                            'created_month_year' => $this->month_year
                        );
                        if(!$this->checkExistEmptyByType($user->user_id,$child->user_id,'04') && $revenueChild > 0) {
                            $dataPositionCommissionAdd_04 = $this->commission_empty_position_model->add($dataPositionCommission_04);
                            log_message("debug","Vị trí trống Partner1 - UserID:".$user->user_id.",Con:".$child->user_id.",Doanh thu con:".$revenueChild.",Loại:04,Tháng:".$this->month_year);
                        }

                        // 05
                        $dev1_percent_05 = 0;
                        $partner2_percent_05 = 0;
                        if($child->group_id == Developer2User){
                            $dev1_percent_05 = $this->get_commission_config(Developer1User,'05');
                            $partner2_percent_05 = $this->get_commission_config(Partner2User,'05');
                        }

                        if($child->group_id == Developer1User){
                            $partner2_percent_05 = $this->get_commission_config(Partner2User,'05');
                        }
                        $revenueChild = 0;
                        $revenueChild = $this->get_revenue_by_user($child->user_id,'05');

                        $dataPositionCommission_05 = array(
                            'user_id' => $user->user_id,
                            'group_id' => $user->group_id,
                            'parent_id' => $user->parent,
                            'user_child_id' => $child->user_id,
                            'user_child_profit' => $revenueChild,
                            'dev1_percent' => $dev1_percent_05,
                            'partner2_percent' => $partner2_percent_05,
                            'partner1_percent' => 0,
                            'coremember_percent' => 0,
                            'type' => '05',
                            'created_date_str' => date("d-m-Y"),
                            'created_date' => time(),
                            'created_month_year' => $this->month_year
                        );
                        if(!$this->checkExistEmptyByType($user->user_id,$child->user_id,'05') && $revenueChild > 0) {
                            $dataPositionCommissionAdd_05 = $this->commission_empty_position_model->add($dataPositionCommission_05);
                            log_message("debug","Vị trí trống Partner1 - UserID:".$user->user_id.",Con:".$child->user_id.",Doanh thu con:".$revenueChild.",Loại:05,Tháng:".$this->month_year);
                        }

                    }
                }
                // doanh so ca nhan
                $revenuePrivate =  $this->get_personal_revenue_by_user($user->user_id,'02');
                if($revenuePrivate > 0){
                    // tinh hoa hong ca nhan o day
                    $this->caculate_personal_commission($user,$revenuePrivate,'02','Hoa hồng Bán sỉ cá nhân');
                }

                $comission = $revenue * ($percent/100);
                if($comission > 0){
                    $dataAdd = array(
                        'user_id' => $user->user_id,
                        'group_id' => $user->group_id,
                        'parent_id' => $user->parent,
                        'commission' => $comission,
                        'percent' => $percent,
                        'profit' => $revenue,
                        'type' => '02',
                        'description' => 'Hoa hồng Bán sỉ',
                        'commission_month' => $this->month_year,
                        'created_date' => time(),
                        'created_date_str' => date("d-m-Y",time()),
                        'payment_date' => time(),
                        'payment_status' => 0,
                        'status' => 0
                    );
                    $commissionAdd = $this->commission_model->add($dataAdd);
                    $dataMoney = array(
                        'user_id' => $user->user_id,
                        'group_id' => $user->group_id,
                        'parent_id' => $user->parent,
                        'amount' => $comission,
                        'type' => '02',
                        'description' => 'Tiền hoa hồng Bán sỉ',
                        'created_date' => date("Y-m-d H:i:s"),
                        'month_year' => $this->month_year,
                        'status' => 0
                    );

                    $this->persional_money_by_type($dataMoney);
                }
                log_message("debug","Hoa hồng Bán sỉ Partner1 - UserID:".$user->user_id.",Doanh thu:".$revenue.",Phần trăm:".$percent.",Hoa hồng:".$comission.",Loại:02,Tháng:".$this->month_year);
            }
        }
    }

    function wholesale_sell_product_commission_coremember(){
        if(!$this->checkExistCommissionTodayByGroup(10,'02')){
            $this->load->model('commission_model');
            $this->load->model('revenue_model');
            $this->load->model('commission_empty_position_model');

            $percent = $this->get_commission_config(10,'02');
            $listUser = $this->get_all_coremember();
            foreach($listUser as $user){
                $revenue = 0;
                $comission = 0;
                // doanh so cay he thong
                $listChild = $this->get_list_child_tree($user->user_id);
                foreach($listChild as $child){
                    $totalChild = $this->get_revenue_by_user($child->user_id,'02');
                    $revenue = $revenue + $totalChild;
                    if($child->group_id == Developer2User || $child->group_id == Developer1User || $child->group_id == Partner2User){
                        // 01
                        $dev1_percent_01 = 0;
                        $partner2_percent_01 = 0;
                        $partner1_percent_01 = 0;
                        if($child->group_id == Developer2User){
                            $dev1_percent_01 = $this->get_commission_config(Developer1User,'01');
                            $partner2_percent_01 = $this->get_commission_config(Partner2User,'01');
                            $partner1_percent_01 = $this->get_commission_config(Partner1User,'01');
                        }

                        if($child->group_id == Developer1User){
                            $partner2_percent_01 = $this->get_commission_config(Partner2User,'01');
                            $partner1_percent_01 = $this->get_commission_config(Partner1User,'01');
                        }

                        if($child->group_id == Partner2User){
                            $partner1_percent_01 = $this->get_commission_config(Partner1User,'01');
                        }
                        $revenueChild = 0;
                        $revenueChild = $this->get_revenue_by_user($child->user_id,'01');

                        $dataPositionCommission_01 = array(
                            'user_id' => $user->user_id,
                            'group_id' => $user->group_id,
                            'parent_id' => $user->parent,
                            'user_child_id' => $child->user_id,
                            'user_child_profit' => $revenueChild,
                            'dev1_percent' => $dev1_percent_01,
                            'partner2_percent' => $partner2_percent_01,
                            'partner1_percent' => $partner1_percent_01,
                            'coremember_percent' => 0,
                            'type' => '01',
                            'created_date_str' => date("d-m-Y"),
                            'created_date' => time(),
                            'created_month_year' => $this->month_year
                        );
                        if(!$this->checkExistEmptyByType($user->user_id,$child->user_id,'01') && $revenueChild > 0) {
                            $dataPositionCommissionAdd_01 = $this->commission_empty_position_model->add($dataPositionCommission_01);
                            log_message("debug","Vị trí trống CoreMember - UserID:".$user->user_id.",Con:".$child->user_id.",Doanh thu con:".$revenueChild.",Loại:01,Tháng:".$this->month_year);
                        }

                        // 02
                        $dev1_percent_02 = 0;
                        $partner2_percent_02 = 0;
                        $partner1_percent_02 = 0;
                        if($child->group_id == Developer2User){
                            $dev1_percent_02 = $this->get_commission_config(Developer1User,'02');
                            $partner2_percent_02 = $this->get_commission_config(Partner2User,'02');
                            $partner1_percent_02 = $this->get_commission_config(Partner1User,'02');
                        }

                        if($child->group_id == Developer1User){
                            $partner2_percent_02 = $this->get_commission_config(Partner2User,'02');
                            $partner1_percent_02 = $this->get_commission_config(Partner1User,'02');
                        }

                        if($child->group_id == Partner2User){
                            $partner1_percent_02 = $this->get_commission_config(Partner1User,'02');
                        }
                        $revenueChild = 0;
                        $revenueChild = $this->get_revenue_by_user($child->user_id,'02');

                        $dataPositionCommission_02 = array(
                            'user_id' => $user->user_id,
                            'group_id' => $user->group_id,
                            'parent_id' => $user->parent,
                            'user_child_id' => $child->user_id,
                            'user_child_profit' => $revenueChild,
                            'dev1_percent' => $dev1_percent_02,
                            'partner2_percent' => $partner2_percent_02,
                            'partner1_percent' => $partner1_percent_02,
                            'coremember_percent' => 0,
                            'type' => '02',
                            'created_date_str' => date("d-m-Y"),
                            'created_date' => time(),
                            'created_month_year' => $this->month_year
                        );
                        if(!$this->checkExistEmptyByType($user->user_id,$child->user_id,'02') && $revenueChild > 0) {
                            $dataPositionCommissionAdd_02 = $this->commission_empty_position_model->add($dataPositionCommission_02);
                            log_message("debug","Vị trí trống CoreMember - UserID:".$user->user_id.",Con:".$child->user_id.",Doanh thu con:".$revenueChild.",Loại:02,Tháng:".$this->month_year);
                        }

                        // 03
                        $dev1_percent_03 = 0;
                        $partner2_percent_03 = 0;
                        $partner1_percent_03 = 0;
                        if($child->group_id == Developer2User){
                            $dev1_percent_03 = $this->get_config_solution_commission(Developer1User);
                            $partner2_percent_03 = $this->get_config_solution_commission(Partner2User);
                            $partner1_percent_03 = $this->get_config_solution_commission(Partner1User);
                        }

                        if($child->group_id == Developer1User){
                            $partner2_percent_03 = $this->get_config_solution_commission(Partner2User);
                            $partner1_percent_03 = $this->get_config_solution_commission(Partner1User);
                        }

                        if($child->group_id == Partner2User){
                            $partner1_percent_03 = $this->get_config_solution_commission(Partner1User);
                        }
                        $revenueChild = 0;
                        $revenueChild = $this->get_revenue_by_user($child->user_id,'03');

                        $dataPositionCommission_03 = array(
                            'user_id' => $user->user_id,
                            'group_id' => $user->group_id,
                            'parent_id' => $user->parent,
                            'user_child_id' => $child->user_id,
                            'user_child_profit' => $revenueChild,
                            'dev1_percent' => $dev1_percent_03,
                            'partner2_percent' => $partner2_percent_03,
                            'partner1_percent' => $partner1_percent_03,
                            'coremember_percent' => 0,
                            'type' => '03',
                            'created_date_str' => date("d-m-Y"),
                            'created_date' => time(),
                            'created_month_year' => $this->month_year
                        );
                        if(!$this->checkExistEmptyByType($user->user_id,$child->user_id,'03') && $revenueChild > 0) {
                            $dataPositionCommissionAdd_03 = $this->commission_empty_position_model->add($dataPositionCommission_03);
                            log_message("debug","Vị trí trống CoreMember - UserID:".$user->user_id.",Con:".$child->user_id.",Doanh thu con:".$revenueChild.",Loại:03,Tháng:".$this->month_year);
                        }

                        // 04
                        $dev1_percent_04 = 0;
                        $partner2_percent_04 = 0;
                        $partner1_percent_04 = 0;
                        if($child->group_id == Developer2User){
                            $dev1_percent_04 = $this->get_commission_config(Developer1User,'04');
                            $partner2_percent_04 = $this->get_commission_config(Partner2User,'04');
                            $partner1_percent_04 = $this->get_commission_config(Partner1User,'04');
                        }

                        if($child->group_id == Developer1User){
                            $partner2_percent_04 = $this->get_commission_config(Partner2User,'04');
                            $partner1_percent_04 = $this->get_commission_config(Partner1User,'04');
                        }

                        if($child->group_id == Partner2User){
                            $partner1_percent_04 = $this->get_commission_config(Partner1User,'04');
                        }
                        $revenueChild = 0;
                        $revenueChild = $this->get_revenue_by_user($child->user_id,'04');

                        $dataPositionCommission_04 = array(
                            'user_id' => $user->user_id,
                            'group_id' => $user->group_id,
                            'parent_id' => $user->parent,
                            'user_child_id' => $child->user_id,
                            'user_child_profit' => $revenueChild,
                            'dev1_percent' => $dev1_percent_04,
                            'partner2_percent' => $partner2_percent_04,
                            'partner1_percent' => $partner1_percent_04,
                            'coremember_percent' => 0,
                            'type' => '04',
                            'created_date_str' => date("d-m-Y"),
                            'created_date' => time(),
                            'created_month_year' => $this->month_year
                        );
                        if(!$this->checkExistEmptyByType($user->user_id,$child->user_id,'04') && $revenueChild > 0) {
                            $dataPositionCommissionAdd_04 = $this->commission_empty_position_model->add($dataPositionCommission_04);
                            log_message("debug","Vị trí trống CoreMember - UserID:".$user->user_id.",Con:".$child->user_id.",Doanh thu con:".$revenueChild.",Loại:04,Tháng:".$this->month_year);
                        }

                        // 05
                        $dev1_percent_05 = 0;
                        $partner2_percent_05 = 0;
                        $partner1_percent_05 = 0;
                        if($child->group_id == Developer2User){
                            $dev1_percent_05 = $this->get_commission_config(Developer1User,'05');
                            $partner2_percent_05 = $this->get_commission_config(Partner2User,'05');
                            $partner1_percent_05 = $this->get_commission_config(Partner1User,'05');
                        }

                        if($child->group_id == Developer1User){
                            $partner2_percent_05 = $this->get_commission_config(Partner2User,'05');
                            $partner1_percent_05 = $this->get_commission_config(Partner1User,'05');
                        }

                        if($child->group_id == Partner2User){
                            $partner1_percent_05 = $this->get_commission_config(Partner1User,'05');
                        }
                        $revenueChild = 0;
                        $revenueChild = $this->get_revenue_by_user($child->user_id,'05');

                        $dataPositionCommission_05 = array(
                            'user_id' => $user->user_id,
                            'group_id' => $user->group_id,
                            'parent_id' => $user->parent,
                            'user_child_id' => $child->user_id,
                            'user_child_profit' => $revenueChild,
                            'dev1_percent' => $dev1_percent_05,
                            'partner2_percent' => $partner2_percent_05,
                            'partner1_percent' => $partner1_percent_05,
                            'coremember_percent' => 0,
                            'type' => '05',
                            'created_date_str' => date("d-m-Y"),
                            'created_date' => time(),
                            'created_month_year' => $this->month_year
                        );
                        if(!$this->checkExistEmptyByType($user->user_id,$child->user_id,'05') && $revenueChild > 0) {
                            $dataPositionCommissionAdd_05 = $this->commission_empty_position_model->add($dataPositionCommission_05);
                            log_message("debug","Vị trí trống CoreMember - UserID:".$user->user_id.",Con:".$child->user_id.",Doanh thu con:".$revenueChild.",Loại:05,Tháng:".$this->month_year);
                        }

                    }
                }
                // doanh so ca nhan
                $revenuePrivate =  $this->get_personal_revenue_by_user($user->user_id,'02');
                if($revenuePrivate > 0){
                    // tinh hoa hong ca nhan o day
                    $this->caculate_personal_commission($user,$revenuePrivate,'02','Hoa hồng Bán sỉ cá nhân');
                }

                $comission = $revenue * ($percent/100);
                if($comission > 0){
                    $dataAdd = array(
                        'user_id' => $user->user_id,
                        'group_id' => $user->group_id,
                        'parent_id' => $user->parent,
                        'commission' => $comission,
                        'percent' => $percent,
                        'profit' => $revenue,
                        'type' => '02',
                        'description' => 'Hoa hồng Bán sỉ',
                        'commission_month' => $this->month_year,
                        'created_date' => time(),
                        'created_date_str' => date("d-m-Y",time()),
                        'payment_date' => time(),
                        'payment_status' => 0,
                        'status' => 0
                    );
                    $commissionAdd = $this->commission_model->add($dataAdd);
                    $dataMoney = array(
                        'user_id' => $user->user_id,
                        'group_id' => $user->group_id,
                        'parent_id' => $user->parent,
                        'amount' => $comission,
                        'type' => '02',
                        'description' => 'Tiền hoa hồng Bán sỉ',
                        'created_date' => date("Y-m-d H:i:s"),
                        'month_year' => $this->month_year,
                        'status' => 0
                    );

                    $this->persional_money_by_type($dataMoney);
                }
                log_message("debug","Hoa hồng Bán sỉ CoreMember - UserID:".$user->user_id.",Doanh thu:".$revenue.",Phần trăm:".$percent.",Hoa hồng:".$comission.",Loại:02,Tháng:".$this->month_year);

            }
        }
    }

    function wholesale_sell_product_commission_coreadmin(){
        if(!$this->checkExistCommissionTodayByGroup(12,'02')){
            $this->load->model('commission_model');
            $this->load->model('revenue_model');
            $this->load->model('commission_empty_position_model');
            $percent = $this->get_commission_config(12,'02');
            $listUser = $this->get_all_coreadmin();
            foreach($listUser as $user){
                $revenue = 0;
                $comission = 0;
                // doanh so cay he thong
                $listChild = $this->get_list_child_tree($user->user_id);
                foreach($listChild as $child){
                    $totalChild = $this->get_revenue_by_user($child->user_id,'02');
                    $revenue = $revenue + $totalChild;
                    if($child->group_id == Developer2User || $child->group_id == Developer1User || $child->group_id == Partner2User || $child->group_id ==  Partner1User){
                        // 01
                        $dev1_percent_01 = 0;
                        $partner2_percent_01 = 0;
                        $partner1_percent_01 = 0;
                        $coremember_percent_01 = 0;
                        if($child->group_id == Developer2User){
                            $dev1_percent_01 = $this->get_commission_config(Developer1User,'01');
                            $partner2_percent_01 = $this->get_commission_config(Partner2User,'01');
                            $partner1_percent_01 = $this->get_commission_config(Partner1User,'01');
                            $coremember_percent_01 = $this->get_commission_config(CoreMemberUser,'01');
                        }

                        if($child->group_id == Developer1User){
                            $partner2_percent_01 = $this->get_commission_config(Partner2User,'01');
                            $partner1_percent_01 = $this->get_commission_config(Partner1User,'01');
                            $coremember_percent_01 = $this->get_commission_config(CoreMemberUser,'01');
                        }

                        if($child->group_id == Partner2User){
                            $partner1_percent_01 = $this->get_commission_config(Partner1User,'01');
                            $coremember_percent_01 = $this->get_commission_config(CoreMemberUser,'01');
                        }
                        if($child->group_id == Partner1User){
                            $coremember_percent_01 = $this->get_commission_config(CoreMemberUser,'01');
                        }
                        $revenueChild = 0;
                        $revenueChild = $this->get_revenue_by_user($child->user_id,'01');

                        $dataPositionCommission_01 = array(
                            'user_id' => $user->user_id,
                            'group_id' => $user->group_id,
                            'parent_id' => $user->parent,
                            'user_child_id' => $child->user_id,
                            'user_child_profit' => $revenueChild,
                            'dev1_percent' => $dev1_percent_01,
                            'partner2_percent' => $partner2_percent_01,
                            'partner1_percent' => $partner1_percent_01,
                            'coremember_percent' => $coremember_percent_01,
                            'type' => '01',
                            'created_date_str' => date("d-m-Y"),
                            'created_date' => time(),
                            'created_month_year' => $this->month_year
                        );
                        if(!$this->checkExistEmptyByType($user->user_id,$child->user_id,'01') && $revenueChild > 0) {
                            $dataPositionCommissionAdd_01 = $this->commission_empty_position_model->add($dataPositionCommission_01);
                            log_message("debug","Vị trí trống CoreAdmin - UserID:".$user->user_id.",Con:".$child->user_id.",Doanh thu con:".$revenueChild.",Loại:01,Tháng:".$this->month_year);
                        }

                        // 02
                        $dev1_percent_02 = 0;
                        $partner2_percent_02 = 0;
                        $partner1_percent_02 = 0;
                        $coremember_percent_02 = 0;
                        if($child->group_id == Developer2User){
                            $dev1_percent_02 = $this->get_commission_config(Developer1User,'02');
                            $partner2_percent_02 = $this->get_commission_config(Partner2User,'02');
                            $partner1_percent_02 = $this->get_commission_config(Partner1User,'02');
                            $coremember_percent_02 = $this->get_commission_config(CoreMemberUser,'02');
                        }

                        if($child->group_id == Developer1User){
                            $partner2_percent_02 = $this->get_commission_config(Partner2User,'02');
                            $partner1_percent_02 = $this->get_commission_config(Partner1User,'02');
                            $coremember_percent_02 = $this->get_commission_config(CoreMemberUser,'02');
                        }

                        if($child->group_id == Partner2User){
                            $partner1_percent_02 = $this->get_commission_config(Partner1User,'02');
                            $coremember_percent_02 = $this->get_commission_config(CoreMemberUser,'02');
                        }
                        if($child->group_id == Partner1User){
                            $coremember_percent_02 = $this->get_commission_config(CoreMemberUser,'02');
                        }
                        $revenueChild = 0;
                        $revenueChild = $this->get_revenue_by_user($child->user_id,'02');

                        $dataPositionCommission_02 = array(
                            'user_id' => $user->user_id,
                            'group_id' => $user->group_id,
                            'parent_id' => $user->parent,
                            'user_child_id' => $child->user_id,
                            'user_child_profit' => $revenueChild,
                            'dev1_percent' => $dev1_percent_02,
                            'partner2_percent' => $partner2_percent_02,
                            'partner1_percent' => $partner1_percent_02,
                            'coremember_percent' => $coremember_percent_02,
                            'type' => '02',
                            'created_date_str' => date("d-m-Y"),
                            'created_date' => time(),
                            'created_month_year' => $this->month_year
                        );
                        if(!$this->checkExistEmptyByType($user->user_id,$child->user_id,'02') && $revenueChild > 0) {
                            $dataPositionCommissionAdd_02 = $this->commission_empty_position_model->add($dataPositionCommission_02);
                            log_message("debug","Vị trí trống CoreAdmin - UserID:".$user->user_id.",Con:".$child->user_id.",Doanh thu con:".$revenueChild.",Loại:02,Tháng:".$this->month_year);
                        }

                        // 03
                        $dev1_percent_03 = 0;
                        $partner2_percent_03 = 0;
                        $partner1_percent_03 = 0;
                        $coremember_percent_03 = 0;
                        if($child->group_id == Developer2User){
                            $dev1_percent_03 = $this->get_config_solution_commission(Developer1User);
                            $partner2_percent_03 = $this->get_config_solution_commission(Partner2User);
                            $partner1_percent_03 = $this->get_config_solution_commission(Partner1User);
                            $coremember_percent_03 = $this->get_config_solution_commission(CoreMemberUser);
                        }

                        if($child->group_id == Developer1User){
                            $partner2_percent_03 = $this->get_config_solution_commission(Partner2User);
                            $partner1_percent_03 = $this->get_config_solution_commission(Partner1User);
                            $coremember_percent_03 = $this->get_config_solution_commission(CoreMemberUser);
                        }

                        if($child->group_id == Partner2User){
                            $partner1_percent_03 = $this->get_config_solution_commission(Partner1User);
                            $coremember_percent_03 = $this->get_config_solution_commission(CoreMemberUser);
                        }
                        if($child->group_id == Partner1User){
                            $coremember_percent_03 = $this->get_config_solution_commission(CoreMemberUser);
                        }
                        $revenueChild = 0;
                        $revenueChild = $this->get_revenue_by_user($child->user_id,'03');

                        $dataPositionCommission_03 = array(
                            'user_id' => $user->user_id,
                            'group_id' => $user->group_id,
                            'parent_id' => $user->parent,
                            'user_child_id' => $child->user_id,
                            'user_child_profit' => $revenueChild,
                            'dev1_percent' => $dev1_percent_03,
                            'partner2_percent' => $partner2_percent_03,
                            'partner1_percent' => $partner1_percent_03,
                            'coremember_percent' => $coremember_percent_03,
                            'type' => '03',
                            'created_date_str' => date("d-m-Y"),
                            'created_date' => time(),
                            'created_month_year' => $this->month_year
                        );
                        if(!$this->checkExistEmptyByType($user->user_id,$child->user_id,'03') && $revenueChild > 0) {
                            $dataPositionCommissionAdd_03 = $this->commission_empty_position_model->add($dataPositionCommission_03);
                            log_message("debug","Vị trí trống CoreAdmin - UserID:".$user->user_id.",Con:".$child->user_id.",Doanh thu con:".$revenueChild.",Loại:03,Tháng:".$this->month_year);
                        }

                        // 04
                        $dev1_percent_04 = 0;
                        $partner2_percent_04 = 0;
                        $partner1_percent_04 = 0;
                        $coremember_percent_04 = 0;
                        if($child->group_id == Developer2User){
                            $dev1_percent_04 = $this->get_commission_config(Developer1User,'04');
                            $partner2_percent_04 = $this->get_commission_config(Partner2User,'04');
                            $partner1_percent_04 = $this->get_commission_config(Partner1User,'04');
                            $coremember_percent_04 = $this->get_commission_config(CoreMemberUser,'04');
                        }

                        if($child->group_id == Developer1User){
                            $partner2_percent_04 = $this->get_commission_config(Partner2User,'04');
                            $partner1_percent_04 = $this->get_commission_config(Partner1User,'04');
                            $coremember_percent_04 = $this->get_commission_config(CoreMemberUser,'04');
                        }

                        if($child->group_id == Partner2User){
                            $partner1_percent_04 = $this->get_commission_config(Partner1User,'04');
                            $coremember_percent_04 = $this->get_commission_config(CoreMemberUser,'04');
                        }
                        if($child->group_id == Partner1User){
                            $coremember_percent_04 = $this->get_commission_config(CoreMemberUser,'04');
                        }
                        $revenueChild = 0;
                        $revenueChild = $this->get_revenue_by_user($child->user_id,'04');

                        $dataPositionCommission_04 = array(
                            'user_id' => $user->user_id,
                            'group_id' => $user->group_id,
                            'parent_id' => $user->parent,
                            'user_child_id' => $child->user_id,
                            'user_child_profit' => $revenueChild,
                            'dev1_percent' => $dev1_percent_04,
                            'partner2_percent' => $partner2_percent_04,
                            'partner1_percent' => $partner1_percent_04,
                            'coremember_percent' => $coremember_percent_04,
                            'type' => '04',
                            'created_date_str' => date("d-m-Y"),
                            'created_date' => time(),
                            'created_month_year' => $this->month_year
                        );
                        if(!$this->checkExistEmptyByType($user->user_id,$child->user_id,'04') && $revenueChild > 0) {
                            $dataPositionCommissionAdd_04 = $this->commission_empty_position_model->add($dataPositionCommission_04);
                            log_message("debug","Vị trí trống CoreAdmin - UserID:".$user->user_id.",Con:".$child->user_id.",Doanh thu con:".$revenueChild.",Loại:04,Tháng:".$this->month_year);
                        }

                        // 05
                        $dev1_percent_05 = 0;
                        $partner2_percent_05 = 0;
                        $partner1_percent_05 = 0;
                        $coremember_percent_05 = 0;
                        if($child->group_id == Developer2User){
                            $dev1_percent_05 = $this->get_commission_config(Developer1User,'05');
                            $partner2_percent_05 = $this->get_commission_config(Partner2User,'05');
                            $partner1_percent_05 = $this->get_commission_config(Partner1User,'05');
                            $coremember_percent_05 = $this->get_commission_config(CoreMemberUser,'05');
                        }

                        if($child->group_id == Developer1User){
                            $partner2_percent_05 = $this->get_commission_config(Partner2User,'05');
                            $partner1_percent_05 = $this->get_commission_config(Partner1User,'05');
                            $coremember_percent_05 = $this->get_commission_config(CoreMemberUser,'05');
                        }

                        if($child->group_id == Partner2User){
                            $partner1_percent_05 = $this->get_commission_config(Partner1User,'05');
                            $coremember_percent_05 = $this->get_commission_config(CoreMemberUser,'05');
                        }
                        if($child->group_id == Partner1User){
                            $coremember_percent_05 = $this->get_commission_config(CoreMemberUser,'05');
                        }
                        $revenueChild = 0;
                        $revenueChild = $this->get_revenue_by_user($child->user_id,'05');

                        $dataPositionCommission_05 = array(
                            'user_id' => $user->user_id,
                            'group_id' => $user->group_id,
                            'parent_id' => $user->parent,
                            'user_child_id' => $child->user_id,
                            'user_child_profit' => $revenueChild,
                            'dev1_percent' => $dev1_percent_05,
                            'partner2_percent' => $partner2_percent_05,
                            'partner1_percent' => $partner1_percent_05,
                            'coremember_percent' => $coremember_percent_05,
                            'type' => '05',
                            'created_date_str' => date("d-m-Y"),
                            'created_date' => time(),
                            'created_month_year' => $this->month_year
                        );
                        if(!$this->checkExistEmptyByType($user->user_id,$child->user_id,'05') && $revenueChild > 0) {
                            $dataPositionCommissionAdd_05 = $this->commission_empty_position_model->add($dataPositionCommission_05);
                            log_message("debug","Vị trí trống CoreAdmin - UserID:".$user->user_id.",Con:".$child->user_id.",Doanh thu con:".$revenueChild.",Loại:05,Tháng:".$this->month_year);
                        }
                    }
                }
                // doanh so ca nhan
                $revenuePrivate =  $this->get_personal_revenue_by_user($user->user_id,'02');
                if($revenuePrivate > 0){
                    // tinh hoa hong ca nhan o day
                    $this->caculate_personal_commission($user,$revenuePrivate,'02','Hoa hồng Bán sỉ cá nhân');
                }

                $comission = $revenue * ($percent/100);
                if($comission > 0){
                    $dataAdd = array(
                        'user_id' => $user->user_id,
                        'group_id' => $user->group_id,
                        'parent_id' => $user->parent,
                        'commission' => $comission,
                        'percent' => $percent,
                        'profit' => $revenue,
                        'type' => '02',
                        'description' => 'Hoa hồng Bán sỉ',
                        'commission_month' => $this->month_year,
                        'created_date' => time(),
                        'created_date_str' => date("d-m-Y",time()),
                        'payment_date' => time(),
                        'payment_status' => 0,
                        'status' => 0
                    );
                    $commissionAdd = $this->commission_model->add($dataAdd);
                    $dataMoney = array(
                        'user_id' => $user->user_id,
                        'group_id' => $user->group_id,
                        'parent_id' => $user->parent,
                        'amount' => $comission,
                        'type' => '02',
                        'description' => 'Tiền Hoa hồng Bán sỉ',
                        'created_date' => date("Y-m-d H:i:s"),
                        'month_year' => $this->month_year,
                        'status' => 0
                    );

                    $this->persional_money_by_type($dataMoney);
                }

                log_message("debug","Hoa hồng Bán sỉ CoreAdmin - UserID:".$user->user_id.",Doanh thu:".$revenue.",Phần trăm:".$percent.",Hoa hồng:".$comission.",Loại:02,Tháng:".$this->month_year);
            }
        }
    }

    // retail buy product revenue
    function retail_buy_product_revenue_store_from_affiliate(){
        if(!$this->checkExistRevenueByGroupType(3,'08')){
            $this->load->model('revenue_model');
            $listUser = $this->get_all_shopper();

            $arr_start_end_date = $this->get_start_end_date();
            $startMonth = $arr_start_end_date[0];
            $endMonth = $arr_start_end_date[1];

            foreach($listUser as $user){
                $totalRevenue = 0;
                $totalChild = 0;
                $totalPrivateRevenue = 0;

                // doanh so ca nhan
                $totalPrivateRevenue = $this->calculate_retail_buy_product_revenue_store_by_userid($user->use_id,$startMonth,$endMonth);
                if($totalPrivateRevenue > 0){
                    $totalRevenue = $totalRevenue + $totalPrivateRevenue;
                }
                if($totalRevenue > 0){
                    $dataAdd = array(
                        'user_id' => $user->use_id,
                        'group_id' => $user->use_group,
                        'parent_id' => $user->parent_id,
                        'created_date_str' => date("d-m-Y",time()),
                        'created_date' => time(),
                        'revenue_month_year' => $this->month_year,
                        'total' => $totalRevenue,
                        'private_profit' => $totalPrivateRevenue,
                        'type' => '08',
                        'status' => 0
                    );

                    $revenue = $this->revenue_model->add($dataAdd);
                }
            }
        }
    }

    // retail buy product revenue
    function retail_buy_product_revenue_dev2(){
        if(!$this->checkExistRevenueByGroupType(6,'04')){
            $this->load->model('revenue_model');
            $listUser = $this->get_all_dev2();

            $arr_start_end_date = $this->get_start_end_date();
            $startMonth = $arr_start_end_date[0];
            $endMonth = $arr_start_end_date[1];

            foreach($listUser as $user){
                $totalRevenue = 0;
                $totalChild = 0;
                $totalPrivateRevenue = 0;

                // doanh so ca nhan
                $totalPrivateRevenue = $this->calculate_retail_buy_product_revenue_by_userid($user->user_id,$startMonth,$endMonth);
                if($totalPrivateRevenue > 0){
                    $totalRevenue = $totalRevenue + $totalPrivateRevenue;
                }
                if($totalRevenue > 0){
                    $dataAdd = array(
                        'user_id' => $user->user_id,
                        'group_id' => $user->group_id,
                        'parent_id' => $user->parent,
                        'created_date_str' => date("d-m-Y",time()),
                        'created_date' => time(),
                        'revenue_month_year' => $this->month_year,
                        'total' => $totalRevenue,
                        'private_profit' => 0,
                        'type' => '04',
                        'status' => 0
                    );

                    $revenue = $this->revenue_model->add($dataAdd);
                }
                log_message("debug","Doanh số Mua lẻ Dev2 - UserID:".$user->user_id.",Doanh thu:".$totalRevenue.",Doanh thu CN:0,Loại:04,Tháng:".$this->month_year);
            }
        }
    }
    // get revenue product
    function retail_buy_product_revenue_dev1(){
        if(!$this->checkExistRevenueByGroupType(7,'04')){
            $this->load->model('revenue_model');
            $listUser = $this->get_all_dev1();

            $arr_start_end_date = $this->get_start_end_date();
            $startMonth = $arr_start_end_date[0];
            $endMonth = $arr_start_end_date[1];

            foreach($listUser as $user){
                $totalRevenue = 0;
                $totalChild = 0;
                $totalPrivateRevenue = 0;

                // doanh so cay he thong
                $listChild = $this->get_list_child_tree($user->user_id);
                foreach($listChild as $child){
                    $totalChild = $this->get_revenue_by_user($child->user_id,'04');
                    $totalRevenue = $totalRevenue + $totalChild;
                }
                // doanh so ca nhan
                $totalPrivateRevenue = $this->calculate_retail_buy_product_revenue_by_userid($user->user_id,$startMonth,$endMonth);

                if($totalRevenue > 0 || $totalPrivateRevenue > 0){
                    $dataAdd = array(
                        'user_id' => $user->user_id,
                        'group_id' => $user->group_id,
                        'parent_id' => $user->parent,
                        'created_date_str' => date("d-m-Y",time()),
                        'created_date' => time(),
                        'revenue_month_year' => $this->month_year,
                        'total' => $totalRevenue,
                        'private_profit' => $totalPrivateRevenue,
                        'type' => '04',
                        'status' => 0
                    );


                    $revenue = $this->revenue_model->add($dataAdd);
                }
                log_message("debug","Doanh số Mua lẻ Dev1 - UserID:".$user->user_id.",Doanh thu:".$totalRevenue.",Doanh thu CN:".$totalPrivateRevenue.",Loại:04,Tháng:".$this->month_year);
            }
        }
    }

    function retail_buy_product_revenue_partner2(){
        if(!$this->checkExistRevenueByGroupType(8,'04')){
            $this->load->model('revenue_model');
            $listUser = $this->get_all_partner2();

            $arr_start_end_date = $this->get_start_end_date();
            $startMonth = $arr_start_end_date[0];
            $endMonth = $arr_start_end_date[1];

            foreach($listUser as $user){
                $totalRevenue = 0;
                $totalChild = 0;
                $totalPrivateRevenue = 0;

                // doanh so cay he thong
                $listChild = $this->get_list_child_tree($user->user_id);
                foreach($listChild as $child){
                    $totalChild = $this->get_revenue_by_user($child->user_id,'04');
                    $totalRevenue = $totalRevenue + $totalChild;
                }
                // doanh so ca nhan
                $totalPrivateRevenue = $this->calculate_retail_buy_product_revenue_by_userid($user->user_id,$startMonth,$endMonth);

                if($totalRevenue > 0 || $totalPrivateRevenue > 0){
                    $dataAdd = array(
                        'user_id' => $user->user_id,
                        'group_id' => $user->group_id,
                        'parent_id' => $user->parent,
                        'created_date_str' => date("d-m-Y",time()),
                        'created_date' => time(),
                        'revenue_month_year' => $this->month_year,
                        'total' => $totalRevenue,
                        'private_profit' => $totalPrivateRevenue,
                        'type' => '04',
                        'status' => 0
                    );


                    $revenue = $this->revenue_model->add($dataAdd);
                }
                log_message("debug","Doanh số Mua lẻ Partner2 - UserID:".$user->user_id.",Doanh thu:".$totalRevenue.",Doanh thu CN:".$totalPrivateRevenue.",Loại:04,Tháng:".$this->month_year);
            }
        }
    }

    function retail_buy_product_revenue_partner1(){
        if(!$this->checkExistRevenueByGroupType(9,'04')){
            $this->load->model('revenue_model');
            $listUser = $this->get_all_partner1();

            $arr_start_end_date = $this->get_start_end_date();
            $startMonth = $arr_start_end_date[0];
            $endMonth = $arr_start_end_date[1];

            foreach($listUser as $user){
                $totalRevenue = 0;
                $totalChild = 0;
                $totalPrivateRevenue = 0;

                // doanh so cay he thong
                $listChild = $this->get_list_child_tree($user->user_id);
                foreach($listChild as $child){
                    $totalChild = $this->get_revenue_by_user($child->user_id,'04');
                    $totalRevenue = $totalRevenue + $totalChild;
                }
                // doanh so ca nhan
                $totalPrivateRevenue = $this->calculate_retail_buy_product_revenue_by_userid($user->user_id,$startMonth,$endMonth);

                if($totalRevenue > 0 || $totalPrivateRevenue > 0){
                    $dataAdd = array(
                        'user_id' => $user->user_id,
                        'group_id' => $user->group_id,
                        'parent_id' => $user->parent,
                        'created_date_str' => date("d-m-Y",time()),
                        'created_date' => time(),
                        'revenue_month_year' => $this->month_year,
                        'total' => $totalRevenue,
                        'private_profit' => $totalPrivateRevenue,
                        'type' => '04',
                        'status' => 0
                    );


                    $revenue = $this->revenue_model->add($dataAdd);
                }
                log_message("debug","Doanh số Mua lẻ Partner1 - UserID:".$user->user_id.",Doanh thu:".$totalRevenue.",Doanh thu CN:".$totalPrivateRevenue.",Loại:04,Tháng:".$this->month_year);
            }
        }
    }

    function retail_buy_product_revenue_coremember(){
        if(!$this->checkExistRevenueByGroupType(10,'04')){
            $this->load->model('revenue_model');
            $listUser = $this->get_all_coremember();

            $arr_start_end_date = $this->get_start_end_date();
            $startMonth = $arr_start_end_date[0];
            $endMonth = $arr_start_end_date[1];

            foreach($listUser as $user){
                $totalRevenue = 0;
                $totalChild = 0;
                $totalPrivateRevenue = 0;

                // doanh so cay he thong
                $listChild = $this->get_list_child_tree($user->user_id);
                foreach($listChild as $child){
                    $totalChild = $this->get_revenue_by_user($child->user_id,'04');
                    $totalRevenue = $totalRevenue + $totalChild;
                }
                // doanh so ca nhan
                $totalPrivateRevenue = $this->calculate_retail_buy_product_revenue_by_userid($user->user_id,$startMonth,$endMonth);

                if($totalRevenue > 0 || $totalPrivateRevenue > 0){
                    $dataAdd = array(
                        'user_id' => $user->user_id,
                        'group_id' => $user->group_id,
                        'parent_id' => $user->parent,
                        'created_date_str' => date("d-m-Y",time()),
                        'created_date' => time(),
                        'revenue_month_year' => $this->month_year,
                        'total' => $totalRevenue,
                        'private_profit' => $totalPrivateRevenue,
                        'type' => '04',
                        'status' => 0
                    );


                    $revenue = $this->revenue_model->add($dataAdd);
                }
                log_message("debug","Doanh số Mua lẻ CoreMemember - UserID:".$user->user_id.",Doanh thu:".$totalRevenue.",Doanh thu CN:".$totalPrivateRevenue.",Loại:04,Tháng:".$this->month_year);
            }
        }
    }

    function retail_buy_product_revenue_coreadmin(){
        if(!$this->checkExistRevenueByGroupType(12,'04')){
            $this->load->model('revenue_model');
            $listUser = $this->get_all_coreadmin();

            $arr_start_end_date = $this->get_start_end_date();
            $startMonth = $arr_start_end_date[0];
            $endMonth = $arr_start_end_date[1];

            foreach($listUser as $user){
                $totalRevenue = 0;
                $totalChild = 0;
                $totalPrivateRevenue = 0;

                // doanh so cay he thong
                $listChild = $this->get_list_child_tree($user->user_id);
                foreach($listChild as $child){
                    $totalChild = $this->get_revenue_by_user($child->user_id,'04');
                    $totalRevenue = $totalRevenue + $totalChild;
                }
                // doanh so ca nhan
                $totalPrivateRevenue = $this->calculate_retail_buy_product_revenue_by_userid($user->user_id,$startMonth,$endMonth);

                if($totalRevenue > 0 || $totalPrivateRevenue > 0){
                    $dataAdd = array(
                        'user_id' => $user->user_id,
                        'group_id' => $user->group_id,
                        'parent_id' => $user->parent,
                        'created_date_str' => date("d-m-Y",time()),
                        'created_date' => time(),
                        'revenue_month_year' => $this->month_year,
                        'total' => $totalRevenue,
                        'private_profit' => $totalPrivateRevenue,
                        'type' => '04',
                        'status' => 0
                    );
                    $revenue = $this->revenue_model->add($dataAdd);
                }
                log_message("debug","Doanh số Mua lẻ CoreAdmin - UserID:".$user->user_id.",Doanh thu:".$totalRevenue.",Doanh thu CN:".$totalPrivateRevenue.",Loại:04,Tháng:".$this->month_year);
            }
        }
    }

    // retail sell product revenue
    function retail_sell_product_revenue_dev2(){
        if(!$this->checkExistRevenueByGroupType(6,'05')){
            $this->load->model('revenue_model');
            $listUser = $this->get_all_dev2();

            $arr_start_end_date = $this->get_start_end_date();
            $startMonth = $arr_start_end_date[0];
            $endMonth = $arr_start_end_date[1];

            foreach($listUser as $user){
                $totalRevenue = 0;
                $totalChild = 0;
                $totalPrivateRevenue = 0;

                // doanh so ca nhan
                $totalPrivateRevenue = $this->calculate_retail_sell_product_revenue_by_userid($user->user_id,$startMonth,$endMonth);
                if($totalPrivateRevenue > 0){
                    $totalRevenue = $totalRevenue + $totalPrivateRevenue;
                }
                if($totalRevenue > 0){
                    $dataAdd = array(
                        'user_id' => $user->user_id,
                        'group_id' => $user->group_id,
                        'parent_id' => $user->parent,
                        'created_date_str' => date("d-m-Y",time()),
                        'created_date' => time(),
                        'revenue_month_year' => $this->month_year,
                        'total' => $totalRevenue,
                        'private_profit' => 0,
                        'type' => '05',
                        'status' => 0
                    );

                    $revenue = $this->revenue_model->add($dataAdd);
                }
                log_message("debug","Doanh số Bán lẻ Dev2 - UserID:".$user->user_id.",Doanh thu:".$totalRevenue.",Doanh thu CN:0,Loại:05,Tháng:".$this->month_year);
            }
        }
    }
    // get revenue product
    function retail_sell_product_revenue_dev1(){
        if(!$this->checkExistRevenueByGroupType(7,'05')){
            $this->load->model('revenue_model');
            $listUser = $this->get_all_dev1();

            $arr_start_end_date = $this->get_start_end_date();
            $startMonth = $arr_start_end_date[0];
            $endMonth = $arr_start_end_date[1];

            foreach($listUser as $user){
                $totalRevenue = 0;
                $totalChild = 0;
                $totalPrivateRevenue = 0;

                // doanh so cay he thong
                $listChild = $this->get_list_child_tree($user->user_id);
                foreach($listChild as $child){
                    $totalChild = $this->get_revenue_by_user($child->user_id,'05');
                    $totalRevenue = $totalRevenue + $totalChild;
                }
                // doanh so ca nhan
                $totalPrivateRevenue = $this->calculate_retail_sell_product_revenue_by_userid($user->user_id,$startMonth,$endMonth);

                if($totalRevenue > 0 || $totalPrivateRevenue > 0){
                    $dataAdd = array(
                        'user_id' => $user->user_id,
                        'group_id' => $user->group_id,
                        'parent_id' => $user->parent,
                        'created_date_str' => date("d-m-Y",time()),
                        'created_date' => time(),
                        'revenue_month_year' => $this->month_year,
                        'total' => $totalRevenue,
                        'private_profit' => $totalPrivateRevenue,
                        'type' => '05',
                        'status' => 0
                    );


                    $revenue = $this->revenue_model->add($dataAdd);
                }
                log_message("debug","Doanh số Bán lẻ Dev1 - UserID:".$user->user_id.",Doanh thu:".$totalRevenue.",Doanh thu CN:".$totalPrivateRevenue.",Loại:05,Tháng:".$this->month_year);
            }
        }
    }

    function retail_sell_product_revenue_partner2(){
        if(!$this->checkExistRevenueByGroupType(8,'05')){
            $this->load->model('revenue_model');
            $listUser = $this->get_all_partner2();

            $arr_start_end_date = $this->get_start_end_date();
            $startMonth = $arr_start_end_date[0];
            $endMonth = $arr_start_end_date[1];

            foreach($listUser as $user){
                $totalRevenue = 0;
                $totalChild = 0;
                $totalPrivateRevenue = 0;

                // doanh so cay he thong
                $listChild = $this->get_list_child_tree($user->user_id);
                foreach($listChild as $child){
                    $totalChild = $this->get_revenue_by_user($child->user_id,'05');
                    $totalRevenue = $totalRevenue + $totalChild;
                }
                // doanh so ca nhan
                $totalPrivateRevenue = $this->calculate_retail_sell_product_revenue_by_userid($user->user_id,$startMonth,$endMonth);

                if($totalRevenue > 0 || $totalPrivateRevenue > 0){
                    $dataAdd = array(
                        'user_id' => $user->user_id,
                        'group_id' => $user->group_id,
                        'parent_id' => $user->parent,
                        'created_date_str' => date("d-m-Y",time()),
                        'created_date' => time(),
                        'revenue_month_year' => $this->month_year,
                        'total' => $totalRevenue,
                        'private_profit' => $totalPrivateRevenue,
                        'type' => '05',
                        'status' => 0
                    );


                    $revenue = $this->revenue_model->add($dataAdd);
                }
                log_message("debug","Doanh số Bán lẻ Partner2 - UserID:".$user->user_id.",Doanh thu:".$totalRevenue.",Doanh thu CN:".$totalPrivateRevenue.",Loại:05,Tháng:".$this->month_year);
            }
        }
    }

    function retail_sell_product_revenue_partner1(){
        if(!$this->checkExistRevenueByGroupType(9,'05')){
            $this->load->model('revenue_model');
            $listUser = $this->get_all_partner1();

            $arr_start_end_date = $this->get_start_end_date();
            $startMonth = $arr_start_end_date[0];
            $endMonth = $arr_start_end_date[1];

            foreach($listUser as $user){
                $totalRevenue = 0;
                $totalChild = 0;
                $totalPrivateRevenue = 0;

                // doanh so cay he thong
                $listChild = $this->get_list_child_tree($user->user_id);
                foreach($listChild as $child){
                    $totalChild = $this->get_revenue_by_user($child->user_id,'05');
                    $totalRevenue = $totalRevenue + $totalChild;
                }
                // doanh so ca nhan
                $totalPrivateRevenue = $this->calculate_retail_sell_product_revenue_by_userid($user->user_id,$startMonth,$endMonth);

                if($totalRevenue > 0 || $totalPrivateRevenue > 0){
                    $dataAdd = array(
                        'user_id' => $user->user_id,
                        'group_id' => $user->group_id,
                        'parent_id' => $user->parent,
                        'created_date_str' => date("d-m-Y",time()),
                        'created_date' => time(),
                        'revenue_month_year' => $this->month_year,
                        'total' => $totalRevenue,
                        'private_profit' => $totalPrivateRevenue,
                        'type' => '05',
                        'status' => 0
                    );
                    $revenue = $this->revenue_model->add($dataAdd);
                }
                log_message("debug","Doanh số Bán lẻ Partner1 - UserID:".$user->user_id.",Doanh thu:".$totalRevenue.",Doanh thu CN:".$totalPrivateRevenue.",Loại:05,Tháng:".$this->month_year);
            }
        }
    }

    function retail_sell_product_revenue_coremember(){
        if(!$this->checkExistRevenueByGroupType(10,'05')){
            $this->load->model('revenue_model');
            $listUser = $this->get_all_coremember();

            $arr_start_end_date = $this->get_start_end_date();
            $startMonth = $arr_start_end_date[0];
            $endMonth = $arr_start_end_date[1];

            foreach($listUser as $user){
                $totalRevenue = 0;
                $totalChild = 0;
                $totalPrivateRevenue = 0;

                // doanh so cay he thong
                $listChild = $this->get_list_child_tree($user->user_id);
                foreach($listChild as $child){
                    $totalChild = $this->get_revenue_by_user($child->user_id,'05');
                    $totalRevenue = $totalRevenue + $totalChild;
                }
                // doanh so ca nhan
                $totalPrivateRevenue = $this->calculate_retail_sell_product_revenue_by_userid($user->user_id,$startMonth,$endMonth);

                if($totalRevenue > 0 || $totalPrivateRevenue > 0){
                    $dataAdd = array(
                        'user_id' => $user->user_id,
                        'group_id' => $user->group_id,
                        'parent_id' => $user->parent,
                        'created_date_str' => date("d-m-Y",time()),
                        'created_date' => time(),
                        'revenue_month_year' => $this->month_year,
                        'total' => $totalRevenue,
                        'private_profit' => $totalPrivateRevenue,
                        'type' => '05',
                        'status' => 0
                    );


                    $revenue = $this->revenue_model->add($dataAdd);
                }
                log_message("debug","Doanh số Bán lẻ CoreMember - UserID:".$user->user_id.",Doanh thu:".$totalRevenue.",Doanh thu CN:".$totalPrivateRevenue.",Loại:05,Tháng:".$this->month_year);
            }
        }
    }

    function retail_sell_product_revenue_coreadmin(){
        if(!$this->checkExistRevenueByGroupType(12,'05')){
            $this->load->model('revenue_model');
            $listUser = $this->get_all_coreadmin();

            $arr_start_end_date = $this->get_start_end_date();
            $startMonth = $arr_start_end_date[0];
            $endMonth = $arr_start_end_date[1];

            foreach($listUser as $user){
                $totalRevenue = 0;
                $totalChild = 0;
                $totalPrivateRevenue = 0;

                // doanh so cay he thong
                $listChild = $this->get_list_child_tree($user->user_id);
                foreach($listChild as $child){
                    $totalChild = $this->get_revenue_by_user($child->user_id,'05');
                    $totalRevenue = $totalRevenue + $totalChild;
                }
                // doanh so ca nhan
                $totalPrivateRevenue = $this->calculate_retail_sell_product_revenue_by_userid($user->user_id,$startMonth,$endMonth);

                if($totalRevenue > 0 || $totalPrivateRevenue > 0){
                    $dataAdd = array(
                        'user_id' => $user->user_id,
                        'group_id' => $user->group_id,
                        'parent_id' => $user->parent,
                        'created_date_str' => date("d-m-Y",time()),
                        'created_date' => time(),
                        'revenue_month_year' => $this->month_year,
                        'total' => $totalRevenue,
                        'private_profit' => $totalPrivateRevenue,
                        'type' => '05',
                        'status' => 0
                    );


                    $revenue = $this->revenue_model->add($dataAdd);
                }
                log_message("debug","Doanh số Bán lẻ CoreAdmin - UserID:".$user->user_id.",Doanh thu:".$totalRevenue.",Doanh thu CN:".$totalPrivateRevenue.",Loại:05,Tháng:".$this->month_year);
            }
        }
    }

    // buy product revenue
    function wholesale_buy_product_revenue_dev2(){
        if(!$this->checkExistRevenueByGroupType(6,'01')){
            $this->load->model('revenue_model');
            $listUser = $this->get_all_dev2();

            $arr_start_end_date = $this->get_start_end_date();
            $startMonth = $arr_start_end_date[0];
            $endMonth = $arr_start_end_date[1];

            foreach($listUser as $user){
                $totalRevenue = 0;
                $totalChild = 0;
                $totalPrivateRevenue = 0;

                // doanh so ca nhan
                $totalPrivateRevenue = $this->calculate_wholesale_buy_product_revenue_by_userid($user->user_id,$startMonth,$endMonth);
                if($totalPrivateRevenue > 0){
                    $totalRevenue = $totalRevenue + $totalPrivateRevenue;
                }
                if($totalRevenue > 0){
                    $dataAdd = array(
                        'user_id' => $user->user_id,
                        'group_id' => $user->group_id,
                        'parent_id' => $user->parent,
                        'created_date_str' => date("d-m-Y",time()),
                        'created_date' => time(),
                        'revenue_month_year' => $this->month_year,
                        'total' => $totalRevenue,
                        'private_profit' => 0,
                        'type' => '01',
                        'status' => 0
                    );

                    $revenue = $this->revenue_model->add($dataAdd);
                }
                log_message("debug","Doanh số Mua sỉ Dev2 - UserID:".$user->user_id.",Doanh thu:".$totalRevenue.",Doanh thu CN:0,Loại:01,Tháng:".$this->month_year);
            }
        }
    }
    // get revenue product
    function wholesale_buy_product_revenue_dev1(){
        if(!$this->checkExistRevenueByGroupType(7,'01')){
            $this->load->model('revenue_model');
            $listUser = $this->get_all_dev1();

            $arr_start_end_date = $this->get_start_end_date();
            $startMonth = $arr_start_end_date[0];
            $endMonth = $arr_start_end_date[1];

            foreach($listUser as $user){
                $totalRevenue = 0;
                $totalChild = 0;
                $totalPrivateRevenue = 0;

                // doanh so cay he thong
                $listChild = $this->get_list_child_tree($user->user_id);
                foreach($listChild as $child){
                    $totalChild = $this->get_revenue_by_user($child->user_id,'01');
                    $totalRevenue = $totalRevenue + $totalChild;
                }
                // doanh so ca nhan
                $totalPrivateRevenue = $this->calculate_wholesale_buy_product_revenue_by_userid($user->user_id,$startMonth,$endMonth);

                if($totalRevenue > 0 || $totalPrivateRevenue > 0){
                    $dataAdd = array(
                        'user_id' => $user->user_id,
                        'group_id' => $user->group_id,
                        'parent_id' => $user->parent,
                        'created_date_str' => date("d-m-Y",time()),
                        'created_date' => time(),
                        'revenue_month_year' => $this->month_year,
                        'total' => $totalRevenue,
                        'private_profit' => $totalPrivateRevenue,
                        'type' => '01',
                        'status' => 0
                    );


                    $revenue = $this->revenue_model->add($dataAdd);
                }
                log_message("debug","Doanh số Mua sỉ Dev1 - UserID:".$user->user_id.",Doanh thu:".$totalRevenue.",Doanh thu CN:".$totalPrivateRevenue.",Loại:01,Tháng:".$this->month_year);
            }
        }
    }

    function wholesale_buy_product_revenue_partner2(){
        if(!$this->checkExistRevenueByGroupType(8,'01')){
            $this->load->model('revenue_model');
            $listUser = $this->get_all_partner2();

            $arr_start_end_date = $this->get_start_end_date();
            $startMonth = $arr_start_end_date[0];
            $endMonth = $arr_start_end_date[1];

            foreach($listUser as $user){
                $totalRevenue = 0;
                $totalChild = 0;
                $totalPrivateRevenue = 0;

                // doanh so cay he thong
                $listChild = $this->get_list_child_tree($user->user_id);
                foreach($listChild as $child){
                    $totalChild = $this->get_revenue_by_user($child->user_id,'01');
                    $totalRevenue = $totalRevenue + $totalChild;
                }
                // doanh so ca nhan
                $totalPrivateRevenue = $this->calculate_wholesale_buy_product_revenue_by_userid($user->user_id,$startMonth,$endMonth);

                if($totalRevenue > 0 || $totalPrivateRevenue > 0){
                    $dataAdd = array(
                        'user_id' => $user->user_id,
                        'group_id' => $user->group_id,
                        'parent_id' => $user->parent,
                        'created_date_str' => date("d-m-Y",time()),
                        'created_date' => time(),
                        'revenue_month_year' => $this->month_year,
                        'total' => $totalRevenue,
                        'private_profit' => $totalPrivateRevenue,
                        'type' => '01',
                        'status' => 0
                    );


                    $revenue = $this->revenue_model->add($dataAdd);
                }
                log_message("debug","Doanh số Mua sỉ Partner2 - UserID:".$user->user_id.",Doanh thu:".$totalRevenue.",Doanh thu CN:".$totalPrivateRevenue.",Loại:01,Tháng:".$this->month_year);
            }
        }
    }

    function wholesale_buy_product_revenue_partner1(){
        if(!$this->checkExistRevenueByGroupType(9,'01')){
            $this->load->model('revenue_model');
            $listUser = $this->get_all_partner1();

            $arr_start_end_date = $this->get_start_end_date();
            $startMonth = $arr_start_end_date[0];
            $endMonth = $arr_start_end_date[1];

            foreach($listUser as $user){
                $totalRevenue = 0;
                $totalChild = 0;
                $totalPrivateRevenue = 0;

                // doanh so cay he thong
                $listChild = $this->get_list_child_tree($user->user_id);
                foreach($listChild as $child){
                    $totalChild = $this->get_revenue_by_user($child->user_id,'01');
                    $totalRevenue = $totalRevenue + $totalChild;
                }
                // doanh so ca nhan
                $totalPrivateRevenue = $this->calculate_wholesale_buy_product_revenue_by_userid($user->user_id,$startMonth,$endMonth);

                if($totalRevenue > 0 || $totalPrivateRevenue > 0){
                    $dataAdd = array(
                        'user_id' => $user->user_id,
                        'group_id' => $user->group_id,
                        'parent_id' => $user->parent,
                        'created_date_str' => date("d-m-Y",time()),
                        'created_date' => time(),
                        'revenue_month_year' => $this->month_year,
                        'total' => $totalRevenue,
                        'private_profit' => $totalPrivateRevenue,
                        'type' => '01',
                        'status' => 0
                    );


                    $revenue = $this->revenue_model->add($dataAdd);
                }
                log_message("debug","Doanh số Mua sỉ Partner1 - UserID:".$user->user_id.",Doanh thu:".$totalRevenue.",Doanh thu CN:".$totalPrivateRevenue.",Loại:01,Tháng:".$this->month_year);
            }
        }
    }

    function wholesale_buy_product_revenue_coremember(){
        if(!$this->checkExistRevenueByGroupType(10,'01')){
            $this->load->model('revenue_model');
            $listUser = $this->get_all_coremember();

            $arr_start_end_date = $this->get_start_end_date();
            $startMonth = $arr_start_end_date[0];
            $endMonth = $arr_start_end_date[1];

            foreach($listUser as $user){
                $totalRevenue = 0;
                $totalChild = 0;
                $totalPrivateRevenue = 0;

                // doanh so cay he thong
                $listChild = $this->get_list_child_tree($user->user_id);
                foreach($listChild as $child){
                    $totalChild = $this->get_revenue_by_user($child->user_id,'01');
                    $totalRevenue = $totalRevenue + $totalChild;
                }
                // doanh so ca nhan
                $totalPrivateRevenue = $this->calculate_wholesale_buy_product_revenue_by_userid($user->user_id,$startMonth,$endMonth);

                if($totalRevenue > 0 || $totalPrivateRevenue > 0){
                    $dataAdd = array(
                        'user_id' => $user->user_id,
                        'group_id' => $user->group_id,
                        'parent_id' => $user->parent,
                        'created_date_str' => date("d-m-Y",time()),
                        'created_date' => time(),
                        'revenue_month_year' => $this->month_year,
                        'total' => $totalRevenue,
                        'private_profit' => $totalPrivateRevenue,
                        'type' => '01',
                        'status' => 0
                    );


                    $revenue = $this->revenue_model->add($dataAdd);
                }
                log_message("debug","Doanh số Mua sỉ CoreMemeber - UserID:".$user->user_id.",Doanh thu:".$totalRevenue.",Doanh thu CN:".$totalPrivateRevenue.",Loại:01,Tháng:".$this->month_year);
            }
        }
    }

    function wholesale_buy_product_revenue_coreadmin(){
        if(!$this->checkExistRevenueByGroupType(12,'01')){
            $this->load->model('revenue_model');
            $listUser = $this->get_all_coreadmin();

            $arr_start_end_date = $this->get_start_end_date();
            $startMonth = $arr_start_end_date[0];
            $endMonth = $arr_start_end_date[1];

            foreach($listUser as $user){
                $totalRevenue = 0;
                $totalChild = 0;
                $totalPrivateRevenue = 0;

                // doanh so cay he thong
                $listChild = $this->get_list_child_tree($user->user_id);
                foreach($listChild as $child){
                    $totalChild = $this->get_revenue_by_user($child->user_id,'01');
                    $totalRevenue = $totalRevenue + $totalChild;
                }
                // doanh so ca nhan
                $totalPrivateRevenue = $this->calculate_wholesale_buy_product_revenue_by_userid($user->user_id,$startMonth,$endMonth);

                if($totalRevenue > 0 || $totalPrivateRevenue > 0){
                    $dataAdd = array(
                        'user_id' => $user->user_id,
                        'group_id' => $user->group_id,
                        'parent_id' => $user->parent,
                        'created_date_str' => date("d-m-Y",time()),
                        'created_date' => time(),
                        'revenue_month_year' => $this->month_year,
                        'total' => $totalRevenue,
                        'private_profit' => $totalPrivateRevenue,
                        'type' => '01',
                        'status' => 0
                    );

                    $revenue = $this->revenue_model->add($dataAdd);
                }
                log_message("debug","Doanh số Mua sỉ CoreAdmin - UserID:".$user->user_id.",Doanh thu:".$totalRevenue.",Doanh thu CN:".$totalPrivateRevenue.",Loại:01,Tháng:".$this->month_year);
            }
        }
    }

    // wholesale sell product revenue
    function wholesale_sell_product_revenue_dev2(){
        if(!$this->checkExistRevenueByGroupType(6,'02')){
            $this->load->model('revenue_model');

            $listUser = $this->get_all_dev2();

            $arr_start_end_date = $this->get_start_end_date();
            $startMonth = $arr_start_end_date[0];
            $endMonth = $arr_start_end_date[1];
            // dev2 doanh so  ca nhan bang doanh so nhom
            foreach($listUser as $user){
                $totalRevenue = 0;
                $totalChild = 0;
                $totalPrivateRevenue = 0;

                // doanh so ca nhan
                $totalPrivateRevenue = $this->calculate_wholesale_sell_product_revenue_by_userid($user->user_id,$startMonth,$endMonth);
                if($totalPrivateRevenue > 0){
                    $totalRevenue = $totalRevenue + $totalPrivateRevenue;
                }
                if($totalRevenue > 0){
                    $dataAdd = array(
                        'user_id' => $user->user_id,
                        'group_id' => $user->group_id,
                        'parent_id' => $user->parent,
                        'created_date_str' => date("d-m-Y",time()),
                        'created_date' => time(),
                        'revenue_month_year' => $this->month_year,
                        'total' => $totalRevenue,
                        'private_profit' => 0,
                        'type' => '02',
                        'status' => 0
                    );

                    $revenue = $this->revenue_model->add($dataAdd);
                }
                log_message("debug","Doanh số Bán sỉ Dev2 - UserID:".$user->user_id.",Doanh thu:".$totalRevenue.",Doanh thu CN:0,Loại:02,Tháng:".$this->month_year);
            }
        }
    }

    // get revenue product
    function wholesale_sell_product_revenue_dev1(){
        if(!$this->checkExistRevenueByGroupType(7,'02')){
            $this->load->model('revenue_model');
            $listUser = $this->get_all_dev1();

            $arr_start_end_date = $this->get_start_end_date();
            $startMonth = $arr_start_end_date[0];
            $endMonth = $arr_start_end_date[1];

            foreach($listUser as $user){
                $totalRevenue = 0;
                $totalChild = 0;
                $totalPrivateRevenue = 0;

                // doanh so cay he thong
                $listChild = $this->get_list_child_tree($user->user_id);
                foreach($listChild as $child){
                    $totalChild = $this->get_revenue_by_user($child->user_id,'02');
                    $totalRevenue = $totalRevenue + $totalChild;
                }
                // doanh so ca nhan
                $totalPrivateRevenue = $this->calculate_wholesale_sell_product_revenue_by_userid($user->user_id,$startMonth,$endMonth);

                if($totalRevenue > 0 || $totalPrivateRevenue > 0){
                    $dataAdd = array(
                        'user_id' => $user->user_id,
                        'group_id' => $user->group_id,
                        'parent_id' => $user->parent,
                        'created_date_str' => date("d-m-Y",time()),
                        'created_date' => time(),
                        'revenue_month_year' => $this->month_year,
                        'total' => $totalRevenue,
                        'private_profit' => $totalPrivateRevenue,
                        'type' => '02',
                        'status' => 0
                    );

                    $revenue = $this->revenue_model->add($dataAdd);
                }
                log_message("debug","Doanh số Bán sỉ Dev1 - UserID:".$user->user_id.",Doanh thu:".$totalRevenue.",Doanh thu CN:0,Loại:02,Tháng:".$this->month_year);
            }
        }
    }

    function wholesale_sell_product_revenue_partner2(){
        if(!$this->checkExistRevenueByGroupType(8,'02')){
            $this->load->model('revenue_model');
            $listUser = $this->get_all_partner2();

            $arr_start_end_date = $this->get_start_end_date();
            $startMonth = $arr_start_end_date[0];
            $endMonth = $arr_start_end_date[1];

            foreach($listUser as $user){
                $totalRevenue = 0;
                $totalChild = 0;
                $totalPrivateRevenue = 0;

                // doanh so cay he thong
                $listChild = $this->get_list_child_tree($user->user_id);
                foreach($listChild as $child){
                    $totalChild = $this->get_revenue_by_user($child->user_id,'02');
                    $totalRevenue = $totalRevenue + $totalChild;
                }
                // doanh so ca nhan
                $totalPrivateRevenue = $this->calculate_wholesale_sell_product_revenue_by_userid($user->user_id,$startMonth,$endMonth);

                if($totalRevenue > 0 || $totalPrivateRevenue > 0){
                    $dataAdd = array(
                        'user_id' => $user->user_id,
                        'group_id' => $user->group_id,
                        'parent_id' => $user->parent,
                        'created_date_str' => date("d-m-Y",time()),
                        'created_date' => time(),
                        'revenue_month_year' => $this->month_year,
                        'total' => $totalRevenue,
                        'private_profit' => $totalPrivateRevenue,
                        'type' => '02',
                        'status' => 0
                    );
                    $revenue = $this->revenue_model->add($dataAdd);
                }
                log_message("debug","Doanh số Bán sỉ Partner2 - UserID:".$user->user_id.",Doanh thu:".$totalRevenue.",Doanh thu CN:".$totalPrivateRevenue.",Loại:02,Tháng:".$this->month_year);
            }
        }
    }

    function wholesale_sell_product_revenue_partner1(){
        if(!$this->checkExistRevenueByGroupType(9,'02')){
            $this->load->model('revenue_model');
            $listUser = $this->get_all_partner1();

            $arr_start_end_date = $this->get_start_end_date();
            $startMonth = $arr_start_end_date[0];
            $endMonth = $arr_start_end_date[1];

            foreach($listUser as $user){
                $totalRevenue = 0;
                $totalChild = 0;
                $totalPrivateRevenue = 0;

                // doanh so cay he thong
                $listChild = $this->get_list_child_tree($user->user_id);
                foreach($listChild as $child){
                    $totalChild = $this->get_revenue_by_user($child->user_id,'02');
                    $totalRevenue = $totalRevenue + $totalChild;
                }
                // doanh so ca nhan
                $totalPrivateRevenue = $this->calculate_wholesale_sell_product_revenue_by_userid($user->user_id,$startMonth,$endMonth);

                if($totalRevenue > 0 || $totalPrivateRevenue > 0){
                    $dataAdd = array(
                        'user_id' => $user->user_id,
                        'group_id' => $user->group_id,
                        'parent_id' => $user->parent,
                        'created_date_str' => date("d-m-Y",time()),
                        'created_date' => time(),
                        'revenue_month_year' => $this->month_year,
                        'total' => $totalRevenue,
                        'private_profit' => $totalPrivateRevenue,
                        'type' => '02',
                        'status' => 0
                    );


                    $revenue = $this->revenue_model->add($dataAdd);
                }
                log_message("debug","Doanh số Bán sỉ Partner1 - UserID:".$user->user_id.",Doanh thu:".$totalRevenue.",Doanh thu CN:".$totalPrivateRevenue.",Loại:02,Tháng:".$this->month_year);
            }
        }
    }

    function wholesale_sell_product_revenue_coremember(){
        if(!$this->checkExistRevenueByGroupType(10,'02')){
            $this->load->model('revenue_model');
            $listUser = $this->get_all_coremember();

            $arr_start_end_date = $this->get_start_end_date();
            $startMonth = $arr_start_end_date[0];
            $endMonth = $arr_start_end_date[1];

            foreach($listUser as $user){
                $totalRevenue = 0;
                $totalChild = 0;
                $totalPrivateRevenue = 0;

                // doanh so cay he thong
                $listChild = $this->get_list_child_tree($user->user_id);
                foreach($listChild as $child){
                    $totalChild = $this->get_revenue_by_user($child->user_id,'02');
                    $totalRevenue = $totalRevenue + $totalChild;
                }
                // doanh so ca nhan
                $totalPrivateRevenue = $this->calculate_wholesale_sell_product_revenue_by_userid($user->user_id,$startMonth,$endMonth);

                if($totalRevenue > 0 || $totalPrivateRevenue > 0){
                    $dataAdd = array(
                        'user_id' => $user->user_id,
                        'group_id' => $user->group_id,
                        'parent_id' => $user->parent,
                        'created_date_str' => date("d-m-Y",time()),
                        'created_date' => time(),
                        'revenue_month_year' => $this->month_year,
                        'total' => $totalRevenue,
                        'private_profit' => $totalPrivateRevenue,
                        'type' => '02',
                        'status' => 0
                    );


                    $revenue = $this->revenue_model->add($dataAdd);
                }
                log_message("debug","Doanh số Bán sỉ CoreMemeber - UserID:".$user->user_id.",Doanh thu:".$totalRevenue.",Doanh thu CN:".$totalPrivateRevenue.",Loại:02,Tháng:".$this->month_year);
            }
        }
    }

    function wholesale_sell_product_revenue_coreadmin(){
        if(!$this->checkExistRevenueByGroupType(12,'02')){
            $this->load->model('revenue_model');
            $listUser = $this->get_all_coreadmin();

            $arr_start_end_date = $this->get_start_end_date();
            $startMonth = $arr_start_end_date[0];
            $endMonth = $arr_start_end_date[1];

            foreach($listUser as $user){
                $totalRevenue = 0;
                $totalChild = 0;
                $totalPrivateRevenue = 0;

                // doanh so cay he thong
                $listChild = $this->get_list_child_tree($user->user_id);
                foreach($listChild as $child){
                    $totalChild = $this->get_revenue_by_user($child->user_id,'02');
                    $totalRevenue = $totalRevenue + $totalChild;
                }
                // doanh so ca nhan
                $totalPrivateRevenue = $this->calculate_wholesale_sell_product_revenue_by_userid($user->user_id,$startMonth,$endMonth);

                if($totalRevenue > 0 || $totalPrivateRevenue > 0){
                    $dataAdd = array(
                        'user_id' => $user->user_id,
                        'group_id' => $user->group_id,
                        'parent_id' => $user->parent,
                        'created_date_str' => date("d-m-Y",time()),
                        'created_date' => time(),
                        'revenue_month_year' => $this->month_year,
                        'total' => $totalRevenue,
                        'private_profit' => $totalPrivateRevenue,
                        'type' => '02',
                        'status' => 0
                    );

                    $revenue = $this->revenue_model->add($dataAdd);
                }
                log_message("debug","Doanh số Bán sỉ CoreAdmin - UserID:".$user->user_id.",Doanh thu:".$totalRevenue.",Doanh thu CN:".$totalPrivateRevenue.",Loại:02,Tháng:".$this->month_year);
            }
        }
    }

    // get list child
    function get_list_child_tree($userid){
        $this->load->model('user_tree_model');
        if($userid > 0){
            $listChild = $this->user_tree_model->fetch("*", "parent = ".$userid);
            return $listChild;
        }
    }

    // sum retail sell product revenue by user
    function calculate_retail_sell_product_revenue_by_userid($userid,$start_month,$end_month){
        $c_month_year = $this->month_year;
        $this->load->model('revenue_store_category_model');
        if($userid > 0){
            $tAmount = $this->revenue_store_category_model->get("sum(rsc_profit) as tamount", "rsc_parent_id = $userid AND rsc_type = '05' AND rsc_created_month_year = '".$c_month_year."'");
            if($tAmount->tamount > 0){
                return $tAmount->tamount;
            }else{
                return 0;
            }
        }
        return 0;
    }

    // sum retail buy product revenue by user
    function calculate_retail_buy_product_revenue_by_userid($userid,$start_month,$end_month){
        $c_month_year = $this->month_year;
        $this->load->model('revenue_store_category_model');
        if($userid > 0){
            $tAmount = $this->revenue_store_category_model->get("sum(rsc_profit) as tamount", "rsc_parent_id = $userid AND rsc_type = '04' AND rsc_created_month_year = '".$c_month_year."'");
            if($tAmount->tamount > 0){
                return $tAmount->tamount;
            }else{
                return 0;
            }
        }
        return 0;
    }

    // sum retail buy product revenue store by user
    function calculate_retail_buy_product_revenue_store_by_userid($userid,$start_month,$end_month){
        $c_month_year = $this->month_year;
        $this->load->model('revenue_store_category_model');
        if($userid > 0){
            $tAmount = $this->revenue_store_category_model->get("sum(rsc_profit) as tamount", "rsc_parent_id = $userid AND rsc_type = '04' AND rsc_created_month_year = '".$c_month_year."'");
            if($tAmount->tamount > 0){
                return $tAmount->tamount;
            }else{
                return 0;
            }
        }
        return 0;
    }

    // sum sell product revenue by user
    function calculate_wholesale_sell_product_revenue_by_userid($userid,$start_month,$end_month){
        $c_month_year = $this->month_year;
        $this->load->model('revenue_store_category_model');
        if($userid > 0){
            $tAmount = $this->revenue_store_category_model->get("sum(rsc_profit) as tamount", "rsc_parent_id = $userid AND rsc_type = '02' AND rsc_created_month_year = '".$c_month_year."'");
            if($tAmount->tamount > 0){
                return $tAmount->tamount;
            }else{
                return 0;
            }
        }
        return 0;
    }

    // sum buy product revenue by user
    function calculate_wholesale_buy_product_revenue_by_userid($userid,$start_month,$end_month){
        $c_month_year = $this->month_year;
        $this->load->model('revenue_store_category_model');
        if($userid > 0){
            $tAmount = $this->revenue_store_category_model->get("sum(rsc_profit) as tamount", "rsc_parent_id = $userid AND rsc_type = '01' AND rsc_created_month_year = '".$c_month_year."'");
            if($tAmount->tamount > 0){
                return $tAmount->tamount;
            }else{
                return 0;
            }
        }
        return 0;
    }
    // sum service revenue by user

    function calculate_revenue_by_userid($userid,$start_month,$end_month){
        $this->load->model('package_user_model');
        $this->load->model('package_daily_user_model');
        if($userid > 0){
            // package service
            $tAmount = $this->package_user_model->get("sum(real_amount) as tamount", "sponser_id = $userid AND UNIX_TIMESTAMP(begined_date) >= ".$start_month. " AND UNIX_TIMESTAMP(begined_date) <= ".$end_month);
            // daily service
            $tAmount2 = $this->package_daily_user_model->get("sum(real_amount) as tamount2", "sponser_id = $userid AND (UNIX_TIMESTAMP(begined_date) >= ".$start_month. " AND UNIX_TIMESTAMP(begined_date) <= ".$end_month.")");
            if($tAmount->tamount > 0 || $tAmount2->tamount2 > 0){
                return $tAmount->tamount + $tAmount2->tamount2;
            }else{
                return 0;
            }
        }
        return 0;
    }

    // get revenue
    function solution_revenue_dev2()
    {
        if(!$this->checkExistRevenueByGroupType(6,'03')){
            $this->load->model('recalculation_model');
            $this->load->model('revenue_model');
            $listDev2 = $this->get_all_dev2();

            $arr_start_end_date = $this->get_start_end_date();
            $startMonth = $arr_start_end_date[0];
            $endMonth = $arr_start_end_date[1];

            foreach($listDev2 as $dev2){
                $totalRevenue = 0;
                $totalRevenue = $this->calculate_revenue_by_userid($dev2->user_id,$startMonth,$endMonth);
                if($totalRevenue > 0){
                    $dataAdd = array(
                        'user_id' => $dev2->user_id,
                        'group_id' => $dev2->group_id,
                        'parent_id' => $dev2->parent,
                        'created_date_str' => date("d-m-Y",time()),
                        'created_date' => time(),
                        'revenue_month_year' => $this->month_year,
                        'total' => $totalRevenue - (FEE_VAT * $totalRevenue),
                        'total_vat' => $totalRevenue,
                        'private_profit' => 0,
                        'private_profit_vat' => 0,
                        'type' => '03',
                        'status' => 0
                    );

                    $revenue = $this->revenue_model->add($dataAdd);
                }
                log_message("debug","Doanh thu Giải pháp - UserID:".$dev2->user_id.",Doanh thu:".$totalRevenue.",Tháng:".$this->month_year);

            }
        }
    }

    function checkExistRevenueByGroupType($groupid,$type){
        $c_month_year = $this->month_year;
        $this->load->model('revenue_model');
        $revenueToday = $this->revenue_model->fetch($select = "*", $where = "group_id = $groupid  AND type = '".$type."' AND revenue_month_year = '".$c_month_year."'", $order = "id", $by = "DESC", $start = 0, $limit = 1);
        if(count($revenueToday) == 1){
            return true;
        }
        return false;
    }

    function checkExistEmptyByType($user_id,$child_id,$type){
        $c_month_year = $this->month_year;
        $this->load->model('commission_empty_position_model');
        $emptyPosition = $this->commission_empty_position_model->fetch($select = "*", $where = "user_id = $user_id AND user_child_id = $child_id AND type = '".$type."' AND created_month_year = '".$c_month_year."'", $order = "id", $by = "DESC", $start = 0, $limit = 1);
        if(count($emptyPosition) == 1){
            return true;
        }
        return false;
    }

    function get_revenue_by_user($user_id,$type){
        $c_month_year = $this->month_year;
        $revenueToday = $this->revenue_model->get($select = "*", $where = "user_id = $user_id AND type = '".$type."' AND revenue_month_year = '".$c_month_year."'");
        if(count($revenueToday) > 0){
            if($revenueToday->total > 0 || $revenueToday->private_profit){
                return $revenueToday->total + $revenueToday->private_profit;
            }
        }
        return 0;
    }

    function get_personal_revenue_by_user($user_id,$type){
        $c_month_year = $this->month_year;
        $revenueToday = $this->revenue_model->get($select = "*", $where = "user_id = $user_id AND type = '".$type."' AND revenue_month_year = '".$c_month_year."'");
        if(count($revenueToday) > 0){
            if($revenueToday->private_profit > 0){
                return $revenueToday->private_profit;
            }
        }

        return 0;
    }

    function solution_revenue_dev1()
    {
        if(!$this->checkExistRevenueByGroupType(7,'03')){
            $this->load->model('revenue_model');
            $listDev1 = $this->get_all_dev1();

            $arr_start_end_date = $this->get_start_end_date();
            $startMonth = $arr_start_end_date[0];
            $endMonth = $arr_start_end_date[1];

            foreach($listDev1 as $dev1){
                $totalRevenue = 0;
                $totalChild = 0;
                $totalPrivateRevenue = 0;

                // doanh so cay he thong
                $listChild = $this->get_list_child_tree($dev1->user_id);
                foreach($listChild as $child){
                    $totalChild = $this->get_revenue_by_user($child->user_id,'03');
                    $totalRevenue = $totalRevenue + $totalChild;
                }
                // doanh so ca nhan
                $totalPrivateRevenue = $this->calculate_revenue_by_userid($dev1->user_id,$startMonth,$endMonth);

                if($totalRevenue > 0 || $totalPrivateRevenue > 0){
                    $dataAdd = array(
                        'user_id' => $dev1->user_id,
                        'group_id' => $dev1->group_id,
                        'parent_id' => $dev1->parent,
                        'created_date_str' => date("d-m-Y",time()),
                        'created_date' => time(),
                        'revenue_month_year' => $this->month_year,
                        'total' => $totalRevenue,
                        'private_profit' => $totalPrivateRevenue - (FEE_VAT * $totalPrivateRevenue),
                        'private_profit_vat' => $totalPrivateRevenue ,
                        'type' => '03',
                        'status' => 0
                    );
                    $revenue = $this->revenue_model->add($dataAdd);
                }
                log_message("debug","Doanh thu Giải pháp - UserID:".$dev1->user_id.",Doanh thu:".$totalRevenue.",Doanh thu CN:".$totalPrivateRevenue.",Tháng:".$this->month_year);
            }
        }
    }

    function solution_revenue_partner2()
    {
        if(!$this->checkExistRevenueByGroupType(8,'03')){
            $this->load->model('revenue_model');
            $listPartner2 = $this->get_all_partner2();

            $arr_start_end_date = $this->get_start_end_date();
            $startMonth = $arr_start_end_date[0];
            $endMonth = $arr_start_end_date[1];

            foreach($listPartner2 as $partner2){
                $totalRevenue = 0;
                $totalChild = 0;
                $totalPrivateRevenue = 0;

                // doanh so cay he thong
                $listChild = $this->get_list_child_tree($partner2->user_id);
               /* if($partner2->user_id == 1406)
                print_r($listChild);
               */
                foreach($listChild as $child){
                    $totalChild = $this->get_revenue_by_user($child->user_id,'03');
                    $totalRevenue = $totalRevenue + $totalChild;
                }
                // doanh so ca nhan
                $totalPrivateRevenue = $this->calculate_revenue_by_userid($partner2->user_id,$startMonth,$endMonth);

                if($totalRevenue > 0 || $totalPrivateRevenue > 0){
                    $dataAdd = array(
                        'user_id' => $partner2->user_id,
                        'group_id' => $partner2->group_id,
                        'parent_id' => $partner2->parent,
                        'created_date_str' => date("d-m-Y",time()),
                        'created_date' => time(),
                        'revenue_month_year' => $this->month_year,
                        'total' => $totalRevenue,
                        'private_profit' => $totalPrivateRevenue - (FEE_VAT * $totalPrivateRevenue),
                        'private_profit_vat' => $totalPrivateRevenue,
                        'type' => '03',
                        'status' => 0
                    );
                    $revenue = $this->revenue_model->add($dataAdd);
                }
                log_message("debug","Doanh thu Giải pháp - UserID:".$partner2->user_id.",Doanh thu:".$totalRevenue.",Doanh thu CN:".$totalPrivateRevenue.",Tháng:".$this->month_year);
            }
        }
    }

    function solution_revenue_partner1()
    {
        if(!$this->checkExistRevenueByGroupType(9,'03')){
            $this->load->model('revenue_model');
            $listPartner1 = $this->get_all_partner1();

            $arr_start_end_date = $this->get_start_end_date();
            $startMonth = $arr_start_end_date[0];
            $endMonth = $arr_start_end_date[1];

            foreach($listPartner1 as $partner1){
                $totalRevenue = 0;
                $totalChild = 0;
                $totalPrivateRevenue = 0;

                // doanh so cay he thong
                $listChild = $this->get_list_child_tree($partner1->user_id);
                foreach($listChild as $child){
                    $totalChild = $this->get_revenue_by_user($child->user_id,'03');
                    $totalRevenue = $totalRevenue + $totalChild;
                }
                // doanh so ca nhan
                $totalPrivateRevenue = $this->calculate_revenue_by_userid($partner1->user_id,$startMonth,$endMonth);

                if($totalRevenue > 0 || $totalPrivateRevenue > 0){
                    $dataAdd = array(
                        'user_id' => $partner1->user_id,
                        'group_id' => $partner1->group_id,
                        'parent_id' => $partner1->parent,
                        'created_date_str' => date("d-m-Y",time()),
                        'created_date' => time(),
                        'revenue_month_year' => $this->month_year,
                        'total' => $totalRevenue,
                        'private_profit' => $totalPrivateRevenue - (FEE_VAT * $totalPrivateRevenue),
                        'private_profit_vat' => $totalPrivateRevenue,
                        'type' => '03',
                        'status' => 0
                    );
                    $revenue = $this->revenue_model->add($dataAdd);
                }
                log_message("debug","Doanh thu Giải pháp - UserID:".$partner1->user_id.",Doanh thu:".$totalRevenue.",Doanh thu CN:".$totalPrivateRevenue.",Tháng:".$this->month_year);
            }
        }
    }

    function solution_revenue_coremember()
    {
        if(!$this->checkExistRevenueByGroupType(10,'03')){
            $this->load->model('revenue_model');
            $listCoremember = $this->get_all_coremember();

            $arr_start_end_date = $this->get_start_end_date();
            $startMonth = $arr_start_end_date[0];
            $endMonth = $arr_start_end_date[1];

            foreach($listCoremember as $coremember){
                $totalRevenue = 0;
                $totalChild = 0;
                $totalPrivateRevenue = 0;

                // doanh so cay he thong
                $listChild = $this->get_list_child_tree($coremember->user_id);
                foreach($listChild as $child){
                    $totalChild = $this->get_revenue_by_user($child->user_id,'03');
                    $totalRevenue = $totalRevenue + $totalChild;
                }

                // doanh so ca nhan
                $totalPrivateRevenue = $this->calculate_revenue_by_userid($coremember->user_id,$startMonth,$endMonth);

                if($totalRevenue > 0 || $totalPrivateRevenue > 0){
                    $dataAdd = array(
                        'user_id' => $coremember->user_id,
                        'group_id' => $coremember->group_id,
                        'parent_id' => $coremember->parent,
                        'created_date_str' => date("d-m-Y",time()),
                        'created_date' => time(),
                        'revenue_month_year' => $this->month_year,
                        'total' => $totalRevenue,
                        'private_profit' => $totalPrivateRevenue - (FEE_VAT * $totalPrivateRevenue),
                        'private_profit_vat' => $totalPrivateRevenue,
                        'type' => '03',
                        'status' => 0
                    );
                    $revenue = $this->revenue_model->add($dataAdd);
                }
                log_message("debug","Doanh thu Giải pháp - UserID:".$coremember->user_id.",Doanh thu:".$totalRevenue.",Doanh thu CN:".$totalPrivateRevenue.",Tháng:".$this->month_year);
            }
        }
    }

    function solution_revenue_coreadmin()
    {
        if(!$this->checkExistRevenueByGroupType(12,'03')){
            $this->load->model('revenue_model');
            $listCoreAdmin = $this->get_all_coreadmin();

            $arr_start_end_date = $this->get_start_end_date();
            $startMonth = $arr_start_end_date[0];
            $endMonth = $arr_start_end_date[1];

            foreach($listCoreAdmin as $coreadmin){
                $totalRevenue = 0;
                $totalChild = 0;
                $totalPrivateRevenue = 0;

                // doanh so cay he thong
                $listChild = $this->get_list_child_tree($coreadmin->user_id);
                foreach($listChild as $child){
                    $totalChild = $this->get_revenue_by_user($child->user_id,'03');
                    $totalRevenue = $totalRevenue + $totalChild;
                }
                // doanh so ca nhan
                $totalPrivateRevenue = $this->calculate_revenue_by_userid($coreadmin->user_id,$startMonth,$endMonth);

                if($totalRevenue > 0 || $totalPrivateRevenue > 0){
                    $dataAdd = array(
                        'user_id' => $coreadmin->user_id,
                        'group_id' => $coreadmin->group_id,
                        'parent_id' => $coreadmin->parent,
                        'created_date_str' => date("d-m-Y",time()),
                        'created_date' => time(),
                        'revenue_month_year' => $this->month_year,
                        'total' => $totalRevenue,
                        'private_profit' => $totalPrivateRevenue - (FEE_VAT * $totalPrivateRevenue),
                        'private_profit_vat' => $totalPrivateRevenue,
                        'type' => '03',
                        'status' => 0
                    );
                    $revenue = $this->revenue_model->add($dataAdd);
                }
                log_message("debug","Doanh thu Giải pháp - UserID:".$coreadmin->user_id.",Doanh thu:".$totalRevenue.",Doanh thu CN:".$totalPrivateRevenue.",Tháng:".$this->month_year);
            }
        }
    }

    //get user by group

    function get_all_dev2(){
        $this->load->model('user_tree_model');
        $listDev2 = $this->user_tree_model->fetch("*","group_id = 6");
        return $listDev2;
    }

    function get_all_dev1(){
        $this->load->model('user_tree_model');
        $listDev1 = $this->user_tree_model->fetch("*","group_id = 7");
        return $listDev1;
    }

    function get_all_partner2(){
        $this->load->model('user_tree_model');
        $listPartner2 = $this->user_tree_model->fetch("*","group_id = 8");
        return $listPartner2;
    }

    function get_all_partner1(){
        $this->load->model('user_tree_model');
        $listParter1 = $this->user_tree_model->fetch("*","group_id = 9");
        return $listParter1;
    }

    function get_all_coremember(){
        $this->load->model('user_tree_model');
        $listCore = $this->user_tree_model->fetch("*","group_id = 10");
        return $listCore;
    }

    function get_all_coreadmin(){
        $this->load->model('user_tree_model');
        $listCoreAdmin = $this->user_tree_model->fetch("*","group_id = 12");
        return $listCoreAdmin;
    }

    // check commission
    function checkExistCommissionTodayByGroup($groupid,$type){
        $c_month_year = $this->month_year;
        $this->load->model('commission_model');
        $commissionToday = $this->commission_model->fetch($select = "*", $where = "group_id = $groupid AND type = '".$type."' AND commission_month = '".$c_month_year."'", $order = "id", $by = "DESC", $start = 0, $limit = 1);
        if(count($commissionToday) == 1){
            return true;
        }
        return false;
    }

    function get_percent_solution_dev2($revenue){
        $percent = 0;
        $listConfig = $this->solution_commission_model->fetch("*","id IN (1,2,3,4,5)","id","ASC");
        if($revenue < 10000000){
            $percent = $listConfig[0]->commission;
        }
        if($revenue >= 10000000 && $revenue < 20000000){
            $percent = $listConfig[1]->commission;
        }
        if($revenue >= 20000000 && $revenue < 30000000){
            $percent = $listConfig[2]->commission;
        }
        if($revenue >= 30000000 && $revenue < 50000000){
            $percent = $listConfig[3]->commission;
        }
        if($revenue >= 50000000){
            $percent = $listConfig[4]->commission;
        }
        return $percent;
    }

    function get_config_solution_commission($group){
        $this->load->model('solution_commission_model');

        if($group == 7){
            $listConfig = $this->solution_commission_model->fetch("*","id IN (6)","id","ASC");
        }
        if($group == 8){
            $listConfig = $this->solution_commission_model->fetch("*","id IN (7)","id","ASC");
        }
        if($group == 9){
            $listConfig = $this->solution_commission_model->fetch("*","id IN (8)","id","ASC");
        }
        if($group == 10){
            $listConfig = $this->solution_commission_model->fetch("*","id IN (9)","id","ASC");
        }
        if($group == 12){
            $listConfig = $this->solution_commission_model->fetch("*","id IN (10)","id","ASC");
        }

        return $listConfig[0]->commission;
    }
    // calculate commission
    function solution_commission_dev2()
    {
        if(!$this->checkExistCommissionTodayByGroup(6,'03')){
            $this->load->model('solution_commission_model');
            $this->load->model('commission_model');
            $listUser = $this->get_all_dev2();

            foreach($listUser as $user){
                $revenue = 0;
                $percent = 0;
                $comission = 0;
                $revenue = $this->get_revenue_by_user($user->user_id,'03');
                $percent = $this->get_percent_solution_dev2($revenue);

                $comission= $revenue * ($percent/100);

				if($comission > 0){
					$dataAdd = array(
						'user_id' => $user->user_id,
						'group_id' => $user->group_id,
						'parent_id' => $user->parent,
						'commission' => $comission,
						'percent' => $percent,
						'profit' => $revenue,
						'type' => '03',
						'description' => 'Hoa hồng bán Giải pháp',
						'commission_month' => $this->month_year,
						'created_date' => time(),
						'created_date_str' => date("d-m-Y",time()),
						'payment_date' => time(),
						'payment_status' => 0,
						'status' => 0
					);
					$commission = $this->commission_model->add($dataAdd);

					$dataMoney = array(
						'user_id' => $user->user_id,
						'group_id' => $user->group_id,
						'parent_id' => $user->parent,
						'amount' => $comission,
						'type' => '03',
						'description' => 'Tiền Hoa hồng bán Giải pháp',
						'created_date' => date("Y-m-d H:i:s"),
						'month_year' => $this->month_year,
						'status' => 0
					);

                    $this->persional_money_by_type($dataMoney);
                }
                log_message("debug","Hoa hồng Giải pháp - UserID:".$user->user_id.",Doanh thu:".$revenue.",Phần trăm:".$percent.",Hoa hồng:".$comission.",Tháng:".$this->month_year);

            }
        }
    }

    function getListChildTree($userid){
        $this->load->model('user_tree_model');
        if($userid > 0){
            $listChild = $this->user_tree_model->fetch("tbtt_user_tree.*", "parent=".$userid);
            return $listChild;
        }
    }

    // number of affiliate
    function number_of_affiliate_by_user($userid){
        $this->load->model('user_model');
        if($userid > 0){
            $numberAF = $this->user_model->get("count(*) as numberAffiliate", "use_group = 3 AND use_status = 1 AND parent_id = $userid");
            if($numberAF->numberAffiliate > 0){
                return $numberAF->numberAffiliate;
            }else{
                return 0;
            }
        }
        return 0;
    }

    // commission
    function solution_commission_dev1()
    {
        if(!$this->checkExistCommissionTodayByGroup(7,'03')){
            $this->load->model('commission_model');

            $this->load->model('revenue_model');
            $this->load->model('solution_commission_model');
            $listConfig = $this->solution_commission_model->fetch("*","id IN (6)","id","ASC");
            $listUser = $this->get_all_dev1();
            foreach($listUser as $user){
                $revenue = 0;
                $percent = 0;
                $comission = 0;
                $percentDev2 = 0;
                $revenuePrivate = 0;
                $arrListChild = array();

                $revenue = $this->get_revenue_by_user($user->user_id,'03');

                $percent = $listConfig[0]->commission;

                $revenuePrivate = $this->get_personal_revenue_by_user($user->user_id,'03');
                $percentDev2 = $this->get_percent_solution_dev2($revenuePrivate);
                $comissionPrivate = $revenuePrivate * ($percentDev2/100);

                if($comissionPrivate > 0){
                    $dataAdd = array(
                        'user_id' => $user->user_id,
                        'group_id' => $user->group_id,
                        'parent_id' => $user->parent,
                        'commission' => $comissionPrivate,
                        'percent' => $percentDev2,
                        'profit' => $revenuePrivate,
                        'type' => '03',
                        'description' => 'Hoa hồng bán Giải pháp cá nhân',
                        'commission_month' => $this->month_year,
                        'created_date' => time(),
                        'created_date_str' => date("d-m-Y",time()),
                        'payment_date' => time(),
                        'payment_status' => 0,
                        'status' => 0
                    );
                    $commissionAdd = $this->commission_model->add($dataAdd);
                    $dataMoney = array(
                        'user_id' => $user->user_id,
                        'group_id' => $user->group_id,
                        'parent_id' => $user->parent,
                        'amount' => $comissionPrivate,
                        'type' => '03',
                        'description' => 'Tiền Hoa hồng bán Giải pháp cá nhân',
                        'created_date' => date("Y-m-d H:i:s"),
                        'month_year' => $this->month_year,
                        'status' => 0
                    );

                    $this->persional_money_by_type($dataMoney);
                }

                $comission = $revenue * ($percent/100);
                if($comission > 0){
                    $dataAdd = array(
                        'user_id' => $user->user_id,
                        'group_id' => $user->group_id,
                        'parent_id' => $user->parent,
                        'commission' => $comission,
                        'percent' => $percent,
                        'profit' => $revenue,
                        'type' => '03',
                        'description' => 'Hoa hồng bán Giải pháp',
                        'commission_month' => $this->month_year,
                        'created_date' => time(),
                        'created_date_str' => date("d-m-Y",time()),
                        'payment_date' => time(),
                        'payment_status' => 0,
                        'status' => 0
                    );
                    $commissionAdd = $this->commission_model->add($dataAdd);
                    $dataMoney = array(
                        'user_id' => $user->user_id,
                        'group_id' => $user->group_id,
                        'parent_id' => $user->parent,
                        'amount' => $comission,
                        'type' => '03',
                        'description' => 'Tiền hoa hồng bán Giải pháp',
                        'created_date' => date("Y-m-d H:i:s"),
                        'month_year' => $this->month_year,
                        'status' => 0
                    );

                    $this->persional_money_by_type($dataMoney);
                }
                log_message("debug","Hoa hồng Giải pháp - UserID:".$user->user_id.",Doanh thu:".$revenue.",Phần trăm:".$percent.",Hoa hồng:".$comission.",Doanh thu CN:".$revenuePrivate.",Phần trăm CN:".$percentDev2.",Hoa hồng CN:".$comissionPrivate.",Tháng:".$this->month_year);

            }
        }
    }

    function solution_commission_partner2()
    {
        if(!$this->checkExistCommissionTodayByGroup(8,'03')){
            $this->load->model('commission_model');

            $this->load->model('revenue_model');
            $this->load->model('solution_commission_model');
            $listConfig = $this->solution_commission_model->fetch("*","id IN (7)","id","ASC");
            $listUser = $this->get_all_partner2();
            foreach($listUser as $user){
                $revenue = 0;
                $percent = 0;
                $comission = 0;
                $revenue = $this->get_revenue_by_user($user->user_id,'03');

                $percent = $listConfig[0]->commission;

                $comission = $revenue * ($percent/100);

                $revenuePrivate = $this->get_personal_revenue_by_user($user->user_id,'03');
                $percentDev2 = $this->get_percent_solution_dev2($revenuePrivate);
                $comissionPrivate = $revenuePrivate * ($percentDev2/100);

                if($comissionPrivate > 0){
                    $dataAdd = array(
                        'user_id' => $user->user_id,
                        'group_id' => $user->group_id,
                        'parent_id' => $user->parent,
                        'commission' => $comissionPrivate,
                        'percent' => $percentDev2,
                        'profit' => $revenuePrivate,
                        'type' => '03',
                        'description' => 'Hoa hồng bán Giải pháp cá nhân',
                        'commission_month' => $this->month_year,
                        'created_date' => time(),
                        'created_date_str' => date("d-m-Y",time()),
                        'payment_date' => time(),
                        'payment_status' => 0,
                        'status' => 0
                    );
                    $commissionAdd = $this->commission_model->add($dataAdd);
                    $dataMoney = array(
                        'user_id' => $user->user_id,
                        'group_id' => $user->group_id,
                        'parent_id' => $user->parent,
                        'amount' => $comissionPrivate,
                        'type' => '03',
                        'description' => 'Tiền Hoa hồng bán Giải pháp cá nhân',
                        'created_date' => date("Y-m-d H:i:s"),
                        'month_year' => $this->month_year,
                        'status' => 0
                    );

                    $this->persional_money_by_type($dataMoney);
                }

                if($comission > 0){
                    $dataAdd = array(
                        'user_id' => $user->user_id,
                        'group_id' => $user->group_id,
                        'parent_id' => $user->parent,
                        'commission' => $comission,
                        'percent' => $percent,
                        'profit' => $revenue,
                        'type' => '03',
                        'description' => 'Hoa hồng bán Giải pháp',
                        'commission_month' => $this->month_year,
                        'created_date' => time(),
                        'created_date_str' => date("d-m-Y",time()),
                        'payment_date' => time(),
                        'payment_status' => 0,
                        'status' => 0
                    );
                    $commissionAdd = $this->commission_model->add($dataAdd);
                    $dataMoney = array(
                        'user_id' => $user->user_id,
                        'group_id' => $user->group_id,
                        'parent_id' => $user->parent,
                        'amount' => $comission,
                        'type' => '03',
                        'description' => 'Tiền hoa hồng bán Giải pháp',
                        'created_date' => date("Y-m-d H:i:s"),
                        'month_year' => $this->month_year,
                        'status' => 0
                    );

                    $this->persional_money_by_type($dataMoney);
                }
                log_message("debug","Hoa hồng Giải pháp - UserID:".$user->user_id.",Doanh thu:".$revenue.",Phần trăm:".$percent.",Hoa hồng:".$comission.",Doanh thu CN:".$revenuePrivate.",Phần trăm CN:".$percentDev2.",Hoa hồng CN:".$comissionPrivate.",Tháng:".$this->month_year);

            }
        }
    }

    function solution_commission_partner1()
    {
        if(!$this->checkExistCommissionTodayByGroup(9,'03')){
            $this->load->model('commission_model');

            $this->load->model('revenue_model');
            $this->load->model('solution_commission_model');
            $listConfig = $this->solution_commission_model->fetch("*","id IN (8)","id","ASC");
            $listUser = $this->get_all_partner1();

            foreach($listUser as $user){
                $revenue = 0;
                $percent = 0;
                $comission = 0;
                $arrListChild = array();
                $revenue = $this->get_revenue_by_user($user->user_id,'03');

                $percent = $listConfig[0]->commission;
                $comission = $revenue * ($percent/100);

                $revenuePrivate = $this->get_personal_revenue_by_user($user->user_id,'03');
                $percentDev2 = $this->get_percent_solution_dev2($revenuePrivate);
                $comissionPrivate = $revenuePrivate * ($percentDev2/100);

                if($comissionPrivate > 0){
                    $dataAdd = array(
                        'user_id' => $user->user_id,
                        'group_id' => $user->group_id,
                        'parent_id' => $user->parent,
                        'commission' => $comissionPrivate,
                        'percent' => $percentDev2,
                        'profit' => $revenuePrivate,
                        'type' => '03',
                        'description' => 'Hoa hồng bán Giải pháp cá nhân',
                        'commission_month' => $this->month_year,
                        'created_date' => time(),
                        'created_date_str' => date("d-m-Y",time()),
                        'payment_date' => time(),
                        'payment_status' => 0,
                        'status' => 0
                    );
                    $commissionAdd = $this->commission_model->add($dataAdd);
                    $dataMoney = array(
                        'user_id' => $user->user_id,
                        'group_id' => $user->group_id,
                        'parent_id' => $user->parent,
                        'amount' => $comissionPrivate,
                        'type' => '03',
                        'description' => 'Tiền Hoa hồng bán Giải pháp cá nhân',
                        'created_date' => date("Y-m-d H:i:s"),
                        'month_year' => $this->month_year,
                        'status' => 0
                    );

                    $this->persional_money_by_type($dataMoney);
                }

                if($comission > 0){
                    $dataAdd = array(
                        'user_id' => $user->user_id,
                        'group_id' => $user->group_id,
                        'parent_id' => $user->parent,
                        'commission' => $comission,
                        'percent' => $percent,
                        'profit' => $revenue,
                        'type' => '03',
                        'description' => 'Hoa hồng bán Giải pháp',
                        'commission_month' => $this->month_year,
                        'created_date' => time(),
                        'created_date_str' => date("d-m-Y",time()),
                        'payment_date' => time(),
                        'payment_status' => 0,
                        'status' => 0
                    );
                    $commissionAdd = $this->commission_model->add($dataAdd);
                    $dataMoney = array(
                        'user_id' => $user->user_id,
                        'group_id' => $user->group_id,
                        'parent_id' => $user->parent,
                        'amount' => $comission,
                        'type' => '03',
                        'description' => 'Tiền hoa hồng bán Giải pháp',
                        'created_date' => date("Y-m-d H:i:s"),
                        'month_year' => $this->month_year,
                        'status' => 0
                    );
                    $this->persional_money_by_type($dataMoney);
                }
                log_message("debug","Hoa hồng Giải pháp - UserID:".$user->user_id.",Doanh thu:".$revenue.",Phần trăm:".$percent.",Hoa hồng:".$comission.",Doanh thu CN:".$revenuePrivate.",Phần trăm CN:".$percentDev2.",Hoa hồng CN:".$comissionPrivate.",Tháng:".$this->month_year);

            }
        }
    }

    function solution_commission_coremember()
    {
        if(!$this->checkExistCommissionTodayByGroup(10,'03')){
            $this->load->model('commission_model');

            $this->load->model('revenue_model');
            $this->load->model('solution_commission_model');
            $listConfig = $this->solution_commission_model->fetch("*","id IN (9)","id","ASC");
            $listUser = $this->get_all_coremember();
            foreach($listUser as $user){
                $revenue = 0;
                $percent = 0;
                $comission = 0;
                $arrListChild = array();
                $revenue = $this->get_revenue_by_user($user->user_id,'03');
                $percent = $listConfig[0]->commission;
                $comission = $revenue * ($percent/100);

                $revenuePrivate = $this->get_personal_revenue_by_user($user->user_id,'03');
                $percentDev2 = $this->get_percent_solution_dev2($revenuePrivate);
                $comissionPrivate = $revenuePrivate * ($percentDev2/100);

                if($comissionPrivate > 0){
                    $dataAdd = array(
                        'user_id' => $user->user_id,
                        'group_id' => $user->group_id,
                        'parent_id' => $user->parent,
                        'commission' => $comissionPrivate,
                        'percent' => $percentDev2,
                        'profit' => $revenuePrivate,
                        'type' => '03',
                        'description' => 'Hoa hồng bán Giải pháp cá nhân',
                        'commission_month' => $this->month_year,
                        'created_date' => time(),
                        'created_date_str' => date("d-m-Y",time()),
                        'payment_date' => time(),
                        'payment_status' => 0,
                        'status' => 0
                    );
                    $commissionAdd = $this->commission_model->add($dataAdd);
                    $dataMoney = array(
                        'user_id' => $user->user_id,
                        'group_id' => $user->group_id,
                        'parent_id' => $user->parent,
                        'amount' => $comissionPrivate,
                        'type' => '03',
                        'description' => 'Tiền Hoa hồng bán Giải pháp cá nhân',
                        'created_date' => date("Y-m-d H:i:s"),
                        'month_year' => $this->month_year,
                        'status' => 0
                    );

                    $this->persional_money_by_type($dataMoney);
                }

                if($comission > 0){
                    $dataAdd = array(
                        'user_id' => $user->user_id,
                        'group_id' => $user->group_id,
                        'parent_id' => $user->parent,
                        'commission' => $comission,
                        'percent' => $percent,
                        'profit' => $revenue,
                        'type' => '03',
                        'description' => 'Hoa hồng bán Giải pháp',
                        'commission_month' => $this->month_year,
                        'created_date' => time(),
                        'created_date_str' => date("d-m-Y",time()),
                        'payment_date' => time(),
                        'payment_status' => 0,
                        'status' => 0
                    );
                    $commissionAdd = $this->commission_model->add($dataAdd);

                    $dataMoney = array(
                        'user_id' => $user->user_id,
                        'group_id' => $user->group_id,
                        'parent_id' => $user->parent,
                        'amount' => $comission,
                        'type' => '03',
                        'description' => 'Tiền hoa hồng bán Giải pháp',
                        'created_date' => date("Y-m-d H:i:s"),
                        'month_year' => $this->month_year,
                        'status' => 0
                    );

                    $this->persional_money_by_type($dataMoney);
                }
                log_message("debug","Hoa hồng Giải pháp - UserID:".$user->user_id.",Doanh thu:".$revenue.",Phần trăm:".$percent.",Hoa hồng:".$comission.",Doanh thu CN:".$revenuePrivate.",Phần trăm CN:".$percentDev2.",Hoa hồng CN:".$comissionPrivate.",Tháng:".$this->month_year);

            }
        }
    }

    function solution_commission_coreadmin()
    {
        if(!$this->checkExistCommissionTodayByGroup(12,'03')){
            $this->load->model('commission_model');

            $this->load->model('revenue_model');
            $this->load->model('solution_commission_model');
            $listConfig = $this->solution_commission_model->fetch("*","id IN (10)","id","ASC");
            $listUser = $this->get_all_coreadmin();
            foreach($listUser as $user){
                $revenue = 0;
                $percent = 0;
                $comission = 0;

                $revenue = $this->get_revenue_by_user($user->user_id,'03');

                $percent = $listConfig[0]->commission;
                $comission = $revenue * ($percent/100);

                $revenuePrivate = $this->get_personal_revenue_by_user($user->user_id,'03');
                $percentDev2 = $this->get_percent_solution_dev2($revenuePrivate);
                $comissionPrivate = $revenuePrivate * ($percentDev2/100);

                if($comissionPrivate > 0){
                    $dataAdd = array(
                        'user_id' => $user->user_id,
                        'group_id' => $user->group_id,
                        'parent_id' => $user->parent,
                        'commission' => $comissionPrivate,
                        'percent' => $percentDev2,
                        'profit' => $revenuePrivate,
                        'type' => '03',
                        'description' => 'Hoa hồng bán Giải pháp cá nhân',
                        'commission_month' => $this->month_year,
                        'created_date' => time(),
                        'created_date_str' => date("d-m-Y",time()),
                        'payment_date' => time(),
                        'payment_status' => 0,
                        'status' => 0
                    );
                    $commissionAdd = $this->commission_model->add($dataAdd);
                    $dataMoney = array(
                        'user_id' => $user->user_id,
                        'group_id' => $user->group_id,
                        'parent_id' => $user->parent,
                        'amount' => $comissionPrivate,
                        'type' => '03',
                        'description' => 'Tiền Hoa hồng bán Giải pháp cá nhân',
                        'created_date' => date("Y-m-d H:i:s"),
                        'month_year' => $this->month_year,
                        'status' => 0
                    );

                    $this->persional_money_by_type($dataMoney);
                }

				if($comission > 0){
				$dataAdd = array(
					'user_id' => $user->user_id,
					'group_id' => $user->group_id,
					'parent_id' => $user->parent,
					'commission' => $comission,
					'percent' => $percent,
					'profit' => $revenue,
					'type' => '03',
					'description' => 'Hoa hồng bán Giải pháp',
					'commission_month' => $this->month_year,
					'created_date' => time(),
					'created_date_str' => date("d-m-Y",time()),
					'payment_date' => time(),
					'payment_status' => 0,
					'status' => 0
				);
				$commissionAdd = $this->commission_model->add($dataAdd);

				$dataMoney = array(
					'user_id' => $user->user_id,
					'group_id' => $user->group_id,
					'parent_id' => $user->parent,
					'amount' => $comission,
					'type' => '03',
					'description' => 'Tiền hoa hồng bán Giải pháp',
					'created_date' => date("Y-m-d H:i:s"),
					'month_year' => $this->month_year,
					'status' => 0
				);

				$this->persional_money_by_type($dataMoney);
				}
                log_message("debug","Hoa hồng Giải pháp - UserID:".$user->user_id.",Doanh thu:".$revenue.",Phần trăm:".$percent.",Hoa hồng:".$comission.",Doanh thu CN:".$revenuePrivate.",Phần trăm CN:".$percentDev2.",Hoa hồng CN:".$comissionPrivate.",Tháng:".$this->month_year);

			}
		}
    }
    // Huy don hang neu trong vong 24h gio chu gian hang ko xu ly

    public function cancelOrder(){
        //update order ve trạng thái 99: Huy don hang neu trong vong 24h gio chu gian hang ko xu ly
        $this->load->model('order_model');
        $order_cart = $this->order_model->fetch('id,order_saler,order_clientCode,change_status_date',"order_status = '01'");
        // echo date('d/m/Y',1467772516);
        foreach($order_cart as $vals){
            $total   = time() - $vals->change_status_date;
            $hours   = floor($total / 3600);
            if ($hours >= process_oder_time){
                $this->order_model->updateOrderCode($vals->order_clientCode,'99',$vals->order_saler,$vals->id);
                log_message("debug","Đơn hàng đã bị hủy sau 24h không xử lý - Đơn hàng:".$vals->id.",Từ:".$vals->order_status.",Thành:99, Ngày giờ:".date("d-m-Y H:i:s"));
            }
        }
    }
    
    public function ghnOrderComplete(){
        //update order ve trạng thái 98: Đã hoàn thành sau khi đơn hàng đã giao xong 48h
        $this->load->model('order_model');
        $order_cart = $this->order_model->fetch('id, order_saler, order_clientCode, change_status_date',"order_status = '03'");
       // echo date('d/m/Y',1467772516);
        foreach($order_cart as $vals){
            $total   = time() - $vals->change_status_date;
            $hours   = floor($total / 3600);

            if ($hours >= timeOrderComplete){
                $this->order_model->updateOrderCode($vals->order_clientCode,'98',$vals->order_saler,$vals->id);
                log_message("debug","Đơn hàng hoàn thành sau 48h giao xong  - Đơn hàng:".$vals->id.",Từ:".$vals->order_status.",Thành:98,Mã GHN:".$vals->order_clientCode.",Ngày giờ:".date("d-m-Y H:i:s"));
            }
        }
    }

    public function ghnUpdateOrder(){
        $this->load->model('order_model');
        $this->load->model('showcart_model');
        $this->load->library('RestApiClient');
        $this->RestApiClient = new RestApiClient();//khoi tao

        $serviceClient  = $this->RestApiClient->connectGHN();
        $sessionToken   = $serviceClient->SignIn();
        $serviceClient->SignOut();
        $arrProduct     =   array();

        $order_list     =   $this->order_model->getListOrders(array('order_status'=>'02'),array('key'=>'id','value'=>'ASC'),'id,order_saler,order_status,order_clientCode,payment_method');

        foreach($order_list as $vals){
            $GetOrderInfo = array(
                "SessionToken"      =>  $sessionToken,
                'OrderCode'         =>  $vals->order_clientCode
            );
            $reponseGetOrderInfo = $serviceClient->GetOrderInfo($GetOrderInfo);
            switch ($reponseGetOrderInfo['CurrentStatus']) {
                case "Cancel":
                    if($vals->payment_method == "info_nganluong"){
                        $this->order_model->updateOrderCode($vals->order_clientCode,'06',$vals->order_saler,$vals->id);
                        log_message("debug","Cập nhật tình trạng vận chuyển đơn hàng  - Đơn hàng:".$vals->id.",Từ:".$vals->order_status.",Thành:06,Mã GHN:".$vals->order_clientCode.",Ngày giờ:".date("d-m-Y H:i:s"));
                    } else {
                        $this->order_model->updateOrderCode($vals->order_clientCode,'04',$vals->order_saler,$vals->id);
                        log_message("debug","Cập nhật tình trạng vận chuyển đơn hàng  - Đơn hàng:".$vals->id.",Từ:".$vals->order_status.",Thành:04,Mã GHN:".$vals->order_clientCode.",Ngày giờ:".date("d-m-Y H:i:s"));
                    }
                    break;
                case "Delivered":
                    $this->order_model->updateOrderCode($vals->order_clientCode,'03',$vals->order_saler,$vals->id);
                    log_message("debug","Cập nhật tình trạng vận chuyển đơn hàng  - Đơn hàng:".$vals->id.",Từ:".$vals->order_status.",Thành:03,Mã GHN:".$vals->order_clientCode.",Ngày giờ:".date("d-m-Y H:i:s"));
                    break;
                case "Finish":
                    $this->order_model->updateOrderCode($vals->order_clientCode,'03',$vals->order_saler,$vals->id);
                    log_message("debug","Cập nhật tình trạng vận chuyển đơn hàng  - Đơn hàng:".$vals->id.",Từ:".$vals->order_status.",Thành:03,Mã GHN:".$vals->order_clientCode.",Ngày giờ:".date("d-m-Y H:i:s"));
                    break;

                case "WaitingToFinish":
                    $this->order_model->updateOrderCode($vals->order_clientCode,'03',$vals->order_saler,$vals->id);
                    log_message("debug","Cập nhật tình trạng vận chuyển đơn hàng  - Đơn hàng:".$vals->id.",Từ:".$vals->order_status.",Thành:03,Mã GHN:".$vals->order_clientCode.",Ngày giờ:".date("d-m-Y H:i:s"));
                    break;
            }
            sleep(10);
        }
    }

    public function cronDelivery(){
        $this->load->model('delivery_model');
        $this->load->model('delivery_comments_model');

        $this->load->model('order_model');
        $this->load->model('showcart_model');
        $this->load->model('product_model');
        $this->load->model('shop_model');
        $this->load->model('user_model');

        foreach($this->delivery_model->cronDelivery(array('status_id'=>"01")) as $vals){
            $status_id                      =       "02";
            $where['status_id']             =       $status_id;
            $where['lastupdated']           =       date("Y-m-d H:i:s",time());

            $comments = array(
                'id_request'                =>      $vals->id,
                'status_changedelivery'     =>      $status_id,
                'user_id'                   =>      $vals->order_saler,
                'content'                   =>      'Bạn vui lòng upload mẫu vận đơn',
                'status_comment'            =>      "1",
                'lastupdated'               =>      $where['lastupdated']
            );

            $this->delivery_comments_model->add($comments);
            $this->delivery_model->update($where,'id = '.$vals->id);

            //send email
            $_data['shop_info']  =   $this->shop_model->get('sho_name','sho_user = '.$vals->order_saler);
            $_data['user_info']  =   $this->user_model->get('use_email','use_id = '.$vals->order_saler);

            if($_delivery[0]->email && $_data['user_info']->use_email){
                $_data['content']       =   $this->input->post('content');
                $_data['delivery_id']   =   $_delivery[0]->order_id;
                $_data['order_info']    =   $this->order_model->get('order_token','id = '.$_delivery[0]->order_id);
                $content_email          =   $this->load->view('home/account/showcart/email', $_data, true);
                $this->sendEmail($vals->email,$_data['user_info']->use_email,$content_email);
            }
        }

        die("cron delivery success!!!");
   }

//    public function cron24hDelivery(){
//        $this->load->model('delivery_model');
//        $this->load->model('delivery_comments_model');
//        $this->load->model('order_model');
//        $this->load->model('showcart_model');
//        $this->load->model('product_model');
//        $this->load->model('shop_model');
//
//        $list_delivery                  =   $this->delivery_model->cron24hDelivery();
//        $status_id                      =   "04";
//        foreach($list_delivery as $vals){
//
//            if($vals->type_id == "1"){
//                //update order va tao don hang moi cho khach hang
//                $where['client_code_new']   = $this->_thanhtoan($vals->order_id,$vals->order_saler);
//            } else if($vals->type_id == "2"){
//                //update order status hoan tien
//                $this->order_model->updateOrderCode($vals->order_clientCode,"06",$vals->order_saler,$vals->order_id);
//
//                $_data['shop_info']  =   $this->shop_model->get('sho_name,sho_email','sho_user = '.$vals->order_saler);
//                if($_delivery[0]->email && $_data['shop_info']->sho_email){
//                    $_data['content']       =   $this->input->post('content');
//                    $_data['delivery_id']   =   $_delivery[0]->order_id;
//                    $_data['order_info']    =   $this->order_model->get('order_token','id = '.$_delivery[0]->order_id);
//                    $content_email          =   $this->load->view('home/account/showcart/email', $_data, true);
//                    $this->sendEmail($vals->email,$_data['shop_info']->sho_email,$content_email);
//                }
//
//            }
//
//            $where['status_id']             =       $status_id;
//            $where['lastupdated']           =       date("Y-m-d H:i:s",time());
//            $comments = array(
//                'id_request'                =>      $vals->id,
//                'status_changedelivery'     =>      $status_id,
//                'user_id'                   =>      $vals->order_saler,
//                'content'                   =>      'Đơn hàng vượt quá 24h. Hệ thống Azibai auto xử lí',
//                'status_comment'            =>      "1",
//                'lastupdated'               =>      date("Y-m-d H:i:s",time())
//            );
//            $this->delivery_comments_model->add($comments);
//            $this->delivery_model->update($where,'id = '.$vals->id);
//            unset($comments);
//            unset($where);
//            unset($_data);
//            unset($content_email);
//            sleep(6);
//            echo 'Đơn hàng '.$vals->order_id.' Đã update status ';
//            if($vals->type_id == "1"){
//                echo 'trả hàng xong - đơn hàng mới đã tạo<br/>';
//            } else {
//                echo 'hoàn tiền<br/>';
//            }
//        }
//
//        //echo "Đơn hàng vượt quá 24h. Hệ thống Azibai auto xử lí THANH CONG";
//    }

//    private function _thanhtoan($order_id,$order_saler){
//            $order_cart             = $this->showcart_model->getDetailOrders(array('order_saler'=>$order_saler,'id'=>$order_id,'order_status'=>"05"));
//            $weight                 = 0;
//            foreach($order_cart as $vals){
//                $weight             +=  $vals->pro_weight * $vals->shc_quantity;
//                $products[]         =   array('id'=>$vals->pro_id,'shc_quantity'=>$vals->shc_quantity,'pro_instock'=>$vals->pro_instock,'pro_buy'=>$vals->pro_buy);
//            }
//
//            $data['ClientOrderCode']      =   time() . '_' . rand(100, 9999);
//            $data['SenderName']           =   $order_cart[0]->sho_name;
//            $data['SenderPhone']          =   $order_cart[0]->sho_mobile;
//            $data['PickAddress']          =   ($order_cart[0]->sho_kho_address)?$order_cart[0]->sho_kho_address:$order_cart[0]->sho_address;
//            $data['PickDistrictCode']     =   ($order_cart[0]->sho_kho_district)?$order_cart[0]->sho_kho_district:$order_cart[0]->sho_district;
//            $data['RecipientName']        =   $order_cart[0]->ord_sname;
//            $data['RecipientPhone']       =   $order_cart[0]->ord_smobile;
//            $data['DeliveryAddress']      =   $order_cart[0]->ord_saddress;
//            $data['DeliveryDistrictCode'] =   $order_cart[0]->ord_district;
//            $data['CODAmount']            =   0;
//            $data['ContentNote']          =   "Xac nhan don hang - ClientCode = ".$order_cart[0]->order_code;
//            $data['ServiceID']            =   $order_cart[0]->order_serviceID;
//            $data['Weight']               =   $weight;
//            $data['Length']               =   0;
//            $data['Width']                =   0;
//            $data['Height']               =   0;
//
//            try {
//                $return = $this->CreateShippingOrder($data);
//
//                if($return['code'] == 1){
//                    if($order_cart[0]->shipping_fee != $return['msg']['TotalFee']){
//                        $logaction = "Phí vận chuyển trả về từ GIAO HÀNG NHANH ko khớp";
//                    } else {
//                        $logaction = "Xác nhận đơn hàng thành công";
//                        $this->order_model->updateOrderCode($return['msg']['OrderCode'],'02',$order_saler,$order_id);
//
//                        if($delivery){
//                            foreach($products as $values){
//                                if($values['pro_buy'] > 0 || $values['pro_instock'] > 0){
//                                    $this->product_model->updateProBuyInstock($values);
//                                }
//                            }
//                        }
//
//                        if($order_cart[0]->ord_semail){
//                            $this->load->model("shop_mail_model");
//                            $this->shop_mail_model->sendingConfirmOrderEmailForCustomer($order_cart[0],$order_cart[0],$order_cart);
//                        }
//
//                    }
//                } else {
//                    $logaction = "Xác nhận đơn hàng thất bại ".$return['msg'];
//                }
//                $this->load->model('ghnapilog_model');
//                $log                =   new stdClass();
//                $log->OrderCode     =   $return['msg']['OrderCode'];
//                $log->TotalFee      =   $return['msg']['TotalFee'];
//                $log->owner         =   $order_saler;
//                $log->logaction     =   $logaction;
//                $log->lastupdated   =   date('Y-m-d H:i:s',time());
//                $this->ghnapilog_model->create($log);//log giao dich
//                return $return['msg']['OrderCode'];
//            } catch (Exception $e) {
//                die("Loi Api GHN");
//            }
//            unset($order_cart);
//            unset($data);
//
//    }
//
//    private function CreateShippingOrder($order){
//        $this->load->library('RestApiClient');
//        $this->RestApiClient = new RestApiClient();
//
//        $serviceClient  = $this->RestApiClient->connectGHN();
//        $sessionToken   = $serviceClient->SignIn();
//        $serviceClient->SignOut();
//        $arrProduct     =   array();
//        //https://testapipds.ghn.vn:9999/UI/API/GetAccountFortest
//        if ($sessionToken){
//            $responseCreateShippingOrder = $serviceClient->CreateShippingOrder($order);
//            //print_r($responseCreateShippingOrder);exit;
//            if($responseCreateShippingOrder['ErrorMessage'] == ''){
//                return array(
//                    'code'  => '1',
//                    'msg'   =>  $responseCreateShippingOrder
//                );
//            } else {
//                return array(
//                    'code'  => '-1',
//                    'msg'   =>  $responseCreateShippingOrder['ErrorMessage']
//                );
//            }
//        } else {
//           print_r('Client and Password are incorrect - Liên hệ Admin');exit;
//        }
//
//    }


    private function sendEmail($to, $from, $body ,$attachment='' ,$from_name="Azibai.com", $subject="Thông báo khiếu nại sản phẩm"){
        $this->load->model('shop_mail_model');
        $this->load->library('email');
        $config['useragent'] = $this->lang->line('useragen_mail_detail');
        $config['mailtype'] = 'html';
        $this->email->initialize($config);
        require_once($_SERVER['DOCUMENT_ROOT'] . folderWeb . '/PHPMailer/class.phpmailer.php');
        require_once($_SERVER['DOCUMENT_ROOT'] . folderWeb . '/PHPMailer/class.pop3.php');
        return $this->shop_mail_model->smtpmailer($to, $from, $from_name, $subject, $body,$attachment);
    }

    function calulate_money_store_by_week_custom($c_start,$c_end){
        //$this->revenue_shop_category("01");
        $this->revenue_shop_category_custom_not_check("02",$c_start,$c_end);
        $this->revenue_shop_category_custom_not_check("02_no_member",$c_start,$c_end);
        //$this->revenue_shop_category("04");
        $this->revenue_shop_category_custom_not_check("05_affiliate",$c_start,$c_end);
        $this->revenue_shop_category_custom_not_check("05",$c_start,$c_end);
    }

    // tinh tien cho gian hang theo tuan, da tru phi tra cho Azibai
    public function calulate_money_store_by_week(){
        //$this->revenue_shop_category("01");
        $this->revenue_shop_category("02");
        $this->revenue_shop_category("02_no_member");
        //$this->revenue_shop_category("04");
        $this->revenue_shop_category("05_affiliate");
        $this->revenue_shop_category("05");
    }

    public function find_cat_parent($catid){
        $this->load->model('category_model');
        $catidObj = $this->category_model->get('parent_id, cat_level, b2b_em_fee, b2b_fee, b2c_fee, b2c_af_fee','cat_id = '.$catid);

        if($catidObj->cat_level == 1){
           return $catidObj;
        }
        if($catidObj->cat_level == 2){
            $catidObjLevel1 = $this->category_model->get('parent_id, cat_level, b2b_em_fee, b2b_fee, b2c_fee, b2c_af_fee','cat_id = '.$catidObj->parent_id);
            return $catidObjLevel1;

        }

        if($catidObj->cat_level == 3){
            $catidObjLevel2 = $this->category_model->get('parent_id, cat_level, b2b_em_fee, b2b_fee, b2c_fee, b2c_af_fee','cat_id = '.$catidObj->parent_id);
            $catidObjLevel2_level1 = $this->category_model->get('parent_id, cat_level, b2b_em_fee, b2b_fee, b2c_fee, b2c_af_fee','cat_id = '.$catidObjLevel2->parent_id);
            return $catidObjLevel2_level1;
        }

        if($catidObj->cat_level == 4) {
            $catidObjLevel3 = $this->category_model->get('parent_id, cat_level, b2b_em_fee, b2b_fee, b2c_fee, b2c_af_fee', 'cat_id = ' . $catidObj->parent_id);
            $catidObjLevel3_level2 = $this->category_model->get('parent_id, cat_level, b2b_em_fee, b2b_fee, b2c_fee, b2c_af_fee', 'cat_id = ' . $catidObjLevel3->parent_id);
            $catidObjLevel3_level1 = $this->category_model->get('parent_id, cat_level, b2b_em_fee, b2b_fee, b2c_fee, b2c_af_fee', 'cat_id = ' . $catidObjLevel3_level2->parent_id);
            return $catidObjLevel3_level1;
        }
    }

    function get_list_category_shopper($shopid,$type,$week= false,$c_start="",$c_end=""){
        $this->load->model('showcart_model');
        $arr_start_end_date = $this->get_start_end_date();
        $start = $arr_start_end_date[0];
        
        $end = $arr_start_end_date[1];
        if($week){
            $end = strtotime("now");
            $start = strtotime("-1 week");
        }


        if($c_start != "" && $c_end != ""){
            $end = $c_end;
            $start = $c_start;
        }
        // shc_saler_store_type = 1 la mua si
        $where = "";
        switch ($type) {
            case "01":
                $where .= "shc_buyer = $shopid AND shc_buyer_group = 3 AND shc_saler_store_type = 1";
                break;
            case "02":
                $where .=  "shc_saler = $shopid AND shc_buyer_group = 3 AND shc_saler_store_type = 1";
                break;
            case "02_no_member":
                $where .=  "shc_saler = $shopid AND shc_saler_store_type = 1 AND (shc_buyer_group = 1 OR shc_buyer_group = 2 OR shc_buyer_group = 0)";
                break;
            case "04":
                $where .=  "af_id = $shopid AND (shc_buyer_group = 1 OR shc_buyer_group = 2 OR shc_buyer_group = 0) AND shc_saler_store_type = 0";
                break;
            case "05_affiliate":
                $where .=  "shc_saler = $shopid AND (shc_buyer_group = 1 OR shc_buyer_group = 2 OR shc_buyer_group = 0) AND af_id > 0 AND shc_saler_store_type = 0";
                break;
            case "05":
                $where .=  "shc_saler = $shopid AND (shc_buyer_group = 1 OR shc_buyer_group = 2 OR shc_buyer_group = 0) AND af_id = 0 AND shc_saler_store_type = 0";
                break;
        }
        $where .= " AND shc_status = '98' AND shc_change_status_date >= ".$start. " AND shc_change_status_date <= ".$end;
        $listCat = $this->showcart_model->fetch("tbtt_showcart.pro_category,tbtt_category.b2b_em_fee,tbtt_category.b2b_fee,tbtt_category.b2c_fee,tbtt_category.b2c_af_fee", $where,1);

        foreach ($listCat as $key => $item ){
            $Cat = $this->find_cat_parent($item->pro_category);
            $listCat[$key]->b2b_em_fee = $Cat->b2b_em_fee;
            $listCat[$key]->b2b_fee = $Cat->b2b_fee;
            $listCat[$key]->b2c_fee = $Cat->b2c_fee;
            $listCat[$key]->b2c_af_fee = $Cat->b2c_af_fee;
        }
        return $listCat;
    }

    function checkExistRevenueStoreByTypeWeek($type,$type2 = 0){
        $c_month_year = $this->month_year;
        if($type2 == 1){
            $str_type2 = "rsc_type2 = 1 AND ";
        }else{
            $str_type2 = '';
        }
        $this->load->model('revenue_store_category_model');
        $revenueToday = $this->revenue_store_category_model->fetch_weekly($select = "*", $where = $str_type2."rsc_type = '".$type."'  AND rsc_created_month_year = '".$c_month_year."'", $order = "rsc_id", $by = "DESC", $start = 0, $limit = 1);
        if(count($revenueToday) == 1){
            return true;
        }
        return false;
    }

    // revenue shopper by category - wholesale sell
    function revenue_shop_by_category($shopid, $catid, $type, $week = false,$c_start = "",$c_end = ""){
        $this->load->model('showcart_model');
        $arr_start_end_date = $this->get_start_end_date();
        $start = $arr_start_end_date[0];
        $end = $arr_start_end_date[1];
        if($week){
            $end = strtotime("now");
            $start = strtotime("-1 week");
        }

        if($c_start != "" && $c_end != ""){
            $end = $c_end;
            $start = $c_start;
        }
        $where = "pro_category = ".$catid." " ;
        // shc_saler_store_type : 1 ( sỉ ) , 0 (lẻ);
        // shc_buyer_group :0 (không đăng nhập), 1 ( user ), 2 ( affiliate ), 3 (gian hàng);

        switch ($type) {
            case "01":
                $where .= "AND shc_buyer = ".$shopid." AND shc_buyer_group = 3 AND shc_saler_store_type = 1";
                break;
            case "02":
                $where .=  "AND shc_saler = ".$shopid." AND shc_buyer_group = 3 AND shc_saler_store_type = 1";
                break;
            case "02_no_member": 
                $where .=  "AND shc_saler = ".$shopid." AND (shc_buyer_group = 1 OR shc_buyer_group = 2 OR shc_buyer_group = 0) AND shc_saler_store_type = 1";
                break;
            case "04":
                $where .=  "AND af_id = ".$shopid." AND (shc_buyer_group = 1 OR shc_buyer_group = 2 OR shc_buyer_group = 0) AND shc_saler_store_type = 0";
                break;
            case "05_affiliate":
                $where .=  "AND shc_saler = ".$shopid." AND (shc_buyer_group = 1 OR shc_buyer_group = 2 OR shc_buyer_group = 0) AND shc_saler_store_type = 0 AND af_id > 0";
                break;
            case "05":
                $where .=  "AND shc_saler = ".$shopid." AND (shc_buyer_group = 1 OR shc_buyer_group = 2 OR shc_buyer_group = 0) AND shc_saler_store_type = 0 AND  af_id = 0 ";
                break;
        }
        $where .= " AND shc_status = '98' AND shc_change_status_date >= ".$start. " AND shc_change_status_date <= ".$end;
        $revenueToday = $this->showcart_model->get("sum(shc_total) as totalRevenue", $where);

        if($revenueToday->totalRevenue > 0){
            return $revenueToday->totalRevenue;
        }
        return 0;
    }

    function revenue_shop_category($type){
        $checkExistRevenueStoreByTypeWeek = true;
        switch ($type) {
            case "01":
                $checkExistRevenueStoreByTypeWeek = $this->checkExistRevenueStoreByTypeWeek('01');
                break;
            case "02":
                $checkExistRevenueStoreByTypeWeek = $this->checkExistRevenueStoreByTypeWeek('02');
                break;
            case "02_no_member":
                $checkExistRevenueStoreByTypeWeek = $this->checkExistRevenueStoreByTypeWeek('02');
                break;
            case "04":
                $checkExistRevenueStoreByTypeWeek = $this->checkExistRevenueStoreByTypeWeek('04');
                break;
            case "05_affiliate":
                $checkExistRevenueStoreByTypeWeek = $this->checkExistRevenueStoreByTypeWeek('05',1);
                break;
            case "05":
                $checkExistRevenueStoreByTypeWeek = $this->checkExistRevenueStoreByTypeWeek('05');
                break;
        }
        if(!$checkExistRevenueStoreByTypeWeek){
            $this->load->model('revenue_store_category_model');
            switch ($type) {
                case "01":
                case "02":
                case "02_no_member":
                case "05":
                case "05_affiliate":
                    $listShopper = $this->get_all_shopper();
                    break;
                case "04":
                    $listShopper = $this->get_all_affiliate();
                    break;
            }
            $listCat = array();
            foreach($listShopper as $shopper){
                if(isset($listCat)){
                    reset($listCat);
                }
                $listCat = $this->get_list_category_shopper($shopper->use_id,$type,true);
                if(count($listCat) > 0){
                    foreach($listCat as $cat){
                        $revenue = $this->revenue_shop_by_category($shopper->use_id, $cat->pro_category,$type,true);
                        if( $revenue > 0){
                            switch ($type) {
                                case "01":
                                    $dataAdd = array(
                                        'rsc_shop_id' => $shopper->use_id,
                                        'rsc_parent_id' => $shopper->parent_id,
                                        'rsc_category_id' => $cat->pro_category,
                                        'rsc_revenue' => $revenue,
                                        'rsc_percent' => $cat->b2b_em_fee,
                                        'rsc_profit' => $revenue * ($cat->b2b_em_fee/100),
                                        'rsc_type' => '01',
                                        'rsc_description' => 'Hoa hồng mua sỉ',
                                        'rsc_created_date' => time(),
                                        'rsc_created_date_str' => date("d-m-Y",time()),
                                        'rsc_created_month_year' =>  $this->month_year
                                    );
                                    break;
                                case "02":
                                    $dataAdd = array(
                                        'rsc_shop_id' => $shopper->use_id,
                                        'rsc_parent_id' => $shopper->parent_id,
                                        'rsc_category_id' => $cat->pro_category,
                                        'rsc_revenue' => $revenue,
                                        'rsc_percent' => $cat->b2b_em_fee,
                                        'rsc_profit' => $revenue * ($cat->b2b_em_fee/100),
                                        'rsc_type' => '02',
                                        'rsc_type2' => 1,
                                        'rsc_description' => 'Hoa hồng bán sỉ thông qua thành viên gian hàng Azibai',
                                        'rsc_created_date' => time(),
                                        'rsc_created_date_str' => date("d-m-Y",time()),
                                        'rsc_created_month_year' =>  $this->month_year
                                    );
                                    break;
                                case "02_no_member":
                                    $dataAdd = array(
                                        'rsc_shop_id' => $shopper->use_id,
                                        'rsc_parent_id' => $shopper->parent_id,
                                        'rsc_category_id' => $cat->pro_category,
                                        'rsc_revenue' => $revenue,
                                        'rsc_percent' => $cat->b2b_fee,
                                        'rsc_profit' => $revenue * ($cat->b2b_fee/100),
                                        'rsc_type' => '02',
                                        'rsc_type2' => 0,
                                        'rsc_description' => 'Hoa hồng bán sỉ không qua thành viên gian hàng Azibai',
                                        'rsc_created_date' => time(),
                                        'rsc_created_date_str' => date("d-m-Y",time()),
                                        'rsc_created_month_year' =>  $this->month_year
                                    );
                                    break;
                                case "04":
                                    $dataAdd = array(
                                        'rsc_shop_id' => $shopper->use_id,
                                        'rsc_parent_id' => $shopper->parent_id,
                                        'rsc_category_id' => $cat->pro_category,
                                        'rsc_revenue' => $revenue,
                                        'rsc_percent' => $cat->b2c_fee,
                                        'rsc_profit' => $revenue * ($cat->b2c_fee/100),
                                        'rsc_type' => '04',
                                        'rsc_description' => 'Hoa hồng mua lẻ thông qua Cộng tác viên online',
                                        'rsc_created_date' => time(),
                                        'rsc_created_date_str' => date("d-m-Y",time()),
                                        'rsc_created_month_year' =>  $this->month_year
                                    );
                                    break;
                                case "05_affiliate":
                                    $dataAdd = array(
                                        'rsc_shop_id' => $shopper->use_id,
                                        'rsc_parent_id' => $shopper->parent_id,
                                        'rsc_category_id' => $cat->pro_category,
                                        'rsc_revenue' => $revenue,
                                        'rsc_percent' => $cat->b2c_af_fee,
                                        'rsc_profit' => $revenue * ($cat->b2c_af_fee/100),
                                        'rsc_type' => '05',
                                        'rsc_type2' => 1,
                                        'rsc_description' => 'Hoa hồng bán lẻ có Cộng tác viên online',
                                        'rsc_created_date' => time(),
                                        'rsc_created_date_str' => date("d-m-Y",time()),
                                        'rsc_created_month_year' =>  $this->month_year
                                    );
                                    break;
                                case "05":
                                    $dataAdd = array(
                                        'rsc_shop_id' => $shopper->use_id,
                                        'rsc_parent_id' => $shopper->parent_id,
                                        'rsc_category_id' => $cat->pro_category,
                                        'rsc_revenue' => $revenue,
                                        'rsc_percent' => $cat->b2c_fee,
                                        'rsc_profit' => $revenue * ($cat->b2c_fee/100),
                                        'rsc_type' => '05',
                                        'rsc_type2' => 0,
                                        'rsc_description' => 'Hoa hồng bán lẻ không có Cộng tác viên online',
                                        'rsc_created_date' => time(),
                                        'rsc_created_date_str' => date("d-m-Y",time()),
                                        'rsc_created_month_year' =>  $this->month_year
                                    );
                                    break;
                            }
                            $revenueCategory = $this->revenue_store_category_model->add_weekly($dataAdd);
                        }

                    }
                }
            }
        }
    }

    function revenue_shop_category_custom_not_check($type,$c_start = "", $c_end=""){
        
        $this->load->model('revenue_store_category_model');
        switch ($type) {
            case "01":
            case "02":
            case "02_no_member":
            case "05":
            case "05_affiliate":
                $listShopper = $this->get_all_shopper();
                break;
            case "04":
                $listShopper = $this->get_all_affiliate();
                break;
        }
            
        $listCat = array();
        foreach($listShopper as $shopper){
            if(isset($listCat)){
                reset($listCat);
            }
            $listCat = $this->get_list_category_shopper($shopper->use_id,$type,true,$c_start,$c_end);

            if(count($listCat) > 0){
                foreach($listCat as $cat){

                    $revenue = $this->revenue_shop_by_category($shopper->use_id, $cat->pro_category,$type,true,$c_start,$c_end);

                    if( $revenue > 0){
                        switch ($type) {
                            case "01":
                                $dataAdd = array(
                                    'rsc_shop_id' => $shopper->use_id,
                                    'rsc_parent_id' => $shopper->parent_id,
                                    'rsc_category_id' => $cat->pro_category,
                                    'rsc_revenue' => $revenue,
                                    'rsc_percent' => $cat->b2b_em_fee,
                                    'rsc_profit' => $revenue * ($cat->b2b_em_fee/100),
                                    'rsc_type' => '01',
                                    'rsc_description' => 'Hoa hồng mua sỉ',
                                    'rsc_created_date' => $c_end,
                                    'rsc_created_date_str' => date("d-m-Y",$c_end),
                                    'rsc_created_month_year' =>  date('m-Y',$c_end)
                                );
                                break;
                            case "02":
                                $dataAdd = array(
                                    'rsc_shop_id' => $shopper->use_id,
                                    'rsc_parent_id' => $shopper->parent_id,
                                    'rsc_category_id' => $cat->pro_category,
                                    'rsc_revenue' => $revenue,
                                    'rsc_percent' => $cat->b2b_em_fee,
                                    'rsc_profit' => $revenue * ($cat->b2b_em_fee/100),
                                    'rsc_type' => '02',
                                    'rsc_type2' => 1,
                                    'rsc_description' => 'Hoa hồng bán sỉ thông qua thành viên gian hàng Azibai',
                                    'rsc_created_date' => $c_end,
                                    'rsc_created_date_str' => date("d-m-Y",$c_end),
                                    'rsc_created_month_year' =>  date('m-Y',$c_end)
                                );
                                break;
                            case "02_no_member":
                                $dataAdd = array(
                                    'rsc_shop_id' => $shopper->use_id,
                                    'rsc_parent_id' => $shopper->parent_id,
                                    'rsc_category_id' => $cat->pro_category,
                                    'rsc_revenue' => $revenue,
                                    'rsc_percent' => $cat->b2b_fee,
                                    'rsc_profit' => $revenue * ($cat->b2b_fee/100),
                                    'rsc_type' => '02',
                                    'rsc_type2' => 0,
                                    'rsc_description' => 'Hoa hồng bán sỉ không qua thành viên gian hàng Azibai',
                                    'rsc_created_date' => $c_end,
                                    'rsc_created_date_str' => date("d-m-Y",$c_end),
                                    'rsc_created_month_year' =>  date('m-Y',$c_end)
                                );
                                break;
                            case "04":
                                $dataAdd = array(
                                    'rsc_shop_id' => $shopper->use_id,
                                    'rsc_parent_id' => $shopper->parent_id,
                                    'rsc_category_id' => $cat->pro_category,
                                    'rsc_revenue' => $revenue,
                                    'rsc_percent' => $cat->b2c_fee,
                                    'rsc_profit' => $revenue * ($cat->b2c_fee/100),
                                    'rsc_type' => '04',
                                    'rsc_description' => 'Hoa hồng mua lẻ thông qua Cộng tác viên online',
                                    'rsc_created_date' => $c_end,
                                    'rsc_created_date_str' => date("d-m-Y",$c_end),
                                    'rsc_created_month_year' =>  date('m-Y',$c_end)
                                );
                                break;
                            case "05_affiliate":
                                $dataAdd = array(
                                    'rsc_shop_id' => $shopper->use_id,
                                    'rsc_parent_id' => $shopper->parent_id,
                                    'rsc_category_id' => $cat->pro_category,
                                    'rsc_revenue' => $revenue,
                                    'rsc_percent' => $cat->b2c_af_fee,
                                    'rsc_profit' => $revenue * ($cat->b2c_af_fee/100),
                                    'rsc_type' => '05',
                                    'rsc_type2' => 1,
                                    'rsc_description' => 'Hoa hồng bán lẻ có Cộng tác viên online',
                                    'rsc_created_date' => $c_end,
                                    'rsc_created_date_str' => date("d-m-Y",$c_end),
                                    'rsc_created_month_year' =>  date('m-Y',$c_end)
                                );
                                break;
                            case "05":
                                $dataAdd = array(
                                    'rsc_shop_id' => $shopper->use_id,
                                    'rsc_parent_id' => $shopper->parent_id,
                                    'rsc_category_id' => $cat->pro_category,
                                    'rsc_revenue' => $revenue,
                                    'rsc_percent' => $cat->b2c_fee,
                                    'rsc_profit' => $revenue * ($cat->b2c_fee/100),
                                    'rsc_type' => '05',
                                    'rsc_type2' => 0,
                                    'rsc_description' => 'Hoa hồng bán lẻ không có Cộng tác viên online',
                                    'rsc_created_date' => $c_end,
                                    'rsc_created_date_str' => date("d-m-Y",$c_end),
                                    'rsc_created_month_year' => date('m-Y',$c_end)
                                );
                                break;
                        }
                        $revenueCategory = $this->revenue_store_category_model->add_weekly($dataAdd);
                    }

                }
            }
        }        
    }

    /**
    *   Unactive user not use in current 6 month 
    *   By Bao Tran
    *   Date: 09/12/2017
    **/
    function disable_user_no_use_6_month(){
        //get list user       
        $this->load->model('user_model');
        $list_user = $this->user_model->get_list_user('*', 'use_status = 1');

        foreach ($list_user as $key) {           
            $time = time() - $key->use_lastest_login;
            $time_s = floor($time / 3600);            
            $id = $key->use_id;
            $where = 'use_id = '.(int)$id;

            if( $time_s > 4320){               
               $this->user_model->update(array('use_status'=>0), $where);               
            }
        }        
    }

    /*
    *   Remove session on table session daily at 00h00'
    *   By Bao Tran, 30/07/2018
    */
    function removeSessionDaily()
    {
        $this->db->empty_table('tbtt_session');
    }

    /**
    *   Calculate commission for bonus affiliate, monthly
    *   By Bao Tran
    *   Date: 12/09/2018
    **/

    public function calculate_commission_bonus_affiliate()
    {        
        $c_month = $this->month_year;
        //Check existed
        $this->load->model('account_model');
        $checkMoney = $this->account_model->fetch($select = "*", $where = "month_year ='".$c_month."' AND type = '09'", $order = "id", $by = "DESC", $start = 0, $limit = 1);

        if(count($checkMoney) == 0){            
            $arr_start_end_date = $this->get_start_end_date();
            $startMonth = $arr_start_end_date[0];
            $endMonth = $arr_start_end_date[1];

            $sql = 'SELECT `af_id`, `sho_user`, `superior_id` FROM `tbtt_commission_aff` WHERE `af_id` > 0 GROUP BY `af_id`';
            $this->db->cache_off();
            $query = $this->db->query($sql);
            $result = $query->result();
            $query->free_result();
            
            if ( $result ) {
                $this->load->model('showcart_model');                
                $this->load->model('commissionaffilite_model');                
                foreach ($result as $val) {
                    $qr = "SELECT SUM(s.`shc_total`) AS t FROM tbtt_showcart AS s WHERE s.`af_id` = ".$val->af_id." AND (s.`shc_saler` = ".$val->superior_id." OR s.`shc_saler` = ".$val->sho_user.") AND s.`shc_status` = '98' AND s.`shc_change_status_date` >= $startMonth AND s.`shc_change_status_date` <= $endMonth";
                    $this->db->cache_off();
                    $que = $this->db->query($qr);
                    $res = $que->result();
                    $que->free_result();

                    $total = $res->t > 0 ? $res->t : 0;

                    $comaff = $this->commissionaffilite_model->fetch_join('tbtt_commission_aff.*, tbtt_user.`use_group`, tbtt_user.`parent_id`', 'INNER', 'tbtt_user', 'tbtt_user.use_id = tbtt_commission_aff.af_id', '', '', '', '', '', '', 'tbtt_commission_aff.`af_id` = '. $val->af_id .' AND tbtt_commission_aff.`min` <= '.$total.' AND tbtt_commission_aff.`max` >= '.$total, '', '');
                    if (count($comaff) == 1) {
                        $dataMoney = array(
                            'user_id' => $val->af_id,
                            'group_id' => $comaff->use_group,
                            'parent_id' => $comaff->parent_id,
                            'amount' => $res->t * $comaff->percent,
                            'type' => '09',
                            'description' => 'Hoa hồng thưởng thêm cộng tác viên',
                            'created_date' => date("Y-m-d H:i:s"),
                            'month_year' => $this->month_year,
                            'status' => 0
                        );
                        $this->persional_money_by_type($dataMoney);

                        $subMoney = array(
                            'user_id' => $val->af_id,
                            'group_id' => $comaff->use_group,
                            'parent_id' => $comaff->parent_id,
                            'amount' => -1 * $res->t * $comaff->percent,
                            'type' => '09',
                            'description' => 'Trừ hoa hồng thưởng thêm cộng tác viên',
                            'created_date' => date("Y-m-d H:i:s"),
                            'month_year' => $this->month_year,
                            'status' => 0
                        );
                        $this->persional_money_by_type($subMoney);                    
                    }
                }
            }
        }         
    }

    /**
    *   Calculate commission for group trade
    *   By Bao Tran
    *   Date: 09/12/2017
    **/
    function calculate_commission_group_trade(){
        if(!$this->checkExistMoneyGroupTradeAdmin()){
            $this->load->model('showcart_model');
            $this->load->model('grouptrade_model');
            $arr_start_end_date = $this->get_start_end_date();
            $startMonth = $arr_start_end_date[0];
            $endMonth = $arr_start_end_date[1];
            // $q = "SELECT SUM(a.discount) AS amount, af_id, tbtt_user.use_id as user_id, tbtt_user.use_group as group_id, tbtt_user.parent_id FROM (SELECT af_id, CASE WHEN af_amt > 0 THEN af_amt * `shc_quantity` ELSE shc_total * CAST(af_rate AS DECIMAL (10, 5)) / 100 END AS discount FROM `tbtt_showcart` WHERE af_id > 0 AND shc_status = '98' AND shc_change_status_date >= $startMonth AND shc_change_status_date <= $endMonth) AS a INNER JOIN tbtt_user ON tbtt_user.use_id = a.af_id GROUP BY a.af_id";
            
            $q = "SELECT SUM(a.discount) AS amount, af_id, tbtt_user.use_id as user_id, tbtt_user.use_group as group_id, tbtt_user.parent_id FROM (SELECT af_id, CASE WHEN af_amt > 0 THEN af_amt * `shc_quantity` ELSE shc_total * CAST(af_rate AS DECIMAL (10, 5)) / 100 END AS discount FROM `tbtt_showcart` WHERE af_id > 0 AND shc_status = '98' AND shc_change_status_date >= $startMonth AND shc_change_status_date <= $endMonth) AS a INNER JOIN tbtt_user ON tbtt_user.use_id = a.af_id GROUP BY a.af_id";
            $query = $this->db->query($q);
            foreach ($query->result() as $user)
            {
                if($user->amount > 0){
                    $dataMoney = array(
                        'user_id' => $user->user_id,
                        'group_id' => $user->group_id,
                        'parent_id' => $user->parent_id,
                        'amount' => $user->amount,
                        'type' => '09',
                        'description' => 'Hoa hồng chủ nhóm thương mại',
                        'created_date' => date("Y-m-d H:i:s"),
                        'month_year' => $this->month_year,
                        'status' => 0
                    );
                    $this->persional_money_by_type($dataMoney);
                }
            }
        }        
    }

    function checkExistMoneyGroupTradeAdmin(){
        $c_month = $this->month_year;
        $this->load->model('account_model');
        $moneyToday = $this->account_model->fetch($select = "*", $where = "month_year = '".$c_month."' AND type = '09'", $order = "id", $by = "DESC", $start = 0, $limit = 1);

        if(count($moneyToday) == 1){
            return true;
        }
        return false;
    }
}
?>