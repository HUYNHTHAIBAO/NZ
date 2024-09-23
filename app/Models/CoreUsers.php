<?php

namespace App\Models;

use App\Utils\File;
use App\Utils\Links;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;

class CoreUsers extends Authenticatable implements JWTSubject
{
    use Notifiable;
    use HasRoles;
    const STATUS_UNREGISTERED = 0;
    const STATUS_REGISTERED = 1;
    const STATUS_CONFIRMED = 2;
    const STATUS_BANNED = 3;
    const GENDER_MALE = 1;
    const GENDER_FEMALE = 2;
    const ACCOUNT_POSITION_ADMIN = 1,
        ACCOUNT_POSITION_SECRETARY = 2,
        ACCOUNT_POSITION_SECRETARY_OUT = 3,
        ACCOUNT_POSITION_SALE = 4,
        ACCOUNT_POSITION_SALE_COLLABORATOR = 5;
    const ACCOUNT_POSITION = [
        ['id' => self::ACCOUNT_POSITION_ADMIN, 'name' => 'Admin'],
        //        ['id' => self::ACCOUNT_POSITION_SECRETARY, 'name' => 'Thư ký'],
        //        ['id' => self::ACCOUNT_POSITION_SECRETARY_OUT, 'name' => 'Thư ký admin'],
        //        ['id' => self::ACCOUNT_POSITION_SALE, 'name' => 'Sale'],
        //        ['id' => self::ACCOUNT_POSITION_SALE_COLLABORATOR, 'name' => 'CTV Sale'],
    ];


    const ACCOUNT_TYPE_NEW = 0,
          ACCOUNT_TYPE_EXPERT_PENDING = 1,
          ACCOUNT_TYPE_EXPERT = 1;



    public static $account_type = [
        0 => 'Người dùng',
        1 => 'Đang chờ duyệt lên chuyên gia',
        2 => 'Chuyên gia',

    ];

    public static $status_inactive = 0;
    public static $status_active = 1;
    public static $status_banned = 3;
    protected $guard_name = 'backend';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = 'lck_core_users';
    protected $fillable = [
        'company_id',
        'fullname',
        'email',
        'phone',
        'password',
        'status',
        'fcm_token',
        'device_id',
        'device_os',
        'recommender',
        'gender',
        'birthday',
        'cardid',
        'avatar_file_id',
        'avatar_file_path',
        'rating',
        'balance',
        'point',
        'address',
        'facebook_id',
        'google_id',
        'account_position',
        'account_type',
        'last_login',
        'o_lat',
        'o_long',
        'discount_code',
        'recommender',
        'id_branchs',
        'bio',
        'job',
        'advise',
        'questions',
        'facebook_link',
        'x_link',
        'instagram_link',
        'tiktok_link',
        'linkedin_link',
        'approved',
        'category_id_expert',
        'reason_for_refusal',
        'priority',
        'show',
        'avatar_name',
        'type_switch_account',
        'tags_id',
        'token_api',
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'company_id',
    ];
    protected $appends = array('avatar_src');

    protected static function boot()
    {
        // sets default values on saving
        static::saving(function ($element) {
            $element->company_id = $element->company_id ?? config('constants.company_id');
        });
        parent::boot();
    }

    public function getAvatarSrcAttribute()
    {
        return Links::ImageLink($this->avatar_file_path );
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function get_by_where($params)
    {
        $params = array_merge(array(
            'fullname'         => null,
            'email'            => null,
            'phone'            => null,
            'status'           => null,
            'account_position' => null,
            'is_staff'         => false,
            'pagin_path'       => null,
        ), $params);

        \DB::enableQueryLog();


//        $data = $this->orderBy('priority', 'asc');
        $data = $this->orderByRaw("CASE WHEN priority IS NULL THEN 1 ELSE 0 END, priority ASC");


        if (!empty($params['fullname'])) {
            $data->where('fullname', 'like', "%{$params['fullname']}%");
        }
        if (!empty($params['email'])) {
            $data->where('email', 'like', "%{$params['email']}%");
        }
        if ($params['status'] !== null) {
            $data->where('status', $params['status']);
        }
        if ($params['account_position']) {
            $data->where('account_position', $params['account_position']);
        }

        if (isset($params['account_type']) && is_array($params['account_type'])) {
            $data->whereIn('account_type', $params['account_type']);
        } elseif (isset($params['account_type'])) {
            $data->where('account_type', $params['account_type']);
        }


        if ($params['phone']) {
            $data->where('phone', 'like', "%{$params['phone']}%");
        }
        if ($params['is_staff']) {
            $data->whereNotNull('account_position');
            $data->where('account_position', '<>', 0);
        } else {
            $data->where('account_position', 0);
        }

        $data = $data->paginate(config('constants.item_perpage'))->withPath($params['pagin_path']);

        return $data;
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'id_branchs', 'id');
    }

    public function expertProfile()
    {
        return $this->hasOne(ExpertProfiles::class, 'user_id', 'id');
    }
    public function applications()
    {
        return $this->hasMany(ExpertApplications::class);
    }

    public function duration()
    {
        return $this->hasMany(TimeRatesDuration::class, 'user_id', 'id');
    }
    public function times()
    {
        return $this->hasMany(TimeDurations::class, 'user_id', 'id');
    }
    public function categoryExpert()
    {
        return $this->hasMany(ExpertCategory::class, 'id', 'category_id_expert');
    }

    public function timeRateDuration() {
        return $this->belongsTo(TimeRatesDuration::class);
    }
    public function walletExpert()
    {
        return $this->belongsTo(WalletExpert::class, 'user_expert_id', 'id');
    }

    public function postExpert()
    {
        return $this->belongsTo(PostExpert::class, 'user_id', 'id');
    }
// CoreUsers.php

    public function tags()
    {
        return $this->belongsToMany(ExpertCategoryTags::class, 'lck_expert_category_tags_pivot', 'expert_category_id', 'tags_id');
    }

// Trong model CoreUsers
    public function rates()
    {
        return $this->hasMany(TimeDurations::class, 'user_id');
    }

}
