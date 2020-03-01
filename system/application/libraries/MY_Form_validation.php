<?php defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Form_validation extends CI_Form_validation
{
    function __construct($config = array())
    {
        parent::__construct($config);
    }

    /**
     * get array error message
     * @return array|bool
     */
    function error_array()
    {
        if (count($this->_error_array) === 0)
            return FALSE;
        else
            return $this->_error_array;
    }

    /**
     * Required
     *
     * @access	public
     * @param	string
     * @return	bool
     */
    function url($url)
    {
        if ( ! is_array($url) && filter_var($url, FILTER_VALIDATE_URL)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * Required
     *
     * @access	public
     * @param	string
     * @return	array
     */
    function get_post_data()
    {
        $temp = [];
        if (!empty(is_array($this->_field_data) && !empty($this->_field_data))){
            foreach ($this->_field_data as $val){
                $temp[$val['field']] = $val['postdata'];
            }
        }
        return $temp;
    }

    function is_exists($str, $field) {
        $field_ar = explode('.', $field);
        $query = $this->CI->db->get_where($field_ar[0], array($field_ar[1] => $str), 1, 0);
        if ($query->num_rows() !== 0) {
            return TRUE;
        }

        return FALSE;
    }
}