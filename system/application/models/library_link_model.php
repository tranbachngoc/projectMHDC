<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
#****************************************#
# * @Author: lehieu008                   #
# * @Email: lehieu008@gmail.com          #
# * @Website: http://www.iscvietnam.net  #
# * @Copyright: 2008 - 2009              #
#****************************************#
class Library_link_model extends MY_Model
{
    protected static $fillable = [
        'user_id',
        'sho_id',
        'custom_link_id',
        'category_link_id',
        'status',
        'title',
        'description',
        'detail',
        'image',
        'image_path',
        'video_path',
        'image_width',
        'image_height',
        'media_type',
        'save_link',
        'host',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by',
    ];

    function __construct()
    {
        parent::__construct();
        $this->table = "tbtt_library_links";
        $this->select = "*";
	}

    /**
     * @param $sho_id
     * @param mixed $cat_id
     * @param $limit
     * @param $start
     * @param int $owner_id
     * @param bool $count
     * @return array
     */
    public function shop_gallery_list_link($sho_id, $cat_id = '', $limit, $start, $owner_id = 0, $count = false)
    {
        if(empty($sho_id))
            return [];

        $where = "tbtt_library_links.sho_id  = ". $sho_id;

        //nếu ko phải chủ shop hay nv shop thì chỉ hiển thị link public
        if(!$owner_id){
            $where .= ' AND tbtt_library_links.status = 1';
        }

        if($cat_id && (is_string($cat_id) || is_numeric($cat_id))){
            $where .= ' AND tbtt_library_links.category_link_id ='.$cat_id;
        }

        if($cat_id && is_array($cat_id)){
            $where .= ' AND tbtt_library_links.category_link_id IN ('.implode($cat_id, ",").')';
        }

        return $this->gets([
            'select'        => 'tbtt_library_links.*',
            'param'         => $where,
            'orderby'       => 'tbtt_library_links.id DESC',
            'limit'         => $limit,
            'start'         => $start,
            'count'         => (boolean)$count,
            'type'          => 'array',
        ]);
    }

    public function get_category_ids_by_shop($sho_id)
    {
        if(!$sho_id)
            return [];

        $sql = 'SELECT distinct category_link_id FROM tbtt_library_links WHERE category_link_id IS NOT NULL AND status = 1 AND sho_id ='. (int)$sho_id;
        return $this->db->query($sql)->result_array();
    }

    public function get_category_ids_by_user($user_id)
    {
        if(!$user_id)
            return [];
        $sql = 'SELECT distinct category_link_id FROM tbtt_library_links WHERE category_link_id IS NOT NULL AND status = 1 AND sho_id = 0 AND user_id = '. (int)$user_id;
        return $this->db->query($sql)->result_array();
    }

    public function user_gallery_list_link($user_id, $cat_id = '', $limit, $start, $owner_id = 0, $count = false)
    {
        if(empty($user_id))
            return [];

        $where = "tbtt_library_links.sho_id = 0 AND tbtt_library_links.user_id = ". $user_id;

        //nếu ko phải chủ shop hay nv shop thì chỉ hiển thị link public
        if(!$owner_id){
            $where .= ' AND tbtt_library_links.status = 1';
        }

        if($cat_id && (is_string($cat_id) || is_numeric($cat_id))){
            $where .= ' AND tbtt_library_links.category_link_id ='.$cat_id;
        }

        if($cat_id && is_array($cat_id)){
            $where .= ' AND tbtt_library_links.category_link_id IN ('.implode($cat_id, ",").')';
        }

        return $this->gets([
            'select'        => 'tbtt_library_links.*',
            'param'         => $where,
            'orderby'       => 'tbtt_library_links.id DESC',
            'limit'         => $limit,
            'start'         => $start,
            'count'         => (boolean)$count,
            'type'          => 'array',
        ]);
    }

    public function info_link($id, $params = [])
    {
        return $this->find_where(['id' => $id], $params);
    }

    /**
     * @param $data
     * pass column save database
     */
    public function pass_column($data)
    {
        if(empty($data)){
            return self::$fillable;
        }
        foreach ($data as $field => $val) {
            if(!in_array($field, self::$fillable)){
                unset($data[$field]);
            }
        }
        return $data;
    }

