<?php
#****************************************#
# * @Author: lehieu008                   #
# * @Email: lehieu008@gmail.com          #
# * @Website: http://www.iscvietnam.net  #
# * @Copyright: 2008 - 2009              #
#****************************************#
class Config extends CI_Controller
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
		$this->lang->load('admin/config');
	}
	
	function index()
	{
        #BEGIN: CHECK PERMISSION
		if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'config_view'))
		{
			show_error($this->lang->line('unallowed_use_permission'));
			die();
		}
		#END CHECK PERMISSION
		if(file_exists('system/application/config/setting.php') && @class_exists('Setting'))
		{
            $data['existFile'] = true;
            #BEGIN: Edit
            if(@is_writable('system/application/config/setting.php'))
            {
                $data['isWritable'] = true;
                $data['successEdit'] = false;
                if($this->session->flashdata('sessionSuccessEdit'))
				{
		            $data['successEdit'] = true;
				}
				if($this->input->post('isSubmit') && $this->input->post('isSubmit') == 'true')
				{
                    #BEGIN: CHECK PERMISSION
					if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'config_edit'))
					{
						show_error($this->lang->line('unallowed_use_permission'));
						die();
					}
					#END CHECK PERMISSION
                    $this->load->helper('file');
                    #BEGIN: Assign value post
                    $config = '<?php'."\n";
                    $config .= "if(!defined('BASEPATH'))exit('No direct script access allowed');"."\n";
                    $config .= '/**'."\n";
                    $config .= ' *Class Setting: Luu tat ca cac cau hinh'."\n";
                    $config .= '**/'."\n";
                    $config .= 'class Setting'."\n";
                    $config .= '{'."\n";
                    #Thong tin website
                    $config .= '#Thong tin website'."\n";
                    $config .= "const settingTitle = '".$this->filter->clear($this->input->post('site_config'))."';"."\n";
                    $config .= "const settingDescr = '".$this->filter->clear($this->input->post('descr_config'))."';"."\n";
                    $config .= "const settingKeyword = '".$this->filter->clear($this->input->post('keyword_config'))."';"."\n";
                    $config .= "const settingEmail_1 = '".$this->filter->clear($this->input->post('email1_config'))."';"."\n";
                    $config .= "const settingEmail_2 = '".$this->filter->clear($this->input->post('email2_config'))."';"."\n";
                    $config .= "const settingAddress_1 = '".$this->filter->clear($this->input->post('address1_config'))."';"."\n";
                    $config .= "const settingAddress_2 = '".$this->filter->clear($this->input->post('address2_config'))."';"."\n";
                    $config .= "const settingPhone = '".$this->filter->clear($this->input->post('phone_config'))."';"."\n";
                    $config .= "const settingMobile = '".$this->filter->clear($this->input->post('mobile_config'))."';"."\n";
                    $config .= "const settingYahoo_1 = '".$this->filter->clear($this->input->post('yahoo1_config'))."';"."\n";
                    $config .= "const settingYahoo_2 = '".$this->filter->clear($this->input->post('yahoo2_config'))."';"."\n";
                    $config .= "const settingSkype_1 = '".$this->filter->clear($this->input->post('skype1_config'))."';"."\n";
                    $config .= "const settingSkype_2 = '".$this->filter->clear($this->input->post('skype2_config'))."';"."\n";
                    #Cau hinh chung
                    $config .= '#Cau hinh chung'."\n";
                    $config .= "const settingTimePost = ".(int)$this->input->post('timepost_config').";"."\n";
                    $config .= "const settingLockAccount = ".(int)$this->input->post('timelock_config').";"."\n";
                    $config .= "const settingTimeSession = ".(int)$this->input->post('timesession_config').";"."\n";
                    $config .= "const settingTimeCache = ".(int)$this->input->post('timecache_config').";"."\n";
                    if($this->input->post('stopsite_config') == '1')
                    {
						$stopsite_config = 1;
                    }
					else
					{
						$stopsite_config = 0;
					}
                    $config .= "const settingStopSite = '".$stopsite_config."';"."\n";
                    if($this->input->post('active_config') == '1')
                    {
                        $active_config = 1;
                    }
                    else
                    {
						$active_config = 0;
                    }
                    $config .= "const settingActiveAccount = '".$active_config."';"."\n";
                    if($this->input->post('stopregis_config') == '1')
                    {
						$stopregis_config = 1;
                    }
                    else
                    {
                        $stopregis_config = 0;
                    }
                    $config .= "const settingStopRegister = '".$stopregis_config."';"."\n";
                    if($this->input->post('stopvip_config') == '1')
                    {
						$stopvip_config = 1;
                    }
                    else
                    {
						$stopvip_config = 0;
                    }
                    $config .= "const settingStopRegisterVip = '".$stopvip_config."';"."\n";
                    if($this->input->post('stopshop_config') == '1')
                    {
						$stopshop_config = 1;
                    }
                    else
                    {
						$stopshop_config = 0;
                    }
                    $config .= "const settingStopRegisterShop = '".$stopshop_config."';"."\n";
                    $config .= "const settingExchange = ".(int)$this->input->post('exchange_config').";"."\n";
					$config .= "const settingChiPhiUpTin = ".(int)$this->input->post('chiphi_uptin').";"."\n";
					
                    #Hien thi san pham
                    $config .= '#Hien thi san pham'."\n";
                    $config .= "const settingProductNew_Home = ".(int)$this->input->post('pro1_config').";"."\n";
                    $config .= "const settingProductReliable_Home = ".(int)$this->input->post('pro2_config').";"."\n";
                    $config .= "const settingProductNew_Category = ".(int)$this->input->post('pro3_config').";"."\n";
                    $config .= "const settingProductReliable_Category = ".(int)$this->input->post('pro4_config').";"."\n";
                    $config .= "const settingProductSaleoff = ".(int)$this->input->post('pro5_config').";"."\n";
                    $config .= "const settingProductNew_Top = ".(int)$this->input->post('pro6_config').";"."\n";
                    $config .= "const settingProductSaleoff_Top = ".(int)$this->input->post('pro7_config').";"."\n";
                    $config .= "const settingProductBuyest_Top = ".(int)$this->input->post('pro8_config').";"."\n";
                    $config .= "const settingProductUser = ".(int)$this->input->post('pro9_config').";"."\n";
                    $config .= "const settingProductCategory = ".(int)$this->input->post('pro10_config').";"."\n";
                    #Hien thi rao vat
                    $config .= '#Hien thi rao vat'."\n";
                    $config .= "const settingAdsNew_Home = ".(int)$this->input->post('ads1_config').";"."\n";
                    $config .= "const settingAdsReliable_Category = ".(int)$this->input->post('ads2_config').";"."\n";
                    $config .= "const settingAdsNew_Category = ".(int)$this->input->post('ads3_config').";"."\n";
                    $config .= "const settingAdsShop = ".(int)$this->input->post('ads4_config').";"."\n";
                    $config .= "const settingAdsReliable_Top = ".(int)$this->input->post('ads5_config').";"."\n";
                    $config .= "const settingAdsNew_Top = ".(int)$this->input->post('ads6_config').";"."\n";
                    $config .= "const settingAdsViewest_Top = ".(int)$this->input->post('ads7_config').";"."\n";
                    $config .= "const settingAdsShop_Top = ".(int)$this->input->post('ads8_config').";"."\n";
                    $config .= "const settingAdsUser = ".(int)$this->input->post('ads9_config').";"."\n";
                    $config .= "const settingAdsCategory = ".(int)$this->input->post('ads10_config').";"."\n";
                    #Hien thi tin tuyen dung, tim viec
                    $config .= '#Hien thi tin tuyen dung, tim viec'."\n";
                    $config .= "const settingJobInterest = ".(int)$this->input->post('job1_config').";"."\n";
                    $config .= "const settingJobNew = ".(int)$this->input->post('job2_config').";"."\n";
                    $config .= "const settingJob24Gio_J_Top = ".(int)$this->input->post('job3_config').";"."\n";
                    $config .= "const settingJob24Gio_E_Top = ".(int)$this->input->post('job4_config').";"."\n";
                    $config .= "const settingJobUser = ".(int)$this->input->post('job5_config').";"."\n";
                    $config .= "const settingJobField = ".(int)$this->input->post('job6_config').";"."\n";
                    #Hien thi cua hang
                    $config .= '#Hien thi cua hang'."\n";
                    $config .= "const settingShopInterest = ".(int)$this->input->post('shop1_config').";"."\n";
                    $config .= "const settingShopInterest_Category = ".(int)$this->input->post('shop2_config').";"."\n";
                    $config .= "const settingShopNew_Category = ".(int)$this->input->post('shop3_config').";"."\n";
                    $config .= "const settingShopSaleoff = ".(int)$this->input->post('shop4_config').";"."\n";
                    $config .= "const settingShopNew_Top = ".(int)$this->input->post('shop5_config').";"."\n";
                    $config .= "const settingShopSaleoff_Top = ".(int)$this->input->post('shop6_config').";"."\n";
                    $config .= "const settingShopProductest_Top = ".(int)$this->input->post('shop7_config').";"."\n";
                    #Hien thi shopping
                    $config .= '#Hien thi shopping'."\n";
                    $config .= "const settingShoppingInterest_Home = ".(int)$this->input->post('shopping1_config').";"."\n";
                    $config .= "const settingShoppingNew_Home = ".(int)$this->input->post('shopping2_config').";"."\n";
                    $config .= "const settingShoppingSaleoff_Home = ".(int)$this->input->post('shopping3_config').";"."\n";
                    $config .= "const settingShoppingNew_List = ".(int)$this->input->post('shopping4_config').";"."\n";
                    $config .= "const settingShoppingSaleoff_List = ".(int)$this->input->post('shopping5_config').";"."\n";
                    $config .= "const settingShoppingAdsNew = ".(int)$this->input->post('shopping6_config').";"."\n";
                    $config .= "const settingShoppingProductNew_Top = ".(int)$this->input->post('shopping7_config').";"."\n";
                    $config .= "const settingShoppingAdsNew_Top = ".(int)$this->input->post('shopping8_config').";"."\n";
                    $config .= "const settingShoppingSearch = ".(int)$this->input->post('shopping9_config').";"."\n";
                    #Hien thi tim kiem
                    $config .= '#Hien thi tim kiem'."\n";
                    $config .= "const settingSearchProduct = ".(int)$this->input->post('search1_config').";"."\n";
                    $config .= "const settingSearchAds = ".(int)$this->input->post('search2_config').";"."\n";
                    $config .= "const settingSearchJob = ".(int)$this->input->post('search3_config').";"."\n";
                    $config .= "const settingSearchShop = ".(int)$this->input->post('search4_config').";"."\n";
                    #Cau hinh hien thi khac
                    $config .= '#Cau hinh hien thi khac'."\n";
                    $config .= "const settingOtherAccount = ".(int)$this->input->post('other1_config').";"."\n";
                    $config .= "const settingOtherAdmin = ".(int)$this->input->post('other2_config').";"."\n";
                    $config .= "const settingOtherShowcart = ".(int)$this->input->post('other3_config').";"."\n";
                    $config .= '}';
                    #END Assign value post
                    if(write_file('system/application/config/setting.php', $config))
                    {
                        $this->session->set_flashdata('sessionSuccessEdit', 1);
                    }
                    redirect(base_url().'administ/system/config', 'location');
				}
            }
            else
            {
                $data['isWritable'] = false;
                $data['successEdit'] = false;
            }
            #END Edit
            #BEGIN: Assign value
            $data['site_config'] = settingTitle;
			$data['chiphi_uptin'] = settingChiPhiUpTin;
            $data['descr_config'] = settingDescr;
            $data['keyword_config'] = settingKeyword;
            $data['email1_config'] = settingEmail_1;
            $data['email2_config'] = settingEmail_2;
            $data['address1_config'] = settingAddress_1;
            $data['address2_config'] = settingAddress_2;
            $data['phone_config'] = settingPhone;
            $data['mobile_config'] = settingMobile;
            $data['yahoo1_config'] = settingYahoo_1;
            $data['yahoo2_config'] = settingYahoo_2;
            $data['skype1_config'] = settingSkype_1;
            $data['skype2_config'] = settingSkype_2;
            #Cau hinh chung
            $data['timepost_config'] = settingTimePost;
            $data['timelock_config'] = settingLockAccount;
            $data['timesession_config'] = settingTimeSession;
            $data['timecache_config'] = settingTimeCache;
            $data['stopsite_config'] = settingStopSite;
            $data['active_config'] = settingActiveAccount;
            $data['stopregis_config'] = settingStopRegister;
            $data['stopvip_config'] = settingStopRegisterVip;
            $data['stopshop_config'] = settingStopRegisterShop;
            $data['exchange_config'] = settingExchange;
            #Hien thi san pham
            $data['pro1_config'] = settingProductNew_Home;
            $data['pro2_config'] = settingProductReliable_Home;
            $data['pro3_config'] = settingProductNew_Category;
            $data['pro4_config'] = settingProductReliable_Category;
            $data['pro5_config'] = settingProductSaleoff;
            $data['pro6_config'] = settingProductNew_Top;
            $data['pro7_config'] = settingProductSaleoff_Top;
            $data['pro8_config'] = settingProductBuyest_Top;
            $data['pro9_config'] = settingProductUser;
            $data['pro10_config'] = settingProductCategory;
            #Hien thi rao vat
            $data['ads1_config'] = settingAdsNew_Home;
            $data['ads2_config'] = settingAdsReliable_Category;
            $data['ads3_config'] = settingAdsNew_Category;
            $data['ads4_config'] = settingAdsShop;
            $data['ads5_config'] = settingAdsReliable_Top;
            $data['ads6_config'] = settingAdsNew_Top;
            $data['ads7_config'] = settingAdsViewest_Top;
            $data['ads8_config'] = settingAdsShop_Top;
            $data['ads9_config'] = settingAdsUser;
            $data['ads10_config'] = settingAdsCategory;
            #Hien thi tin tuyen dung, tim viec
            $data['job1_config'] = settingJobInterest;
            $data['job2_config'] = settingJobNew;
            $data['job3_config'] = settingJob24Gio_J_Top;
            $data['job4_config'] = settingJob24Gio_E_Top;
            $data['job5_config'] = settingJobUser;
            $data['job6_config'] = settingJobField;
            #Hien thi cua hang
            $data['shop1_config'] = settingShopInterest;
            $data['shop2_config'] = settingShopInterest_Category;
            $data['shop3_config'] = settingShopNew_Category;
            $data['shop4_config'] = settingShopSaleoff;
            $data['shop5_config'] = settingShopNew_Top;
            $data['shop6_config'] = settingShopSaleoff_Top;
            $data['shop7_config'] = settingShopProductest_Top;
            #Hien thi site shopping
            $data['shopping1_config'] = settingShoppingInterest_Home;
            $data['shopping2_config'] = settingShoppingNew_Home;
            $data['shopping3_config'] = settingShoppingSaleoff_Home;
            $data['shopping4_config'] = settingShoppingNew_List;
            $data['shopping5_config'] = settingShoppingSaleoff_List;
            $data['shopping6_config'] = settingShoppingAdsNew;
            $data['shopping7_config'] = settingShoppingProductNew_Top;
            $data['shopping8_config'] = settingShoppingAdsNew_Top;
            $data['shopping9_config'] = settingShoppingSearch;
			#Hien thi tim kiem
            $data['search1_config'] = settingSearchProduct;
            $data['search2_config'] = settingSearchAds;
            $data['search3_config'] = settingSearchJob;
            $data['search4_config'] = settingSearchShop;
            #Cau hinh hien thi khac
            $data['other1_config'] = settingOtherAccount;
            $data['other2_config'] = settingOtherAdmin;
            $data['other3_config'] = settingOtherShowcart;
            #END Assign value
		}
		else
		{
			$data['existFile'] = false;
		}
		#Load view
		$this->load->view('admin/config/defaults', $data);
	}
	
	function sohapay()
	{
        #BEGIN: CHECK PERMISSION
		if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'config_view'))
		{
			show_error($this->lang->line('unallowed_use_permission'));
			die();
		}
		#END CHECK PERMISSION
		if($this->input->post('isSubmit')=="1"){
			$query	=	"UPDATE tbtt_sohapay set merchant_site_code = '".$this->input->post('merchant_site_code')."', secure_secret = '".$this->input->post('secure_secret')."' where id = 1";
			$this->db->query($query);
			print "<script>
			alert('Cập nhật thông tin Sohapay thành công!')
			</script>";
		}
		
		$query	=	"SELECT * FROM tbtt_sohapay WHERE id=1";
		$tempresult=$this->db->query($query); 
		$result=$tempresult->result();
		
		$data['sohapay']=$result;
		#Load view
		$this->load->view('admin/config/sohapay',$data);
	}
	
	function info()
	{
        #BEGIN: CHECK PERMISSION
		if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'config_view'))
		{
			show_error($this->lang->line('unallowed_use_permission'));
			die();
		}
		#END CHECK PERMISSION
		#Load view
		$this->load->view('admin/config/info');
	}

	function solution_commission_config(){
		$this->load->model('solution_commission_model');		
		$listConfig = $this->solution_commission_model->fetch("*","","id","ASC");
		$data['listConfig'] = $listConfig;       
		$this->load->view('admin/config/solution_commission', $data);
	}

    function commissionRate(){
        $this->load->model('commission_config_model');
        $listConfig = $this->commission_config_model->fetch("*","","id","ASC");
        $data['listConfig'] = $listConfig;
        $this->load->view('admin/config/commission_config', $data);
    }

    function configData(){
        $this->load->model('config_model');
        $listConfig = $this->config_model->fetch("*","","id","ASC");
        $data['listConfig'] = $listConfig;
        $this->load->view('admin/config/default_config', $data);
    }

	function payment() {
		#BEGIN: CHECK PERMISSION
		if (!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'config_view')) {
			show_error($this->lang->line('unallowed_use_permission'));
			die();
		}
		#END CHECK PERMISSION
		$this->load->model('payment_model');
		
		if($this->input->post('info_nganluong')) {
			$data = array(
				'info_nganluong' => $this->input->post('info_nganluong'),
				'info_cod' => $this->input->post('info_cod'),
				'info_bank' => $this->input->post('info_bank')
			);
			$this->payment_model->update($data, array('id_user' => PAYMENT_USER_ID));
		}
		
		
		$data = array(
			'payment' => $this->payment_model->get('*', array('id_user' => PAYMENT_USER_ID))
		);
		
		#Load view
		$this->load->view('admin/config/payment', $data);
	}

	function solution_commission_config_ajax(){
		$this->load->model('solution_commission_model');
		$id = $this->input->post('id');
		$commission = $this->input->post('commission');
		$commission_level1 = $this->input->post('commission_level1');
		$commission_level2 = $this->input->post('commission_level2');
		$commission_level3 = $this->input->post('commission_level3');
		$affiliate_number_level1 = $this->input->post('affiliate_number_level1');
		$affiliate_number_level2 = $this->input->post('affiliate_number_level2');
		$affiliate_number_level3 = $this->input->post('affiliate_number_level3');
		
		if($id > 0) {
			$data = array(
				'commission' => $commission,
				'commission_level1' => $commission_level1,
				'commission_level2' => $commission_level2,
				'commission_level3' => $commission_level3,
				'affiliate_number_level1' => $affiliate_number_level1,
				'affiliate_number_level2' => $affiliate_number_level2,
				'affiliate_number_level3' => $affiliate_number_level3
			);
			$this->solution_commission_model->update($data, array('id' => $id ));
			echo "1";
			exit();
		}
		
	}

    function ajaxCommissionRate(){
        $this->load->model('commission_config_model');
        $id = $this->input->post('id');
        $rate = $this->input->post('rate');

        if($id > 0) {
            $data = array(
                'commission_rate' => $rate

            );
            $this->commission_config_model->update($data, array('id' => $id ));
            echo "1";
            exit();
        }

    }

    function ajaxConfig(){
        $this->load->model('config_model');
        $id = $this->input->post('id');
        $field_value = $this->input->post('field_value');

        if($id > 0) {
            $data = array(
                'field_value' => $field_value

            );
            $this->config_model->update($data, array('id' => $id ));
            echo "1";
            exit();
        }

    }
    
}