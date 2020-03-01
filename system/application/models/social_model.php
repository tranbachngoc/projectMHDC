<?php
#****************************************#
# * @Author: lehieu008                   #
# * @Email: lehieu008@gmail.com          #
# * @Website: http://www.iscvietnam.net  #
# * @Copyright: 2008 - 2009              #
#****************************************#
class Social_model extends MY_Model
{
	function __construct()
	{
		parent::__construct();
		$this->table = 'tbtt_social';
		$this->select = '*';
	}

	private function checkSocialExist($data){
		$this->db->cache_off();
		$this->db->select('COUNT(*) as total');
		$this->db->from('tbtt_social');
		$this->db->where('providerId', $data['providerId']);
		$this->db->where('providerUserId', $data['providerUserId']);
		$query = $this->db->get();
		$result = $query->row_array();
		$query->free_result();
		if($result['total'] > 0){
			return TRUE;
		}else{
			return FALSE;
		}
	}

	function updateLogin($data){
		if($this->checkSocialExist($data)){
			$this->db->where('providerId', $data['providerId']);
			$this->db->where('providerUserId', $data['providerUserId']);
			$this->db->update('tbtt_social', $data);
		}else{
			$this->db->insert('tbtt_social', $data);
		}
	}

	function addSocial($data) {
		$this->db->cache_off();
		$this->db->insert('tbtt_social', $data);
	}

	function updateSocial($data) {
		$this->db->cache_off();
		$this->db->where('providerId', $data['providerId']);
		$this->db->where('providerUserId', $data['providerUserId']);
		$this->db->update('tbtt_social', array('userId'=>$data['use_id']));
	}

	function checkExistUser($data){

		$this->db->cache_off();
		$this->db->select('use_id, use_group, use_username, use_fullname, avatar');
		$this->db->from('tbtt_user');
		$this->db->where('use_email', $data['email']);
		$query = $this->db->get();
		$result = $query->row_array();
		$query->free_result();
		if(!empty($result)){
			// Update user ID
			$this->db->where('providerId', $data['providerId']);
			$this->db->where('providerUserId', $data['providerUserId']);
			$this->db->update('tbtt_social', array('userId'=>$result['use_id']));
		}
		return $result;
	}

	function getUser($data)
	{
        $this->db->cache_off();
		$this->db->select('*');
		$this->db->where('providerUserId', $data['providerUserId']);
		$this->db->where('providerId', $data['providerId']);
		$this->db->join('tbtt_user', 'tbtt_user.use_id = tbtt_social.userId', 'RIGHT');
		#Query
		$query = $this->db->get("tbtt_social");
		$result = $query->row();
		$query->free_result();
		return $result;
	}

	function getUserSocial($select="*", $where="") {
		$this->db->cache_off();
		$this->db->select($select);
		if($where && $where != "")
		{
			$this->db->where($where);
		}
		#Query
		$query = $this->db->get("tbtt_social");
		$result = $query->row();
		$query->free_result();
		return $result;
	}
	
	function login($data){
		#Load model
		$this->load->model('user_model');
		$sessionLogin = array(
			'sessionUser'      	=>     $data['use_id'],
			'sessionGroup'     	=>     $data['use_group'],
			'sessionUsername'       =>     $data['use_username'],
			'sessionName'     	=>     $data['use_fullname'],
			'sessionAvatar' => $data['avatar']
		);
		$this->session->set_userdata($sessionLogin);
		$this->session->set_flashdata('sessionSuccessLogin', 1);
		$this->session->unset_userdata('sessionValidLogin');
		$this->session->unset_userdata('sessionTimeValidLogin');
		$this->user_model->update(array('use_lastest_login'=>time()), "use_id = ".$data['use_id']);
	}

	function createdUser($data){
		$data['use_group'] = 3;
		$this->load->model('user_model');
		$this->user_model->add($data);
		return $this->db->insert_id();
	}
	
	function get($select = "*", $where = "")
	{
        $this->db->cache_off();
		$this->db->select($select);
		if($where && $where != "")
		{
			$this->db->where($where);
		}
		#Query
		$query = $this->db->get("tbtt_user");
		$result = $query->row();
		$query->free_result();
		return $result;
	}
	
	function getUserByUsername($username)
	{
		$select = "*";
        $this->db->cache_off();
		$this->db->select($select);
		$where ="use_username like '".$username."'";
		
		$this->db->where($where);
		#Query
		$query = $this->db->get("tbtt_user");
		$result = $query->row();
		$query->free_result();
		return $result;
	}
	
	function fetch($select = "*", $where = "", $order = "use_id", $by = "DESC", $start = -1, $limit = 0)
	{
        $this->db->cache_off();
		$this->db->select($select);
		if($where && $where != "")
		{
			$this->db->where($where, NULL, false);
		}
		if($order && $order != "" && $by && ($by == "DESC" || $by == "ASC"))
		{
            $this->db->order_by($order, $by);
		}
		if((int)$start >= 0 && $limit && (int)$limit > 0)
		{
			$this->db->limit($limit, $start);
		}
		#Query
		$query = $this->db->get("tbtt_user");
		$result = $query->result();
		$query->free_result();
		return $result;
	}
	
	function fetch_join($select = "*", $join, $table, $on, $where = "", $order = "use_id", $by = "DESC", $start = -1, $limit = 0, $distinct = false)
	{
        $this->db->cache_off();
		$this->db->select($select);
		if($join && ($join == "INNER" || $join == "LEFT" || $join == "RIGHT") && $table && $table != "" && $on && $on != "")
		{
			$this->db->join($table, $on, $join);
		}
		if($where && $where != "")
		{
			$this->db->where($where, NULL, false);
		}
		if($order && $order != "" && $by && ($by == "DESC" || $by == "ASC"))
		{
            $this->db->order_by($order, $by);
		}
		if((int)$start >= 0 && $limit && (int)$limit > 0)
		{
			$this->db->limit($limit, $start);
		}
		if($distinct && $distinct == true)
		{
			$this->db->distinct();
		}
		#Query
		$query = $this->db->get("tbtt_user");
		$result = $query->result();
		$query->free_result();
		return $result;
	}
	
	function add($data)
	{
        if(!isset($data['af_key'])){
            $data['af_key'] = md5($data['use_username'].time());
        }
		return $this->db->insert("tbtt_user", $data);
	}
	
	function update($data, $where = "")
	{
    	if($where && $where != "")
    	{
			$this->db->where($where);
    	}
		return $this->db->update("tbtt_user", $data);
	}
	
	function delete($value, $field = "use_id", $in = true)
    {
		if($in == true)
		{
			$this->db->where_in($field, $value);
		}
		else
		{
            $this->db->where($field, $value);
		}
		return $this->db->delete("tbtt_user");
    }
    
    public function get_list_statuses() {
        $this->db->cache_off();
        $this->db->select('*');
        $query = $this->db->get("tbtt_status");
        $result = $query->result();
        $statuses = array();
        if (!empty($result)) {
            foreach ($result as $item) {
                $statuses[$item->status_id] = $item->text;
            }
        }
        $query->free_result();
        return $statuses;
    }    
}