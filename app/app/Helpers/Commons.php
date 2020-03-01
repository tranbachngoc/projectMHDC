<?php
namespace App\Helpers;
use PhoneNumberUtil;
use PhoneNumberFormat;
use App\Models\User;
use DateTime;
class Commons {

    public static function grenerateDropDownButton($title ='Actions',$menus,$options = ['pull-right'=>true]) {
        $pullright = isset($options['pull-right']) ? 'pull-right' : 'pull-right';
        $color = isset($options['color']) ? $options['color']:'green';
        $buttonDropDown = '<div class="actions" >';
        $buttonDropDown .= '<div class="btn-group">';
        $buttonDropDown .= '<a class="btn btn-sm '.$color.' dropdown-toggle" href="javascript:;" data-toggle="dropdown" aria-expanded="true">';
        $buttonDropDown .= $title;
        $buttonDropDown .= '<i class="fa fa-angle-down"></i>';
        $buttonDropDown .= '</a>';
        $buttonDropDown .= '<ul class="dropdown-menu ' . $pullright . '">';

        foreach ($menus as $menu) {
            $buttonDropDown .= '<li>' . $menu . '</li>';
        }
        $buttonDropDown .= '</ul>';
        $buttonDropDown .= '</div>';
        $buttonDropDown .='</div>';
        return $buttonDropDown;
    }

    public static function formatDistance($distance, $duration) {
        $minus = gmdate("i", $duration);
        $hours = gmdate("H", $duration);
        return [
            'distance'=> [
                'text' => $distance . ' km',
                'value' => $distance
            ],
            'duration'=> [
                'text' => ($hours != 0 ? $hours.' giờ ' : '').($minus.' phút'),
                'value' => $duration
            ]
        ];
    }

    public static function getDetailLinkDriver($item){
        return link_to_action('Backend\DriverController@view',$item['name'],['id'=>$item['id']]);
    }

    public static function getDetailLinkCustomer($item){
        return link_to_action('Backend\CustomerController@detail',$item['name'],['id'=>$item['id']]);
    }

    public static function getPhone($phone,$format = PhoneNumberFormat::NATIONAL,$countryCode = 'VN'){
        $phoneUtil = PhoneNumberUtil::getInstance();
        $numberPrototype = $phoneUtil->parse($phone, $countryCode);

        return $phoneUtil->format($numberPrototype, $format) . "\n";

    }

    public static function formatPhoneNumber($phone,$format = PhoneNumberFormat::NATIONAL,$countryCode){
        $phoneUtil = PhoneNumberUtil::getInstance();
        $phoneNumberObject = $phoneUtil->parse($phone, $countryCode);
        $nationNalPhone = $phoneUtil->format($phoneNumberObject, PhoneNumberFormat::NATIONAL);
        $nationNalPhone = str_replace(' ', '', $nationNalPhone);
        return $nationNalPhone;
    }

    public static function regexPhone() {
        return '/^\+?(84|0)(1\d{9}|8\d{8}|9\d{8})$/';
    }

    public static function validNick() {
        return '/[a-zA-Z0-9]$/';
    }
    public static function homePhone() {
        return '/^[0-9]{8,12}$/';
    }
    public static function isPhone() {
        return '/^\+?(0)(1\d{9}|8\d{8}|9\d{8})$/';
    }

