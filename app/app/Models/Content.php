<?php

namespace App\Models;

use App\BaseModel;
use App\Helpers\Commons;
use App\Models\ContentComment;
use App\Models\SelectNews;
use App\Models\User;
use App\Observers\NewsObserver;

/**
 * Content model
 *
 * @property integer $serviceId Relation of service
 */
class Content extends BaseModel {
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    const FILTER_PROMOTION = 'promotion';
    const FILTER_HOT = 'hot';
    const FILTER_CATEGORY = 'category';
    const FILTER_FOLLOW = 'follow';
    const FILTER_MESELECT = 'meselect';
    const FILTER_SELECTME = 'selectme';

    const PERRMISSION_ALL = 1;
    const PERRMISSION_TV = 2;
    const PERRMISSION_TV_CTV = 3;
    const PERRMISSION_CTV = 4;
    const PERRMISSION_LOCAL = 5;
    const PERRMISSION_ONLYME = 6;

    protected $table = 'tbtt_content';

    protected $primaryKey = 'not_id';
    
    public $timestamps = false;
     public function __construct(array $attributes = array()) {
        $this->setRawAttributes($this->defaults, true);
        parent::__construct($attributes);
    }

    // protected $fillable = [
    //     'description',
    //     'administrativeAreaLevel1',
    //     'administrativeAreaLevel1Hash',
    //     'centerLat',
    //     'centerLng',
    //     'createdBy',
    //     'updatedBy'
    // ];

    public static function tableName() {
        return 'tbtt_content';
    }

    protected $defaults = array(
        'not_view' => 0,
        'group_docs' => 0,
        'not_image7' => '',
        'not_image8' => '',
        'not_ghim' => 0,
        'imglink1' => '#',
        'imglink2' => '#',
        'imglink3' => '#',
        'imglink4' => '#',
        'imglink5' => '#',
        'imglink6' => '#',
        'imglink7' => '#',
        'imglink8' => '#',
        'linkdetail1' => '#',
        'linkdetail2' => '#',
        'linkdetail3' => '#',
        'linkdetail4' => '#',
        'linkdetail5' => '#',
        'linkdetail6' => '#',
        'linkdetail7' => '#',
        'linkdetail8' => '#',
        'imgcaption1' => '',
        'imgcaption2' => '',
        'imgcaption3' => '',
        'imgcaption4' => '',
        'imgcaption5' => '',
        'imgcaption6' => '',
        'imgcaption7' => '',
        'imgcaption8' => '',
        'not_slideshow'=>0
    );
    protected $fillable = [
        'not_title',
        'not_description',
        'group_docs',
        'not_keywords',
        'not_view',
        'not_group',
        'not_user',
        'not_view',
        'id_category',
        'not_degree',
        'not_detail',
        'not_begindate',
        'not_enddate',
        'cat_type',
        'not_image',
        'not_image1',
        'not_image2',
        'not_image3',
        'not_image4',
        'not_image5',
        'not_image6',
        'not_image7',
        'not_image8',
        'imglink1',
        'imglink2',
        'imglink3',
        'imglink4',
        'imglink5',
        'imglink6',
        'imglink7',
        'imglink8',
        'linkdetail1',
        'linkdetail2',
        'linkdetail3',
        'linkdetail4',
        'linkdetail5',
        'linkdetail6',
        'linkdetail7',
        'linkdetail8',
        'not_dir_image',
        'not_video_url',
        'not_video_url1',
        'not_status',
        'not_pro_cat_id',
        'not_news_hot',
        'not_news_sale',
        'imgcaption1',
        'imgcaption2',
        'imgcaption3',
        'imgcaption4',
        'imgcaption5',
        'imgcaption6',
        'imgcaption7',
        'imgcaption8'
    ];
    

    /**
     * Comments relationship
     * @return App\Models\ContentComment
     */
    public function comments() {
        return $this->hasMany('App\Models\ContentComment', 'noc_content', 'not_id');
    }
    
    public function selecter(){
        return $this->hasMany('App\Models\SelectNews','not_id','not_id');
    }

    /**
     * User relationship
     * @return App\Models\User
     */
    public function user() {
        return $this->hasOne('App\Models\User', 'use_id', 'not_user');
    }

    public function populateSlug() {
        $this->slug = Commons::toSlug($this->not_title);
    }

    public function populateCountComments() {
        $this->not_comment = ContentComment::where('noc_content', $this->not_id)->count();
    }
    
     public function populateContChooseNews() {
        $this->not_selected = SelectNews::where('not_id', $this->not_id)->count();
    }
    public function isSelected($user){  
        if (!empty($user)) {
            $this->not_is_selected = SelectNews::where(['not_id'=> $this->not_id, 'sho_user'=> $user->use_id])->count();
        }else{
            $this->not_is_selected = 0;
        }
    }

    public function checkOwner($userId) {
        return $userId === $this->not_user;
    }
    protected function getProduct($product,$linkdetail,$user = null,$shop = null){
        $item = [];
        $item['detail'] = $this->{$linkdetail};
        if (empty($this->{$product})) {
            unset($this->{$product});
            return $item;
        }
        //;
        $this->{$product}->generateLinks($shop);
        $this->{$product}->publicInfo($user);
        $item = $this->{$product};
       // $item->link = $this->{$linkdetail};
        $item->detail = $this->{$linkdetail};
        $this->{$product}->category;

        unset($this->{$product});
        return $item;
    }

