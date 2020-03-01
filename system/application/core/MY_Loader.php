<?php
class MY_Loader extends CI_Loader {
    static $static_data = array();
    public function view($view, $vars = array(), $return = FALSE)
    {
        $vars = array_merge($vars, self::$static_data);
        return $this->_ci_load(array('_ci_view' => $view, '_ci_vars' => $this->_ci_object_to_array($vars), '_ci_return' => $return));
    }
}