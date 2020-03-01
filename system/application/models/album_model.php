<?php

class Album_model extends MY_Model
{
    function __construct()
    {
        parent::__construct();
        $this->table = 'tbtt_album_media';
        $this->select = '*';
    }

    function get($select = "*", $where = "")
    {
        $this->db->cache_off();
        $this->db->select($select);
        if ($where && $where != "") {
            $this->db->where($where);
        }
		#Query
        $query = $this->db->get($this->table);
        $result = $query->row();
        $query->free_result();
        return $result;
    }

    function fetch($select = "*", $where = "", $order = "album_id", $by = "DESC", $start = -1, $limit = 10, $distinct = false)
    {
        $this->db->cache_off();
        $this->db->select($select);
        $this->db->from($this->table);
        if ($where && $where != "") {
            $this->db->where($where, null, false);
        }
        if ($order && $order != "" && $by && ($by == "DESC" || $by == "ASC")) {
            $this->db->order_by($order, $by);
            $this->db->order_by('album_updated', 'DESC');
        }
        if ((int)$start >= 0 && $limit && (int)$limit > 0) {
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
        return $this->db->insert($this->table, $data);
    }

    function update($data, $where = "")
    {
        if ($where && $where != "") {
            $this->db->where($where);
        }
        return $this->db->update($this->table, $data);
    }

    function update_multi($data, $field = 'album_id')
	{
        $this->db->trans_start();
        $this->db->update_batch($this->table, $data, $field);
        $this->db->trans_complete();
        return ($this->db->trans_status() === FALSE)? FALSE:TRUE;
	}

    function delete($value, $field = "", $in = true)
    {
        if ($in == true) {
            $this->db->where_in($field, $value);
        } else {
            $this->db->where($field, $value);
        }
        return $this->db->delete($this->table);
    }

    function get_album_with_total($user_id = 0, $shop_id = 0, $type = 0, $permission = PERMISSION_SOCIAL_PUBLIC)
    {
        $select = 'tbtt_album_media.*, count(tbtt_album_media_detail.ref_album_id) as total';
        $where = 'tbtt_album_media.album_type = '.$type.' AND tbtt_album_media.ref_user = '.$user_id.' AND tbtt_album_media.ref_shop_id = '.$shop_id;
        $this->db->cache_off();
        $this->db->select($select)
            ->where($where)
            ->join('tbtt_album_media_detail', 'tbtt_album_media_detail.ref_album_id = tbtt_album_media.album_id', 'LEFT')
            ->order_by('tbtt_album_media.album_offset_top', 'DESC')
            ->order_by('tbtt_album_media.album_updated', 'DESC')
            ->group_by('tbtt_album_media.album_id');
        if ($permission == PERMISSION_SOCIAL_PUBLIC) {
            $this->db->where_in('tbtt_album_media.album_permission', [PERMISSION_SOCIAL_PUBLIC]);
        } elseif ($permission == PERMISSION_SOCIAL_FRIEND) {
            $this->db->where_in('tbtt_album_media.album_permission', [PERMISSION_SOCIAL_PUBLIC, PERMISSION_SOCIAL_FRIEND]);
        } elseif($permission == PERMISSION_SOCIAL_ME) {
            $this->db->where_in('tbtt_album_media.album_permission', [PERMISSION_SOCIAL_PUBLIC, PERMISSION_SOCIAL_FRIEND, PERMISSION_SOCIAL_ME]);
        }
        $query = $this->db->get('tbtt_album_media');
        $result = $query->result();
        $query->free_result();
        return $result;
    }

    function get_detail_data_album($user_id = 0, $shop_id = 0, $type = 0, $album_id = 0) {
        $select = 'b.id, b.name, b.title, c.not_dir_image, c.not_title ,b.img_up_detect, b.img_up_by_shop, b.img_library_dir, b.img_library_title';
        $where = 'tbtt_album_media.album_id = '.$album_id.' AND tbtt_album_media.album_type = '.$type.' AND tbtt_album_media.ref_user = '.$user_id.' AND tbtt_album_media.ref_shop_id = '.$shop_id;

        $this->db->cache_off();
        $this->db->select($select)
            ->where($where)
            ->join('tbtt_album_media_detail a', 'a.ref_album_id = tbtt_album_media.album_id', 'LEFT')
            ->join('tbtt_images b', 'b.id = a.ref_item_id', 'LEFT')
            ->join('tbtt_content c', 'c.not_id = b.not_id', 'LEFT');
        $query = $this->db->get('tbtt_album_media');
        $result = $query->result();
        $query->free_result();
        return $result;
    }

    function get_data_album_with_id($id = 0, $album_type = ALBUM_IMAGE, $user_id = 0, $shop_id = 0)
    {
        $select = 'tbtt_album_media.*';
        $where = 'tbtt_album_media.album_type = '.$album_type.' AND tbtt_album_media.ref_user = '.$user_id.' AND tbtt_album_media.ref_shop_id = '.$shop_id.' AND a.ref_item_id = '.$id;
        $this->db->select($select)
            ->where($where)
            ->join('tbtt_album_media_detail a', 'a.ref_album_id = tbtt_album_media.album_id', 'LEFT');
        $query = $this->db->get('tbtt_album_media');
        $result = $query->result();
        $query->free_result();
        return $result;
    }

    function get_album_avata_with_id_image($arr_album_id = array())
    {
        $select = '*';
        $where = '';
    }
}