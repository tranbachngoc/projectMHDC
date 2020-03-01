<?php
if(!defined('BASEPATH'))exit('No direct script access allowed');
#BEGIN: File mode
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);
define('ENVIRONMENT', 'development');

#END File mode
#BEGIN: Fopen file
define('FOPEN_READ', 							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 		'wb'); 
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 	'w+b');
define('FOPEN_WRITE_CREATE', 					'ab');
define('FOPEN_READ_WRITE_CREATE', 				'a+b');
define('FOPEN_WRITE_CREATE_STRICT', 			'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');
#END Fopen file

define('PAYMENT_USER_ID', 1);
define('AF_OFF', 1);

// Define Ajax Request
define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');

define( 'FACEBOOK_ID',			'235009293507438');
define( 'FACEBOOK_SERECT',			'3256f2503618b3871c83954178398507');
define( 'FACEBOOK_FIELD',			'name,gender,email,birthday,hometown,locale,religion');
define( 'FACEBOOK_PERMISSION',			'public_profile,email');
define('GG_APP_ID', '531627412734-apb474n0ak746cptq3ke58eqll15guo2.apps.googleusercontent.com');
define('GG_APP_SERET', '_Wt8RW7vthe6TnwhWgoMfaH9');
define('GOOGLE_KEY', 'AIzaSyCegBi6yJOToGCC-J-5i14Z-gNZ3lbVoZo');
define( 'GOOGLE_SCOPE',			'profile email'); // https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/plus.login
define('GG_SCOPES', 'https://www.googleapis.com/auth/plus.login,https://www.googleapis.com/auth/plus.me,https://www.googleapis.com/auth/userinfo.email,https://www.googleapis.com/auth/userinfo.profile');

// Define param sequence to get $this->uri->segment(param);
// Use for subdomain
// Get segment First
define('segmentFirst', 1);
define('segmentSecond', 2);
define('segmentThird', 3);
define('segmentFourth', 4);
define('segmentFifth', 5);

define('COLLECTION_CUSTOMLINK', 3);
define('CUSTOMLINK_CONTENT', 'content');
define('CUSTOMLINK_COLLECTION', 'collection');
define('CUSTOMLINK_IMAGE', 'image');

define('domain_site', 'azibai.xxx');
define('IP_SERVER', 'S40');
define('SERVER_LOADBALANCER', '171.244.9.48');

