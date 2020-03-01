<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Content_image_link_model extends MY_Model
{
    protected static $fillable = [
        'link_id',
        'content_image_id',
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
        $this->table = "tbtt_content_image_links";
        $this->select = "*";
    }

    public function find_link_by_id($id, $is_owner = true)
    {
        if(!$id)
            return [];

        $sql = 'SELECT image.id,
                       "tbtt_content_image_links" AS `type_tbl`,
                       image.user_id,
                       image.sho_id,
                       image.cate_link_id,
                       image.content_id,
                       image.show_in_library,
                       image.title,
                       image.description,
                       image.image,
                       image.img_width,
                       image.img_height,
                       image.mime,
                       image.video,
                       image.orientation,
                       image.is_public,
                       image.created_at,
                       link.id AS `link_id`,
                       link.title AS `link_title`,
                       link.description AS `link_description`,
                       link.image AS `link_image`,
                       link.img_width AS `link_img_width`,
                       link.img_height AS `link_img_height`,
                       link.host,
                       link.link
                FROM tbtt_content_image_links AS image 
                LEFT JOIN tbtt_links AS link ON image.link_id = link.id
                WHERE image.id ='.$id. (!$is_owner ? ' AND image.is_public = 1' : '');

        return ($result = $this->db->query($sql)) ? $result->row_array() : null;
    }

    public function links_of_collection($colection_ids, $shop_id = 0, $user_id = 0, $link_id_expel = 0, $is_owner = false)
    {
        if (!$colection_ids || !is_array($colection_ids) || (!$shop_id && !$user_id))
            return [];

        $where = '';

        if (!$is_owner) {
            $where .= ' AND image.is_public = 1';
        }

        if ($shop_id) {
            $where .= ' AND image.sho_id =' . $shop_id;
        } else {
            $where .= ' AND image.user_id =' . $user_id . ' AND image.sho_id = 0';
        }

        if ($link_id_expel) {
            $where .= ' AND image.id != ' . $link_id_expel;
        }

        $sql = 'SELECT image.id,
                       "tbtt_content_image_links" AS `type_tbl`,
                       image.user_id,
                       image.sho_id,
                       image.cate_link_id,
                       image.content_id,
                       image.title,
                       image.description,
                       image.image,
                       image.img_width,
                       image.img_height,
                       image.mime,
                       image.video,
                       image.orientation,
                       image.is_public,
                       image.created_at,
                       link.id AS `link_id`,
                       link.title AS `link_title`,
                       link.description AS `link_description`,
                       link.image AS `link_image`,
                       link.img_width AS `link_img_width`,
                       link.img_height AS `link_img_height`,
                       link.link,
                       link.host
                FROM tbtt_content_image_links AS image 
                LEFT JOIN tbtt_links AS link ON image.link_id = link.id
                WHERE image.id IN (
                  SELECT DISTINCT content_image_link_id FROM tbtt_collection_content_image_links WHERE collection_id IN ('.implode($colection_ids, ',').')
                ) '. $where . ' LIMIT 30';

        $result = $this->db->query($sql);
        return $result ? $result->result_array() : null;
    }

    public function link_of_news($new_id, $image_id = 0, $link_id_expel = 0, $is_owner = false, $order_by = 'ASC')
    {
        if (!$new_id)
            return [];

        $where = 'image.content_id = ' . $new_id;

        if (!$is_owner) {
            $where .= ' AND image.is_public = 1';
        }

        if ($link_id_expel) {
            $where .= ' AND image.id != ' . $link_id_expel;
        }

        if ($image_id) {
            $where .= ' AND image.content_image_id = ' . $image_id;
        }

        $sql = 'SELECT image.id,
                       "tbtt_content_image_links" AS `type_tbl`,
                       image.user_id,
                       image.sho_id,
                       image.cate_link_id,
                       image.content_id,
                       image.content_image_id,
                       image.title,
                       image.description,
                       image.image,
                       image.img_width,
                       image.img_height,
                       image.mime,
                       image.video,
                       image.orientation,
                       image.is_public,
                       image.created_at,
                       link.id AS `link_id`,
                       link.title AS `link_title`,
                       link.description AS `link_description`,
                       link.image AS `link_image`,
                       link.img_width AS `link_img_width`,
                       link.img_height AS `link_img_height`,
                       link.link,
                       link.host
                FROM tbtt_content_image_links AS image 
                LEFT JOIN tbtt_links AS link ON image.link_id = link.id
                WHERE '. $where . ' 
                ORDER BY image.created_at '. $order_by;

        return ($result = $this->db->query($sql)) ? $result->result_array() : null;
    }

    public function link_same_category($cat_id, $shop_id = 0, $user_id = 0, $link_id_expel = 0, $is_owner = false)
    {
        if(!$cat_id || (!$shop_id && !$user_id))
            return [];

        $where = 'image.cate_link_id = '. $cat_id;

        if (!$is_owner) {
            $where .= ' AND image.is_public = 1';
        }

        if($shop_id){
            $where .= ' AND image.sho_id = '. $shop_id;
        }else{
            $where .= ' AND image.user_id = '. $user_id . ' AND image.sho_id = 0';
        }

        if ($link_id_expel) {
            $where .= ' AND image.id != '. $link_id_expel;
        }

        $sql = 'SELECT image.id,
                       "tbtt_content_image_links" AS `type_tbl`,
                       image.user_id,
                       image.sho_id,
                       image.cate_link_id,
                       image.content_id,
                       image.title,
                       image.description,
                       image.image,
                       image.img_width,
                       image.img_height,
                       image.mime,
                       image.video,
                       image.orientation,
                       image.is_public,
                       image.created_at,
                       link.id AS `link_id`,
                       link.title AS `link_title`,
                       link.description AS `link_description`,
                       link.image AS `link_image`,
                       link.img_width AS `link_img_width`,
                       link.img_height AS `link_img_height`,
                       link.link,
                       link.host
                FROM tbtt_content_image_links AS image 
                LEFT JOIN tbtt_links AS link ON image.link_id = link.id
                WHERE '. $where . ' LIMIT 30';

        $result = $this->db->query($sql);
        return $result ? $result->result_array() : null;
    }

}