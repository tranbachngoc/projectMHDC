<?php
class Walletlog_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->table_name = "tbtt_walletlog";
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
        $this->db->join('tbtt_user','tbtt_user.use_id = tbtt_walletlog.user_id');
        $this->db->join('tbtt_wallet','tbtt_wallet.id_walletlog = tbtt_walletlog.id','left');
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

    function delete($value, $field = "id", $in = true)
    {
        if($in == true)
        {
            $this->db->where_in($field, $value);
        }
        else
        {
            $this->db->where($field, $value);
        }
        return $this->db->delete("tbtt_walletlog");
    }
    
    public function listWalletLog($params) {
                $this->db->cache_off();
		$this->db->select('tbtt_walletlog.*,tbtt_wallet.id_walletlog, tbtt_wallet.update_by_admin, tbtt_wallet.status_apply, tbtt_user.*');
                $this->db->join('tbtt_user','tbtt_user.use_id = tbtt_walletlog.user_id');
                $this->db->join('tbtt_wallet','tbtt_wallet.id_walletlog = tbtt_walletlog.id', 'left');

		if (!empty($params['user_id'])) {
			$this->db->where('tbtt_walletlog.user_id', $params['user_id']);
		}
        if (isset($params['id']) && (int)$params['id'] > 0) {
			$this->db->where('tbtt_walletlog.id', $params['id']);
		}

        if (!empty($params['order_by'])) {
            $this->db->order_by($params['order_by']['key'],$params['order_by']['value']);
            $this->db->order_by('id','DESC');
        }

		if ($params['is_count']) {                        
			$query = $this->db->get($this->table_name);
			$result = $query->result();    
			return count($result);
		   
		} 
        else {
			if(!empty($params['limit'])) {
				$this->db->limit($params['limit'], $params['start']);
				$query = $this->db->get($this->table_name);
			}
            else {
				$query = $this->db->get($this->table_name);
			}                    
			
			$result = $query->result();

			$query->free_result();
		}


		return $result;
    }

}