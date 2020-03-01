<?php
#****************************************#
# * @Author: lehieu008                   #
# * @Email: lehieu008@gmail.com          #
# * @Website: http://www.iscvietnam.net  #
# * @Copyright: 2008 - 2009              #
#****************************************#
class CustomLink_model extends MY_Model
{
    function __construct()
    {
        parent::__construct();
        $this->table = "tbtt_custom_link";
        $this->select = "*";
	}

	function get($select = "*", $where = "")
	{
        $this->db->cache_off();
		$this->db->select($select);
		if($where && $where != "")
		{
			$this->db->where($where, NULL, false);
		}
		#Query
		$query = $this->db->get("tbtt_custom_link");
		$result = $query->result();
		$query->free_result();
		return $result;
	}

    function add($data)
	{
		return $this->db->insert("tbtt_custom_link", $data);
	}

	function update($data, $where = "")
	{
    	if($where && $where != "")
    	{
			$this->db->where($where);
    	}
		return $this->db->update("tbtt_custom_link", $data);
	}

	function delete($value, $field = "ads_id", $in = true)
    {
		if($in == true)
		{
			$this->db->where_in($field, $value);
		}
		else
		{
            $this->db->where($field, $value);
		}
		return $this->db->delete("tbtt_custom_link");
	}

    function fetch_join($select = '*', $from = 'tbtt_custom_link', $where = '', $join = array(), $order = '', $by = 'DESC', $start = -1, $limit = 10)
    {
        $this->db->select($select);
        $this->db->from($from);
        if(!empty($join)) {
            foreach ($join as $key => $value) {
                $this->db->join($value['table'], $value['on'], $value['option']);
            }
        }
        if ($where && $where !== '') {
            $this->db->where($where);
        }
        if ($order && $order != "" && $by && ($by == "DESC" || $by == "ASC")) {
            $this->db->order_by($order, $by);
        }
        if ((int)$start >= 0 && $limit && (int)$limit > 0) {
            $this->db->limit($limit, $start);
        }
        $query = $this->db->get();
        $result = $query->result();
        $query->free_result();
        return $result;
    }

    public function shop_gallery_list_link($sho_id, $limit, $start, $owns_id = false, $count = false)
    {
        $where_common = "tbtt_custom_link.sho_id  = ". $sho_id;
        $where_common .= " AND (tbtt_custom_link.type = '".CUSTOMLINK_CONTENT."' OR  tbtt_custom_link.type = '".CUSTOMLINK_COLLECTION. "')";

        $where_collection  = "  tbtt_collection.status      = 1
                                AND tbtt_collection.type    = " . COLLECTION_CUSTOMLINK;

        $where_content  = " tbtt_content.not_status = 1
                    AND tbtt_content.not_publish    = 1
                    AND tbtt_content.id_category    = 16 ";

        $where_permission            = ' AND tbtt_content.not_permission = 1';
        $where_permission_collection = ' AND tbtt_collection.isPublic    = 1';

        if ($owns_id) {
            // neu co mot user dang nhap vao thì get cả tin private của user đó
            $where_permission = ' AND (tbtt_content.not_permission = 1 OR (tbtt_content.not_permission = 6 AND tbtt_content.not_user = '.$owns_id.')) ';
            $where_permission_collection = '';
        }

        $where_content    .= $where_permission;
        $where_collection .= $where_permission_collection;
        //type collection, content, image

        return $this->customlink_model->gets([
            'select'        => 'tbtt_custom_link.*, tbtt_collection.name as collection_name, tbtt_content.not_title, tbtt_content.not_id',
            'param'         => $where_common,
            'orderby'       => 'tbtt_custom_link.id DESC',
            'limit'         => $limit,
            'start'         => $start,
            'count'         => (boolean)$count,
            'joins'         => [
                [
                    'table'     => 'tbtt_content',
                    'where'     => 'tbtt_custom_link.type_id = tbtt_content.not_id AND tbtt_custom_link.type = "'.CUSTOMLINK_CONTENT.'" AND '. $where_content,
                    'type_join' => 'LEFT'
                ],
                [
                    'table'     => 'tbtt_collection',
                    'where'     => 'tbtt_custom_link.type_id = tbtt_collection.id AND tbtt_custom_link.type = "'.CUSTOMLINK_COLLECTION.'"' . ($where_collection ? ' AND' . $where_collection : ''),
                    'type_join' => 'LEFT'
                ],
                [
                    'table'     => 'tbtt_permission',
                    'where'     => 'tbtt_permission.id = tbtt_content.not_permission',
                    'type_join' => 'LEFT'
                ]
            ]
        ]);
    }

