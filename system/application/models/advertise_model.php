<?php
#****************************************#
# * @Author: lehieu008                   #
# * @Email: lehieu008@gmail.com          #
# * @Website: http://www.iscvietnam.net  #
# * @Copyright: 2008 - 2009              #
#****************************************#
class Advertise_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
        $this->table_name = "tbtt_advertise";
	}

	function get($select = "*", $where = "")
	{
		if(strtolower(trim($this->uri->segment(1))) == 'administ')
		{
			$this->db->cache_off();
		}
		else
		{
            $this->db->cache_on();
		}
		$this->db->select($select);
		if($where && $where != "")
		{
			$this->db->where($where);
		}
		#Query
		$query = $this->db->get("tbtt_advertise");
		$result = $query->row();
		$query->free_result();
		return $result;
	}

	function fetch($select = "*", $where = "", $order = "adv_id", $by = "DESC", $start = -1, $limit = 0)
	{
        if(strtolower(trim($this->uri->segment(1))) == 'administ')
		{
			$this->db->cache_off();
            $this->db->join('tbtt_user', 'tbtt_user.use_id = tbtt_advertise.user_id', 'INNER');
            $this->db->join('tbtt_category', 'tbtt_category.cat_id = tbtt_advertise.cat_id', 'LEFT');
            $this->db->join('tbtt_province', 'tbtt_province.pre_id = tbtt_advertise.adv_province', 'LEFT');

		}
		else
		{
            $this->db->cache_on();
		}
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
		$query = $this->db->get("tbtt_advertise");

		$result = $query->result();
		$query->free_result();
		return $result;
	}
	
	function add($data)
	{
		$this->db->cache_delete_all();
		if(!file_exists('system/cache/index.html'))
		{
			$this->load->helper('file');
   			@write_file('system/cache/index.html', '<p>Directory access is forbidden.</p>');
		}
		return $this->db->insert("tbtt_advertise", $data);
	}

	function update($data, $where = "")
	{
        $this->db->cache_delete_all();
		if(!file_exists('system/cache/index.html'))
		{
			$this->load->helper('file');
   			@write_file('system/cache/index.html', '<p>Directory access is forbidden.</p>');
		}
    	if($where && $where != "")
    	{
			$this->db->where($where);
    	}
		return $this->db->update("tbtt_advertise", $data);
	}

	function delete($value, $field = "adv_id", $in = true)
    {
        $this->db->cache_delete_all();
		if(!file_exists('system/cache/index.html'))
		{
			$this->load->helper('file');
   			@write_file('system/cache/index.html', '<p>Directory access is forbidden.</p>');
		}
		if($in == true)
		{
			$this->db->where_in($field, $value);
		}
		else
		{
            $this->db->where($field, $value);
		}
		return $this->db->delete("tbtt_advertise");
    }
    public function listAds($params) {
        $this->db->cache_off();
        $this->db->select('tbtt_advertise.*, tbtt_user.*, tbtt_category.cat_name, tbtt_province.pre_name, tbtt_advertise_config.adv_title as adv_title2');
        $this->db->join('tbtt_user','tbtt_user.use_id = tbtt_advertise.user_id');
        $this->db->join('tbtt_province','tbtt_province.pre_id = tbtt_advertise.adv_province', 'left');
        $this->db->join('tbtt_category','tbtt_category.cat_id = tbtt_advertise.cat_id', 'left');
        $this->db->join('tbtt_advertise_config','tbtt_advertise_config.id = tbtt_advertise.adv_position');

        if (!empty($params['user_id'])) {
            $this->db->where('tbtt_advertise.user_id', $params['user_id']);
        }

        if (!empty($params['order_by'])) {
            $this->db->order_by($params['order_by']['key'],$params['order_by']['value']);
            $this->db->order_by('adv_id','DESC');
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

            $query->free_result();
        }

        $result = $query->result();

        $query->free_result();
        return $result;
    }
}