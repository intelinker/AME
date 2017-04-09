<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FavoriteArticle extends Model
{
    protected $fillable = [
//        'title', 'description', 'content', 'avatar', 'created_by', 'updated_by',
    ];

    public function user() {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function article() {
        return $this->hasOne('App\Article', 'article_id');
    }
}
