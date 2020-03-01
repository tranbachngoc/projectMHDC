<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
function concatenateFiles($files) {
    $buffer = '';

    foreach($files as $file) {
        $buffer .= file_get_contents($file);
    }

    return $buffer;
}

function loadCss($files,$minfile = 'home/styles.min.css'){
    $_minfile ="templates/".$minfile;

    $createMinFile = false;
    if(!file_exists($_minfile)){
        $createMinFile = true;
    }

    if(!$createMinFile){
        $btime = filemtime($_minfile);
        foreach ($files as $key => $value) {
            $time = filemtime('templates/'.$value);
            if($time>$btime){
                unlink($_minfile);
                $createMinFile = true;
                break;
            }
        }
    }
    if($createMinFile){
        $CI= &get_instance();
        $CI->load->library('minify');
        $CI->minify->css($files);
        $CI->minify->deploy_css(TRUE,$minfile);
    }
    $sServerName = getAliasDomain();
    $sContentCss = str_replace('../fonts', $sServerName.'templates/home/fonts', concatenateFiles(array($_minfile)));
    return $sContentCss;
}
function loadJs($files, $minfile = 'home/scripts.min.js'){
    $createMinFile = false;
    if(!file_exists($minfile)){
        $createMinFile = true;
    }
    if(!$createMinFile){
        $btime = filemtime($minfile);
        foreach ($files as $key => $value) {
            $time = filemtime('templates/asset/js/'.$value);
            if($time>$btime){
                unlink($minfile);
                $createMinFile = true;
                break;
            }
        }

    }

    if($createMinFile){
        $CI= &get_instance();
        $CI->load->library('minify');
        $CI->minify->js($files);
        $CI->minify->deploy_js('', $minfile);
    }
    $sServerName = getAliasDomain();
    return $sServerName.'templates/'.$minfile;
}

if(!function_exists('strictEmpty')) {
    function strictEmpty($var) {
        $var = trim($var);
        if(isset($var) === true && $var === '') {
            return true;
        }
        else {
            return false;
        }
    }
}

if(!function_exists('dd')) {
    function dd($param = array()) {
        echo '<pre>';
        print_r($param);
        echo '</pre>';
    }
}

if(!function_exists('getAliasDomain')) {
    function getAliasDomain($link = '') {
        $result = "";
        if (isset($_SERVER['HTTP_X_FORWARDED_HOST']) && !empty($_SERVER['HTTP_X_FORWARDED_HOST'])) {
            $result = get_server_protocol() . $_SERVER['HTTP_X_FORWARDED_HOST'] . '/';
        }
        if($result != '') {
            return $result.$link;
        }else {
            return base_url().$link;
        }

    }
}
if(!function_exists('replaceAliasDomain')) {
    function replaceAliasDomain($sString = '') {
        $sServerName = get_server_protocol() . $_SERVER['SERVER_NAME']. '/';
        $sString = str_replace($sServerName, getAliasDomain() , $sString);
        return $sString;
    }
}
if(!function_exists('replaceImage')) {
    function replaceImage($sString = '') {
        $sServerName = get_server_protocol() . $_SERVER['SERVER_NAME']. '/';
        $sString = str_replace($sServerName, DOMAIN_CLOUDSERVER , $sString);
        return $sString;
    }
}
if(!function_exists('formatNumber')) {
    function formatNumber($number, $decimals = NUM_DECIMALS, $decimal_pont = NUM_DECIMAL_POINT, $thousands_sep = NUM_THOUSANDS_SEP ) {
        return number_format($number, $decimals, $decimal_pont, $thousands_sep);
    }
}