    public function personal_gallery_list_link($user_id, $limit, $start, $owns_id = false, $count = false)
    {
        $where_common = "tbtt_custom_link.user_id  = ". $user_id . " AND ( tbtt_custom_link.sho_id IS NULL OR tbtt_custom_link.sho_id = 0) ";
        $where_common .= " AND (tbtt_custom_link.type = '".CUSTOMLINK_CONTENT."' OR  tbtt_custom_link.type = '".CUSTOMLINK_COLLECTION. "')";

        $where_collection  = "  tbtt_collection.status      = 1
                                AND tbtt_collection.type    = " . COLLECTION_CUSTOMLINK;

        $where_content  = " tbtt_content.not_status = 1
                    AND tbtt_content.not_publish    = 1
                    AND tbtt_content.id_category    = 16 ";

        $where_permission            = ' AND tbtt_content.not_permission = 1';
        $where_permission_collection = ' AND tbtt_collection.isPublic    = 1';

        if ($owns_id) {
            // neu co mot user dang nhap vao thì get cả tin private của user đó
            $where_permission = ' AND (tbtt_content.not_permission = 1 OR (tbtt_content.not_permission = 6 AND tbtt_content.not_user = '.$user_id.')) ';
            $where_permission_collection = '';
        }

        $where_content    .= $where_permission;
        $where_collection .= $where_permission_collection;
        //type collection, content, image

        return $this->gets([
            'select'        => 'tbtt_custom_link.*, tbtt_collection.name as collection_name, tbtt_content.not_title, tbtt_content.not_id',
            'param'         => $where_common,
            'orderby'       => 'tbtt_custom_link.id DESC',
            'limit'         => $limit,
            'start'         => $start,
            'count'         => (boolean)$count,
            'joins'         => [
                [
                    'table'     => 'tbtt_content',
                    'where'     => 'tbtt_custom_link.type_id = tbtt_content.not_id AND tbtt_custom_link.type = "'.CUSTOMLINK_CONTENT.'" AND '. $where_content,
                    'type_join' => 'LEFT'
                ],
                [
                    'table'     => 'tbtt_collection',
                    'where'     => 'tbtt_custom_link.type_id = tbtt_collection.id AND tbtt_custom_link.type = "'.CUSTOMLINK_COLLECTION.'"' . ($where_collection ? ' AND' . $where_collection : ''),
                    'type_join' => 'LEFT'
                ],
                [
                    'table'     => 'tbtt_permission',
                    'where'     => 'tbtt_permission.id = tbtt_content.not_permission',
                    'type_join' => 'LEFT'
                ]
            ]
        ]);
    }

    public function get_link_of_shop($shop_id, $link_id, $is_owner = false)
    {
        if(!$shop_id || !$link_id){
            return null;
        }

        $where = 'tbtt_custom_link.id ='.$link_id . ' AND tbtt_custom_link.sho_id ='.$shop_id;

        if(!$is_owner){
            $where .= ' AND status = 1';
        }

        return $this->find_where($where);
    }

    public function get_link_of_user($user_id, $link_id, $is_owner = false)
    {
        if(!$user_id || !$link_id){
            return null;
        }

        $where = 'tbtt_custom_link.id ='.$link_id . ' AND tbtt_custom_link.sho_id = 0 AND tbtt_custom_link.user_id ='.$user_id;

        if(!$is_owner){
            $where .= ' AND status = 1';
        }

        return $this->find_where($where);
    }

    public function custom_links_of_collection($colection_ids, $shop_id = 0, $user_id = 0, $link_id_expel = 0, $is_owner = false, $limit = 15, $start = 0, $count = false)
    {
        if(!$colection_ids ||(!$shop_id && !$user_id))
            return [];

        if (is_array($colection_ids)){
            $where = 'tbtt_collection_link.cl_coll_id IN ('.implode($colection_ids, ',') . ')';
        }else{
            $where = 'tbtt_collection_link.cl_coll_id = '.$colection_ids;
        }

        if(!$is_owner){
            $where .= ' AND tbtt_custom_link.status = 1';
        }

        if($shop_id){
            $where .= ' AND tbtt_custom_link.sho_id ='.$shop_id;
        }else{
            $where .= ' AND tbtt_custom_link.user_id ='.$user_id. ' AND tbtt_custom_link.sho_id = 0' ;
        }

        if($link_id_expel){
            $where .= ' AND tbtt_custom_link.id != '.$link_id_expel;
        }

        return $this->gets([
            'select'        => 'distinct tbtt_custom_link.id, tbtt_custom_link.*',
            'param'         => $where,
            'orderby'       => 'tbtt_custom_link.id DESC',
            'limit'         => $limit,
            'start'         => $start,
            'count'         => (boolean)$count,
            'type'          => 'array',
            'joins'         => [
                [
                    'table'     => 'tbtt_collection_link',
                    'where'     => 'tbtt_collection_link.cl_customLink_id = tbtt_custom_link.id',
                    'type_join' => 'LEFT'
                ]
            ]
        ]);

    }

    public function custom_link_of_news($new_id, $shop_id = 0, $user_id = 0, $link_id_expel = 0, $is_owner = false, $limit = 15, $start = 0, $count = false)
    {
        if(!$new_id ||(!$shop_id && !$user_id))
            return [];

        $where = 'tbtt_custom_link.type = "content" AND tbtt_custom_link.type_id = '.$new_id;

        if(!$is_owner){
            $where .= ' AND tbtt_custom_link.status = 1';
        }

        if($user_id){
            $where .= ' AND tbtt_content.not_user ='. $user_id;
        }

        if($shop_id){
            $where .= ' AND tbtt_content.sho_id ='.$shop_id;
        }

        if($link_id_expel){
            $where .= ' AND tbtt_custom_link.id != '.$link_id_expel;
        }
        return $this->gets([
            'select'        => 'tbtt_custom_link.*',
            'param'         => $where,
            'orderby'       => 'tbtt_custom_link.id DESC',
            'limit'         => $limit,
            'start'         => $start,
            'count'         => (boolean)$count,
            'type'          => 'array',
            'joins'         => [
                [
                    'table'     => 'tbtt_content',
                    'where'     => 'tbtt_custom_link.type_id = tbtt_content.not_id AND tbtt_custom_link.type = "content"',
                    'type_join' => 'LEFT'
                ]
            ]
        ]);

    }


}