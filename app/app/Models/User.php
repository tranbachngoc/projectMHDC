<?php

namespace App\Models;

use Illuminate\Support\Facades\Log;
use Uuid;
use JWTAuth;
use JWTFactory;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Helpers\Hash;
use App\Helpers\Commons;
use App\Models\Notification;
use App\Models\CommissionType;
use App\Models\PackageUser;
use App\Models\UserFollow;
use App\Observers\UserObserver;
use Carbon\Carbon;
use DB;

/**
 * Admin user model
 *
 * @property String $email
 * @property String $name
 * @property String $password
 * @property String $createdAt
 * @property String $updatedAt
 * @property String $role
 * @property Boolean $active
 */
class User extends Authenticatable {

    use Notifiable;

    /**
     * define('NormalUser',1);
        define('AffiliateUser',2);
        define('AffiliateStoreUser',3);
        define('Developer2User',6);
        define('Developer1User',7);
        define('Partner2User',8);
        define('Partner1User',9);
        define('CoreMemberUser',10);
        define('CoreAdminUser',12);
        define('StaffUser',11);
        define('BranchUser',14);
     */
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    const TYPE_NormalUser = 1;
    const TYPE_AffiliateUser = 2;
    const TYPE_AffiliateStoreUser = 3;
    const TYPE_Developer2User = 6;
    const TYPE_Developer1User = 7;
    const TYPE_Partner2User = 8;
    const TYPE_Partner1User = 9;
    const TYPE_CoreMemberUser = 10;
    const TYPE_CoreAdminUser = 12;
    const TYPE_StaffUser = 11;
    const TYPE_BranchUser = 14;
    const TYPE_StaffStoreUser = 15;
    const ID_GROUPADMIN = [4,12,100];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tbtt_user';

    protected $primaryKey = 'use_id';

    public $wasNew = false;

    public $timestamps = false;

    protected $defaults = array(
        'use_fullname' => '',
        'use_address' => '',
        'active_code' => '',
        'avatar' => '',
        'use_birthday' => 0,
        'use_sex' => 0,
        'id_card' => '',
        'tax_code' => '',
        'tax_type' => 0,
        'bank_name' => '',
        'bank_add' => '',
        'account_name' => '',
        'num_account' => '',
        'style_id' => '',
        'use_yahoo' => '',
        'use_skype' => '',
        'company_name' => '',
        'company_position' => '',
        'company_address' => '',
        'use_message'=>'',
        'website' => '',
        'business_field' => '',
        'fax' => '',
        'use_enddate' => 0,
        'member_type' => 0,
        'use_invite'=>0,

    );

    public function __construct(array $attributes = array())
    {
        $this->setRawAttributes($this->defaults, true);
        parent::__construct($attributes);
    }

    protected $fillable = [
        'use_username',
        'use_password',
        'use_salt',
        'use_email',
        'use_fullname',
        'use_birthday',
        'use_sex',
        'use_address',
        'use_province',
        'user_district',
        'use_phone',
        'use_mobile',
        'id_card',
        'tax_code',
        'tax_type',
        'bank_name',
        'bank_add',
        'account_name',
        'num_account',
        'style_id',
        'use_yahoo',
        'use_skype',
        'use_group',
        'use_status',
        'use_regisdate',
        'use_bandate',
        'use_enddate',
        'use_end_bandate',
        'use_key',
        'use_lastest_login',
        'member_type',
        'active_code',
        'company_name',
        'company_position',
        'company_address',
        'company_agent',
        'website',
        'business_field',
        'fax',
        'avatar',
        'use_permision',
        'request_shop',
        'af_key',
        'parent_id',
        'parent_shop',
        'pw_emailmarketting',
        'active_date',
        'use_auth_token',
        'use_message',

        /*'use_career1',
        'use_career2',
        'use_department',
        'use_mobile',
        'use_email',
        'use_religion',
        'use_marriage',
        'use_favorites',
        'use_education',
        'use_accommodation',
        'use_talk',
        'use_logo',
        'use_banner',
        'use_introtext',
        'use_introimage',

        'use_slogan',
        'use_slogan_by',
        'use_slogan_bg',

        'use_service_desc',
        'use_service_1',
        'use_service_2',
        'use_service_3',
        'use_service_4',
        'use_service_5',
        'use_service_6',

        'use_statistic_text_1' ,
        'use_statistic_num_1' ,
        'use_statistic_text_2',
        'use_statistic_num_2',
        'use_statistic_text_3',
        'use_statistic_num_3' ,
        'use_statistic_text_4' ,
        'use_statistic_num_4',
        'use_statistic_bg',
        'use_facebook',
        'use_twitter',
        'use_google',
        'use_certification',

        'use_portfolio_desc',
        'use_portfolio_1',
        'use_portfolio_2',
        'use_portfolio_3',
        'use_portfolio_4',
        'use_portfolio_5',
        'use_portfolio_6',
        'use_portfolio_7',
        'use_portfolio_8',
        'use_portfolio_9',
        'use_portfolio_10',
        'use_portfolio_11',
        'use_portfolio_12',

        'use_customers_bg',
        'use_custommer_1_say',
        'use_custommer_2_say',
        'use_custommer_3_say',
        'use_custommer_4_say',

        'use_history_1',
        'use_history_2',
        'use_history_3',
        'use_history_4',
        'use_history_5',
        'use_history_6',
        'use_history_7',
        'use_history_8',
        'use_history_9',
        'use_history_10',*/




    ];

    /**
     * generate json web token for current user
     * The token is generated by
     * [
     *   'type' => 'userType',
     *   'authToken' => 'user-token'
     * ]
     * @return boolean
     */
    public function generateJwt() {
        try {
            $payload = JWTFactory::make([
                'token' => $this->use_auth_token,
                'userId' => (int)$this->use_id,
                'group' => (int)$this->use_group,
                'username' => $this->use_username,
                'name' => $this->use_fullname
            ]);
            // attempt to verify the credentials and create a token for the user
            $token = JWTAuth::encode($payload);
        } catch (JWTException $e) {
            return false;
        }

        return $token->get();
    }

    public static function tableName() {
        return 'tbtt_user';
    }

    public function save(array $options = array()) {
        //default tag is personal
        if (!$this->parent_id) {
            $this->parent_id = $this->randomParent();
        }

        if (!$this->exists) {
            $this->wasNew = true;
        }
        if(!$this->af_key){
            $this->af_key = md5($this->use_username.time());
        }

        Log::info($this);

        parent::save($options);
    }

    public static function boot() {
        parent::boot();

        static::observe(new UserObserver());
    }

    public function randomParent() {
        $user = User::where('use_status', 1)
        ->whereIn('use_group', [6,7,8,9,10])
        ->orderBy('use_group', Commons::randomOrderBy())
        ->orderBy('use_id', Commons::randomOrderBy())
        ->where(function($q) {
            $q->orWhere('user_district', $this->user_district);
            $q->orWhere('use_province', $this->use_province);
         })
        ->select('use_id')
        ->first();

        if ($user) {
            return $user->use_id;
        }
        $user = User::where('use_status', 1)
        ->whereIn('use_group', [6,7,8,9,10])
        ->orderBy('use_group', Commons::randomOrderBy())
        ->orderBy('use_id', Commons::randomOrderBy())
        ->select('use_id')
        ->first();

        return $user->use_id;
    }

