<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function articles() {
        return $this -> hasMany('App\Article');
    }

    public function comments() {
        return $this -> hasMany('App\Comment');
    }

    public function accountType() {
        return $this -> hasOne('App\AccountType', 'account_type');
    }

    public function status() {
        return $this -> hasOne('App\UserStatus', 'status');
    }

    public function profile() {
        return $this -> hasOne('App\Profile');
    }

    public function belongUser() {
        return $this -> belongsTo('App\Profile', 'related_account_id');
    }

    public function relation() {
        return $this -> hasMany('App\UserRelation');
    }

    public function related() {
        return $this -> belongsTo('App\UserRelation');
    }

    public function setup() {
        return $this -> hasOne('App\Setup');
    }

    public function favoriteArticles() {
        return $this->hasMany('App\FavoriteArticle');
    }

    public function favoriteDocuments() {
        return $this->hasMany('App\FavoriteDocument');
    }

}
