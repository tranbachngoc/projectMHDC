<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bookmark_model extends MY_Model
{
    function __construct()
    {
        parent::__construct();
        $this->table  = "tbtt_bookmark_links";
        $this->select = "*";
    }

    /**
     * @param $user_id
     * @param array $shops
     * get all bookmark owner user, shop
     */
    public function my_bookmarks($user_id)
    {
        if (empty($user_id))
            return [];

        return $this->gets([
            'select'    => 'tbtt_bookmark_links.*',
            'param'     => 'tbtt_bookmark_links.user_id = '.$user_id,
            'orderby'   => 'tbtt_bookmark_links.user_id, tbtt_bookmark_links.id DESC',
        ]);
    }

    public function get_link($id)
    {
        if(!$id){
            return null;
        }
        return $this->find_where(['id' => (int)$id]);
    }
}
?>