    public static function randomSalt() {
        return Hash::key(8);
    }

    public function initAuthToken() {
        if (!$this->use_auth_token) {
            $this->use_auth_token = Uuid::generate()->string;
        }
    }

    public function getType() {
        return (int) $this->use_group;
    }

    public function hasFollow($use_id) {
        return UserFollow::where([
            'user_id' => $this->use_id,
            'follower' => $use_id,
            'hasFollow' => true
        ])->count() > 0;
    }

    /**
     * find user and return user instance
     *
     * @param String $token
     * @param BaseUser $type
     */
    public static function findByToken($token) {
        $user = User::where('use_auth_token', $token)->first();
        unset($user->use_password);
        unset($user->use_salt);
        unset($user->use_auth_token);
        return $user;
    }

    public function getRememberToken() {
        return $this->rememberToken;
    }

    public function setRememberToken($value) {
        $this->rememberToken = $value;
    }

    public function getRememberTokenName() {
        return 'rememberToken';
    }

    public static function hashPassword($password, $salt) {
        return Hash::create($password, $salt, 'md5sha512');
    }

    /**
     * add new password hash
     *
     * @param String $password
     */
    public function setPassword($password) {
        $this->use_password = Hash::create($password, $this->use_salt, 'md5sha512');
    }

    /**
     * check password hash
     *
     * @param string $password
     */
    public function checkPassword($password) {
        return Hash::create($password, $this->use_salt, 'md5sha512') === $this->use_password;
    }

    public function getAvatarUrl() {
        $avatar = 'images/default-avatar.jpg';
        return env("APP_URL_IMAGE") . DIRECTORY_SEPARATOR . $avatar;
    }

    public function myPublicProfile() {
        $data = $this->publicProfile();
        $data['bank_name'] = $this->bank_name;
        $data['bank_add'] = $this->bank_add;
        $data['account_name'] = $this->account_name;
        $data['num_account'] = $this->num_account;
        $data['province'] = $this->province;
        $data['district'] = $this->district;
        if (!empty($this->district)) {
            $data['district_code'] = $data['district']['DistrictCode'];
        } else {
            $data['district_code'] = '';
        }


        return $data;
    }

    public function province() {
        return $this->hasOne('App\Models\Province','pre_id','use_province')->select('pre_name','pre_id');
    }

    public function district() {
        return $this->hasOne('App\Models\District','DistrictCode','user_district')->select('DistrictName', 'ProvinceName', 'DistrictCode');
    }
    /**
     * return customer public profile
     */
    public function publicProfile() {
        $data =  [
            'use_id' => $this->use_id,
            'use_username' => $this->use_username,
            'use_email' => $this->use_email,
            'use_fullname' => $this->use_fullname,
            'use_birthday' => $this->use_birthday,
            'use_sex' => $this->use_sex,
            'use_address' => $this->use_address,
            'use_province' => $this->use_province,
            'use_district' => $this->user_district,
            'user_district'=>$this->user_district,
            'use_phone'=>$this->use_phone,
            'use_mobile'=>$this->use_mobile,
            'tax_code'=>$this->tax_code,
            'tax_type'=>$this->tax_type,
            'website'=>$this->website,
            'company_name'=>$this->company_name,
            'company_position'=>$this->company_position,
            'company_address'=>$this->company_address,
            'company_agent'=>$this->company_agent,
            'business_field'=>$this->business_field,
            'avatar'=>$this->getAvatar(),
            'use_yahoo'=>$this->use_yahoo,
            'use_skype'=>$this->use_skype,
            'use_group'=>$this->use_group,
            'use_status'=>$this->use_status,
            'use_regisdate'=>$this->use_regisdate,
            'use_message'=>$this->use_message,
            'parent_id'=>$this->parent_id,
            'not_totalNotRead'=> $this->countTotalNotRead(),
            'id_card'=>$this->id_card,
            'af_key'=>$this->af_key,

            /*'use_fullname' => $this->use_fullname,
            'use_career1' => $this->use_career1,
            'use_career2' => $this->use_career2,
            'use_department' => $this->use_department,
            'use_mobile' => $this->use_mobile,
            'use_email' => $this->use_email,
            'use_religion' => $this->use_religion,
            'use_marriage' => $this->use_marriage,
            'use_favorites' =>$this->use_favorites,
            'use_education' => $this->use_education,
            'use_accommodation' => $this->use_accommodation,
            'use_talk' => $this->use_talk,
            'use_logo' => $this->use_logo,
            'use_banner' => $this->use_banner,
            'use_introtext' => $this->use_introtext,
            'use_introimage' => $this->use_introimage,
            'use_slogan' => $this->use_slogan,
            'use_slogan_by' => $this->use_slogan_by,
            'use_slogan_bg' => $this->use_slogan_bg,

            'use_service_desc' => $this->use_service_desc,
            'use_service_1' => $this->use_service_1 == null? null: json_decode($this->use_service_1, true) ,
            'use_service_2' => $this->use_service_2 == null? null: json_decode($this->use_service_2, true) ,
            'use_service_3' => $this->use_service_3 == null? null: json_decode($this->use_service_3, true) ,
            'use_service_4' => $this->use_service_4 == null? null: json_decode($this->use_service_4, true) ,
            'use_service_5' => $this->use_service_5 == null? null: json_decode($this->use_service_5, true) ,
            'use_service_6' => $this->use_service_6 == null? null: json_decode($this->use_service_6, true) ,

            'use_statistic_text_1' => $this->use_statistic_text_1,
            'use_statistic_num_1' => $this->use_statistic_num_1,
            'use_statistic_text_2' => $this->use_statistic_text_2,
            'use_statistic_num_2' => $this->use_statistic_num_2,
            'use_statistic_text_3' => $this->use_statistic_text_3,
            'use_statistic_num_3' => $this->use_statistic_num_3,
            'use_statistic_text_4' => $this->use_statistic_text_4,
            'use_statistic_num_4' => $this->use_statistic_num_4,
            'use_statistic_bg' => $this->use_statistic_bg,
            'use_facebook' => $this->use_facebook,
            'use_twitter' => $this->use_twitter,
            'use_google' => $this->use_google,
            'use_certification' => $this->use_certification == null? null: json_decode($this->use_certification, true),

            'use_portfolio_desc' => $this->use_portfolio_desc ,
            'use_portfolio_1' => $this->use_portfolio_1 == null? null: json_decode($this->use_portfolio_1, true),
            'use_portfolio_2'=> $this->use_portfolio_2 == null? null: json_decode($this->use_portfolio_2, true),
            'use_portfolio_3'=> $this->use_portfolio_3 == null? null: json_decode($this->use_portfolio_3, true),
            'use_portfolio_4'=> $this->use_portfolio_4 == null? null: json_decode($this->use_portfolio_4, true),
            'use_portfolio_5'=> $this->use_portfolio_5 == null? null: json_decode($this->use_portfolio_5, true),
            'use_portfolio_6'=> $this->use_portfolio_6 == null? null: json_decode($this->use_portfolio_6, true),
            'use_portfolio_7'=> $this->use_portfolio_7 == null? null: json_decode($this->use_portfolio_7, true),
            'use_portfolio_8'=> $this->use_portfolio_8 == null? null: json_decode($this->use_portfolio_8, true),
            'use_portfolio_9'=> $this->use_portfolio_9 == null? null: json_decode($this->use_portfolio_9, true),
            'use_portfolio_10'=> $this->use_portfolio_10 == null? null: json_decode($this->use_portfolio_10, true),
            'use_portfolio_11'=> $this->use_portfolio_11 == null? null: json_decode($this->use_portfolio_11, true),
            'use_portfolio_12'=> $this->use_portfolio_12 == null? null: json_decode($this->use_portfolio_12, true),
            'use_customers_bg' => $this->use_customers_bg,
            'use_custommer_1_say' => $this->use_custommer_1_say == null? null: json_decode($this->use_custommer_1_say, true),
            'use_custommer_2_say' => $this->use_custommer_2_say == null? null: json_decode($this->use_custommer_2_say, true),
            'use_custommer_3_say' => $this->use_custommer_3_say == null? null: json_decode($this->use_custommer_3_say, true),
            'use_custommer_4_say' => $this->use_custommer_4_say == null? null: json_decode($this->use_custommer_4_say, true),

            'use_history_1' => $this->use_history_1 == null? null: json_decode($this->use_history_1, true),
            'use_history_2' => $this->use_history_2 == null? null: json_decode($this->use_history_2, true),
            'use_history_3' => $this->use_history_3 == null? null: json_decode($this->use_history_3, true),
            'use_history_4' => $this->use_history_4 == null? null: json_decode($this->use_history_4, true),
            'use_history_5' => $this->use_history_5 == null? null: json_decode($this->use_history_5, true),
            'use_history_6' => $this->use_history_6 == null? null: json_decode($this->use_history_6, true),
            'use_history_7' => $this->use_history_7 == null? null: json_decode($this->use_history_7, true),
            'use_history_8' => $this->use_history_8 == null? null: json_decode($this->use_history_8, true),
            'use_history_9' => $this->use_history_9 == null? null: json_decode($this->use_history_9, true),
            'use_history_10' => $this->use_history_10 == null? null: json_decode($this->use_history_10, true),*/


        ];
        $data['province'] = $this->province;
        $data['district'] = $this->district;
        // dump($this->branch_number_count);
        $data['branch_number_count'] = $this->branch_number_count ? $this->branch_number_count : 0;
        return $data;
    }

