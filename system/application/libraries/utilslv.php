<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 11/25/2015
 * Time: 14:56 PM
 */
class utilSlv
{
    private static $m_pInstance;
    var $_css = array();
    var $_script = array();
    var $_head = array();
    var $_iefix = array();
    var $_url = '';
    var $_seo = array();
    var $_footer = array();
    var $_config = '';
    var $_inlineScript = '';

    public function __construct($sAliasDomain = '')
    {

        // Add all page assest
        $this->_url = ($sAliasDomain != '') ? $sAliasDomain : base_url();
        $this->_config = ' var siteUrl = "'.$this->_url.'";';
        
        /*
        $this->addHead('<link rel="icon" href="' . $this->_url . 'templates/home/images/favicon.ico" type="image/x-icon" />');
        $this->addHead('<link rel="shortcut icon" href="' . $this->_url . 'templates/home/images/favicon.ico" type="image/x-icon" />');
        $this->addHead('<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />');
        $this->addHead('<meta name="alexaVerifyID" content="J_mnEtPUDglQ039W2oyKZBA5lws" />');
        $this->addHead('<meta name="google-site-verification" content="2I2JANiiw42OZIbSWLtSDOMruRC-XYvKdxn3w8xPWfQ" />');
        $this->addHead('<meta name="revisit-after" content="1 days" />');
        $this->_seo['title'] = settingTitle;
        $this->_seo['keywords'] = settingKeyword;
        $this->_seo['description'] = settingDescr;
        $this->_seo['phone'] = settingPhone;
        $this->addStyleSheet($this->_url . 'templates/home/css/bootstrap.min.css');
        $this->addStyleSheet($this->_url . 'templates/home/css/font-awesome.min.css');
        $this->addStyleSheet($this->_url . 'templates/home/css/style-azibai.css');
        $this->addStyleSheet($this->_url . 'templates/home/css/style_azibai_tung.css');
        $this->addStyleSheet($this->_url . 'templates/home/css/style_azibai_viet.css');
        $this->addStyleSheet($this->_url . 'templates/home/css/all.css');
        $this->addStyleSheet($this->_url . 'templates/home/css/1000px.css');
        $this->addIE('<!--[if ie]>     <link type="text/css" rel="stylesheet" href="' . $this->_url . 'templates/home/css/ie.css" />     <![endif]--> <!--[if ie 8]>     <link type="text/css" rel="stylesheet" href="' . $this->_url . 'templates/home/css/ie8.css" />     <![endif]--> <!--[if ie 7]> <link type="text/css" rel="stylesheet" href="' . $this->_url . 'templates/home/css/ie7.css" />     <link type="text/css" rel="stylesheet" href="' . $this->_url . 'templates/home/css/move/views-home-product-category.css" />         <![endif]-->');

        $this->addScript($this->_url . 'templates/home/js/stuHover.js');
        $this->addScript($this->_url . 'templates/home/js/jquery.js');
        $this->addScript($this->_url . 'templates/home/js/jquery.simpletip-1.3.1.min.js');
        $this->addScript($this->_url . 'templates/home/js/general_en.js');
        $this->addScript($this->_url . 'templates/home/js/jalert/jquery.alerts.js');
        $this->addScript($this->_url . 'templates/home/js/js-azibai.js');
        $this->addScript($this->_url . 'templates/home/js/js-azibai-tung.js');
        $this->addScript($this->_url . 'templates/home/js/general.js');
        $this->addScript($this->_url . 'templates/home/js/jquery.tooltip.js');
        $this->addScript($this->_url . 'templates/home/js/menu.js');
        $this->addScript($this->_url . 'templates/home/js/jquery.dcverticalmegamenu.1.3.js');
        $this->addScript($this->_url . 'templates/home/js/jquery.hoverIntent.minified.js');
        $this->addScript($this->_url . 'templates/home/js/swfobject.js');
        $this->addScript($this->_url . 'templates/home/js/fancybox/jquery.mousewheel-3.0.4.pack.js');
        $this->addScript($this->_url . 'templates/home/js/jquery.bgiframe.min.js');
        $this->addScript($this->_url . 'templates/home/js/jquery.ajaxQueue.js');
        $this->addScript($this->_url . 'templates/home/js/jquery.autocomplete.js');
        $this->addScript($this->_url . 'templates/home/js/jquery.validate.js');
        $this->addScript($this->_url . 'templates/home/js/vtip.js');
        $this->addScript($this->_url . 'templates/home/js/jquery.jcarousellite-1.0.1.min.js');
        $this->addScript($this->_url . 'templates/home/js/affiliate.js');
        $this->_footer['url'] = $this->_url;
        $this->_footer['socialFacebook'] = socialFacebook;
        $this->_footer['socialTwitter'] = socialTwitter;
        $this->_footer['socialGooglePlus'] = socialGooglePlus;
        $this->_footer['socialLinkedin'] = socialLinkedin;
        $this->_footer['socialYoutube'] = socialYoutube;
        $this->_footer['socialIntergram'] = socialIntergram;
        $this->_footer['socialPinterest'] = socialPinterest;
        $this->_footer['socialVimeo'] = socialVimeo;
        $this->_footer['socialTumblr'] = socialTumblr;
        $this->_footer['socialSkype'] = socialSkype;
        $this->_footer['settingAddress_1'] = settingAddress_1;
        $this->_footer['settingPhone'] = settingPhone;
        $this->_footer['settingEmail_1'] = settingEmail_1;
        $this->_footer['settingWebsite'] = settingWebsite;
        */


    }

