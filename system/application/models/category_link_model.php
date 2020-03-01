<?php
#****************************************#
# * @Author: lehieu008                   #
# * @Email: lehieu008@gmail.com          #
# * @Website: http://www.iscvietnam.net  #
# * @Copyright: 2008 - 2009              #
#****************************************#
class Category_link_model extends MY_Model
{
    function __construct()
    {
        parent::__construct();
        $this->table = "tbtt_category_links";
        $this->select = "*";
	}

    public function get_categories_child($parent_id, $cat_ids = [])
    {
        if(!$parent_id)
            return [];
        $where = 'status = 1 AND parent_id = '. (int)$parent_id;

        if(!empty($cat_ids) && is_array($cat_ids)){
            $where = 'status = 1 AND parent_id = '. (int)$parent_id . ' AND id IN ('.implode($cat_ids, ",").')';
        }

        return $this->gets([
            'param'     => $where,
            'orderby'   => 'ordering',
            'type'      => 'array'
        ]);
    }

    public function get_category_by_slug($slug)
    {
        if(!$slug)
            return [];

        return $this->find_where('tbtt_category_links.status = 1 AND tbtt_category_links.slug ="'.$slug.'"', [
            'select'    => 'tbtt_category_links.*, parent.name AS parent_name, parent.slug AS parent_slug',
            'joins'     => [
                [
                    'table'     => 'tbtt_category_links AS parent',
                    'where'     => 'tbtt_category_links.parent_id = parent.id AND tbtt_category_links.status = 1 AND tbtt_category_links.parent_id > 0',
                    'type_join' => 'LEFT'
                ],
            ]
        ]);
    }

    public function get_category_by_id($id)
    {
        if(!$id)
            return [];

        return $this->find_where('tbtt_category_links.status = 1 AND tbtt_category_links.id ="'.(int)$id.'"', [
            'select'    => 'tbtt_category_links.*, parent.name AS parent_name, parent.slug AS parent_slug',
            'joins'     => [
                [
                    'table'     => 'tbtt_category_links AS parent',
                    'where'     => 'tbtt_category_links.parent_id = parent.id AND tbtt_category_links.status = 1 AND tbtt_category_links.parent_id > 0',
                    'type_join' => 'LEFT'
                ],
            ]
        ]);
    }

    public function get_category_root()
    {
        return $this->gets([
            'param'     => 'status = 1 AND parent_id = 0',
            'orderby'   => 'ordering',
            'type'      => 'array'
        ]);
    }

    public function get_category_parent_by_cat_ids($ids)
    {
        if(!$ids)
            return [];

        if(is_array($ids))
            $ids = implode($ids, ",");

        $sql = 'SELECT distinct parent_id
                FROM tbtt_category_links 
                WHERE parent_id != 0 AND status = 1 AND id IN ('.$ids.') ORDER BY id ASC';

        $query = $this->db->query($sql);
        return ($query->num_rows()) ? $query->result_array() : [];
    }
}