    public function lisProduct($user = null, $shop = null) {
        $listProducts = [];
        for ($i = 1; $i < 9; $i++) {
            $filed = 'not_image' . $i;
            // $item['thumnailNews'] ='';
            if ($this->{$filed}) {
                $item = $this->getProduct('product' . $i, 'linkdetail' . $i, $user, $shop);
                $item['thumbnailNews'] = \App\Helpers\Utils::showThumbnail($this->not_dir_image, $this->{$filed}, 3, 'tintuc');
              //  $item['detail'] = $this->{'linkdetail' . $i};
                if (!empty($item)) {

                    $listProducts[] = $item;
                }
            }
        }
        $this->products = $listProducts;
    }

    public function domainLink($domain,$shopLink) {
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $slug =  str_slug($this->not_title);
        if (!empty($domain)) {
            if($shopLink){
                $this->domainLink = $protocol . $domain . '/news/detail/' . $this->not_id;
            }else{
                $this->domainLink = $protocol . $domain . '/tintuc/detail/' . $this->not_id;
            }
            
            if(!empty($slug)){
                $this->domainLink = $this->domainLink.'/'.$slug;
            }
        } else {
            $this->domainLink = '';
        }
    }

    public function populate($user = null,$shop = null) {
        $this->populateSlug();
        $this->populateCountComments();
        $this->populateContChooseNews();
        $this->lisProduct($user,$shop);
        $this->isSelected($user);
        $this->thumbnail();
        $this->hasPermission($user);
        //$this->selectUsers;
    }
    public function lisSelecter(){
        $this->selecter;
        if(!empty($this->selecter)){
   
        }
    }
    public function selectUsers() {
        return $this->belongsToMany('App\Models\User', (new \App\Models\SelectNews)->getTable(), 'not_id', 'sho_user')->select(['use_id', 'use_username', 'avatar', 'use_fullname', 'use_phone']);
    }

    public function product1() {
        return $this->hasOne('App\Models\Product', 'pro_id', 'imglink1');
    }

    public function product2() {
        return $this->hasOne('App\Models\Product', 'pro_id', 'imglink2');
    }

    public function product3() {
        return $this->hasOne('App\Models\Product', 'pro_id', 'imglink3');
    }

    public function product4() {
        return $this->hasOne('App\Models\Product', 'pro_id', 'imglink4');
    }
     public function product5() {
        return $this->hasOne('App\Models\Product', 'pro_id', 'imglink5');
    }

    public function product6() {
        return $this->hasOne('App\Models\Product', 'pro_id', 'imglink6');
    }
     public function product7() {
        return $this->hasOne('App\Models\Product', 'pro_id', 'imglink7');
    }
     public function product8() {
        return $this->hasOne('App\Models\Product', 'pro_id', 'imglink8');
    }
    public function thumbnail() {

        $this->thumbnail = \App\Helpers\Utils::showThumbnail($this->not_dir_image, $this->not_image, 3, 'tintuc');
    }


    public function hasPermission($user = null, $save = false){
        if ($save) {
            return $user && $this->not_user == $user->use_id;   
        }
        return $this->hasPermission = $user && $this->not_user == $user->use_id;
    }

    public static function filter($query, $user = null) {
        $tableName = Content::tableName();
        if (!$user) {
            return $query->whereIn($tableName.'.not_permission', [self::PERRMISSION_ALL]);
        }
        // if user login
        $shopID = $user->getShopInTree();
        $shopID = $shopID != 0 ? $shopID : $user->use_id;
        $shopNear = $user->getShopNearest();


        if ($user->use_group === User::TYPE_AffiliateUser) {
            $query->where(function ($q) use($tableName,$shopID,$shopNear) {
                $q->orWhereIn($tableName . '.not_permission', [Content::PERRMISSION_ALL, Content::PERRMISSION_TV, Content::PERRMISSION_CTV]);
                $q->orWhere(function($q) use($shopID, $shopNear) {
                    $q->where('not_permission', Content::PERRMISSION_LOCAL);
                    $q->whereIn('not_user', [$shopID,$shopNear]);
                });
            });
        } else {
            $query->where(function ($q) use($tableName, $shopID, $shopNear,$user) {

                $q->orWhereIn($tableName . '.not_permission', [Content::PERRMISSION_ALL, Content::PERRMISSION_TV, Content::PERRMISSION_TV_CTV]);
                $q->orWhere(function($q) use($shopID, $shopNear) {
                    $q->where('not_permission', Content::PERRMISSION_LOCAL);
                    $q->whereIn('not_user', [$shopID, $shopNear]);
                });
                $q->orWhere(function($q) use($user) {
                    $q->where('not_permission', Content::PERRMISSION_ONLYME);
                    $q->where('not_user', $user->use_id);
                });
                $q->orWhere(function($q) use($shopID, $user) {
                    $q->where('not_permission', Content::PERRMISSION_CTV);
                    $q->whereIn('not_user', [$shopID, $user->use_id]);
                });
            });
        }
    }
      public static function boot() {
        parent::boot();

        static::observe(new NewsObserver());
    }

}
