<?php

namespace App\Models;

use App\BaseModel;
use App\Helpers\Commons;
use DB;
use App\Observers\ProductObserver;
/**
 * Product model
 *
 */
class Product extends BaseModel {

    const P_TYPE_BUY = '06';
    const P_TYPE_EAT = '04';
    const P_TYPE_NEWS = '03';
    const P_TYPE_PLACE = '07';
    const TYPE_COUPON = 2;
    const TYPE_DEFAULT = 0;
    const TYPE_SERVICE = 1;
    const TYPE_AFFILIATE_PERCENT = 1;
    const TYPE_AFFILIATE_CURRENCY = 2;
    const STATUS_ACTIVE = 1;
    const PRICE_TYPE_DEFAULT = 1;
    const PRICE_TYPE_PROMOTION_MONEY = 2; // hoa hồng tiền
    const PRICE_TYPE_PROMOTION_PERCENT = 3; // hoa hồng %
    const IS_AFF_PRODUCT = 1;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tbtt_product';

    protected $primaryKey = 'pro_id';
    
    public $timestamps = false;
    protected $fillable = array(
        'pro_name',
        'pro_sku',
        'pro_descr',
        'pro_keyword',
        'pro_cost',
        'pro_currency',
        'pro_hondle',
        'pro_saleoff',
        'pro_province',
        'pro_category',
        'pro_begindate',
        'pro_enddate',
        'pro_detail',
        'pro_image',
        'pro_dir',
        'pro_user',
        'pro_poster',
        'pro_address',
        'pro_phone',
        'pro_mobile',
        'pro_email',
        'pro_yahoo',
        'pro_skype',
        'pro_status',
        'pro_view',
        'pro_buy',
        'pro_comment',
        'pro_vote_cost',
        'pro_vote_quanlity',
        'pro_vote_model',
        'pro_vote_service',
        'pro_vote_total',
        'pro_vote',
        'pro_reliable',
        'pro_saleoff_value',
        'is_product_affiliate',
        'af_amt',
        'af_rate',
        'af_dc_amt',
        'af_dc_rate',
        'pro_show',
        'pro_type_saleoff',
        'pro_manufacturer_id',
        'pro_instock',
        'pro_weight',
        'pro_length',
        'pro_width',
        'pro_height',
        'pro_minsale',
        'pro_vat',
        'pro_quality',
        'pro_made_from',
        'pro_warranty_period',
        'pro_video',
        'created_date',
        'begin_date_sale',
        'end_date_sale',
        'pro_type',
        'up_date'
    );
    
    protected $cast = [
        'pro_order' => 'integer'
    ];
    protected $defaults = array(
        'pro_type' => 0,
        'pro_vip' => 0,
        'pro_type_saleoff' => 0,
        'is_product_affiliate' => 0,
        'up_date' => 0,
        'is_asigned_by_admin' => 0,
        'id_shop_cat' => 0,
        'pro_of_shop' => 0,
        'pro_type_saleoff'=>0,
        'pro_manufacturer_id'=>0,
        'pro_instock'=>0,
        'pro_video'=>''
    );

    public function __construct(array $attributes = array())
    {
        $this->setRawAttributes($this->defaults, true);
        parent::__construct($attributes);
    }

    public static function tableName() {
        return 'tbtt_product';
    }

    /**
     * Category relationship
     * @return App\Models\Category
     */
    public function category() {
        return $this->hasOne('App\Models\Category', 'cat_id', 'pro_category')->select(['cat_id','cate_type','cat_status','cat_level', 'cat_name', 'cat_descr','parent_id']);
    }

    /**
     * Shop relationship
     * @return App\Models\Shop
     */
    public function shop() {
        return $this->hasOne('App\Models\Shop', 'sho_user', 'pro_user')->select([ 'sho_id', 
                'sho_name',
                'sho_descr',
                'sho_link',
                'sho_facebook',
                'sho_skype',
                'sho_dir_logo',
                'sho_dir_banner',
                'sho_banner',
                'sho_user',
                'sho_address',
                'sho_twitter',
                'shop_type',
                'sho_youtube',
                'sho_google_plus',
                'sho_vimeo',
                'sho_website',
                'sho_style',
                'domain',
                'sho_phone',
                'sho_mobile',
                'sho_category']);
    }

