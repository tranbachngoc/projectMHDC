<?php
#****************************************#
# * @Author: lehieu008                   #
# * @Email: lehieu008@gmail.com          #
# * @Website: http://www.iscvietnam.net  #
# * @Copyright: 2008 - 2009              #
#****************************************#
class Contact extends CI_Controller
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
		$this->lang->load('admin/contact');
		#Load model
		$this->load->model('contact_model');
	}
	
	function index()
	{
        #BEGIN: Delete
		if($this->input->post('checkone') && is_array($this->input->post('checkone')) && count($this->input->post('checkone')) > 0)
		{
            #BEGIN: CHECK PERMISSION
			if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'contact_delete'))
			{
				show_error($this->lang->line('unallowed_use_permission'));
				die();
			}
			#END CHECK PERMISSION
			$this->contact_model->delete($this->input->post('checkone'), "con_id");
			redirect(base_url().trim(uri_string(), '/'), 'location');
		}
		#END Delete
		#BEGIN: CHECK PERMISSION
		if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'contact_view'))
		{
			show_error($this->lang->line('unallowed_use_permission'));
			die();
		}
		#END CHECK PERMISSION
        #Define url for $getVar
		$action = array('search', 'keyword', 'filter', 'key', 'sort', 'by', 'page', 'status', 'id');
		$getVar = $this->uri->uri_to_assoc(3, $action);
		#BEGIN: Search & Filter
		$where = '';
		$sort = '';
		$by = '';
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
				case 'title':
				    $sortUrl .= '/search/title/keyword/'.$getVar['keyword'];
				    $pageUrl .= '/search/title/keyword/'.$getVar['keyword'];
				    $where .= "con_title LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
				    break;
                case 'username':
				    $sortUrl .= '/search/username/keyword/'.$getVar['keyword'];
				    $pageUrl .= '/search/username/keyword/'.$getVar['keyword'];
				    $where .= "use_username LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
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
				    $where .= "con_date_contact = ".(float)$getVar['key'];
				    break;
				case 'datereply':
				    $sortUrl .= '/filter/datereply/key/'.$getVar['key'];
				    $pageUrl .= '/filter/datereply/key/'.$getVar['key'];
				    $where .= "con_date_reply = ".(float)$getVar['key'];
				    break;
                case 'view':
				    $sortUrl .= '/filter/view/key/'.$getVar['key'];
				    $pageUrl .= '/filter/view/key/'.$getVar['key'];
				    $where .= "con_view = 1";
				    break;
                case 'notview':
				    $sortUrl .= '/filter/notview/key/'.$getVar['key'];
				    $pageUrl .= '/filter/notview/key/'.$getVar['key'];
				    $where .= "con_view = 0";
				    break;
                case 'reply':
				    $sortUrl .= '/filter/reply/key/'.$getVar['key'];
				    $pageUrl .= '/filter/reply/key/'.$getVar['key'];
				    $where .= "con_reply = 1";
				    break;
                case 'notreply':
				    $sortUrl .= '/filter/notreply/key/'.$getVar['key'];
				    $pageUrl .= '/filter/notreply/key/'.$getVar['key'];
				    $where .= "con_reply = 0";
				    break;
                case 'active':
				    $sortUrl .= '/filter/active/key/'.$getVar['key'];
				    $pageUrl .= '/filter/active/key/'.$getVar['key'];
				    $where .= "con_status = 1";
				    break;
                case 'deactive':
				    $sortUrl .= '/filter/deactive/key/'.$getVar['key'];
				    $pageUrl .= '/filter/deactive/key/'.$getVar['key'];
				    $where .= "con_status = 0";
				    break;
			}
		}
		#If sort
		if($getVar['sort'] != FALSE && trim($getVar['sort']) != '')
		{
			switch(strtolower($getVar['sort']))
			{
				case 'title':
				    $pageUrl .= '/sort/title';
				    $sort .= "con_title";
				    break;
                case 'username':
				    $pageUrl .= '/sort/username';
				    $sort .= "use_username";
				    break;
				case 'position':
				    $pageUrl .= '/sort/position';
				    $sort .= "con_position";
				    break;
                case 'datecontact':
				    $pageUrl .= '/sort/datecontact';
				    $sort .= "con_date_contact";
				    break;
                case 'datereply':
				    $pageUrl .= '/sort/datereply';
				    $sort .= "con_date_reply";
				    break;
				default:
				    $pageUrl .= '/sort/id';
				    $sort .= "con_id";
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
		$data['sortUrl'] = base_url().'administ/contact'.$sortUrl.'/sort/';
		$data['pageSort'] = $pageSort;
		#END Create link sort
		#BEGIN: Status
		$statusUrl = $pageUrl.$pageSort;
		$data['statusUrl'] = base_url().'administ/contact'.$statusUrl;
		if($getVar['status'] != FALSE && trim($getVar['status']) != '' && $getVar['id'] != FALSE && (int)$getVar['id'] > 0)
		{
            #BEGIN: CHECK PERMISSION
			if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'contact_edit'))
			{
				show_error($this->lang->line('unallowed_use_permission'));
				die();
			}
			#END CHECK PERMISSION
			switch(strtolower($getVar['status']))
			{
				case 'active':
				    $this->contact_model->update(array('con_status'=>1), "con_id = ".(int)$getVar['id']);
					break;
				case 'deactive':
				    $this->contact_model->update(array('con_status'=>0), "con_id = ".(int)$getVar['id']);
					break;
			}
			redirect($data['statusUrl'], 'location');
		}
		#END Status
		#BEGIN: Pagination
		$this->load->library('pagination');
		#Count total record
		$totalRecord = count($this->contact_model->fetch_join("con_id", "LEFT", "tbtt_user", "tbtt_contact.con_user = tbtt_user.use_id", $where, "", ""));
        $config['base_url'] = base_url().'administ/contact'.$pageUrl.'/page/';
		$config['total_rows'] = $totalRecord;
		$config['per_page'] = settingOtherAdmin;
		$config['num_links'] = 5;
		$config['cur_page'] = $start;
		$this->pagination->initialize($config);
		$data['linkPage'] = $this->pagination->create_links();
		#END Pagination
		#sTT - So thu tu
		$data['sTT'] = $start + 1;
		#Fetch record
		$select = "con_id, con_title, con_position, con_date_contact, con_date_reply, con_view, con_reply, con_status, use_id, use_username, use_fullname, use_email";
		$limit = settingOtherAdmin;
		$data['contact'] = $this->contact_model->fetch_join($select, "LEFT", "tbtt_user", "tbtt_contact.con_user = tbtt_user.use_id", $where, $sort, $by, $start, $limit);
		#Load view
		$this->load->view('admin/contact/defaults', $data);
	}
	
	function view($id)
	{
        if($this->session->flashdata('sessionSuccessReply'))
		{
            $data['successReply'] = true;
		}
		else
		{
            $data['successReply'] = false;
            #BEGIN: Get contact by $id
			$contact = $this->contact_model->get("*", "con_id = ".(int)$id);
			if(count($contact) != 1 || !$this->check->is_id($id))
			{
				redirect(base_url().'administ/contact', 'location');
				die();
			}
			$data['contact'] = $contact;
			#END Get contact by $id
			$this->load->library('bbcode');
			#Get user
			$this->load->model('user_model');
			$data['user'] = $this->user_model->get("use_username, use_fullname, use_email, use_phone, use_yahoo", "use_id = ".$contact->con_user);
			#Update view
			$this->contact_model->update(array('con_view'=>1), "con_id = ".(int)$id);
			$this->load->library('form_validation');
			#BEGIN: Set rules
            $this->form_validation->set_rules('txtContent', 'lang:txtcontent_message_view', 'trim|required');
			#END Set rules
			#BEGIN: Set message
			$this->form_validation->set_message('required', $this->lang->line('required_message'));
			$this->form_validation->set_error_delimiters('<div class="div_errorpost">', '</div>');
			#END Set message
			if($this->form_validation->run() != FALSE)
			{
                #BEGIN: CHECK PERMISSION
				if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'contact_add'))
				{
					show_error($this->lang->line('unallowed_use_permission'));
					die();
				}
				#END CHECK PERMISSION
				$txtContent = $contact->con_detail.'[fieldset][legend][i]'.$this->lang->line('name_reply_view').'[/i][/legend]'.$this->input->post('txtContent').'[/fieldset]';
				$dataReply = array(
				                    'con_detail'      	=>      trim($this->filter->injection_html($txtContent)),
				                    'con_date_reply'    =>  	mktime(0, 0, 0, date('m'), date('d'), date('Y')),
				                    'con_reply'         =>      1,
	                                'con_status'      	=>      1
									);
				if($this->contact_model->update($dataReply, "con_id = ".(int)$id))
				{
     				$this->session->set_flashdata('sessionSuccessReply', 1);
				}
				redirect(base_url().'administ/contact/view/'.$id, 'location');
			}
			else
	        {
				if($this->input->post('isSubmit') && $this->input->post('isSubmit') == 'true')
				{
					$data['errorReply'] = true;
				}
				else
				{
                    $data['errorReply'] = false;
				}
				$data['txtContent'] = $this->input->post('txtContent');
	        }
        }
		#Load view
		$this->load->view('admin/contact/view', $data);
	}
}