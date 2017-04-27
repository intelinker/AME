<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserTitle extends Model
{
    protected $fillable = [
//        'article_id', 'status', 'content', 'created_by', 'updated_by',
    ];

    public function profile() {
        return $this->hasMany('App\Profile', 'title');
    }
}
