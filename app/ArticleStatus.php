<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ArticleStatus extends Model
{
    //    protected $table = "diaries";

    protected $fillable = [
//        'title', 'description', 'content', 'avatar', 'created_by', 'updated_by',
    ];

    public function article() {
        return $this->belongsTo('App\Article');
    }

    public function comment() {
        return $this->belongsTo('App\Comment');
    }
}
