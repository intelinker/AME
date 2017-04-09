<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserRelation extends Model
{
    protected $fillable = [
//        'title', 'description', 'content', 'avatar', 'created_by', 'updated_by',
    ];

    public function user() {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function relation() {
        return $this->hasMany('App\User', 'relation_id');
    }
}
