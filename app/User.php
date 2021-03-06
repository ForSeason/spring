<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'user';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'account', 'nickname', 'sex', 'password', 'url_head_pic', 'age', 'phone',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        // 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function members() {
        return $this->hasMany('App\Member');
    }

    public function sayings() {
        return $this->hasMany('App\Saying');
    }

    protected static function boot() {
        parent::boot();

        static::deleting(function($user) {
            $user->members()->delete();
            $user->sayings()->delete();
        });
    }
}