    public static function getInstance($sAliasDomain = '')
    {
        if (!self::$m_pInstance) {
            self::$m_pInstance = new utilSlv($sAliasDomain);
        }
        return self::$m_pInstance;
    }

    public function addStyleSheet($file)
    {
        array_push($this->_css, $file);
    }

    public function addScript($file)
    {
        array_push($this->_script, $file);
    }

    public function addHead($text)
    {
        array_push($this->_head, $text);
    }

    public function addIE($text)
    {
        array_push($this->_iefix, $text);
    }
    public function  addInlineScript($text){
        $this->_inlineScript .= $text;
    }
    public function getScript()
    {
        return $this->_script;
    }

    public function getStyleSheet()
    {
        return $this->_css;
    }

    public function getHead()
    {
        return $this->_head;
    }

    public function setUrl($url)
    {
        $this->_url = $url;
    }

    public function getData()
    {
        return array('scripts' => $this->_script, 'inline_script'=>$this->_inlineScript, 'head' => $this->_head, 'style' => $this->_css, 'ie' => $this->_iefix, 'url' => $this->_url, 'footer' => $this->_footer, 'seo' => $this->_seo, 'config'=>$this->_config);
    }
    
    //by Phuc
    public function my_number_format($number, $dec_point, $thousands_sep) 
    { 
        $was_neg = $number < 0; // Because +0 == -0 
        $number = abs($number); 

        $tmp = explode(',', $number); 
        $out = number_format($tmp[0], 0, $dec_point, $thousands_sep); 
        if (isset($tmp[1])) $out .= $dec_point.$tmp[1]; 

        if ($was_neg) $out = "-$out"; 

        return str_replace(",", ".", $out); 
    }
    
    public function getDatesFromRange($start, $end) {
        $interval = new DateInterval('P1D');

        $realEnd = new DateTime($end);
        $realEnd->add($interval);

        $period = new DatePeriod(
             new DateTime($start),
             $interval,
             $realEnd
        );

        foreach($period as $date) { 
            $array[] = $date->format('Y-m-d'); 
        }

        return $array;
    }
    
    public function getMonthFromRange() {
        $x = 1;
        $month = array();
        while($x <= 12){
            $month[] = $x;
            $x++;
        }
        return $month;
    }
    
    public function getYearFromRange($year) {
        
        $_year      =   array();
        $_year[]    =   $year - 1;
        $_year[]    =   $year;
        $_year[]    =   $year + 1;
        
        return $_year;
    }
}