    public function countTotalNotRead() {
        return Notification::where([
                'userId' => $this->use_id,
                'read' => false
            ])->count();
    }

    public function getAvatar() {

        if (in_array($this->use_group,[self::TYPE_BranchUser,self::TYPE_AffiliateUser]) && (!$this->avatar || $this->avatar === '')) {
            $parent = self::where('use_id', $this->parent_id)->select('avatar', 'use_group', 'parent_id')->first();



            if ($this->use_group == self::TYPE_BranchUser && $parent->use_group === self::TYPE_StaffStoreUser) {

                $parent = self::where('use_id', $parent->parent_id)->select('avatar')->first();
            }else if($this->use_group == self::TYPE_AffiliateUser && (!empty($parent) && $parent->use_group == self::TYPE_BranchUser)){
                 $parent = self::where('use_id', $parent->parent_id)->select('avatar')->first();
            }





            return !empty($parent) ? $parent->avatar : $this->avatar;
        }
        return $this->avatar;
    }

    static public function allowUpdate($group) {
        $attrbuites = [
            'use_fullname',
            'use_birthday',
            'use_sex',
            'id_card',
            'use_address',
            'use_province',
            'use_district',
            'use_phone',
            'use_mobile',
            'use_skype',
            'use_yahoo',
            'fax',
            'tax_code',
            'company_name',
            'company_position',
            'company_address',
            'website',
            'business_field',
            'avatar',
            'use_message',
            'tax_type'
        ];
        if (in_array($group, [self::TYPE_StaffUser, self::TYPE_StaffStoreUser])) {
            unset($attrbuites['business_field']);
            unset($attrbuites['website']);
            unset($attrbuites['company_address']);
            unset($attrbuites['use_skype']);
            unset($attrbuites['use_email']);
            unset($attrbuites['use_mobile']);
            unset($attrbuites['use_yahoo']);
            unset($attrbuites['fax']);
            unset($attrbuites['tax_code']);
            unset($attrbuites['company_name']);
            unset($attrbuites['company_position']);
        }
        if ($group <= self::TYPE_AffiliateUser) {
            unset($attrbuites['business_field']);
            unset($attrbuites['website']);
            unset($attrbuites['company_address']);
            unset($attrbuites['use_skype']);
            unset($attrbuites['use_yahoo']);
            unset($attrbuites['fax']);
            unset($attrbuites['company_name']);
            unset($attrbuites['company_position']);
        }
        return $attrbuites;
    }

    /**
     * get Key Link
     * @param string $value [description]
     */
    public function getActivateLink() {
        $token = Hash::create(trim(strtolower($this->use_email)), $this->use_key, "sha512md5");
        return env('APP_FONTEND_URL') . '/activation/user/' . trim($this->use_username) . '/key/' . $this->use_key . '/token/' . $token;
    }
    public function shop(){
     return $this->hasOne('App\Models\Shop','sho_user','use_id')->select([
         'sho_id',
         'sho_user',
         'sho_name',
         'sho_descr',
         'sho_link',
         'sho_facebook',
         'sho_skype',
         'sho_dir_logo',
         'sho_address',
         'sho_twitter',
         'sho_youtube',
         'sho_google_plus',
         'sho_vimeo',
         'sho_website',
         'sho_style',
         'sho_category',
         'sho_banner',
         'shop_type',
         'sho_logo',
         'sho_dir_banner']);

    }
    public function staffOfUser(){
        return $this->hasOne('App\Models\User','use_id','parent_id')->select('use_username','use_group', 'parent_id', 'use_id');
    }
    public function affNumber(){
        return $this->hasMany('App\Models\User', 'parent_id', 'use_id')->where(['use_status' => self::STATUS_ACTIVE,
                'use_group' => self::TYPE_AffiliateUser]);
    }

    public function getChild(){
        return $this->hasOne('App\Models\UserTree','user_id','use_id');
    }

