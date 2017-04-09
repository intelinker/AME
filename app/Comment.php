<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'article_id', 'status', 'content', 'created_by', 'updated_by',
    ];

    public function user() {
        return $this->belongsTo('App\User', 'created_by');
    }

    public function article() {
        return $this->belongsTo('App\Article', 'article_id');
    }

    public function status() {
        return $this->hasOne('App\ArticleStatus', 'status');
    }
}
