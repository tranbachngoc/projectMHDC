<?php
#****************************************#
# * @Author: lehieu008                   #
# * @Email: lehieu008@gmail.com          #
# * @Website: http://www.iscvietnam.net  #
# * @Copyright: 2008 - 2009              #
#****************************************#
class User_model extends MY_Model
{
	function __construct()
	{
		parent::__construct();
		$this->table = 'tbtt_user';
		$this->select = '*';
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

	function get_list_user($select = "*", $where = "", $join = "", $table, $on)
	{
        $this->db->cache_off();
		$this->db->select($select);
        if(is_array($where)) {
            foreach ($where as $iKWhere => $aWhere) {
                if(is_array($aWhere)) {
                    $this->db->where_in($iKWhere, $aWhere);
                }else {
                    $this->db->where($iKWhere.' =',$aWhere);
                }
            }
        } else if($where && $where != "") {
			$this->db->where($where);
		}

        if($join && ($join == "INNER" || $join == "LEFT" || $join == "RIGHT") && $table && $table != "" && $on && $on != "")
        {
            $this->db->join($table, $on, $join);
        }
		#Query
		$query = $this->db->get("tbtt_user");
		$result = $query->result();
		$query->free_result();
		return $result;
	}

	function getDetail($select = "*", $join, $table, $on, $where = "", $order = "use_id", $by = "DESC", $start = -1, $limit = 0, $distinct = false)
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

	public function get_user_key($key)
	{
		$this->db->where('af_key', $key);
		$result = $this->db->get('tbtt_user');
		if($result->num_rows() > 0)
			return $result->row();
		return false;
	}

	public function get_user_id($key)
	{
		$this->db->where('use_id', $key);
		$result = $this->db->get('tbtt_user');
		if($result->num_rows() > 0)
			return $result->row();
		return false;
	}

	function fetch($select = "*", $where = "", $order = "use_id", $by = "DESC", $start = -1, $limit = 10, $distinct = false)
	{
        $this->db->cache_off();
		$this->db->select($select);
		$this->db->from("tbtt_user u");
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
			$this->db->group_by('tbtt_shop.sho_user');
		}	
		#Query
		//$query = $this->db->get("tbtt_user");
		$query = $this->db->get();           
		$result = $query->result();
		$query->free_result();
		return $result;
	}
	
	function fetch_join($select = "*", $join, $table, $on, $where = "", $order = "use_id", $by = "DESC", $start = -1, $limit = 0, $distinct = false, $group_by=NULL)
	{
        $this->db->cache_off();
		$this->db->select($select, false);
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
			$this->db->group_by('tbtt_shop.sho_user');
		}
		if($group_by && $group_by != NULL){
            $this->db->group_by($group_by);
        }

