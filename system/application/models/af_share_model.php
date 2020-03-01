<?php
/**
 * Created by PhpStorm.
 * Date: 11/25/2015
 * Time: 15:21 PM
 */
class Af_share_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    function add($data)
    {
        return $this->db->insert('tbtt_af_share', $data);
    }
    public function get($key,$value)
    {
        $this->db->where($key, $value);
        $result = $this->db->get('tbtt_af_share');
        if($result->num_rows() > 0)
            return $result->row();
        return false;
    }
    function getAll($select = "*", $where = "")
    {
        $this->db->select($select);
        if($where && $where != "")
        {
            $this->db->where($where);
        }
        #Query
        $query = $this->db->get("tbtt_af_share");
        $result = $query->row();
        $query->free_result();
        return $result;
    }

    //for af
    public function getAll_ListViewShare($key, $start = 0, $limit='')
    {
        $chuoi_sql="SELECT pro_category,af_key,tbtt_af_share.pro_id,tbtt_product.pro_name,count(*) as 'so_luong_view' 
                    FROM tbtt_af_share,tbtt_product 
                    WHERE tbtt_product.pro_id=tbtt_af_share.pro_id
                    AND tbtt_af_share.af_key LIKE '".$key."'
                    GROUP BY tbtt_af_share.pro_id";
        if($limit != ''){
            $chuoi_sql .= " LIMIT ".$start.','.$limit;
        }
        $kq=$this->db->query($chuoi_sql);
        return  $kq->result_object();

    }

    //for af
    public function getAll_by_afKey_proId($af_key,$proId,$start = 0,$limit = '')
    {
        $this->db->where('af_key',$af_key);
        $this->db->where('pro_id',$proId);
        if($limit != ''){
            $this->db->limit($limit,$start);
        }
        $result = $this->db->get('tbtt_af_share');
        if($result->num_rows() > 0)
        return $result->result();
        return false;
    }

    //for chu shop
    public function getAll_by_proId($proId,$start = 0,$limit = '')
    {
        $chuoi_sql = "SELECT * FROM tbtt_af_share,tbtt_user WHERE tbtt_user.af_key=tbtt_af_share.af_key  and pro_id='".$proId."'";
        if($limit != ''){
            $chuoi_sql .= " LIMIT ".$start.','.$limit;
        }
        $kq = $this->db->query($chuoi_sql);
        return  $kq->result_object();
    }

    //for chu shop
    public function getAll_ListViewShare_Shop($key, $start = 0, $limit = '')
    {
        $chuoi_sql = "SELECT pro_category,af_key,tbtt_af_share.pro_id,tbtt_product.pro_name,count(*) as 'so_luong_view' 
                     FROM tbtt_af_share,tbtt_product 
                     WHERE tbtt_product.pro_id=tbtt_af_share.pro_id 
                     AND pro_user='".$key."'
                     group by tbtt_af_share.pro_id";
        if($limit != ''){
            $chuoi_sql .= " LIMIT ".$start.','.$limit;
        }
        $kq = $this->db->query($chuoi_sql);
        return  $kq->result_object();
    }

    function buildLink($parrams, $issort = false)
    {
        if ($issort == true) {
            unset($this->filter['sort']);
            unset($this->filter['dir']);
        }
        foreach ($this->filter as $key => $val) {
            if ($val != '') {
                array_unshift($parrams, $key . '=' . $val);
            }
        }
        return '?' . implode('&', $parrams);
    }

}
