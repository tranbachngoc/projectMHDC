<?php
#****************************************#
# * @Author: lehieu008                   #
# * @Email: lehieu008@gmail.com          #
# * @Website: http://www.iscvietnam.net  #
# * @Copyright: 2008 - 2009              #
#****************************************#
class Newsletter extends CI_Controller
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
		
		#Load model
		$this->load->model('newsletter_model');
	}
	
	function index()
	{
        #BEGIN: Delete
		if($this->input->post('checkone') && is_array($this->input->post('checkone')) && count($this->input->post('checkone')) > 0)
		{
           
			#END CHECK PERMISSION
			$this->newsletter_model->delete($this->input->post('checkone'), "new_id");
			redirect(base_url().trim(uri_string(), '/'), 'location');
		}
		#END Delete
		 $isPaging = $this->input->get_post('excel', 0) == 1 ? FALSE : TRUE;
		//$this->newsletter_model->pagination($isPaging);
		$filter['where']['new_status'] = 1;
		$data['newsletter'] = $this->newsletter_model->getLits($filter);
		//print_r($data['newsletter']);die;	
		if ($isPaging == FALSE) {
            $this->_excel($data['newsletter']);
            exit();
        }
		/*if ($isPaging == FALSE) {
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=export.xls");
            header("Pragma: no-cache");
            header("Expires: 0");
            echo $this->_excel($data['newsletter']);
            exit();
        }*/
        #Define url for $getVar
		$action = array('search', 'keyword', 'filter', 'key', 'sort', 'by', 'page', 'status', 'id');
		$getVar = $this->uri->uri_to_assoc(3, $action);
		#BEGIN: Search & Filter
		$where = '';
		$sort = 'new_id';
		$by = 'DESC';
		$sortUrl = '';
		$pageSort = '';
		$pageUrl = '';
		$keyword = '';
		#If search
		if($getVar['search'] != FALSE && trim($getVar['search']) != '' && $getVar['keyword'] != FALSE && trim($getVar['keyword']) != '')
		{
            $keyword = $getVar['keyword'];
			switch(strtolower($getVar['search']))
			{
				case 'email':
				    $sortUrl .= '/search/email/keyword/'.$getVar['keyword'];
				    $pageUrl .= '/search/email/keyword/'.$getVar['keyword'];
				    $where .= "new_email LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
				    break;
                
			}
		}
		#If filter
		elseif($getVar['filter'] != FALSE && trim($getVar['filter']) != '' && $getVar['key'] != FALSE && trim($getVar['key']) != '')
		{
			switch(strtolower($getVar['filter']))
			{
				case 'datecontact':
				    $sortUrl .= '/filter/datecontact/key/'.$getVar['key'];
				    $pageUrl .= '/filter/datecontact/key/'.$getVar['key'];
				    $where .= "new_created_date = ".(float)$getVar['key'];
				    break;
                case 'active':
				    $sortUrl .= '/filter/active/key/'.$getVar['key'];
				    $pageUrl .= '/filter/active/key/'.$getVar['key'];
				    $where .= "new_status = 1";
				    break;
                case 'deactive':
				    $sortUrl .= '/filter/deactive/key/'.$getVar['key'];
				    $pageUrl .= '/filter/deactive/key/'.$getVar['key'];
				    $where .= "new_status = 0";
				    break;
			}
		}
		#If sort
		if($getVar['sort'] != FALSE && trim($getVar['sort']) != '')
		{
			switch(strtolower($getVar['sort']))
			{
				case 'email':
				    $pageUrl .= '/sort/email';
				    $sort .= "new_email";
				    break;
                case 'createddate':
				    $pageUrl .= '/sort/createddate';
				    $sort .= "new_created_date";
				    break;					                
				default:
				    $pageUrl .= '/sort/id';
				    $sort .= "new_id";
			}
			if($getVar['by'] != FALSE && strtolower($getVar['by']) == 'desc')
			{
                $pageUrl .= '/by/desc';
				$by .= "DESC";
			}
			else
			{
                $pageUrl .= '/by/asc';
				$by .= "ASC";
			}
		}
		#If have page
		if($getVar['page'] != FALSE && (int)$getVar['page'] > 0)
		{
			$start = (int)$getVar['page'];
			$pageSort .= '/page/'.$start;
		}
		else
		{
			$start = 0;
		}
		#END Search & Filter
		#Keyword
		$data['keyword'] = $keyword;
		#BEGIN: Create link sort
		$data['sortUrl'] = base_url().'administ/newsletter'.$sortUrl.'/sort/';
		$data['pageSort'] = $pageSort;
		#END Create link sort
		#BEGIN: Status
		$statusUrl = $pageUrl.$pageSort;
		$data['statusUrl'] = base_url().'administ/newsletter'.$statusUrl;
		if($getVar['status'] != FALSE && trim($getVar['status']) != '' && $getVar['id'] != FALSE && (int)$getVar['id'] > 0)
		{
            switch(strtolower($getVar['status']))
			{
				case 'active':
				    $this->newsletter_model->update(array('new_status' => 1), "new_id = ".(int)$getVar['id']);
					break;
				case 'deactive':
				    $this->newsletter_model->update(array('new_status' => 0), "new_id = ".(int)$getVar['id']);
					break;
			}
			redirect($data['statusUrl'], 'location');
		}
		#END Status
	
		#BEGIN: Pagination
		$this->load->library('pagination');
		#Count total record
		$totalRecord = count($this->newsletter_model->fetch("new_id", $where, "", ""));
		$config['cur_page'] = $start;
		$config['total_rows'] = $totalRecord;
		$config['base_url'] = base_url().'administ/newsletter'.$pageUrl.'/page/';
		$config['per_page'] = settingOtherAdmin;
		$config['num_links'] = 5;
		$this->pagination->initialize($config);
		$data['linkPage'] = $this->pagination->create_links();
		#END Pagination

		#sTT - So thu tu
		$data['sTT'] = $start + 1;
		#Fetch record
		$select = "new_id, new_email, new_created_date, new_status";
		$limit = settingOtherAdmin;
		$data['link'] = base_url() . 'administ/newsletter';
		$data['newsletter'] = $this->newsletter_model->fetch($select, $where, $sort, $by, $start, $limit);
		
		#Load view
		$this->load->view('admin/newsletter/defaults', $data);
	}
	private function  _excel($data, $showID = false)
    {
        require_once(APPPATH . 'libraries/xlsxwriter.class.php');
        $filename = "report.xlsx";
        header('Content-disposition: attachment; filename="' . XLSXWriter::sanitize_filename($filename) . '"');
        header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
        header('Content-Transfer-Encoding: binary');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        $header = array(
            'Email' => 'string'
        );
        $excel = array();
        foreach ($data as $item) {
            $row = array();           
            array_push($row, $item['new_email']);
            array_push($excel, $row);
        }
        $writer = new XLSXWriter();
        $writer->setAuthor('Lê Văn Sơn');
        $writer->writeSheet($excel, 'Sheet1', $header);
        $writer->writeToStdOut();
    }
	
	
}