    public function get_link_of_shop($shop_id, $link_id, $is_owner = false)
    {
        if(!$shop_id || !$link_id){
            return null;
        }

        $where = 'tbtt_library_links.id ='.$link_id . ' AND tbtt_library_links.sho_id ='.$shop_id;

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

        $where = 'tbtt_library_links.id ='.$link_id . ' AND tbtt_library_links.sho_id = 0 AND tbtt_library_links.user_id ='.$user_id;

        if(!$is_owner){
            $where .= ' AND status = 1';
        }

        return $this->find_where($where);
    }

    public function link_of_news($new_id, $shop_id = 0, $user_id = 0, $link_id_expel = 0, $is_owner = false, $limit = 15, $start = 0, $count = false)
    {
        if(!$new_id ||(!$shop_id && !$user_id))
            return [];

        $where = 'tbtt_library_links.not_id = '.$new_id;

        if(!$is_owner){
            $where .= ' AND tbtt_library_links.status = 1';
        }

        if($user_id){
            $where .= ' AND tbtt_content.not_user ='. $user_id;
        }

        if($shop_id){
            $where .= ' AND tbtt_content.sho_id ='.$shop_id;
        }

        if($link_id_expel){
            $where .= ' AND tbtt_library_links.id != '.$link_id_expel;
        }

        return $this->gets([
            'select'        => 'tbtt_library_links.*',
            'param'         => $where,
            'orderby'       => 'tbtt_library_links.id DESC',
            'limit'         => $limit,
            'start'         => $start,
            'count'         => (boolean)$count,
            'type'          => 'array',
            'joins'         => [
                [
                    'table'     => 'tbtt_content',
                    'where'     => 'tbtt_library_links.not_id = tbtt_content.not_id',
                    'type_join' => 'LEFT'
                ]
            ]
        ]);

    }

    public function link_same_category($cat_id, $shop_id = 0, $user_id = 0, $link_id_expel = 0, $is_owner = false, $limit = 15, $start = 0, $count = false)
    {
        if(!$cat_id ||(!$shop_id && !$user_id))
            return [];

        $where = 'tbtt_library_links.category_link_id = '.$cat_id;

        if(!$is_owner){
            $where .= ' AND tbtt_library_links.status = 1';
        }

        if($shop_id){
            $where .= ' AND tbtt_library_links.sho_id ='.$shop_id;
        }else{
            $where .= ' AND tbtt_library_links.user_id ='.$user_id . ' AND tbtt_library_links.sho_id = 0';
        }

        if($link_id_expel){
            $where .= ' AND tbtt_library_links.id != '.$link_id_expel;
        }

        return $this->gets([
            'select'        => 'tbtt_library_links.*',
            'param'         => $where,
            'orderby'       => 'tbtt_library_links.id DESC',
            'limit'         => $limit,
            'start'         => $start,
            'count'         => (boolean)$count,
            'type'          => 'array',
        ]);

    }

    public function links_of_collection($colection_ids, $shop_id = 0, $user_id = 0, $link_id_expel = 0, $is_owner = false, $limit = 15, $start = 0, $count = false)
    {
        if(!$colection_ids ||(!$shop_id && !$user_id))
            return [];

        if (is_array($colection_ids)){
            $where = 'tbtt_collection_link.cl_coll_id IN ('.implode($colection_ids, ',') . ')';
        }else{
            $where = 'tbtt_collection_link.cl_coll_id = '.$colection_ids;
        }

        if(!$is_owner){
            $where .= ' AND tbtt_library_links.status = 1';
        }

        if($shop_id){
            $where .= ' AND tbtt_library_links.sho_id ='.$shop_id;
        }else{
            $where .= ' AND tbtt_library_links.user_id ='.$user_id. ' AND tbtt_library_links.sho_id = 0' ;
        }

        if($link_id_expel){
            $where .= ' AND tbtt_library_links.id != '.$link_id_expel;
        }

        return $this->gets([
            'select'        => 'distinct tbtt_library_links.id, tbtt_library_links.*',
            'param'         => $where,
            'orderby'       => 'tbtt_library_links.id DESC',
            'limit'         => $limit,
            'start'         => $start,
            'count'         => (boolean)$count,
            'type'          => 'array',
            'joins'         => [
                [
                    'table'     => 'tbtt_collection_link',
                    'where'     => 'tbtt_collection_link.library_link_id = tbtt_library_links.id',
                    'type_join' => 'LEFT'
                ]
            ]
        ]);

    }
}