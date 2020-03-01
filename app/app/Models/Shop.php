<?php

namespace App\Models;

use App\BaseModel;
use App\Models\UserFollow;
use App\Models\User;

/**
 * Shop model
 *
 */
class Shop extends BaseModel {

    /**
     * The table associated with the model.
     *
     * @var string
     */
    const TYPE_AFFILIATE = 0;
    const TYPE_BRANCH = 3;
    const STATUS_ACTIVE =1;

    protected $table = 'tbtt_shop';

    protected $primaryKey = 'sho_id';
    
    public $timestamps = false;

    public static function tableName() {
        return 'tbtt_shop';
    }

    protected $defaults = array(
        'sho_address' => '',
        'sho_limit_ctv' => 0,
        'sho_descr'=>'',
        'sho_bg_repeat_x' => 0,
        'sho_bg_repeat_y' => 0,
        'sho_bgcolor' => '',
        'sho_cat_style' => 0,
        'sho_provinces' => '',
        'sho_kho_province' => 0,
        'sho_kho_district' => '',
        'sho_kho_address' => '',
        'sho_yahoo' => '',
        'sho_skype' => '',
        'sho_facebook' => '',
        'sho_twitter' => '',
        'sho_youtube' => '',
        'sho_google_plus' => '',
        'sho_vimeo' => '',
        'sho_website' => '',
        'sho_saleoff' => 0,
        'sho_quantity_product' => 0,
        'sho_introduction' => '',
        'sho_company_profile' => '',
        'sho_certificate' => '',
        'sho_trade_capacity' => '',
        'sho_warranty' => '',
        'sho_guarantee' => 0,
        'sho_users_required' => '',
        'shop_id_category' => 0,
        'shop_fax' => 0,
        'sho_dir_bging' => '',
        'sho_bgimg' => '',
        'domain' => '',
        'shop_begindate_guarantee' => 0,
        'shop_enddate_guarantee' => 0,
        'shop_enddate_guarantee' => 0,
        'shop_video' => 0,
        'sho_discount_rate' => 0
    );

    public function __construct(array $attributes = array())
    {
        $this->setRawAttributes($this->defaults, true);
        parent::__construct($attributes);
    }
    
    public function rule(){
        return $this->hasOne('App\Models\ShopRule','sho_id','sho_id');
    }

    protected $fillable = [
        'sho_name',
        'sho_descr',
        'sho_link',
        'sho_logo',
        'sho_dir_logo',
        'sho_banner',
        'sho_dir_banner',
        'sho_bgimg',
        'sho_bg_repeat_x',
        'sho_bg_repeat_y',
        'sho_bgcolor',
        'sho_address',
        'sho_category',
        'sho_cat_style',
        'sho_province',
        'sho_district',
        'sho_provinces',
        'sho_kho_province',
        'sho_kho_district',
        'sho_kho_address',
        'sho_phone',
        'sho_mobile',
        'sho_email',
        'sho_yahoo',
        'sho_skype',
        'sho_facebook',
        'sho_twitter',
        'sho_youtube',
        'sho_google_plus',
        'sho_vimeo',
        'sho_website',
        'sho_style',
        'sho_saleoff',
        'sho_status',
        'sho_user',
        'sho_view',
        'sho_quantity_product',
        'sho_quantity_product',
        'sho_begindate',
        'sho_enddate',
        'sho_introduction',
        'sho_company_profile',
        'sho_certificate',
        'sho_trade_capacity',
        'sho_warranty',
        'sho_guarantee',
        'sho_users_required',
        'shop_id_category',
        'shop_fax',
        'sho_facebook',
        'sho_dir_bging',
        'shop_begindate_guarantee',
        'shop_enddate_guarantee',
        'sho_is_hot',
        'sho_hot_order',
        'sho_guarantee_end',
        'shop_video',
        'shop_type',
        'shop_group',
        'domain',
        'sho_company_code',
        'sho_package',
        'sho_package_start',
        'sho_package_end',
        'sho_discount_rate',
        'sho_description',
        'sho_keywords',
        'sho_shipping'
    ];
    public function getBanner() {
        $shop = clone($this);
        
        if(empty($shop->shopUser)){
            return;
        }
        
        $user = $shop->shopUser;
    
        if (in_array($user->use_group, [User::TYPE_BranchUser, User::TYPE_AffiliateUser])) {
            $parent = self::where('sho_user', $user->parent_id)->select('sho_banner','sho_user','sho_logo','sho_dir_logo', 'sho_dir_banner')->first();
            if(empty($parent)){
                return;
            }
            $parent_user = $parent->user;
            if(empty($parent_user)){
                return;
            }
            if ($user->use_group == User::TYPE_BranchUser && $parent_user->use_group === User::TYPE_StaffStoreUser) {
                $parent = self::where('sho_user', $parent_user->parent_id)->select('sho_banner','sho_logo','sho_dir_logo', 'sho_dir_banner')->first();
            } else if ($user->use_group == User::TYPE_AffiliateUser && $parent_user->use_group == User::TYPE_BranchUser) {
                $parent = self::where('sho_user', $parent_user->use_id)->select('sho_banner','sho_logo','sho_dir_logo', 'sho_dir_banner')->first();
              

            }
          
       
            if (!empty($parent)) {
                if (!$this->sho_banner || $this->sho_banner === '' || $this->sho_banner == 'default-banner.jpg') {
                    $this->sho_dir_banner = $parent->sho_dir_banner;
                    $this->sho_banner = $parent->sho_banner;
                }
                if (!$this->sho_logo || $this->sho_logo === '' || $this->sho_logo == 'default-logo.png') {
                    $this->sho_logo = $parent->sho_logo;
                    $this->sho_dir_logo = $parent->sho_dir_logo;
                }
            }
        }
        return;
    }

    public function publicInfo() {
        $this->province;
        $this->district;
        $this->khoDistrict;
        $this->khoProvince;
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $duoi = '.' . substr(env('APP_FONTEND_URL', 'http://localhost'), strlen($protocol), strlen(env('APP_FONTEND_URL', 'http://localhost')));
        $this->domainLink = '';
        if (!empty($this->domain)) {
            $this->domainLink = $protocol . $this->domain;
        } elseif (!empty($this->sho_link)) {
            $this->domainLink = $protocol . $this->sho_link . $duoi;
        }
        $this->getBanner();
  
        return $this;
    }

    public function province() {
        return $this->hasOne('App\Models\Province', 'pre_id', 'sho_province')->select('pre_name', 'pre_id');
    }
    public function user() {
        return $this->hasOne('App\Models\User', 'use_id', 'sho_user');
    }
    public function shopUser() {
        return $this->hasOne('App\Models\User', 'use_id', 'sho_user');
    }

    public function district() {
        return $this->hasOne('App\Models\District', 'DistrictCode', 'sho_district')->select('DistrictName', 'ProvinceName', 'DistrictCode');
    }
    
      public function khoDistrict() {
        return $this->hasOne('App\Models\District', 'DistrictCode', 'sho_kho_district')->select('DistrictName', 'ProvinceName', 'DistrictCode');
    }
    
    public function khoProvince(){
         return $this->hasOne('App\Models\Province', 'pre_id', 'sho_kho_province')->select('pre_name', 'pre_id');

    }

    public function hasFollow($use_id) {
        return UserFollow::where([
            'user_id' => $this->sho_user,
            'follower' => $use_id,
            'hasFollow' => true
        ])->count() > 0;
    }

}
