<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Model extends CI_Model {

	public $table 			= null; //table đang xử lý
	public $select 			= '*';

	function __construct($table = null) {

		$this->table 	= $table;
//		$ci =& get_instance();

		parent::__construct();
	}

	public function settable($table = NULL)
	{
		$this->table = $table;
	}


	public function gettable()
	{
		return $this->table;
	}


	//Xử lý lấy dữ liệu
	public function _general($param = '')
	{
		//Select
		if(isset($param['select']) && !empty($param['select'])) {
			$this->db->select($param['select']);
		}

		//Table
		if(isset($param['table']) && !empty($param['table'])){
			$this->db->from($param['table']);
		}

		//Join table with table
		if(isset($param['join']) && !empty($param['join'])){
		    if(sizeof($param['join']) == 3){
                $this->db->join($param['join']['table'], $param['join']['where'], $param['join']['type_join']);
            }else{
                $this->db->join($param['join']['table'], $param['join']['where']);
            }
		}

		//Join table with more table
		if(isset($param['joins']) && !empty($param['joins'])){
			foreach ($param['joins'] as $key => $table) {
                if(sizeof($table) == 3){
                    $this->db->join($table['table'], $table['where'], $table['type_join']);
                }else{
                    $this->db->join($table['table'], $table['where']);
                }
			}
		}

		//Where String
		if(isset($param['param']) && !empty($param['param'])){
			$this->db->where($param['param']);
		}

		//Where Array
		if(isset($param['param_where']) && is_array($param['param_where'])){
			$this->db->where($param['param_where']);
		}

		//Or Where Array
		if(isset($param['param_where_or']) && is_array($param['param_where_or'])){
			$this->db->or_where($param['param_where_or']);
		}

		//Where In
		if(isset($param['field_where_in']) && !empty($param['field_where_in']) && isset($param['param_where_in']) && is_array($param['param_where_in'])){
			$this->db->where_in($param['field_where_in'], $param['param_where_in']);
		}
		//Where Not In
		if(isset($param['field_where_not_in']) && !empty($param['field_where_not_in']) && isset($param['param_where_not_in']) && is_array($param['param_where_not_in'])){
			$this->db->where_not_in($param['field_where_not_in'], $param['param_where_not_in']);
		}

		if(!empty($param['having'])){
		    $this->db->having($param['having']);
        }

		//Like
		if(isset($param['like']) && is_array($param['like'])){
			foreach($param['like'] as $key => $val){
				//$val[0] : row
				//$val[1] : keyword
				//$val[2] : before, after, both, none
				$this->db->like($key, $val[0], isset($val[1])?$val[1]:'');
			}
		}

		//Or_like
		if(isset($param['or_like']) && is_array($param['or_like'])){
			foreach($param['or_like'] as $key => $val){
				//$val[0] : row
				//$val[1] : keyword
				//$val[2] : before, after, both, none
				$this->db->or_like($key, $val[0], isset($val[1])?$val[1]:'');
			}
		}

		//Order by
		if(isset($param['orderby']) && !empty($param['orderby'])){
			$this->db->order_by($param['orderby']);
		}

		//Limit
		if(isset($param['limit']) && (int)$param['limit'] > 0){
			$this->db->limit((int)$param['limit'], (int)$param['start']);
		}
		//Group by
		if(isset($param['groupby']) && is_array($param['groupby'])){
			$this->db->group_by($param['groupby']);
		}

		//Count
		if(isset($param['count']) && $param['count'] == TRUE){
			$data = $this->db->count_all_results();
			$this->db->flush_cache();
			return $data;
		}
		//Return data
		else{
			//List
			if(isset($param['list']) && $param['list'] == TRUE){
				if(isset($param['type']) && $param['type'] == 'object'){
					$data = $this->db->get();
                    if ($data) {
                        $data = $data->result_object();
                    }else{
                        $data = null;
                    }
					$this->db->flush_cache();
					return $data;
				}
				$data = $this->db->get();
                if ($data) {
                    $data = $data->result_array();
                }else{
                    $data = null;
                }
                $this->db->flush_cache();
				return $data;
			}
			//Row
			else{
				if(isset($param['type']) && $param['type'] == 'object'){
					$data = $this->db->get();
					if($data){
                        $data = $data->row_object();
                    }else{
                        $data = null;
                    }
					$this->db->flush_cache();
					return $data;
				}
				$data = $this->db->get();
                if($data){
                    $data = $data->row_array();
                }else{
                    $data = null;
                }
				$this->db->flush_cache();
				return $data;
			}
		}
	}

//	public function query($sql = '')
//	{
//
//		if(empty($sql)) return false;
//		return $this->db->query($sql);
//	}

	//Kết xuất dữ liệu theo sum, avg..v...v..
	public function _operator($param = NULL, $operator = NULL)
	{
		if(isset($param['table']) && !empty($param['table'])){
			$this->db->from($param['table']);
		}

		if(isset($param['param']) && !empty($param['param'])){
			$this->db->where($param['param']);
		}

		if(isset($param['param_where']) && is_array($param['param_where'])){
			$this->db->where($param['param_where']);
		}

		if(isset($operator) && !empty($operator)){
			if($operator == 'max')
				$this->db->select_max($param['col']);

			if($operator == 'min')
				$this->db->select_min($param['col']);

			if($operator == 'avg')
				$this->db->select_avg($param['col']);

			if($operator == 'sum')
				$this->db->select_sum($param['col']);
		}

		$data = $this->db->get();
        if($data){
            $data = $data->row_object();
        }else{
            $data = null;
        }
		$this->db->flush_cache();

		return $data;
	}

	//Cập nhật dữ liệu
	public function _save($param = NULL, $has_time = false){

		$flag = 0;

		$time = gmdate('Y-m-d H:i:s', time() + 7*3600);

		$data = $param['data'];

		if(isset($param['param']) && !empty($param['param'])){
			$this->db->where($param['param']);
			$flag = $flag = + 1;
		}

		if(isset($param['param_where']) && is_array($param['param_where'])){
			$this->db->where($param['param_where']);
			$flag = $flag = + 1;
		}

		if(isset($param['field_where_in']) && !empty($param['field_where_in']) && isset($param['param_where_in']) && is_array($param['param_where_in'])){
			$this->db->where_in($param['field_where_in'], $param['param_where_in']);
			$flag = $flag = + 1;
		}
		//Insert dữ liệu mới
		if($flag == 0){

		    if ($has_time){
                $data['created'] = $time;
            }

			$this->db->insert($param['table'], $data);

			$insert_id = $this->db->insert_id();

			$this->db->flush_cache();

			return $insert_id;
		}
		//Update dữ liệu mới
		else{

            if ($has_time){
                $data['updated'] = $time;
            }

			$this->db->set($data);

			$this->db->update($param['table']);

			$affected_rows = $this->db->affected_rows();

			$this->db->flush_cache();

			return $affected_rows;
		}
	}

	//Cập nhật nhiều dữ liệu
	public function _saveBatch($param = NULL){

		$data = $param['data'];

		if(!isset($param['field']))
			$this->db->insert_batch($param['table'], $data);
		else
			$this->db->update_batch($param['table'], $data, $param['field']);

		$affected_rows = $this->db->affected_rows();

		$this->db->flush_cache();

		return $affected_rows;
	}

	//Xóa Dữ Liệu
	public function _Del($param = NULL){
		$flag = 0;
		if(isset($param['param']) && !empty($param['param'])){
			$this->db->where($param['param']);
			$flag = $flag = + 1;
		}
		if(isset($param['param_where']) && is_array($param['param_where'])){
			$this->db->where($param['param_where']);
			$flag = $flag = + 1;
		}
		if(isset($param['field_where_in']) && !empty($param['field_where_in']) && isset($param['param_where_in']) && is_array($param['param_where_in'])){
			$this->db->where_in($param['field_where_in'], $param['param_where_in']);
			$flag = $flag = + 1;
		}
		//Like
		if(isset($param['like']) && is_array($param['like'])){
			foreach($param['like'] as $key => $val){
				//$val[0] : row
				//$val[1] : keyword
				//$val[2] : before, after, both, none
				$this->db->like($key, $val[0], isset($val[1])?$val[1]:'');
			}
		}
		if($flag > 0){
			$this->db->delete($param['table']);
			$affected_rows = $this->db->affected_rows();
			$this->db->flush_cache();
			return $affected_rows;
		}
		return 0;
	}

	//Get 1 trường Dữ Liệu dùng chung
	public function find($type = 'object')
	{
		return $this->_general(array(
			'select'	  => $this->select,
			'table'       => $this->table,
			'type'        => $type,
		));
	}

	public function find_where($where = array(), $params = array(), $type = '')
	{
		$param = array(
			'select'  	=> $this->select,
			'table'   	=> $this->table,
			'type'    	=> $type,
		);

		$params = array_replace($param, $params);

		if(is_array($where)) $params['param_where'] = $where;
		else $params['param'] = $where;

		return $this->_general($params);
	}

	public function gets($params = array())
	{

		$param = array(
			'select'  	=> $this->select,
			'table'   	=> $this->table,
			'type'    	=> 'object',
			'list'    	=> true,
			'orderby' 	=> 'created',
			'limit' 	=> 0,
			'start' 	=> 0
		);

		$params = array_merge($param, $params);

		return $this->_general($params);
	}

	public function gets_where($where= array(), $params = array())
	{
		$param = array(
			'select'  	=> $this->select,
			'table'   	=> $this->table,
			'type'    	=> 'object',
			'list'    	=> true,
			'orderby' 	=> 'order, created desc',
			'limit' 	=> 0,
			'start' 	=> 0
		);

		$params = array_merge($param, $params);
		if(is_array($where)) $params['param_where'] = $where;
		else $params['param'] = $where;

		return $this->_general($params);
	}

	public function gets_where_in($data = array(), $where= array(), $params = array())
	{
		if($data['data'] == null || count($data['data']) == 0)
			return null;
		$param = array(
			'select'  	=> $this->select,
			'table'   	=> $this->table,
			'type'    	=> 'object',
			'list'    	=> true,
			'orderby' 	=> 'created',
			'limit' 	=> 0,
			'start' 	=> 0
		);

		$params = array_merge($param, $params);

		if(is_array($where)) $params['param_where'] = $where;
		else $params['param'] = $where;

		$params['field_where_in'] = $data['field'];
		$params['param_where_in'] = $data['data'];

		return $this->_general($params);
	}

	public function gets_where_notin($data = array(), $where= array(), $params = array())
	{
		$param = array(
			'select'  	=> $this->select,
			'table'   	=> $this->table,
			'type'    	=> 'object',
			'list'    	=> true,
			'orderby' 	=> 'created',
			'limit' 	=> 0,
			'start' 	=> 0
		);

		$params = array_merge($param, $params);

		if(is_array($where)) $params['param_where'] = $where;
		else $params['param'] = $where;

		$params['field_where_not_in'] = $data['field'];
		$params['param_where_not_in'] = $data['data'];

		return $this->_general($params);
	}

	public function gets_where_like($data = array(), $where= array(), $params = array())
	{
		$param = array(
			'select'  	=> $this->select,
			'table'   	=> $this->table,
			'type'    	=> 'object',
			'list'    	=> true,
			'orderby' 	=> 'created',
			'limit' 	=> 0,
			'start' 	=> 0
		);

		$params = array_merge($param, $params);

		if(is_array($where)) $params['param_where'] = $where;
		else $params['param'] = $where;

		//Like
		$params['like']		= $data['like'];

		if(isset($data['or_like']))
			$params['or_like']	= $data['or_like'];

		return $this->_general($params);
	}

	public function gets_where_more($data = array(), $where= array(), $params = array())
	{
		$param = array(
			'select'  	=> $this->select,
			'table'   	=> $this->table,
			'type'    	=> 'object',
			'list'    	=> true,
			'orderby' 	=> 'created',
			'limit' 	=> 0,
			'start' 	=> 0
		);

		$params = array_merge($param, $params);

		if(is_array($where)) $params['param_where'] = $where;
		else $params['param'] = $where;

		//Like
		if(isset($data['like']))
			$params['like']			  = $data['like'];

		//or_like
		if(isset($data['or_like']))
			$params['or_like']	= $data['or_like'];

		//in
		if(isset($data['in'])) {
			$params['field_where_in'] = $data['in']['field'];
			$params['param_where_in'] = $data['in']['data'];
		}

		//not in
		if(isset($data['not_in'])) {
			$params['field_where_not_in'] = $data['not_in']['field'];
			$params['param_where_not_in'] = $data['not_in']['data'];
		}

		return $this->_general($params);
	}

	/*=======================================================================*/

	public function gets_join($where = array(), $params= array())
	{
		$param = array(
			'select'  	=> $this->select,
			'table'   	=> $this->table,
			'type'    	=> 'object',
			'list'    	=> true,
			'orderby' 	=> $this->table.'.order,'.$this->table.'.created',
			'limit' 	=> 0,
			'start' 	=> 0
		);

		$params = array_merge($param, $params);

		foreach ($params['table_join'] as $key => $value) {
			$params['joins'][$key]['table'] = $value['table'];
			$params['joins'][$key]['where'] = $value['where'];
		}

		unset($params['table_join']);

		foreach ($where as $key => $val) {
			if($key == 'where_table_join')
			{
				foreach ($val as $k => $wh) {
					$params['param_where'][$k] = $wh;
				}
			}
			else
				$params['param_where'][$params['table'].'.'.$key] = $val;
		}

		return $this->_general($params);
	}

	public function operatorby($where = array(), $col = NULL, $operator = 'sum')
	{
		return $this->_operator(array(
			'table'       => $this->table,
			'param_where' => $where,
			'col'		  => $col), $operator);
	}

	//Count dữ liệu
	public function count()
	{
		return $this->_general(array(
			'table'       => $this->table,
			'count'       => TRUE
			));
	}

	public function count_where($where = array(), $params = array())
	{
		$param = array(
			'table'   => $this->table,
			'count'       => TRUE
		);

		$param = array_merge($param, $params);

		if(is_array($where)) $param['param_where'] = $where;
		else $param['param'] = $where;

		return $this->_general($param);
	}

	public function count_where_in($data, $where = array())
	{
		$param = array(
			'table'   => $this->table,
			'count'       => TRUE
		);

		if(is_array($where)) $param['param_where'] = $where;
		else $param['param'] = $where;

		$param['field_where_in'] = $data['field'];
		$param['param_where_in'] = $data['data'];

		return $this->_general($param);
	}

	public function count_where_notin($data, $where)
	{
		$param = array(
			'table'   => $this->table,
			'count'       => TRUE
		);

		if(is_array($where)) $param['param_where'] = $where;
		else $param['param'] = $where;

		$param['field_where_not_in'] = $data['field'];
		$param['param_where_not_in'] = $data['data'];

		return $this->_general($param);
	}

	public function count_where_more($data = array(), $where= array())
	{
		$params = array(
			'table'   	=> $this->table,
			'count'       => TRUE
		);

		if(is_array($where)) $params['param_where'] = $where;
		else $params['param'] = $where;

		//Like
		if(isset($data['like']))
			$params['like']			  = $data['like'];

		//or_like
		if(isset($data['or_like']))
			$params['or_like']	= $data['or_like'];

		//in
		if(isset($data['in'])) {
			$params['field_where_in'] = $data['in']['field'];
			$params['param_where_in'] = $data['in']['data'];
		}

		//not in
		if(isset($data['not_in'])) {
			$params['field_where_not_in'] = $data['not_in']['field'];
			$params['param_where_not_in'] = $data['not_in']['data'];
		}

		return $this->_general($params);
	}

	//Cập nhật dữ liệu
	public function add_new($data)
	{
		return $this->_save(array(
			'table' => $this->table,
			'data'  =>  $data));
	}

	public function adds($data)
	{
		return $this->_saveBatch(array(
			'table' => $this->table,
			'data'  =>  $data));
	}

	public function update_where($data = array(), $where = array())
	{
		return $this->_save(array(
			'table'       => $this->table,
			'param_where' => $where,
			'data'        => $data));
	}

	public function updates_where($data = array())
	{
		$param = array(
				'table' => $this->table,
				'data'  => $data['value'],
				'field' => $data['field'],
		);
		return $this->_saveBatch($param);
	}

	//Xóa dữ liệu
	public function delete_where($where)
	{
		return $this->_Del(array(
			'table'       => $this->table,
			'param_where' => $where,
        ));
	}

	public function delete_where_in($data, $where = array())
	{
		return $this->_Del(array(
			'table'       => $this->table,
			'param_where' => $where,
			'field_where_in' => $data['field'],
			'param_where_in' => $data['data'],
		));
	}

	public function delete_where_notin($data, $where = array())
	{
		return $this->_Del(array(
			'table'       => $this->table,
			'param_where' => $where,
			'like' => $data,
		));
	}

	public function delete_where_like($data, $where = array())
	{
		return $this->_Del(array(
			'table'       => $this->table,
			'param_where' => $where,
			'like' => $data,
		));
	}
}