        #Query
		$query = $this->db->get("tbtt_user");
		$result = $query->result();
		$query->free_result();
		return $result;
	}


    function fetch_join1($select = "*", $join_1, $table_1, $on_1, $join_2, $table_2, $on_2, $wherestore = "", $order = "use_id", $by = "DESC", $start = -1, $limit = 0, $distinct = false, $group_by=NULL)
    {
        $this->db->cache_off();
        $this->db->select($select);
        if ($join_1 && ($join_1 == "INNER" || $join_1 == "LEFT" || $join_1 == "RIGHT") && $table_1 && $table_1 != "" && $on_1 && $on_1 != "") {
            $this->db->join($table_1, $on_1, $join_1);
        }
        if ($join_2 && ($join_2 == "INNER" || $join_2 == "LEFT" || $join_2 == "RIGHT") && $table_2 && $table_2 != "" && $on_2 && $on_2 != "") {
            $this->db->join($table_2, $on_2, $join_2);

        }
        if ($wherestore && $wherestore != "") {
            $this->db->where($wherestore);
        }
        if ($order && $order != "" && $by && ($by == "DESC" || $by == "ASC")) {
            $this->db->order_by($order, $by);
        }
        if ((int)$start >= 0 && $limit && (int)$limit > 0) {
            $this->db->limit($limit, $start);
        }
        if ($distinct && $distinct == true) {
            $this->db->distinct();

        }
        if($group_by && $group_by!= NULL){
            $this->db->group_by($group_by);
        }
        else{
            $this->db->group_by('tbtt_shop.sho_user');
        }
		#Query
        $query = $this->db->get("tbtt_user");
        $result = $query->result();
        $query->free_result();
        return $result;
    }
    function fetch_join2($select = "*", $join_1, $table_1, $on_1, $join_2, $table_2, $on_2, $join_3, $table_3, $on_3, $wherestore = "", $order = "use_id", $by = "DESC", $start = -1, $limit = 0, $distinct = false)
    {
        $this->db->cache_off();
        $this->db->select($select);
        if ($join_1 && ($join_1 == "INNER" || $join_1 == "LEFT" || $join_1 == "RIGHT") && $table_1 && $table_1 != "" && $on_1 && $on_1 != "") {
            $this->db->join($table_1, $on_1, $join_1);
        }
        if ($join_2 && ($join_2 == "INNER" || $join_2 == "LEFT" || $join_2 == "RIGHT") && $table_2 && $table_2 != "" && $on_2 && $on_2 != "") {
            $this->db->join($table_2, $on_2, $join_2);

        }

        if ($join_3 && ($join_3 == "INNER" || $join_3 == "LEFT" || $join_3 == "RIGHT") && $table_3 && $table_3 != "" && $on_3 && $on_3 != "") {
            $this->db->join($table_3, $on_3, $join_3);

        }

        if ($wherestore && $wherestore != "") {
            $this->db->where($wherestore);
        }
        if ($order && $order != "" && $by && ($by == "DESC" || $by == "ASC")) {
            $this->db->order_by($order, $by);
        }
        if ((int)$start >= 0 && $limit && (int)$limit > 0) {
            $this->db->limit($limit, $start);
        }
        if ($distinct && $distinct == true) {
            $this->db->distinct();
            $this->db->group_by('tbtt_shop.sho_user');
        }
        #Query
        $query = $this->db->get("tbtt_user");
        $result = $query->result();
        $query->free_result();
        return $result;
    }

    function fetch_join3($select = "*", $join_1, $table_1, $on_1, $join_2, $table_2, $on_2, $join_3, $table_3, $on_3, $wherestore = "", $order = "use_id", $by = "DESC", $start = -1, $limit = 0, $distinct = false, $group=NULL)
    {
        $this->db->cache_off();
        $this->db->select($select);
        if ($join_1 && ($join_1 == "INNER" || $join_1 == "LEFT" || $join_1 == "RIGHT") && $table_1 && $table_1 != "" && $on_1 && $on_1 != "") {
            $this->db->join($table_1, $on_1, $join_1);
        }
        if ($join_2 && ($join_2 == "INNER" || $join_2 == "LEFT" || $join_2 == "RIGHT") && $table_2 && $table_2 != "" && $on_2 && $on_2 != "") {
            $this->db->join($table_2, $on_2, $join_2);

        }
        if ($join_3 && ($join_3 == "INNER" || $join_3 == "LEFT" || $join_3 == "RIGHT") && $table_3 && $table_3 != "" && $on_3 && $on_3 != "") {
            $this->db->join($table_3, $on_3, $join_3);

        }
        if ($wherestore && $wherestore != "") {
            $this->db->where($wherestore);
        }
        if ($order && $order != "" && $by && ($by == "DESC" || $by == "ASC")) {
            $this->db->order_by($order, $by);
        }
        if ((int)$start >= 0 && $limit && (int)$limit > 0) {
            $this->db->limit($limit, $start);
        }
        if ($distinct && $distinct == true) {
            $this->db->distinct();
            $this->db->group_by('tbtt_shop.sho_user');
        }
        else{
            if ($group && $group != NULL) {
                $this->db->group_by($group);
            }
        }
        #Query
        $query = $this->db->get("tbtt_user");
        $result = $query->result();
        $query->free_result();
        return $result;
    }

    function fetch_join4($select = "*", $join_1, $table_1, $on_1, $join_2, $table_2, $on_2, $join_3, $table_3, $on_3, $join_4, $table_4, $on_4, $wherestore = "", $order = "use_id", $by = "DESC", $start = -1, $limit = 0, $distinct = false, $group=NULL)
    {
        $this->db->cache_off();
        $this->db->select($select);
        if ($join_1 && ($join_1 == "INNER" || $join_1 == "LEFT" || $join_1 == "RIGHT") && $table_1 && $table_1 != "" && $on_1 && $on_1 != "") {
            $this->db->join($table_1, $on_1, $join_1);
        }
        if ($join_2 && ($join_2 == "INNER" || $join_2 == "LEFT" || $join_2 == "RIGHT") && $table_2 && $table_2 != "" && $on_2 && $on_2 != "") {
            $this->db->join($table_2, $on_2, $join_2);

        }
        if ($join_3 && ($join_3 == "INNER" || $join_3 == "LEFT" || $join_3 == "RIGHT") && $table_3 && $table_3 != "" && $on_3 && $on_3 != "") {
            $this->db->join($table_3, $on_3, $join_3);

        }
         if ($join_4 && ($join_4 == "INNER" || $join_4 == "LEFT" || $join_4 == "RIGHT") && $table_4 && $table_4 != "" && $on_4 && $on_4 != "") {
            $this->db->join($table_4, $on_4, $join_4);

        }
        if ($wherestore && $wherestore != "") {
            $this->db->where($wherestore);
        }
        if ($order && $order != "" && $by && ($by == "DESC" || $by == "ASC")) {
            $this->db->order_by($order, $by);
        }
        if ((int)$start >= 0 && $limit && (int)$limit > 0) {
            $this->db->limit($limit, $start);
        }
        if ($distinct && $distinct == true) {
            $this->db->distinct();
            $this->db->group_by('tbtt_shop.sho_user');
        }
        else{
            if ($group && $group != NULL) {
                $this->db->group_by($group);
            }
        }
        #Query
        $query = $this->db->get("tbtt_user");
        $result = $query->result();
        $query->free_result();
        return $result;
    }

    //by Tran Bao, get money by subuser of NVKD
    function get_list_DSo_by_NVKD($select='*', $where='', $order ='user_id', $by='DESC', $start = -1, $limit = 0)
    {
    	$this->db->cache_off();
        $this->db->select($select);
        if($where && $where != "")
		{
			$this->db->where($where, NULL, false);
		}
        if ($order && $order != "" && $by && ($by == "DESC" || $by == "ASC")) {
            $this->db->order_by($order, $by);
        }
        if ((int)$start >= 0 && $limit && (int)$limit > 0) {
            $this->db->limit($limit, $start);
        }       
        #Query
        $query = $this->db->get('tbtt_user AS us');
        $result = $query->result();  
        $query->free_result();
        return $result;
    }  

	//by Tran Bao, get list shop fee
	function get_list_shop_fee() {
	    $this->db->select ( 'tbtt_package_user.user_id, tbtt_package_user.package_id, tbtt_package_info.name' ); 
	    $this->db->from ( 'tbtt_package_user');
	    $this->db->join ( 'tbtt_package', 'tbtt_package.id = tbtt_package_user.package_id' , 'left' );
	    $this->db->join ( 'tbtt_package_info', 'tbtt_package_info.id = tbtt_package.info_id' , 'left' );	    
	    $this->db->where('tbtt_package.info_id >=2 AND tbtt_package.info_id <= 7');
	    $this->db->group_by('tbtt_package_user.user_id');
	    $this->db->order_by('tbtt_package_user.user_id', 'DESC');
	    $query = $this->db->get ();
	    return $query->result ();
 	}

 	//by Tran Bao, get list shop by package
 	function get_shop_by_package($IdPackage) {
	    $this->db->select ( 'tbtt_package_user.user_id, tbtt_package_user.package_id, tbtt_package_info.name' ); 
	    $this->db->from ( 'tbtt_package_user');
	    $this->db->join ( 'tbtt_package', 'tbtt_package.id = tbtt_package_user.package_id' , 'left' );
	    $this->db->join ( 'tbtt_package_info', 'tbtt_package_info.id = tbtt_package.info_id' , 'left' );	    
	    $this->db->where('tbtt_package.info_id = '.$IdPackage);
	    $this->db->group_by('tbtt_package_user.user_id');
	    $this->db->order_by('tbtt_package_user.user_id', 'DESC');
	    $query = $this->db->get ();
	    return $query->result ();
 	}

	function add($data)
	{
        if(!isset($data['af_key'])){
            $data['af_key'] = md5($data['use_username'].time());
        }

		$this->db->insert("tbtt_user", $data);
        return $this->db->insert_id();
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

	function getUserInfo($filter)
	{
		$this->db->cache_off();
		if(isset($filter['select'])){
			$this->db->select($filter['select'], false);
		}
		if(isset($filter['where'])){
			$this->db->where($filter['where']);
		}
		#Query
		$query = $this->db->get("tbtt_user");
		$result = $query->row_array();

		$query->free_result();
		return $result;
	}
        
    public function countUserByParams($where=NULL,$select='*',$total=NULL) {
        $this->db->select($select);
        $this->db->from('tbtt_user');

        if(isset($where['use_status']) && $where['use_status']){
            $this->db->where('use_status',$where['use_status']);
        }
            
        if(isset($where['use_group']) && $where['use_group']){
            $this->db->where('use_group',$where['use_group']);
        }
            
        if(isset($where['active_date']) && $where['active_date']){
            $this->db->where('active_date',$where['active_date']);
        }
        $query = $this->db->get();
        if($total){
            return $query->num_rows();
        }
        return $query->result();
    }

    function generalInfo($where)
    {
        $params = ['use_status' => 1];

        if (filter_var($where, FILTER_VALIDATE_EMAIL)){
            $params['use_email']  = $where;
        }else if(is_numeric($where)){
            $params['use_id']  = $where;
        }else{
            $params['use_username']  = $where;
        }

        return $this->find_where(
            $params,
            ['select'   => 'use_id, use_username, use_group, parent_id, use_status, af_key, use_enddate, use_fullname, use_email, use_sex, use_birthday, use_mobile, use_group, use_about, use_address, use_province, user_district, avatar, use_cover, website,affiliate_level, website, use_home_town, use_religion, use_slug, parent_invited, is_show_storetab, permission_email, permission_mobile']
        );
    }

    public function get_own_shop_or_branch($user_id)
    {
        if(!$user_id)
            return false;

        $user = $this->find_where([
                'use_status'    => ACTIVE,
                'use_id'        => $user_id
            ],
            ['select'  => 'use_id, use_group, parent_id, parent_shop, use_status']
        );

        if (empty($user) || !$user['use_group'])
            return false;

        if ($user['use_group'] == NormalUser)
            return false;

        if ($user['use_group'] == AffiliateStoreUser || $user['use_group'] == BranchUser)
            return $user['use_id'];

        if ($user['use_group'] == StaffStoreUser){
            $user_parent = $this->find_where([
                'use_status'    => ACTIVE,
                'use_id'        => $user->parent_id
            ],
                ['select'  => 'use_id, use_group, parent_id, parent_shop, use_status']
            );

            if (empty($user_parent)){
                return false;
            }

            return $user_parent['use_id'];
        }

        return false;
    }


    /**
     * @param $root_user of shop, branch
     * @param string $return
     * @return mix
     */
    public function get_all_user_shop_of_branch($root_user, $return = 'json')
    {
        if(!$root_user)
            return false;

        $users = $this->find_where([
            'use_status' => ACTIVE,
            'parent_id' => $root_user,
            'use_group' => StaffStoreUser,
        ], ['select' => 'use_id, use_group, parent_id, parent_shop, parent_invited']);

        $result = [];
        $result[] = $root_user;
        if (!empty($users)){
            foreach ($users as $user) {
                if(!empty($user['use_id'])){
                    $result[] = $user['use_id'];
                }
            }
        }

        if ($return == 'json'){
            return json_encode($result);
        }

        if ($return == 'string'){
            return implode(',', $result);
        }

        return $result;
    }

    public function is_owner_shop($sho_user, $user_id = 0, $group_id = 0)
    {
        $sho_user = (int)$sho_user;
        $user_id = (int)$user_id;
        $group_id = (int)$group_id;

        if(!$sho_user)
            return 0;

        if(!$user_id)
            $user_id = (int)$this->session->userdata('sessionUser');

        if(!$group_id)
            $group_id = (int)$this->session->userdata('sessionGroup');

        if(!$user_id || !$group_id)
            return 0;

        if($sho_user == $user_id)
            return $user_id;

        if($group_id == StaffStoreUser){
            if($this->find_where(['use_id' => $user_id, 'parent_id' => $sho_user], ['select' => 'use_id'])){
                return $user_id;
            }
        }

        return 0;
    }

    public function page_permission($current_user_id, $user_id) {
        // check user
        $sql_get_shop = 'select `use_group` from `tbtt_user` where `use_status` = 1 and `use_id` = '.$user_id.' limit 1';
        $get_shop = $this->db->query($sql_get_shop);

        if (!$get_shop->num_rows()) {
            return false;
        }

        if ($user_id == $current_user_id) {
            return true;
        }else {
            // check branch for shop
            $get_branch_sql = 'select `use_id` 
                               from `tbtt_user` 
                               where (`use_status` = 1 and `use_group` = '.BranchUser.' and `parent_id` = '.$current_user_id.' and `use_id` = '.$user_id.') limit 1';
            $get_branch = $this->db->query($get_branch_sql);
            if ($get_branch->num_rows()) {
                return true;
            }
        }
        return false;
    }

    /**
     * @param $root_user of shop, branch
     * @param string $return
     * @return mix
     */
    public function get_list_user_shop_and_branch($root_user, $return = 'json')
    {
        if(!$root_user)
            return false;

        $where = "use_status = " . ACTIVE . " AND parent_id = {$root_user} AND use_group = " . BranchUser ;
        $param = array(
            'select'  	=> 'use_id, use_group, parent_id, parent_shop, parent_invited',
            'table'   	=> 'tbtt_user',
            'type'    	=> 'array',
            'list'    	=> true,
            'orderby' 	=> 'use_id ASC',
            'limit' 	=> 0,
            'start' 	=> 0
        );
        $users = $this->gets_where($where, $param);

        $result = [];
        $result[] = $root_user;
        if (!empty($users)){
            foreach ($users as $user) {
                if(!empty($user['use_id'])){
                    $result[] = $user['use_id'];
                }
            }
        }

        if ($return == 'json'){
            return json_encode($result);
        }

        if ($return == 'string'){
            return implode(',', $result);
        }

        return $result;
    }
}