    public static function suggest($user = null, $type) {
        $position = self::getPositionQuery($user);
        $sql = "SELECT
                  pro_user,
                  pro_id,
                  pro_name,
                  pro_cost,
                  pro_image,
                  pro_dir,
                  pro_category " . Commons::getDiscountQuery() . "
                FROM
                  tbtt_package_daily_content
                  LEFT JOIN tbtt_product
                    ON tbtt_product.pro_id = tbtt_package_daily_content.content_id
                                  LEFT JOIN tbtt_package_daily_user
                    ON tbtt_package_daily_user.id = tbtt_package_daily_content.order_id
                WHERE tbtt_package_daily_content.p_type = ". $type ."
                  AND tbtt_package_daily_user.content_type = 'product'
                  AND tbtt_product.pro_id IS NOT NULL " . $position . "
                  ORDER BY RAND() LIMIT 0, 10";
        return DB::select(DB::raw($sql));
    }

    public static function news() {
        $sql = "SELECT
                  not_id,
                  not_title,
                  not_image,
                  not_dir_image,
                  not_begindate
                FROM
                  tbtt_package_daily_content
                  LEFT JOIN tbtt_content
                    ON tbtt_content.not_id = tbtt_package_daily_content.content_id
                WHERE tbtt_package_daily_content.begin_date = CURDATE()
                  AND tbtt_package_daily_content.p_type = ". self::P_TYPE_NEWS ."
                  AND content_type = 'news'
                  AND tbtt_content.not_id IS NOT NULL
                  ORDER BY RAND() LIMIT 0, 10";
        return DB::select(DB::raw($sql));
    }


    public static function getPositionQuery($user = null) {
        $position = "";
        $use_province = (int) $user ? $user->use_province : 0;
        if($use_province > 0){
            if(in_array($use_province, array(4,8,58,62,63,77,33))){
                $position   = "AND tbtt_package_daily_user.position IN (001,000)";//khu vực 1
            } else {
                $position   = "AND tbtt_package_daily_user.position IN (999,000)";//khu vực 2
            }
        } else {
            $position   = "AND tbtt_package_daily_user.position IN (000)";//toan quoc
        }
    }
    public function generateLinks($shop = null, $user = null) {
        $af_id = '';
        if (!empty($user)) {
            if (in_array($user->use_group,[User::TYPE_AffiliateStoreUser,User::TYPE_AffiliateUser])) {
             if(!empty($user->af_key)){
                $af_id = '?af_id='.$user->af_key;
             }
            }
        }
        if (!empty($shop)) {
            $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
            if (!empty($shop->domain)) {
                $this->link = 'http://' . $shop->domain.$af_id;
            } else {
                $this->link = $protocol . $shop->sho_link . '.' . env('APP_DOMAIN') . '/shop/product/detail/' . $this->pro_id . '/' . str_slug($this->pro_name).$af_id;
            }
        } else {
            $this->link = env('APP_FONTEND_URL', 'http://') . '/' . $this->pro_category . '/' . $this->pro_id . '/' . str_slug($this->pro_name).$af_id;
        }

        
        return;
    }

    public function isSelected($user) {
        if (!empty($user)) {
            $this->pro_is_affiliated = ProductAffiiate::where(['use_id' => $user->use_id, 'pro_id' => $this->pro_id])->count();
        } else {
            $this->pro_is_affiliated = 0;
        }
    }
    