    public static function removeSign($string) {
        $trans = array(
            "đ" => "d", "ă" => "a", "â" => "a", "á" => "a", "à" => "a",
            "ả" => "a", "ã" => "a", "ạ" => "a",
            "ấ" => "a", "ầ" => "a", "ẩ" => "a", "ẫ" => "a", "ậ" => "a",
            "ắ" => "a", "ằ" => "a", "ẳ" => "a", "ẵ" => "a", "ặ" => "a",
            "é" => "e", "è" => "e", "ẻ" => "e", "ẽ" => "e", "ẹ" => "e",
            "ế" => "e", "ề" => "e", "ể" => "e", "ễ" => "e", "ệ" => "e",
            "í" => "i", "ì" => "i", "ỉ" => "i", "ĩ" => "i", "ị" => "i",
            "ư" => "u", "ô" => "o", "ơ" => "o", "ê" => "e",
            "Ư" => "u", "Ô" => "o", "Ơ" => "o", "Ê" => "e",
            "ú" => "u", "ù" => "u", "ủ" => "u", "ũ" => "u", "ụ" => "u",
            "ứ" => "u", "ừ" => "u", "ử" => "u", "ữ" => "u", "ự" => "u",
            "ó" => "o", "ò" => "o", "ỏ" => "o", "õ" => "o", "ọ" => "o",
            "ớ" => "o", "ờ" => "o", "ở" => "o", "ỡ" => "o", "ợ" => "o",
            "ố" => "o", "ồ" => "o", "ổ" => "o", "ỗ" => "o", "ộ" => "o",
            "ú" => "u", "ù" => "u", "ủ" => "u", "ũ" => "u", "ụ" => "u",
            "ứ" => "u", "ừ" => "u", "ử" => "u", "ữ" => "u", "ự" => "u",
            "ý" => "y", "ỳ" => "y", "ỷ" => "y", "ỹ" => "y", "ỵ" => "y",
            "Ý" => "Y", "Ỳ" => "Y", "Ỷ" => "Y", "Ỹ" => "Y", "Ỵ" => "Y",
            "Đ" => "D", "Ă" => "A", "Â" => "A", "Á" => "A", "À" => "A",
            "Ả" => "A", "Ã" => "A", "Ạ" => "A",
            "Ấ" => "A", "Ầ" => "A", "Ẩ" => "A", "Ẫ" => "A", "Ậ" => "A",
            "Ắ" => "A", "Ằ" => "A", "Ẳ" => "A", "Ẵ" => "A", "Ặ" => "A",
            "É" => "E", "È" => "E", "Ẻ" => "E", "Ẽ" => "E", "Ẹ" => "E",
            "Ế" => "E", "Ề" => "E", "Ể" => "E", "Ễ" => "E", "Ệ" => "E",
            "Í" => "I", "Ì" => "I", "Ỉ" => "I", "Ĩ" => "I", "Ị" => "I",
            "Ư" => "U", "Ô" => "O", "Ơ" => "O", "Ê" => "E",
            "Ư" => "U", "Ô" => "O", "Ơ" => "O", "Ê" => "E",
            "Ú" => "U", "Ù" => "U", "Ủ" => "U", "Ũ" => "U", "Ụ" => "U",
            "Ứ" => "U", "Ừ" => "U", "Ử" => "U", "Ữ" => "U", "Ự" => "U",
            "Ó" => "O", "Ò" => "O", "Ỏ" => "O", "Õ" => "O", "Ọ" => "O",
            "Ớ" => "O", "Ờ" => "O", "Ở" => "O", "Ỡ" => "O", "Ợ" => "O",
            "Ố" => "O", "Ồ" => "O", "Ổ" => "O", "Ỗ" => "O", "Ộ" => "O",
            "Ú" => "U", "Ù" => "U", "Ủ" => "U", "Ũ" => "U", "Ụ" => "U",
            "Ứ" => "U", "Ừ" => "U", "Ử" => "U", "Ữ" => "U", "Ự" => "U",
            ' ' => '-', "'" => '', '"' => '', '“' => '', '”' => '', '’' => '',
            ':' => '', '.' => '', ',' => '', '®' => '(R)', '©' => '(C)');
        //remove any '-' from the string they will be used as concatonater
        $str = str_replace('-', ' ', $string);
        $str = strtr($str, $trans);
        // remove any duplicate whitespace, and ensure all characters are alphanumeric
        $str = preg_replace(array('/\s+/', "/[^a-z0-9_\s-ءاأإآؤئبتثجحخدذرزسشصضطظعغفقكلمنهويةى]#u/"), array('-', ''), $str);
        // lowercase and trim
        $str = trim(strtolower($str), '-');
        return $str;
    }

