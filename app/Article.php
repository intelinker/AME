<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    //    protected $table = "diaries";

    protected $fillable = [
//        'title', 'description', 'content', 'avatar', 'created_by', 'updated_by',
    ];

    public function user() {
        return $this->belongsTo('App\User', 'created_by');
    }

    public function comments() {
        return $this->hasMany('App\Comment');
    }

    public function language() {
        return $this->hasOne('App\Language', 'language_id');
    }

    public function status() {
        return $this->hasOne('App\ArticleStatus', 'status');
    }

    public function favorited() {
        return $this->belongsTo('App\FavoriteArticles');
    }
}
