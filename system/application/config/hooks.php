<?php
if(!defined('BASEPATH'))exit('No direct script access allowed');
$hook['pre_controller'][] = array(
    'class'    => 'sonlv',
    'function' => 'defineConstant',
    'filename' => 'sonlv.php',
    'filepath' => 'hooks',
    'params'   => array()
);
$hook['pre_controller_constructor'][] = array(
    'class'    => 'sonlv',
    'function' => 'shopLocation',
    'filename' => 'sonlv.php',
    'filepath' => 'hooks',
    'params'   => array()
);
//$hook['pre_controller_constructor'][] = array(
//    'class'    => 'sonlv',
//    'function' => 'variable_global',
//    'filename' => 'sonlv.php',
//    'filepath' => 'hooks',
//    'params'   => array()
//);
$hook['post_controller_constructor'] = array(
    'class'    => 'sonlv',
    'function' => 'initTab',
    'filename' => 'sonlv.php',
    'filepath' => 'hooks',
    'params'   => array()
);
