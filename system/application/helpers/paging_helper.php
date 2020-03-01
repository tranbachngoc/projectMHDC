<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function pagination($url = '',$total,$per_page = NULL,$uri_segment = NULL){
				
			$config                    = array();
			$config['base_url']        = $url;
			$config['total_rows']      = $total;
			$config['per_page']        = $per_page;
			$config['uri_segment']     = $uri_segment;
                        $config['use_page_numbers'] = TRUE;
			$config['first_link']      = '<<';
			$config['last_link']       = '>>';
			$config['first_tag_open']  = '<li class="click">';
			$config['first_tag_close'] = '</li>';
			$config['last_tag_open']   = '<li class="click">';
			$config['last_tag_close']  = '</li>';
			$config['prev_tag_open']   = '<li class="click">';
			$config['prev_tag_close']  = '</li>';
			$config['next_tag_open']   = '<li class="click">';
			$config['next_tag_close']  = '</li>';
			$config['num_tag_open']    = '<li class="click">';
			$config['num_tag_close']   = '</li>';
			$config['next_link']       = 'Next';
			$config['prev_link']       = 'Prev';
			$config['cur_tag_open']    = '<li class="active"><a>';
			$config['cur_tag_close']   = '</a></li>';
			return $config;
	
}