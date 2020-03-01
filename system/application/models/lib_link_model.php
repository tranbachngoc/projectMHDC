<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lib_link_model extends MY_Model
{
    protected static $fillable = [
        'link_id',
        'user_id',
        'sho_id',
        'cate_link_id',
        'title',
        'description',
        'image',
        'video',
        'img_width',
        'img_height',
        'mime',
        'orientation',
        'is_public',
        'created_at',
        'updated_at',
    ];

    function __construct()
    {
        parent::__construct();
        $this->table = "tbtt_lib_links";
        $this->select = "*";
    }

    public function find_link_by_id($id, $is_owner = true)
    {
        if(!$id)
            return [];

        $sql = 'SELECT library.id,
                       "tbtt_lib_links" AS `type_tbl`,
                       library.user_id,
                       library.sho_id,
                       library.cate_link_id,
                       0 AS "content_id",
                       library.title,
                       library.description,
                       library.image,
                       library.img_width,
                       library.img_height,
                       library.mime,
                       library.video,
                       library.orientation,
                       library.is_public,
                       library.created_at,
                       link.id AS `link_id`,
                       link.title AS `link_title`,
                       link.description AS `link_description`,
                       link.image AS `link_image`,
                       link.img_width AS `link_img_width`,
                       link.img_height AS `link_img_height`,
                       link.link,
                       link.host
                FROM tbtt_lib_links AS library 
                LEFT JOIN tbtt_links AS link ON library.link_id = link.id
                WHERE library.id ='.$id. (!$is_owner ? ' AND library.is_public = 1' : '');

        return ($result = $this->db->query($sql)) ? $result->row_array() : null;
    }

    public function links_of_collection($colection_ids, $shop_id = 0, $user_id = 0, $link_id_expel = 0, $is_owner = false)
    {
        if (!$colection_ids || !is_array($colection_ids) || (!$shop_id && !$user_id))
            return [];

        $where = '';

        if (!$is_owner) {
            $where .= ' AND library.is_public = 1';
        }

        if ($shop_id) {
            $where .= ' AND library.sho_id =' . $shop_id;
        } else {
            $where .= ' AND library.user_id =' . $user_id . ' AND library.sho_id = 0';
        }

        if ($link_id_expel) {
            $where .= ' AND library.id != ' . $link_id_expel;
        }

        $sql = 'SELECT library.id,
                       "tbtt_lib_links" AS `type_tbl`,
                       library.user_id,
                       library.sho_id,
                       library.cate_link_id,
                       library.title,
                       library.description,
                       library.image,
                       library.img_width,
                       library.img_height,
                       library.mime,
                       library.video,
                       library.orientation,
                       library.is_public,
                       library.created_at,
                       link.id AS `link_id`,
                       link.title AS `link_title`,
                       link.description AS `link_description`,
                       link.image AS `link_image`,
                       link.img_width AS `link_img_width`,
                       link.img_height AS `link_img_height`,
                       link.link,
                       link.host
                FROM tbtt_lib_links AS library 
                LEFT JOIN tbtt_links AS link ON library.link_id = link.id
                WHERE library.id IN (
                  SELECT DISTINCT lib_link_id FROM tbtt_collection_lib_links WHERE collection_id IN ('.implode($colection_ids, ',').')
                ) '. $where . ' LIMIT 30';

        $result = $this->db->query($sql);
        return $result ? $result->result_array() : null;
    }

    public function link_same_category($cat_id, $shop_id = 0, $user_id = 0, $link_id_expel = 0, $is_owner = false)
    {
        if(!$cat_id || (!$shop_id && !$user_id))
            return [];

        $where = 'library.cate_link_id = '. $cat_id;

        if (!$is_owner) {
            $where .= ' AND library.is_public = 1';
        }

        if($shop_id){
            $where .= ' AND library.sho_id = '. $shop_id;
        }else{
            $where .= ' AND library.user_id = '. $user_id . ' AND library.sho_id = 0';
        }

        if ($link_id_expel) {
            $where .= ' AND library.id != '. $link_id_expel;
        }

        $sql = 'SELECT library.id,
                       "tbtt_lib_links" AS `type_tbl`,
                       library.user_id,
                       library.sho_id,
                       library.cate_link_id,
                       library.title,
                       library.description,
                       library.image,
                       library.img_width,
                       library.img_height,
                       library.mime,
                       library.video,
                       library.orientation,
                       library.is_public,
                       library.created_at,
                       link.id AS `link_id`,
                       link.title AS `link_title`,
                       link.description AS `link_description`,
                       link.image AS `link_image`,
                       link.img_width AS `link_img_width`,
                       link.img_height AS `link_img_height`,
                       link.link,
                       link.host
                FROM tbtt_lib_links AS library 
                LEFT JOIN tbtt_links AS link ON library.link_id = link.id
                WHERE '. $where . ' LIMIT 30';

        $result = $this->db->query($sql);
        return $result ? $result->result_array() : null;
    }


}