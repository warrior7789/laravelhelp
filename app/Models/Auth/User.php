<?php

namespace App\Models\Auth;

use App\Models\Traits\Uuid;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use App\Models\Auth\Traits\Scope\UserScope;
use App\Models\Auth\Traits\Method\UserMethod;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Auth\Traits\SendUserPasswordReset;
use App\Models\Auth\Traits\Attribute\UserAttribute;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Auth\Traits\Relationship\UserRelationship;

use Cache;
/**
 * Class User.
 */
class User extends Authenticatable
{
    use HasRoles,
        Notifiable,
        SendUserPasswordReset,
        SoftDeletes,
        UserAttribute,
        UserMethod,
        UserRelationship,
        UserScope,
        Uuid;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'avatar_type',
        'avatar_location',
        'password',
        'password_changed_at',
        'active',
        'confirmation_code',
        'confirmed',
        'timezone',
        'last_login_at',
        'last_login_ip',
        'is_sp',
        'slug',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * @var array
     */
    protected $dates = ['last_login_at', 'deleted_at'];

    /**
     * The dynamic attributes from mutators that should be returned with the user object.
     * @var array
     */
    protected $appends = ['full_name'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'active' => 'boolean',
        'confirmed' => 'boolean',
    ];

    public static function GetAll() {
        $users = static::where('active', 1)->where('is_sp', 1)->get();
        $selection = array();
        $selection[""]=__('strings.new.select_user');
        foreach ($users as $key => $value) {
            $selection[$value->id]=$value->first_name.' '.$value->last_name;            
        }        
        return $selection;
    }

    public function Profile(){
        return $this->hasOne('App\Models\Profile');
    }


    public function isOnline(){
        return Cache::has('user-is-online-'.$this->id);
    }

    public function Spskill()
    {
        return $this->hasMany('App\Models\Spskill');
    }

    public function SocialAccount()
    {
        return $this->hasMany('App\Models\Auth\SocialAccount');
    }

    public function Spavailability()
    {
        return $this->hasMany('App\Models\Spavailability');
    }
    
    public function Photogallary()
    {
        return $this->hasMany('App\Models\Photogallary');
    }

    public function messages()
    {
        return $this->hasMany('App\Models\Message');
    }

    public function conversationUserOne()
    {
        return $this->hasMany('App\Models\Conversation', 'user_one');
    }

    public function conversationUserTwo()
    {
        return $this->hasMany('App\Models\Conversation', 'user_two');
    }


    public function fromUserRating()
    {
        return $this->hasMany('App\Models\Feedback', 'from_userid');
    }

    public function toUserRating()
    {
        return $this->hasMany('App\Models\Feedback', 'to_userid');
    }


    public function mainuserofFavourite()
    {
        return $this->hasMany('App\Models\FavSp', 'user_id');
    }

    public function favouriteUser()
    {
        return $this->hasMany('App\Models\FavSp', 'fav_user_id');
    }
   
}