    public function isBracndSelected($user){
        if (!empty($user) && $user->use_group == User::TYPE_BranchUser) {
            $this->pro_is_branch_selected = Product::where(['pro_user' => $user->use_id, 'pro_of_shop' => $this->pro_id])->count();
        } else {
            $this->pro_is_branch_selected = 0;
        }
    }
    public function additionFiled() {
        if ($this->is_product_affiliate == Product::IS_AFF_PRODUCT) {
            if ($this->af_amt > 0) {
                $seller_affiliate_value = $this->af_amt;
                $pro_type_affiliate = Product::TYPE_AFFILIATE_CURRENCY;
            } else {
                $seller_affiliate_value = $this->aff_rate ? $this->aff_rate : $this->af_rate;
                $pro_type_affiliate = Product::TYPE_AFFILIATE_PERCENT;
            }

            if ($this->af_dc_amt > 0) {
                $pro_type_dc_affiliate = Product::TYPE_AFFILIATE_CURRENCY;
                $buyer_affiliate_value = $this->af_dc_amt;
            } else {
                $pro_type_dc_affiliate = Product::TYPE_AFFILIATE_PERCENT;
                $buyer_affiliate_value = $this->af_dc_rate;
            }
        } else {
            $pro_type_dc_affiliate = 0;
            $buyer_affiliate_value = 0;
            $seller_affiliate_value = 0;
            $pro_type_affiliate = 0;
        }
        $this->pro_type_dc_affiliate = $pro_type_dc_affiliate;
        $this->buyer_affiliate_value = $buyer_affiliate_value;
        $this->seller_affiliate_value = $seller_affiliate_value;
        $this->pro_type_affiliate = $pro_type_affiliate;
    }

    public function publicInfo($user = null,$createLink = true){
        if ($createLink) {
            $this->generateLinks(null,$user);
        }
        if(!empty($this->shop)){
            $this->shop->publicInfo();
        }
        
        $this->manufacturer;
        $this->isSelected($user);
        $this->productParent($user);
        $this->isBracndSelected($user);
        $this->additionFiled();
       
    }
    
    public function productParent($user) {
        $id_my_parent = 0;
        
        $this->isParentsProduct = false;
        if ($user && $this->is_product_affiliate == 1) {
            $parent = $user->parentActiveInfo;
           
            #Get my parent
            if ($parent && ($parent->use_group == User::TYPE_AffiliateStoreUser || $parent->use_group == User::TYPE_BranchUser)) {
                $id_my_parent = $parent->use_id;
            } elseif ($parent && ($parent->use_group == User::TYPE_StaffUser || $parent->use_group == User::TYPE_StaffStoreUser)) {
                #Get parent of parent
                $paren_of_parent = $parent->parentActiveInfo;

                if ($paren_of_parent && ($paren_of_parent->use_group == User::TYPE_AffiliateStoreUser || $paren_of_parent->use_group == User::TYPE_AffiliateUser)) {
                    $id_my_parent = $paren_of_parent->use_id;
                }
            } else {
                $id_my_parent = $user->parent_shop;
            }
            
            if ($id_my_parent > 0) {

                $this->isParentsProduct = $this->pro_user == $id_my_parent ;
            }
        }
    }

    public function buildPrice($user = null, $af_id = null) {
        $afSelect = false;
        if ($af_id && $this->is_product_affiliate == 1) {
            $userObject = User::where(['af_key', $af_id])->first();
            if ($userObject->use_id > 0) {
                $afSelect = true;
            }
        }
        $price = Commons::buildPrice($this, $user ? $user->use_group : null, $afSelect);
        $this->salePrice = isset($price['salePrice']) ? $price['salePrice'] : 0;
        $this->saleInfo = $price;
    }