    public static function toSlug($string) {
        return Commons::removeSign($string).'.html';
    }

    public static function randomOrderBy() {
        $i = rand(0, 1);
        if ($i == 0) {
            return 'DESC';
        }
        return 'ASC';
    }

   public function injection($str) {
        $str = str_replace("~", "&tilde;", $str);
        $str = str_replace("`", "&lsquo;", $str);
        $str = str_replace("#", "&curren;", $str);
        $str = str_replace("%", "&permil;", $str);
        $str = str_replace("'", "&rsquo;", $str);
        $str = str_replace("\"", "&quot;", $str);
        $str = str_replace("\\", "&frasl;", $str);
        $str = str_replace("--", "&ndash;&ndash;", $str);
        $str = str_replace("ar(", "ar&Ccedil;", $str);
        $str = str_replace("Ar(", "Ar&Ccedil;", $str);
        $str = str_replace("aR(", "aR&Ccedil;", $str);
        $str = str_replace("AR(", "AR&Ccedil;", $str);
        return $str;
    }

    public function html($str)
	{
		return htmlspecialchars($str);
	}

	public function injection_html($str)
	{
		return $this->injection($this->html($str));
	}

	public function clear($str) {
        $str = str_replace("~", "", $str);
        $str = str_replace("`", "", $str);
        $str = str_replace("#", "", $str);
        $str = str_replace("%", "", $str);
        $str = str_replace("&", "", $str);
        $str = str_replace("'", "", $str);
        $str = str_replace("\"", "", $str);
        $str = str_replace("\\", "", $str);
        $str = str_replace("/", "", $str);
        $str = str_replace("<", "", $str);
        $str = str_replace(">", "", $str);
        return $str;
    }

    public static function buildPrice($product, $group, $af = false) {

        $salePrice = $product->pro_cost;
        $saleOff = 0;
        $em_off = 0;
        $af_off = 0;
        $em_sale = 0;
        $af_sale = 0;
        $af_rate = 0;
        $off_sale = $salePrice;

        if ($product->off_amount > 0) {
            $salePrice -= $product->off_amount;
            $saleOff += $product->off_amount;
            $off_sale = $salePrice;
        }

        // Check employee discount
        if ($group == User::TYPE_AffiliateStoreUser) {
            /* $salePrice -= $product->em_off;
              $saleOff += $product->em_off;
              $em_off = $product->em_off;
              $em_sale = $salePrice; */
        } else {
            if ($af == true) {
                $salePrice -= $product->af_off;
                $saleOff += $product->af_off;
                $af_off = $product->af_off;
                $af_sale = $salePrice;
            }
        }


        // Check aff discount
        return array('salePrice' => $salePrice, 'saleOff' => $saleOff, 'em_off' => $em_off, 'af_off' => $af_off, 'em_sale' => $em_sale, 'af_sale' => $af_sale, 'off_sale' => $off_sale, 'af_rate' => $af_rate);
    }

    public static function getDiscountQuery()
    {
        $curTime = time();
        return ', IF(
                tbtt_product.pro_saleoff = 1 AND (('.$curTime.' >= tbtt_product.begin_date_sale AND '.$curTime.' <= tbtt_product.end_date_sale) OR (tbtt_product.begin_date_sale = 0 AND tbtt_product.end_date_sale = 0 )),
                CASE
                  WHEN tbtt_product.pro_type_saleoff = 2
                  THEN tbtt_product.pro_saleoff_value
                  WHEN tbtt_product.pro_type_saleoff = 1
                  THEN CAST(
                    tbtt_product.pro_saleoff_value AS DECIMAL (10, 5)
                  ) * tbtt_product.pro_cost / 100
                END,
                0
              ) AS off_amount
              , IF(
                tbtt_product.pro_saleoff = 1 AND (('.$curTime.' >= tbtt_product.begin_date_sale AND '.$curTime.' <= tbtt_product.end_date_sale) OR (tbtt_product.begin_date_sale = 0 AND tbtt_product.end_date_sale = 0 )),
                CASE
                  WHEN tbtt_product.pro_type_saleoff = 2
                  THEN 0
                  WHEN tbtt_product.pro_type_saleoff = 1
                  THEN tbtt_product.pro_saleoff_value
                END,
                0
              ) AS off_rate,

