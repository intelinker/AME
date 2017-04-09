<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FavoriteDoc extends Model
{
    protected $fillable = [
//        'title', 'description', 'content', 'avatar', 'created_by', 'updated_by',
    ];

    public function user() {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function document() {
        return $this->hasOne('App\Document', 'doc_id');
    }
}