    public function getAllStaffOfUser(){
        $result = null;
        if (!empty($this->staffOfUser)) {
            $parentUser = $this->staffOfUser;
            $result = $parentUser->publicProfile();
            $result['shop'] = $parentUser->shop;
            $result['staff_of_user'] = null;
            if (in_array($parentUser->use_group, [User::TYPE_BranchUser, User::TYPE_StaffUser, User::TYPE_StaffStoreUser])) {

                if (!empty($parentUser->staffOfUser)) {
                    $parentRoot = $parentUser->staffOfUser;
                    $result['staff_of_user'] = $parentRoot;
                    $result['staff_of_user']['shop'] = $parentRoot->shop;
                    $result['staff_of_user']['staff_of_user'] = [];
                    if ($parentRoot->use_group == User::TYPE_BranchUser && !empty($parentRoot->staffOfUser)) {
                        $result['staff_of_user']['staff_of_user'] = $parentRoot->staffOfUser;
                    }
                }


            }
        }
        return $result;
    }

    public function parents(){
         $result = [
            'GH' => null,
            'CN' => null,
            'NVGH' => null,
            'NV' => null
        ];
        $parent = $this->staffOfUser;
        if (!empty($parent)) {
            if (in_array($parent->use_group, [User::TYPE_AffiliateStoreUser, User::TYPE_BranchUser, User::TYPE_StaffStoreUser, User::TYPE_StaffUser])) {

            }
        }
        return $result;
        $pgroup = $Str->use_group;
        if ($Str->use_group == 3) {
            $info_parent .= 'GH: ' . $Str->use_username;
            $checkDomain = $this->shop_model->get('sho_id, sho_link, domain', 'sho_user = ' . $Str->use_id);
            if ($checkDomain) {
                $haveDomain .= $checkDomain->domain;
                $pshop .= $checkDomain->sho_link;
            }
        } elseif ($Str->use_group == 14) {
            $info_parent = 'CN: ' . $Str->use_username;
            $pa_cn = $this->user_model->get('use_username, use_group, parent_id', 'use_id = ' . $Str->parent_id);
            if (!empty($pa_cn)) {
                if ($pa_cn->use_group == AffiliateStoreUser) {
                    $info_parent .= ', GH: ' . $pa_cn->use_username;
                } else {
                    if ($pa_cn->use_group == StaffStoreUser) {
                        $pa_nvgh = $this->user_model->get('use_username, use_group, parent_id', 'use_id = ' . $pa_cn->parent_id);
                        $info_parent .= ', NVGH: ' . $pa_cn->use_username . ', GH: ' . $pa_nvgh->use_username;
                    }
                }
            }
        } elseif ($Str->use_group == 15) {
            $info_parent = 'NVGH: ' . $Str->use_username;
            $pa_cn = $this->user_model->get('use_username, use_group, parent_id', 'use_id = ' . $Str->parent_id);
            $pa_nvgh = $this->user_model->get('use_username, use_group, parent_id', 'use_id = ' . $pa_cn->parent_id);
            if (!empty($pa_cn) && $pa_cn->use_group == AffiliateStoreUser) {
                $info_parent .= ', GH: ' . $pa_cn->use_username;
            }
        } elseif ($Str->use_group == 11) {
            $info_parent = 'NV: ' . $Str->use_username;
            $pa_nv = $this->user_model->get('use_username, use_group, parent_id', 'use_id = ' . $Str->parent_id);
            if (!empty($pa_nv) && $pa_nv->use_group == 14) {
                $info_parent .= ', CN: ' . $pa_nv->use_username;
                $pa_cn = $this->user_model->get('use_username, use_group, parent_id', 'use_id = ' . $pa_nv->parent_id);
                if (!empty($pa_cn) && $pa_cn->use_group == 3) {
                    $info_parent .= ', GH: ' . $pa_cn->use_username;
                }
            } elseif (!empty($pa_nv) && $pa_nv->use_group == 3) {
                $info_parent .= ', GH: ' . $pa_nv->use_username;
            }
        } else {

        }
    }

    public function branchNumber() {
        $shopdb = (new Shop)->getTable();
        return $this->hasMany('App\Models\User', 'parent_id', 'use_id')->where(['use_status' => self::STATUS_ACTIVE,
                'use_group' => self::TYPE_BranchUser])->join($shopdb, $shopdb . '.sho_user', 'use_id');
    }

    function getCommissionType(){
        $list = CommissionType::get();
        $results = [];
        foreach ($list as $key => $val) {
            if($this->use_group == self::TYPE_AffiliateStoreUser) {
                if ($val['id'] == '01') continue;
                if ($val['id'] == '02') continue;
                if ($val['id'] == '03') continue;
                if ($val['id'] == '04') continue;
                if ($val['id'] == '05') continue;
                if ($val['id'] == '06') continue;
            }elseif($this->use_group == self::TYPE_AffiliateUser){
                if ($val['id'] == '01') continue;
                if ($val['id'] == '02') continue;
                if ($val['id'] == '03') continue;
                if ($val['id'] == '04') continue;
                if ($val['id'] == '05') continue;
                if ($val['id'] == '07') continue;
                if ($val['id'] == '08') continue;
            }else{
                if ($val['id'] == '06') continue;
                if ($val['id'] == '07') continue;
                if ($val['id'] == '08') continue;
            }
            $results[] = $val;
        }

        return $results;
    }

    public static function CommissionType(){
        return [
            self::STATUS_PENDING => 'default',
            self::STATUS_CANCEL => 'danger',
            self::STATUS_ASSIGNED => 'warning',
            self::STATUS_PICKED => 'info',
            self::STATUS_DROPPED => 'success',
            self::STATUS_NO_DRIVER => 'default'
        ];
    }


    protected $casts = [
        'use_province' => 'integer',
        'use_district'=>'integer',
        'user_district'=>'integer'
    ];

