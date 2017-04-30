<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserRelation extends Model
{
    protected $fillable = [
        'user_id', 'relation_id', 'relation_type', 'review_articles', 'articles_reviewed', 'notify_activities',
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