              IF(
                tbtt_product.dc_amt > 0,
                CAST(
                  tbtt_product.dc_amt AS DECIMAL (10, 5)
                ),
                IF(
                  tbtt_product.dc_rate > 0,
                  CAST(
                    tbtt_product.dc_rate AS DECIMAL (10, 5)
                  ) * tbtt_product.pro_cost / 100,
                  0
                )
              ) AS em_off,
              IF(
                tbtt_product.dc_amt > 0,
                0,
                IF(
                  tbtt_product.dc_rate > 0,
                  tbtt_product.dc_rate,
                  0
                )
              ) AS em_rate,

              IF(
                tbtt_product.af_dc_amt > 0,
                CAST(
                  tbtt_product.af_dc_amt AS DECIMAL (10, 5)
                ),
                IF(
                  tbtt_product.af_dc_rate > 0,
                  CAST(
                    tbtt_product.af_dc_rate AS DECIMAL (10, 5)
                  ) * tbtt_product.pro_cost / 100,
                  0
                )
              ) AS af_off,
              IF(
                tbtt_product.af_dc_amt > 0,
                0,
                IF(
                  tbtt_product.af_dc_rate > 0,
                  tbtt_product.af_dc_rate,
                  0
                )
              ) AS af_rate';
    }

    public function rand_string_limit($length)
    {
        $str = "";
        $chars = "123456789";
        $size = strlen($chars);
        for ($i = 0; $i < $length; $i++) {
            $str .= $chars[rand(0, $size - 1)];
        }
        $string = $str . date("s") . date("imd");
        $this->load->model('showcart_model');
        do {
            $get = $this->showcart_model->fetch('shc_code', 'shc_code="' . $string . '"', '');
        } while (count($get) > 0);
        return $string;
    }

    static function generateRandomString($length = 6) {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    static function toQueryString($query) {
        $bindings = $query->getBindings();
        $sql = $query->toSql();
        foreach ($bindings as $binding) {
            $value = is_numeric($binding) ? $binding : "'" . $binding . "'";
            $sql = preg_replace('/\?/', $value, $sql, 1);
        }
        return str_replace('\\', '\\\\', $sql);
    }

    static function size_thumbnail($pathImage = 'media/images/product/default/none.gif', $maxWidth = 120, $maxHeight = 120) {
        if (file_exists($pathImage)) {
            $infoImage = @getimagesize($pathImage);
            $width = $infoImage[0];
            $height = $infoImage[1];
            $percent = $width / $height;
            $width = min($width, $maxWidth);
            $height = min($width / $percent, $maxHeight);
            $width = $height * $percent;
            return array('width' => $width, 'height' => $height);
        } else {
            return array('width' => $maxWidth, 'height' => $maxHeight);
        }
    }

    public static function convertDateTotime($date) {
        return (new DateTime($date))->getTimestamp();

    }

    public static function getLatLng($address)
    {
        $address = urlencode($address);
        if($address == "") {
            return ['lat' => 0, 'lng' => 0];
        }
        $lat = 0;
        $lng = 0;
        $geocode = file_get_contents('http://maps.google.com/maps/api/geocode/json?address='.$address.'&sensor=false');
        if($geocode) {
            $output= json_decode($geocode);

            if($output) {
                if( isset($output->results[0]->geometry->location->lat)) {
                    $lat = $output->results[0]->geometry->location->lat;
                }
                if( isset($output->results[0]->geometry->location->lng)) {
                    $lng = $output->results[0]->geometry->location->lng;
                }

                return ['lat' => $lat, 'lng' => $lng];

            }
            else {

                return ['lat' => $lat, 'lng' => $lng];
            }
        }
        else {

            return ['lat' => $lat, 'lng' => $lng];
        }



    }


}