    public function checkLimitService($parent) {


        $userID = $parent->use_id;

        switch ($parent->use_group) {
            case self::TYPE_StaffUser:
                //Nếu cha la nv - Lấy cha của cha
                $staffUserParent = $parent->parentActiveInfo;
                $userID = $staffUserParent->use_id;
                //Nếu cha la chi nhánh lấy thông tin cha của cha
                if (!empty($staffUserParent) && $staffUserParent->use_group == User::TYPE_BranchUser) {
                    $branchParent = $staffUserParent->parentActiveInfo;
                    if (!empty($branchParent)) {
                        $userID = $branchParent->use_id;
                        //Nếu cha này là một chủ gh lấy thông tin cha
                        if ($branchParent->use_group == User::TYPE_StaffStoreUser) {
                            $staffStoreParent = $branchParent->parentActiveInfo;
                            if (!empty($staffStoreParent)) {
                                $userID = $staffStoreParent->use_id;
                            }
                        }
                    }
                }
                break;
            case self::TYPE_BranchUser:
                $branchParent = $parent->parentActiveInfo;
                if (!empty($branchParent)) {
                    $userID = $branchParent->use_id;
                    //Nếu cha này là một chủ gh lấy thông tin cha
                    if ($branchParent->use_group == User::TYPE_StaffStoreUser) {
                        $staffStoreParent = $branchParent->parentActiveInfo;
                        if (!empty($staffStoreParent)) {
                            $userID = $staffStoreParent->use_id;
                        }
                    }
                }
                break;
            case self::TYPE_StaffStoreUser:

                $staffStoreParent = $parent->parentActiveInfo;
                if (!empty($staffStoreParent)) {
                    $userID = $staffStoreParent->use_id;
                }

                break;
        }
        $userdb = User::tableName();
        //Lấy danh sách con trực tiếp
        $query = self::where([]);
        // Lay danh sach con
       // Lấy danh sách user level 1
        $query->where(function($q) use ($userID, $userdb) {
              $q->where($userdb . '.use_status', self::STATUS_ACTIVE);
            $q->whereIn($userdb . '.use_group', [self::TYPE_BranchUser, self::TYPE_StaffUser, self::TYPE_StaffStoreUser]);
            $q->where($userdb . '.parent_id', $userID);

        });

        // Lấy danh sách user level 2
        $query->orWhere(function($q) use($userID, $userdb) {
            $q->where($userdb.'.use_status',self::STATUS_ACTIVE);
            $q->whereIn($userdb . '.use_group', [self::TYPE_BranchUser, self::TYPE_StaffUser]);
            $q->whereIn('parent_id', function($q2) use ($userID, $userdb) {
                $q2->select('use_id');
                $q2->from($userdb);
                $q2->where('parent_id', $userID);
                $q2->where($userdb.'.use_status',self::STATUS_ACTIVE);
                $q2->whereIn($userdb . '.use_group', [self::TYPE_BranchUser, self::TYPE_StaffStoreUser]);
            });
        });

        // Lấy danh sách use level 3
        $query->orWhere(function($q) use($userID, $userdb) {
            $q->where($userdb . '.use_status', self::STATUS_ACTIVE);
            $q->whereIn($userdb . '.use_group', [self::TYPE_StaffUser]);
            $q->whereIn('parent_id', function($q2) use ($userID, $userdb) {
                $q2->select('use_id');
                $q2->from($userdb);
                $q2->where($userdb . '.use_status', self::STATUS_ACTIVE);
                $q2->whereIn($userdb . '.use_group', [self::TYPE_BranchUser]);
                $q2->whereIn('parent_id', function($q3) use($userID, $userdb) {
                    $q3->select('use_id');
                    $q3->from($userdb);
                    $q3->where($userdb . '.use_status', self::STATUS_ACTIVE);
                    $q3->where('parent_id', $userID);
                    $q3->whereIn($userdb . '.use_group', [self::TYPE_BranchUser, self::TYPE_StaffStoreUser]);
                });
            });
        });
        $list = $query->get()->pluck('use_id');
        $total_aff_sub = 0;
        if (!empty($list)) {
            $subQ = User::whereIn($userdb . '.parent_id', $list);
            $subQ->where('use_group', self::TYPE_AffiliateUser);
            $subQ->where('use_status', self::STATUS_ACTIVE);
            $total_aff_sub = $subQ->count();
        }
        $total_aff_shop = self::where([
                'use_group' => self::TYPE_AffiliateUser,
                'parent_id' => $userID,
                'use_status' => self::STATUS_ACTIVE
            ])->count();


        $total_aff_shop = $total_aff_shop ? $total_aff_shop : 0;
        $total = $total_aff_shop + $total_aff_sub;


         #BEGIN:: Lấy Gói DV mà GH đang sử dụng
        $sho_package = self::GetPackageValueshop($userID);

        $shop_package_limit = $sho_package ? $sho_package->limit : 3;

          #BEGIN:: Lấy Gói DV mà GH Mua thêm mở Cộng Tác Viên Online
        $sho_pack_ctv =self::getPackageCreateCTVOnline($userID);


        $limit_pack_ctv = $sho_pack_ctv ? $sho_pack_ctv->limit : 0;

        #END:: Lấy Gói DV mà GH Mua thêm mở Cộng Tác Viên Online

        $total_limit = $shop_package_limit + $limit_pack_ctv;

        //Không giới hạn or Nếu giới hạn thì xét con cho thêm aff hay không?
        if ($shop_package_limit < 0 || $total_limit > $total) {
            return false;
        } else {
            return $shop_package_limit;
        }



    }

    public static function getPackageCreateCTVOnline($userID) {

        return PackageUser::where([
                    'tbtt_package_user.user_id' => $userID
                ])
                ->select('tbtt_package.info_id as id', 'tbtt_package.month_price', 'tbtt_package_user.limited', 'tbtt_service.name', 'tbtt_service.limit', 'tbtt_service.unit', 'tbtt_service.desc', 'tbtt_service.install', 'tbtt_service.note', 'tbtt_service.group', 'tbtt_service.published')
                ->whereDate('tbtt_package_user.begined_date', '<=', Carbon::now()->toDateTimeString())
                ->whereDate('tbtt_package_user.ended_date', '>=', Carbon::now()->toDateTimeString())
                ->join('tbtt_package', 'tbtt_package_user.package_id', 'tbtt_package.id')
                ->join('tbtt_package_service', 'tbtt_package_service.package_id', 'tbtt_package.id')
                ->join('tbtt_service', 'tbtt_package_service.service_id', 'tbtt_service.id')
                ->where('tbtt_service.group', 26)
                ->where('tbtt_service.published', 1)
                ->orderBy('tbtt_package_user.id', 'desc')
                ->first();
    }

    public static function GetPackageValueshop($userID) {
        return PackageUser::where([
                'tbtt_package_user.user_id' => $userID
            ])
        ->select('tbtt_package.info_id as id',
                  'tbtt_package.month_price',
                  'tbtt_service.name',
                  'tbtt_service.limit',
                  'tbtt_service.unit',
                  'tbtt_service.desc',
                  'tbtt_service.install',
                  'tbtt_service.note',
                  'tbtt_service.group',
                  'tbtt_service.published')
        ->whereDate('tbtt_package_user.begined_date', '<=', Carbon::now()->toDateTimeString())
        ->whereRaw('(NOW() <= tbtt_package_user.ended_date OR tbtt_package_user.ended_date IS NULL)')
        ->join('tbtt_package', 'tbtt_package_user.package_id','tbtt_package.id')
        ->join('tbtt_package_service', 'tbtt_package.info_id','tbtt_package_service.package_id')
        ->join('tbtt_service', 'tbtt_package_service.service_id','tbtt_service.id')
        ->where('tbtt_service.group', 18)
        ->orderBy('tbtt_package_user.id', 'desc')
        ->first();
    }
    public static function getPackage($userID) {
        return PackageUser::where([
                'tbtt_package_user.user_id' => $userID
            ])
        ->select('tbtt_package.info_id as id',
                  'tbtt_package.month_price',
                  'tbtt_service.name',
                  'tbtt_service.limit',
                  'tbtt_service.unit',
                  'tbtt_service.desc',
                  'tbtt_service.install',
                  'tbtt_service.note',
                  'tbtt_service.group',
                  'tbtt_service.published')
        ->whereDate('tbtt_package_user.begined_date', '<=', Carbon::now()->toDateTimeString())
        ->orWhere(function ($query) {
            $query
                ->whereDate('tbtt_package_user.ended_date', '>=', Carbon::now()->toDateTimeString())
                ->whereNull('tbtt_package_user.ended_date');
        })
        ->join('tbtt_package_service as service', 'tbtt_package_user.package_id','service.package_id')
        ->join('tbtt_service', 'service.service_id','tbtt_service.id')
        ->join('tbtt_package', 'service.package_id','tbtt_package.id')
        ->orderBy('tbtt_package_user.id', 'desc')
        ->first();
    }