if(!function_exists('getUrlMeta')) {
    function getUrlMeta($url='') {

        // Khởi tạo mặc định

        $aMeta = array(
            'title'			=> '',
            'description'	=> '',
            'image'			=> '',
            'save_link' 	=> $url
        );

        $checkRedirectUrl = checkRedirectUrl($url);

        $parse_host = parse_url($checkRedirectUrl, PHP_URL_HOST);
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);

        if ($parse_host == domain_site) 
        {
           curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13 Azibai'); 
        } 
        else 
        {
            curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
        }

        
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_ENCODING ,"");
        $data = curl_exec($ch);
        curl_close($ch);
        $html = $data;

        //parsing begins here:
        $doc = new \DOMDocument();
        @$doc->loadHTML('<?xml encoding="utf-8" ?>' . $html);
        $meta_val = [];

        $list = $doc->getElementsByTagName("title");
        if ($list->length > 0) {
            $meta_val['title'] = $list->item(0)->textContent;
        }

        foreach($doc->getElementsByTagName('link') as $meta) {
            if ($meta->getAttribute('rel') != ''
                && ($meta->getAttribute('rel') == 'shortcut icon'
                || $meta->getAttribute('rel') == 'icon'
                || preg_match('/[a-zA-Z]*touch-icon[a-zA-Z]*/', $meta->getAttribute('rel')))) {
                $meta_val['favicon'] = $meta->getAttribute('href');
            }
        }

        foreach($doc->getElementsByTagName('meta') as $meta) {
            if($meta->getAttribute('property') != '') {
                $meta_val[$meta->getAttribute('property')] = $meta->getAttribute('content');
            }else {
                $meta_val[$meta->getAttribute('name')] = $meta->getAttribute('content');
            }
        }


        foreach ($meta_val as $key => $value) {

            // Thẻ title
            if($key == 'title' && $value != '') {
                $aMeta['title'] = $value;
            }else if($key == 'og:title' && $value != '') {
                $aMeta['title'] = $value;
            }else if($key == 'twitter:title' && $value != '') {
                $aMeta['title'] = $value;
            }

            // Thẻ description
            if($key == 'description' && $value != '') {
                $aMeta['description'] = $value;
            }else if($key == 'og_description' && $value != '') {
                $aMeta['description'] = $value;
            }else if($key == 'twitter:description' && $value != '') {
                $aMeta['description'] = $value;
            }

            // Hình đại diện
            if($key == 'og:image' && $value != '') {
                $aMeta['image'] = $value;
            }else if($key == 'twitter:image' && $value != '') {
                $aMeta['image'] = $value;
            }

            // favicon
            if($key == 'favicon' && $value) {
                $aMeta['favicon'] = $value;
            }
        }

        return $aMeta;
    }
}

if(!function_exists('checkRedirectUrl')) {
    function checkRedirectUrl($url)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_URL, $url);
        $out = curl_exec($ch);

        // line endings is the wonkiest piece of this whole thing
        $out = str_replace("\r", "", $out);

        // only look at the headers
        $headers_end = strpos($out, "\n\n");
        if ($headers_end !== false) {
            $out = substr($out, 0, $headers_end);
        }

        $headers = explode("\n", $out);
        foreach ($headers as $header) {
            if (substr($header, 0, 10) == "Location: ") {
                $target = substr($header, 10);

                return $target;
            }
        }

        return $url;
    }
}

if(!function_exists('theme_get_youtube_id_from_url')) {
    function theme_get_youtube_id_from_url($url)
    {
        if (stristr($url, 'youtu.be/')) {
            @preg_match('/(https:|http:|)(\/\/www\.|\/\/|)(.*?)\/(.{11})/i', $url, $final_ID);
            return $final_ID[4];
        } else {
            @preg_match('/(https:|http:|):(\/\/www\.|\/\/|)(.*?)\/(embed\/|watch.*?v=|)([a-z_A-Z0-9\-]{11})/i', $url, $IDD);
            return $IDD[5];
        }
    }
}

