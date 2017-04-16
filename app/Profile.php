<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
        protected $table = "user_profile";

    protected $fillable = [
//        'title', 'description', 'content', 'avatar', 'created_by', 'updated_by',
    ];

    public function user() {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function country() {
        return $this->hasOne('App\Country', 'country_id');
    }

//    public function airport() {
//        return $this->hasOne('App\Airport', 'airport_id');
//    }

    public function language() {
        return $this->belongsTo('App\Language', 'language_id');
    }

    public function relatedUser() {
        return $this->hasMany('App\User');
    }

    public function title() {
        return $this->belongsTo('App\UserTitle', 'title');
    }

    public function position() {
        return $this->belongsTo('App\UserPosition', 'position');
    }

    public function relation() {
        return $this->hasMany('App\UserRelation');
    }
}