    //Lấy danh sách các vị trí CN và NV của GH
    public function getListBranchAndStaffIds() {
        $userdb = self::tableName();
        $sub_tructiep = self::where([$userdb . '.use_status' => self::STATUS_ACTIVE, $userdb . '.parent_id' => $this->use_id])
        ->whereIn($userdb . '.use_group', [self::TYPE_BranchUser, self::TYPE_StaffUser, self::TYPE_StaffStoreUser])
        ->leftJoin($userdb.' as staff', function($join) use($userdb)
         {
           $join->on($userdb . '.use_group', '=', DB::raw(self::TYPE_BranchUser));
           $join->on($userdb.'.use_id', '=', 'staff.parent_id');
           $join->on('staff.use_group', '=', DB::raw(self::TYPE_StaffUser));
           $join->on('staff.use_status', '=', DB::raw(self::STATUS_ACTIVE));
         })
        ->leftJoin($userdb.' as staff2', function($join) use($userdb)
         {
           $join->on($userdb . '.use_group', '=', DB::raw(self::TYPE_StaffStoreUser));
           $join->on('staff.use_status', '=', DB::raw(self::STATUS_ACTIVE));
           $join->on($userdb.'.use_id', '=', 'staff.parent_id')
           ->whereIn('staff.use_group', [self::TYPE_StaffUser, self::TYPE_BranchUser]);
         })
        ->select('staff.use_id as staff_id', 'staff2.use_id as staff2_id', $userdb.'.use_id')
        ->get();

        $tree = [];
        foreach ($sub_tructiep as $value) {
            if ($value->staff_id) {
                $tree[] = $value->staff_id;
            }
            if ($value->use_id) {
                $tree[] = $value->use_id;
            }
            if ($value->staff2_id) {
                $tree[] = $value->staff2_id;
            }
        }
        $tree[] = $this->use_id;
        return $tree;
    }

    public function getParentInfo() {
        $result = [
            'GH' => null,
            'CN' => null,
            'NVGH' => null,
            'NV' => null
        ];
        if ($this->parent_group == User::TYPE_AffiliateStoreUser) { //3
            $result['GH'] = $this->parent_name;
        } else if ($this->parent_group == User::TYPE_BranchUser) {  //14
            $result['CN'] = $this->parent_name;
            $pa_cn = $this->where('use_id', $this->parent_parent_id)->select('use_username', 'use_group', 'parent_id')->first();
            if (!empty($pa_cn)) {
                if ($pa_cn->use_group == User::TYPE_AffiliateStoreUser) {
                    $result['GH'] = $pa_cn->use_username;
                }
                else{
                    if ($pa_cn->use_group == User::TYPE_StaffStoreUser) {
                        $pa_nvgh = $this->where('use_id', $pa_cn->parent_id)->select('use_username', 'use_group', 'parent_id')->first();
                        $result['NVGH'] = $pa_cn->use_username;
                        $result['GH'] = $pa_nvgh->use_username;
                    }
                }
            }
        } else if ($this->parent_group == User::TYPE_StaffStoreUser) { //15
            $result['NVGH'] = $this->parent_name;
            $pa_cn = $this->where('use_id', $this->parent_parent_id)->select('use_username', 'use_group', 'parent_id')->first();
            $pa_nvgh = $this->where('use_id', $pa_cn->parent_id)->select('use_username', 'use_group', 'parent_id')->first();
            if (!empty($pa_cn) && $pa_cn->use_group == User::TYPE_AffiliateStoreUser) {
                $result['GH'] = $pa_cn->use_username;
            }
        } else if ($this->parent_group == User::TYPE_StaffUser) { //11
            $result['NV'] = $this->parent_name;
            $pa_nv = $this->where('use_id', $this->parent_parent_id)->select('use_username', 'use_group', 'parent_id')->first();
            if (!empty($pa_nv) && $pa_nv->use_group == User::TYPE_BranchUser) {
                $result['CN'] = $pa_nv->use_username;
                $pa_cn = $this->where('use_id', $pa_nv->parent_id)->select('use_username', 'use_group', 'parent_id')->first();
                if (!empty($pa_cn) && $pa_cn->use_group == 3) {
                    $result['GH'] = $pa_cn->use_username;
                }
            } elseif (!empty($pa_nv) && $pa_nv->use_group == 3) {
                $result['GH'] = $pa_nv->use_username;
            }
        }
        return $result;
    }
    public function getParentInfoV1(){
         $result = [
            'GH' => null,
            'CN' => null,
            'NVGH' => null,
            'NV' => null
        ];
        $parent = $this->parentInfo;
        if (!empty($parent)) {
            if (in_array($parent->use_group, [User::TYPE_AffiliateStoreUser, User::TYPE_BranchUser, User::TYPE_StaffStoreUser, User::TYPE_StaffUser])) {
                if ($parent->use_group == User::TYPE_AffiliateStoreUser) {
                    $result['GH'] = $parent->publicProfile();
                }
                if ($parent->use_group == User::TYPE_BranchUser) {
                    $result['CN'] = $parent->publicProfile();
                    $parent_branch = $parent->parentInfo;
                    if (!empty($parent_branch)) {
                        if ($parent_branch->use_group == User::TYPE_AffiliateStoreUser) {
                            $result['GH'] = $parent_branch->publicProfile();
                        } else if ($parent_branch->use_group == User::TYPE_StaffStoreUser) {
                            $parent_staff_store = $parent_branch->parentInfo;
                            $result['NVGH'] = $parent_branch->publicProfile();
                            if (!empty($parent_staff_store)) {
                                $result['GH'] = $parent_staff_store->publicProfile();
                            }
                        }
                    }
                }
                if ($parent->use_group == User::TYPE_StaffStoreUser) {
                    $result['NVGH'] = $parent->publicProfile();
                    $brand = $parent->parentInfo;
                    if (!empty($brand)) {
                        $result['GH'] = $brand->publicProfile();
                    }
                }
                if ($parent->use_group == User::TYPE_StaffUser) {
                    $result['NV'] = $parent->publicProfile();
                    $parent_nv = $parent->parentInfo;
                    if (!empty($parent_nv)) {
                        if ($parent_nv->use_group == User::TYPE_BranchUser) {
                            $result['CN'] = $parent_nv->publicProfile();
                            $parent_branch = $parent_nv->parentInfo;
                            if (!empty($parent_branch)) {
                                if ($parent_branch->use_group == User::TYPE_AffiliateStoreUser) {
                                    $result['GH'] = $parent_branch->publicProfile();
                                }
                            }
                        }
                        if ($parent_nv->use_group == User::TYPE_AffiliateStoreUser) {
                            $result['GH'] = $parent_nv->publicProfile();
                        }
                    }
                }
            }
        }
        return $result;
    }

    public function branchConfig(){
        return $this->hasOne('App\Models\BranchConfig','bran_id','use_id');
    }