if(!function_exists('get_server_protocol')) {
    function get_server_protocol()
    {
        if(!empty($_SERVER['HTTP_X_FORWARDED_PROTO']))
            return $_SERVER['HTTP_X_FORWARDED_PROTO'] . '://';
        else
            return (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    }
}

if(!function_exists('azibai_url')) {
    function azibai_url($url = '', $domain = false)
    {
        if($domain == true && $url != '') {
            if (defined(ENVIRONMENT) && ENVIRONMENT === 'production'){
                return 'https://' . $url;
            }

            return get_server_protocol() . $url;
        }else {
            if (defined(ENVIRONMENT) && ENVIRONMENT === 'production'){
                return 'https://'. domain_site . $url;
            }

            return get_server_protocol() . domain_site . $url;
        }
        
    }
}

if(!function_exists('trim_protocol')) {
    function trim_protocol($url)
    {
        return str_replace(['http://', 'https://'], '', $url);
    }
}

if(!function_exists('get_shop_link')) {
    function get_shop_link()
    {
        $result = $_SERVER['HTTP_HOST'];
        $arrUrl = explode('.', $_SERVER['HTTP_HOST']);
        if (count($arrUrl) === 3) {
            $result = $arrUrl[0];
        }
        return trim(strip_tags($result));
    }
}
if(!function_exists('shop_url')) {
    function shop_url($shop = '')
    {
        if(empty($shop))
            return is_domain_shop();

        $url = '';
        $protocol = get_server_protocol();
        if(gettype($shop) == "array" && !empty($shop['sho_link'])){
            $url = $protocol . $shop['sho_link'] . '.' . domain_site;
            if (!empty($shop['domain'])) {
                $url = 'http://' . $shop['domain'];
            }
        }
        if(gettype($shop) == "object" && property_exists($shop, 'sho_link')){
            $url = $protocol . $shop->sho_link . '.' . domain_site;
            if (property_exists($shop, 'domain') && ($domain_trim = trim_protocol($shop->domain))) {
                $url = 'http://' . $domain_trim;
            }
        }
        return $url;
    }
}

if(!function_exists('profile_url')) {
    function profile_url($profile = '') {
        if(empty($profile))
            return is_domain_shop();

        $url = '';
        $protocol = get_server_protocol();
        if(gettype($profile) == "array" && !empty($profile['use_id'])){
            $url = $protocol . domain_site . '/profile/' . $profile['use_id'];
            if(!empty($profile['use_slug'])) {
                $url = $protocol . domain_site . '/profile/' . $profile['use_slug'];
            }
            if(!empty($profile['website'])) {
                $url = 'http://' . $profile['website'];
            }
        }

        if(gettype($profile) == "object" && property_exists($profile, 'use_id')){
            $url = $protocol . domain_site . '/profile/' . $profile->use_id;
            if(property_exists($profile, 'use_slug')) {
                $url = $protocol . domain_site . '/profile/' . $profile->use_slug;
            }
            if(property_exists($profile, 'website')) {
                $url = 'http://' . $profile->use_id;
            }
        }

        return $url;
    }
}

/**
 * cắt chuỗi ký tự
 * @param  array  $param [description]
 * @return [type]        [description]
 */
if(!function_exists('cut_string'))
{
    function cut_string($string,$num){
        
        $limit = $num - 1 ;

        $str_tmp = '';

        $arrstr = explode(" ", trim($string));
        if ( count($arrstr) <= $num ) {
            $str_tmp[0] =  $string;
            return $str_tmp; 
        }
        $iCount = ceil(count($arrstr)/$num);
        for ($i=0; $i < $iCount ; $i++) {
            $start = $num*$i;
            for ($j=$start; $j <= $limit + $start; $j++) {
               $str_tmp[$i] .= " " . $arrstr[$j];
            }
            
        }
        return $str_tmp;
    }
}
if(!function_exists('cutStringContent'))
{
    function cutStringContent($string,$num){
        
        $limit = $num - 1 ;

        $str_tmp = '';

        $arrstr = explode(" ", $string);
        
        if ( count($arrstr) <= $num ) { return $string; }
        
        if (!empty($arrstr)) {
            for ( $j=0; $j< count($arrstr) ; $j++) {
                $str_tmp .= " " . $arrstr[$j];
                if ($j == $limit)
                        { break; }
            }
        }
        
        return $str_tmp.'...';
    }
}
if(!function_exists('countText')){
    function countText($string, $num) {
        $iCount = ceil(count(explode(" ", trim($string))) / $num);
        if($iCount == 2) {
          return $num;
        }
        return countText(string,parseInt($num+1));
    }
}
if(!function_exists('limit_the_string')) {
    function limit_the_string($string, $limit = 60)
    {
        $limit = (int)$limit;
        if (strlen($string) < $limit)
            return $string;
        $reg ="/^(.{1,".$limit."}[^\s]*).*$/s";
        return preg_replace($reg, '\\1...', $string);
    }
}
if(!function_exists('is_domain_shop')) {
    function is_domain_shop()
    {
        return preg_replace('/^(?:([^\.]+)\.)?azibai.*$/', '\1', $_SERVER['HTTP_HOST']);
    }
}
if(!function_exists('curl_data')) {
    function curl_data($url, $params_data = array(), $verb = "", $custom_method = "", $method = "GET", $token = '') {
        $aHeader = array('Content-Type: multipart/form-data;');
        if(isset($token) && $token != '') {
            $aHeader[] = 'Authorization: Bearer '.$token;
        }
        
        //dd($params_data);die();
        
        if ($method == 'GET' && !empty($params_data)) 
        {
            $url = sprintf("%s?%s", $url, http_build_query($params_data));
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_POSTFIELDS ,$params_data);
        curl_setopt($ch, CURLOPT_ENCODING ,"");
        curl_setopt($ch, CURLOPT_SAFE_UPLOAD, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER ,$aHeader);
        
        $data = curl_exec($ch);

        curl_close($ch);
        return $data;
    }
}
if(!function_exists('time2str')) {
    function time2str($ts) {
        if(!ctype_digit($ts)) {
            $ts = strtotime($ts);
        }
        $diff = time() - $ts;
        if($diff == 0) {
            return 'now';
        } elseif($diff > 0) {
            $day_diff = floor($diff / 86400);
            if($day_diff == 0) {
                if($diff < 60) return 'vừa xong';
                if($diff < 120) return '1 phút trước';
                if($diff < 3600) return floor($diff / 60) . ' phút trước';
                if($diff < 7200) return '1 giờ trước';
                if($diff < 86400) return floor($diff / 3600) . ' giờ trước';
            }
            if($day_diff == 1) { return 'Hôm qua'; }
            if($day_diff < 7) { return $day_diff . ' ngày trước'; }
            if($day_diff < 31) { return ceil($day_diff / 7) . ' tuần trước'; }
            if($day_diff < 60) { return 'tháng trước'; }
            return date('F Y', $ts);
        } else {
            $diff = abs($diff);
            $day_diff = floor($diff / 86400);
            if($day_diff == 0) {
                if($diff < 120) { return 'khoảng 1 phút'; }
                if($diff < 3600) { return 'khoảng ' . floor($diff / 60) . ' phút'; }
                if($diff < 7200) { return 'khoảng 1 giờ'; }
                if($diff < 86400) { return 'khoảng ' . floor($diff / 3600) . ' giờ'; }
            }
            if($day_diff == 1) { return 'Ngày mai'; }
            if($day_diff < 4) { return date('l', $ts); }
            if($day_diff < 7 + (7 - date('w'))) { return 'tuần tới'; }
            if(ceil($day_diff / 7) < 4) { return 'in ' . ceil($day_diff / 7) . ' tuần'; }
            if(date('n', $ts) == date('n') + 1) { return 'tháng tới'; }
            return date('F Y', $ts);
        }
    }

    function general_group_option_collection($data){
        $data = (array)$data;
        if(empty($data)){
            return '';
        }
        $str = '';
        $collection_group = [];
        foreach ($data as $item){
            if($item->sho_id == 0 && $item->user_id){
                $collection_group['user_'.$item->user_id]['name']   = 'Cá nhân';
                $collection_group['user_'.$item->user_id]['item'][] = '<option value="'.$item->id.'">'.ucfirst($item->name).'</option>';
            }
            if($item->sho_id){
                $collection_group['shop_'.$item->sho_id]['name']  = $item->sho_name;
                $collection_group['shop_'.$item->sho_id]['item'][] = '<option value="'.$item->id.'">'.ucfirst($item->name).'</option>';
            }
        }
        if(!empty($collection_group)){
            foreach ($collection_group as $group) {
                $str .= '<optgroup label="'.$group['name'].'">';
                $str .=     implode('',$group['item']);
                $str .= '</optgroup>';
            }
        }
        return $str;
    }
}
if(!function_exists('block_js')) {
    function block_js($script_tags, $block = 'script_tags')
    {
        $CI = &get_instance();
        $CI->load->vars(array($block => $script_tags));
    }
}
if(!function_exists('block_css')) {
    function block_css($script_tags, $block = 'css_tags')
    {
        $CI = &get_instance();
        $CI->load->vars(array($block => $script_tags));
    }
}
if(!function_exists('array_to_array_keys')) {
    function array_to_array_keys($data, $key)
    {
        if (!$data || !$key)
            return [];
        $temp = [];
        foreach ($data as $item) {
            $temp[] = $item[$key];
        }

        return $temp;
    }
}
if(!function_exists('checkExtensionImage')) {
    function checkExtensionImage($type = ''){
        $aImageType = array(
            'image/bmp'     => '.bmp',
            'image/gif'     => '.gif',
            'image/jpeg'    => '.jpg',
            'image/pjpeg'   => '.jpeg',
            'image/png'     => '.png',
            'image/x-png'   => '.png'
        );
        if(isset($aImageType[$type])) {
            return $aImageType[$type];
        }else {
            return '';
        }
    }
}

if(!function_exists('check_owner')) {
    function check_owner($user_id_login, $shop_id_login, $user_id_item, $shop_id_item){
        if(!$user_id_login || (!$user_id_item && !$shop_id_item))
            return false;

        if($user_id_login == $user_id_item)
            return true;

        if($shop_id_login == $shop_id_item)
            return true;

        return false;
    }
}
if(!function_exists('array_to_key_arrays')) {
    function array_to_key_arrays($data, $key)
    {
        if (!$data || !$key)
            return [];
        $temp = [];
        foreach ($data as $index => $item) {
            if(isset($item[$key])){
                $temp[$item[$key]] = $item;
            }
        }

        return $temp;
    }
}

if(!function_exists('get_current_full_url')) {
    function get_current_full_url() {
        return get_server_protocol() . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    }
}

if(!function_exists('get_current_base_url')) {
    function get_current_base_url($url) {
        $result = parse_url($url);
        return $result['scheme']."://".$result['host'];
    }
}
//$crop = [
//    'pre_fix' => $prefix,
//    'width'   => $optimize_img['data']['pc']['width_crop'],
//    'height'  => $optimize_img['data']['pc']['height_crop'],
//];
if(!function_exists('get_mode_image')) {
    function get_mode_image($extend_img, $mode = 'pc', $crop = false){
        if($extend_img && ($extend_img = @json_decode($extend_img, true))){
            if(isset($extend_img[$mode])){
                $dir = $extend_img[$mode]['dir'];
                if($crop && ($img_crop = $extend_img[$mode]['crop'])){
                    return ($dir && $img_crop['pre_fix'] ? ($dir .'/'.$img_crop['pre_fix']) : ($dir ? $dir : null));
                }
                return $dir;
            }
        }
        return null;
    }
}

if(!function_exists('convert_percent_encoding')) {
    function convert_percent_encoding($title_) {
        $title_ = str_replace('&quot;', '"', $title_);
        $title_ = str_replace('&curren;', '#', $title_);
        $title_ = str_replace("&percnt;", "%", $title_);
        $title_ = str_replace('&apos;', "'", $title_);
        $title_ = str_replace('&ndash;', '-', $title_);
        $title_ = str_replace('&lt;', '<', $title_);
        $title_ = str_replace('&frasl;', '\\', $title_);
        $title_ = str_replace('&gt;', '>', $title_);
        $title_ = str_replace('&tilde;', '˜', $title_);
        $title_ = str_replace('&amp;', '&', $title_);
        $title_ = str_replace("&lsquo;", '‘', $title_);
        $title_ = str_replace('&rsquo;', '’', $title_);
        $title_ = str_replace('&permil;', '‰', $title_);
        $title_ = urlencode($title_);
        $title_ = str_replace(array('%3Cbr%3E', '%3Cbr%2F%3E', '%3Cbr+%2F%3E'), '%0A', $title_);
        return $title_;
    }
}

if(!function_exists('convert_percent_decoding')) {
    function convert_percent_decoding($title_) {
        $title_ = str_replace('&quot;', '"', $title_);
        $title_ = str_replace('&curren;', '#', $title_);
        $title_ = str_replace("&percnt;", "%", $title_);
        $title_ = str_replace('&apos;', "'", $title_);
        $title_ = str_replace('&ndash;', '-', $title_);
        $title_ = str_replace('&lt;', '<', $title_);
        $title_ = str_replace('&frasl;', '\\', $title_);
        $title_ = str_replace('&gt;', '>', $title_);
        $title_ = str_replace('&tilde;', '˜', $title_);
        $title_ = str_replace('&amp;', '&', $title_);
        $title_ = str_replace("&lsquo;", '‘', $title_);
        $title_ = str_replace('&rsquo;', '’', $title_);
        $title_ = str_replace('&permil;', '‰', $title_);
        return $title_;
    }
}

if(!function_exists('curl_multi_level_arr')) {
    function curl_multi_level_arr($url, $params_data = array(), $method = "GET", $token = '')
    {
        $fields_string = http_build_query($params_data);
        if ($method == 'GET' && !empty($params_data))
        {
            $url = sprintf("%s?%s", $url, http_build_query($params_data));
        }

        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        if($token){
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Authorization: Bearer '.$token
            ));
        }
        $res = curl_exec($ch);
        curl_close($ch);
        return $res;
    }
}
?>