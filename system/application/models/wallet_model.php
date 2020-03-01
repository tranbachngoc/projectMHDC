<?php
class Wallet_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->table_name = "tbtt_wallet";
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
        $query = $this->db->get($this->table_name);
        $result = $query->row();
        $query->free_result();
        return $result;
    }
    
    function fetch($select = "*", $where = "", $order = "id", $by = "DESC", $start = -1, $limit = 0)
    {
        $this->db->cache_off();
        $this->db->select($select);
        if($where && $where != "")
        {
                $this->db->where($where);
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
        $query = $this->db->get($this->table_name);
        $result = $query->result();
        $query->free_result();
        return $result;
    }
    
    
    function add($data)
    {
        $this->db->insert($this->table_name, $data);
        return $this->db->insert_id();
    }

    function update($data, $where = "")
    {
        if($where && $where != "")
        {
            $this->db->where($where);
        }
        return $this->db->update($this->table_name, $data);
    }
    
    public function getListWallet($params) {
                $this->db->cache_off();
		$this->db->select('*');
		
		if (!empty($params['user_id'])) {
			$this->db->where('user_id', $params['user_id']);
		}
                
        if (!empty($params['order_by'])) {
            $this->db->order_by($params['order_by']['key'],$params['order_by']['value']);
        }
		
		if ($params['is_count']) {                        
			$query = $this->db->get($this->table_name);
			$result = $query->result();    
			return count($result);
		   
		} else {
			if(!empty($params['limit'])) {
				$this->db->limit($params['limit'], $params['start']);
				$query = $this->db->get($this->table_name);
			} else {
				$query = $this->db->get($this->table_name);
			}                    
			
			$result = $query->result();
                        //echo $this->db->last_query();exit;
			$query->free_result();
		}

		return $result;
    }
    
    public function getSumWallet($where,$type){
        $this->db->cache_off();
        $this->db->select('SUM(amount) AS amount');
        $this->db->from($this->table_name);
        
        if(isset($where['user_id']) && $where['user_id'] != ''){
            $this->db->where('user_id',$where['user_id']);
        }
        
        if(isset($type) && $type != ''){
            $this->db->where('type',$type);
        }
        
        $query = $this->db->get();
        //echo $this->db->last_query();exit;
        return $query->result();

    }

}