    public function parentInfo() {
        return $this->hasOne('App\Models\User', 'use_id', 'parent_id');
    }

    public function parentActiveInfo() {
        return $this->hasOne('App\Models\User', 'use_id', 'parent_id')->where(['use_status'=>User::STATUS_ACTIVE]);
    }

    public function group(){
        return $this->hasOne('App\Models\Group','gro_id','use_group');
    }

    public function getShopInTree() {
        $parent = 0;
        $u_pa_1 = self::where('use_id', $this->parent_id)->select('use_id', 'use_group', 'parent_id')->first();
        if($u_pa_1 && $u_pa_1->use_group == 3){
            $parent = $u_pa_1->use_id;
        } elseif ($u_pa_1 && $u_pa_1->use_group == 14) {
            $u_pa_2 = self::where('use_id', $u_pa_1->parent_id)->select('use_id', 'use_group', 'parent_id')->first();
            if($u_pa_2 && $u_pa_2->use_group == 3){
                $parent = $u_pa_2->use_id;
            } else {
                $u_pa_3 = self::where('use_id', $u_pa_2->parent_id)->select('use_id', 'use_group', 'parent_id')->first();
                if($u_pa_3 && $u_pa_3->use_group == 3) {
                    $parent = $u_pa_3->use_id;
                }
            }
        } elseif ($u_pa_1 && $u_pa_1->use_group == 15) {
            $u_pa_2 = self::where('use_id', $u_pa_1->parent_id)->select('use_id', 'use_group', 'parent_id')->first();
            if($u_pa_2 && $u_pa_2->use_group == 3){
                $parent = $u_pa_2->use_id;
            }
        } elseif ($u_pa_1 && $u_pa_1->use_group == 11) {
            $u_pa_2 = self::where('use_id', $u_pa_1->parent_id)->select('use_id', 'use_group', 'parent_id')->first();
            if($u_pa_2 && $u_pa_2->use_group == 3){
                $parent = $u_pa_2->use_id;
            } elseif ($u_pa_2 && $u_pa_2->use_group == 14) {
                $u_pa_3 = self::where('use_id', $u_pa_2->parent_id)->select('use_id', 'use_group', 'parent_id')->first();
                if($u_pa_3 && $u_pa_3->use_group == 3) {
                    $parent = $u_pa_3->use_id;
                } else {
                    $u_pa_4 = self::where('use_id', $u_pa_3->parent_id)->select('use_id', 'use_group', 'parent_id')->first();
                    if($u_pa_4 && $u_pa_4->use_group == 3) {
                        $parent = $u_pa_4->use_id;
                    }
                }
            }
        }
        return $parent;
    }

    public function getShopNearest() {
        #Get user
        $id_my_parent = 0;
        if ($this->use_group === self::TYPE_AffiliateUser) {
            #Get my parent
            $get_p = self::where('use_id', $this->parent_id)->select('use_id', 'use_username', 'use_group', 'parent_id')->first();
            if ($get_p && ($get_p->use_group == 3 || $get_p->use_group == 14)) {
                $id_my_parent = $get_p->use_id;
            } elseif ($get_p && ($get_p->use_group == 11 || $get_p->use_group == 15)) {
                #Get parent of parent
                $get_p_p = self::where('use_id', $get_p->parent_id)->select('use_id', 'use_username', 'use_group', 'parent_id')->first();
                if ($get_p_p && ($get_p_p->use_group == 3 || $get_p_p->use_group == 14)) {
                    $id_my_parent = $get_p_p->use_id;
                }
            } else {
                $id_my_parent = $get_p->parent_id;
            }
        }
        return $id_my_parent;
    }


    public static function getListUsers($page, $pageSize, $params) {
        $userId = $params['userId'];
        $search = $params['search'];
        $typegroup = $params['typegroup'];
        $offset = ($page - 1) * $pageSize;
        $list = User::where("use_status","=", 1)
                ->where("use_id","<>", $userId)
                ->whereNotIn("use_group",User::ID_GROUPADMIN)
                ->where(function ($query) use ($search) {
                    if( $search != '') {
                        $query->where('use_username', 'like', '%'.$search.'%')
                                ->orWhere('use_fullname', 'like', '%'.$search.'%')
                                ->orWhere('use_username', 'like', '%'.$search.'%')
                                ->orWhere('use_email', 'like', '%'.$search.'%')
                                ->orWhere('use_mobile', 'like', '%'.$search.'%')
                                ->orWhere('use_phone', 'like', '%'.$search.'%');
                    }
                })
                ->where(function ($query) use ($typegroup) {
                    if( $typegroup != 0) {
                        $query->where('use_group', '=', $typegroup);

                    }
                })
                ->select("tbtt_user.avatar","tbtt_user.use_username","tbtt_user.use_fullname", "tbtt_user.use_id" )->orderby('tbtt_user.use_fullname', 'asc');
        return $list;


    }

    public static function getListUsersAlias($page, $pageSize, $params) {
        $userId = $params['userId'];
        $search = $params['search'];
        $typegroup = $params['typegroup'];
        $offset = ($page - 1) * $pageSize;
        $list = User::where("use_status","=", 1)
                ->leftJoin(DB::raw("(select * from chatuseralias where userId = $userId) as chatuseralias"), function($join) {
                         $join->on('tbtt_user.use_id', '=', 'chatuseralias.userId_alias');
                })
                ->leftJoin("chatfacephone", function($join) {
                         $join->on('tbtt_user.use_id', '=', 'chatfacephone.userId');
                })
                ->where("use_id","<>", $userId)
                ->whereNotIn("use_group",User::ID_GROUPADMIN)
                ->where(function ($query) use ($search) {
                    if( $search != '') {
                        $query->where('use_username', 'like', '%'.$search.'%')
                                ->orWhere('use_fullname', 'like', '%'.$search.'%')
                                ->orWhere('use_username', 'like', '%'.$search.'%')
                                ->orWhere('use_email', 'like', '%'.$search.'%')
                                ->orWhere('use_mobile', 'like', '%'.$search.'%')
                                ->orWhere('use_phone', 'like', '%'.$search.'%')
                                ->orWhere('chatuseralias.name_alias', 'like', '%'.$search.'%');
                    }
                })
                ->where(function ($query) use ($typegroup) {
                    if( $typegroup != 0) {
                        $query->where('use_group', '=', $typegroup);
                    }
                })
                ->select("tbtt_user.avatar","tbtt_user.use_username","chatfacephone.face_id","chatfacephone.face_name","chatfacephone.face_picture","chatfacephone.phone_name",DB::raw('(CASE WHEN chatuseralias.name_alias is null THEN tbtt_user.use_fullname ELSE chatuseralias.name_alias END) AS use_fullname'), "tbtt_user.use_id" )->orderby("use_fullname", 'asc');
        return $list;

    }


