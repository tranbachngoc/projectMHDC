<?php
#****************************************#
# * @Author: lehieu008                   #
# * @Email: lehieu008@gmail.com          #
# * @Website: http://www.iscvietnam.net  #
# * @Copyright: 2008 - 2009              #
#****************************************#
class Content_model extends MY_Model
{
    function __construct()
    {
        parent::__construct();
        $this->table = "tbtt_content";
        $this->select = "*";
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
		$query = $this->db->get("tbtt_content");
		
		$result = $query->row();
		$query->free_result();
		return $result;
	}

	function fetch($select = "*", $where = "", $order = "not_id", $by = "DESC", $start = -1, $limit = 0)
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
		$query = $this->db->get("tbtt_content");
		$result = $query->result();
		$query->free_result();
		return $result;		
	}
        
	function fetch_join($select = "*", $join, $table, $on, $where = "", $order = "id", $by = "DESC", $start = -1, $limit = 0, $distinct = false)
	{
		$this->db->cache_off();
		$this->db->select($select);
		if($join && ($join == "INNER" || $join == "LEFT" || $join == "RIGHT") && $table && $table != "" && $on && $on != "")
		{
			$this->db->join($table, $on, $join);
		}
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
		if($distinct && $distinct == true)
		{
			$this->db->distinct();
		}
		#Query
		$query = $this->db->get("tbtt_content");
		$result = $query->result();
		$query->free_result();
		return $result;
	}
        
    function fetch_join1($select = "*", $join, $table, $on, $where = "", $order = "id", $by = "DESC", $start = -1, $limit = 0, $distinct = false)
	{
        $this->db->cache_off();            
        $this->db->select($select);
        $this->db->from("tbtt_content AS tc");
        if($join && ($join == "INNER" || $join == "LEFT" || $join == "RIGHT") && $table && $table != "" && $on && $on != "")
        {
            $this->db->join($table, $on, $join);
        }
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
        if($distinct && $distinct == true)
        {
            $this->db->distinct();
        }
        #Query
        $query = $this->db->get();
        $result = $query->result();
        $query->free_result();
        return $result;
	}
        
    function fetch_join_2($select = "*", $join1, $table1, $on1, $join2, $table2, $on2, $where = "", $order = "id", $by = "DESC", $start = -1, $limit = 0, $distinct = false)
	{
		$this->db->cache_off();
		$this->db->select($select);
		$this->db->from("tbtt_content AS a");
		if($join1 && ($join1 == "INNER" || $join1 == "LEFT" || $join1 == "RIGHT") && $table1 && $table1 != "" && $on1 && $on1 != "")
		{
			$this->db->join($table1, $on1, $join1);
		}
		if($join2 && ($join2 == "INNER" || $join2 == "LEFT" || $join2 == "RIGHT") && $table2 && $table2 != "" && $on2 && $on2 != "")
		{
			$this->db->join($table2, $on2, $join2);
		}
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
		if($distinct && $distinct == true)
		{
			$this->db->distinct();
		}
		#Query
		$query = $this->db->get();
		$result = $query->result();
		$query->free_result();
		return $result;
	}
		
	function fetch_join_3($select = "*", $join1, $table1, $on1, $join2, $table2, $on2, $join3, $table3, $on3, $where = "", $order = "id", $by = "DESC", $start = -1, $limit = 0, $distinct = false) {
            $this->db->cache_off();
            $this->db->select($select, false);
            $this->db->from("tbtt_content");
            if ($join1 && ($join1 == "INNER" || $join1 == "LEFT" || $join1 == "RIGHT") && $table1 && $table1 != "" && $on1 && $on1 != "") {
                $this->db->join($table1, $on1, $join1);
            }
            if ($join2 && ($join2 == "INNER" || $join2 == "LEFT" || $join2 == "RIGHT") && $table2 && $table2 != "" && $on2 && $on2 != "") {
                $this->db->join($table2, $on2, $join2);
            }
            if ($join3 && ($join3 == "INNER" || $join3 == "LEFT" || $join3 == "RIGHT") && $table3 && $table3 != "" && $on3 && $on3 != "") {
                $this->db->join($table3, $on3, $join3);
            }
            if ($where && $where != "") {
                $this->db->where($where);
            }
            if ($order && $order != "" && $by && ($by == "DESC" || $by == "ASC")) {
                $this->db->order_by($order, $by);
                
            }
            if ((int) $start >= 0 && $limit && (int) $limit > 0) {
                $this->db->limit($limit, $start);
            }
            if ($distinct && $distinct == true) {
                $this->db->distinct();
            }
            #Query
            $query = $this->db->get();
            $result = $query->result();
            $query->free_result();
            return $result;
        }

    function add($data)
	{
		$this->db->insert("tbtt_content", $data);
		$insert_id = $this->db->insert_id();

   		return  $insert_id;
	}

	function isAuthor($userId,$ContentId){
        $query	=	"SELECT count(*) as total FROM `tbtt_content` WHERE not_user = ".$userId . " AND not_id = ".$ContentId;
        $return = $this->db->query($query);
        if($return->num_rows > 0 ){
            return true;
        }else {
            return false;
        }
    }

	function update($data, $where = "")
	{
        if($where && $where != "")
        {
            $this->db->where($where);
        }
        return $this->db->update("tbtt_content", $data);
	}

	function delete($value, $field = "not_id", $in = true)
    {
        if($in == true){
            $this->db->where_in($field, $value);
       	}else{
            $this->db->where($field, $value);
        }
        return $this->db->delete("tbtt_content");
    }

    /**
     * @param array $params
     * @return mixed
     * điều kiện hiển thị tin tức ngoài trang chủ
     * not_publish = 1 && not_status = 1 && not_permission = 1
     * nếu có user login thì thêm OR (not_permission != 1 && not_user = user_login)
     */
    public function get_news_wall($params = array())
    {
        $params_allow = [
            'user_login',
            'user_id',
            'sho_id',
            'cat_id',
            'limit',
            'start',
            'count',
            'order_by',
            'filter',
        ];

        $filter   = 'all';
        $limit    = 5;
        $start    = 0;
        $count    = false;
        $order_by = 'tbtt_content.not_id DESC';

        if(!empty($params)){
            foreach ($params as $key => $param) {
                if(in_array($key, $params_allow)){
                    ${$key} = $param;
                }
            }
        }

        if(!empty($cat_id)){
            $filter = 'all';
        }

        /*allow 2 post per user on wall, remove post of disable user //is_show_on_homepage*/
        $where_common = 'tbtt_content.id_category = 16 
                         AND tbtt_content.not_status = 1 
                         AND 2 > (
                                    SELECT count(`content1`.`not_id`)
                                    FROM `tbtt_content` AS `content1`
                                    WHERE `tbtt_content`.`not_user` = `content1`.`not_user`
                                    AND `tbtt_content`.`not_id` < `content1`.`not_id` 
                                )
                         AND not_user=19264 AND not_user NOT IN (SELECT use_id FROM tbtt_user WHERE is_show_on_homepage = '.NOT_SHOW_ON_HOMEPAGE.') ';
        $permission   = 'AND tbtt_content.not_permission = 1 AND tbtt_content.not_publish = 1 ';

        if(!empty($user_login)) {
            $permission = 'AND ((tbtt_content.not_permission = 1 AND tbtt_content.not_publish = 1) OR (tbtt_content.not_permission != 1 AND tbtt_content.not_user = '.$user_login.')) ';
        }

        switch ($filter){
            case 'all':
                if(!empty($cat_id)){
                    $where_common.= 'AND tbtt_content.not_pro_cat_id = '.$cat_id. ' ';
                }
                break;
            case 'shop':
                //nếu có sho_id thì lọc theo shop đó ngược lại all shop
                if(empty($sho_id)){
                    $where_common.= 'AND tbtt_content.sho_id > 0 ';
                }else{
                    $where_common.= 'AND tbtt_content.sho_id = '.$sho_id. ' ';
                }
                break;
            case 'user':
                if(empty($user_id)){
                    $where_common.= 'AND tbtt_content.sho_id = 0 AND tbtt_content.not_user > 0 ';
                }else{
                    $where_common.= 'AND tbtt_content.sho_id = 0 AND tbtt_content.not_user = '.$user_id . ' ';
                }
                break;
            default:

                break;
        }

        $where_common .= $permission;

        return $this->gets([
            'select'        => 'tbtt_content.*, 
                                tbtt_category.cat_name, 
                                tbtt_shop.sho_id, 
                                tbtt_shop.sho_name, 
                                tbtt_shop.sho_link, 
                                tbtt_shop.sho_logo, 
                                tbtt_shop.sho_dir_logo, 
                                tbtt_shop.sho_user, 
                                tbtt_shop.sho_mobile, 
                                tbtt_shop.sho_phone, 
                                tbtt_shop.sho_facebook, 
                                tbtt_shop.sho_email, 
                                tbtt_shop.domain, 
                                tbtt_user.use_id, 
                                tbtt_user.use_fullname, 
                                tbtt_user.use_slug,
                                tbtt_user.avatar',
            'param'         => $where_common,
            'orderby'       => $order_by,
            'limit'         => $limit,
            'start'         => $start,
            'count'         => (boolean)$count,
            'joins'         => [
                ['table' => 'tbtt_shop'     , 'where' => 'tbtt_content.sho_id         = tbtt_shop.sho_id AND tbtt_shop.sho_id > 0'   , 'type_join' => 'LEFT'],
                ['table' => 'tbtt_user'     , 'where' => 'tbtt_content.not_user       = tbtt_user.use_id'                            , 'type_join' => 'LEFT'],
                ['table' => 'tbtt_category' , 'where' => 'tbtt_content.not_pro_cat_id = tbtt_category.cat_id'                        , 'type_join' => 'LEFT'],
            ],
        ]);
    }

    public function get_new_by_id($id_content = 0, $user_login)
    {
        if($id_content == 0) return null;

        $limit    = 1;
        $start    = 0;
        $count    = false;
        $order_by = 'tbtt_content.not_id DESC';

        // $where_common = 'id_category = 16 AND not_status = 1 ';
        $where_common = 'tbtt_content.id_category = 16 
                        AND tbtt_content.not_status = 1 
                        AND not_user NOT IN (SELECT use_id FROM tbtt_user WHERE is_show_on_homepage = '.NOT_SHOW_ON_HOMEPAGE.') ';


        $permission   = 'AND tbtt_content.not_permission = 1 AND tbtt_content.not_publish = 1 ';

        if(!empty($user_login)) {
            $permission = 'AND ((tbtt_content.not_permission = 1 AND tbtt_content.not_publish = 1) OR (tbtt_content.not_permission != 1 AND tbtt_content.not_user = '.$user_login.')) ';
        }

        $where_common .= $permission;
        $where_common .= ' AND tbtt_content.not_id = ' . $id_content;

        return $this->gets([
            'select'        => 'tbtt_content.*, 
                                tbtt_category.cat_name, 
                                tbtt_shop.sho_id, 
                                tbtt_shop.sho_name, 
                                tbtt_shop.sho_link, 
                                tbtt_shop.sho_logo, 
                                tbtt_shop.sho_dir_logo, 
                                tbtt_shop.sho_user, 
                                tbtt_shop.sho_mobile, 
                                tbtt_shop.sho_phone, 
                                tbtt_shop.sho_facebook, 
                                tbtt_shop.sho_email, 
                                tbtt_shop.domain, 
                                tbtt_user.use_id, 
                                tbtt_user.use_fullname, 
                                tbtt_user.use_slug,
                                tbtt_user.avatar',
            'param'         => $where_common,
            'orderby'       => $order_by,
            'limit'         => $limit,
            'start'         => $start,
            'count'         => (boolean)$count,
            'joins'         => [
                ['table' => 'tbtt_shop'     , 'where' => 'tbtt_content.sho_id         = tbtt_shop.sho_id AND tbtt_shop.sho_id > 0'   , 'type_join' => 'LEFT'],
                ['table' => 'tbtt_user'     , 'where' => 'tbtt_content.not_user       = tbtt_user.use_id'                            , 'type_join' => 'LEFT'],
                ['table' => 'tbtt_category' , 'where' => 'tbtt_content.not_pro_cat_id = tbtt_category.cat_id'                        , 'type_join' => 'LEFT'],
            ]
        ]);
    }

	public function public_wall_hot_box(){
		$sql = "SELECT
				  not_id,
				  not_title,
				  not_begindate,
				  not_detail,
				  not_image,
				  not_dir_image,
				  not_view,
				  not_paid_news,
				  not_news_sale,
				  1 as not_news_hot
				FROM
				  tbtt_package_daily_content
                  LEFT JOIN tbtt_package_daily_user
                    ON tbtt_package_daily_user.id = tbtt_package_daily_content.order_id
				  LEFT JOIN tbtt_content
					ON tbtt_content.not_id = tbtt_package_daily_content.content_id

				WHERE tbtt_package_daily_content.begin_date = CURDATE()
				  AND tbtt_package_daily_content.p_type = '01'
				  AND tbtt_package_daily_content.content_type = 'news'
                  AND tbtt_package_daily_user.position = '000'
				  AND tbtt_content.not_id IS NOT NULL
				ORDER BY RAND()
				LIMIT 0, 10 ";

		$query = $this->db->query($sql);
		return $query->result();
	}

	public function public_wall_sale_box(){
		$sql = "SELECT
				  not_id,
				  not_title,
				  not_begindate,
				  not_detail,
				  not_image,
				  not_dir_image,
				  not_view,
				  not_paid_news,
				  not_news_hot,
				  1 as not_news_sale
				FROM
				  tbtt_package_daily_content
                  LEFT JOIN tbtt_package_daily_user
                    ON tbtt_package_daily_user.id = tbtt_package_daily_content.order_id
				  LEFT JOIN tbtt_content
					ON tbtt_content.not_id = tbtt_package_daily_content.content_id

				WHERE tbtt_package_daily_content.begin_date = CURDATE()
				  AND tbtt_package_daily_content.p_type = '01'
				  AND tbtt_package_daily_content.content_type = 'news'
                  AND tbtt_package_daily_user.position = '111'
				  AND tbtt_content.not_id IS NOT NULL
				ORDER BY RAND()
				LIMIT 0, 10 ";
		$query = $this->db->query($sql);
		return $query->result();
	}

	public function private_wall_hot_box(){
		$sql = "SELECT
				  not_id,
				  not_title,
				  not_begindate,
				  not_detail,
				  not_image,
				  not_dir_image,
				  not_view,
				  not_paid_news,
				  not_news_sale,
				  1 as not_news_hot
				FROM
				  tbtt_package_daily_content
				  LEFT JOIN tbtt_package_daily_user
                    ON tbtt_package_daily_user.id = tbtt_package_daily_content.order_id
				  LEFT JOIN tbtt_content
					ON tbtt_content.not_id = tbtt_package_daily_content.content_id
				WHERE tbtt_package_daily_content.begin_date = CURDATE()
				  AND tbtt_package_daily_content.p_type = '02'
				  AND tbtt_package_daily_user.content_type = 'news'
				  AND tbtt_package_daily_user.position = '000'
				  AND tbtt_content.not_id IS NOT NULL
				ORDER BY RAND()
				LIMIT 0, 10 ";
		$query = $this->db->query($sql);
		return $query->result();
	}

	public function private_wall_sale_box(){
		$sql = "SELECT
				  not_id,
				  not_title,
				  not_begindate,
				  not_detail,
				  not_image,
				  not_dir_image,
				  not_view,
				  not_paid_news,
				  1 as not_news_sale,
				  not_news_hot
				FROM
				  tbtt_package_daily_content
				  LEFT JOIN tbtt_package_daily_user
                    ON tbtt_package_daily_user.id = tbtt_package_daily_content.order_id
				  LEFT JOIN tbtt_content
					ON tbtt_content.not_id = tbtt_package_daily_content.content_id
				WHERE tbtt_package_daily_content.begin_date = CURDATE()
				  AND tbtt_package_daily_content.p_type = '02'
				  AND tbtt_package_daily_user.content_type = 'news'
				  AND tbtt_package_daily_user.position = '111'
				  AND tbtt_content.not_id IS NOT NULL
				ORDER BY RAND()
				LIMIT 0, 10 ";
		$query = $this->db->query($sql);
		return $query->result();
	}

    public function shop_news_list_videos($shop_id, $limit = 0, $start = 0, $user_login = '', $count = false, $shop_user = 0)
    {
        if(!$shop_id){
            return false;
        }

        $where  = "not_status = 1 
                    AND not_publish = 1 
                    AND id_category = 16 
                    AND (tbtt_content.not_video_url1 IS NOT NULL AND tbtt_content.not_video_url1 != 0)";

        $where_permission = ' AND not_permission = 1';

        if ($user_login) {
            $where_permission = ' AND (not_permission = 1 OR (not_permission = 6 AND not_user = '.$user_login.')) ';
        }
        $where .= $where_permission;

        // get list not_id from shop and branchs of shop
        if($shop_user > 0) {
            $get_share_news = 'SELECT not_id FROM tbtt_send_news WHERE status = 1 and user_shop_id = '. $shop_user;
            $query_news  = $this->db->query($get_share_news);
            $result_share = $query_news->result();
            if (!empty($result_share)) {
                foreach ($result_share as $k_share => $v_share)
                {
                    $not_id_share[] = $v_share->not_id;
                }
            }

            if (!empty($not_id_share)) {
                $where .= " AND (tbtt_content.sho_id = ". $shop_id . " OR tbtt_content.not_id IN (" . implode(",",$not_id_share) . "))";
            } else {
                $where .= " AND tbtt_content.sho_id = ". $shop_id;
            }
        }

        return $this->gets([
            'select'        => 'DISTINCT tbtt_content.not_id, tbtt_content.not_video_url1, tbtt_content.not_title, tbtt_content.not_detail, tbtt_content.not_dir_image, tbtt_content.not_begindate, tbtt_content.sho_id, tbtt_videos.id, tbtt_videos.thumbnail, tbtt_videos.width, tbtt_videos.height, tbtt_videos.name, tbtt_videos.title, tbtt_videos.description, tbtt_videos.path,
            tbtt_shop.sho_logo, tbtt_shop.sho_dir_logo, tbtt_shop.sho_link, tbtt_shop.domain, tbtt_shop.sho_name',
            'param'         => $where,
            'orderby'       => 'tbtt_videos.id DESC',
            'limit'         => $limit,
            'start'         => $start,
            'count'         => (boolean)$count,
            'joins'         => [
                ['table' => 'tbtt_permission',  'where' => 'tbtt_permission.id = tbtt_content.not_permission', 'type_join' => 'LEFT'],
                ['table' => 'tbtt_videos',      'where' => 'tbtt_content.not_video_url1 = tbtt_videos.id', 'type_join' => 'RIGHT'],
                ['table' => 'tbtt_shop',      'where' => 'tbtt_shop.sho_user = tbtt_videos.user_id', 'type_join' => 'LEFT']
            ]
        ]);
    }

    public function shop_news_list_image($shop_id, $limit = 0, $start = 0, $user_login = '', $count = false, $relation_id = array(), $album_id = 0, $shop_user = 0)
    {
        $where  = "not_status = 1 AND not_publish = 1 AND id_category = 16 AND (tbtt_images.not_id IS NOT NULL AND tbtt_images.not_id != 0)" ;
        $where_permission = ' AND not_permission = 1';

        if(!empty($relation_id)){
            $limit = 0;
            $start = 0;
            $where =  'not_status = 1 AND not_publish = 1 AND id_category = 16 AND tbtt_images.not_id = '.$relation_id['not_id'].' AND tbtt_images.id <> '.$relation_id['image_id'].' AND tbtt_content.sho_id = '. $shop_id ;
        }

        if ($user_login) {
            $where_permission = ' ';
        }
        $where .= $where_permission;

        // get list not_id from shop and branchs of shop
        if($shop_user > 0) {
            $get_share_news = 'SELECT not_id FROM tbtt_send_news WHERE status = 1 and user_shop_id = '. $shop_user;
            $query_news  = $this->db->query($get_share_news);
            $result_share = $query_news->result();
            if (!empty($result_share)) {
                foreach ($result_share as $k_share => $v_share)
                {
                    $not_id_share[] = $v_share->not_id;
                }
            }

            if (!empty($not_id_share)) {
                $where .= " AND (tbtt_content.sho_id = ". $shop_id . " OR tbtt_content.not_id IN (" . implode(",",$not_id_share) . "))";
            } else {
                $where .= " AND tbtt_content.sho_id = ". $shop_id;
            }
        }

        $where_getImg_upload = '';
        if ($shop_user) {
            $where_getImg_upload .= ' OR (img_up_by_shop = '.$shop_id.' AND img_up_detect = '.IMAGE_UP_DETECT_LIBRARY.' AND user_id = '. $shop_user .')';
        }

        $where .= $where_getImg_upload;
        $arr_join = [
                        ['table' => 'tbtt_images',      'where' => 'tbtt_images.not_id = tbtt_content.not_id', 'type_join' => 'RIGHT'],
                        ['table' => 'tbtt_shop',      'where' => 'tbtt_shop.sho_user = tbtt_images.user_id', 'type_join' => 'LEFT']
                    ];

        if($album_id > 0 && $shop_user > 0){
            array_push($arr_join,
                ['table' => 'tbtt_album_media_detail',  'where' => 'tbtt_album_media_detail.ref_item_id = tbtt_images.id', 'type_join' => 'LEFT']
            );
            $where = "tbtt_album_media_detail.ref_album_id = $album_id AND ($where)";
        }
        return $this->content_model->gets([
            'select'        => 'DISTINCT COALESCE(tbtt_content.not_id, 0) AS not_id, tbtt_content.not_detail, tbtt_content.not_begindate, tbtt_content.not_dir_image, tbtt_content.sho_id, tbtt_content.not_title, tbtt_images.name, tbtt_images.link_crop, tbtt_images.tags, tbtt_images.title, tbtt_images.content, tbtt_images.id, tbtt_images.img_w, tbtt_images.img_h, tbtt_images.img_library_dir, tbtt_images.img_library_title, tbtt_images.img_up_detect, tbtt_images.orientation, tbtt_shop.sho_logo, tbtt_shop.sho_dir_logo, tbtt_images.user_id',
            'param'         => $where,
            'orderby'       => 'tbtt_images.id DESC',
            'limit'         => $limit,
            'start'         => $start,
            'count'         => (boolean)$count,
            'joins'         => $arr_join,
        ]);
    }

    public function shop_news_list_image_type($shop_id, $limit = 0, $start = 0, $user_login = '', $count = false, $relation_id = array(), $album_id = 0, $shop_user = 0, $typeIMG = IMAGE_UP_DETECT_CONTENT)
    {
        if($typeIMG == IMAGE_UP_DETECT_CONTENT) {
            $where  = "not_status = 1 AND not_publish = 1 AND id_category = 16 AND (tbtt_images.not_id IS NOT NULL AND tbtt_images.not_id != 0)";
            $where_permission = ' AND not_permission = 1';

            if(!empty($relation_id)){
                $limit = 0;
                $start = 0;
                $where =  'not_status = 1 AND not_publish = 1 AND id_category = 16 AND tbtt_images.not_id = '.$relation_id['not_id'].' AND tbtt_images.id <> '.$relation_id['image_id'].' AND tbtt_content.sho_id = '. $shop_id ;
            }

            if ($user_login) {
                $where_permission = ' ';
            }
            $where .= $where_permission . ' AND img_up_detect = '.$typeIMG;

            // get list not_id from shop and branchs of shop
            if($shop_user > 0) {
                $get_share_news = 'SELECT not_id FROM tbtt_send_news WHERE status = 1 and user_shop_id = '. $shop_user;
                $query_news  = $this->db->query($get_share_news);
                $result_share = $query_news->result();
                if (!empty($result_share)) {
                    foreach ($result_share as $k_share => $v_share)
                    {
                        $not_id_share[] = $v_share->not_id;
                    }
                }

                if (!empty($not_id_share)) {
                    $where .= " AND (tbtt_content.sho_id = ". $shop_id . " OR tbtt_content.not_id IN (" . implode(",",$not_id_share) . "))";
                } else {
                    $where .= " AND tbtt_content.sho_id = ". $shop_id;
                }
            }

            $arr_join = [
                ['table' => 'tbtt_images',      'where' => 'tbtt_images.not_id = tbtt_content.not_id', 'type_join' => 'LEFT']
            ];
        }

        if($typeIMG == IMAGE_UP_DETECT_LIBRARY) {
            $where = 'img_up_by_shop = '.$shop_id.' AND img_up_detect = '.$typeIMG.' AND user_id = '. $shop_user;
            $arr_join = [
                ['table' => 'tbtt_images',      'where' => 'tbtt_images.not_id = tbtt_content.not_id', 'type_join' => 'RIGHT']
            ];
        }

        if($album_id > 0 && $shop_user > 0){
            array_push($arr_join,
                ['table' => 'tbtt_album_media_detail',  'where' => 'tbtt_album_media_detail.ref_item_id = tbtt_images.id', 'type_join' => 'LEFT']
            );
            $where = "tbtt_album_media_detail.ref_album_id = $album_id AND ($where)";
        }

        return $this->content_model->gets([
            'select'        => 'COALESCE(tbtt_content.not_id, 0) AS not_id, tbtt_content.not_detail, tbtt_content.not_begindate, tbtt_content.not_dir_image, tbtt_content.sho_id, tbtt_content.not_title, tbtt_images.name, tbtt_images.tags, tbtt_images.title, tbtt_images.content, tbtt_images.id, tbtt_images.img_w, tbtt_images.img_h, tbtt_images.img_library_dir, tbtt_images.img_library_title, tbtt_images.img_up_detect, tbtt_images.orientation',
            'param'         => $where,
            'orderby'       => 'tbtt_images.id DESC',
            'limit'         => $limit,
            'start'         => $start,
            'count'         => (boolean)$count,
            'joins'         => $arr_join,
        ]);
    }

    public function personal_news_list_videos($user_id, $limit = 0, $start = 0, $is_own = false, $count = false)
    {
        if(!$user_id){
            return false;
        }

        $where  = "not_status = 1 
                    AND not_publish = 1 
                    AND id_category = 16 
                    AND (tbtt_content.not_video_url1 IS NOT NULL AND tbtt_content.not_video_url1 != 0) 
                    AND ( tbtt_content.sho_id IS NULL OR tbtt_content.sho_id = 0 ) 
                    AND tbtt_content.not_user = ". $user_id ;

        $where_permission = ' AND not_permission = 1';

        if ($is_own) {
            $where_permission = ' AND (not_permission = 1 OR (not_permission = 6 AND not_user = '.$user_id.')) ';
        }
        $where .= $where_permission;

        return $this->gets([
            'select'        => 'tbtt_content.not_id, tbtt_content.not_video_url1, tbtt_content.not_title, tbtt_content.not_detail, tbtt_content.not_dir_image, tbtt_content.not_begindate, tbtt_content.sho_id, tbtt_videos.id, tbtt_videos.thumbnail, tbtt_videos.width, tbtt_videos.height, tbtt_videos.name, tbtt_videos.title, tbtt_videos.description, tbtt_videos.path',
            'param'         => $where,
            'orderby'       => 'tbtt_videos.id DESC',
            'limit'         => $limit,
            'start'         => $start,
            'count'         => (boolean)$count,
            'joins'         => [
                ['table' => 'tbtt_permission',  'where' => 'tbtt_permission.id = tbtt_content.not_permission', 'type_join' => 'LEFT'],
                ['table' => 'tbtt_videos',      'where' => 'tbtt_content.not_video_url1 = tbtt_videos.id', 'type_join' => 'LEFT'],
            ]
        ]);
    }

    public function personal_news_list_image($user_id, $limit = 0, $start = 0, $is_own = false, $count = false, $relation_id = array(), $album_id = 0)
    {
        $where  = "not_status = 1 AND not_publish = 1 AND id_category = 16 AND (tbtt_images.not_id IS NOT NULL AND tbtt_images.not_id != 0) AND ( tbtt_content.sho_id IS NULL OR tbtt_content.sho_id = 0 ) AND tbtt_content.not_user = ". $user_id ;
        $where_permission = ' AND not_permission = 1';

        if(!empty($relation_id)){
            $limit = 0;
            $start = 0;
            $where =  'not_status = 1 AND not_publish = 1 AND id_category = 16 AND tbtt_images.not_id = '.$relation_id['not_id'].' AND tbtt_images.id <> '.$relation_id['image_id'].' AND tbtt_content.not_user = '. $user_id ;
        }

        if ($is_own) {
            $where_permission = ' AND (not_permission = 1 OR (not_permission = 6 AND not_user = '.$user_id.')) ';
        }
        $where .= $where_permission;

        $where_getImg_upload = ' OR (img_up_by_shop = 0 AND img_up_detect = '.IMAGE_UP_DETECT_LIBRARY.' AND user_id = '. $user_id .')';
        $where .= $where_getImg_upload;

        $arr_join = [
            ['table' => 'tbtt_permission',  'where' => 'tbtt_permission.id = tbtt_content.not_permission', 'type_join' => 'LEFT'],
            ['table' => 'tbtt_images',      'where' => 'tbtt_images.not_id = tbtt_content.not_id', 'type_join' => 'RIGHT']
        ];
        if($album_id > 0){
            array_push($arr_join,
            ['table' => 'tbtt_album_media_detail',  'where' => 'tbtt_album_media_detail.ref_item_id = tbtt_images.id', 'type_join' => 'LEFT']
            );
            $where = "tbtt_album_media_detail.ref_album_id = $album_id AND ($where)";
        }

        return $this->content_model->gets([
            'select'        => 'COALESCE(tbtt_content.not_id, (0)) AS not_id, tbtt_content.not_user, tbtt_content.not_detail, tbtt_content.not_begindate, tbtt_content.not_dir_image, tbtt_content.sho_id, tbtt_content.not_title, tbtt_images.name, tbtt_images.link_crop, tbtt_images.tags, tbtt_images.title, tbtt_images.content, tbtt_images.id, tbtt_images.img_w, tbtt_images.img_h, tbtt_images.img_library_dir, tbtt_images.img_library_title, tbtt_images.img_up_detect, tbtt_images.orientation',
            'param'         => $where,
            'orderby'       => 'tbtt_images.id DESC',
            'limit'         => $limit,
            'start'         => $start,
            'count'         => (boolean)$count,
            'joins'         => $arr_join
        ]);
    }

    public function personal_news_list_image_type($user_id, $limit = 0, $start = 0, $is_own = false, $count = false, $relation_id = array(), $album_id = 0, $typeIMG = IMAGE_UP_DETECT_CONTENT)
    {
        if($typeIMG == IMAGE_UP_DETECT_CONTENT) {
            $where  = "not_status = 1 AND not_publish = 1 AND id_category = 16 AND (tbtt_images.not_id IS NOT NULL AND tbtt_images.not_id != 0) AND ( tbtt_content.sho_id IS NULL OR tbtt_content.sho_id = 0 ) AND tbtt_content.not_user = ". $user_id ;
            $where_permission = ' AND not_permission = 1';

            if(!empty($relation_id)){
                $limit = 0;
                $start = 0;
                $where =  'not_status = 1 AND not_publish = 1 AND id_category = 16 AND tbtt_images.not_id = '.$relation_id['not_id'].' AND tbtt_images.id <> '.$relation_id['image_id'].' AND tbtt_content.not_user = '. $user_id ;
            }

            if ($is_own) {
                $where_permission = ' AND (not_permission = 1 OR (not_permission = 6 AND not_user = '.$user_id.')) ';
            }
            $where .= $where_permission . ' AND img_up_detect = '.$typeIMG;
            $arr_join = [
                ['table' => 'tbtt_permission',  'where' => 'tbtt_permission.id = tbtt_content.not_permission', 'type_join' => 'LEFT'],
                ['table' => 'tbtt_images',      'where' => 'tbtt_images.not_id = tbtt_content.not_id', 'type_join' => 'LEFT']
            ];
        }

        if($typeIMG == IMAGE_UP_DETECT_LIBRARY) {
            $where = 'img_up_by_shop = 0 AND img_up_detect = '.$typeIMG.' AND user_id = '. $user_id;
            $arr_join = [
                ['table' => 'tbtt_images',      'where' => 'tbtt_images.not_id = tbtt_content.not_id', 'type_join' => 'RIGHT']
            ];
        }

        if($album_id > 0){
            array_push($arr_join,
            ['table' => 'tbtt_album_media_detail',  'where' => 'tbtt_album_media_detail.ref_item_id = tbtt_images.id', 'type_join' => 'LEFT']
            );
            $where = "tbtt_album_media_detail.ref_album_id = $album_id AND ($where)";
        }

        return $this->content_model->gets([
            'select'        => 'COALESCE(tbtt_content.not_id, (0)) AS not_id, tbtt_content.not_user, tbtt_content.not_detail, tbtt_content.not_begindate, tbtt_content.not_dir_image, tbtt_content.sho_id, tbtt_content.not_title, tbtt_images.name, tbtt_images.tags, tbtt_images.title, tbtt_images.content, tbtt_images.id, tbtt_images.img_w, tbtt_images.img_h, tbtt_images.img_library_dir, tbtt_images.img_library_title, tbtt_images.img_up_detect, tbtt_images.orientation',
            'param'         => $where,
            'orderby'       => 'tbtt_images.id DESC',
            'limit'         => $limit,
            'start'         => $start,
            'count'         => (boolean)$count,
            'joins'         => $arr_join
        ]);
    }

    public function get_mention_by_content_id($content_id)
    {
        $this->load->config('config_upload');
        $cdn_avatar = $this->config->item('avatar_user_config')['cloud_server_show_path'] . '/';
        $cdn_avatar_shop = $this->config->item('logo_shop_config')['cloud_server_show_path'] . '/';
        $default_ava = site_url('media/images/avatar/default-avatar.png');
        $azibai_url = azibai_url();
        $protocol = get_server_protocol();
        $domain_site = domain_site;

        $sql = "SELECT
            tbtt_content_tagged_users.start,
            tbtt_content_tagged_users.end,
            tbtt_content_tagged_users.user_id,
            tbtt_content_tagged_users.sho_id,
            IF(tbtt_content_tagged_users.sho_id = 0, 1, 0) AS is_personal,
            IF(tbtt_content_tagged_users.sho_id = 0, tbtt_user.use_fullname, tbtt_shop.sho_name) AS full_name,
            IF(tbtt_content_tagged_users.sho_id = 0,
                IF(tbtt_user.website IS NULL OR tbtt_user.website = '',
                    CONCAT('{$azibai_url}','/profile/', tbtt_content_tagged_users.user_id),
                    CONCAT('http://', tbtt_user.website)
                ),
                IF(tbtt_shop.domain IS NULL OR tbtt_shop.domain = '',
                    CONCAT('{$protocol}', tbtt_shop.sho_link, '.', '{$domain_site}'),
                    CONCAT('http://', tbtt_shop.domain)
                )
            ) AS link_website,
            IF(tbtt_content_tagged_users.sho_id = 0,
                IF(tbtt_user.avatar IS NULL OR tbtt_user.avatar = '',
                    '{$default_ava}',
                    CONCAT('{$cdn_avatar}', tbtt_content_tagged_users.user_id,'/',tbtt_user.avatar)
                ),
                IF(tbtt_shop.sho_logo IS NULL OR tbtt_shop.sho_logo = '',
                    '{$default_ava}',
                    CONCAT('{$cdn_avatar_shop}', tbtt_shop.sho_dir_logo,'/',tbtt_shop.sho_logo)
                )
            ) AS avatar_fullpath
        FROM
            tbtt_content_tagged_users
        LEFT JOIN tbtt_shop ON tbtt_shop.sho_id = tbtt_content_tagged_users.sho_id
        INNER JOIN tbtt_user ON tbtt_user.use_id = tbtt_content_tagged_users.user_id
        WHERE
            tbtt_content_tagged_users.content_id = {$content_id}";

        return $this->db->query($sql)->result();
    }

    public function news_detail($not_id, $sessionUser, $sessionGroup, $shopID, $shop_near)
    {
        $select = "a.*, 
                    u.use_id,
                    u.website, 
                    u.use_group, 
                    u.use_username, 
                    u.use_status, 
                    u.use_email, 
                    u.use_fullname, 
                    u.use_birthday, 
                    u.use_slug, 
                    u.use_address, 
                    u.avatar, 
                    b.cat_name, 
                    p.name as not_permission_name, 
                    s.sho_name, 
                    s.sho_link, 
                    s.sho_logo, 
                    s.sho_dir_logo, 
                    s.sho_descr, 
                    s.sho_banner, 
                    s.sho_dir_banner, 
                    s.sho_mobile, 
                    s.sho_phone, 
                    s.sho_facebook, 
                    s.domain, 
                    s.sho_user, 
                    s.sho_email";

        $where  = "a.not_status = 1 AND a.id_category = 16 AND a.not_publish = 1 AND a.not_id = " . $not_id;
        $where_permission =  ' AND not_permission = 1';
        if( $sessionUser ) { // neu co mot user dang nhap vao
            $shopID = $shopID != 0 ? $shopID : $sessionUser;
            $shop_near = $shop_near != 0 ? $shop_near : $sessionUser;
            if( $sessionGroup == 2) {
                $aaaa = ' AND (not_permission IN (1,2,4) OR (not_permission = 5 AND (not_user = '. $shopID .' OR not_user = '. $shop_near .')))';
            } else {
                $aaaa = ' AND (not_permission IN (1,2,3) OR (( not_permission = 5 AND ( not_user = '. $shopID .' OR not_user = '. $shop_near .')) OR ( not_permission = 6 AND not_user = '. $sessionUser .') OR ( not_permission = 4 AND ( not_user = '. $sessionUser .' OR not_user = '. $shop_near .'))))';
            }
            $where_permission = $aaaa;
        }
        $where .= $where_permission;

        $sql2 = 'SELECT ' . $select . ' FROM tbtt_content AS a '
            . 'LEFT JOIN tbtt_user AS u ON a.not_user = u.use_id '
            . 'LEFT JOIN tbtt_category AS b ON a.not_pro_cat_id = b.cat_id '
            . 'LEFT JOIN tbtt_shop AS s ON a.not_user = s.sho_user '
            . 'LEFT JOIN tbtt_permission AS p ON p.id = a.not_permission '
            . 'WHERE ' . $where;

        $query = $this->db->query($sql2);
        return $query->row();
    }
}