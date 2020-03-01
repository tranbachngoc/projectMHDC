<?php defined('BASEPATH') or exit('No direct script access allowed');

class Collection_content_link_model extends MY_Model
{

    function __construct()
    {
        parent::__construct();
        $this->select = "*";
        $this->table  = 'tbtt_collection_content_links';
    }

    public function delete_link_in_collection_by($link_id ,$shop_id = 0, $user_id = 0)
    {
        if(!$link_id || (!$shop_id && !$user_id))
        return false;

        $sql = 'DELETE tbtt_collection_content_links
                FROM tbtt_collection_content_links LEFT JOIN tbtt_collection ON tbtt_collection.id = tbtt_collection_content_links.collection_id ';
        $where = 'WHERE tbtt_collection_content_links.content_link_id = '.$link_id;
        if($shop_id){
            $where .= ' AND tbtt_collection.sho_id ='.$shop_id;
        }else{
            $where .= ' AND tbtt_collection.user_id ='.$user_id;
        }

        $this->db->query($sql . $where);

        return $this->db->affected_rows();
    }

    /**
     * @param $link_id
     * @param int $shop_id
     * @param int $user_id
     * @param int $collection_type
     * @return array
     * get all collections of library link id
     */
    public function link_belong_to_many_collections($link_id, $shop_id = 0, $user_id = 0, $is_owner = false)
    {
        if (!$link_id)
            return [];

        $where = 'tbtt_collection_content_links.content_link_id =' .$link_id.  ' AND tbtt_collection.type = ' . COLLECTION_CUSTOMLINK;

        if(!$is_owner){
            $where .= ' AND tbtt_collection.isPublic = 1';
        }
        //lấy collection của cá nhân hoặc shop
        if (!empty($shop_id)) {
            $where .= ' AND tbtt_collection.sho_id = '.$shop_id.'';
        }else{
            $where .= ' AND tbtt_collection.user_id = '.$user_id.' AND tbtt_collection.sho_id = 0';
        }

        return $this->gets([
            'select'    => 'tbtt_collection.*',
            'param'     => $where,
            'type'      => 'array',
            'orderby'   => '',
            'joins'         => [
                [
                    'table'     => 'tbtt_collection',
                    'where'     => 'tbtt_collection.id = tbtt_collection_content_links.collection_id',
                    'type_join' => 'LEFT'
                ],
            ]
        ]);
    }
}

/* End of file Collection_model.php */

?>