    public static function getListUsersFolow($page, $pageSize, $params) {
        $userId = $params['userId'];
        $search = $params['search'];
        $typegroup = $params['typegroup'];
        $offset = ($page - 1) * $pageSize;
        /*$list = User::join("tbtt_user_follow", "tbtt_user_follow.follower","=", "tbtt_user.use_id")
                ->where("use_status","=", 1)
                ->where("tbtt_user_follow.hasFollow","=", 1)
                ->where("tbtt_user_follow.user_id","=", $userId)
                ->where(function ($query) use ($search) {
                    if( $search != '') {
                        $query->where('use_username', 'like', '%'.$search.'%')
                                ->orWhere('use_fullname', 'like', '%'.$search.'%')
                                ->orWhere('use_mobile', 'like', '%'.$search.'%')
                                ->orWhere('use_username', 'like', '%'.$search.'%')
                                ->orWhere('use_email', 'like', '%'.$search.'%')
                                ->orWhere('use_phone', 'like', '%'.$search.'%');
                    }
                })
                ->select("tbtt_user.avatar","tbtt_user.use_username","tbtt_user.use_fullname", "tbtt_user.use_id" );*/

        $list = User::join("tbtt_user_follow", "tbtt_user_follow.user_id","=", "tbtt_user.use_id")
                ->leftJoin("chatfacephone", function($join) {
                         $join->on('tbtt_user.use_id', '=', 'chatfacephone.userId');
                })
                ->where("use_status","=", 1)
                ->whereNotIn("tbtt_user.use_id", User::ID_GROUPADMIN)
                ->where("tbtt_user_follow.hasFollow","=", 1)
                ->where("tbtt_user_follow.follower","=", $userId)
                ->where(function ($query) use ($search) {
                    if( $search != '') {
                        $query->where('use_username', 'like', '%'.$search.'%')
                                ->orWhere('use_fullname', 'like', '%'.$search.'%')
                                ->orWhere('use_mobile', 'like', '%'.$search.'%')
                                ->orWhere('use_username', 'like', '%'.$search.'%')
                                ->orWhere('use_email', 'like', '%'.$search.'%')
                                ->orWhere('use_phone', 'like', '%'.$search.'%');
                    }
                })
                ->where(function ($query) use ($typegroup) {
                    if( $typegroup != 0) {
                        $query->where('use_group', '=', $typegroup);

                    }
                })
                ->select("tbtt_user.avatar","tbtt_user.use_username","tbtt_user.use_fullname", "tbtt_user.use_id","chatfacephone.face_id","chatfacephone.face_name","chatfacephone.face_picture","chatfacephone.phone_name" )->orderby('tbtt_user.use_fullname', 'asc');
        return $list;


    }

    public static function getListUsersFolowAlias($page, $pageSize, $params) {
        $userId = $params['userId'];
        $search = $params['search'];
        $typegroup = $params['typegroup'];
        $offset = ($page - 1) * $pageSize;
        $list1 = DB::table("tbtt_user")->join("chatfacephone", "tbtt_user.use_id","=","chatfacephone.userId")
                    ->leftJoin(DB::raw("(select * from chatuseralias where userId = $userId) as chatuseralias"), function($join) {
                             $join->on('tbtt_user.use_id', '=', 'chatuseralias.userId_alias');
                    })
                    ->where(function ($query) use ($search) {
                        if( $search != '') {
                            $query->where('tbtt_user.use_username', 'like', '%'.$search.'%')
                                    ->orWhere('tbtt_user.use_fullname', 'like', '%'.$search.'%')
                                    ->orWhere('tbtt_user.use_mobile', 'like', '%'.$search.'%')
                                    ->orWhere('tbtt_user.use_username', 'like', '%'.$search.'%')
                                    ->orWhere('tbtt_user.use_email', 'like', '%'.$search.'%')
                                    ->orWhere('tbtt_user.use_phone', 'like', '%'.$search.'%')
                                    ->orWhere('name_alias', 'like', '%'.$search.'%')
                                    ;
                        }
                    })
                    ->where("tbtt_user.use_id", '<>', $userId)
                    ->select("tbtt_user.avatar","tbtt_user.use_username", "chatfacephone.face_id","chatfacephone.face_name","chatfacephone.face_picture","chatfacephone.phone_name",DB::raw('(CASE WHEN chatuseralias.name_alias is null THEN tbtt_user.use_fullname ELSE chatuseralias.name_alias END) AS use_fullname'), "tbtt_user.use_id", DB::raw('(CASE WHEN chatuseralias.name_alias is null THEN 1 ELSE 1 END) as sortfield') );

        $list = DB::table("tbtt_user")->join("tbtt_user_follow", function($join) {
                    //, "tbtt_user_follow.user_id","=", "tbtt_user.use_id"
                        $join->on('tbtt_user_follow.user_id', '=', 'tbtt_user.use_id')
                            ->orOn('tbtt_user_follow.follower', '=', 'tbtt_user.use_id');
                })
                ->leftJoin(DB::raw("(select * from chatuseralias where userId = $userId) as chatuseralias"), function($join) {
                         $join->on('tbtt_user.use_id', '=', 'chatuseralias.userId_alias');
                })
                ->leftJoin("chatfacephone", function($join) {
                         $join->on('tbtt_user.use_id', '=', 'chatfacephone.userId');
                })
                ->where("use_status","=", 1)
                ->whereNotIn("tbtt_user.use_id", User::ID_GROUPADMIN)
                ->where("tbtt_user_follow.hasFollow","=", 1)
                //->where("tbtt_user_follow.follower","=", $userId)
                ->where(function ($query) use ($userId) {
                     $query->where('tbtt_user_follow.follower', '=', $userId )
                                ->orWhere('tbtt_user_follow.user_id', '=', $userId);
                })
                ->where(function ($query) use ($search) {
                    if( $search != '') {
                        $query->where('use_username', 'like', '%'.$search.'%')
                                ->orWhere('use_fullname', 'like', '%'.$search.'%')
                                ->orWhere('use_mobile', 'like', '%'.$search.'%')
                                ->orWhere('use_username', 'like', '%'.$search.'%')
                                ->orWhere('use_email', 'like', '%'.$search.'%')
                                ->orWhere('use_phone', 'like', '%'.$search.'%')
                                ->orWhere('name_alias', 'like', '%'.$search.'%')
                                ;
                    }
                })
                ->where(function ($query) use ($typegroup) {
                    if( $typegroup != 0) {
                        $query->where('use_group', '=', $typegroup);
                    }
                })
                ->where("tbtt_user.use_id", '<>', $userId)
                ->select("tbtt_user.avatar","tbtt_user.use_username", "chatfacephone.face_id","chatfacephone.face_name","chatfacephone.face_picture","chatfacephone.phone_name",DB::raw('(CASE WHEN chatuseralias.name_alias is null THEN tbtt_user.use_fullname ELSE chatuseralias.name_alias END) AS use_fullname'), "tbtt_user.use_id",DB::raw('(CASE WHEN chatuseralias.name_alias is null THEN 0 ELSE 0 END) as sortfield') )
                ->orderby('sortfield', 'desc')
                ->union($list1);
        $querySql = $list->toSql();
        $query = DB::table(DB::raw("($querySql) as a"))->mergeBindings($list)->groupBy('use_id');
        return $query;

    }

}