    public function manufacturer(){
        return $this->hasOne('App\Models\Manufacturer','man_id','pro_manufacturer_id');
    }
    public static function queryDiscountProductDp() {
        $curTime = time();
        return 'IF(
                tbtt_product.pro_saleoff = 1 AND ((' . $curTime . ' >= tbtt_product.begin_date_sale AND ' . $curTime . ' <= tbtt_product.end_date_sale) OR (tbtt_product.begin_date_sale = 0 AND tbtt_product.end_date_sale = 0 )),
                CASE
                  WHEN tbtt_product.pro_type_saleoff = 2
                  THEN tbtt_product.pro_saleoff_value
                  WHEN tbtt_product.pro_type_saleoff = 1
                  THEN CAST(
                    tbtt_product.pro_saleoff_value AS DECIMAL (15, 5)
                  ) * T2.dp_cost / 100
                END,
                0
              ) AS off_amount
              , IF(
                tbtt_product.pro_saleoff = 1 AND ((' . $curTime . ' >= tbtt_product.begin_date_sale AND ' . $curTime . ' <= tbtt_product.end_date_sale) OR (tbtt_product.begin_date_sale = 0 AND tbtt_product.end_date_sale = 0 )),
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
                  tbtt_product.dc_amt AS DECIMAL (15, 5)
                ),
                IF(
                  tbtt_product.dc_rate > 0,
                  CAST(
                    tbtt_product.dc_rate AS DECIMAL (15, 5)
                  ) * T2.dp_cost / 100,
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
                  tbtt_product.af_dc_amt AS DECIMAL (15, 5)
                ),
                IF(
                  tbtt_product.af_dc_rate > 0,
                  CAST(
                    tbtt_product.af_dc_rate AS DECIMAL (15, 5)
                  ) * T2.dp_cost / 100,
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
        define('DISCOUNT_DP_QUERY', $discount_dp);
    }
    
    public static function selelectSafePrice() {
        $curTime = time();
        return 'IF(
                tbtt_product.pro_saleoff = 1 AND ((' . $curTime . ' >= tbtt_product.begin_date_sale AND ' . $curTime . ' <= tbtt_product.end_date_sale) OR (tbtt_product.begin_date_sale = 0 AND tbtt_product.end_date_sale = 0 )),
                CASE
                  WHEN tbtt_product.pro_type_saleoff = 2
                  THEN tbtt_product.pro_cost - tbtt_product.pro_saleoff_value
                  WHEN tbtt_product.pro_type_saleoff = 1
                  THEN tbtt_product.pro_cost - CAST(
                    tbtt_product.pro_saleoff_value AS DECIMAL (15, 5)
                  ) * tbtt_product.pro_cost / 100
                END,
                tbtt_product.pro_cost
              )';
    }

    public static function queryDiscountProduct() {
        $curTime = time();
        return ' IF(
                tbtt_product.pro_saleoff = 1 AND (('.$curTime.' >= tbtt_product.begin_date_sale AND '.$curTime.' <= tbtt_product.end_date_sale) OR (tbtt_product.begin_date_sale = 0 AND tbtt_product.end_date_sale = 0 )),
                CASE
                  WHEN tbtt_product.pro_type_saleoff = 2
                  THEN tbtt_product.pro_saleoff_value
                  WHEN tbtt_product.pro_type_saleoff = 1
                  THEN CAST(
                    tbtt_product.pro_saleoff_value AS DECIMAL (15, 5)
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
                  tbtt_product.dc_amt AS DECIMAL (15, 5)
                ),
                IF(
                  tbtt_product.dc_rate > 0,
                  CAST(
                    tbtt_product.dc_rate AS DECIMAL (15, 5)
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
                  tbtt_product.af_dc_amt AS DECIMAL (15, 5)
                ),
                IF(
                  tbtt_product.af_dc_rate > 0,
                  CAST(
                    tbtt_product.af_dc_rate AS DECIMAL (15, 5)
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
              ) AS af_rate' ;
    }
    
    public function detailProducts() {

        return $this->hasMany('App\Models\DetailProduct', 'dp_pro_id', 'pro_id');
    }

    public function promotionsProduct() {
        return $this->hasMany('App\Models\ProductPromotion', 'pro_id', 'pro_id');
    }
    public function promotions(){
        return $this->hasMany('App\Models\ProductPromotion', 'pro_id', 'pro_id')
            ->select(DB::raw('*, IF(dc_rate > 0, dc_rate, dc_amt) AS dc_amount, IF(dc_rate > 0, \'%\', \'Số tiền\') AS dc_type'))
            ->orderBy('limit_from','asc');
    }
    
    public static function boot() {
        parent::boot();

        static::observe(new ProductObserver());
    }


}
