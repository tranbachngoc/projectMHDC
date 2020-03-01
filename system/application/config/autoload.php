<?php
if(!defined('BASEPATH'))exit('No direct script access allowed');
#Auto load libraries
$autoload['libraries'] = array('database', 'session', 'filter', 'check');
#Auto load helper
$autoload['helper'] = array('form', 'url', 'str', 'text', 'thumbnail', 'number','file','icsc','paging_helper','theme_helper', 'date','emoji');
#Auto load plugin
$autoload['plugin'] = array();
#Auto load config
$autoload['config'] = array('config_upload','config_api','config_api_aff');
#Auto load language
$autoload['language'] = array();
#Auto load model
$autoload['model'] = array('counter_model', 'menu_model', 'advertise_model', 'product_model');

$autoload['drivers'] = array('session'); 
