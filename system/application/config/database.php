<?php
if(!defined('BASEPATH'))exit('No direct script access allowed');
$active_group = "default";
$active_record = TRUE;
#BEGIN: Database
// $db['default']['hostname'] = "localhost";
// $db['default']['username'] = "root";
// $db['default']['password'] = "";
// $db['default']['database'] = "azibai_xyz";

$db['default']['dbdriver'] = "mysql";
$db['default']['dbprefix'] = "tbtt_";
$db['default']['pconnect'] = TRUE;
$db['default']['db_debug'] = TRUE;
$db['default']['cache_on'] = FALSE;
$db['default']['cachedir'] = "system/cache";
$db['default']['char_set'] = "utf8";
$db['default']['dbcollat'] = "utf8_general_ci";
$db['default']['date_default_timezone_set'] = "Asia/Ho_Chi_Minh";

// $db['default']['hostname'] = "125.212.229.152";
// $db['default']['username'] = "azibai_xyz"; 
// $db['default']['password'] = "1dc@123@12345";
// $db['default']['database'] = "azibai_xyz";

$db['default']['hostname'] = "125.212.229.146";
$db['default']['username'] = "azibai_web";
$db['default']['password'] = "auyKRdP0w2v8COySusIW";
$db['default']['database'] = "azibai_com";
// #END Database
