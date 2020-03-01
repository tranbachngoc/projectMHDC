<?php
#****************************************#
# * @Author: lehieu008                   #
# * @Email: lehieu008@gmail.com          #
# * @Website: http://www.iscvietnam.net  #
# * @Copyright: 2008 - 2009              #
#****************************************#
class Images_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	function get($select = "*", $where = "")
	{
        $this->db->cache_off();
		$this->db->select($select);
		if($where && $where != "")
		{
			$this->db->where($where, NULL, false);
		}
		#Query
		$query = $this->db->get("tbtt_images");
		$result = $query->result();
		$query->free_result();
		return $result;
	}

	function getwhere($select = "*", $where = ""){
        $this->db->cache_off();
		$this->db->select($select);
		if($where && $where != "")
		{
			$this->db->where($where, NULL, false);
		}
		#Query
		$query = $this->db->get("tbtt_images");
		$result = $query->row_array();
		// $query->free_result();
		return $result;
	}

    function add($data){

		$this->db->insert("tbtt_images", $data);
		$insert_id = $this->db->insert_id();

   		return  $insert_id;
	}

	function update($data, $where = "")
	{
    	if($where && $where != "")
    	{
			$this->db->where($where);
    	}
		return $this->db->update("tbtt_images", $data);
	}

	function updateIn($data, $field = 'id')
	{
		return $this->db->update_batch("tbtt_images", $data, $field);
	}

	function delete($value, $field = "id", $in = true)
    {
		if($in == true)
		{
			$this->db->where_in($field, $value);
		}
		else
		{
            $this->db->where($field, $value);
		}
		return $this->db->delete("tbtt_images");
	}

	function getImageAndDir($image_id = array())
	{
		$this->db->select('tbtt_images.id, tbtt_images.name, tbtt_images.img_up_detect, tbtt_content.not_dir_image, tbtt_images.img_library_dir');
		$this->db->join('tbtt_content', 'tbtt_content.not_id = tbtt_images.not_id', 'LEFT');
		$this->db->where_in('tbtt_images.id', $image_id);
		$query = $this->db->get('tbtt_images');

		$result = $query->result();
        $query->free_result();
        return $result;
	}

	function getFirstImgAlbum($album_id = 0, $user_id = 0, $shop_id = 0)
	{
		$this->db->select('tbtt_images.id, tbtt_images.name, tbtt_images.img_up_detect, tbtt_content.not_dir_image, tbtt_images.img_library_dir');
		$this->db->join('tbtt_content', 'tbtt_content.not_id = tbtt_images.not_id', 'LEFT');
		$this->db->join('tbtt_album_media_detail', 'tbtt_album_media_detail.ref_item_id = tbtt_images.id', 'INNER');
		$this->db->where("tbtt_album_media_detail.ref_album_id = $album_id AND tbtt_album_media_detail.ref_user = $user_id AND tbtt_album_media_detail.ref_shop_id = $shop_id");
		$query = $this->db->get('tbtt_images');

		$result = $query->row();
        $query->free_result();
        return $result;
	}
}