<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 12/3/2015
 * Time: 15:46 PM
 */
class Share_model extends CI_Model
{
    var $_link = array();
    var $_curLink = 'account/share';
    function __construct()
    {
        parent::__construct();
        $this->load->database();

        // Paginaiton defaults
        $this->pagination_enabled = FALSE;
        $this->pagination_per_page = 20;
        $this->pagination_num_links = 5;
        $this->pager = '';

        $this->filter = array('cat'=>0, 'q'=>'', 'p'=>'','pf'=>'', 'pt'=>'');

        $this->_link = array(
            'share'=>'account/share'
        );
    }
    function setCurLink($link){
        $this->_curLink = $link;
    }

    function counter($obj)
    {

        // Update counter
        $this->db->cache_off();
        $obj['share_id'] = $this->db->select('use_id')
            ->get_where('tbtt_user', array('af_key' => $obj['share_id']))
            ->row()
            ->use_id;
        if ($obj['share_id'] > 0) {
            $obj['link'] = trim($obj['link']);
            if(substr($obj['link'], -1) == '/'){
                $obj['link'] = substr($obj['link'], 0, -1);
            }
            $this->db->set('click', 'click + 1', FALSE);
            $this->db->where(array('share_id' => $obj['share_id'], 'content_id' => $obj['content_id'], 'link' => $obj['link']));
            $this->db->update('tbtt_share');
            if ($this->db->affected_rows() <= 0) {
                $obj['click'] = 1;
                $this->db->insert('tbtt_share', $obj);
            }
        }

    }
    function lister( $where = array(),$page = FALSE)
    {

        $this->db->start_cache();
        $sort = isset($_REQUEST['sort']) ? $_REQUEST['sort'] : 'link';
        $dir = isset($_REQUEST['dir']) ? $_REQUEST['dir'] : 'asc';
        $dir = strtolower($dir);
        $dir = $dir == 'asc' ? 'asc' : 'desc';
        $q = isset($_REQUEST['q']) ? $_REQUEST['q'] : '';
        $this->filter['p'] = isset($_REQUEST['p']) ? trim($_REQUEST['p']) : '';
        $this->filter['sort'] = $sort;
        $this->filter['dir'] = $dir;

        // Set filter
        if(trim($q) != ''){
            $searchString = $this->db->escape('%'.$q.'%');
            $this->db->where("(tbtt_user.`use_username` LIKE  {$searchString} OR tbtt_user.`use_fullname` LIKE  {$searchString} OR tbtt_user.`use_email` LIKE  {$searchString}) ");
            $this->filter['q'] =  trim($q);
        }

        if($this->filter['p'] != ''){
            $searchString = $this->db->escape('%'.$this->filter['p'].'%');
            $this->db->where("(tbtt_share.`content_title` LIKE  {$searchString} ) ");
        }

        switch($sort){
            case 'name':
                $this->db->order_by("tbtt_user.`use_fullname`", $dir);
                break;
            case 'proName':
                $this->db->order_by("tbtt_product.`pro_name`", $dir);
                break;
            case 'username':
                $this->db->order_by("tbtt_user.`use_username`", $dir);
                break;
            case 'email':
                $this->db->order_by("tbtt_user.`use_email`", $dir);
                break;
            case 'link':
                $this->db->order_by("tbtt_share.`link`", $dir);
                break;
            case 'click':
                $this->db->order_by("tbtt_share.`click`", $dir);
                break;
        }

        $select = 'tbtt_user.use_id,tbtt_user.af_key,use_username, use_fullname, use_email, link, content_title, tbtt_share.click,tbtt_af_share.*';
        // Unset user id
        unset($where['use_id']);
        $this->db->select($select, false);
        $this->db->from('tbtt_share');
        //$this->db->join('tbtt_product', 'tbtt_share.content_id = tbtt_product.pro_id');
        $this->db->join('tbtt_user', 'tbtt_user.use_id = tbtt_share.share_id');
        $this->db->join('tbtt_af_share', 'tbtt_af_share.pro_id = tbtt_share.content_id');
        $this->db->where($where);
        /**
         *   PAGINATION
         */
        if ($this->pagination_enabled == TRUE) {
            $config = array();
            $config['cur_page'] = $page;
            $config['total_rows'] = $this->db->count_all_results();
            $config['base_url'] = base_url().$this->_curLink;
            $config['uri_segment'] = 3;
            $config['cur_tag_open'] = '<li><span class="current">';
            $config['cur_tag_close'] = '</span></li>';
            $config['per_page'] = $this->pagination_per_page;
            $config['num_links'] = $this->pagination_num_links;
            $config['suffix'] = $this->buildLink(array("sort={$sort}", "dir={$dir}"));
            $this->load->library('pagination');
            $this->pagination->initialize($config);
            $this->pager = $this->pagination->create_links();
            $this->db->limit($config['per_page'], $page);
        }

        // Get the results
        $query = $this->db->get();
        //echo $this->db->last_query();
        $temp_result = $query->result_array();
        $query->free_result();
        foreach($temp_result  as &$item){
          $item['link'] = base_url().$item['link'].'?share='.$item['af_key'];
        }

        $this->db->flush_cache();
        return $temp_result;
    }
    function pagination($bool)
    {
        $this->pagination_enabled = ($bool === TRUE) ? TRUE : FALSE;
    }
    function getSort(){
        return array(
            array('id'=>1, 'text'=>'Link: A->Z', 'link'=>$this->buildLink(array('sort=link', 'dir=asc'))),
            array('id'=>1, 'text'=>'Link: Z->A', 'link'=>$this->buildLink(array('sort=link', 'dir=desc'))),
            array('id'=>1, 'text'=>'Click: tăng dần', 'link'=>$this->buildLink(array('sort=click', 'dir=asc'))),
            array('id'=>1, 'text'=>'Click: Giảm dần', 'link'=>$this->buildLink(array('sort=click', 'dir=desc')))

        );

    }
    function getAdminSort(){
        $sortField = array('name', 'username', 'email', 'link', 'click', 'proName');
        $data = array();
        foreach($sortField as $item){
            $data[$item]['asc'] = $this->buildLink(array('sort='.$item, 'dir=asc'));
            $data[$item]['desc'] = $this->buildLink(array('sort='.$item, 'dir=desc'));
        }
        return $data;
    }
    function buildLink($parrams){
        if(@$this->filter['q'] != ''){
            array_unshift($parrams, 'q='.$this->filter['q']);
        }
        if(@$this->filter['p'] != ''){
            array_unshift($parrams, 'p='.$this->filter['p']);
        }
        return '?'.implode('&', $parrams);
    }
    function getFilter(){
        return $this->filter;
    }

    function getRoute($var){
        return $this->_link[$var];
    }

}