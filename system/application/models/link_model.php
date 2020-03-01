<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Link_model extends MY_Model
{
    protected static $fillable = [
        'link',
        'title',
        'description',
        'image',
        'host',
        'img_width',
        'img_height',
        'added_at'
    ];

    function __construct()
    {
        parent::__construct();
        $this->table = "tbtt_links";
        $this->select = "*";
    }

    public function gallery_link_new($limit = 21, $start = 0, $order_by = 'DESC')
    {
        $sql = 'SELECT
                tmp.id,
                tmp.type_tbl,
                tmp.link_id,
                tmp.user_id,
                tmp.sho_id,
                tmp.cate_link_id,
                tmp.title,
                tmp.description,
                tmp.image,
                tmp.video,
                tmp.img_width,
                tmp.img_height,
                tmp.orientation,
                tmp.is_public,
                l.title as link_title,
                l.description as link_description,
                l.image as link_image,
                l.img_width as link_img_width,
                l.img_height as link_img_height,
                l.link,
                l.host
            FROM (
                SELECT id, "tbtt_lib_links" AS type_tbl, title, description, img_width, img_height, orientation, image, video, cate_link_id, link_id, user_id, sho_id, is_public, created_at, updated_at FROM tbtt_lib_links
                UNION
                SELECT id, "tbtt_content_links" AS type_tbl, title, description, img_width, img_height, orientation, image, video, cate_link_id, link_id, user_id, sho_id, is_public, created_at, updated_at FROM tbtt_content_links WHERE show_in_library = 1
                UNION 
                SELECT id, "tbtt_content_image_links" AS type_tbl, title, description, img_width, img_height, orientation, image, video, cate_link_id, link_id, user_id, sho_id, is_public, created_at, updated_at FROM tbtt_content_image_links WHERE show_in_library = 1
            ) as tmp
            JOIN tbtt_links as l ON tmp.link_id = l.id
            ORDER BY tmp.created_at '. $order_by .'
            LIMIT '. $start .','. $limit;

        return ($result = $this->db->query($sql)) ? $result->result_array() : null;
    }


    /**
     * @param $sho_id
     * @param mixed $cat_id array|int
     * @param $limit
     * @param $start
     * @param int $owner_id
     * @param bool $count
     * @return array
     */
    public function shop_gallery_list_link($sho_id = 0, $user_id = 0, $cat_id = '', $limit = 20, $start = 0, $is_owner = false, $order_by = 'DESC', $count = false)
    {
        $where = '';
        if($sho_id){
            $where = "WHERE sho_id  = ". $sho_id;
        }else if($user_id){
            $where = 'WHERE sho_id = 0 AND user_id ='.$user_id;
        }

        if($cat_id){
            $where .= ($where ? ' AND ' : ' WHERE ');
            if(is_string($cat_id) || is_numeric($cat_id)){
                $where .= ' tmp.cate_link_id = '.$cat_id;
            }

            if(is_array($cat_id)){
                $where .= ' tmp.cate_link_id IN ('.implode($cat_id, ",").')';
            }
        }

        $sql = 'SELECT
                tmp.id,
                tmp.type_tbl,
                tmp.link_id,
                tmp.user_id,
                tmp.sho_id,
                tmp.cate_link_id,
                tmp.title,
                tmp.description,
                tmp.image,
                tmp.video,
                tmp.img_width,
                tmp.img_height,
                tmp.orientation,
                tmp.is_public,
                l.title as link_title,
                l.description as link_description,
                l.image as link_image,
                l.img_width as link_img_width,
                l.img_height as link_img_height,
                l.link,
                l.host ';

        if($count){
            $sql = 'SELECT count(tmp.id) AS total ';
        }

        $sql .= ' FROM (
                    SELECT id, "tbtt_lib_links" AS type_tbl, title, description, img_width, img_height, orientation, image, video, cate_link_id, link_id, user_id, sho_id, is_public, created_at, updated_at FROM tbtt_lib_links '.(!$is_owner ? 'where is_public = 1' : '').' 
                    UNION ALL 
                    SELECT id, "tbtt_content_links" AS type_tbl, title, description, img_width, img_height, orientation, image, video, cate_link_id, link_id, user_id, sho_id, is_public, created_at, updated_at FROM tbtt_content_links where show_in_library = 1 '.(!$is_owner ? 'AND is_public = 1' : '').'   
                    UNION ALL 
                    SELECT id, "tbtt_content_image_links" AS type_tbl, title, description, img_width, img_height, orientation, image, video, cate_link_id, link_id, user_id, sho_id, is_public, created_at, updated_at FROM tbtt_content_image_links where show_in_library = 1 '.(!$is_owner ? 'AND is_public = 1' : '').'
                ) as tmp
                JOIN tbtt_links as l ON tmp.link_id = l.id
                '.$where;

        if(!$count){
            $sql .= ' ORDER BY tmp.created_at '. $order_by .'
            LIMIT '. $start .','. $limit;
        }
        return ($result = $this->db->query($sql)) ? $result->result_array() : null;
    }
    public function find_link_by_id($id, $is_owner = false)
    {
        if(empty($id))
            return [];

        $where = "WHERE tmp.id  = ". $id . (!$is_owner ? ' AND tmp.is_public = 1' : '');

        $sql = 'SELECT
                tmp.id,
                tmp.link_id,
                tmp.user_id,
                tmp.sho_id,
                tmp.content_id,
                tmp.cate_link_id,
                tmp.type_tbl,
                tmp.title,
                tmp.description,
                tmp.image,
                tmp.video,
                tmp.img_width,
                tmp.img_height,
                tmp.orientation,
                tmp.is_public,
                l.title as link_title,
                l.description as link_description,
                l.image as link_image,
                l.img_width as link_img_width,
                l.img_height as link_img_height,
                l.link,
                l.host
            FROM (
                SELECT id, "tbtt_lib_links" AS type_tbl, "" AS content_id, title, description, img_width, img_height, orientation, image, video, cate_link_id, link_id, user_id, sho_id, is_public, created_at, updated_at FROM tbtt_lib_links
                UNION ALL
                SELECT id, "tbtt_content_links" AS type_tbl, content_id, title, description, img_width, img_height, orientation, image, video, cate_link_id, link_id, user_id, sho_id, is_public, created_at, updated_at FROM tbtt_content_links
                UNION ALL 
                SELECT id, "tbtt_content_image_links" AS type_tbl, content_id, title, description, img_width, img_height, orientation, image, video, cate_link_id, link_id, user_id, sho_id, is_public, created_at, updated_at FROM tbtt_content_image_links
            ) as tmp
            JOIN tbtt_links as l ON tmp.link_id = l.id
            '.$where;
        return ($result = $this->db->query($sql)) ? $result->row_array() : null;
    }

    public function all_clone_link($id)
    {
        if(empty($id))
            return [];

        $where = "WHERE l.id  = ". $id;

        $sql = 'SELECT
                tmp.id,
                tmp.link_id,
                tmp.user_id,
                tmp.sho_id,
                tmp.cate_link_id,
                tmp.type_tbl,
                tmp.title,
                tmp.description,
                tmp.image,
                tmp.video,
                tmp.img_width,
                tmp.img_height,
                tmp.orientation,
                tmp.is_public,
                tmp.created_at,
                l.title as link_title,
                l.description as link_description,
                l.image as link_image,
                l.img_width as link_img_width,
                l.img_height as link_img_height,
                l.link,
                l.host
            FROM (
                SELECT id, "tbtt_lib_links" AS type_tbl, title, description, img_width, img_height, orientation, image, video, cate_link_id, link_id, user_id, sho_id, is_public, created_at, updated_at FROM tbtt_lib_links where is_public = 1
                UNION ALL 
                SELECT id, "tbtt_content_links" AS type_tbl, title, description, img_width, img_height, orientation, image, video, cate_link_id, link_id, user_id, sho_id, is_public, created_at, updated_at FROM tbtt_content_links where is_public = 1 AND show_in_library = 1
                UNION ALL 
                SELECT id, "tbtt_content_image_links" AS type_tbl, title, description, img_width, img_height, orientation, image, video, cate_link_id, link_id, user_id, sho_id, is_public, created_at, updated_at FROM tbtt_content_image_links where is_public = 1 AND show_in_library = 1
            ) as tmp
            JOIN tbtt_links as l ON tmp.link_id = l.id
            '.$where;
        return ($result = $this->db->query($sql)) ? $result->result_array() : null;
    }

    public function get_category_ids_by_shop($sho_id = 0, $user_id = 0, $is_onwer = false)
    {
        if(!$sho_id && !$user_id)
            return [];

        if($sho_id){
            $where = 'sho_id = '. $sho_id;
        }else {
            $where = 'sho_id = 0 AND user_id ='.$user_id;
        }

        if(!$is_onwer){
            $where .= ' AND is_public =1';
        }

        $sql = 'SELECT cate_link_id FROM tbtt_lib_links '. ($where ? (' WHERE ' . $where) : '') .'
                UNION
                SELECT cate_link_id FROM tbtt_content_links WHERE '. $where .' AND show_in_library = 1  
                UNION 
                SELECT cate_link_id FROM tbtt_content_image_links WHERE '. $where . ' AND show_in_library = 1';

        return ($result = $this->db->query($sql)) ? $result->result_array() : null;
    }

    public function get_category_ids_by_user($user_id, $is_owner = false)
    {
        if(!$user_id)
            return [];

        $sql = 'SELECT cate_link_id FROM tbtt_lib_links WHERE sho_id = 0 AND user_id ='. (int)$user_id . (!$is_owner ? ' AND is_public = 1 ': '') .'   
                UNION 
                SELECT cate_link_id FROM tbtt_content_links WHERE sho_id = 0 AND user_id ='. (int)$user_id . (!$is_owner ? ' AND is_public = 1 ': '') .'
                UNION 
                SELECT cate_link_id FROM tbtt_content_image_links WHERE sho_id = 0 AND user_id ='. (int)$user_id . (!$is_owner ? ' AND is_public = 1 ': '');

        return ($result = $this->db->query($sql)) ? $result->result_array() : null;
    }

    /**
     * Get news specify news_id
     *
     * @param $news_id
     * @param $sho_id
     * @param int $user_id
     * @param bool $owner_id
     * @param int $limit
     * @param int $start
     * @param int $owner_id
     * @param string $order_by
     * @return array|null
     */
    public function link_of_news($news_id, $sho_id = 0, $user_id = 0, $link_id_expel = 0, $owner_id = false, $limit = 20, $start = 0, $order_by = 'ASC')
    {
        if(!$news_id)
            return [];

        $where = 'WHERE content_id = '.$news_id;

        if($sho_id && $user_id){
            $where .= ' AND user_id  = '. $user_id . ' AND sho_id  = '. $sho_id;
        }else if($sho_id){
            $where .= ' AND sho_id  = '. $sho_id;
        }else if($user_id){
            $where .= ' AND user_id  = '. $user_id . ' AND sho_id = 0 ';
        }

        if($link_id_expel){
            $where .= ' AND tmp.id !='. $link_id_expel;
        }

        //nếu ko phải chủ shop hay nv shop thì chỉ hiển thị link public
        if(!$owner_id){
            $where .= ' AND is_public = 1';
        }
        $sql = 'SELECT
                tmp.id,
                tmp.type_tbl,
                tmp.content_image_id,
                tmp.link_id,
                tmp.user_id,
                tmp.sho_id,
                tmp.cate_link_id,
                tmp.content_id,
                tmp.title,
                tmp.description,
                tmp.image,
                tmp.video,
                tmp.img_width,
                tmp.img_height,
                tmp.orientation,
                tmp.is_public,
                l.title as link_title,
                l.description as link_description,
                l.image as link_image,
                l.img_width as link_img_width,
                l.img_height as link_img_height,
                l.link,
                l.host,
                l.img_ext as link_img_ext,
                l.img_path as link_img_path,
                l.img_name as link_img_name
            FROM (
                SELECT id, "tbtt_content_links" AS type_tbl, "" AS content_image_id, content_id, title, description, img_width, img_height, orientation, image, video, cate_link_id, link_id, user_id, sho_id, is_public, created_at, updated_at FROM tbtt_content_links
                UNION ALL 
                SELECT id, "tbtt_content_image_links" AS type_tbl, content_image_id, content_id, title, description, img_width, img_height, orientation, image, video, cate_link_id, link_id, user_id, sho_id, is_public, created_at, updated_at FROM tbtt_content_image_links
            ) as tmp
            JOIN tbtt_links as l ON tmp.link_id = l.id
            '.$where.'
            ORDER BY tmp.id '. $order_by .'
            ' .($start && $limit ? ('LIMIT '.$start .','. $limit): ($limit ? 'LIMIT '.$limit : '') );
        return ($result = $this->db->query($sql)) ? $result->result_array() : null;
    }

    public function shop_get_link_collection($sho_id, $collection_id, $limit = 20, $start = 0, $order_by = 'DESC')
    {
        if(empty($sho_id) || empty($collection_id)) {
            return [];
        }

        $where = "WHERE sho_id  = $sho_id";

        $sql = 'SELECT
                tmp.id,
                tmp.type_tbl,
                tmp.link_id,
                tmp.user_id,
                tmp.sho_id,
                tmp.cate_link_id,
                tmp.title,
                tmp.description,
                tmp.image,
                tmp.video,
                tmp.img_width,
                tmp.img_height,
                tmp.orientation,
                tmp.is_public,
                l.title as link_title,
                l.description as link_description,
                l.image as link_image,
                l.img_width as link_img_width,
                l.img_height as link_img_height,
                l.link,
                l.host
            FROM (
                (SELECT tbtt_lib_links.id, "tbtt_lib_links" AS type_tbl, title, description, img_width, img_height, orientation, image, video, cate_link_id, link_id, user_id, sho_id, is_public, created_at, updated_at
                FROM tbtt_lib_links
                INNER JOIN tbtt_collection_lib_links 
                    ON (tbtt_collection_lib_links.lib_link_id = tbtt_lib_links.id AND tbtt_collection_lib_links.collection_id = '.$collection_id.')
                )
                UNION ALL
                (SELECT tbtt_content_links.id, "tbtt_content_links" AS type_tbl, title, description, img_width, img_height, orientation, image, video, cate_link_id, link_id, user_id, sho_id, is_public, created_at, updated_at 
                FROM tbtt_content_links
                INNER JOIN tbtt_collection_content_links 
                    ON (tbtt_collection_content_links.content_link_id = tbtt_content_links.id AND tbtt_collection_content_links.collection_id = '.$collection_id.')
                )
                UNION ALL
                (SELECT tbtt_content_image_links.id, "tbtt_content_image_links" AS type_tbl, title, description, img_width, img_height, orientation, image, video, cate_link_id, link_id, user_id, sho_id, is_public, created_at, updated_at
                FROM tbtt_content_image_links
                INNER JOIN tbtt_collection_content_image_links 
                    ON (tbtt_collection_content_image_links.content_image_link_id = tbtt_content_image_links.id AND tbtt_collection_content_image_links.collection_id = '.$collection_id.')
                )
            ) as tmp
            JOIN tbtt_links as l ON tmp.link_id = l.id
            '.$where.'
            ORDER BY tmp.created_at '. $order_by;

        if($start >= 0) {
            $sql .= ' LIMIT '. $start .','. $limit;
        }
        return ($result = $this->db->query($sql)) ? $result->result_array() : null;
    }

    public function shop_get_all_link_all_collection_has_link($sho_id, $is_owner = false, $order_by = 'DESC')
    {
        if(empty($sho_id)) {
            return [];
        }

        $where = 'WHERE sho_id  = ' . $sho_id;
        $sql = 'SELECT
                tmp.id,
                tmp.type_tbl,
                tmp.user_id,
                tmp.sho_id,
                tmp.image,
                tmp.video,
                tmp.c_id,
                tmp.c_name,
                tmp.c_avatar,
                tmp.c_created_at,
                tmp.c_isPublic,
                tmp.count_1,
                tmp.count_2,
                tmp.count_3,
                l.title as link_title,
                l.description as link_description,
                l.image as link_image,
                l.link,
                l.host
            FROM (
                (SELECT tbtt_lib_links.id, "tbtt_lib_links" AS type_tbl, image, video, link_id, tbtt_lib_links.user_id, tbtt_lib_links.sho_id, tbtt_lib_links.created_at, tbtt_lib_links.updated_at,
                    tbtt_collection.avatar_path_full AS c_avatar, tbtt_collection.name AS c_name, tbtt_collection.id AS c_id, tbtt_collection.created_at AS c_created_at, tbtt_collection.isPublic as c_isPublic,
                    count_1, count_2, count_3
                FROM tbtt_lib_links
                INNER JOIN tbtt_collection_lib_links
                    ON tbtt_collection_lib_links.lib_link_id = tbtt_lib_links.id
                INNER JOIN tbtt_collection
                    ON tbtt_collection.id = tbtt_collection_lib_links.collection_id
                LEFT JOIN 
                    (SELECT count(*) AS count_1, (0) AS count_2, (0) AS count_3, tbtt_collection_lib_links.lib_link_id
                        FROM tbtt_collection_lib_links
                        INNER JOIN tbtt_collection
                            ON tbtt_collection.id = tbtt_collection_lib_links.collection_id
                        GROUP BY tbtt_collection_lib_links.collection_id
                            ) tb_count
                    ON tb_count.lib_link_id = tbtt_lib_links.id
                ORDER BY created_at '. $order_by .'
                )
                UNION ALL
                (SELECT tbtt_content_links.id, "tbtt_content_links" AS type_tbl, image, video, link_id, tbtt_content_links.user_id, tbtt_content_links.sho_id, tbtt_content_links.created_at, tbtt_content_links.updated_at,
                    tbtt_collection.avatar_path_full AS c_avatar, tbtt_collection.name AS c_name, tbtt_collection.id AS c_id, tbtt_collection.created_at AS c_created_at, tbtt_collection.isPublic as c_isPublic,
                    count_1, count_2, count_3
                FROM tbtt_content_links
                INNER JOIN tbtt_collection_content_links
                    ON tbtt_collection_content_links.content_link_id = tbtt_content_links.id
                INNER JOIN tbtt_collection
                    ON tbtt_collection.id = tbtt_collection_content_links.collection_id
                LEFT JOIN
                    (SELECT count(*) AS count_2, (0) AS count_1, (0) AS count_3, tbtt_collection_content_links.content_link_id
                        FROM tbtt_collection_content_links
                        INNER JOIN tbtt_collection
                            ON tbtt_collection.id = tbtt_collection_content_links.collection_id
                        GROUP BY tbtt_collection_content_links.collection_id
                            ) tb_count
                    ON tb_count.content_link_id = tbtt_content_links.id
                ORDER BY created_at '. $order_by .'
                )
                UNION ALL
                (SELECT tbtt_content_image_links.id, "tbtt_content_image_links" AS type_tbl, image, video, link_id, tbtt_content_image_links.user_id, tbtt_content_image_links.sho_id, tbtt_content_image_links.created_at, tbtt_content_image_links.updated_at,
                    tbtt_collection.avatar_path_full AS c_avatar, tbtt_collection.name AS c_name, tbtt_collection.id AS c_id, tbtt_collection.created_at AS c_created_at, tbtt_collection.isPublic as c_isPublic,
                    count_1, count_2, count_3
                FROM tbtt_content_image_links
                INNER JOIN tbtt_collection_content_image_links 
                    ON tbtt_collection_content_image_links.content_image_link_id = tbtt_content_image_links.id
                INNER JOIN tbtt_collection
                    ON tbtt_collection.id = tbtt_collection_content_image_links.collection_id
                LEFT JOIN
                    (SELECT count(*) AS count_3, (0) AS count_1, (0) AS count_2, tbtt_collection_content_image_links.content_image_link_id
                        FROM tbtt_collection_content_image_links
                        INNER JOIN tbtt_collection
                            ON tbtt_collection.id = tbtt_collection_content_image_links.collection_id
                        GROUP BY tbtt_collection_content_image_links.collection_id
                            ) tb_count
                    ON tb_count.content_image_link_id = tbtt_content_image_links.id
                ORDER BY created_at '. $order_by .'
                )
            ) as tmp
            JOIN tbtt_links as l ON tmp.link_id = l.id
            '.$where. (!$is_owner ? ' AND c_isPublic = 1 ': '') . '
            ORDER BY tmp.c_created_at '. $order_by;

        return ($result = $this->db->query($sql)) ? $result->result_array() : null;
    }

    /**
     * Home azibai Get unique link with max_id
     *
     * @return array
     */
    public function links_unique($shop_id = 0, $user_id = 0, $cat_id = 0, $is_owner = false)
    {
        $query1 = 'SET @noo := 0, @cate_id := 0;';
        $this->db->query($query1);
        $where     = ($shop_id ? ' WHERE tmp.sho_id ='. $shop_id : ($user_id ? ' WHERE tmp.user_id ='.$user_id : ''));
        $where_cat = $cat_id ? (' HAVING cate_id = '. $cat_id) : '';

        $query = '
            SELECT tmp2.* FROM (
                SELECT tmp1.*, (@noo := IF (@cate_id = tmp1.cate_id, @noo + 1, 1)) as noo, @cate_id := tmp1.cate_id FROM (
                    SELECT c.name, c.parent_id, c.slug , tmp.*, (IF (c.parent_id = 0, c.id, c.parent_id)) as cate_id,
                        l.title as link_title,
                        l.description as link_description,
                        l.image as link_image,
                        l.img_width as link_img_width,
                        l.img_height as link_img_height,
                        l.link,
                        l.host
                    FROM (
                        SELECT id, "tbtt_lib_links" AS type_tbl, title, description, img_width, img_height, orientation, image, video, cate_link_id, link_id, user_id, sho_id, is_public, created_at, updated_at FROM tbtt_lib_links '.(!$is_owner ? 'where is_public = 1' : '').' 
                        UNION ALL 
                        SELECT id, "tbtt_content_links" AS type_tbl, title, description, img_width, img_height, orientation, image, video, cate_link_id, link_id, user_id, sho_id, is_public, created_at, updated_at FROM tbtt_content_links where show_in_library = 1 '.(!$is_owner ? 'AND is_public = 1' : '').'   
                        UNION ALL 
                        SELECT id, "tbtt_content_image_links" AS type_tbl, title, description, img_width, img_height, orientation, image, video, cate_link_id, link_id, user_id, sho_id, is_public, created_at, updated_at FROM tbtt_content_image_links where show_in_library = 1 '.(!$is_owner ? 'AND is_public = 1' : '').'
                    ) as tmp 
                    JOIN tbtt_links as l ON tmp.id = l.max_id AND l.tbl_max IS NOT NULL && tmp.type_tbl = l.tbl_max
                    JOIN tbtt_category_links as c ON tmp.cate_link_id = c.id
                    '. $where .'
                    '. $where_cat .'
                    ORDER BY '.($where_cat ? ' tmp.created_at DESC ' : ' tmp.cate_link_id ASC ').' 
                 ) as tmp1 
             ) as tmp2
             WHERE tmp2.noo < 22;
        ';
        $result = $this->db->query($query);
        return ($result->num_rows()) ? $result->result_array() : [];
    }

    public function azibai_links($cat_id = 0, $cat_parent = false, $start = 0, $limit = 20)
    {
        $where = '';

        if($cat_id){
            $where = 'WHERE c.id = '. $cat_id . ($cat_parent ? " OR c.parent_id = $cat_id " : ' ');
        }

        $sql = 'SELECT  c.id AS cat_id, c.name, c.parent_id, c.slug , tmp.*,
                        l.title as link_title,
                        l.description as link_description,
                        l.image as link_image,
                        l.img_width as link_img_width,
                        l.img_height as link_img_height,
                        l.link,
                        l.host
                    FROM (
                        SELECT id, "tbtt_lib_links" AS type_tbl, title, description, img_width, img_height, orientation, image, video, cate_link_id, link_id, user_id, sho_id, is_public, created_at, updated_at FROM tbtt_lib_links where is_public = 1
                        UNION ALL 
                        SELECT id, "tbtt_content_links" AS type_tbl, title, description, img_width, img_height, orientation, image, video, cate_link_id, link_id, user_id, sho_id, is_public, created_at, updated_at FROM tbtt_content_links where is_public = 1 AND show_in_library = 1
                        UNION ALL 
                        SELECT id, "tbtt_content_image_links" AS type_tbl, title, description, img_width, img_height, orientation, image, video, cate_link_id, link_id, user_id, sho_id, is_public, created_at, updated_at FROM tbtt_content_image_links where is_public = 1 AND show_in_library = 1
                    ) as tmp
                    JOIN tbtt_links as l ON tmp.id = l.max_id AND tmp.type_tbl = l.tbl_max
                    JOIN tbtt_category_links as c ON tmp.cate_link_id = c.id
                    '.$where.'
                    ORDER BY l.added_at DESC 
                    LIMIT '. $start .','.$limit;

        return ($result = $this->db->query($sql)) ? $result->result_array() : [];
    }

    public function distinct_category_child($cat_id)
    {
        $sql = 'SELECT  c.id AS cat_id
                    FROM (
                        SELECT id, "tbtt_lib_links" AS type_tbl, cate_link_id FROM tbtt_lib_links where is_public = 1
                        UNION
                        SELECT id, "tbtt_content_links" AS type_tbl, cate_link_id FROM tbtt_content_links where is_public = 1 AND show_in_library = 1
                        UNION
                        SELECT id, "tbtt_content_image_links" AS type_tbl, cate_link_id FROM tbtt_content_image_links where is_public = 1 AND show_in_library = 1
                    ) as tmp 
                    JOIN tbtt_links as l ON tmp.id = l.max_id AND tmp.type_tbl = l.tbl_max
                    JOIN tbtt_category_links as c ON tmp.cate_link_id = c.id
                WHERE c.parent_id ='.$cat_id;

        return ($result = $this->db->query($sql)) ? $result->result_array() : [];
    }
}