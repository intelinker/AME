<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    //    protected $table = "diaries";

    protected $fillable = [
//        'title', 'description', 'content', 'avatar', 'created_by', 'updated_by',
    ];

    public function profile() {
        return $this->belongsTo('App\Profile', 'language_id');
    }

    public function article() {
        return $this->belongsTo('App\Article');
    }
}
