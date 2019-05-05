<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $table = 'room';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'creator',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
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

    public function chats() {
        return $this->hasMany('App\Chat');
    }

    public function members() {
        return $this->hasMay('App\Member');
    }

    protected static function boot() {
        parent::boot();

        static::deleting(function($user) {
            $user->members()->delete();
            $user->chats()->delete();
        });
    }
    //
}
