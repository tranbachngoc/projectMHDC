<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 ***************************************************************************
 * Created: 2018/08/29
 * Check Permissions
 ***************************************************************************
 * @author: Duc<nguyenvietduckt82@gmail.com>
 * @return: return true or false
 *
 ***************************************************************************
 */
if(!function_exists('format_date')) {
    function format_date($time, $input_format = INPUT_DATE_FOMART, $output_format = OUTPUT_DATE_FOMART) {
        if (!$time || $time == '0000-00-00'){
            return null;
        }
        return date_format(date_create_from_format($input_format, $time), $output_format);
    }
}

?>