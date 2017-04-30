<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserRelation extends Model
{
    protected $fillable = [
//        'title', 'description', 'content', 'avatar', 'created_by', 'updated_by',
    ];

    public function user() {
        return $this->belongsToMany('App\User', 'user_id');
    }

    public function relation() {
        return $this->hasMany('App\User', 'relation_id');
    }

    public function type() {
        return $this->hasOne('App\RelationType', 'relation_type');
    }
}
