<?php
#****************************************#
# * @Author: lehieu008                   #
# * @Email: lehieu008@gmail.com          #
# * @Website: http://www.iscvietnam.net  #
# * @Copyright: 2008 - 2009              #
#****************************************#
class Comment_model extends CI_Model
{
    var $_curLink = '';
	function __construct()
	{
		parent::__construct();
        // Paginaiton defaults
        $this->pagination_enabled = TRUE;
        $this->pagination_per_page = 100;
        $this->pagination_num_links = 3;
	}
    function setCurLink($link){
        $this->_curLink = $link;
    }


    function add($data)
	{
		$this->db->set($data);
		return $this->db->insert("tbtt_content_comment");
	}
    function delete($value, $field = "noc_id", $in = true)
    {
        $this->db->cache_delete_all();
        if(!file_exists('system/cache/index.html'))
        {
            $this->load->helper('file');
            @write_file('system/cache/index.html', '<p>Directory access is forbidden.</p>');
        }
        if($in == true)
        {
            $this->db->where_in($field, $value);
        }
        else
        {
            $this->db->where($field, $value);
        }
        return $this->db->delete("tbtt_content_comment");
    }
    function getComments( $where = array(), $page = FALSE){
        $this->db->cache_off();

        $this->db->select('*');
        $this->db->from('tbtt_content_comment');
        $this->db->where($where);
        $this->db->order_by("noc_date", 'desc');
        if ($this->pagination_enabled == TRUE) {
            $this->db->limit($this->pagination_per_page, $page);
        }
        $query = $this->db->get();
        $temp_result = $query->result_array();
        if($this->pagination_enabled == TRUE){
            $this->db->select('COUNT(*) as total');
            $this->db->from('tbtt_content_comment');
            $this->db->where($where);
            $query = $this->db->get();
            $result = $query->row_array();
            $config = array();
            $config['cur_page'] = $page;
            $config['total_rows'] = $result['total'];
            $config['base_url'] = base_url().$this->_curLink;
            $config['uri_segment'] = 3;
            $config['cur_tag_open'] = '<li><span class="current">';
            $config['cur_tag_close'] = '</span></li>';
            $config['per_page'] = $this->pagination_per_page;
            $config['num_links'] = $this->pagination_num_links;
            $config['suffix'] = '';
            $this->load->library('pagination');
            $this->pagination->initialize($config);
            $this->pager = $this->pagination->create_links();
        }

        return $temp_result;

    }
    function getCommenbyUser($parrams){
        $this->db->cache_off();
        $this->db->select('tbtt_content_comment.*,DATE_FORMAT(tbtt_content_comment.noc_date,"%d-%m-%Y") AS noc_date, tbtt_content.not_title, tbtt_content.not_id');
        $this->db->from('tbtt_content');
        $this->db->join('tbtt_content_comment', 'tbtt_content_comment.noc_content = tbtt_content.not_id', 'right');
        $this->db->where('tbtt_content.not_user', $parrams['not_user']);
        $this->db->order_by('tbtt_content_comment.noc_date', 'desc');
        $this->db->limit($parrams['limit'], $parrams['page']);
        $query = $this->db->get();
        $temp_result = $query->result_array();
        $query->free_result();
        return $temp_result;

    }
    function getNumCommenbyUser($parrams){
        $this->db->cache_off();
        $this->db->select('COUNT(*) as total');
        $this->db->from('tbtt_content');
        $this->db->join('tbtt_content_comment', 'tbtt_content_comment.noc_content = tbtt_content.not_id', 'right');
        $this->db->where('tbtt_content.not_user', $parrams['not_user']);
        $query = $this->db->get();
        $temp_result = $query->row_array();
        $query->free_result();
        return $temp_result['total'];

    }
    function  getLastedComment($where = array()){
        $this->db->cache_off();
    }


}